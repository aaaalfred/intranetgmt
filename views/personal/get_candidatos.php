<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if(isset($_SESSION['login_gmt'])) {
    include("../../actions/conexion.php");

    function quitar_acentos($cadena) {
        $cadena = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $cadena);
        return $cadena;
    }

    // Obtener el tipo de usuario
    $query_tipo = "SELECT tipo FROM credenciales WHERE id = ?";
    $stmt_tipo = $con->prepare($query_tipo);
    $stmt_tipo->bind_param("i", $_SESSION['id_gmt']);
    $stmt_tipo->execute();
    $result_tipo = $stmt_tipo->get_result();
    if($result_tipo->num_rows == 0) {
        echo json_encode(['error' => 'Usuario no encontrado']);
        exit;
    }
    $tipo_usuario = $result_tipo->fetch_assoc()['tipo'];

    // Construir la consulta base
    $query = "SELECT u.id, u.nombre, u.app, u.apm, u.telefono, u.curp, c.cliente, c.proyecto, c.perfil 
              FROM usuarios u 
              JOIN cuentas c ON c.clave = u.clave_ejecutivo 
              WHERE u.autorizado IS NULL";
    $params = [];
    $types = '';

    // Filtro según tipo de usuario
    if ($tipo_usuario == 'GROUPER') {
        $query .= " AND c.idGrouper = ?";
        $params[] = $_SESSION['id_gmt'];
        $types .= 'i';
    } elseif ($tipo_usuario == 'EJECUTIVO') {
        $query .= " AND c.idEjecutivo = ?";
        $params[] = $_SESSION['id_gmt'];
        $types .= 'i';
    } else {
        echo json_encode(['error' => 'Tipo de usuario no reconocido']);
        exit;
    }

    // Aplicar filtros si se han enviado
    if(!empty($_POST['date1']) && !empty($_POST['date2'])) {
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
        $query .= " AND u.fechaAlta BETWEEN ? AND DATE_ADD(?, INTERVAL 1 DAY)";
        $params[] = $date1;
        $params[] = $date2;
        $types .= 'ss';
    }

    if(!empty($_POST['codsel'])) {
        $claves = $_POST['codsel'];
        // Preparar placeholders
        $placeholders = implode(',', array_fill(0, count($claves), '?'));
        $query .= " AND c.cliente IN ($placeholders)";
        foreach ($claves as $clave) {
            $params[] = $clave;
            $types .= 's';
        }
    }

    $query .= " ORDER BY u.fechaAlta DESC";

    $stmt = $con->prepare($query);
    if($stmt === false) {
        echo json_encode(['error' => 'Error en la preparación de la consulta: ' . $con->error]);
        exit;
    }

    if($params) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        echo json_encode(['error' => 'Error en la ejecución de la consulta: ' . $stmt->error]);
        exit;
    }

    $candidatos = [];

    while ($row = $result->fetch_assoc()) {
        $nombreCompleto = $row['nombre'] . ' ' . $row['app'] . ' ' . $row['apm'];
        $nombreSinAcentos = strtoupper(quitar_acentos($nombreCompleto));

        $candidato = [
            'id' => $row['id'],
            'nombre' => $nombreSinAcentos,
            'telefono' => $row['telefono'],
            'curp' => $row['curp'],
            'cliente' => $row['cliente'],
            'proyecto' => $row['proyecto'],
            'perfil' => $row['perfil']
        ];
        $candidatos[] = $candidato;
    }

    echo json_encode($candidatos);
} else {
    echo json_encode(['error' => 'No autorizado']);
}

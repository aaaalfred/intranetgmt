<?php
session_start();
include("../../actions/conexion.php");

if(isset($_SESSION['login_gmt'])) {
    // Preparar la consulta principal con un JOIN
    $sql = "SELECT u.id, u.nombre, u.app, u.apm, u.telefono, u.curp, u.fechaAlta, u.clave_ejecutivo, 
                   c.cliente, c.perfil 
            FROM usuarios u
            LEFT JOIN codigos_clientes c ON SUBSTRING(u.clave_ejecutivo, 1, 3) = c.codigo
            WHERE u.autorizado = 1 AND u.autorizado_dos IS NULL";

    $params = [];
    $types = '';

    // Filtrar por claves seleccionadas
    if(!empty($_POST['codsel'])) {
        $claves = $_POST['codsel'];
        $placeholders = implode(',', array_fill(0, count($claves), '?'));
        $sql .= " AND u.clave_ejecutivo IN ($placeholders)";
        $params = array_merge($params, $claves);
        $types .= str_repeat('s', count($claves));
    } else {
        // Filtrar por las claves del usuario si no se seleccionaron claves específicas
        $porciones = explode(",", $_SESSION["clave_gmt"]);
        if (!empty($porciones)) {
            $placeholders = implode(',', array_fill(0, count($porciones), '?'));
            $sql .= " AND (";
            foreach ($porciones as $i => $porcion) {
                $sql .= $i > 0 ? " OR " : "";
                $sql .= "u.clave_ejecutivo LIKE CONCAT('%', ?, '%')";
                $params[] = $porcion;
                $types .= 's';
            }
            $sql .= ")";
        }
    }

    $sql .= " ORDER BY u.fechaAlta DESC";

    // Preparar y ejecutar la consulta
    $stmt = $con->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['error' => 'Error en la preparación de la consulta: ' . $con->error]);
        exit;
    }

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    if (!$stmt->execute()) {
        echo json_encode(['error' => 'Error en la ejecución de la consulta: ' . $stmt->error]);
        exit;
    }

    $result = $stmt->get_result();
    $preaprobados = [];

    while ($row = $result->fetch_assoc()) {
        $preaprobados[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre'] . ' ' . $row['app'] . ' ' . $row['apm'],
            'telefono' => $row['telefono'],
            'curp' => $row['curp'],
            'fechaAlta' => $row['fechaAlta'],
            'clave_ejecutivo' => $row['clave_ejecutivo'],
            'cliente' => $row['cliente'] ?? 'N/A',
            'perfil' => $row['perfil'] ?? 'N/A'
        ];
    }

    echo json_encode($preaprobados);
} else {
    echo json_encode(['error' => 'No autorizado']);
}
?>
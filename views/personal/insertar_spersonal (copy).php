<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
    include ("../../actions/conexion.php");

    // Función para enviar notificación a Slack
    function sendSlackNotification($message) {
        $webhook_url = "https://hooks.slack.com/services/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";
        $ch = curl_init($webhook_url);
        $data = json_encode([
            "text" => $message
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    // Función para obtener el valor del POST o un valor por defecto si no existe
    function getPostValue($key, $default = '') {
        return isset($_POST[$key]) ? mysqli_real_escape_string($GLOBALS['con'], $_POST[$key]) : $default;
    }

    // Obtener los datos del formulario
    $folio = uniqid('REQ-');
    $usuario = $_SESSION['nombre_gmt'] ?? 'Usuario Desconocido';
    $cliente = getPostValue('cliente');
    $promocion = getPostValue('promocion');
    $nocasting = intval($_POST['npersonal_casting'] ?? 0);
    $noreal = intval($_POST['npersonal_requerido'] ?? 0);
    $puesto = getPostValue('puesto');
    $descpuesto = getPostValue('descripcion');
    $escolaridad = getPostValue('escolaridad');
    $nodias = intval($_POST['tdias'] ?? 0);
    $dias = getPostValue('dias');
    $horarios = getPostValue('horarios');
    $perfil = getPostValue('perfil');
    $edad = getPostValue('edad');
    $sexo = getPostValue('sexo');
    $zonas = getPostValue('zonas');
    $tiendas = getPostValue('tiendas');
    $experiencia = getPostValue('experiencia');
    $fechacasting = getPostValue('f_entrevista');
    $fyhcasting = getPostValue('h_entrevista');
    $lugarcasting = getPostValue('l_entrevista');
    $fingreso = getPostValue('f_ingreso');
    $fsalida = getPostValue('terminoplan');
    $requerimientos = getPostValue('requerimientos');
    $movil = getPostValue('exp_movil');
    $coment = getPostValue('comentarios');
    $bono = getPostValue('bono');
    $coordinacion = getPostValue('coordinacion');
    $sueldo = floatval($_POST['sueldo'] ?? 0);
    $tdias = $nodias;

    // Crear la consulta SQL usando una declaración preparada
    $sql = "INSERT INTO reqpersonal (folio, usuario, cliente, promocion, nocasting, noreal, puesto, descpuesto, escolaridad, nodias, dias, horarios, perfil, edad, sexo, zonas, tiendas, experiencia, fechacasting, fyhcasting, lugarcasting, fingreso, fsalida, requerimientos, movil, coment, bono, coordinacion, sueldo, tdias) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la declaración
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
    // Crear una cadena de tipos dinámica (ahora con un parámetro menos)
    $types = str_repeat('s', 30);
    $types[4] = $types[5] = $types[9] = $types[29] = 'i';
    $types[28] = 'd';

        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, $types, 
            $folio, $usuario, $cliente, $promocion, $nocasting, $noreal, $puesto, $descpuesto, $escolaridad, 
            $nodias, $dias, $horarios, $perfil, $edad, $sexo, $zonas, $tiendas, $experiencia, 
            $fechacasting, $fyhcasting, $lugarcasting, $fingreso, $fsalida, $requerimientos, $movil, $coment, 
            $bono, $coordinacion, $sueldo, $tdias);

        // Ejecutar la declaración
        if (mysqli_stmt_execute($stmt)) {
            // Prepara el mensaje para Slack
            $slackMessage = "Nueva solicitud de personal:\n" .
                            "Folio: $folio\n" .
                            "Cliente: $cliente\n" .
                            "Promoción: $promocion\n" .
                            "Puesto: $puesto\n" .
                            "Fecha de ingreso: $fingreso";
            
            // Envía la notificación a Slack
            sendSlackNotification($slackMessage);

            echo "<script>alert('Solicitud de personal insertada correctamente'); window.location.href='solicitud_personal.php';</script>";
        } else {
            echo "<script>alert('Error al insertar la solicitud de personal: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error en la preparación de la consulta: " . mysqli_error($con) . "'); window.history.back();</script>";
    }

    mysqli_close($con);
} else {
    header("Location: ../../login.php");
    exit();
}
?>
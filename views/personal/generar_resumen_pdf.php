<?php
require_once '../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Incluir el archivo de conexión a la base de datos
include("../../actions/conexion.php");

function obtenerDatosUsuario($con, $id) {
    $query = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id'");
    return mysqli_fetch_assoc($query);
}

if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];
    $usuario = obtenerDatosUsuario($con, $id_usuario);

    if ($usuario) {
        // Crear el contenido HTML para el PDF
        $html = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .header { text-align: center; margin-bottom: 20px; }
                .profile-image { width: 150px; height: auto; margin: 0 auto; display: block; }
                .info { margin-bottom: 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Resumen del Perfil</h1>
                <img src="' . $usuario['foto_perfil'] . '" class="profile-image">
            </div>
            <div class="info">
                <p><strong>Nombre:</strong> ' . $usuario['nombre'] . ' ' . $usuario['app'] . ' ' . $usuario['apm'] . '</p>
                <p><strong>CURP:</strong> ' . $usuario['curp'] . '</p>
                <p><strong>RFC:</strong> ' . $usuario['rfc'] . '</p>
                <p><strong>NSS:</strong> ' . $usuario['nss'] . '</p>
                <p><strong>Fecha de Nacimiento:</strong> ' . $usuario['fecha_nacimiento'] . '</p>
                <p><strong>Correo:</strong> ' . $usuario['correo'] . '</p>
            </div>
        </body>
        </html>';

        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        // Crear instancia de Dompdf
        $dompdf = new Dompdf($options);

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderizar PDF
        $dompdf->render();

        // Generar nombre de archivo
        $filename = 'resumen_perfil_' . $usuario['curp'] . '.pdf';

        // Enviar PDF al navegador
        $dompdf->stream($filename, array("Attachment" => true));
        exit(0);
    } else {
        echo "Usuario no encontrado.";
    }
} else {
    echo "ID de usuario no proporcionado.";
}
<?php

// Asegurar que el directorio de contratos generados existe
$directorio_contratos = __DIR__ . '/contratos_generados';
if (!file_exists($directorio_contratos)) {
    mkdir($directorio_contratos, 0755, true);
}
// Incluir el archivo de conexión existente
include("../../../actions/conexion.php");

// Incluir Composer autoload
require '../../../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Dompdf\Dompdf;
use Dompdf\Options;

function obtenerDatosTrabajador($con, $id_trabajador) {
    $id_trabajador = mysqli_real_escape_string($con, $id_trabajador);
    $sql = "SELECT curp, rfc, regimen_fiscal, cp, nss, nombre, app, apm, sexo, telefono, fecha_nacimiento 
        FROM usuarios 
        WHERE id = '$id_trabajador'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return false;
}

// Configurar Twig
$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/cache/twig',
    'auto_reload' => true,
]);

// Configurar opciones de Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isRemoteEnabled', true);


// Verificar si se han enviado IDs de usuarios
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_users'])) {
    $selected_users = $_POST['selected_users'];
    $contratos_generados = [];
    $errores = [];

    foreach ($selected_users as $id_trabajador) {
        // Crear una nueva instancia de Dompdf para cada contrato
        $dompdf = new Dompdf($options);

        $trabajador = obtenerDatosTrabajador($con, $id_trabajador);
        if (!$trabajador) {
            $errores[] = "No se encontró el trabajador con ID: $id_trabajador";
            continue;
        }

        // Preparar los datos para la plantilla
        $datos = [
            'nombre' => htmlspecialchars($trabajador['nombre'], ENT_QUOTES, 'UTF-8'),
            'app' => htmlspecialchars($trabajador['app'], ENT_QUOTES, 'UTF-8'),
            'apm' => htmlspecialchars($trabajador['apm'], ENT_QUOTES, 'UTF-8'),
            'nss' => htmlspecialchars($trabajador['nss'], ENT_QUOTES, 'UTF-8'),
            'curp' => htmlspecialchars($trabajador['curp'], ENT_QUOTES, 'UTF-8'),
            'rfc' => htmlspecialchars($trabajador['rfc'], ENT_QUOTES, 'UTF-8'),
            'regimen_fiscal' => htmlspecialchars($trabajador['regimen_fiscal'], ENT_QUOTES, 'UTF-8'),
            'cp' => htmlspecialchars($trabajador['cp'], ENT_QUOTES, 'UTF-8'),
            'sexo' => htmlspecialchars($trabajador['sexo'], ENT_QUOTES, 'UTF-8'),
            'telefono' => htmlspecialchars($trabajador['telefono'], ENT_QUOTES, 'UTF-8'),
            'fecha_nacimiento' => htmlspecialchars($trabajador['fecha_nacimiento'], ENT_QUOTES, 'UTF-8'),



        ];

        // Renderizar la plantilla con Twig
        $html = $twig->render('contrato.html.twig', $datos);

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);

        // Configurar el tamaño y la orientación del papel
        $dompdf->setPaper('legal', 'portrait');

        // Renderizar el HTML como PDF
        $dompdf->render();

        // Definir la ruta del PDF
        $nombre_pdf = 'Contrato_' . preg_replace('/\s+/', '_', $trabajador['curp']) . '.pdf';
        $ruta_pdf = __DIR__ . '/contratos_generados/' . $nombre_pdf;

        // Guardar el PDF

        file_put_contents($ruta_pdf, $dompdf->output());
        error_log("PDF generado: $ruta_pdf");

        // Actualizar el estado del contrato en la base de datos
        $query = "UPDATE usuarios SET autorizado_dos = 1 WHERE id = '$id_trabajador'";
        if (mysqli_query($con, $query)) {
            $contratos_generados[] = $nombre_pdf;
        } else {
            $errores[] = "Error al actualizar el estado del contrato para el trabajador con ID: $id_trabajador";
        }
    }

    // Preparar mensaje de resultado
    $mensaje = "";
    if (!empty($contratos_generados)) {
        $mensaje .= "Contratos generados: " . implode(", ", $contratos_generados) . "<br>";
    }
    if (!empty($errores)) {
        $mensaje .= "Errores: " . implode(", ", $errores);
    }

    // Redirigir de vuelta a la página de generar con el mensaje
    header("Location: generar.php?mensaje=" . urlencode($mensaje));
    exit();
} else {
    // Si no se seleccionaron usuarios, redirigir de vuelta con un mensaje de error
    header("Location: generar.php?error=" . urlencode("No se seleccionaron usuarios para generar contratos."));
    exit();
}
?>
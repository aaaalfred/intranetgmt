<?php
// views/personal/contratos/generar_contrato.php

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
    $sql = "SELECT nombre, nss, curp FROM usuarios WHERE id = '$id_trabajador'";
    $result = mysqli_query($con, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return false;
}

// Obtener ID del trabajador de la solicitud
$id_trabajador = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_trabajador > 0) {
    $trabajador = obtenerDatosTrabajador($con, $id_trabajador);
    if (!$trabajador) {
        die('Trabajador no encontrado.');
    }
} else {
    die('ID de trabajador inválido.');
}

// Configurar Twig
$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/cache/twig',
    'auto_reload' => true,
]);

// Preparar los datos para la plantilla
$datos = [
    'nombre' => htmlspecialchars($trabajador['nombre'], ENT_QUOTES, 'UTF-8'),
    'nss' => htmlspecialchars($trabajador['nss'], ENT_QUOTES, 'UTF-8'),
    'curp' => htmlspecialchars($trabajador['curp'], ENT_QUOTES, 'UTF-8'),
];

// Renderizar la plantilla con Twig
$html = $twig->render('contrato.html.twig', $datos);

// Configurar opciones de Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isRemoteEnabled', true); // Permitir recursos remotos como imágenes

$dompdf = new Dompdf($options);

// Cargar el HTML en Dompdf
$dompdf->loadHtml($html);

// Configurar el tamaño y la orientación del papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar el HTML como PDF
$dompdf->render();

// Definir la ruta del PDF en caché
$nombre_pdf = 'Contrato_' . preg_replace('/\s+/', '_', $trabajador['nombre']) . '.pdf';
$cachePath = __DIR__ . '/cache/pdfs/' . $nombre_pdf;

// Asegurarse de que el directorio de caché existe
if (!file_exists(__DIR__ . '/cache/pdfs')) {
    mkdir(__DIR__ . '/cache/pdfs', 0777, true);
}

// Guardar el PDF en el caché
file_put_contents($cachePath, $dompdf->output());

// Servir el PDF para descarga
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $nombre_pdf . '"');
header('Cache-Control: max-age=0');

readfile($cachePath);
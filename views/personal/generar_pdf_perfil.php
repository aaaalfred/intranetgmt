<?php
require_once '../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_POST['imgData'])) {
    $imgData = $_POST['imgData'];

    // Configurar opciones de Dompdf
    $options = new Options();
    $options->set('isRemoteEnabled', true);

    // Crear instancia de Dompdf
    $dompdf = new Dompdf($options);

    // Crear contenido HTML
    $html = '<html><body>';
    $html .= '<img src="' . $imgData . '" style="width: 100%;">';
    $html .= '</body></html>';

    // Cargar HTML en Dompdf
    $dompdf->loadHtml($html);

    // Renderizar PDF
    $dompdf->render();

    // Enviar PDF al navegador
    $dompdf->stream("perfil_usuario.pdf", array("Attachment" => false));
    exit(0);
}
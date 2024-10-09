<?php
session_start();
if(!isset($_SESSION['login_gmt'])) {
    header('Location: ../../../login.php');
    exit();
}

// Definir rutas base
//$baseDir = realpath(__DIR__ . '/../../../');
//$actionsDir = $baseDir . '/actions';

// Función para verificar y incluir archivos
function safeRequire($file) {
    if (file_exists($file)) {
        require_once $file;
        echo "Archivo incluido: $file<br>";
    } else {
        echo "Advertencia: El archivo $file no existe.<br>";
    }
}

// Intentar incluir los archivos necesarios
include("../../../actions/conexion.php");
//safeRequire($actionsDir . '../../../actions/conexion.php');

// Incluir Composer autoload para Twig y Dompdf
$vendorAutoload = $baseDir . '/vendor/autoload.php';
safeRequire($vendorAutoload);

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Dompdf\Dompdf;
use Dompdf\Options;

$views = "../../";

// Funciones que podrían haber estado en functions.php
    //funcion de quitar acentos
function quitar_acentos($cadena) {
        $no_permitidas = array('á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','À','Ã','Ì','Ò','Ù','Ã™','Ã','Ãè','Ã¬','Ã²','Ã¹','ç','Ç','Ã¢','ê','Ã®','Ã´','Ã»','Ã‚','ÃŠ','ÃŽ','Ã','Ã›','ü','Ã¶','Ã–','Ã¯','Ã¤','«','Ò','Ã','ÃÄ','ÃË');
        $permitidas = array("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        return str_replace($no_permitidas, $permitidas, $cadena);
}

function getToken() {
    if (isset($_SESSION['token']) && $_SESSION['token_expiry'] > time()) {
        return $_SESSION['token'];
    }

    $ch = curl_init();

    curl_setopt_array($ch, [
      CURLOPT_URL => "https://api-sandbox.weetrust.com.mx/access/token",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "user-id: TeFbEi5eNYa6RAoamjHweOi7E2u1",
        "api-key: 0a967dca0f50bca58c9693cecb76500c0e03925f",
      ],
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false,
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);

    curl_close($ch);

    if ($err) {
        throw new Exception("cURL Error #: " . $err);
    }
    $response_json = json_decode($response, true);
    $response_data = $response_json['responseData'];

    if (!isset($response_data['accessToken'])) {
        throw new Exception('Invalid token response');
    }

    $_SESSION['token'] = $response_data['accessToken'];
    $_SESSION['token_expiry'] = time() + 300;

    return $_SESSION['token'];
}

function uploadDocument($filePath, $fileName) {
    $token = getToken();

    $ch = curl_init();

    curl_setopt_array($ch, [
      CURLOPT_URL => "https://api-sandbox.weetrust.com.mx/documents",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => [
        'file'=> new CURLFILE($filePath, 'application/pdf', $fileName),
        'documentName' => $fileName,
        'documentType' => 'PDF'
      ],
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "token: $token",
        "user-id: TeFbEi5eNYa6RAoamjHweOi7E2u1"
      ],
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);

    curl_close($ch);

    if ($err) {
        throw new Exception("cURL Error #: " . $err);
    }

    return $response;
}

function fijarFirma($documentoId) {
    $token = getToken();

    $ch = curl_init();

    curl_setopt_array($ch, [
      CURLOPT_URL => "https://api-sandbox.weetrust.com.mx/documents/signature",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => json_encode([
        'documentID' => $documentoId,
        'signatureCoordinates' => [
            [
                'page' => 1,
                'coordinateX' => 100,
                'coordinateY' => 100
            ]
        ]
      ]),
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "content-type: application/json",
        "token: $token",
        "user-id: TeFbEi5eNYa6RAoamjHweOi7E2u1"
      ],
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);

    curl_close($ch);

    if ($err) {
        throw new Exception("cURL Error #: " . $err);
    }

    return $response;
}

function enviarDocumento($documentoId, $name, $email) {
    $token = getToken();

    $ch = curl_init();

    curl_setopt_array($ch, [
      CURLOPT_URL => "https://api-sandbox.weetrust.com.mx/documents/signatory",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => json_encode([
        'documentID' => $documentoId,
        'nickname' => $name,
        'message' => 'Se le solicita la firma del siguiente contrato',
        'title' => 'Firma de contrato',
        'hasOrder' => false,
        'disableMailing' => false,
        'signatory' => [
        [
                'emailID' => $email,
                'name' => $name
        ]
    ]
      ]),
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "content-type: application/json",
        "token: $token",
        "user-id: TeFbEi5eNYa6RAoamjHweOi7E2u1"
      ],
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);

    curl_close($ch);

    if ($err) {
        throw new Exception("cURL Error #: " . $err);
    }

    return $response;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_users'])) {
    $selected_users = $_POST['selected_users'];

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

    $dompdf = new Dompdf($options);

    foreach ($selected_users as $user_id) {
        try {
            // Obtener información del usuario
            $query = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$user_id'");
            $user = mysqli_fetch_assoc($query);

            if (!$user) {
                throw new Exception("Usuario no encontrado para ID: $user_id");
            }

            // Preparar los datos para la plantilla
            $datos = [
                'nombre' => $user['nombre'],
                'apellido_paterno' => $user['app'],
                'apellido_materno' => $user['apm'],
                'curp' => $user['curp'],
                'rfc' => $user['rfc'],
                'fecha_nacimiento' => $user['fecha_nacimiento'],
                // Agregar más campos según sea necesario
            ];

            // Renderizar la plantilla con Twig
            $html = $twig->render('contrato.html.twig', $datos);

            // Cargar el HTML en Dompdf
            $dompdf->loadHtml($html);

            // Configurar el tamaño y la orientación del papel
            $dompdf->setPaper('A4', 'portrait');

            // Renderizar el HTML como PDF
            $dompdf->render();

            // Guardar el PDF en un archivo temporal
            $pdfContent = $dompdf->output();
            $tempFile = tempnam(sys_get_temp_dir(), 'contract_');
            file_put_contents($tempFile, $pdfContent);

            // Subir documento a Weetrust
            $fileName = 'contrato_' . $user['curp'] . '.pdf';
            $response = uploadDocument($tempFile, $fileName);
            $response_json = json_decode($response, true);
            $documentoId = $response_json['responseData']['documentID'];

            // Fijar firma
            $response_ff = fijarFirma($documentoId);

            // Enviar documento a firma
            $response_ed = enviarDocumento($documentoId, $user['nombre'], $user['correo']);
            $response_json_ed = json_decode($response_ed, true);
            $signatoryID = $response_json_ed['responseData']['signatory'][0]['signatoryID'];
            $estatus = $response_json_ed['responseData']['status'];
            $url = $response_json_ed['responseData']['signatory'][0]['signing']['url'];

            // Insertar en la base de datos
            mysqli_query($con, "INSERT INTO contratos_weetrust VALUES (
                0,
                now(),
                '".$user['id']."',
                '".$user['curp']."',
                '".$documentoId."',
                '".$signatoryID."',
                '".$url."',
                '".$estatus."');");

            echo "Contrato procesado exitosamente para el usuario: " . $user['nombre'] . "<br>";

            // Limpiar el archivo temporal
            unlink($tempFile);

            // Limpiar Dompdf para el siguiente uso
            $dompdf->clear();

        } catch (Exception $e) {
            echo "Error al procesar el usuario " . $user['nombre'] . ": " . $e->getMessage() . "<br>";
        }
    }

    echo "<br><a href='../preaprobados.php'>Volver a Preaprobados</a>";
} else {
    echo "No se seleccionaron usuarios para generar contratos.";
    echo "<br><a href='../preaprobados.php'>Volver a Preaprobados</a>";
}
?>
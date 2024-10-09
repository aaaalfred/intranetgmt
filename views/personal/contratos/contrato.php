<?php
session_start();
if (!isset($_SESSION['login_gmt'])) {
    header("Location: ../../../login.php");
    exit();
}

require_once '../../../vendor/autoload.php';
include("../../../actions/conexion.php");

use Dompdf\Dompdf;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Configuración de Twig
$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

// Directorio para guardar los contratos
$contractDir = __DIR__ . '/contratos_generados/';
if (!file_exists($contractDir)) {
    mkdir($contractDir, 0777, true);
}

$zipFilename = 'contratos_' . date('Y-m-d_H-i-s') . '.zip';
$zip = new ZipArchive();
$zip->open($contractDir . $zipFilename, ZipArchive::CREATE);

$contractsGenerated = [];
$errors = [];

if (isset($_POST['selected_users']) && is_array($_POST['selected_users'])) {
    foreach ($_POST['selected_users'] as $userId) {
        // Obtener datos del usuario
        $query = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$userId'");
        $userData = mysqli_fetch_assoc($query);

        if ($userData) {
            try {
                // Renderizar la plantilla Twig con los datos del usuario
                $html = $twig->render('contrato.html.twig', [
                    'nombre' => $userData['nombre'] . ' ' . $userData['app'] . ' ' . $userData['apm'],
                    'curp' => $userData['curp'],
                    'nss' => $userData['nss'],
                    // Agrega más campos según sea necesario
                ]);

                // Generar PDF
                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                $pdfFilename = 'contrato_' . $userData['curp'] . '.pdf';
                $pdfPath = $contractDir . $pdfFilename;
                file_put_contents($pdfPath, $dompdf->output());

                // Agregar al ZIP
                $zip->addFile($pdfPath, $pdfFilename);

                // Insertar información en la base de datos
                $fechaGeneracion = date('Y-m-d H:i:s');
                $query = "INSERT INTO contratos (usuario_id, fecha_generacion, nombre_archivo) 
                          VALUES ('$userId', '$fechaGeneracion', '$pdfFilename')";
                if (!mysqli_query($con, $query)) {
                    throw new Exception("Error al insertar en la tabla contratos: " . mysqli_error($con));
                }

                $contractsGenerated[] = $pdfFilename;

                // Subir a WeeSign y enviar para firma
                $documentId = uploadDocument($pdfPath, $userData['curp'], 'pdf');
                if ($documentId) {
                    fijarFirma($documentId, $userData['email']);
                    $signingInfo = enviarDocumento($documentId, $userData['email'], $userData['nombre']);
                    
                    if ($signingInfo) {
                        $query = "INSERT INTO contratos_weetrust 
                            (fecha, id_usuario, curp, documentoId, signatoryID, url, estatus) 
                            VALUES (NOW(), '$userId', '{$userData['curp']}', '$documentId', 
                            '{$signingInfo['signatoryID']}', '{$signingInfo['url']}', '{$signingInfo['estatus']}')";
                        if (!mysqli_query($con, $query)) {
                            throw new Exception("Error al insertar en la tabla contratos_weetrust: " . mysqli_error($con));
                        }
                    } else {
                        throw new Exception("No se pudo obtener la información de firma de WeeSign");
                    }
                } else {
                    throw new Exception("No se pudo subir el documento a WeeSign");
                }
            } catch (Exception $e) {
                $errors[] = "Error procesando contrato para usuario $userId: " . $e->getMessage();
            }
        } else {
            $errors[] = "No se encontraron datos para el usuario con ID $userId";
        }
    }
}

$zip->close();

// Funciones de WeeSign
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

function uploadDocument($filePath, $nombre, $extension) {
    $token = getToken();

    $url = 'https://api-sandbox.weetrust.com.mx/documents';
    $headers = [
        'accept: */*',
        'token: ' . $token,
        'user-id: TeFbEi5eNYa6RAoamjHweOi7E2u1',
        'Content-Type: multipart/form-data'
    ];

    $cfile = new CURLFile($filePath, 'application/pdf', $nombre.'.'.$extension);

    $data = [
        'document' => $cfile
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);

    curl_close($ch);

    if ($err) {
        throw new Exception("cURL Error #: " . $err);
    }

    $responseData = json_decode($response, true);
    return $responseData['responseData']['documentID'];
}

function fijarFirma($documentoId, $email) {
    $token = getToken();
    
    $ch = curl_init();
    
    curl_setopt_array($ch, [
      CURLOPT_URL => "https://api-sandbox.weetrust.com.mx/documents/fixed-signatory",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => json_encode([
        'staticSignPositions' => [
            [
                'parentImageSize' => [
                    'width' => '612',
                    'height' => '792'
                ],
                'user' => [
                    'email' => $email
                ],
                'coordinates' => [
                    'x' => '324',
                    'y' => '324'
                ],
                'viewport' => [
                    'width' => '612',
                    'height' => '792'
                ],
                'imageSize' => [
                    [
                    'width' => '101',
                    'height' => '51'
                    ]
                ],
                'page' => 1,
                'pageY' => 314,
                'color' => '#000acc'
            ]
        ],
        'documentID' => $documentoId
      ]),
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "content-type: application/json",
        'token: ' . $token,
        "user-id: TeFbEi5eNYa6RAoamjHweOi7E2u1",
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

    return json_decode($response, true);
}

function enviarDocumento($documentoId, $email, $nombre) {
    $token = getToken();
    
    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://api-sandbox.weetrust.com.mx/documents/signatory",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => json_encode([
        'documentID' => $documentoId,
        'nickname' => $nombre,
        'message' => 'Se le solicita la firma del siguiente contrato',
        'title' => 'Firma de contrato',
        'hasOrder' => false,
        'disableMailing' => false,
        'signatory' => [
            [
                'emailID' => $email,
                'name' => $nombre
            ]
        ]
      ]),
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "content-type: application/json",
        "token: $token",
        "user-id: TeFbEi5eNYa6RAoamjHweOi7E2u1"
      ],
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false,
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        throw new Exception("cURL Error #: " . $err);
    }

    $responseData = json_decode($response, true);
    return [
        'signatoryID' => $responseData['responseData']['signatory'][0]['signatoryID'],
        'estatus' => $responseData['responseData']['status'],
        'url' => $responseData['responseData']['signatory'][0]['signing']['url']
    ];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contratos Generados</title>
    <!-- Incluir estilos CSS necesarios -->
</head>
<body>
    <h1>Contratos Generados</h1>
    <?php if (!empty($contractsGenerated)): ?>
        <p>Se han generado los siguientes contratos:</p>
        <ul>
            <?php foreach ($contractsGenerated as $contract): ?>
                <li><?php echo htmlspecialchars($contract); ?></li>
            <?php endforeach; ?>
        </ul>
        <p><a href="<?php echo $contractDir . $zipFilename; ?>" download>Descargar todos los contratos (ZIP)</a></p>
    <?php else: ?>
        <p>No se han generado contratos.</p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <h2>Errores:</h2>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p><a href="../preaprobados.php">Volver a Preaprobados</a></p>
</body>
</html>
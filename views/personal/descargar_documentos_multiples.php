<?php
session_start();

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

function obtenerUrlDocumento($documento_id) {
    $token = getToken();

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api-sandbox.weetrust.com.mx/documents/update-url",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => json_encode(['documentID' => $documento_id]),
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
        echo "cURL Error #:" . $err;
        exit;
    }

    return json_decode($response, true);
}

if (isset($_POST['document_ids']) && is_array($_POST['document_ids'])) {
    $document_ids = $_POST['document_ids'];
    $zip = new ZipArchive();
    $zipFileName = 'documentos_seleccionados.zip';

    if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
        exit("No se puede abrir el archivo <$zipFileName>\n");
    }

    foreach ($document_ids as $document_id) {
        $response = obtenerUrlDocumento($document_id);
        $url = $response['responseData']['url'];
        
        $file_content = file_get_contents($url);
        $zip->addFromString("$document_id.pdf", $file_content);
    }

    $zip->close();

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
    header('Content-Length: ' . filesize($zipFileName));

    readfile($zipFileName);
    unlink($zipFileName);
    exit;
} else {
    echo 'No se seleccionaron documentos.';
}
?>

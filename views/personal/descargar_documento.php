<?php


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

		/*curl_setopt_array($curl, [
		  CURLOPT_URL => "https://api-sandbox.weetrust.com.mx/documents/$documento_id",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => [
			"accept: application/json",
			"token: $token",
			"user-id: TeFbEi5eNYa6RAoamjHweOi7E2u1"
		  ],
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		]);*/
		
		curl_setopt_array($curl, [
		  CURLOPT_URL => "https://api-sandbox.weetrust.com.mx/documents/update-url",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "PUT",
		  CURLOPT_POSTFIELDS => json_encode([
			'documentID' => $documento_id
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
		  echo "cURL Error #:" . $err;
		}

		return json_decode($response, true);
	}
	
	$responseoud = obtenerUrlDocumento($_GET['doc']);
	
	//var_dump($responseoud['responseData']["url"]);exit;
	
	//urlencode($responseoud['responseData']["url"]);
	
	
// Obtén la URL del documento desde el parámetro de la URL
$weetrust_url = $responseoud['responseData']["url"];

// Verifica si la URL está presente
if (empty($weetrust_url)) {
    echo 'URL no proporcionada.';
    exit;
}

// Nombre del archivo a ser descargado
$file_name = $_GET['doc'].'.pdf'; // Cambia esto por el nombre que desees

// Inicializa cURL
$ch = curl_init();

// Configura la URL y otras opciones necesarias para cURL
curl_setopt($ch, CURLOPT_URL, $weetrust_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

// Ejecuta la solicitud cURL
$file_content = curl_exec($ch);

// Verifica si hubo algún error
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit;
}

// Cierra la sesión cURL
curl_close($ch);

// Configura los encabezados para forzar la descarga
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $file_name . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . strlen($file_content));

// Envía el contenido del archivo al navegador
echo $file_content;
exit;
?>

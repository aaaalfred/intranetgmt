<?php
session_start();

include ("../../actions/conexion.php");


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
        CURLOPT_HTTPHEADER => [
			"user-id: TeFbEi5eNYa6RAoamjHweOi7E2u1",
			'token: ' . $token,
			'accept: application/json',
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

function fijarFirma($documentoId) {
	
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
                                'email' => $_POST['email']
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
    


    return $response;
}


function enviarDocumento($documentoId) {
	
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
		'nickname' => $_POST['name'],
		'message' => 'Se le solicita la firma del siguiente contrato',
		'title' => 'Firma de contrato',
		'hasOrder' => false,
		'disableMailing' => false,
		'signatory' => [
        [
                'emailID' => $_POST['email'],
                'name' => $_POST['name']
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

	$response2 = curl_exec($curl);
	$err2 = curl_error($curl);

    curl_close($curl);
	

    if ($err2) {
        throw new Exception("cURL Error #: " . $err2);
    }
    


    return $response2;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pdfFile']['tmp_name'];
        $fileName = $_FILES['pdfFile']['name'];
        $fileSize = $_FILES['pdfFile']['size'];
        $fileType = $_FILES['pdfFile']['type'];

        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        if ($fileExtension !== 'pdf') {
            echo "Solo se permiten archivos PDF.";
            exit;
        }

        try {
            $response = uploadDocument($fileTmpPath, $fileNameCmps, $fileExtension);
            echo "Documento subido exitosamente: " . json_encode($response);
			//$response_json = json_decode($response, true);
			$_SESSION['documentoId'] = $response['responseData']['documentID'];
			//var_dump($_SESSION['documentoId']);
			try {
				//Agrega api de coordenadas de firma
				$response_ff = fijarFirma($_SESSION['documentoId']);
				$response_json = json_decode($response_ff, true);
				//var_dump($response_json);
				
				try {
					//enviar documento a firma
					$response_ed = enviarDocumento($_SESSION['documentoId']);
					$response_json_ed = json_decode($response_ed, true);
					//var_dump("Aqui es la api de enviar documento a firma");
					$_SESSION['signatoryID'] = $response_json_ed['responseData']['signatory'][0]['signatoryID'];
					$_SESSION['estatus'] = $response_json_ed['responseData']['status'];
					$_SESSION['url'] = $response_json_ed['responseData']['signatory'][0]['signing']['url'];
					
					mysqli_query($con, "INSERT INTO contratos_weetrust VALUES (
						0,
						now(),
						'".$_POST["id"]."',
						'".$_POST["curp"]."',
						'".$_SESSION['documentoId']."',
						'".$_SESSION['signatoryID']."',
						'".$_SESSION['url']."',
						'".$_SESSION['estatus']."');");
						
					header("location: perfil_weetrust.php?id=".$_POST['id']."&curp=".$_POST['curp']."&vista=".$_POST['vista']);
					
				} catch (Exception $e) {
					echo "Error: " . $e->getMessage();
			}
				
			} catch (Exception $e) {
				echo "Error: " . $e->getMessage();
			}
			
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Error al subir el archivo.";
    }
}

?>

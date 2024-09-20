<?php
	session_start();
	//var_dump($_POST['periodo']);exit;
	$message = '';
	$errores = '';
	if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload')
	{
		if (isset($_FILES['uploadedFile']))
		{
			foreach($_FILES['uploadedFile']['tmp_name'] as $key => $tmp_name)
			{
				if ($_FILES['uploadedFile']['error'][$key] === UPLOAD_ERR_OK)
				{
					// Obtengo detalle del archivo a ejecutar
					$fileTmpPath = $_FILES['uploadedFile']['tmp_name'][$key];
					$fileName = $_FILES['uploadedFile']['name'][$key];
					$fileSize = $_FILES['uploadedFile']['size'][$key];
					$fileType = $_FILES['uploadedFile']['type'][$key];
					$fileNameCmps = explode(".", $fileName);
					$fileExtension = strtolower(end($fileNameCmps));
					
					$DateAndTime = date('mdYhis', time());
					$nombredoc = "Lista.$fileExtension";
					// Checo si al archivo tiene las siguientes extensiones
					$allowedfileExtensions = array('xls', 'xlsx');
					if (in_array($fileExtension, $allowedfileExtensions))
					{
					  // Directorio en el que almacenaran los archivos
					  $directorio = 'C:\wamp64\www\admin-gmt\views\personal\archivo_lista\\';
					  $dest_path = $directorio . $nombredoc;

					  if(move_uploaded_file($fileTmpPath, $dest_path)) 
					  {
						$message .= 'Archivo '.$fileName.' subido correctamente<br>';
					  }
					  else 
					  {
						$errores .= 'Hubo un error al guardar el archivo '.$fileName.'<br>';
					  }
					}
					else
					{
					  $errores .= 'No se pudo subir el archivo '.$fileName.' porque no cumple con las siguientes extensiones '. implode(',', $allowedfileExtensions).'<br>';
					}
				}
				else
				{
					$errores .= 'Error con el archivo '.$fileName.': '. $_FILES['uploadedFile']['error'][$key].'<br>';
				}
			}
		}
	}
	//var_dump("Fin");exit;
	$_SESSION['message'] = $message;
	$_SESSION['errores'] = $errores;
	$_SESSION['ubicacion'] = $dest_path;
	header("Location: recibos.php?csl=true#mensajes");
?>
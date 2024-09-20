<?php
session_start();

	include('../../actions/conexion.php');
	$variables = "";
	for($i = 0 ; $i < count($_POST['claves']) ; $i++){
		if($i ==0){
			$variables = $variables . $_POST['claves'][$i]."";
		}else{
			$variables = $variables . "," . $_POST['claves'][$i];

		}
	}
	
	//var_dump("UPDATE credenciales SET nombre ='".$_POST['nombre']."', usuario='".$_POST['usuario']."', password='".$_POST['password']."', clave='".$variables."' WHERE id = ".$_GET['id'].";");exit;
	mysqli_query($con, "UPDATE credenciales SET nombre ='".$_POST['nombre']."', usuario='".$_POST['usuario']."', password='".$_POST['password']."', correo='".$_POST['correo']."', clave='".$variables."' WHERE id = ".$_GET['id'].";");

	header("Location: ejecutivos.php");

?>
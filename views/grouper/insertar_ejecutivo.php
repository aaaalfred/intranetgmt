<?php 
	
	include('../../actions/conexion.php');
	$variables = "";
	for($i = 0 ; $i < count($_POST['claves']) ; $i++){
		if($i ==0){
			$variables = $variables . $_POST['claves'][$i]."";
		}else{
			$variables = $variables . "," . $_POST['claves'][$i];

		}
	}
	//var_dump("INSERT INTO credenciales (id, nombre, rol, clave, usuario, password, correo, ejecutivo, tipo) VALUES (0, '".$_POST['nombre']."', 'EJECUTIVO', ('".$variables."'), '".$_POST['usuario']."', '".$_POST['password']."', '".$_POST['correo']."', NULL, '".$_POST['rol']."');");exit;
	mysqli_query($con, "INSERT INTO credenciales (id, nombre, rol, clave, usuario, password, correo, ejecutivo, tipo) VALUES (0, '".$_POST['nombre']."', 'EJECUTIVO', ('".$variables."'), '".$_POST['usuario']."', '".$_POST['password']."', '".$_POST['correo']."', NULL, '".$_POST['rol']."');");

	header("Location: ejecutivos.php");

?>
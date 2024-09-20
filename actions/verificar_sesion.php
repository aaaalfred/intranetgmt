<?php
	session_start();
	function verificar_login($correo,$pass,&$result) {
		include("conexion.php");
		$sql = "SELECT * FROM credenciales WHERE usuario = '$correo' AND password = '$pass';";
		$rec = mysqli_query($con, $sql);
		$count = 0;
		while($row = mysqli_fetch_object($rec))
		{
			$count++;
			$result = $row;
		}
		if($count == 1)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	if(!isset($_SESSION['login_gmt']))
	{
		if(verificar_login($_POST['username'], $_POST['password'], $result) == 1)
		{
			$_SESSION['login_gmt'] = true;
			$_SESSION['id_gmt'] = $result->id;
			$_SESSION['nombre_gmt'] = $result->nombre;
			$_SESSION['rol_gmt'] = $result->rol;
			$_SESSION['clave_gmt'] = $result->clave;
			$_SESSION['usuario_gmt'] = $result->usuario;
			$_SESSION['password_gmt'] = $result->password;
			$_SESSION['tipo_gmt'] = $result->tipo;
			header("location: ../views/index.php");	
		}else{
			header("location:  ../login.php");
		}
    } else {
		header("location:  ../views/index.php");
	}
?>
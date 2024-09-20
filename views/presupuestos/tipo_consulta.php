<?php
	session_start();
	//error_reporting(0);
	$views = "../";
	include("$views../actions/conexion.php");
	
	$_SESSION['fechai'] = $_POST["fechai"];
	$_SESSION['fechaf'] = $_POST["fechaf"];
	//$_SESSION['cadena'] = $_POST["cadena"];

	if($_POST["enviar"]=="enviar")
	{	
		//var_dump("La consulta es enviar");exit;
		header("location:solicitudes.php");
	}
	if($_POST["enviar"]=="excel")
	{
		//var_dump("La consulta es exportar");exit;
		header("location:excel_solicitudes.php");
	}
?>


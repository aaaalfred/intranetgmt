<?php 
	error_reporting(0);
	session_start();
	include ("../../actions/conexion.php");
	$sql2 = "UPDATE usuarios set ".$_GET["documento"]." = null WHERE id = ".$_GET['id'].";";
	$rec2 = mysqli_query($con, $sql2);

	header("location:perfil.php?id=".$_GET['id']."&curp=".$_GET['curp']."&vista=".$_GET["tipo"]);

?>
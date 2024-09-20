<?php 
session_start();
include ("../../../actions/conexion.php");
		$sql = "INSERT INTO autorizaciones values(0 ,'".$_POST['id']."', NOW(), '1', '".$_SESSION['nombre_gmt']."', null, '0', null);";
	    $rec = mysqli_query($con, $sql);
	    $sql2 = "UPDATE usuarios set autorizado = 1 WHERE id = ".$_POST['id'].";";
	    $rec2 = mysqli_query($con, $sql2);
	header("location:../candidatos.php");

?>
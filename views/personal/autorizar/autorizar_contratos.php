<?php 
session_start();
include ("../../../actions/conexion.php");
if(empty($_POST['autorizado'])){
	$sql = "INSERT INTO autorizaciones values(0 ,'".$_POST['id']."', NOW(), '1', '".$_SESSION['nombre_gmt']."', NOW(), '1', '".$_SESSION['nombre_gmt']."');";
	$rec = mysqli_query($con, $sql);
	$sql2 = "UPDATE usuarios set autorizado = 1, autorizado_dos = 1 WHERE id = ".$_POST['id'].";";
	$rec2 = mysqli_query($con, $sql2);
}else{ 
	$sql = "UPDATE autorizaciones set fecha_check_dos = NOW(), check_dos = '1', autorizo_dos = '".$_SESSION['nombre_gmt']."' WHERE usuario_id = ".$_POST['id'].";";
	$rec = mysqli_query($con, $sql);
	$sql2 = "UPDATE usuarios set autorizado_dos = 1 WHERE id = ".$_POST['id'].";";
	$rec2 = mysqli_query($con, $sql2);
}

header("location:../candidatos.php");

?>
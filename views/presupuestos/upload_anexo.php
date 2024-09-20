<?php
session_start();
//unset($_SESSION['nombrePresupuesto']);
//unset($_SESSION['clavecliente']);
	
include('../../actions/conexion.php');

$claveppto = $_POST["clavePpto"];
$id = $_POST["id"];

//var_dump($_POST['archivo']);exit;

$nombrearchivo=$_FILES['archivo']['name'];
$ruta=$_FILES['archivo']['tmp_name'];
$destino = "presupuesto/".$claveppto.".xlsx"; #para el insert
copy($ruta,"presupuesto/".$claveppto.".xlsx"); #para el la copia del archivo en carpeta indicada

$nombrepdf=$_FILES['pdf']['name'];
$rutapdf=$_FILES['pdf']['tmp_name'];
$destinopdf = "presupuesto/".$claveppto.".pdf"; #para el insert
copy($rutapdf,"presupuesto/".$claveppto.".pdf"); #para el la copia del archivo en carpeta indicada
//var_dump("update PRESUPUESTO set clavePpto='".$_POST["clavePpto"]."', archivoPpto='$destino', pdf='$destinopdf' WHERE nombrePpto='".$_SESSION["nombrePresupuesto"]."' and idUser= '".$_SESSION["usuario_id"]."' AND idPpto=$id;");exit;
mysqli_query($con, "update PRESUPUESTO set clavePpto='".$_POST["clavePpto"]."', archivoPpto='$destino', pdf='$destinopdf' WHERE nombrePpto='".$_SESSION["nombre_presupuesto"]."' and idUser= ".$_SESSION["id_gmt"]." AND idPpto=$id;");


	

	header("Location: presupuestos.php");
	
?>
<?php
session_start();
include('../../actions/conexion.php');
mysqli_query($con, "INSERT INTO presupuesto VALUES (0, NOW(), '".$_POST["descplan"]."','".$_POST["cliente_presupuesto"]."', '','".$_POST["nombre_presupuesto"]."', '','".$_SESSION["id_gmt"]."', '', '','".$_POST["empresa"]."', '".$_POST["temporalidad"]."', '','".$_POST["anexo"]."' );");


$_SESSION['clave_padre'] = $_POST["clave_presupuesto"];
$_SESSION['nombre_presupuesto'] = $_POST["nombre_presupuesto"];
$_SESSION['clave_cliente'] = $_POST["cliente_presupuesto"];

header("Location:adjuntar_anexo.php");	
?>

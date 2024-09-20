<?php
session_start();
if (($_SESSION["login_gmt"]==""))
{
	include ("../../actions/conexion.php");
}
else
{
	include ("../../actions/conexion.php");
	
	$porciones = explode("-", $_POST["cliente_presupuesto"]);
	$pre_cliente = $porciones[0];
	$idCliente = $porciones[1];
	//var_dump("Este es el idCliente $idCliente y este el pre $pre_cliente");exit;
	//var_dump("INSERT INTO presupuesto VALUES (0, NOW(), '".$_POST["plan"]."','".$_POST["cliente_presupuesto"]."', '','".$_POST["nombre_presupuesto"]."', '','".$_SESSION["id_gmt"]."', '', '','".$_POST["empresa"]."', '".$_POST["temporalidad"]."', '','' );");exit;
	mysqli_query($con, "INSERT INTO presupuesto VALUES (0, NOW(), '".$_POST["plan"]."','".$_POST["cliente_presupuesto"]."', '','".$_POST["nombre_presupuesto"]."', '','".$_SESSION["id_gmt"]."', '$idCliente', '','".$_POST["empresa"]."', '".$_POST["temporalidad"]."', '','' );");

	$_SESSION['nombre_presupuesto'] = $_POST["nombre_presupuesto"];
	$_SESSION['clave_cliente'] = $pre_cliente;

	header("Location:adjuntar.php");
}	
?>
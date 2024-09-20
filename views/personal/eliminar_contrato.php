<?php
session_start();
//var_dump($_GET['curp']);exit;
//include ("../actions/conexion.php");

//Eliminar registro de tabla contrato
$sql_au = "DELETE FROM contratos WHERE id = ".$_GET['id'].";";
$rec_au = mysqli_query($con, $sql_au);

//busca el usuario para obtener id y redireccionar al perfil
$sql_id = "SELECT id FROM usuarios WHERE curp = '".$_GET['curp']."';";
$rec_id = mysqli_query($con, $sql_id);

$fila=mysqli_fetch_array($rec_id);
//var_dump($fila['id']);exit;

header("location: perfil.php?id=".$fila['id']."&curp=".$_GET['curp']."&vista=".$_GET['tipo']);

?>
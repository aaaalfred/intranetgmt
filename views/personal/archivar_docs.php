<?php
session_start();
//var_dump($_GET['curp']);exit;
$views = "../";
	
include("$views../actions/conexion.php");

if($_GET['documento'] == "contrato"){
	//busca el usuario para obtener id y documento, tambien para redireccionar al perfil
	$sql_id = "SELECT * FROM usuarios WHERE curp = '".$_GET['curp']."';";
	$rec_id = mysqli_query($con, $sql_id);
	$fila=mysqli_fetch_array($rec_id);
	
	
	$sql_id2 = "SELECT * FROM contratos WHERE id = ".$_GET['id'].";";
	$rec_id2 = mysqli_query($con, $sql_id2);
	$fila2=mysqli_fetch_array($rec_id2);
	$doc = $fila2['contrato'];
	
	//se inserta el documento en la tabla historial
	$sqlinsert = "INSERT INTO historico_documentos VALUES (0, NOW(), '".$_GET['curp']."', '".$_GET['documento']."', '".$doc."');";
	$recinsert = mysqli_query($con, $sqlinsert);
	
	//Eliminar registro de tabla contrato
	$sql_au = "DELETE FROM contratos WHERE id = ".$_GET['id'].";";
	$rec_au = mysqli_query($con, $sql_au);
	
	$sqlstatus = "UPDATE usuarios set status_contrato = null WHERE curp = '".$_GET['curp']."';";
	$recstatus = mysqli_query($con, $sqlstatus);

	
}else if($_GET['documento'] == "identificacion1"){
	
	//Se obtiene el archivo que se quiere archivar
	$sqldoc = "SELECT * FROM usuarios WHERE curp = '".$_GET['curp']."';";
	$resdoc = mysqli_query($con, $sqldoc);
	$fila=mysqli_fetch_array($resdoc);
	$doc = $fila["doc_identificacion"];
	//var_dump();exit;
	//var_dump($doc);exit;
	
	//se inserta el documento en la tabla historial
	$sqlinsert = "INSERT INTO historico_documentos VALUES (0, NOW(), '".$_GET['curp']."', 'identificacion', '".$doc."');";
	//var_dump($sqlinsert);exit;
	$recinsert = mysqli_query($con, $sqlinsert);
	
	$sql2 = "UPDATE usuarios set doc_identificacion = null WHERE id = ".$_GET['id'].";";
	$rec2 = mysqli_query($con, $sql2);
	
}else if($_GET['documento'] == "identificacion2"){
	
	//Se obtiene el archivo que se quiere archivar
	$sqldoc = "SELECT * FROM usuarios WHERE curp = '".$_GET['curp']."';";
	$resdoc = mysqli_query($con, $sqldoc);
	$fila=mysqli_fetch_array($resdoc);
	
	//Se obtiene el archivo que se quiere archivar
	$sqldoc2 = "SELECT * FROM fotos_identificacion WHERE curp = '".$_GET['curp']."';";
	$resdoc2 = mysqli_query($con, $sqldoc2);
	$filadoc2=mysqli_fetch_array($resdoc2);
	$frontal = $filadoc2["frontal"];
	$trasera = $filadoc2["trasera"];
	
	//var_dump($frontal);exit;
	//se inserta el documento en la tabla historial
	$sqlinsert1 = "INSERT INTO historico_documentos VALUES (0, NOW(), '".$_GET['curp']."', 'id_frontal', '".$frontal."');";
	$recinsert1 = mysqli_query($con, $sqlinsert1);
	$sqlinsert2 = "INSERT INTO historico_documentos VALUES (0, NOW(), '".$_GET['curp']."', 'id_trasera', '".$trasera."');";
	$recinsert2 = mysqli_query($con, $sqlinsert2);
	
	//Eliminar registro de tabla contrato
	$sql_au = "DELETE FROM fotos_identificacion WHERE curp = '".$_GET['curp']."';";
	$rec_au = mysqli_query($con, $sql_au);
}

header("location: perfil.php?id=".$fila['id']."&curp=".$_GET['curp']."&vista=".$_GET['tipo']);

?>
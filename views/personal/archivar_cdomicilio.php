<!-- <?php
// var_dump("UPDATE usuarios set ".$_GET["documento"]." = null WHERE id = ".$_GET['id'].";");exit;
?> -->
 <?php 
 //var_dump($_GET['curp']." y ".$_GET['tipo']);exit;
	error_reporting(0);
	session_start();
	$views = "../";
	
	include("$views../actions/conexion.php");
	
	//Se obtiene el archivo que se quiere archivar
	$sqldoc = "SELECT * FROM usuarios WHERE id = ".$_GET['id'].";";
	$resdoc = mysqli_query($con, $sqldoc);
	$filadoc=mysqli_fetch_array($resdoc);
	$doc = $filadoc[$_GET["documento"]];
	//var_dump();exit;
	//var_dump($doc);exit;
	
	//se inserta el documento en la tabla historial
	$sqlinsert = "INSERT INTO historico_documentos VALUES (0, NOW(), '".$_GET['curp']."', '".$_GET['documento']."', '".$doc."');";
	$recinsert = mysqli_query($con, $sqlinsert);
	
	$sql2 = "UPDATE usuarios set ".$_GET["documento"]." = null WHERE id = ".$_GET['id'].";";
	$rec2 = mysqli_query($con, $sql2);
	
	

	header("location:perfil.php?id=".$_GET['id']."&curp=".$_GET['curp']."&vista=".$_GET["tipo"]);

?>
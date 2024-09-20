<?php 
	session_start();
	include ("../../../actions/conexion.php");
	mysqli_query($con, "UPDATE usuarios SET curp = '".$_POST['curpv']."' WHERE  id = ".$_POST['id'].";	");
	
	header("location: ../perfil.php?id=".$_POST['id']."&curp=".$_POST['curpv']."&vista=".$_POST['vista']);
?>
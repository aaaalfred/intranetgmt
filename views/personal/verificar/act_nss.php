<?php 
	session_start();
	include ("../../../actions/conexion.php");
	mysqli_query($con, "UPDATE usuarios SET nss = '".$_POST['nssv']."' WHERE  id = ".$_POST['id'].";	");
	
	header("location: ../perfil.php?id=".$_POST['id']."&curp=".$_POST['curpperfil']."&vista=".$_POST['vista']);
?>
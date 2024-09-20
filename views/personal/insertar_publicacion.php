<?php
	session_start();
	include ("../../actions/conexion.php");
	
	var_dump("INSERT INTO vacantes VALUES (
	0,
	now(),
	'".$_POST["promocion"]."',
	'".$_POST["puesto"]."',
	'".$_POST["puestos"]."',
	'".$_POST["descorta"]."',
	'".$_POST["despuesto"]."',
	'',
	'".$_POST["escolaridad"]."',
	'".$_POST["edad"]."',
	'".$_POST["sexo"]."',
	'".$_POST["experiencia"]."',
	'funciones',
	'".$_POST["tipodecontrato"]."',
	'".$_POST["sueldo"]."',
	'".$_POST["diasalaborar"]."',
	'".$_POST["horario"]."',
	'',
	'',
	'Guadalupe Rojas,	TEL: 5636 0570,	grojas@mctree.com.mx','delegacion',
	'".$_POST["ciudad"]."',
	'".$_POST["rutas"]."',
	'Si',
	'activo',
	'',
	'".$_POST["observaciones"]."');");exit;
	
	mysqli_query($con, "INSERT INTO vacantes VALUES (
	0,
	now(),
	'".$_POST["promocion"]."',
	'".$_POST["puesto"]."',
	'".$_POST["puestos"]."',
	'".$_POST["descorta"]."',
	'".$_POST["despuesto"]."',
	'',
	'".$_POST["escolaridad"]."',
	'".$_POST["edad"]."',
	'".$_POST["sexo"]."',
	'".$_POST["experiencia"]."',
	'funciones',
	'".$_POST["tipodecontrato"]."',
	'".$_POST["sueldo"]."',
	'".$_POST["diasalaborar"]."',
	'".$_POST["horario"]."',
	'',
	'',
	'Guadalupe Rojas,	TEL: 5636 0570,	grojas@mctree.com.mx','delegacion',
	'".$_POST["ciudad"]."',
	'".$_POST["rutas"]."',
	'Si',
	'activo',
	'',
	'".$_POST["observaciones"]."');");

	
		//header("Location:folio.php");
?>
<?php
$host="72.167.45.26";
$usuario="alfred";
$password="aaabcde1409";
$con=mysqli_connect($host, $usuario, $password)or die("Error al conectar con BD ".mysqli_error());
mysqli_set_charset($con, 'utf8');
mysqli_select_db($con, "agencia_app")or die("Error al seleccionar la BD ".mysqli_error());
?>
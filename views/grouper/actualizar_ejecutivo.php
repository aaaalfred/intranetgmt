<?php
session_start();
if(!isset($_SESSION['login_gmt'])) {
		header('Location: ../../login.php');
		exit();
}

$views = "../";
include ("$views../actions/conexion.php");

$id = $_GET['id'];
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];
$usuario = $_POST['usuario'];
$password = $_POST['password'];
$correo = $_POST['correo'];
$claves = isset($_POST['claves']) ? $_POST['claves'] : array();

if (empty($claves)) {
		$_SESSION['error'] = "Debe seleccionar al menos una clave.";
		header("Location: editar_ejecutivo.php?id=$id");
		exit();
}

$claves_string = implode(',', $claves);

$query = mysqli_prepare($con, "UPDATE credenciales SET nombre=?, tipo=?, usuario=?, password=?, correo=?, clave=? WHERE id=?");
mysqli_stmt_bind_param($query, "ssssssi", $nombre, $tipo, $usuario, $password, $correo, $claves_string, $id);
$result = mysqli_stmt_execute($query);

if($result) {
		$_SESSION['success'] = "Ejecutivo actualizado correctamente.";
} else {
		$_SESSION['error'] = "Error al actualizar el ejecutivo.";
}

header("Location: ejecutivos.php");
exit();
?>
<?php 
session_start();
include('../../actions/conexion.php');

if (!isset($_POST['claves']) || empty($_POST['claves'])) {
    echo "Error: Debe seleccionar al menos una clave.";
    exit;
}

$variables = implode(",", $_POST['claves']);

$sql = "INSERT INTO credenciales (id, nombre, rol, clave, usuario, password, correo, ejecutivo, tipo) 
        VALUES (0, ?, 'EJECUTIVO', ?, ?, ?, ?, ?, ?)";

$stmt = $con->prepare($sql);
$stmt->bind_param("sssssss", 
    $_POST['nombre'],
    $variables,
    $_POST['usuario'],
    $_POST['password'],
    $_POST['correo'],
    $_SESSION['id_gmt'],
    $_POST['rol']
);

if($stmt->execute()){
    header("Location: ejecutivos.php");
} else {
    echo "Error al insertar: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
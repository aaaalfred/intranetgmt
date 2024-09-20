<?php 
include ("../../actions/conexion.php");

$sql = "";

$id = mysqli_real_escape_string($con, $_POST['id']);
$nombre = mysqli_real_escape_string($con, $_POST['nombre']);
$app = mysqli_real_escape_string($con, $_POST['app']);
$apm = mysqli_real_escape_string($con, $_POST['apm']);
$telefono = mysqli_real_escape_string($con, $_POST['telefono']);
$correo = mysqli_real_escape_string($con, $_POST['correo']);
$fecha_nacimiento = mysqli_real_escape_string($con, $_POST['fecha_nacimiento']);
$sexo = mysqli_real_escape_string($con, $_POST['sexo']);
$estado = mysqli_real_escape_string($con, $_POST['estado']);
$curp = mysqli_real_escape_string($con, $_POST['curp']);
$rfc = mysqli_real_escape_string($con, $_POST['rfc']);
$cp = mysqli_real_escape_string($con, $_POST['cp']);
$nss = mysqli_real_escape_string($con, $_POST['nss']);
$clabe = mysqli_real_escape_string($con, $_POST['clabe']);
$banco = mysqli_real_escape_string($con, $_POST['banco']);
$no_cuenta = mysqli_real_escape_string($con, $_POST['no_cuenta']);
$clave_ejecutivo = mysqli_real_escape_string($con, $_POST['clave_ejecutivo']);
$regimen = mysqli_real_escape_string($con, $_POST['regimen']);
$estatus = mysqli_real_escape_string($con, $_POST['estatus']);


// Determina el SQL en función del estatus
if($estatus == "Inactivo"){
    $sql = "UPDATE usuarios 
            SET nombre = '$nombre', 
                app = '$app', 
                apm = '$apm', 
                telefono = '$telefono', 
                correo = '$correo', 
                fecha_nacimiento = '$fecha_nacimiento', 
                sexo = '$sexo', 
                estado = '$estado', 
                curp = '$curp', 
                rfc = '$rfc', 
                cp = '$cp', 
                nss = '$nss', 
                clabe = '$clabe', 
                banco = '$banco', 
                no_cuenta = '$no_cuenta', 
                clave_ejecutivo = '', 
                regimen_fiscal = '$regimen', 
                estatus = '$estatus', 
                autorizado = null, 
                autorizado_dos = null 
            WHERE id = $id;";
			
}else{
    $sql = "UPDATE usuarios 
            SET nombre = '$nombre', 
                app = '$app', 
                apm = '$apm', 
                telefono = '$telefono', 
                correo = '$correo', 
                fecha_nacimiento = '$fecha_nacimiento', 
                sexo = '$sexo', 
                estado = '$estado', 
                curp = '$curp', 
                rfc = '$rfc', 
                cp = '$cp', 
                nss = '$nss', 
                clabe = '$clabe', 
                banco = '$banco', 
                no_cuenta = '$no_cuenta', 
                clave_ejecutivo = '$clave_ejecutivo', 
                regimen_fiscal = '$regimen', 
                estatus = '$estatus' 
            WHERE id = $id;";
}

$rec = mysqli_query($con, $sql);

header("location: perfil.php?id=$id&curp=$curp&vista=".$_POST['vista']);
?>

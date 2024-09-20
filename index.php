<?php
//archivo con un solo usort
//direccionar al login al acceder a la raiz /admin-gmt
session_start();
if(isset($_SESSION['login_gmt']))
{
	header('Location: ./views/index.php');
}else {
    header('Location: login.php');
}

?>
<?php 
	session_start();
	$curp = $_GET['curp'];
	var_dump($curp);exit;
	$output = shell_exec("\"C:\\Python38\\python.exe\" \"curp.py\" 2>&1 \"$curp\"");
	echo $output;
	//miVariable = sys.argv[1]
	//sleep(5);
	//echo $cadena;
	//header("location:recibos.php");

?>
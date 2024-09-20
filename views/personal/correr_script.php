<?php 
	session_start();
	$tipo = $_GET['tipo'];
	//$output = shell_exec("\"C:\\Python38\\python.exe\" \"recibos.py\" 2>&1");
	//$comando = "C:\\Python38\\python.exe script.py \"$tipo\"";
	//$comando = "C:\\Python38\\python.exe recibos.py \"$tipo\"";
	//$output = shell_exec($comando);
	$output = shell_exec("\"C:\\Python38\\python.exe\" \"recibos.py\" 2>&1 \"$tipo\"");
	echo $output;
	//miVariable = sys.argv[1]
	//sleep(5);
	//echo $cadena;
	//header("location:recibos.php");

?>
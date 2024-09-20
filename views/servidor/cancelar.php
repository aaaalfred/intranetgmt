<?php
session_start();
include ("../../actions/conexion.php");
	
	mysqli_query($con, "update solicitud set observaciones='".$_POST["observaciones"]."', autorizado='CANCELADA', fautorizacion= now(), status='CANCELADA' WHERE id= '".$_POST["id"]."';");

	header('Content-Type: text/html; charset=UTF-8');
	$sqlvisita=mysqli_query($con, "SELECT * FROM solicitud WHERE id=".$_POST["id"].";");
	$reg_visita=mysqli_fetch_array ($sqlvisita);
	$quiensolicito=$reg_visita ["idUsuario"];

	$sqlusuario = mysqli_query($con, "SELECT * FROM credenciales where id='".$quiensolicito."';");
	$ejecutivo= mysqli_fetch_array ($sqlusuario);
	$correoejecutivo=$ejecutivo ["correo"];
	$nodesolicitud=$_POST["id"];
	$observaciones=$_POST["observaciones"];
	
	require "../../assets/includes/class.phpmailer.php";
	
	$mail = new phpmailer();
	$mail->PluginDir = "includes/";
	$mail->Mailer = "smtp";
	$mail->Host = "smtp.uservers.net";
	$mail->SMTPAuth = true;
	$mail->Username = "solicitud@mctree.com.mx"; 
	$mail->Password = "15S09cheque";
	//$mail->From = "solicitud@mctree.com.mx";
	$mail->From = "sescobar@mctree.com.mx";
	$mail->FromName = "FONDOS"; 
	$mail->Timeout=10;
	//Comentados para hacer pruebas
	/*$mail->AddAddress("$correoejecutivo");
	$mail->AddAddress("iantonio@mctree.com.mx");
	$mail->AddAddress("mmolina@mctree.com.mx");
	$mail->AddAddress("gcardenas@mctree.com.mx");
	$mail->AddBCC("info@mctree.com.mx");*/
	//correo para las pruebas
	$mail->AddAddress("sescobar@mctree.com.mx");
	//$mail -> AddReplyTo ("$correoejecutivo");
	$mensaje = 'Estimado ';
	$mail->Subject = "SOLICITUD $nodesolicitud";
	/*$mail->Body = "SE HA CANCELADO LA SOLICITUD $nodesolicitud ".'<br><br>'."PRESUPUESTO $nopresupuesto ; $nomPresupuesto".'<br><br>'. "IMPORTE $$importe".'<br><br>'
	."PARA $concepto".
	'<br><br>'.
	'CONSULTAR <a href="http://72.167.45.26/intranet/mis_solicitudes.php">MIS SOLICITUDES</a>'.
	'<br><br>'.
	'<div align="center"><img src="https://c4.staticflickr.com/8/7649/16983049650_79488bacfe_n.jpg"></div><br>'
	;*/
	$mail->Body = '
		<table class="body-wrap" style="box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;" bgcolor="transparent">
                            <tr>
                                <td valign="top"></td>
                                <td class="container" width="600" style="display: block !important; max-width: 600px !important; clear: both !important;" valign="top">
                                    <div class="content" style="padding: 20px;">
                                        <table class="main" width="100%" cellpadding="0" cellspacing="0" style="border: 1px dashed #4d79f6;">
                                            <tr>
                                                <td class="content-wrap aligncenter" style="padding: 20px; background-color: transparent;" align="center" valign="top">
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <!-- <a href="#"><img src="assets/images/logo-sm.png" alt="" style="height: 40px; margin-left: auto; margin-right: auto; display:block;"></a> -->
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block" style="padding: 0 0 20px;" valign="top">
                                                                <h2 class="aligncenter" style="font-size: 24px; color:#98a2bd; line-height: 1.2em; font-weight: 600; text-align: center;" align="center">SE HA CANCELADO LA SOLICITUD<span style="color: #4d79f6; font-weight: 700;"> #'.$nodesolicitud.'</span></h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block aligncenter" style="padding: 0 0 20px;" align="center" valign="top">
                                                                <table class="invoice" style="width: 80%;">
                                                                    <tr>
                                                                        <td style="font-size: 14px; padding: 5px 0;" valign="top">
																			<br/>Motivo: '.$observaciones.'
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        
                                                    </table><!--end table-->   
                                                </td>
                                            </tr>
                                        </table><!--end table-->                                               
                                    </div><!--end content-->   
                                </td>
                                <td style="font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                            </tr>
                        </table>
	';

	$mail->AltBody = "mensaje";
	$mail->CharSet = "UTF-8";
	$exito = $mail->Send();
	$intentos=1; 
	while ((!$exito) && ($intentos < 5)) {
		sleep(5);
		$exito = $mail->Send();
		$intentos=$intentos+1;	
	}
	
	header("Location: http://72.167.45.26/admin-gmt/views/presupuestos/mis_solicitudes.php");
?>
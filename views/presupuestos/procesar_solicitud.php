<?php
session_start();
if(!isset($_SESSION['login_gmt']))
{
	header("location:../../login.php");
}
else
{
	include('../../actions/conexion.php');
	
	$empresa = $_POST["empresa"];
	$rfc = $_POST["rfc"];
	$aplica = $_POST["aplica"];
	$claveppto = $_POST["clave"];
	$nombrePpto = $_POST["presupuesto"];
	$solicita = $_POST["solicitadopor"];
	$beneficiario = $_POST["beneficiario"];
	$fechapago = $_POST["fechapago"];
	$concepto = $_POST["concepto"];
	$comprobable = $_POST["comprobable"];
	$mesqaplica = $_POST["mesaplica"];
	$importe = $_POST["importe"];
	$desgloce = $_POST["desgloce"];
	$formaPago = $_POST["formaPago"];
	$banco = $_POST["banco"];
	$cuenta = $_POST["cuenta"];
	$mismoconcepto = $_POST["mismoconcepto"];
	$equivalencia = $_POST["equivalencia"];
	$ejecutivo = $_POST["ejecutivo"];
	
	//Trae el nombre del cliente
	$idcliente = $_POST["idcliente"];
	$sqlnc = "SELECT nombre FROM cliente WHERE id = '$idcliente';";
	$resnc = mysqli_query($con, $sqlnc);
	if($rownc= mysqli_fetch_array($resnc)){
		$nombrecliente=$rownc["nombre"];
	}
	
	//Hace el insert de la solicitud y se guarda el ultimo id
	$usuario_id= $_SESSION['id'];
	$sqls = "INSERT INTO solicitud VALUES(0, NOW(), '$solicita', '$claveppto', '', '$aplica', '$concepto', '$beneficiario', '$rfc', '$importe', '$desgloce', $usuario_id, '$ejecutivo', '$fechapago', '$mesqaplica', NULL, '', $idcliente, 0, '$cuenta', '$formaPago', '$banco', '', '$empresa', '$mismoconcepto', '$equivalencia', 0, 0, 0, '', '$comprobable', '', '', NULL );";
	//var_dump($sqls);exit;
	mysqli_query($con, $sqls)OR DIE("Error al insertar inf en DB");
	$id_solicitud=mysqli_insert_id($con);
	
	//con base al ultimo id /*$idsolicitud*/ se hace esta nueva consulta que la usa para traer la fecha solicitud
	//anteriormente la consulta era SELECT id,fecha FROM solicitud ORDER BY solicitud.id DESC LIMIT 1
	//pero en ocaciones no tomaba el id de la solicitud que era.
	$sqlf="SELECT id,fecha FROM solicitud WHERE solicitud.id = $id_solicitud;";
	$resf = mysqli_query($con, $sqlf);
	if($rowf= mysqli_fetch_array($resf))
	{
		$fecha_solicitud=$rowf["fecha"];
	}
	
	//Obtiene el pdf del presupuesto
	$sqlpdf = "SELECT pdf FROM presupuesto WHERE clavePpto = '$claveppto';";
	$respdf = mysqli_query($con, $sqlpdf);
	if($rowpdf= mysqli_fetch_array($respdf)){$pdf=$rowpdf["pdf"];}
	
	//Datos de usuario
	$sqldu = "SELECT id,correo,nombre FROM credenciales WHERE id = '$usuario_id'";
	$resdu = mysqli_query($con, $sqldu);	
	if($rowdu= mysqli_fetch_array($resdu)){
		$correo=$rowdu["correo"];
			$nombre=$rowdu["nombre"];
	}
	
	

	// primero hay que incluir la clase phpmailer para poder instanciar
	//un objeto de la misma
	require "../../assets/includes/class.phpmailer.php";

	//instanciamos un objeto de la clase phpmailer al que llamamos 
	//por ejemplo mail
	$mail = new phpmailer();

	//Definimos las propiedades y llamamos a los métodos 
	//correspondientes del objeto mail

	//Con PluginDir le indicamos a la clase phpmailer donde se 
	//encuentra la clase smtp que como he comentado al principio de 
	//este ejemplo va a estar en el subdirectorio includes
	$mail->PluginDir = "includes/";

	//Con la propiedad Mailer le indicamos que vamos a usar un 
	//servidor smtp
	$mail->Mailer = "smtp";

	//Asignamos a Host el nombre de nuestro servidor smtp
	$mail->Host = "smtp.uservers.net";

	//Le indicamos que el servidor smtp requiere autenticación
	$mail->SMTPAuth = true;

	//Le decimos cual es nuestro nombre de usuario y password
	$mail->Username = "solicitud@mctree.com.mx"; 
	$mail->Password = "15S09cheque";

	//Indicamos cual es nuestra dirección de correo y el nombre que 
	//queremos que vea el usuario que lee nuestro correo
	$mail->From = "solicitud@mctree.com.mx";
	$mail->FromName = "Grupo Mctree";

	//el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar 
	//una cuenta gratuita, por tanto lo pongo a 30  
	$mail->Timeout=10;

	//Indicamos cual es la dirección de destino del correo
	//$mail->AddAddress("$correo");
	//$mail->AddAddress("gcardenas@mctree.com.mx");
	//$mail->AddAddress("aambriz@mctree.com.mx");
	$mail->AddAddress("sescobar@mctree.com.mx");
	//$mail -> AddReplyTo ("$correoejecutivo");
	
	//comentado porque ya se envia a aambriz, no tiene sentido enviarse doble
	/*if($idcliente == 58)
		{
			$mail->AddAddress("aambriz@mctree@mctree.com.mx");
		}*/
	/*if(($idcliente == 18)OR($idcliente == 25)OR($idcliente == 75)OR($idcliente == 100))
		{
			$mail->AddAddress("egarcia@mctree.com.mx");
			$mail -> AddReplyTo ("egarcia@mctree.com.mx");
		}
	if($idcliente == 6)
		{
			$mail->AddAddress("cceledon@ibtl.mx");
			$mail->AddAddress("jgutierrez@ibtl.mx");
		}
	if(($idcliente == 7)OR($idcliente == 69)OR($idcliente == 82))
		{
			$mail->AddAddress("rjuarez@mctree.com.mx");
		}
	if(($idcliente == 64)OR($idcliente == 77)OR($idcliente == 87)OR($idcliente == 104)OR($idcliente == 107))
		{
			$mail->AddAddress("sgalvan@mctree.com.mx");
		}
	if($idcliente == 31)
		{
			$mail->AddAddress("hortiz@mctree.com.mx");
		}*/			
	//Asignamos asunto y cuerpo del mensaje
	//El cuerpo del mensaje lo ponemos en formato html, haciendo 
	//que se vea en negrita
	$mensaje = 'Estimado ';
	$mail->Subject = "DE $nombre";
	
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
                                                                <h2 class="aligncenter" style="font-size: 24px; color:#98a2bd; line-height: 1.2em; font-weight: 600; text-align: center;" align="center">Solicitud <span style="color: #4d79f6; font-weight: 700;">#'.$id_solicitud.'</span></h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block aligncenter" style="padding: 0 0 20px;" align="center" valign="top">
                                                                <table class="invoice" style="width: 80%;">
                                                                    <tr>
                                                                        <td style="font-size: 14px; padding: 5px 0;" valign="top">Solicito: '.$nombre.'
                                                                            <br/>Fecha de solicitud: '.$fecha_solicitud.'
                                                                            <br/>Empresa: '.$empresa.'
																			<br/>RFC: '.$rfc.'
																			<br/>Cliente: '.$nombrecliente.'
																			<br/>Presupuesto: '.$nombrePpto.'
																			<br/>Clave de presupuesto: '.$claveppto.'
                                                                        </td>
                                                                    </tr>
																	<tr>
																		<td align="center"><a style="background-color: white; color: black; border: 2px solid #4CAF50; text-decoration: none; padding: 5px;" href="http://72.167.45.26/admin-gmt/presupuestos/'."$pdf".'">ARCHIVO</a></td>
																	</tr>
                                                                    <tr>
                                                                        <td style="padding: 5px 0;" valign="top">
                                                                            <table class="invoice-items" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Aplica a presupuesto</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$aplica.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Forma de pago</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$formaPago.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Banco</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$banco.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Numero de cuenta</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$cuenta.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Beneficiario</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$beneficiario.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Fecha de pago</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$fechapago.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Mes en que aplica gasto</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$mesqaplica.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Concepto</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$concepto.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Mismo concepto</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$mismoconcepto.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Equivalencia</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$equivalencia.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Es comprobable</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$comprobable.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Importe</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> $'.$importe.'</td>
                                                                                </tr>
																				
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                <a href="http://72.167.45.26/admin-gmt/views/servidor/servidor.php?id='."$id_solicitud".'&clave='."$claveppto".'&clave='."$claveppto".'&status=CANCELADA&tipo=1E" style="font-size: 14px; color: #4d79f6; text-decoration: none; margin: 0;">SI EXISTE UN ERROR EN LA SOLICITUD, DA CLICK AQUI PARA CANCELAR</a>
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

		//función para generar tokens únicos
		function generarToken() { return bin2hex(random_bytes(16)); }
		
		//genera y almacena un token en la base de datos junto con la información del correo
		$token = generarToken(); 
		// Conexión a la base de datos y almacenamiento del token 
		// Asegúrate de escapar adecuadamente los valores de las variables para evitar inyección SQL 
		$query = "INSERT INTO correos_enviados (fecha, token, destinatario) VALUES (NOW(), '$token', 'sescobar@mctree.com.mx');"; 
		$result = mysqli_query($con, $query); 
		
		//Envía el correo y actualiza el estado del token en la base de datos
		//Definimos AltBody por si el destinatario del correo no admite email con formato html 
		$mail->AltBody = "mensaje";
		$mail->CharSet = "UTF-8";
		//Se hace el primer proceso de enviar correo
		$exito = $mail->Send();
		// Si el correo se envió correctamente, actualiza el estado del token en la base de datos 
		if ($exito) {
			$query3 = "UPDATE correos_enviados SET enviado = 1 WHERE token = '$token'";
			$result3 = mysqli_query($con, $query3);
			echo "<br><br><br><font style='font-size:20px' color='#FFFFFF' face='Arial'><B>Solicitud enviada correctamente</B></font>";
		}else{
			
			//verifica si el token ya se ha utilizado antes de intentar enviar el correo
			$query2 = "SELECT enviado FROM correos_enviados WHERE token = '$token';";
			$result2 = mysqli_query($con, $query2);
			$row = mysqli_fetch_assoc($result2);
			// Si el correo ya se ha enviado, se detiene el script
			if ($row['enviado'] == null OR $row['enviado'] == ""){
				$intentos = 1;
				while ((!$exito) && ($intentos < 5))
				{
					
					sleep(5);
					$exito = $mail->Send();
					$intentos = $intentos + 1;
				}
			}
			if ($exito) {
				$query3 = "UPDATE correos_enviados SET enviado = 1 WHERE token = '$token'";
				$result3 = mysqli_query($con, $query3);
				echo "<br><br><br><font style='font-size:20px' color='#FFFFFF' face='Arial'><B>Solicitud enviada correctamente</B></font>";
			}else{
				echo "<font style='font-size:20px' color='#FFFFFF' face='Arial'>Problemas enviando la solicitud";
				echo "<br/>".$mail->ErrorInfo;
			}
		}

	$mail2 = new phpmailer();
	$mail2->PluginDir = "includes/";
	$mail2->Mailer = "smtp";
	$mail2->Host = "smtp.uservers.net";
	$mail2->SMTPAuth = true;
	$mail2->Username = "solicitud@mctree.com.mx"; 
	$mail2->Password = "15S09cheque";
	$mail2->From = "solicitud@mctree.com.mx";
	$mail2->FromName = "Grupo Mctree";
	$mail2->Timeout=10;
	//$mail2->AddAddress("iantonio@mctree.com.mx");
	//$mail2->AddAddress("mmolina@mctree.com.mx");
	$mail2->AddAddress("sescobar@mctree.com.mx");
	//$mail->AddAddress("aambriz@mctree.com.mx");
		
	//Comentado porque el correo es invalido
	//$mail2->AddAddress("aambriz@mctree@mctree.com.mx");


		
		
		

	//$mail2->AddBCC("info@mctree.com.mx");
	//if($importe >= 1000){$mail2->AddAddress("dbala@mctree.com.mx");}
	$mensaje = 'Estimado ';
	$mail2->Subject = "DE $nombre";

	$mail2->Body = '
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
                                                                <h2 class="aligncenter" style="font-size: 24px; color:#98a2bd; line-height: 1.2em; font-weight: 600; text-align: center;" align="center">Solicitud <span style="color: #4d79f6; font-weight: 700;">#'.$id_solicitud.'</span></h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block aligncenter" style="padding: 0 0 20px;" align="center" valign="top">
                                                                <table class="invoice" style="width: 80%;">
                                                                    <tr>
                                                                        <td style="font-size: 14px; padding: 5px 0;" valign="top">Solicito: '.$nombre.'
                                                                            <br/>Fecha de solicitud: '.$fecha_solicitud.'
                                                                            <br/>Empresa: '.$empresa.'
																			<br/>RFC: '.$rfc.'
																			<br/>Cliente: '.$nombrecliente.'
																			<br/>Presupuesto: '.$nombrePpto.'
																			<br/>Clave de presupuesto: '.$claveppto.'
                                                                        </td>
                                                                    </tr>
																	<tr>
																		<td align="center"><a style="background-color: white; color: black; border: 2px solid #4CAF50; text-decoration: none; padding: 5px;" href="http://72.167.45.26/admin-gmt/presupuestos/'."$pdf".'">ARCHIVO</a></td>
																	</tr>
                                                                    <tr>
                                                                        <td style="padding: 5px 0;" valign="top">
                                                                            <table class="invoice-items" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Aplica a presupuesto</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$aplica.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Forma de pago</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$formaPago.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Banco</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$banco.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Numero de cuenta</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$cuenta.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Beneficiario</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$beneficiario.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Fecha de pago</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$fechapago.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Mes en que aplica gasto</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$mesqaplica.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Concepto</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$concepto.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Mismo concepto</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$mismoconcepto.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Equivalencia</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$equivalencia.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Es comprobable</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$comprobable.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Importe</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> $'.$importe.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Se autoriza: </td>
                                                                                </tr>
																				<tr>
																					<td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
																						<a href="http://72.167.45.26/admin-gmt/views/servidor/servidor.php?id='."$id_solicitud".'&clave='."$claveppto".'&status=SI&tipo=2D" style="font-size: 14px; color: #4d79f6; text-decoration: none; margin: 0;">SI</a>
																					</td>
																				</tr>
																				<tr>
																					<td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
																						<a href="http://72.167.45.26/admin-gmt/views/servidor/servidor.php?id='."$id_solicitud".'&clave='."$claveppto".'&status=NO&tipo=2D" style="font-size: 14px; color: #4d79f6; text-decoration: none; margin: 0;">NO</a>
																					</td>
																				</tr>
																				<tr>
																					<td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
																						<a href="http://72.167.45.26/admin-gmt/views/servidor/servidor.php?id='."$id_solicitud".'&clave='."$claveppto".'&status=CANCELADA&tipo=2D" style="font-size: 14px; color: #4d79f6; text-decoration: none; margin: 0;">CANCELAR</a>
																					</td>
																				</tr>
                                                                            </table>
                                                                        </td>
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
		   
		//proceso para el segundo correo
		//genera y almacena un token en la base de datos junto con la información del correo
		$tokend = generarToken(); 
		// Conexión a la base de datos y almacenamiento del token 
		// Asegúrate de escapar adecuadamente los valores de las variables para evitar inyección SQL 
		$queryd = "INSERT INTO correos_enviados (fecha, token, destinatario) VALUES (NOW(), '$tokend', 'sescobar@mctree.com.mx');"; 
		$resultd = mysqli_query($con, $queryd); 
		
		//Envía el correo y actualiza el estado del token en la base de datos
		//Definimos AltBody por si el destinatario del correo no admite email con formato html 
		$mail2->AltBody = "mensaje";
		$mail2->CharSet = "UTF-8";
		//Se hace el primer proceso de enviar correo
		$exito2 = $mail2->Send();
		// Si el correo se envió correctamente, actualiza el estado del token en la base de datos 
		if ($exito2) {
			$query3d = "UPDATE correos_enviados SET enviado = 1 WHERE token = '$tokend'";
			$result3d = mysqli_query($con, $query3d);
			echo "<br><br><br><font style='font-size:20px' color='#FFFFFF' face='Arial'><B>Solicitud enviada correctamente</B></font>";
		}else{
			
			//verifica si el token ya se ha utilizado antes de intentar enviar el correo
			$query2d = "SELECT enviado FROM correos_enviados WHERE token = '$tokend';";
			$result2d = mysqli_query($con, $query2d);
			$rowd = mysqli_fetch_assoc($result2d);
			// Si el correo ya se ha enviado, se detiene el script
			if ($rowd['enviado'] == null OR $rowd['enviado'] == ""){
				$intentosd = 1;
				while ((!$exito2) && ($intentosd < 5))
				{
					
					sleep(5);
					$exito2 = $mail2->Send();
					$intentosd = $intentosd + 1;
				}
			}
			if ($exito2) {
				$query3d = "UPDATE correos_enviados SET enviado = 1 WHERE token = '$tokend'";
				$result3d = mysqli_query($con, $query3d);
				echo "<br><br><br><font style='font-size:20px' color='#FFFFFF' face='Arial'><B>Solicitud enviada correctamente</B></font>";
			}else{
				echo "<font style='font-size:20px' color='#FFFFFF' face='Arial'>Problemas enviando la solicitud";
				echo "<br/>".$mail2->ErrorInfo;
			}
		}

}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Solicitud de Cheque</title>
<style type="text/css">
div#container
{
   width: 994px;
   position: relative;
   margin-top: 0px;
   margin-left: auto;
   margin-right: auto;
   text-align: left;
}
</style>
<style type="text/css">
body
{
   text-align: center;
   margin: 0;
   background-color: #556B2F;
   background-image: url(imagen/logo.png);
   color: #000000;
}
</style>
<body oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
<br><br><br>
<!-- <a href="../mis_solicitudes.php" style="text-decoration:none color:white;"><h3>Ir a mis solicitudes</h3></a> -->
<a style="background-color: transparent; color: white; border: 2px solid white; text-decoration: none; padding: 5px;" href="mis_solicitudes.php">Ir a mis solicitudes</a>
</body>
</html>
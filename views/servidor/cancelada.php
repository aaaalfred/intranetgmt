<?php
session_start();
include ("../../actions/conexion.php");
	
	header('Content-Type: text/html; charset=UTF-8');
	$sqlvisita=mysqli_query($con, "SELECT * FROM solicitud WHERE id=".$_REQUEST["id"].";");
	$reg_visita=mysqli_fetch_array ($sqlvisita);
	$elcliente=$reg_visita ["idCliente"];
	$clavepresupuesto=$reg_visita ["clave"];
	$quiensolicito=$reg_visita ["idUsuario"];

	$sqlpresupuesto=mysqli_query($con, "SELECT * FROM PRESUPUESTO WHERE clavePpto='".$clavepresupuesto."';");
	$reg_presupuesto=mysqli_fetch_array ($sqlpresupuesto);

	$concepto=$reg_visita ['concepto'];
	$nomPresupuesto=$reg_presupuesto ["nombrePpto"];
	$nopresupuesto=$reg_visita ["clave"];
	$importe=$reg_visita ["importe"];

	$sqlcliente=mysqli_query($con, "SELECT id,nombre FROM cliente WHERE id='".$elcliente."';");
	$cliente=mysqli_fetch_array ($sqlcliente);

	$sqlusuario = mysqli_query($con, "SELECT * FROM credenciales where id='".$quiensolicito."';");
	$ejecutivo= mysqli_fetch_array ($sqlusuario);
	$correoejecutivo=$ejecutivo ["correo"];

	$nodesolicitud=$_REQUEST["id"];
	
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
                                                                            <br/>Presupuesto: '.$nopresupuesto.' - '.$nomPresupuesto.'
                                                                            <br/>Importe: $'.$importe.'
																			<br/>Para: '.$concepto.'
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
																Consultar<br>
                                                                <a href="http://72.167.45.26/admin-gmt/views/presupuestos/mis_solicitudes.php" style="font-size: 14px; color: #4d79f6; text-decoration: none; margin: 0;">Mis solicitudes</a>
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
	
?>

<!DOCTYPE html>
		<html lang="en" dir="ltr">

		<head>
			

			<meta charset="utf-8" />
					<title>Cancelada</title>
					<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
					<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
					<meta content="" name="author" />
					<meta http-equiv="X-UA-Compatible" content="IE=edge" />

					<!-- App favicon -->
					<link rel="shortcut icon" href="../../assets/images/favicon.ico">

			   

			 <!-- App css -->
			 <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
			 <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
			 <link href="../../assets/css/app.min.css" rel="stylesheet" type="text/css" />

		</head>

		<body id="body" class="auth-page" style="background-image: url('../../assets/images/p-1.png'); background-size: cover; background-position: center center;">
		   <!-- Log In page -->
			<div class="container-md">
				<div class="row vh-100 d-flex justify-content-center">
					<div class="col-12 align-self-center">
						<div class="card-body">
							<div class="row" align="center">
								<div class="cl-mcont">
									<div class="row dash-cols">
										
									<div class="col-sm-12 col-md-12">
										<div class="block">
											<div class="header no-border" >
											<h1><?php echo $cliente ["nombre"]?><input type="hidden" name="idcliente"  value="<?php echo $cliente ["id"];?>"/></th></h1>
											</div>
											<br>
											<div>
												<table class="table">
													<thead>
														<tr>
															<th>EMPRESA</th>
															<th></th>
															<th>SOLICITO</th>
															<th></th>
															<th>FECHA EN QUE SE SOLICITO</th>
															<th></th>
															<th>PRESUPUESTO</th>
															<th></th>
															<th>No DE PRESUPUESTO</th>
														</tr>
														<tr>
															<th class="left"><span><?php echo $reg_visita ["empresa"]?></span></th>
															<th></th>
															<th class="left"><span><?php echo $reg_visita ["solicita"]?></span></th>
															<th></th>
															<th class="left"><span><?php echo $reg_visita ["fecha"]?></span></th>
															<th></th>
															<th class="left"><span><?php echo $reg_presupuesto ["nombrePpto"]?></span></th>
															<th></th>
															<th class="left"><span><?php echo $reg_visita ["clave"]?></span></th>
														</tr>

													</thead>
												</table>
											</div>	
										</div>
										<div class="col-md-4">
										</div>
										<div class="col-md-4">
											<div class="alert alert-danger">
												<i class="fa fa-check sign"></i><strong> SE HA CANCELADO</strong><h3>SOLICITUD <?php echo $reg_visita ["id"]?></h3>
											</div>
										</div>
										<div class="col-md-4">
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="block">
											<div class="content no-padding">
												<table class="table">
													<thead>
														<tr>
															<th>CONCEPTO</th>
															<th>APLICA A PRESUPUESTO</th>
															<th>EN QUE MES APLICA</th>
															<th>MISMO CONCEPTO</th>
															<th>EQUIVALENCIA</th>
														</tr>
														<tr>
															<th class="left"><span><?php echo $reg_visita ["concepto"]?></span></th>
															<th class="left"><span><?php echo $reg_visita ["aplica"]?></span></th>
															<th class="left"><span><?php echo $reg_visita ["mesqaplica"]?></span></th>
															<th class="left"><span><?php echo $reg_visita ["mismoconcepto"]?></span></th>
															<th class="left"><span><?php echo $reg_visita ["equivalencia"]?></span></th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="block">

												<div class="content no-padding">
												<table class="table">
												<thead>
													<tr>
														<th>FECHA DE PAGO</th>
														<th>BENEFICIARIO</th>
														<th>IMPORTE</th>
														<th>FORMA<br>DE PAGO</th>
														<th>CUENTA</th>
													</tr>
													<tr>
														<th class="left"><span><?php echo $reg_visita ["fechadepago"]?></span></th>
														<th class="left"><span><?php echo $reg_visita ["beneficiario"]?></span></th>
														<th class="left"><span>$<?php echo $reg_visita ["importe"]?></span></th>
														<th class="left"><span><?php echo $reg_visita ["formaPago"]?></span></th>
														<th class="left"><span><?php echo $reg_visita ["cuenta"]?></span></th>
													</tr>
												</thead>
												</table>
												</div>	
										</div>
									</div>
								</div>
								</div>
							</div><!--end row-->
						</div><!--end card-body-->
					</div><!--end col-->
				</div><!--end row-->
			</div><!--end container-->
			<!-- vendor js -->
			
			<script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
			<script src="../../assets/libs/simplebar/simplebar.min.js"></script>
			<script src="../../assets/libs/feather-icons/feather.min.js"></script>
			<!-- App js -->
			<script src="../../assets/js/app.js"></script>
			
		</body>

		</html>
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
									
									<div class="col-sm-8 col-md-12">
										<div class="block">
											<div class="header no-border" >
												<div class="col-sm-4 col-md-5">
													<div class="alert alert-danger">
													
													<i class="fa fa-check sign"></i><strong>SE CANCELARA LA SOLICITUD <?php echo $reg_visita ["id"]?></strong><h3></h3>
													</div>
												</div>
												<form name="Form1" method="post" action="cancelar.php">	
														<div class="form-group">
															<input type="hidden" name="id"  value="<?php echo $reg_visita ["id"];?>"/>
															<label class="col-sm-2 control-label">MOTIVO DE CANCELACION</label>
															<div class="col-sm-3">
																<textarea name="observaciones" id="TextConcepto" class="form-control" ></textarea></td>
															</div>
														</div>
														<br/>
												<input type="submit" name='Enviar' value="Cancelar" class="btn btn-danger btn-lg pull-left" >
												</form>
												<br/>
											</div>
										</div>
				 
									</div>
									
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
<?php

include ("../../actions/conexion.php");
	
	$datos = $_GET;	
	$elidentificador=$datos['id'];
	$clave=$datos['clave'];
	$status=$datos['status'];
	$tipo=$datos['tipo'];
	
	
	$sqlvisita=mysqli_query($con, "SELECT * FROM solicitud WHERE id=".$elidentificador." AND clave ='".$clave."';");
	$reg_visita=mysqli_fetch_array ($sqlvisita);
	$seautorizo=$reg_visita ["autorizado"];
	$elid=$reg_visita ["id"];
		
	if ($seautorizo =="SI"){
		$staus="AUTORIZO";
		}
	if ($seautorizo =="NO"){
		$staus="RECHAZO";
		}
	if ($seautorizo =="CANCELADA"){
		$staus="CANCELO";
		}
	if ($seautorizo ==""){
		$staus="SINSTATUS";
		}
	

	if ($seautorizo !=null OR $seautorizo != ""){
		//echo "La solicitud:", $elid ," previamente se ",$staus;
		?>
		<!DOCTYPE html>
		<html lang="en" dir="ltr">

		<head>
			

			<meta charset="utf-8" />
					<title>Status</title>
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
							<div class="row">
								<div class="col-lg-5 mx-auto">
									<div class="card">
										<div class="card-body p-0 auth-header-box">
											<div class="text-center p-3">
												<a href="index.html" class="logo logo-admin">
													<img src="../../assets/images/logo-transparent.png" height="200" alt="logo" class="auth-logo">
												</a>
												<h4 class="mt-3 mb-1 fw-semibold text-white font-18"></h4>   
												<p class="text-muted  mb-0"></p>  
											</div>
										</div>
										<div class="card-body">
											<div class="ex-page-content text-center">
												<!-- <img src="assets/images/error.svg" alt="0" class="" height="170">-->
												<h1 class="mt-5 mb-4"></h1>  
												<h5 class="font-16 text-muted mb-5"><?php echo "La solicitud ". $elid ." se ".$staus; ?></h5>                                    
											</div>          
											<!-- <a class="btn btn-primary w-100" href="index.html">Back to Dashboard <i class="fas fa-redo ml-1"></i></a> -->
										</div><!--end card-body-->
										<div class="card-body bg-light-alt text-center">
											&copy; <script>
												document.write(new Date().getFullYear())
											</script> McTree                                           
										</div><!--end card-body-->
									</div><!--end card-->
								</div><!--end col-->
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
		<?php
	}
	else
	{		
		if($status=="SI"){
			
			
			$eeelid=$datos['id'];
			echo $eeelid;
			$logs=mysqli_query($con, "INSERT INTO logs_solicitudes VALUES (0, NOW(), '$clave', '$status', '$tipo');");
			$actualiza=mysqli_query($con, "UPDATE solicitud SET autorizado='SI' , fautorizacion= now() WHERE id=".$eeelid.";");
			header('Location: http://72.167.45.26/admin-gmt/views/servidor/aceptada.php?id='.$eeelid);
			
			
		}else if($status=="NO"){
			
			
			$eeelid=$datos['id'];
			echo $eeelid;
			$logs=mysqli_query($con, "INSERT INTO logs_solicitudes VALUES (0, NOW(), '$clave', '$status', '$tipo');");
			$actualiza=mysqli_query($con, "UPDATE solicitud SET autorizado='NO' , fautorizacion= now() WHERE id=".$eeelid.";");
			header('Location: http://72.167.45.26/admin-gmt/views/servidor/rechazada.php?id='.$eeelid);
			
			
		} else if($status=="CANCELADA"){
			
			
			$eeelid=$datos['id'];
			echo $eeelid;
			$logs=mysqli_query($con, "INSERT INTO logs_solicitudes VALUES (0, NOW(), '$clave', '$status', '$tipo');");
			$actualiza=mysqli_query($con, "UPDATE solicitud SET autorizado='CANCELADA' , fautorizacion= now(), status='CANCELADA' WHERE id=".$eeelid.";");
			if($tipo == "2D"){
				header('Location: http://72.167.45.26/admin-gmt/views/servidor/cancelacion.php?id='.$eeelid);
			}else{
				header('Location: http://72.167.45.26/admin-gmt/views/servidor/cancelada.php?id='.$eeelid);
			}
			
			
		}
	}
?>
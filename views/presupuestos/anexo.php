<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
	//aqui llenamos la variable para saber si esta en views o en una carpeta dentro de views
	//Si esta en la raiz de view la variable esta vacia y si esta dentro de una carpeta de view la variable es ../
	
	$views = "../";
	
	include ("$views../actions/conexion.php");
	
	$hoy = date("d/m/y");
	$num_registros = mysqli_query($con, "SELECT * FROM PRESUPUESTO WHERE clavePpto='".$_REQUEST["clavePpto"]."';");
	
	$anio=date("y");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        

        <meta charset="utf-8" />
                <title>Anexo</title>
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
                <meta content="" name="author" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />

                <!-- App favicon -->
                <link rel="shortcut icon" href="<?php echo $views;?>../assets/images/favicon.png">

       

         <!-- App css -->
         <link href="<?php echo $views;?>../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
         <link href="<?php echo $views;?>../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
         <link href="<?php echo $views;?>../assets/css/app.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body id="body">
        <!-- leftbar-tab-menu -->
        <?php include ("../../actions/leftbar.php");?>
        <!-- end leftbar-tab-menu-->

        <!-- Top Bar Start -->
        <!-- Top Bar Start -->
        <div class="topbar">            
            <!-- Navbar -->
            <nav class="navbar-custom" id="navbar-custom">    
                <ul class="list-unstyled topbar-nav float-end mb-0">

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $views;?>../assets/images/users/user-4.jpg" alt="profile-user" class="rounded-circle me-2 thumb-sm" />
                                <div>
                                    <small class="d-none d-md-block font-11"><?php echo $_SESSION['rol_gmt']; ?></small>
                                    <span class="d-none d-md-block fw-semibold font-12"> <?php echo $_SESSION['nombre_gmt']; ?> <i
                                            class="mdi mdi-chevron-down"></i></span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#"><i class="ti ti-user font-16 me-1 align-text-bottom"></i> Perfil</a>
                            <div class="dropdown-divider mb-0"></div>
                            <a class="dropdown-item" href="<?php echo $views; ?>../actions/logout.php"><i class="ti ti-power font-16 me-1 align-text-bottom"></i> Cerrar sesión</a>
                        </div>
                    </li><!--end topbar-profile-->
                </ul><!--end topbar-nav-->
				<ul class="list-unstyled topbar-nav mb-0">                        
					<li>
						<button class="nav-link button-menu-mobile nav-icon" id="togglemenu">
							<i class="ti ti-menu-2"></i>
						</button>
					</li>                      
				</ul>
            </nav>
            <!-- end navbar-->
        </div>
        <!-- Top Bar End -->
        <!-- Top Bar End -->

        <div class="page-wrapper">

            <!-- Page Content-->
            <div class="page-content-tab">
                
				<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
							<form method="POST" action="insertar_anexo.php">
								<?php while($fila=mysqli_fetch_array($num_registros)){ ?>
								<div class="card-header">
									<h4 class="card-title">ANEXO</h4>
									<p class="text-muted mb-0">
									</p>
								</div><!--end card-header-->
								<div class="card-body">
									<br><br>
									<div class="row">
										<div class="col-md-3">
										</div>
										<div class="col-md-6">
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label class="col-form-label text-end">Anexo</label>
													<select class="form-select" name="anexo">
														<option></option>
														<option>1</option>
														<option>2</option>
														<option>3</option>
														<option>4</option>
														<option>5</option>
														<option>6</option>
														<option>7</option>
														<option>8</option>
														<option>9</option>
														<option>10</option>
													</select>
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="empresa" class="col-form-label text-end">Empresa</label>
													<input class="form-control" type="text" name="empresa" id="empresa" value='<?php echo $fila["empresa"];?>' readonly="">
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="nombre_presupuesto" class="col-form-label text-end">Nombre del presupuesto</label>
													<input class="form-control" type="text" name="nombre_presupuesto" id="nombre_presupuesto" value='<?php echo $fila["nombrePpto"];?>'>
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="clave_presupuesto" class="col-form-label text-end">Clave padre</label>
													<input class="form-control" type="text" name="clave_presupuesto" id="clave_presupuesto" value='<?php echo $_REQUEST["clavePpto"];?>' readonly>
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="cliente_presupuesto" class="col-form-label text-end">Cliente</label>
													<input class="form-control" type="text" name="cliente_presupuesto" id="cliente_presupuesto" value='<?php echo $fila["clientePpto"];?>'readonly>
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="descplan" class="col-form-label text-end">Descripción del plan</label>
													<input class="form-control" type="text" name="descplan" id="descplan" value='<?php echo $fila["clientePpto"];?>'readonly>
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="temporalidad" class="col-form-label text-end">Temporalidad</label>
													<input class="form-control" type="text" name="temporalidad" id="temporalidad" value='<?php echo $fila["temporalidad"];?>'readonly>
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10" align="center">
													<button type="submit" class="btn  btn-primary ">Enviar</button>
												</div>
											</div>
										</div>
										<div class="col-md-3">
										</div>
									</div>                
								</div><!--end card-body-->
								<br><br>
								<?php } ?>
							</form>
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
				
                <!--Start Footer-->
                <!-- Footer Start -->
                <footer class="footer text-center text-sm-start">
                    <span class="text-muted d-none d-sm-inline-block float-end">
					&copy; <script>
                        document.write(new Date().getFullYear())
                    </script> Grupo Mctree
					</span>
                </footer>
                <!-- end Footer -->                
                <!--end footer-->
            </div>
            <!-- end page content -->
        </div>
        <!-- end page-wrapper -->

        <!-- Javascript  -->  
        <!-- vendor js -->
        
        <script src="<?php echo $views;?>../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo $views;?>../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo $views;?>../assets/libs/feather-icons/feather.min.js"></script>

        <script src="<?php echo $views;?>../assets/libs/apexcharts/apexcharts.min.js"></script>
        <script src="<?php echo $views;?>../assets/js/pages/analytics-index.init.js"></script>
        <!-- App js -->
        <script src="<?php echo $views;?>../assets/js/app.js"></script>

    </body>
    <!--end body-->
</html>
<?php
}else {
    header("Location: ../../login.php");
}
?>
<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
	//aqui llenamos la variable para saber si esta en views o en una carpeta dentro de views
	//Si esta en la raiz de view la variable esta vacia y si esta dentro de una carpeta de view la variable es ../
	
	$views = "../";
	
	include ("$views../actions/conexion.php");
	
	$sqlvisita=mysqli_query($con, "SELECT * FROM reqpersonal WHERE id=".$_REQUEST["id"].";");
	$reg_visita=mysqli_fetch_array ($sqlvisita);
	
	$sqlpuestos=mysqli_query($con, "SELECT * FROM puestos;");
	
	$query_clientes =("SELECT id, pre, nombre FROM cliente order by nombre;");
	$clientes= mysqli_query ($con, $query_clientes);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        

        <meta charset="utf-8" />
                <title>Editar vacante</title>
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
							<form method="POST" action="insertar_spersonal.php">
								<div class="card-header">
									<h4 class="card-title">Editar vacante</h4>
									<p class="text-muted mb-0">
									</p>
								</div><!--end card-header-->
								<div class="card-body">
									<br><br>
									<div class="row">
										<div class="col-lg-6">
											<div class="mb-3 row">
												<div class="col-sm-10">
												<label for="promocion" class="col-form-label text-end">Promoción</label>
												<label class="form-control"><?php echo $reg_visita ["promocion"]?></label>
													<input class="form-control" size="16" type="hidden" step="any" name="promocion" value="<?php echo $reg_visita ["promocion"]?>" />
												</div>
											</div>
											<div class="mb-3 row">
												<!-- <label class="col-sm-2 col-form-label text-end">Cliente</label> -->
												<div class="col-sm-10">
												<label for="puesto" class="col-form-label text-end">Puesto</label>
													<input class="form-control" type="text" name="puesto" id="puesto">
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label class="col-form-label text-end">Tipo de encuesta</label>
													<!-- <select class="form-select" name="cliente" aria-label="Default select example"> -->
													<select class="form-select" name="puestos">
														<?php while ($fila = mysqli_fetch_array ($sqlpuestos))
														{
														echo "<option value='".$fila["id"]."'>".$fila["puesto"]." </option>";
														}
														?>
													  </select>
												</div>
											</div>
											<div class="mb-3 row">
												<!-- <label class="col-sm-2 col-form-label text-end">Cliente</label> -->
												<div class="col-sm-10">
												<label for="descorta" class="col-form-label text-end">Descripción corta</label>
													<input class="form-control" type="text" name="descorta" id="descorta">
												</div>
											</div>
											<div class="mb-3 row">
												<!-- <label class="col-sm-2 col-form-label text-end">Cliente</label> -->
												<div class="col-sm-10">
												<label for="despuesto" class="col-form-label text-end">Descripción del puesto</label>
													<textarea rows="3" class="form-control" type="text" name="despuesto" id="despuesto"></textarea>
												</div>
											</div>
											<div class="mb-3 row">
												<!-- <label class="col-sm-2 col-form-label text-end">Cliente</label> -->
												<div class="col-sm-10">
												<label for="observaciones" class="col-form-label text-end">Observaciones</label>
													<textarea rows="3" class="form-control" type="text" name="observaciones" id="observaciones"></textarea>
												</div>
											</div>
											<div class="mb-3 row">
												<!-- <label class="col-sm-2 col-form-label text-end">Cliente</label> -->
												<div class="col-sm-10">
												<label for="rutas" class="col-form-label text-end">Rutas</label>
													<textarea rows="3" class="form-control" type="text" name="rutas" id="rutas"></textarea>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label class="col-form-label text-end">Tipo de contrato</label>
													<select class="form-select" name="tipodecontrato" aria-label="Default select example">
														<option>Fijo</option>
														<option>Temporal</option>
													  </select>
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="sueldo" class="col-form-label text-end">Sueldo</label>
													<input class="form-control" type="text" name="sueldo" id="sueldo">
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="diasalaborar" class="col-form-label text-end">Dias a laborar</label>
													<input class="form-control" type="text" name="diasalaborar" id="diasalaborar">
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="horario" class="col-form-label text-end">Horario</label>
													<input class="form-control" type="text" name="horario" id="horario">
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="escolaridad" class="col-form-label text-end">Escolaridad</label>
													<input class="form-control" type="text" name="escolaridad" id="escolaridad">
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="ciudad" class="col-form-label text-end">Ciudad</label>
													<input class="form-control" type="text" name="ciudad" id="ciudad">
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="edad" class="col-form-label text-end">Edad</label>
													<input class="form-control" type="text" name="edad" id="edad">
												</div>
											</div>
											<div class="mb-3 row">
												<div class="col-sm-10">
													<label for="sexo" class="col-form-label text-end">Sexo</label>
													<input class="form-control" type="text" name="sexo" id="sexo">
												</div>
											</div>
											<div class="mb-3 row">
												
												<div class="col-sm-10">
													<label for="experiencia" class="col-form-label text-end">Experiencia</label>
													<input class="form-control" type="text" name="experiencia" id="experiencia">
												</div>
											</div>
										</div>
									</div>                                                                      
								</div><!--end card-body-->
								<div align="center">
									<button type="submit" class="btn  btn-primary " style="width: 30%;">Enviar</button>
								</div>
								<br><br>
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
    header("Location: $views../login.php");
}
?>
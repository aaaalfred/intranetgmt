<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
	//aqui llenamos la variable para saber si esta en views o en una carpeta dentro de views
	//Si esta en la raiz de view la variable esta vacia y si esta dentro de una carpeta de view la variable es ../
	
	$views = "../";
	
	include ("$views../actions/conexion.php");
	$solicitud = $_GET['solicitud'];
	
	$solicitudes=mysqli_query($con, "SELECT * FROM comprobacion WHERE no_solicitud = $solicitud;");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        

        <meta charset="utf-8" />
                <title>Detalle</title>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Detalle solicitud <?php echo $solicitud; ?></h4>
                                <p class="text-muted mb-0">
                                    
                                </p>
                            </div><!--end card-header-->
                            <div class="card-body">
                                <div class="table-responsive">
									<table class="table table-striped" id="datatable_1">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
											<th>FECHA</th>
											<th>CONCEPTO</th>
											<th>COMENTARIO</th>
											<th>PDF</th>
											<th>XML</th>
											<th>FECHA TIMBRADO</th>
											<th>FORMA PAGO</th>
											<th>SUBTOTAL</th>
											<th>TOTAL</th>
											<th>METODO PAGO</th>
											<th>UUID</th>
											<th>RFC EMISOR</th>
											<th>NOMBRE EMISOR</th>
											<th>REGIMEN EMISOR</th>
											<th>RFC RECEPTOR</th>
											<th>NOMBRE RECEPTOR</th>
											<th>REGIMEN RECEPTOR</th>
											<th>USO CFDI</th>
											<th>DESCRIPCION</th>
											<th>RETENCIONES IVA</th>
											<th>RETENCIONES ISR</th>
											<th>IVA 16</th>
											<th>IVA 8</th>
											<th>IVA 0</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                         <?php
										 while ($fila=mysqli_fetch_array($solicitudes))
										{
										?>
											<tr>
												<td><a href="javascript:;"><?php echo $fila["id"];?></a></td>
												<td><a><?php echo $fila ["fecha"]; ?></a></td>
												<td><a><?php echo $fila ["concepto"]; ?></td>
												<td><a><?php echo $fila ["comentario"]; ?></a></td>
												<td>
												<?php if(isset($fila['pdf'])){ ?>
												<a href="http://72.167.45.26/<?php echo $fila['pdf'];?>" target="_blank">Ver archivo</a>
												<?php }else{ ?>
												<a>No hay archivo</a>
												<?php } ?>
												</td>
												<td>
												<?php if(isset($fila['xml'])){ ?>
												<a href="http://72.167.45.26/<?php echo $fila['xml'];?>" target="_blank">Ver archivo</a>
												<?php }else{ ?>
												<a>No hay archivo</a>
												<?php } ?>
												</td>
												<td><?php echo $fila["fechatimbrado"]; ?></td>
												<td><?php echo $fila["formapago"]; ?></td>
												<td><?php echo $fila["subtotal"]; ?></td>
												<td><?php echo $fila["total"]; ?></td>
												<td><?php echo $fila["metodopago"]; ?></td>
												<td><?php echo $fila["uuid"]; ?></td>
												<td><?php echo $fila["rfc_emisor"]; ?></td>
												<td><?php echo $fila["nombre_emisor"]; ?></td>
												<td><?php echo $fila["regimen_emisor"]; ?></td>
												<td><?php echo $fila["rfc_receptor"]; ?></td>
												<td><?php echo $fila["nombre_receptor"]; ?></td>
												<td><?php echo $fila["regimen_receptor"]; ?></td>
												<td><?php echo $fila["usocfdi"]; ?></td>
												<td><?php echo $fila["descripcion"]; ?></td>
												<td><?php echo $fila["retenciones_iva"]; ?></td>
												<td><?php echo $fila["retenciones_isr"]; ?></td>
												<td><?php echo $fila["iva_16"]; ?></td>
												<td><?php echo $fila["iva_8"]; ?></td>
												<td><?php echo $fila["iva_0"]; ?></td>
											</tr>
										<?php
										}
										?> 
                                        </tbody>
                                    </table><!--end /table-->
                                </div><!--end /tableresponsive-->
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div><!-- container -->
                 
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
    header('Location: ../../login.php');
}
?>
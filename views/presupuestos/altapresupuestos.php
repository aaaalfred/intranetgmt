<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
	//aqui llenamos la variable para saber si esta en views o en una carpeta dentro de views
	//Si esta en la raiz de view la variable esta vacia y si esta dentro de una carpeta de view la variable es ../
	
	$views = "../";
	
	include ("../../actions/conexion.php");
	
	$num_pdv =("SELECT id, pre, nombre FROM cliente WHERE activos='SI'order by nombre;");
	$pdv= mysqli_query ($con, $num_pdv);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        

        <meta charset="utf-8" />
                <title>Alta de presupuestos</title>
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
            <div class="page-content-tab" style="display: flex; align-items: center;">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Alta de presupuesto</h4>
									<p class="text-muted mb-0">
									
									</p>
								</div><!--end card-header-->
								<div class="card-body"> 
									<form method="post" action="insertar_altapre.php">
										<div class="row">
											<div class="col-lg-6"> 
												<div class="mb-3 row">
													<label class="col-sm-2 col-form-label text-end">Empresa</label>
													<div class="col-sm-10">
														<select class="form-select" name="empresa" aria-label="Default select example">
															<option selected>Selecciona una opción</option>
															<option value="MCTREE">MCTREE</option>
															<option value="IBTL">IBTL</option>
														  </select>
													</div>
												</div>
												<div class="mb-3 row">
													<label for="example-text-input" class="col-sm-2 col-form-label text-end">Presupuesto</label>
													<div class="col-sm-10">
														<input class="form-control" type="text"  id="nombre_presupuesto" name="nombre_presupuesto" placeholder="Nombre del presupuesto">
													</div>
												</div>
												<div class="mb-3 row">
													<label class="col-sm-2 col-form-label text-end">Cliente</label>
													<div class="col-sm-10">
														<select class="form-select" name="cliente_presupuesto" aria-label="Default select example">
															<option selected>Selecciona un cliente</option>
															<option>NUEVO</option>
															<?php while ($fila = mysqli_fetch_array ($pdv))
															{
															echo "<option value='".$fila["pre"]."-".$fila["id"]."'>".$fila["nombre"]." </option>";
															}
															?>
														  </select>
													</div>
												</div>
											</div>


											<div class="col-lg-6">
												<div class="mb-3 row">
													<label class="col-sm-2 col-form-label text-end">Plan <button type="button" class="btn btn-outline" style="size: 10px;" title="detalles" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="fa fa-info"></i></button>  </label>
													<div class="col-sm-10">
														<select class="form-select" name="plan" aria-label="Default select example">
															<option selected>Selecciona una decripción</option>
															<option>DD</option>
															<option>DFS</option>
															<option>PV</option>
															<option>PVFS</option>
															<option>PA</option>
															<option>MS</option>
															<option>PUO</option>
															<option>EDE</option>
															<option>AVP</option>
															<option>PH</option>
															<option>EPV</option>
															<option>EE</option>
															<option>UMIE</option>
															<option>LOG</option>
															<option>CBI</option>
															<option>CCA</option>
															<option>ADM</option>
															<option>VYG</option>
														  </select>
													</div>
												</div>
												<div class="mb-3 row">
													<label class="col-sm-2 col-form-label text-end" style="font-size: 12px;">Temporalidad</label>
													<div class="col-sm-10">
														<select class="form-select" name="temporalidad" aria-label="Default select example">
															<option selected>Selecciona una opción</option>
															<option value="F">Fijo</option>
															<option value="T">Temporal</option>
														  </select>
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10" align="center">
														<button class="btn btn-primary" type="submit">Enviar</button>
													</div>
												</div>											
											</div>
										</div>
									</form>
								</div><!--end card-body-->
							</div><!--end card-->
						</div><!--end col-->
					</div><!--end row-->
				</div>
            </div><!-- container -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Descripción de plan</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div><!--end modal-header-->
                                            <div class="modal-body">
                                                <div align="center">
                                                    <div class="col-lg-9" >
                                                        <table>
															<tr>
																<td><strong>DD</td><td><br>Demostradora, demoedecan, degustadora Diario<br><br></td>
															</tr>
															<tr>
																<td><strong>DFS</td><td><br>Demostradora, demoedecan, degustadora fin de semana o semana no completa<br><br></td>
															</tr>
															<tr>
																<td><strong>PV</td><td><br>Promo vendedor, Promodemostrador, vendedor<br><br></td>
															</tr>
															<tr>
																<td><strong>PVFS</td><td><br>Promo vendedor, Promodemostrador, vendedor fin de semana o semana no completa<br><br></td>
															</tr>
															<tr>
																<td><strong>PA</td><td><br>Promotor anaquelero<br><br></td>
															</tr>
															<tr>
																<td><strong>MS</td><td><br>Mistery Shopper, Supervisores, coordinadores<br><br></td>
															</tr>
															<tr>
																<td><strong>PUO</td><td><br>Personal unidades operativas (personal que presta servicio en oficinas o espacios de cliente)<br><br></td>
															</tr>
															<tr>
																<td><strong>EDE</td><td><br>Edecanes, GOS, Animadores. AA Y AAA<br><br></td>
															</tr>
															<tr>
																<td><strong>AVP</td><td><br>Actividad Vía Pública, Volanteos, Samplings, Walking Bilboards, Perifoneo, Venta en Cruceros, Venta en Tianguis, Venta en Vía Pública<br><br></td>
															</tr>
															<tr>
																<td><strong>PH</td><td><br>Promoción Hogar, Cambaceo<br><br></td>
															</tr>
															<tr>
																<td><strong>EPV</td><td><br>Eventos en punto de venta (autoservicio, departamental, club de precios, on premise, detallista, mayorista, conveniencia, centro comercial,  etc. ) , eventos de fin de semana o entre semana.<br><br></td>
															</tr>
															<tr>
																<td><strong>EE</td><td><br>Eventos Especiales, eventos únicos que conllevan diferentes perfiles de personal, logistica y materiales. Dura 1-3 días<br><br></td>
															</tr>
															<tr>
																<td><strong>UMIE</td><td><br>Uniformes, Materiales, Insumos, Equipos<br><br></td>
															</tr>
															<tr>
																<td><strong>LOG</td><td><br>Logística, envíos traslados, camionetas, mensajerías, etc.<br><br></td>
															</tr>
															<tr>
																<td><strong>CBI</td><td><br>Comisiones, Bonos, Incentivos<br><br></td>
															</tr>
															<tr>
																<td><strong>CCA</strong></td><td><br>Comida para capacitación<br><br></td>
															</tr>
															<tr>
																<td><strong>VYG</strong></td><td><br>Viáticos y Gastos <br><br></td>
															</tr>
														</table>
                                                    </div><!--end col-->
                                                </div><!--end row-->   
                                            </div><!--end modal-body-->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                            </div><!--end modal-footer-->
                                        </div><!--end modal-content-->
                                    </div><!--end modal-dialog-->
                                </div><!--end modal-->
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
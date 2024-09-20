<?php
error_reporting(0);
session_start();
if(isset($_SESSION['login_gmt']))
{
	//aqui llenamos la variable para saber si esta en views o en una carpeta dentro de views
	//Si esta en la raiz de view la variable esta vacia y si esta dentro de una carpeta de view la variable es ../
	
	$views = "../../";
	
	include("$views../actions/conexion.php");
	
	//convierte las claves en lista para poder recorrerlas y hacer mach con los usuarios que contengan la clave ejecutivo
	$porciones = explode(",", $_SESSION["clave_gmt"]);
	$query_claves = "";
	
	if(!empty($_POST['codsel2'])){
			$claves_texto = implode(",", $_POST['codsel2']);
			$query_claves = " clave_ejecutivo IN (".$claves_texto.")";
	}else{
	
		//Recorre las claves para poder llamar solo los usuarios que califiquen
		for ($i=0; $i < count($porciones) ; $i++) {
			if(count($porciones) == 0 || count($porciones) == null){
			}else if(count($porciones) == 1){
				$query_claves = " clave_ejecutivo like '%".$porciones[$i]."%' ";
			}else{
				if( ($i +1) == count($porciones))
				{
					$query_claves = $query_claves." clave_ejecutivo like '%".$porciones[$i]."%' ";
				} else{
					$query_claves = $query_claves." clave_ejecutivo like '%".$porciones[$i]."%' OR ";
				}
			}
		}
	}
	
	
	$query_exportar = "";
	
	if($_POST['modulo3'] === "Candidatos"){
		
		if(($_POST['fechai3'] != "" || $_POST['fechai3'] != null) AND ($_POST['fechaf3'] != "" || $_POST['fechaf3'] != null)){
			$condicion_fechas = " AND fechaAlta BETWEEN '".$_POST['fechai3']."' AND DATE_ADD('".$_POST['fechaf3']."', INTERVAL 1 DAY) ";
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado IS NULL AND ".$query_claves." ".$condicion_fechas." ORDER BY fechaAlta DESC;");
		}else{
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado IS NULL AND ".$query_claves." ORDER BY fechaAlta DESC;");
		}
		
	}
	if($_POST['modulo3'] === "Preaprobados"){
		
		if(($_POST['fechai3'] != "" || $_POST['fechai3'] != null) AND ($_POST['fechaf3'] != "" || $_POST['fechaf3'] != null)){
			
			$condicion_fechas = " AND fechaAlta BETWEEN '".$_POST['fechai3']."' AND DATE_ADD('".$_POST['fechaf3']."', INTERVAL 1 DAY) ";
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado = 1 AND autorizado_dos IS NULL AND ".$query_claves." ".$condicion_fechas." ORDER BY fechaAlta DESC;");
			
		}else{
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado = 1 AND autorizado_dos IS NULL AND ".$query_claves." ORDER BY fechaAlta DESC;");
		}
		
	}
	if($_POST['modulo3'] === "Aprobados"){
		
		if(($_POST['fechai3'] != "" || $_POST['fechai3'] != null) AND ($_POST['fechaf3'] != "" || $_POST['fechaf3'] != null)){
			
			$condicion_fechas = " AND fechaAlta BETWEEN '".$_POST['fechai3']."' AND DATE_ADD('".$_POST['fechaf3']."', INTERVAL 1 DAY) ";
			
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado = 1 AND autorizado_dos = 1 AND ".$query_claves." ".$condicion_fechas." ORDER BY fechaAlta DESC;");
			
		}else{
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado = 1 AND autorizado_dos = 1 AND ".$query_claves." ORDER BY fechaAlta DESC;");
		}
		
	}
	
	//funcion de quitar acentos
	function quitar_acentos($cadena){
		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðòóôõöøùúûýýþÿ';
		$modificadas = 'aaaaaaaceeeeiiiidoooooouuuuybsaaaaaaaceeeeiiiidoooooouuuyyby';
		$cadena = utf8_decode($cadena);
		$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
		return utf8_encode($cadena);
	}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        

        <meta charset="utf-8" />
                <title>Exportar por usuarios</title>
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
                <meta content="" name="author" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />

                <!-- App favicon -->
                <link rel="shortcut icon" href="<?php echo $views;?>../assets/images/favicon.png">

		<link href="<?php echo $views;?>../assets/libs/simple-datatables/style.css" rel="stylesheet" type="text/css" />
		
        <link href="<?php echo $views;?>../assets/libs/vanillajs-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css" />
		
		<link href="<?php echo $views;?>../assets/libs/mobius1-selectr/selectr.min.css" rel="stylesheet" type="text/css" />
		
         <!-- App css -->
         <link href="<?php echo $views;?>../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
         <link href="<?php echo $views;?>../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
         <link href="<?php echo $views;?>../assets/css/app.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body id="body">
        <!-- leftbar-tab-menu -->
        <?php include ("../../../actions/leftbar.php");?>
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
                            <a class="dropdown-item" href="<?php echo $views; ?>../../actions/logout.php"><i class="ti ti-power font-16 me-1 align-text-bottom"></i> Cerrar sesión</a>
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
				<div class="container-fluid">
					<!-- end page title end breadcrumb -->
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Exportar <?php echo $_POST['modulo3'] ?> </h4>
								</div><!--end card-header-->
								
								<div class="card-body">
									<form method="POST" action="exporsel.php">
										<div class="table-responsive">
											<table class="table" id="datatable_1">
												<thead class="thead-light">
												  <tr>
													<th>
														Nombre
													</th>
													<th>
														Telefono
													</th>
													<th>
														CURP
													</th>
													<th>
														Fecha Alta
													</th>
													<th>
														Cliente
													</th>
													<th>
														Perfil
													</th>
													<th>
														Seleccionar
													</th>
												  </tr>
												</thead>
												<tbody>
													<?php while ($fila=mysqli_fetch_array($query_exportar)) {
														if($fila['estatus'] == "Activo" || $fila['estatus'] == null || $fila['estatus'] == ""){
														
														$nombre= quitar_acentos($fila['nombre']);
														$app= quitar_acentos($fila['app']);
														$apm= quitar_acentos($fila['apm']);
														$query_cliper = mysqli_query($con, "SELECT cliente, perfil FROM codigos_clientes WHERE codigo ='".substr($fila['clave_ejecutivo'], 0, 3)."';");
														$filaqp=mysqli_fetch_array($query_cliper);
													?>
													<tr>
														<td><?php  echo strtoupper($nombre." ".$app." ".$apm); ?></td>
														<td><?php  echo $fila ["telefono"]; ?></td>
														<td><?php  echo $fila ["curp"]; ?></td>
														<td><?php  echo $fila ["fechaAlta"]; ?></td>
														<td><?php  echo $filaqp ["cliente"]; ?></td>
														<td><?php  echo $filaqp ["perfil"]; ?></td>
														<td align="center">
															<input class="form-check-input" type="checkbox" value="<?php echo $fila ['id']; ?>" name="seleccionados[]">
														</td>
													</tr> 
													<?php  
														}
													}
													?>
												</tbody>
											</table>
										</div>
										<div align="center">
										<input type="text" name="modulo" style="display: none;" value="<?php echo $_POST['modulo3']; ?>">
											<button class="btn btn-primary" type="submit">Exportar seleccionados</button>
										</div>
									</form>
								</div>
							</div>
						</div> <!-- end col -->
					</div> <!-- end row -->
				</div>
                 
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
		
		<script src="<?php echo $views;?>../assets/libs/simple-datatables/umd/simple-datatables.js"></script>
		<script src="<?php echo $views;?>../assets/libs/vanillajs-datepicker/js/datepicker-full.min.js"></script>
		
		<script src="<?php echo $views;?>../assets/js/pages/datatable.init.js"></script>
        <!-- App js -->
        <script src="<?php echo $views;?>../assets/js/app.js"></script>
		
		<script src="<?php echo $views;?>../assets/libs/mobius1-selectr/selectr.min.js"></script>
		<!-- <script src="<?php echo $views;?>../assets/js/pages/forms-advanced.js"></script> -->
		<script>
			new Selectr("#multiSelect",{multiple:!0});
		</script>

    </body>
    <!--end body-->
</html>
<?php
}else {
    header("Location: ../../../login.php");
}
?>
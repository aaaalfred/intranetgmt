<?php
error_reporting(0);
session_start();
if(isset($_SESSION['login_gmt']))
{
	//aqui llenamos la variable para saber si esta en views o en una carpeta dentro de views
	//Si esta en la raiz de view la variable esta vacia y si esta dentro de una carpeta de view la variable es ../
	
	$views = "../";
	
	include("$views../actions/conexion.php");
	
	$query_clientes = mysqli_query($con, "SELECT * FROM codigos_clientes WHERE codigo IN (".$_SESSION['clave_gmt'].");");
	
	//convierte las claves en lista para poder recorrerlas y hacer mach con los usuarios que contengan la clave ejecutivo
	$porciones = explode(",", $_SESSION["clave_gmt"]);
	$query_claves = "";
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
	
	if($_GET['filtro']){
		$condicion_claves = "";
		$cndicion_fechas = "";
		//validacion para ver si ponemos condicion de claves en query
		if(!empty($_POST['codsel'])){
			$claves_texto = implode(",", $_POST['codsel']);
			$condicion_claves = " AND clave_ejecutivo IN (".$claves_texto.")";
		}
		
		//validacion para ver si ponemos condicion de fechas en query
		if(($_POST['date1'] != "" || $_POST['date1'] != null) AND ($_POST['date2'] != "" || $_POST['date2'] != null)){
			$condicion_fechas = " AND fechaAlta BETWEEN '".$_POST['date1']."' AND DATE_ADD('".$_POST['date2']."', INTERVAL 1 DAY) ";
		}
		//var_dump("SELECT usuarios.* FROM usuarios WHERE autorizado IS NULL ".$condicion_fechas.$condicion_claves." ORDER BY fechaAlta DESC;");exit;
		$query_usuarios = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado IS NULL ".$condicion_fechas.$condicion_claves." ORDER BY fechaAlta DESC;");
	}else{
	$query_usuarios = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado IS NULL AND (".$query_claves.") ORDER BY fechaAlta DESC;");
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
                <title>Candidatos</title>
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
				<div class="container-fluid">
					<!-- end page title end breadcrumb -->
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Candidatos </h4>
								</div><!--end card-header-->
								<div class="row"> 
									<div class="col-lg-8">
										<div class="card">
											<div class="card-header">
												<h4 class="card-title">Filtros</h4>
												<p class="text-muted mb-0">Busca entre rango de fechas
												</p>
											</div><!--end card-header-->
											<form method="POST" action="candidatos.php?filtro=true">
												<div class="card-body">
													<div class="row">
														<div class="col-md-7">
															<label class="mb-3">Selecciona un rango de fechas</label>
															<div class="input-group" id="DateRange">
																<input type="date" class="form-control" name="date1" placeholder="Inicial" aria-label="FechaInicial">
																<span class="input-group-text"> a </span>
																<input type="date" class="form-control" name="date2" placeholder="Final" aria-label="FechaFinal">
															</div> 
														</div><!-- end col -->
														<div class="col-md-4">
															<label class="mb-3">Selecciona un cliente</label>
															<select class="input-group" id="multiSelect" name="codsel[]">
															<?php while ($filac=mysqli_fetch_array($query_clientes)) { ?>
																<option value="<?php echo $filac['codigo']; ?>"><?php echo $filac['codigo']." - ".$filac['cliente']." - ".$filac['perfil']; ?></option>
																<?php } ?>
															</select>          												
														</div><!-- end row -->														
													</div><!-- end row -->
													<br>
													<button class="btn btn-primary" type="submit">Filtrar </button>
												</div><!-- end card-body -->
											</form>
										</div> <!-- end card -->                               
									</div> <!-- end col -->  
									
									<div class="col-lg-4">
										<div class="card">
											<div class="card-header">
												<h4 class="card-title">Filtros</h4>
												<p class="text-muted mb-0">Busca por CURP
												</p>
											</div><!--end card-header-->
											<form method="POST" action="buscarcurp.php">
												<div class="card-body">
													<div class="row">
														<div class="col-md-10">
															<label class="mb-3">Ingresa la CURP que quieras buscar</label>
															<div class="col-sm-10">
																<input class="form-control" type="text" name="bcurp" id="bcurp">
															</div>
														</div><!-- end col --> 												
													</div><!-- end row --> 
													<br>
													<button class="btn btn-primary" type="submit">Filtrar </button>
												</div><!-- end card-body -->
											</form>
										</div> <!-- end card -->                               
									</div> <!-- end col --> 
								</div>
								<div class="card-body">
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
													Ver
												</th>
											  </tr>
											</thead>
											<tbody>
												<?php while ($fila=mysqli_fetch_array($query_usuarios)) {
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
													<td>
														<!-- <a class="btn btn-success" style="font-size: 10px;" href="perfil.php?id=<?php echo $fila ['id'];?>&curp=<?php echo $fila ['curp'];?>">Ver perfil</a> -->
														<a href="perfil.php?id=<?php echo $fila ['id'];?>&curp=<?php echo $fila ['curp'];?>&vista=candidatos"><i class="las la-pen text-secondary font-16"></i></a>
													</td>
												</tr> 
												<?php  
													}
												}
												?>
											</tbody>
										</table>
									</div>
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
    header("Location: ../../login.php");
}
?>
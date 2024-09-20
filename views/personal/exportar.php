<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
	//aqui llenamos la variable para saber si esta en views o en una carpeta dentro de views
	//Si esta en la raiz de view la variable esta vacia y si esta dentro de una carpeta de view la variable es ../
	
	$views = "../";
	
	include("$views../actions/conexion.php");
	
	$query_clientes = mysqli_query($con, "SELECT * FROM codigos_clientes WHERE codigo IN (".$_SESSION['clave_gmt'].");");
	$query_clientes2 = mysqli_query($con, "SELECT * FROM codigos_clientes WHERE codigo IN (".$_SESSION['clave_gmt'].");");
	$query_curps = mysqli_query($con, "SELECT * FROM usuarios WHERE curp IS NOT NULL;");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        

        <meta charset="utf-8" />
                <title>Exportar</title>
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
                <meta content="" name="author" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />

                <!-- App favicon -->
                <link rel="shortcut icon" href="<?php echo $views;?>../assets/images/favicon.png">

       
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
                 
				 <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Exportar candidatos, preaprobados y aprobados</h4>
                                <p class="text-muted mb-0"></p>
                            </div><!--end card-header-->
                            <div class="card-body">
								<form method="POST" action="./exportar/export1.php">
									<br>
									<div class="row">
										<div class="col-md-12" align="center">                                                
											<input type="radio" class="btn-check" name="radioexp" id="primary-outlined1" value="all" autocomplete="off" checked>
											<label class="btn btn-outline-primary btn-sm" for="primary-outlined1" >Exportar todo</label>
											<input type="radio" class="btn-check" name="radioexp" id="primary-outlined" value="dates" autocomplete="off">
											<label class="btn btn-outline-primary btn-sm" for="primary-outlined" >Exportar por fechas</label>   
										</div>
										
									</div> <!--end row-->
									<br>
									<br>
									<div class="input-group" id="DateRange">
										<input type="date" name="fechai" class="form-control" placeholder="Start" aria-label="StartDate">
										<span class="input-group-text">to</span>
										<input type="date" name="fechaf" class="form-control" placeholder="End" aria-label="EndDate">
									</div>
									<br>
									<div align="center">
										<button type="submit" class="btn btn-primary">Exportar</button>
									</div>
								</form>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
					<div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Exportar por Status</h4>
                                <p class="text-muted mb-0"></p>
                            </div><!--end card-header-->
                            <div class="card-body">  
								<form method="POST" action="./exportar/export2.php">
									<div class="row">
										<div class="col-sm-12">
											<label class="col-form-label text-end">Status</label>
											<select class="form-select" name="modulo2" aria-label="Default select example">
												<option selected>Candidatos</option>
												<option>Preaprobados</option>
												<option>Aprobados</option>
											  </select>
										</div>
									</div>
									<br>
									<div class="input-group" id="DateRange">
										<input type="date"  name="fechai2" class="form-control" placeholder="Start" aria-label="StartDate">
										<span class="input-group-text">to</span>
										<input type="date" name="fechaf2"  class="form-control" placeholder="End" aria-label="EndDate">
									</div>
									<br>
									<div class="row">
										<div class="col-sm-12">
											<label class="col-form-label text-end">Claves</label>
											<select class="form-select" name="codsel[]" multiple="true">
												<?php while ($filac=mysqli_fetch_array($query_clientes)) { ?>
													<option value="<?php echo $filac['codigo']; ?>"><?php echo $filac['codigo']." - ".$filac['cliente']." - ".$filac['perfil']; ?></option>
												<?php } ?>
											</select> 
										</div>
									</div>
									<br>
									<div align="center">
										<button type="submit" class="btn btn-primary">Exportar</button>
									</div>
								</form>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
					<div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Exportar por Status (selección de usuarios)</h4>
                                <p class="text-muted mb-0"></p>
                            </div><!--end card-header-->
                            <div class="card-body">  
								<form method="POST" action="./exportar/export3.php">
									<div class="row">
										<div class="col-sm-12">
											<label class="col-form-label text-end">Status</label>
											<select class="form-select" name="modulo3" aria-label="Default select example">
												<option selected>Candidatos</option>
												<option>Preaprobados</option>
												<option>Aprobados</option>
											  </select>
										</div>
									</div>
									<br>
									<div class="input-group" id="DateRange">
										<input type="date"  name="fechai3" class="form-control" placeholder="Start" aria-label="StartDate">
										<span class="input-group-text">to</span>
										<input type="date" name="fechaf3"  class="form-control" placeholder="End" aria-label="EndDate">
									</div>
									<br>
									<div class="row">
										<div class="col-sm-12">
											<label class="col-form-label text-end">Claves</label>
											<select class="form-select" name="codsel2[]" multiple="true">
												<?php while ($filac2=mysqli_fetch_array($query_clientes2)) { ?>
													<option value="<?php echo $filac2['codigo']; ?>"><?php echo $filac2['codigo']." - ".$filac2['cliente']." - ".$filac2['perfil']; ?></option>
												<?php } ?>
											</select> 
										</div>
									</div>
									<br>
									<div align="center">
										<button type="submit" class="btn btn-primary">Exportar</button>
									</div>
								</form>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
				<br>
				<br>
				<div class="row" align="center">
					<div class="col-12">
						<div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Exportar por CURP</h4>
                                <p class="text-muted mb-0"></p>
                            </div><!--end card-header-->
                            <div class="card-body">  
								<form method="POST" action="./exportar/export4.php">
									<div align="center">
										<div class="col-sm-8">
											<label class="col-form-label text-end">CURP</label>
											<select id="default" name="modulo3">
												<option selected>Selecciona una opción</option>
												<?php while ($filacu=mysqli_fetch_array($query_curps)) { ?>
												<option value="<?php echo $filacu['curp']; ?>"><?php echo $filacu['curp']; ?></option>
												<?php } ?>
											</select>
											<br>
											<input type="button" class="btn btn-success" onclick="addFila();" value="Añadir" />
											<br>
										</div>
									</div>
									<br>
									<div>
										<h4 class="card-title">CURPS seleccionadas:</h4>
										<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
										<table id="tablita">
										</table>
									</div>
									<script>
										function eliminarFila(index) {
										  $(index).remove();
										}
										function addFila() {
											var x = $("#default").val();
											if(x == "Selecciona una opción"){
												alert("Selecciona una CURP");
											}else{
												//var fila='<tr><td>'+x+'</td><td><input type="button" class="btn btn-danger btn-sm" onclick="eliminarFila('+x+');" value="Eliminar" /></td></tr>';
												var fila='<tr><td>'+x+'</td></tr>';
												var btn = document.createElement("TR");
												btn.setAttribute("id", x);
												btn.innerHTML=fila;
												console.log(btn);
												document.getElementById("tablita").appendChild(btn);
												var y = $("#curpsb").val();
												if(y=="" || y == null){
													$("#curpsb").val('"'+x+'"');
												}else{
													$("#curpsb").val(y+',"'+x+'"');
												}
											}
										}
									</script>
									<br>
									<input type="hidden" id="curpsb" name="curpsb">
									<div align="center">
										<button type="submit" class="btn btn-primary">Exportar</button>
									</div>
								</form>
                            </div><!--end card-body-->
                        </div><!--end card-->
					</div>
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
		<script src="<?php echo $views;?>../assets/libs/mobius1-selectr/selectr.min.js"></script>
        <!-- App js -->
        <script src="<?php echo $views;?>../assets/js/app.js"></script>
		<script>
			new Selectr("#default");
		</script>
		
    </body>
    <!--end body-->
</html>
<?php
}else {
    header("Location: ../../login.php");
}
?>
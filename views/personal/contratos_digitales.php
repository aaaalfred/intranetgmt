<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
	//aqui llenamos la variable para saber si esta en views o en una carpeta dentro de views
	//Si esta en la raiz de view la variable esta vacia y si esta dentro de una carpeta de view la variable es ../
	
	$views = "../";
	
	include("$views../actions/conexion.php");
	
	$query_contratos = mysqli_query($con,"SELECT contratos_weetrust.* FROM contratos_weetrust;");
	
	//funcion de quitar acentos
	function quitar_acentos($cadena){
		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðòóôõöøùúûýýþÿ';
		$modificadas = 'aaaaaaaceeeeiiiidoooooouuuuybsaaaaaaaceeeeiiiidoooooouuuyyby';
		$cadena = utf8_decode($cadena);
		$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
		return utf8_encode($cadena);
	}
	
	function getToken() {
		if (isset($_SESSION['token']) && $_SESSION['token_expiry'] > time()) {
			return $_SESSION['token'];
		}

		$ch = curl_init();
		
		curl_setopt_array($ch, [
		  CURLOPT_URL => "https://api-sandbox.weetrust.com.mx/access/token",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_HTTPHEADER => [
			"accept: application/json",
			"user-id: TeFbEi5eNYa6RAoamjHweOi7E2u1",
			"api-key: 0a967dca0f50bca58c9693cecb76500c0e03925f",
		  ],
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		]);

		$response = curl_exec($ch);
		$err = curl_error($ch);

		curl_close($ch);
		

		if ($err) {
			throw new Exception("cURL Error #: " . $err);
		}
		$response_json = json_decode($response, true);
		$response_data = $response_json['responseData'];
		

		if (!isset($response_data['accessToken'])) {
			throw new Exception('Invalid token response');
		}

		$_SESSION['token'] = $response_data['accessToken'];
		$_SESSION['token_expiry'] = time() + 300;


		return $_SESSION['token'];
	}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        

        <meta charset="utf-8" />
                <title>Contratos digitales</title>
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
                <meta content="" name="author" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />

                <!-- App favicon -->
                <link rel="shortcut icon" href="<?php echo $views;?>../assets/images/favicon.png">

		<link href="<?php echo $views;?>../assets/libs/simple-datatables/style.css" rel="stylesheet" type="text/css" />

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
				<!-- end page title end breadcrumb -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Contratos Digitales </h4>
                            </div><!--end card-header-->
                            <div class="card-body">
                                <div class="table-responsive">
									<form method="post" action="descargar_documentos_multiples.php">
										<table class="table" id="datatable_1">
											<thead class="thead-light">
											  <tr>
												<th>
													Fecha
												</th>
												<th>
													Usuario ID
												</th>
												<th>
													CURP
												</th>
												<th>
													Documento ID
												</th>
												<th>
													Accion
												</th>
												<th>
													<input type="checkbox" id="select_all" />
												</th>
											  </tr>
											</thead>
											<tbody>
												<?php while ($fila=mysqli_fetch_array($query_contratos)) {
												?>
												<tr>
													<td><?php  echo $fila ["fecha"]; ?></td>
													<td><?php  echo $fila ["usuario_id"]; ?></td>
													<td><?php  echo $fila ["curp"]; ?></td>
													<td><?php  echo $fila ["documento_id"]; ?></td>
													<td><a href="descargar_documento.php?doc=<?php  echo $fila ["documento_id"]; ?>" target="_blank">Descargar Documento</a></td>
													<td><input type="checkbox" name="document_ids[]" value="<?php echo $fila["documento_id"]; ?>" /></td>
												</tr> 
												<?php  
												}
												?>
											</tbody>
										</table>
										  <div align="center">
											<button class="btn btn-primary" type="submit">Descargar Documentos Seleccionados</button>
										  </div>
									</form>
                                </div>
                            </div>
                        </div>
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
		
		<script>
			document.getElementById('select_all').onclick = function() {
				var checkboxes = document.getElementsByName('document_ids[]');
				for (var checkbox of checkboxes) {
					checkbox.checked = this.checked;
				}
			}
		</script>
        
        <script src="<?php echo $views;?>../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo $views;?>../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo $views;?>../assets/libs/feather-icons/feather.min.js"></script>

       
		
		<!-- <script src="<?php echo $views;?>../assets/libs/simple-datatables/umd/simple-datatables.js"></script> 

		<script src="<?php echo $views;?>../assets/js/pages/datatable.init.js"></script> -->
        <!-- App js -->
        <script src="<?php echo $views;?>../assets/js/app.js"></script>

    </body>
    <!--end body-->
</html>
<?php
}else {
    header('Location: login.php');
}
?>
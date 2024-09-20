<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
	//aqui llenamos la variable para saber si esta en views o en una carpeta dentro de views
	//Si esta en la raiz de view la variable esta vacia y si esta dentro de una carpeta de view la variable es ../
	
	$views = "../";
	
	include("$views../actions/conexion.php");
	
	
	/*if(isset($_GET['send'])){
		$tipo = $_POST['tipo'];
		$output = shell_exec("\"C:\\Python38\\python.exe\" \"prueba.py\" 2>&1 \"$tipo\"");
		var_dump($output);exit;
	}*/
	
	$query_clientes = mysqli_query($con, "SELECT * FROM codigos_clientes WHERE codigo IN (".$_SESSION['clave_gmt'].");");
	$query_clientes2 = mysqli_query($con, "SELECT * FROM codigos_clientes WHERE codigo IN (".$_SESSION['clave_gmt'].");");
	$query_curps = mysqli_query($con, "SELECT * FROM usuarios WHERE curp IS NOT NULL;");
	
	//bucle de fechas
	
	// Obtiene la fecha actual
	$fechaActual = new DateTime();

	// Obtiene el año actual
	$anioActual = $fechaActual->format('Y');

	// Inicializa un array para almacenar las opciones del select
	$options = array();

	// Genera las fechas de las quincenas para los meses restantes del año
	//for ($mes = $fechaActual->format('n'); $mes <= 12; $mes++) {
	for ($mes = 1; $mes <= 12; $mes++) {
		$ultimoDiaDelMes = date('t', strtotime($anioActual . '-' . $mes . '-01'));
		
		// Agrega la fecha del 15 del mes si es mayor o igual al día actual
		if ($fechaActual->format('j') <= 15) {
			$options[$anioActual . '-' . sprintf('%02d', $mes) . '-15'] = '15-' . sprintf('%02d', $mes) . '-' . $anioActual;
		}
		
		// Verifica si el mes tiene 30 días (abril, junio, septiembre, noviembre)
		if ($ultimoDiaDelMes == 30) {
			// Agrega la fecha del 30 del mes si es mayor o igual al día actual
			if ($fechaActual->format('j') <= 30) {
				$options[$anioActual . '-' . sprintf('%02d', $mes) . '-30'] = '30-' . sprintf('%02d', $mes) . '-' . $anioActual;
			}
		}
		
		// Verifica si el mes tiene 31 días (enero, marzo, mayo, julio, agosto, octubre, diciembre)
		if ($ultimoDiaDelMes == 31) {
			// Agrega la fecha del 31 del mes si es mayor o igual al día actual
			if ($fechaActual->format('j') <= 31) {
				$options[$anioActual . '-' . sprintf('%02d', $mes) . '-31'] = '31-' . sprintf('%02d', $mes) . '-' . $anioActual;
			}
		}
		
		// Verifica si el mes es febrero (28 o 29 días)
		if ($mes == 2) {
			$diasFebrero = date('t', strtotime($anioActual . '-02-01'));
			// Agrega la fecha del 28 o 29 de febrero si es mayor o igual al día actual
			if ($fechaActual->format('j') <= ($diasFebrero == 28 ? 28 : 29)) {
				$options[$anioActual . '-02-' . ($diasFebrero == 28 ? '28' : '29')] = ($diasFebrero == 28 ? '28' : '29') . '-02-' . $anioActual;
			}
		}
	}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        

        <meta charset="utf-8" />
                <title>Recibos</title>
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
		<style>
			#loading {
				display: none;
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background-color: rgba(255, 255, 255, 0.8);
				text-align: center;
				vertical-align: middle;
			}

			#loading-message {
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				font-size: 24px;
			}
		</style>
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
                        
                    </div><!--end col-->
					<div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Recibos</h4>
                                <p class="text-muted mb-0"></p>
                            </div><!--end card-header-->
                            <div class="card-body">  
								<!-- <form method="POST" action="recibos.php" enctype="multipart/form-data"> -->
									<div class="row">
										<div class="col-sm-12">
											<label class="col-form-label text-end">Selecciona una opcion</label>
											<select class="form-select" id="tipo" name="tipo" aria-label="Default select example">
												<!-- <option selected></option>
												<option>15-08-2023</option>
												<option>30-08-2023</option> -->
												<?php 
													//foreach ($options as $value => $label) {
													//	echo '<option value="' . $label . '">' . $label . '</option>';
													//}
												?>

    
    
    
    
    
    
												<option value="31-12-2024">31-12-2024</option>
												<option value="15-12-2024">15-12-2024</option>
												<option value="30-11-2024">30-11-2024</option>
												<option value="15-11-2024">15-11-2024</option>
												<option value="31-10-2024">31-10-2024</option>
												<option value="15-10-2024">15-10-2024</option>
												<option value="30-09-2024">30-09-2024</option>
												<option value="15-09-2024">15-09-2024</option>
												<option value="31-08-2024">31-08-2024</option>
												<option value="15-08-2024">15-08-2024</option>
												<option value="31-07-2024">31-07-2024</option>
												<option value="15-07-2024">15-07-2024</option>
												<option value="30-06-2024">30-06-2024</option>
												<option value="15-06-2024">15-06-2024</option>
												<option value="31-05-2024">31-05-2024</option>
												<option value="30-05-2024">30-05-2024</option>
												<option value="15-05-2024">15-05-2024</option>
												<option value="30-04-2024">30-04-2024</option>
												<option value="15-04-2024">15-04-2024</option>
												<option value="31-03-2024">31-03-2024</option>
												<option value="15-03-2024">15-03-2024</option>
												<option value="29-02-2024">29-02-2024</option>
												<option value="15-02-2024">15-02-2024</option>
												<option value="31-01-2024">31-01-2024</option>
												<option value="15-01-2024">15-01-2024</option>
												<option value="31-12-2023">31-12-2023</option>
												<option value="20-12-2023">20-12-2023</option>
												<option value="15-12-2023">15-12-2023</option>												
												<option value="30-11-2023">30-11-2023</option>
												<option value="15-11-2023">15-11-2023</option>
												<option value="07-01-2024">Semana 1</option>
												<option value="14-01-2024">Semana 2</option>
												<option value="21-01-2024">Semana 3</option>
												<option value="28-01-2024">Semana 4</option>
												<option value="04-02-2024">Semana 5</option>
												<option value="11-02-2024">Semana 6</option>
												<option value="18-02-2024">Semana 7</option>
												<option value="25-02-2024">Semana 8</option>
												<option value="03-03-2024">Semana 9</option>
												<option value="10-03-2024">Semana 10</option>
												<option value="17-03-2024">Semana 11</option>
												<option value="24-03-2024">Semana 12</option>
												<option value="31-03-2024">Semana 13</option>
												<option value="07-04-2024">Semana 14</option>
												<option value="14-04-2024">Semana 15</option>
												<option value="21-04-2024">Semana 16</option>
												<option value="28-04-2024">Semana 17</option>
												<option value="05-05-2024">Semana 18</option>
												<option value="12-05-2024">Semana 19</option>
												<option value="19-05-2024">Semana 20</option>
												<option value="26-05-2024">Semana 21</option>
												<option value="02-06-2024">Semana 22</option>
												<option value="09-06-2024">Semana 23</option>
												<option value="16-06-2024">Semana 24</option>
												<option value="23-06-2024">Semana 25</option>
												<option value="30-06-2024">Semana 26</option>
												<option value="07-07-2024">Semana 27</option>
												<option value="14-07-2024">Semana 28</option>
												<option value="21-07-2024">Semana 29</option>
												<option value="28-07-2024">Semana 30</option>
												<option value="04-08-2024">Semana 31</option>
												<option value="11-08-2024">Semana 32</option>
												<option value="18-08-2024">Semana 33</option>
												<option value="25-08-2024">Semana 34</option>
												<option value="01-09-2024">Semana 35</option>
												<option value="08-09-2024">Semana 36</option>
												<option value="15-09-2024">Semana 37</option>
												<option value="22-09-2024">Semana 38</option>
												<option value="29-09-2024">Semana 39</option>
												<option value="06-10-2024">Semana 40</option>
												<option value="13-10-2024">Semana 41</option>
												<option value="20-10-2024">Semana 42</option>
												<option value="27-10-2024">Semana 43</option>
												<option value="03-11-2024">Semana 44</option>
												<option value="10-11-2024">Semana 45</option>
												<option value="17-11-2024">Semana 46</option>
												<option value="24-11-2024">Semana 47</option>
												<option value="01-12-2024">Semana 48</option>
												<option value="08-12-2024">Semana 49</option>
												<option value="15-12-2024">Semana 50</option>
												<option value="22-12-2024">Semana 51</option>
												<option value="29-12-2024">Semana 52</option>
											  </select>
										</div>
									</div>
									<br>
									<div align="center">
										<!-- <button type="submit" class="btn btn-primary">Enviar</button> -->
										
										<button id="miBoton" class="btn btn-primary">Enviar</button>
									</div>
									<div id="loading">
										<div id="loading-message">Cargando...</div>
									</div>
									<br>
									<div id="resultado"></div>
									<!-- Codigo Altas -->
									
								<!-- </form> -->
                            </div><!--end card-body-->
                        </div><!--end card-->
						<div class="card">
						<div class="card-body">
						<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="dropdone-nk mg-t-30" align="center">
												<div class="cmp-tb-hd">
													<h2>Subir Archivo</h2>
												</div>
												<form method="POST" action="correr_slista.php" enctype="multipart/form-data">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="form-group">
															<div class="nk-int-st">
																<br>
																<label>Selecciona tu archivo a cargar</label>
																<input type="file" name="uploadedFile[]" id="uploadedFile[]" style="text-align: center;" multiple="">
																<br>
															</div>
														</div>
													</div>
													<br>
													<button type="submit" name="uploadBtn" class="btn btn-primary" value="Upload">Enviar</button>
												</form>
											</div>
										</div>
									</div>
									<div class="row">
									  <?php
							
										//if (isset($_SESSION['message']) && $_SESSION['message']) && isset($_GET["csl"])
											if (isset($_GET["csl"]))
										{
										?>
										
										<?php
										  //printf('<b>%s</b>', $_SESSION['message']);
										  echo "<br><br>";
										  $variable = $_SESSION['ubicacion'];
										  $cadena = shell_exec("\"C:\\Python38\\python.exe\" \"altausers.py\" 2>&1 ");
										  echo $cadena;
										  echo '<br><br>';
										  //echo $cadena;
										}
										
										if (isset($_SESSION['errores']) && $_SESSION['errores'])
										{
										  //printf('<b>%s</b>', $_SESSION['errores']);
										  //unset($_SESSION['errores']);
										}
									  ?>
									</div>
									</div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
					<div class="col-lg-4">
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
		
		<script>
			 document.getElementById("miBoton").onclick = callPythonScript;
			 
			// Función para mostrar el mensaje de carga
			function showLoading() {
				document.getElementById('loading').style.display = 'block';
			}

			// Función para ocultar el mensaje de carga
			function hideLoading() {
				document.getElementById('loading').style.display = 'none';
			}

			// Llama a tu script PHP y muestra el mensaje de carga
			function callPythonScript() {
				showLoading();
				//var tipo = "tu_valor_tipo"; // Asegúrate de asignar el valor correcto a 'tipo'
				var inputElement = document.getElementById("tipo");
				//alert(inputElement.value)
				fetch('correr_script.php?tipo=' + inputElement.value)
					.then(response => response.text()) // Convierte la respuesta en texto
					.then(data => {
						// Maneja la respuesta del script PHP (puede ser la salida del script Python)
						console.log(data);
						var resultadoElement = document.getElementById("resultado");
						resultadoElement.textContent = ""+data;
						hideLoading(); // Oculta el mensaje de carga cuando obtienes una respuesta
					})
					.catch(error => {
						console.error(error);
						var resultadoElement = document.getElementById("resultado");
						resultadoElement.textContent = error;
						hideLoading(); // Oculta el mensaje de carga en caso de error
					});
			}
		</script>
        
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
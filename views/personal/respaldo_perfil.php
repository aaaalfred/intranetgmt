<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
	//aqui llenamos la variable para saber si esta en views o en una carpeta dentro de views
	//Si esta en la raiz de view la variable esta vacia y si esta dentro de una carpeta de view la variable es ../
	
	$views = "../";
	
	include("$views../actions/conexion.php");
	
	//query para obtener los datos del usuario
	$query_usuarios = mysqli_query($con,"SELECT * FROM usuarios WHERE id = ".$_GET['id'].";");
	$usuarios=mysqli_fetch_array ($query_usuarios);
	
	//obtener los contratos
	$query_contrato = mysqli_query($con,"SELECT * FROM contratos WHERE curp = '".$_GET['curp']."';");
	$query_total = mysqli_query($con,"SELECT COUNT(*) as total FROM contratos WHERE curp = '".$_GET['curp']."';");
	$total_contrato=mysqli_fetch_array ($query_total);
	
	//Se guarda el rol en una variable
	$rol = $_SESSION['rol_gmt'];
	
	//Guardo la interfaz previa de donde vienen
	$vista = $_GET['vista'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        

        <meta charset="utf-8" />
                <title>Perfil</title>
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
                <meta content="" name="author" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />

                <!-- App favicon -->
                <link rel="shortcut icon" href="<?php echo $views;?>../assets/images/favicon.png">

		<link href="<?php echo $views;?>../assets/libs/@midzer/tobii/tobii.min.css" rel="stylesheet" type="text/css" />

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
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Admin-GTM</a></li>
                                    <li class="breadcrumb-item"><a href="candidatos.php">Candidatos</a></li>
                                    <li class="breadcrumb-item active">Perfil</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Perfil</h4>
                        </div>
                        <!--end page-title-box-->
                    </div>
                    <!--end col-->
                </div>
                <!-- end page title end breadcrumb -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="met-profile">
                                    <div class="row">
                                        <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                                            <div class="met-profile-main">
                                                <div class="met-profile_user-detail">
													<img src="<?php echo $usuarios['foto']?>" alt="" height="150" class="rounded-circle">
                                                    <h5 class="met-user-name"><?php echo $usuarios['nombre'];?><br><?php echo  $usuarios['app']; ?><br><?php echo  $usuarios['apm']; ?></h5>                                                        
                                                    <p class="mb-0 met-user-name-post"><b> CURP </b>: <?php echo $usuarios['curp']; ?></p>
													<p class="mb-0 met-user-name-post"><b> RFC </b>: <?php echo $usuarios['rfc']; ?></p>
													<p class="mb-0 met-user-name-post"><b> NSS </b>: <?php echo $usuarios['nss']; ?></p>
													<?php if($vista=="candidatos" AND $vista == "preaprobados"){ ?>
														<a href="" class="btn btn-primary btn-sm">Autorizar</a>
													<?php } ?>
                                                </div>
                                            </div>                                                
                                        </div><!--end col-->
                                        
                                        <div class="col-lg-4 ms-auto align-self-center">
                                            <ul class="list-unstyled personal-detail mb-0">
                                                <li class="mt-2"> <b> Fecha de nacimiento </b> : <?php echo $usuarios['fecha_nacimiento']; ?></li>
												<li><br></li>
												<li class=""> <b> Sexo </b> : <?php echo $usuarios['sexo']; ?></li>
												<li><br></li>
                                                <li class="mt-2"> <b> Estado </b> : <?php echo $usuarios['estado']; ?></li>
												<li><br></li>
												<li class="mt-2"> <b> Regimen Fiscal </b> : <?php echo $usuarios['regimen_fiscal']; ?></li>
												<li class="mt-2"> <b> Codigo Postal Fiscal </b> : <?php echo $usuarios['cp']; ?></li>
												<li><br></li>
												<li class="mt-2"> <b> Fecha de Alta </b> : <?php echo $usuarios['fechaAlta']; ?></li>
												<li><br></li>
												<li class=""> <b> Telefono </b> : <?php echo $usuarios['telefono']; ?></li>
												<li><br></li>
                                                <li class="mt-2"> <b> Correo </b> : <?php echo $usuarios['correo']; ?></li>
												<li><br></li>
												<li class="mt-2"> <b> CLABE interbancaria </b> : <?php echo $usuarios['clabe']; ?></li>
												<li class="mt-2"> <b> No. Cuenta </b> : <?php echo $usuarios['no_cuenta']; ?></li>
												<li class="mt-2"> <b> Banco </b> : <?php echo $usuarios['banco']; ?></li>
												<li><br></li>
												<li class="mt-2"> <b> Infonavit </b> : <?php echo $usuarios['infonavit']; ?></li>
												<li class="mt-2"> <b> Fonacot </b> : <?php echo $usuarios['fonacot']; ?></li>
												<li><br></li>
                                            </ul>
                                           
                                        </div><!--end col-->
										
										<div class="col-lg-4 ms-auto align-self-center">
                                            <!-- aqui iria la tabla de dos documentos -->
                                           <div class="card">
													<table class="table table-bordered">
													  <thead>
														<tr>
														  <th scope="col">Documento</th>
														  <th scope="col">Disponibilidad</th>
														</tr>
													  </thead>
													  <tbody>
														<tr>
														  <th scope="row">Acta de nacimiento</th>
														  <td>
															<?php if($usuarios['doc_acta'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {?>
															  <div style="color: red;">No disponible</div>
															<?php }?>
														  </td>
														</tr>
														<tr>
														  <th scope="row">CURP</th>
														  <td>
															<?php if($usuarios['doc_curp'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {?>
															  <div style="color: red;">No disponible</div>
															<?php }?>
														  </td>
														</tr>
														<tr>
														  <th scope="row">Constancia de Situación Fiscal</th>
														  <td>
															<?php if($usuarios['doc_csf'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {?>
															  <div style="color: red;">No disponible</div>
															<?php }?>
														  </td>
														</tr>
														<tr>
														  <th scope="row">Identificación</th>
														  <td>
															<?php if($usuarios['doc_identificacion'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {
																$query_idsc = mysqli_query($con,"SELECT COUNT(fotos_identificacion.id) as total FROM fotos_identificacion INNER JOIN usuarios ON fotos_identificacion.curp = usuarios.curp WHERE usuarios.curp =  '".$_GET['curp']."';");
																$total_idsc = mysqli_fetch_array ($query_idsc);
																if($total_idsc[0] == 1){
															?>
															<div style="color: green;">Disponible</div>
															<?php }else{
															?>
															  <div style="color: red;">No disponible</div>
															<?php }}?>
														  </td>
														</tr>
														<tr>
														  <th scope="row">Numero de IMSS</th>
														  <td>
															<?php if($usuarios['doc_nss'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {?>
															  <div style="color: red;">No disponible</div>
															<?php }?>
														  </td>
														</tr>
														<tr>
														  <th scope="row">Comprobante de domicilio</th>
														  <td>
															<?php if($usuarios['doc_cdomicilio'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {?>
															  <div style="color: red;">No disponible</div>
															<?php }?>
														  </td>
														</tr>
														<tr>
														  <th scope="row">Comprobante de estudios</th>
														  <td>
															<?php if($usuarios['doc_cestudios'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {?>
															  <div style="color: red;">No disponible</div>
															<?php }?>
														  </td>
														</tr>
														<tr>
														  <th scope="row">Carta de recomendación</th>
														  <td>
															<?php if($usuarios['doc_carta'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {?>
															  <div style="color: red;">No disponible</div>
															<?php }?>
														  </td>
														</tr>
														<tr>
														  <th scope="row">Foto</th>
														  <td>
															<?php if($usuarios['foto'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {?>
															  <div style="color: red;">No disponible</div>
															<?php }?>
														  </td>
														</tr>
														<tr>
														  <th scope="row">Estado de Cuenta</th>
														  <td>
															<?php if($usuarios['estado_cuenta'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {?>
															  <div style="color: red;">No disponible</div>
															<?php }?>
														  </td>
														</tr>
														<tr>
														  <th scope="row">INFONAVIT</th>
														  <td>
															<?php if ($usuarios['infonavit'] == 'true') {
															  if($usuarios['doc_infonavit'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {?>
															  <div style="color: red;">No disponible</div>
															<?php }}else{ echo"No aplica";}?>
														  </td>
														</tr>
														<tr>
														  <th scope="row">FONACOT</th>
														  <td>
															<?php if ($usuarios['fonacot'] == 'true') {
															  if($usuarios['doc_fonacot'] != null) { ?>
															  <div style="color: green;">Disponible</div>
															<?php }else {?>
															  <div style="color: red;">No disponible</div>
															<?php }}else{ echo"No aplica";}?>
														  </td>
														</tr>
													  </tbody>
													</table>
                                                </div><!--end card-->
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </div><!--end f_profile-->                                                                                
                            </div><!--end card-body-->  
                            <div class="card-body p-0">    
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#Post" role="tab" aria-selected="true">Documentos</a>
                                    </li>                                              
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#Settings" role="tab" aria-selected="false">Editar</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane p-3 active" id="Post" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                
												<div id="grid" class="row g-0">
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["acta"]'>
														<?php if($usuarios['doc_acta'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['doc_acta']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['doc_acta']; ?>" type="application/pdf" width="100%" height="475px" />
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['doc_acta']; ?>" class="lightbox">
																	<img src="http://72.167.45.26<?php echo $usuarios['doc_acta']; ?>" alt="" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col-->
													
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["curp"]'>
														<?php if($usuarios['doc_curp'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['doc_curp']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['doc_curp']; ?>" type="application/pdf" width="100%" height="100%" />
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['doc_curp']; ?>" class="lightbox" title="<?php echo $usuarios['curp']; ?>">
																	<img src="http://72.167.45.26<?php echo $usuarios['doc_curp']; ?>" alt="<?php echo $usuarios['curp']; ?>" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col--> 
													
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["csf"]'>
														<?php if($usuarios['doc_csf'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['doc_csf']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['doc_csf']; ?>" type="application/pdf" width="100%" height="100%" />
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['doc_csf']; ?>" class="lightbox" title="<?php echo $usuarios['rfc']; ?>">
																	<img src="http://72.167.45.26<?php echo $usuarios['doc_csf']; ?>" alt="<?php echo $usuarios['rfc']."\n".$usuarios['regimen_fiscal']."\n".$usuarios['cp']; ?>" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col--> 
													
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["identificacion"]'>
														<?php if($usuarios['doc_identificacion'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['doc_identificacion']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['doc_identificacion']; ?>" type="application/pdf" width="100%" height="100%"/>
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['doc_identificacion']; ?>" class="lightbox">
																	<img src="http://72.167.45.26<?php echo $usuarios['doc_identificacion']; ?>" alt="" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col--> 
													
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["nss"]'>
														<?php if($usuarios['doc_nss'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['doc_nss']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['doc_nss']; ?>" type="application/pdf" width="100%" height="100%" />
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['doc_nss']; ?>" class="lightbox" title="<?php echo $usuarios['nss']; ?>">
																	<img src="http://72.167.45.26<?php echo $usuarios['doc_nss']; ?>" alt="<?php echo $usuarios['nss']."\n".$usuarios['regimen_fiscal']."\n".$usuarios['cp']; ?>" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col--> 
													
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["cdomicilio"]'>
														<?php if($usuarios['doc_cdomicilio'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['doc_cdomicilio']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['doc_cdomicilio']; ?>" type="application/pdf" width="100%" height="100%" />
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['doc_cdomicilio']; ?>" class="lightbox">
																	<img src="http://72.167.45.26<?php echo $usuarios['doc_cdomicilio']; ?>" alt="" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col--> 
													
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["cestudios"]'>
														<?php if($usuarios['doc_cestudios'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['doc_cestudios']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['doc_cestudios']; ?>" type="application/pdf" width="100%" height="100%" />
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['doc_cestudios']; ?>" class="lightbox">
																	<img src="http://72.167.45.26<?php echo $usuarios['doc_cestudios']; ?>" alt="" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col--> 
													
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["carta"]'>
														<?php if($usuarios['doc_carta'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['doc_carta']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['doc_carta']; ?>" type="application/pdf" width="100%" height="100%" />
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['doc_carta']; ?>" class="lightbox">
																	<img src="http://72.167.45.26<?php echo $usuarios['doc_carta']; ?>" alt="" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col--> 
													
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["foto"]'>
														<?php if($usuarios['foto'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['foto']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['foto']; ?>" type="application/pdf" width="100%" height="100%" />
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['foto']; ?>" class="lightbox">
																	<img src="http://72.167.45.26<?php echo $usuarios['foto']; ?>" alt="" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col--> 
													
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["infonavit"]'>
														<?php if($usuarios['doc_infonavit'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['doc_infonavit']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['doc_infonavit']; ?>" type="application/pdf" width="100%" height="100%" />
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['doc_infonavit']; ?>" class="lightbox">
																	<img src="http://72.167.45.26<?php echo $usuarios['doc_infonavit']; ?>" alt="" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col--> 
													
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["fonacot"]'>
														<?php if($usuarios['doc_fonacot'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['doc_fonacot']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['doc_fonacot']; ?>" type="application/pdf" width="100%" height="100%" />
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['doc_fonacot']; ?>" class="lightbox">
																	<img src="http://72.167.45.26<?php echo $usuarios['doc_fonacot']; ?>" alt="" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col-->
													
													<div class="col-md-4 col-lg-3 picture-item" data-groups='["estado_cuenta"]'>
														<?php if($usuarios['estado_cuenta'] != null) { ?>
													
														<?php 
															$porciones = explode("/", $usuarios['estado_cuenta']);
															$extensiondoc = explode(".", $porciones[4]);
															if($extensiondoc[1] == "pdf"){
															?>
															<embed src="http://72.167.45.26<?php echo $usuarios['estado_cuenta']; ?>" type="application/pdf" width="100%" height="100%" />
														<?php
															}else{
														?>
															  <a href="http://72.167.45.26<?php echo $usuarios['estado_cuenta']; ?>" class="lightbox">
																	<img src="http://72.167.45.26<?php echo $usuarios['estado_cuenta']; ?>" alt="" class="img-fluid" />
																</a> 
														<?php } ?>  
														<?php }else{ ?>
																<a href="<?php echo $views; ?>../assets/images/no_disponible.jpg" class="lightbox">
																	<img src="<?php echo $views; ?>../assets/images/no_disponible.jpg" alt="" class="img-fluid" />
																</a> 
														<?php } ?>
													</div><!--end col--> 
													
												</div><!--end row-->
										
                                            </div><!--end col-->
                                        </div><!--end row-->  
                                    </div>                                               
                                    <div class="tab-pane p-3" id="Settings" role="tabpanel">
										<form method="POST" action="update_perfil.php">
											<div class="row">
												<div class="col-lg-6 col-xl-6">
													<div class="card">
														<div class="card-header">
															<div class="row align-items-center">
																<div class="col">                      
																	<h4 class="card-title">Editar Informacion</h4>                      
																</div><!--end col-->                                                       
															</div>  <!--end row-->                                  
														</div><!--end card-header-->
														<div class="card-body">                       
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Nombre</label>
																<div class="col-lg-9 col-xl-8">
																<input class="form-control" type="text" style="display:none;" name="id" value="<?php echo $usuarios['id'] ?>">
																	<input class="form-control" type="text" name="nombre" value="<?php echo $usuarios['nombre'] ?>">
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Apellido Paterno</label>
																<div class="col-lg-9 col-xl-8">
																	<input class="form-control" type="text" name="app" value="<?php echo $usuarios['app'] ?>">
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Apellido Materno</label>
																<div class="col-lg-9 col-xl-8">
																	<input class="form-control" type="text" name="apm" value="<?php echo $usuarios['apm'] ?>">
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">CURP</label>
																<div class="col-lg-9 col-xl-8">
																	<input class="form-control" type="text" name="curp" value="<?php echo $usuarios['curp']?>">
																	<!--<span class="form-text text-muted font-12">La CURP debe tener 18 digitos.</span> -->
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">RFC</label>
																<div class="col-lg-9 col-xl-8">
																	<input class="form-control" type="text" name="rfc" value="<?php echo $usuarios['rfc']?>">
																	<!--<span class="form-text text-muted font-12">La CURP debe tener 18 digitos.</span> -->
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">NSS</label>
																<div class="col-lg-9 col-xl-8">
																	<input class="form-control" type="text" name="nss" value="<?php echo $usuarios['nss']?>">
																	<!--<span class="form-text text-muted font-12">La CURP debe tener 18 digitos.</span> -->
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Fecha de nacimiento</label>
																<div class="col-lg-9 col-xl-8">
																	<input class="form-control" type="date" name="fecha_nacimiento" value="<?php echo $usuarios['fecha_nacimiento']?>">
																	<!--<span class="form-text text-muted font-12">La CURP debe tener 18 digitos.</span> -->
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Sexo</label>
																<div class="col-md-9">
																<?php if($usuarios['sexo'] == "Hombre"){ ?>
																	<div class="form-check form-check-inline">
																		<input class="form-check-input" type="radio" name="sexo" id="sexo1" value="Hombre" checked>
																		<label class="form-check-label" for="sexo1">Hombre</label>
																	</div>
																<?php }else{ ?>
																	<div class="form-check form-check-inline">
																		<input class="form-check-input" type="radio" name="sexo" id="sexo1" value="Hombre">
																		<label class="form-check-label" for="sexo1">Hombre</label>
																	</div>
																<?php } ?>
																<?php if($usuarios['sexo'] == "Mujer"){ ?>
																	<div class="form-check form-check-inline">
																		<input class="form-check-input" type="radio" name="sexo" id="sexo2" value="Mujer" checked>
																		<label class="form-check-label" for="sexo2">Mujer</label>
																	</div>
																<?php }else{ ?>
																	<div class="form-check form-check-inline">
																		<input class="form-check-input" type="radio" name="sexo" id="sexo2" value="Mujer">
																		<label class="form-check-label" for="sexo2">Mujer</label>
																	</div>
																<?php } ?>
																</div>
															</div> <!--end row-->   
															
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Estado</label>
																<div class="col-lg-9 col-xl-8">
																	<select class="form-select" name="estado">
																		<option value="<?php echo $usuarios['estado'];?>" selected><?php echo $usuarios['estado']?></option>
																	  <option value="Aguascalientes">Aguascalientes</option>
																	  <option value="Baja California">Baja California</option>
																	  <option value="Baja California Sur">Baja California Sur</option>
																	  <option value="Campeche">Campeche</option>
																	  <option value="Chiapas">Chiapas</option>
																	  <option value="Chihuahua">Chihuahua</option>
																	  <option value="CDMX">Ciudad de México</option>
																	  <option value="Coahuila">Coahuila</option>
																	  <option value="Colima">Colima</option>
																	  <option value="Durango">Durango</option>
																	  <option value="Estado de México">Estado de México</option>
																	  <option value="Guanajuato">Guanajuato</option>
																	  <option value="Guerrero">Guerrero</option>
																	  <option value="Hidalgo">Hidalgo</option>
																	  <option value="Jalisco">Jalisco</option>
																	  <option value="Michoacán">Michoacán</option>
																	  <option value="Morelos">Morelos</option>
																	  <option value="Nayarit">Nayarit</option>
																	  <option value="Nuevo León">Nuevo León</option>
																	  <option value="Oaxaca">Oaxaca</option>
																	  <option value="Puebla">Puebla</option>
																	  <option value="Querétaro">Querétaro</option>
																	  <option value="Quintana Roo">Quintana Roo</option>
																	  <option value="San Luis Potosí">San Luis Potosí</option>
																	  <option value="Sinaloa">Sinaloa</option>
																	  <option value="Sonora">Sonora</option>
																	  <option value="Tabasco">Tabasco</option>
																	  <option value="Tamaulipas">Tamaulipas</option>
																	  <option value="Tlaxcala">Tlaxcala</option>
																	  <option value="Veracruz">Veracruz</option>
																	  <option value="Yucatán">Yucatán</option>
																	  <option value="Zacatecas">Zacatecas</option>
																	</select>
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Clave de ejecutivo</label>
																<div class="col-lg-9 col-xl-8">
																	<input class="form-control" type="text" name="clave_ejecutivo" value="<?php echo $usuarios['clave_ejecutivo']?>">
																	<!--<span class="form-text text-muted font-12">La CURP debe tener 18 digitos.</span> -->
																</div>
															</div>
														</div>                                            
													</div>
												</div> <!--end col--> 
												<div class="col-lg-6 col-xl-6">
													<div class="card">
														<div class="card-header">
															<h4 class="card-title">Datos de contacto</h4>
														</div><!--end card-header-->
														<div class="card-body"> 
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Telefono</label>
																<div class="col-lg-9 col-xl-8">
																	<div class="input-group">
																		<span class="input-group-text"><i class="las la-phone"></i></span>
																		<input type="number" class="form-control" name="telefono" value="<?php echo $usuarios['telefono'] ?>" placeholder="Telefono" aria-describedby="basic-addon1">
																	</div>
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Correo</label>
																<div class="col-lg-9 col-xl-8">
																	<div class="input-group">
																		<span class="input-group-text"><i class="las la-at"></i></span>
																		<input type="email" class="form-control" name="correo" value="<?php echo $usuarios['correo'] ?>" placeholder="Correo" aria-describedby="basic-addon1">
																	</div>
																</div>
															</div>
														</div><!--end card-body-->
													</div><!--end card-->
													<div class="card">
														<div class="card-header">
															<h4 class="card-title">Datos Fiscales</h4>
														</div><!--end card-header-->
														<div class="card-body"> 
		
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Regimen fiscal</label>
																<div class="col-lg-9 col-xl-8">
																	<select class="form-select" name="regimen">
																		<option value="<?php echo $usuarios['regimen_fiscal']?>" selected><?php echo $usuarios['regimen_fiscal']?></option>
																		<option value="Régimen Simplificado de Confianza">Régimen Simplificado de Confianza</option>
																		<option value="Sueldos y salarios e ingresos asimilados a salarios">Sueldos y salarios e ingresos asimilados a salarios</option>
																		<option value="Régimen de Actividades Empresariales y Profesionales">Régimen de Actividades Empresariales y Profesionales</option>
																		<option value="Régimen de Incorporación Fiscal">Régimen de Incorporación Fiscal</option>
																		<option value="Enajenación de bienes">Enajenación de bienes</option>
																		<option value="Régimen de Actividades Empresariales con ingresos a través de Plataformas Tecnológicas">Régimen de Actividades Empresariales con ingresos a través de Plataformas Tecnológicas</option>
																		<option value="Régimen de Arrendamiento">Régimen de Arrendamiento</option>
																		<option value="Intereses">Intereses</option>
																		<option value="Obtención de premios">Obtención de premios</option>
																		<option value="Dividendos">Dividendos</option>
																		<option value="Demás ingresos">Demás ingresos</option>
																		<option value="Sin Obligaciones Fiscales">Sin Obligaciones Fiscales</option>
																		<option value="Suspendido">Suspendido</option>
																	</select>
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Codigo Postal Fiscal</label>
																<div class="col-lg-9 col-xl-8">
																	<input class="form-control" type="text" name="cp" value="<?php echo $usuarios['cp']?>">
																	<!--<span class="form-text text-muted font-12">La CURP debe tener 18 digitos.</span> -->
																</div>
															</div>
														</div><!--end card-body-->
													</div><!--end card-->
													<div class="card">
														<div class="card-header">
															<h4 class="card-title">Datos Bancarios</h4>
														</div><!--end card-header-->
														<div class="card-body">
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">CLABE Interbancaria</label>
																<div class="col-lg-9 col-xl-8">
																	<input class="form-control" type="text" name="clabe" value="<?php echo $usuarios['clabe']?>">
																	<!--<span class="form-text text-muted font-12">La CURP debe tener 18 digitos.</span> -->
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">No. Cuenta</label>
																<div class="col-lg-9 col-xl-8">
																	<input class="form-control" type="text" name="no_cuenta" value="<?php echo $usuarios['no_cuenta']?>">
																	<!--<span class="form-text text-muted font-12">La CURP debe tener 18 digitos.</span> -->
																</div>
															</div>
															<div class="form-group mb-3 row">
																<label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Banco</label>
																<div class="col-lg-9 col-xl-8">
																	<input class="form-control" type="text" name="banco" value="<?php echo $usuarios['banco']?>">
																	<!--<span class="form-text text-muted font-12">La CURP debe tener 18 digitos.</span> -->
																</div>
															</div>
														</div><!--end card-body-->
													</div><!--end card-->
													<div class="form-group mb-3 row">
																<div class="col-lg-9 col-xl-8 offset-lg-3">
																	<button type="submit" class="btn btn-de-primary">Enviar</button>
																</div>
															</div> 
												</div> <!-- end col -->                                                                              
											</div><!--end row-->

										</form>
                                    </div>
                                </div>        
                            </div> <!--end card-body-->                            
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!-- container -->
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

        <script src="<?php echo $views;?>../assets/js/pages/analytics-index.init.js"></script>
		<script src="<?php echo $views;?>../assets/libs/apexcharts/apexcharts.min.js"></script> 
		<script src="<?php echo $views;?>../assets/libs/@midzer/tobii/tobii.min.js"></script>
        <!-- App js -->
        <script src="<?php echo $views;?>../assets/js/app.js"></script>
		
		<script>
			const tobii = new Tobii()
		</script>
	
    </body>
    <!--end body-->
</html>
<?php
}else {
    header('Location: '.$views.'../login.php');
}
?>
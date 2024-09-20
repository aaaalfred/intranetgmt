<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
	//aqui llenamos la variable para saber si esta en views o en una carpeta dentro de views
	//Si esta en la raiz de view la variable esta vacia y si esta dentro de una carpeta de view la variable es ../
	
	$views = "../";
	
	include ("$views../actions/conexion.php");
	
	$sqlvisita=mysqli_query($con, "SELECT * FROM PRESUPUESTO WHERE idPpto=".$_REQUEST["id"].";");
	$reg_visita=mysqli_fetch_array ($sqlvisita);
	$elcliente=$reg_visita ["clientePpto"];

	$sqlcliente=mysqli_query($con, "SELECT id,nombre FROM cliente WHERE pre='".$elcliente."';");
	$cliente=mysqli_fetch_array ($sqlcliente);

	$sqlusuario = mysqli_query($con, "SELECT * FROM credenciales where usuario='".$_SESSION['usuario_gmt']."';");
	$nombre= mysqli_fetch_array ($sqlusuario);
	
	$date=date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        

        <meta charset="utf-8" />
                <title>Solicitud de fondo</title>
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
		 
		 <script type="text/javascript">
			function ValidateForm1(theForm)
			{
				if (theForm.Combobox1.selectedIndex <= 0)
				{
				   alert("Campo APLICA A PRESUPUESTO sin llenar");
				   theForm.Combobox1.focus();
				   return false;
				}
				var strFilter = /^[0-9-.]*$/;
				var chkVal = theForm.importe.value;
				if (!strFilter.test(chkVal))
				{
				   alert("El IMPORTE solo admite digitos");
				   theForm.importe.focus();
				   return false;
				}
				if ((theForm.importe.value >= 401) && (theForm.RadioButton1.checked == true))
				{
				   alert("La cantidad solicitada excede el limite en efectivo");
				   theForm.importe.focus();
				   return false;
				}
				if (theForm.importe.value == "")
				{
				   alert("Indica el IMPORTE");
				   theForm.importe.focus();
				   return false;
				}
				var strFilter = /^[0-9-.]*$/;
				var chkVal = theForm.cuenta.value;
				if (!strFilter.test(chkVal))
				{
				   alert("La Cuenta solo admite digitos");
				   theForm.cuenta.focus();
				   return false;
				}

				var strFilter = /^[A-Za-z,ƒŠŒŽšœžŸÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ \t\r\n\f]*$/;
				var chkVal = theForm.beneficiario.value;
				if (!strFilter.test(chkVal))
				{
				   alert("El NOMBRE DEL BENEFICIARIO solo admite letras");
				   theForm.beneficiario.focus();
				   return false;
				}
				if (theForm.beneficiario.value == "")
				{
				   alert("El NOMBRE DEL BENEFICIARIO es obligatorio");
				   theForm.beneficiario.focus();
				   return false;
				}
				if (theForm.boxfpago.value == "")
				{
				   alert("La FECHA DE PAGO es obligatorio");
				   theForm.boxfpago.focus();
				   return false;
				}
				if (theForm.boxfpago.value < '<?php echo"$date";?>')
				{
				   alert("La FECHA DE PAGO es menor a la fecha de solicitud");
				   theForm.boxfpago.focus();
				   return false;
				}
				if (theForm.ComboboxMes.selectedIndex <= 0)
				{
				   alert("El MES EN EL QUE SE APLICA EL GASTO es obligatorio");
				   theForm.ComboboxMes.focus();
				   return false;
				}
				var strFilter = /^[A-Za-z,ƒŠŒŽšœžŸÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ \t\r\n\f0-9-]*$/;
				var chkVal = theForm.TextConcepto.value;
				if (!strFilter.test(chkVal))
				{
				   alert("El CONCEPTO contiene un caracter no valido");
				   theForm.TextConcepto.focus();
				   return false;
				}
				if (theForm.TextConcepto.value == "")
				{
				   alert("El campo CONCEPTO es obligatorio");
				   theForm.TextConcepto.focus();
				   return false;
				}
				if (theForm.mismoconcepto.selectedIndex <= 0)
				{
				   alert("Inidca si es el mismo concepto");
				   theForm.mismoconcepto.focus();
				   return false;
				}
				if (theForm.comprobable.selectedIndex <= 0)
				{
				   alert("Inidca si es comprobable");
				   theForm.comprobable.focus();
				   return false;
				}
				var strFilter = /^[A-Za-z,ƒŠŒŽšœžŸÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ \t\r\n\f0-9-]*$/;
				var chkVal = theForm.equivalencia.value;
				if (!strFilter.test(chkVal))
				{
				   alert("EQUIVALENCIA contiene un caracter no valido");
				   theForm.equivalencia.focus();
				   return false;
				}	
				/*if ((theForm.RadioButton5.checked == true)&&(theForm.equivalencia.value == ""))
				{
				   alert("ES NECESARIO INDICAR LA EQUIVALENCIA");
				   theForm.RadioButton5.focus();
				   return false;
				}*/
				if ((theForm.opcionBanco.selectedIndex <= 0)&&(theForm.RadioButton4.checked == true))
				{
				   alert("El BANCO es obligatorio");
				   theForm.opcionBanco.focus();
				   return false;
				}
				if ((theForm.opcionBanco.selectedIndex <= 0)&&(theForm.RadioButton4.checked == true))
				{
				   alert("Error! el campo '	' es obligatorio");
				   theForm.opcionBanco.focus();
				   return false;
				}
				if ((theForm.RadioButton2.checked != true) && (theForm.RadioButton1.checked != true) && (theForm.RadioButton4.checked != true))
				{
				   alert("Error! falta elegir una forma de pago");
				   theForm.RadioButton2.focus();
				   return false;
				}
				
			return true;
			}
		</script>

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
				<div>
					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header">
									<h2 ><?php echo $cliente ["nombre"]?></h2>
									<p class="text-muted mb-0"></p>
								</div><!--end card-header-->
								<div class="card-body">
									<form name="Form1" method="post" action="procesar_solicitud.php" id="Form1" onsubmit="return ValidateForm1(this)">
										<div class="row">
											<div class="col-lg-6">
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label for="solicitadopor" class="col-form-label text-end">Solicitado por</label>
														<input class="form-control" type="text" value="<?php echo $nombre ["nombre"];?>" name="solicitadopor" id="solicitadopor" readonly="true">
														<input type="hidden" name="idcliente"  value="<?php echo $cliente ["id"];?>"/></th></h1>
														<input type="hidden" name="ejecutivo"  value="<?php echo $nombre ["ejecutivo"];?>"/>
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label for="empresa" class="col-form-label text-end">Empresa</label>
														<input class="form-control" type="text" value="<?php echo $reg_visita ["empresa"]; ?>" name="empresa" readonly="true">
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label for="presupuesto" class="col-form-label text-end">Presupuesto</label>
														<input class="form-control" type="text" value="<?php echo $reg_visita ["nombrePpto"];?>" name="presupuesto" id="presupuesto" readonly="true">
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label for="clave" class="col-form-label text-end">Clave de Presupuesto</label>
														<input class="form-control" type="text" value="<?php echo $reg_visita ["clavePpto"];?>" name="clave" id="clave" readonly="true">
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label class="col-form-label text-end">Aplica a presupuesto</label>
														<select class="form-select" name="aplica" id="Combobox1">
															<option selected>Selecciona una opción</option>
															<option value="Si">Si</option>
															<option value="No">No</option>
														 </select>
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label for="importe" class="col-form-label text-end">Importe Neto</label>
														<input class="form-control" type="text" name="importe" id="importe" >
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label for="beneficiario" class="col-form-label text-end">Beneficiario</label>
														<input class="form-control" type="text" name="beneficiario" id="beneficiario">
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label for="rfc" class="col-form-label text-end">RFC</label>
														<input class="form-control" type="text" name="rfc" id="rfc">
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label for="fechapago" class="col-form-label text-end">Fecha de pago</label>
														<input class="form-control" type="date" name="fechapago" id="boxfpago">
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label class="col-form-label text-end">Mes en que aplica el pago</label>
														<select class="form-select" name="mesaplica" id="ComboboxMes">
															<option selected>Selecciona una opción</option>
															<option>ENERO</option>
															<option>FEBRERO</option>
															<option>MARZO</option>
															<option>ABRIL</option>
															<option>MAYO</option>
															<option>JUNIO</option>
															<option>JULIO</option>
															<option>AGOSTO</option>
															<option>SEPTIEMBRE</option>
															<option>OCTUBRE</option>
															<option>NOVIEMBRE</option>
															<option>DICIEMBRE</option>
														 </select>
													</div>
												</div>
											</div>
											
											<div class="col-lg-6">                                       
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label for="concepto" class="col-form-label text-end">Concepto</label>
														<textarea class="form-control" rows="1" id="TextConcepto" name="concepto"></textarea>
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label class="col-form-label text-end">Tiene el mismo concepto</label>
														<select class="form-select" name="mismoconcepto">
															<option selected>Selecciona una opción</option>
															<option value="Si">Si</option>
															<option value="No">No</option>
														 </select>
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label for="equivalencia" class="col-form-label text-end">Indica la equivalencia</label>
														<textarea class="form-control" rows="1" id="equivalencia" name="equivalencia"></textarea>
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label class="col-form-label text-end">Es comprobable?</label>
														<select class="form-select" name="comprobable" id="comprobable">
															<option selected>Selecciona una opción</option>
															<option value="Si">Si</option>
															<option value="No">No</option>
														 </select>
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label class="col-form-label text-end">Desglose</label>
														<select class="form-select" name="desgloce">
															<option selected>Selecciona una opción</option>
															<option>HONORARIOS, S. PROFESIONALES</option>
															<option>TRANSPORTE DE MERCANCIA Y/O FLETES</option>
															<option>TRANSPORTE DE PERSONAL</option>
															<option>OTRO</option>
														 </select>
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label class="col-form-label text-end">Banco</label>
														<select class="form-select" name="banco" id="opcionBanco">
															<option selected>Selecciona una opción</option>
															<option>BANCOMER</option>
															<option>AZTECA</option>
															<option>BANAMEX</option>
															<option>WALMART</option>
															<option>BANORTE</option>
															<option>BANREGIO</option>
															<option>HSBC</option>
															<option>INBURSA</option>
															<option>IXE</option>
															<option>SANTANDER</option>
															<option>SCOTIABANK</option>
															<option>OTRO</option>
														 </select>
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-md-9">
														<div class="form-check">
															<input class="form-check-input" type="radio" name="formaPago" id="RadioButton2" value="Cheque">
															<label class="form-check-label" for="RadioButton2">
															  Cheque
															</label>
														</div>
														<div class="form-check">
															<input class="form-check-input" type="radio" name="formaPago" id="RadioButton1" value="Efectivo">
															<label class="form-check-label" for="RadioButton1">
															  Efectivo
															</label>
														</div>
														<div class="form-check">
															<input class="form-check-input" type="radio" name="formaPago" id="RadioButton4" value="Transferencia">
															<label class="form-check-label" for="RadioButton4">
															  Transferencia
															</label>
														</div>
													</div>
												</div> <!-- end row -->
												<div class="mb-3 row">
													<div class="col-sm-10">
														<label for="cuenta" class="col-form-label text-end">Cuenta</label>
														<input class="form-control" type="text" name="cuenta" id="cuenta">
													</div>
												</div>
												<div class="mb-3 row">
													<div class="col-sm-10" align="center">
														<button class="btn btn-primary" type="submit" onclick="ValidateForm1();this.disabled=true">Enviar</button>
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
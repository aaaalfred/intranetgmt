<?php
	error_reporting(0);
	session_start();
	include('../../actions/conexion.php');
	
	$usuario=$_SESSION['usuario_gmt'];

	$con_last = new mysqli("localhost", "alfred", "aaabcde1409", "agencia_app");
	
	$cliente =$_POST["cliente"];
	$promocion =$_POST["promocion"];
	$npersonal_casting =$_POST["npersonal_casting"];
	$npersonal_requerido =$_POST["npersonal_requerido"];
	$puesto =$_POST["puesto"]; 
	$descripcion =$_POST["descripcion"];
	$escolaridad =$_POST["escolaridad"];
	$sueldo =$_POST["sueldo"];
	$bono =$_POST["bono"];
	$diaslaborar =$_POST["diaslaborar"];
	$horarios =$_POST["horarios"];
	$exp_movil =$_POST["exp_movil"];
	$edad =$_POST["edad"];
	$sexo =$_POST["sexo"];
	$zonas =$_POST["zonas"];
	$tiendas =$_POST["tiendas"];
	$experiencia =$_POST["experiencia"];
	$f_entrevista =$_POST["f_entrevista"];
	$h_entrevista =$_POST["h_entrevista"];
	$l_entrevista =$_POST["l_entrevista"];
	$f_ingreso =$_POST["f_ingreso"];
	$terminoplan =$_POST["terminoplan"];
	$requerimientos =$_POST["requerimientos"];
	$comentarios =$_POST["comentarios"];
	$fecha_solicitud =date('Y-m-d');
	$coordinacion =$_POST["coordinacion"];
	
	//var_dump($coordinacion);exit;
	
	//var_dump($fecha_solicitud);exit;
	
	$con_last->query("INSERT INTO reqpersonal VALUES (0, NOW(), '', '$usuario','".$cliente."','".$promocion."','".$npersonal_casting."','".$npersonal_requerido."','".$puesto."',
	'".$descripcion."','".$escolaridad."','".$sueldo."', 0,
	'".$diaslaborar."','".$horarios."', '', '".$edad."','".$sexo."','".$zonas."','".$tiendas."','".$experiencia."',
	'".$f_entrevista."','".$h_entrevista."','".$l_entrevista."',
	'".$f_ingreso."','".$terminoplan."','".$requerimientos."','".$exp_movil."','".$comentarios."','".$bono."','".$coordinacion."');");
	
	//obtenemos datos de usuario
	$sql = "SELECT id,correo,nombre FROM credenciales WHERE usuario = '$usuario'";
	$res = mysqli_query($con, $sql);
		
	if($row= mysqli_fetch_array($res)){
		$correo=$row["correo"];
		$nombre=$row["nombre"];
	}
	
	//Trae los datos del cliente
	$sql2 = "SELECT nombre FROM cliente WHERE pre = '$cliente'";
	$res2 = mysqli_query($con, $sql2);
	if($row2= mysqli_fetch_array($res2)){
		$cliente=$row2["nombre"];
	}
	
	//Obtener el id del utimo registro en reqpersonal
	$id = $con_last->insert_id;
	//$id =1000;

			
		  // primero hay que incluir la clase phpmailer para poder instanciar
		  //un objeto de la misma
		  require "../../assets/includes/class.phpmailer.php";

		  //instanciamos un objeto de la clase phpmailer al que llamamos 
		  //por ejemplo mail
		  $mail = new phpmailer();

		  //Definimos las propiedades y llamamos a los métodos 
		  //correspondientes del objeto mail

		  //Con PluginDir le indicamos a la clase phpmailer donde se 
		  //encuentra la clase smtp que como he comentado al principio de 
		  //este ejemplo va a estar en el subdirectorio includes
		  $mail->PluginDir = "includes/";

		  //Con la propiedad Mailer le indicamos que vamos a usar un 
		  //servidor smtp
		  $mail->Mailer = "smtp";

		  //Asignamos a Host el nombre de nuestro servidor smtp
		  $mail->Host = "smtp.uservers.net";
		  ///$mail->Host = "69.174.246.183"; AAA

		  //Le indicamos que el servidor smtp requiere autenticación
		  $mail->SMTPAuth = true;

		  //Le decimos cual es nuestro nombre de usuario y password
		  $mail->Username = "solicitud@mctree.com.mx"; 
		  $mail->Password = "15S09cheque";

		  //Indicamos cual es nuestra dirección de correo y el nombre que 
		  //queremos que vea el usuario que lee nuestro correo
		  $mail->From = "sescobar@mctree.com.mx";
		  $mail->FromName = "Pruebas de REQPERSONAL";
		  //$mail->From = "solicitud@mctree.com.mx";
		  //$mail->FromName = "REQUERIMIENTO DE PERSONAL";

		  //el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar 
		  //una cuenta gratuita, por tanto lo pongo a 30  
		  $mail->Timeout=10;

		  //Indicamos cual es la dirección de destino del correo
		 // $mail->AddAddress("$correo_usuario");
		  //$mail->AddBCC("aambriz@mctree.com.mx");
		  
		  //$mail->AddAddress("sescobar@mctree.com.mx");
		  
		  //sE COMENTARON YA QUE SE HARAN PRUEBAS
		  $mail->AddAddress("sescobar@mctree.com.mx");
		  /*$mail->AddAddress("aambriz@mctree.com.mx");
		  $mail->AddAddress("aalfaro@mctree.com.mx");
		  $mail->AddAddress("fmoreno@mctree.com.mx");
		  $mail->AddAddress("dseveriano@mctree.com.mx");
		  $mail->AddAddress("iortega@mctree.com.mx");
		  $mail->AddAddress("ecervantes@mctree.com.mx");
		  $mail->AddAddress("$coordinacion");
		  $mail->AddAddress("$correo");*/

		  //Asignamos asunto y cuerpo del mensaje
		  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
		  //que se vea en negrita
		  $mail->Subject = "Solicitud de $nombre";
		  $mail->Body = '
			<table class="body-wrap" style="box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;" bgcolor="transparent">
                            <tr>
                                <td valign="top"></td>
                                <td class="container" width="600" style="display: block !important; max-width: 600px !important; clear: both !important;" valign="top">
                                    <div class="content" style="padding: 20px;">
                                        <table class="main" width="100%" cellpadding="0" cellspacing="0" style="border: 1px dashed #4d79f6;">
                                            <tr>
                                                <td class="content-wrap aligncenter" style="padding: 20px; background-color: transparent;" align="center" valign="top">
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <!-- <a href="#"><img src="assets/images/logo-sm.png" alt="" style="height: 40px; margin-left: auto; margin-right: auto; display:block;"></a> -->
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block" style="padding: 0 0 20px;" valign="top">
                                                                <h2 class="aligncenter" style="font-size: 24px; color:#98a2bd; line-height: 1.2em; font-weight: 600; text-align: center;" align="center">Solicitud de personal <span style="color: #4d79f6; font-weight: 700;">#'.$id.'</span></h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block aligncenter" style="padding: 0 0 20px;" align="center" valign="top">
                                                                <table class="invoice" style="width: 80%;">
                                                                    <tr>
                                                                        <td style="font-size: 14px; padding: 5px 0;" valign="top">Solicito: '.$nombre.'
                                                                            <br/>Fecha: '.$fecha_solicitud.'
                                                                            <br/>Cliente: '.$cliente.'
																			<br/>Promoción: '.$promocion.'
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="padding: 5px 0;" valign="top">
                                                                            <table class="invoice-items" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Personal para casting</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$npersonal_casting.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Personal requerido real</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$npersonal_requerido.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Puesto</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$puesto.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Descripción</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$descripcion.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Escolaridad</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$escolaridad.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Sueldo</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$sueldo.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Bono</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$bono.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Dias a laborar</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$diaslaborar.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Horarios</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$horarios.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Experiencia</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$experiencia.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Zonas</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$zonas.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Tiendas</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$tiendas.'</td>
                                                                                </tr>
																				<tr>
																					<td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top"> </td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> </td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Edad</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$edad.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Experiencia con movil</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$exp_movil.'</td>
                                                                                </tr>
																				<tr>
                                                                                    <td style="font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Sexo</td>
                                                                                    <td class="alignright" style="font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top"> '.$sexo.'</td>
                                                                                </tr>
																				
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                <a href="#" style="font-size: 14px; color: #4d79f6; text-decoration: none; margin: 0;">Entrevista/Casting</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                Fecha: '.$f_entrevista.'
                                                            </td>
                                                        </tr>
														<tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                Hora: '.$h_entrevista.'
                                                            </td>
                                                        </tr>
														<tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                Lugar: '.$l_entrevista.'
                                                            </td>
                                                        </tr>
														
														<tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                <a href="#" style="font-size: 14px; color: #4d79f6; text-decoration: none; margin: 0;">Inicio y Fin de Plan</a>
                                                            </td>
                                                        </tr>
														<tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                Fecha de ingreso:  '.$f_ingreso.'
                                                            </td>
                                                        </tr>
														<tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                Termino del plan:  '.$terminoplan.'
                                                            </td>
                                                        </tr>
														
														<tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                <a href="#" style="font-size: 14px; color: #4d79f6; text-decoration: none; margin: 0;"></a>
                                                            </td>
                                                        </tr>
														<tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                Requerimientos Particulares:  '.$requerimientos.'
                                                            </td>
                                                        </tr>
														<tr>
                                                            <td class="content-block aligncenter" style="font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                Comentarios:  '.$comentarios.'
                                                            </td>
                                                        </tr>
														
                                                    </table><!--end table-->   
                                                </td>
                                            </tr>
                                        </table><!--end table-->                                               
                                    </div><!--end content-->   
                                </td>
                                <td style="font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                            </tr>
                        </table>
		  ';
		/*$mail->Body = "REQUERIMIENTO DE PERSONAL #$id
		  
		Solicito: $nombre 
		Fecha $fecha_solicitud
		Cliente: $cliente  		 PROMOCION:$promocion

		Personal para casting:	$nocasting
		Personal requerido real:  $noreal
		Puesto:  $puesto
		Descripcion del Puesto:  $descpuesto
		Escolaridad:  $escolaridad
		Presupuesto:  $presupuesto
		Bono:  $bono
		Dias a laborar:  $dias
		Horarios:  $horarios
		Experiencia:  $experiencia
		Zonas:  $zonas
		Tiendas:  $tiendas

		Edad:  $edad
		Experiencia con Movil:  $movil
		Sexo:  $sexo

		*ENTREVISTA/CASTING
		Fecha: $fechacasting		Hora: $fyhcasting
		Lugar: $lugarcasting

		*INICIO Y FIN DEL PLAN
		Fecha de ingreso:  $fingreso
		Termino del plan:  $fsalida

		Requerimientos Particulares:  $requerimientos

		Comentarios:  $coment

			";*/

		  //Definimos AltBody por si el destinatario del correo no admite email con formato html 
		  $mail->AltBody = "mensaje";
		  
		  $mail->CharSet = "UTF-8";

		  //se envia el mensaje, si no ha habido problemas 
		  //la variable $exito tendra el valor true
		  $exito = $mail->Send();

	
		//header("Location:folio.php");	
		header("Location: ../dashboard.php");
	
?>
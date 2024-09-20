<?php

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=SOLICITUDES ".$_SESSION ["fechai"]." al ".$_SESSION ["fechaf"].".xls");
header("Pragma: no-cache");
header("Expires: 0");		  
		  session_start();

include ("../conexion.php");

$solicitudes=mysqli_query($con, "SELECT solicitud.id, cliente.nombre as cliente, solicitud.rfc, solicitud.clave,presupuesto.nombrePpto,
solicitud.aplica, solicitud.fecha, solicitud.fechadepago,solicitud.mesqaplica,
solicitud.importe-(solicitud.subtotal + solicitud.iva + solicitud.retenciones) as xcomprobar, solicitud.importe,solicitud.subtotal,solicitud.iva,solicitud.retenciones,
solicitud.desgloce, solicitud.cuenta,
solicitud.formaPago, solicitud.concepto, solicitud.comprobable, solicitud.solicita, solicitud.empresa , solicitud.mismoconcepto , solicitud.equivalencia, solicitud.autorizado,
solicitud.fautorizacion,solicitud.status,solicitud.fechapagado, observaciones
FROM solicitud INNER JOIN cliente, presupuesto
WHERE solicitud.idCliente=cliente.id and solicitud.clave=presupuesto.clavePpto and solicitud.fecha BETWEEN '".$_SESSION["fechai"]."' and DATE_ADD('".$_SESSION["fechaf"]."', INTERVAL 1 DAY)
GROUP BY id;");

?>

<body id="sidebar-left">
<table border="1" class="display" id="example"> 
<thead>
	<tr>	
		<th bgcolor="#0099FF" nowrap="nowrap">ID</th>
		<th bgcolor="#0099FF" nowrap="nowrap">EMPRESA</th>
		<th bgcolor="#0099FF" nowrap="nowrap">CLIENTE</th>
		<th bgcolor="#0099FF" nowrap="nowrap">RFC</th>
		<th bgcolor="#0099FF" nowrap="nowrap">CLAVE</th>
		<th bgcolor="#0099FF" nowrap="nowrap">NOMBRE PPTO</th>
		<th bgcolor="#0099FF" nowrap="nowrap">APLICA PPTO</th>
		<th bgcolor="#0099FF" nowrap="nowrap">SOLICITO</th>	
		<th bgcolor="#0099FF" nowrap="nowrap">FECHA</th>
		<th bgcolor="#0099FF" nowrap="nowrap">MES DE SOLICITUD</th>
		<th bgcolor="#0099FF" nowrap="nowrap">FECHA DE PAGO</th>
		<th bgcolor="#0099FF" nowrap="nowrap">MES DE PAGO</th>
		<th bgcolor="#0099FF" nowrap="nowrap">MES EN EL QUE APLICA EL GASTO</th>
		<th bgcolor="#0099FF" nowrap="nowrap">AUTORIZADO</th>
		
		<th bgcolor="#0099FF" nowrap="nowrap">FECHA DE AUTORIZACION</th>
		<th bgcolor="#0099FF" nowrap="nowrap">MES DE AUTORIZACION</th>

		<th bgcolor="#0099FF" nowrap="nowrap">IMPORTE</th>
		<th bgcolor="#0099FF" nowrap="nowrap">SUBTOTAL</th>
		<th bgcolor="#0099FF" nowrap="nowrap">IVA</th>
		<th bgcolor="#0099FF" nowrap="nowrap">RETENCIONES</th>
		<th bgcolor="#0099FF" nowrap="nowrap">STATUS</th>
		
		<th bgcolor="#0099FF" nowrap="nowrap">FECHA EN QUE SE PAGO</th>
		<th bgcolor="#0099FF" nowrap="nowrap">COMPROBABLE</th>
		<th bgcolor="#0099FF" nowrap="nowrap">POR COMPROBAR</th>
		<th bgcolor="#0099FF" nowrap="nowrap">FECHA DE COMPROBACION</th>
		<th bgcolor="#0099FF" nowrap="nowrap">COMPROBAR HISTORICO</th>
		<th bgcolor="#0099FF" nowrap="nowrap">REEMBOLSO</th>
		<th bgcolor="#0099FF" nowrap="nowrap">FECHA DE REEMBOLSO</th>		
		<th bgcolor="#0099FF" nowrap="nowrap">MES DE REEMBOLSO</th>
		
		<th bgcolor="#0099FF" nowrap="nowrap">DESGLOCE</th>
		<th bgcolor="#0099FF" nowrap="nowrap">CUENTA</th>
		<th bgcolor="#0099FF" nowrap="nowrap">FORMA PAGO</th>
		<th bgcolor="#0099FF" nowrap="nowrap">MISMO CONCEPTO</th>
		<th bgcolor="#0099FF" nowrap="nowrap">CONCEPTO</th>
		<th bgcolor="#0099FF" nowrap="nowrap">EQUIVALENCIA</th>
		<th bgcolor="#0099FF" nowrap="nowrap">OBSERVACIONES</th>
	</tr> 
</thead> 
<tbody> 
<?php	while ($fila=mysqli_fetch_array($solicitudes))
	{?>
		<tr class="gradeA"> 
			<td><?php echo $fila ["id"]; ?></td>
			<td><?php echo $fila ["empresa"]; ?></td>
			<td><?php echo $fila ["cliente"]; ?></td>
			<td><?php echo $fila ["rfc"]; ?></td>
			<td><?php echo $fila ["clave"]; ?></td>
			<td><?php echo $fila ["nombrePpto"]; ?></td>
			<td><?php echo $fila ["aplica"]; ?></td>
			<td><?php echo $fila ["solicita"]; ?></td>
			<td><?php echo $fila ["fecha"]; ?></td>	
			<?php $mes = new DateTime($fila ["fecha"]);?>
			<td><?php $fecha=$mes->format('F');
			if ($fecha=="January") $fecha="ENERO";if ($fecha=="February") $fecha="FEBRERO";if ($fecha=="March") $fecha="MARZO";if ($fecha=="April") $fecha="ABRIL";if ($fecha=="May") $fecha="MAYO";
			if ($fecha=="June") $fecha="JUNIO";if ($fecha=="July") $fecha="JULIO";if ($fecha=="August") $fecha="AGOSTO";if ($fecha=="September") $fecha="SEPTIEMBRE";if ($fecha=="October") $fecha="OCTUBRE";
			if ($fecha=="NOVEMBER") $fecha="Noviembre";if ($fecha=="December") $fecha="DICIEMBRE";
			 echo $fecha;
			?></td>	
			<td><?php echo $fila ["fechadepago"]; ?></td>
			<?php $mes = new DateTime($fila ["fechadepago"]);?>
			<td><?php $fecha=$mes->format('F');
			if ($fecha=="January") $fecha="ENERO";if ($fecha=="February") $fecha="FEBRERO";if ($fecha=="March") $fecha="MARZO";if ($fecha=="April") $fecha="ABRIL";if ($fecha=="May") $fecha="MAYO";
			if ($fecha=="June") $fecha="JUNIO";if ($fecha=="July") $fecha="JULIO";if ($fecha=="August") $fecha="AGOSTO";if ($fecha=="September") $fecha="SEPTIEMBRE";if ($fecha=="October") $fecha="OCTUBRE";
			if ($fecha=="NOVEMBER") $fecha="Noviembre";if ($fecha=="December") $fecha="DICIEMBRE";
			 echo $fecha;
			?></td>
			<td><?php echo $fila ["mesqaplica"]; ?></td>
			<td><?php echo $fila ["autorizado"]; ?></td>
			<td><?php echo $fila ["fautorizacion"]; ?></td>
			<?php $mes = new DateTime($fila ["fautorizacion"]);?>
			<td><?php $fechaautorizacion=$mes->format('F');
			if ($fechaautorizacion=="January") $fechaautorizacion="ENERO";if ($fechaautorizacion=="February") $fechaautorizacion="FEBRERO";if ($fechaautorizacion=="March") $fechaautorizacion="MARZO";if ($fechaautorizacion=="April") $fechaautorizacion="ABRIL";if ($fechaautorizacion=="May") $fechaautorizacion="MAYO";
			if ($fechaautorizacion=="June") $fechaautorizacion="JUNIO";if ($fechaautorizacion=="July") $fechaautorizacion="JULIO";if ($fechaautorizacion=="August") $fechaautorizacion="AGOSTO";if ($fechaautorizacion=="September") $fechaautorizacion="SEPTIEMBRE";if ($fechaautorizacion=="October") $fechaautorizacion="OCTUBRE";
			if ($fechaautorizacion=="NOVEMBER") $fechaautorizacion="Noviembre";if ($fechaautorizacion=="December") $fechaautorizacion="DICIEMBRE";
			if ($fechaautorizacion==null) $fechaautorizacion="a";
			 echo $fechaautorizacion;
			?></td>
			
			<td><?php echo $fila ["importe"]; ?></td>
			<td><?php echo $fila ["subtotal"]; ?></td>
			<td><?php echo $fila ["iva"]; ?></td>
			<td><?php echo $fila ["retenciones"]; ?></td>
			<td><?php echo $fila ["status"]; ?></td>
			<td><?php echo $fila ["fechapagado"]; ?></td>
			<td><?php echo $fila ["comprobable"]; ?></td>
			<td><?php echo $fila ["xcomprobar"]; ?></td>
			<td>FECHA DE COMPROBACION</td>
			<td>COMPROBAR HISTORICO</td>
			<td>REEMBOLSO</td>
			<td>FECHA DE REEMBOLSO</td>
			<td>MES DE REEMBOLSO</td>
			
			<td><?php echo $fila ["desgloce"]; ?></td>
			<td><?php echo $fila ["cuenta"]; ?></td>
			<td><?php echo $fila ["formaPago"]; ?></td>
			<td><?php echo $fila ["mismoconcepto"]; ?></td>	
			<td><?php echo $fila ["concepto"]; ?></td>
			<td><?php echo $fila ["equivalencia"]; ?></td>
			<td><?php echo $fila ["observaciones"]; ?></td>
		</tr>

		<?php
}?>
</tbody> 
</table> 
<p>

<?php
$dia=date("l");
if ($dia=="Monday") $dia="Lunes";
if ($dia=="Tuesday") $dia="Martes";
if ($dia=="Wednesday") $dia="Mi&eacute;rcoles";
if ($dia=="Thursday") $dia="Jueves";
if ($dia=="Friday") $dia="Viernes";
if ($dia=="Saturday") $dia="Sabado";
if ($dia=="Sunday") $dia="Domingo";
$dia2=date("d");
$mes=date("F");
if ($mes=="January") $mes="Enero";
if ($mes=="February") $mes="Febrero";
if ($mes=="March") $mes="Marzo";
if ($mes=="April") $mes="Abril";
if ($mes=="May") $mes="Mayo";
if ($mes=="June") $mes="Junio";
if ($mes=="July") $mes="Julio";
if ($mes=="August") $mes="Agosto";
if ($mes=="September") $mes="Septiembre";
if ($mes=="October") $mes="Octubre";
if ($mes=="November") $mes="Noviembre";
if ($mes=="December") $mes="Diciembre";
$ano=date("Y");
echo "Generado el dia: $dia $dia2 de $mes de $ano";
?>
</p>
</body>
</html>
<?php

	session_start();

	require_once '../../../assets/PHPExcel/Classes/PHPExcel.php';
	include ("../../../actions/conexion.php");
	
	
	function quitar_acentos($cadena){
		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðòóôõöøùúûýýþÿ';
		$modificadas = 'aaaaaaaceeeeiiiidoooooouuuuybsaaaaaaaceeeeiiiidoooooouuuyyby';
		$cadena = utf8_decode($cadena);
		$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
		return utf8_encode($cadena);
	}
	
	
	$titulo = $_POST['modulo2'];
	$query_exportar = "";
	
	//convierte las claves en lista para poder recorrerlas y hacer mach con los usuarios que contengan la clave ejecutivo
	$porciones = explode(",", $_SESSION["clave_gmt"]);
	$query_claves = "";
	//Recorre las claves para poder llamar solo los usuarios que califiquen
	
	if(!empty($_POST['codsel'])){
			$claves_texto = implode(",", $_POST['codsel']);
			$query_claves = " clave_ejecutivo IN (".$claves_texto.")";
	}else{
	
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
	
	
	if($_POST['modulo2'] === "Candidatos"){
		
		if(($_POST['fechai2'] != "" || $_POST['fechai2'] != null) AND ($_POST['fechaf2'] != "" || $_POST['fechaf2'] != null)){
			$condicion_fechas = " AND fechaAlta BETWEEN '".$_POST['fechai2']."' AND DATE_ADD('".$_POST['fechaf2']."', INTERVAL 1 DAY) ";
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado IS NULL AND (estatus != 'Inactivo' OR estatus IS NULL) AND ".$query_claves." ".$condicion_fechas." ORDER BY fechaAlta DESC;");
		}else{
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado IS NULL AND (estatus != 'Inactivo' OR estatus IS NULL) AND ".$query_claves." ORDER BY fechaAlta DESC;");
		}
		
	}
	if($_POST['modulo2'] === "Preaprobados"){
		
		if(($_POST['fechai2'] != "" || $_POST['fechai2'] != null) AND ($_POST['fechaf2'] != "" || $_POST['fechaf2'] != null)){
			
			$condicion_fechas = " AND fechaAlta BETWEEN '".$_POST['fechai2']."' AND DATE_ADD('".$_POST['fechaf2']."', INTERVAL 1 DAY) ";
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado = 1 AND autorizado_dos IS NULL AND (estatus != 'Inactivo' OR estatus IS NULL) AND ".$query_claves." ".$condicion_fechas." ORDER BY fechaAlta DESC;");
			
		}else{
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado = 1 AND autorizado_dos IS NULL AND (estatus != 'Inactivo' OR estatus IS NULL) AND ".$query_claves." ORDER BY fechaAlta DESC;");
		}
		
	}
	if($_POST['modulo2'] === "Aprobados"){
		
		if(($_POST['fechai2'] != "" || $_POST['fechai2'] != null) AND ($_POST['fechaf2'] != "" || $_POST['fechaf2'] != null)){
			
			$condicion_fechas = " AND fechaAlta BETWEEN '".$_POST['fechai2']."' AND DATE_ADD('".$_POST['fechaf2']."', INTERVAL 1 DAY) ";
			
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado = 1 AND autorizado_dos = 1 AND (estatus != 'Inactivo' OR estatus IS NULL) AND ".$query_claves." ".$condicion_fechas." ORDER BY fechaAlta DESC;");
			
		}else{
			$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE autorizado = 1 AND autorizado_dos = 1 AND (estatus != 'Inactivo' OR estatus IS NULL) AND ".$query_claves." ORDER BY fechaAlta DESC;");
		}
		
	}
	
	
    //Creacion del objeto excel
    $objPHPExcel = new PHPExcel();

    // Establecer propiedades
    $objPHPExcel->getProperties()
    ->setCreator("MCTREE")
    ->setLastModifiedBy("MCTREE")
    ->setTitle("Documento Excel ".$titulo)
    ->setSubject("Documento Excel ".$titulo)
    ->setDescription($titulo)
    ->setKeywords("Excel Office 2007 openxml php")
    ->setCategory($titulo);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);

    $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('Q')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('R')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('T')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 

    $sharedStyle1 = new PHPExcel_Style();

    $sharedStyle1->applyFromArray(
      array('borders' => array(
        'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
      )
    );

    // Agregar Informacion
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'ID')
    ->setCellValue('B1', 'FECHA')
    ->setCellValue('C1', 'NOMBRE')
    ->setCellValue('D1', 'CURP')
    ->setCellValue('E1', 'RFC')
    ->setCellValue('F1', 'NUM. IMSS')
    ->setCellValue('G1', 'FECHA DE NACIMIENTO')
    ->setCellValue('H1', 'ESTADO')
    ->setCellValue('I1', 'SEXO')
    ->setCellValue('J1', 'TELEFONO')
    ->setCellValue('K1', 'REGIMEN FISCAL')
    ->setCellValue('L1', 'CODIGO POSTAL')
    ->setCellValue('M1', 'CORREO')
    ->setCellValue('N1', 'INFONAVIT')
    ->setCellValue('O1', 'CUENTA')
    ->setCellValue('P1', 'FONACOT')
    ->setCellValue('Q1', 'CUENTA')
    ->setCellValue('R1', 'CLABE')
    ->setCellValue('S1', 'BANCO')
    ->setCellValue('T1', 'No. CUENTA');
    $cont = 2;
    while ($fila=mysqli_fetch_array($query_exportar))
    {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$cont, $fila['id'])
        ->setCellValue('B'.$cont, $fila['fechaAlta'])
        ->setCellValue('C'.$cont, strtoupper(quitar_acentos($fila['app']." ".$fila['apm']." ".$fila['nombre'])))
        ->setCellValue('D'.$cont, strtoupper($fila['curp']))
        ->setCellValue('E'.$cont, strtoupper($fila['rfc']))
        ->setCellValue('F'.$cont, $fila['nss'])
        ->setCellValue('G'.$cont, $fila['fecha_nacimiento'])
        ->setCellValue('H'.$cont, strtoupper($fila['estado']))
        ->setCellValue('I'.$cont, strtoupper($fila['sexo']))
        ->setCellValue('J'.$cont, $fila['telefono'])
        ->setCellValue('K'.$cont, strtoupper($fila['regimen_fiscal']))
        ->setCellValue('L'.$cont, $fila['cp'])
        ->setCellValue('M'.$cont, $fila['correo']);
        if($fila['infonavit'] == "true"){
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('N'.$cont, "Si")
          ->setCellValue('O'.$cont, $fila['cuenta_infonavit']);
        }else{
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('N'.$cont, "No")
          ->setCellValue('O'.$cont, "-");
        }
        if($fila['fonacot'] == "true"){
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('P'.$cont, "Si")
          ->setCellValue('Q'.$cont, $fila['cuenta_fonacot']);
        }else{
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('P'.$cont, "No")
          ->setCellValue('Q'.$cont, "-");
        }
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('R'.$cont, "=\"" .$fila['clabe']. "\"")
        ->setCellValue('S'.$cont, $fila['banco'])
        ->setCellValue('T'.$cont, $fila['no_cuenta']);
        $cont = $cont+1;
    }

    $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:T".($cont-1));

    // Renombrar Hoja
    $objPHPExcel->getActiveSheet()->setTitle('Data');
     
    // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
    $objPHPExcel->setActiveSheetIndex(0);
     
    // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$titulo.'.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
	
	header("location: exportar.php");
?>
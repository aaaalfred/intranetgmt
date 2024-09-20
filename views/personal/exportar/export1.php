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
	
	
	$titulo = "";
	$query_exportar = "";
	if($_POST['radioexp'] == "all"){
		$titulo = "data_all";
		$query_exportar = mysqli_query($con,"SELECT usuarios.*, autorizaciones.check_uno, autorizaciones.check_dos, autorizaciones.fecha_check_uno, autorizaciones.fecha_check_dos FROM usuarios LEFT JOIN autorizaciones ON usuarios.id = autorizaciones.usuario_id ORDER BY fechaAlta DESC;");
	}else{
		$titulo = "data_fechas";
		$query_exportar = mysqli_query($con,"SELECT usuarios.*, autorizaciones.check_uno, autorizaciones.check_dos, autorizaciones.fecha_check_uno, autorizaciones.fecha_check_dos FROM usuarios LEFT JOIN autorizaciones ON usuarios.id = autorizaciones.usuario_id WHERE fechaAlta BETWEEN '".$_POST['fechai']."' AND DATE_ADD('".$_POST['fechaf']."', INTERVAL 1 DAY) ORDER BY fechaAlta DESC;");
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
	$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);

    /*
	$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('Q')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('R')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
    $objPHPExcel->getActiveSheet()->getStyle('T')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT); 
	*/
	
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
    ->setCellValue('C1', 'NOMBRE COMPLETO')
	->setCellValue('D1', 'APELLIDO PATERNO')
	->setCellValue('E1', 'APELLIDO MATERNO')
	->setCellValue('F1', 'NOMBRE')
    ->setCellValue('G1', 'CURP')
    ->setCellValue('H1', 'RFC')
    ->setCellValue('I1', 'NUM. IMSS')
    ->setCellValue('J1', 'FECHA DE NACIMIENTO')
    ->setCellValue('K1', 'ESTADO')
    ->setCellValue('L1', 'SEXO')
    ->setCellValue('M1', 'TELEFONO')
    ->setCellValue('N1', 'REGIMEN FISCAL')
    ->setCellValue('O1', 'CODIGO POSTAL')
    ->setCellValue('P1', 'CORREO')
    ->setCellValue('Q1', 'INFONAVIT')
    ->setCellValue('R1', 'CUENTA')
    ->setCellValue('S1', 'FONACOT')
    ->setCellValue('T1', 'CUENTA')
    ->setCellValue('U1', 'CLABE')
    ->setCellValue('V1', 'BANCO')
	->setCellValue('W1', 'No. CUENTA')
    ->setCellValue('X1', 'STATUS');
    $cont = 2;
    while ($fila=mysqli_fetch_array($query_exportar))
    {
		$status = "";
		if($fila['autorizado'] == null AND $fila['autorizado_dos'] == null){
			$status = "Candidato";
		}else if($fila['autorizado'] == 1 AND $fila['autorizado_dos'] == null){
			$status = "Preaprobado";
		}else if($fila['autorizado'] == 1 AND $fila['autorizado_dos']  == 1){
			if($fila['estatus'] == null || $fila['estatus'] == "Activo"){
			$status = "Aprobado";
			}else{
				$status = "Stand-by";
			}
		}
		
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$cont, $fila['id'])
        ->setCellValue('B'.$cont, $fila['fechaAlta'])
        ->setCellValue('C'.$cont, strtoupper(quitar_acentos($fila['app']." ".$fila['apm']." ".$fila['nombre'])))
		->setCellValue('D'.$cont, strtoupper(quitar_acentos($fila['app'])))
		->setCellValue('E'.$cont, strtoupper(quitar_acentos($fila['apm'])))
		->setCellValue('F'.$cont, strtoupper(quitar_acentos($fila['nombre'])))
        ->setCellValue('G'.$cont, strtoupper($fila['curp']))
        ->setCellValue('H'.$cont, strtoupper($fila['rfc']))
        ->setCellValue('I'.$cont, $fila['nss'])
        ->setCellValue('J'.$cont, $fila['fecha_nacimiento'])
        ->setCellValue('K'.$cont, strtoupper($fila['estado']))
        ->setCellValue('L'.$cont, strtoupper($fila['sexo']))
        ->setCellValue('M'.$cont, $fila['telefono'])
        ->setCellValue('N'.$cont, strtoupper($fila['regimen_fiscal']))
        ->setCellValue('O'.$cont, $fila['cp'])
        ->setCellValue('P'.$cont, $fila['correo']);
        if($fila['infonavit'] == "true"){
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('Q'.$cont, "Si")
          ->setCellValue('R'.$cont, $fila['cuenta_infonavit']);
        }else{
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('Q'.$cont, "No")
          ->setCellValue('R'.$cont, "-");
        }
        if($fila['fonacot'] == "true"){
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('S'.$cont, "Si")
          ->setCellValue('T'.$cont, $fila['cuenta_fonacot']);
        }else{
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('S'.$cont, "No")
          ->setCellValue('T'.$cont, "-");
        }
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('U'.$cont, "=\"" .$fila['clabe']. "\"")
        ->setCellValue('V'.$cont, $fila['banco'])
        ->setCellValue('W'.$cont, $fila['no_cuenta'])
		->setCellValue('X'.$cont, $status);
        $cont = $cont+1;
    }

    $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:X".($cont-1));

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
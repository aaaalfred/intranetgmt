<?php

	session_start();

	require_once '../../../assets/PHPExcel/Classes/PHPExcel.php';
	include ("../../../actions/conexion.php");
	
	//var_dump($_POST['curpsb']);exit;
	function quitar_acentos($cadena){
		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðòóôõöøùúûýýþÿ';
		$modificadas = 'aaaaaaaceeeeiiiidoooooouuuuybsaaaaaaaceeeeiiiidoooooouuuyyby';
		$cadena = utf8_decode($cadena);
		$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
		return utf8_encode($cadena);
	}
	
	
	$titulo = "CURPS";
	$query_exportar = "";
	
	
	$query_exportar = mysqli_query($con,"SELECT usuarios.* FROM usuarios WHERE curp IN (".$_POST['curpsb'].");");
	
	
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
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);

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
    ->setCellValue('A1', 'TR_CURP')
    ->setCellValue('B1', 'TR_PATERNO')
    ->setCellValue('C1', 'TR_MATERNO')
    ->setCellValue('D1', 'TR_NOMBRE')
    ->setCellValue('E1', 'TR_IMSS')
    ->setCellValue('F1', 'TR_RFC')
    ->setCellValue('G1', 'TR_FECHA_NACIMIENTO')
    ->setCellValue('H1', 'TR_SEXO');
    $cont = 2;
    while ($fila=mysqli_fetch_array($query_exportar))
    {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$cont, strtoupper($fila['curp']))
        ->setCellValue('B'.$cont, strtoupper(quitar_acentos($fila['app'])))
        ->setCellValue('C'.$cont, strtoupper(quitar_acentos($fila['apm'])))
        ->setCellValue('D'.$cont, strtoupper(quitar_acentos($fila['nombre'])))
        ->setCellValue('E'.$cont, $fila['nss'])
        ->setCellValue('F'.$cont, strtoupper($fila['rfc']))
        ->setCellValue('G'.$cont, $fila['fecha_nacimiento']);
		if($fila['sexo'] == "Hombre"){
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('H'.$cont, 0);
		}else{
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('H'.$cont, 1);
		}
        $cont = $cont+1;
    }

    $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:H".($cont-1));

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
<?php
require_once("../classes/phprtflite/Rtf.php");
require('../../../funciones/funciones.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
require('../../../classes/querys/query.php');

$query=new query();
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$borde=$_POST['borde'];
$color_borde=$_POST['color_borde'];
$orientacion=$_POST['orientacion'];
$ancho_borde=$_POST['ancho_borde'];
$color_fondo_panel=$_POST['color_fondo'];
$tipo_borde_panel=$_POST['tipo_borde'];

// Compruebo si el Panel es Personalizado o desde Plantilla
if ($_POST['desde']==1) {

	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	$sect->setPaperHeight(21);
	$sect->setPaperWidth(29.7);
	
	$rtf->sendRtf('Panel personalizado');

} elseif ($_POST['desde']==2) {

	$datos_plantilla=$query->datos_plantilla_panel($_POST['mi_seleccion']);
	
	switch ($_POST['mi_seleccion']) {
	
	case 1:  // PLANTILLA CHATBOX
	
	//paragraph formats
	$parF = new ParFormat();
	
	$img[1][1]=$_POST['img_1_1_1'];
	$img[1][2]=$_POST['img_1_1_2'];
	$img[1][3]=$_POST['img_1_1_3'];
	$img[1][4]=$_POST['img_1_1_4'];
	$img[2][1]=$_POST['img_1_2_1'];
	$img[2][2]=$_POST['img_1_2_2'];
	$img[2][3]=$_POST['img_1_2_3'];
	$img[2][4]=$_POST['img_1_2_4'];
	$img[3][1]=$_POST['img_1_3_1'];
	$img[3][2]=$_POST['img_1_3_2'];
	$img[3][3]=$_POST['img_1_3_3'];
	$img[3][4]=$_POST['img_1_3_4'];
	$img[4][1]=$_POST['img_1_4_1'];
	$img[4][2]=$_POST['img_1_4_2'];
	$img[4][3]=$_POST['img_1_4_3'];
	$img[4][4]=$_POST['img_1_4_4'];
	
	$encript->desencriptar($img[1][1],1); 
	$encript->desencriptar($img[1][2],1);
	$encript->desencriptar($img[1][3],1);
	$encript->desencriptar($img[1][4],1);
	$encript->desencriptar($img[2][1],1);
	$encript->desencriptar($img[2][2],1);
	$encript->desencriptar($img[2][3],1);
	$encript->desencriptar($img[2][4],1);
	$encript->desencriptar($img[3][1],1);
	$encript->desencriptar($img[3][2],1);
	$encript->desencriptar($img[3][3],1);
	$encript->desencriptar($img[3][4],1);
	$encript->desencriptar($img[4][1],1);
	$encript->desencriptar($img[4][2],1);
	$encript->desencriptar($img[4][3],1);
	$encript->desencriptar($img[4][4],1);
	
	
	$parGreyLeft = new ParFormat();
	$parGreyLeft->setShading(10);
	
	$parGreyCenter = new ParFormat('center');
	$parGreyCenter->setShading(10);
	
	$rtf = new Rtf();
	$null = null;
	
	$header = &$rtf->addHeader('first');
	$header->writeText(utf8_encode('Tablero de Comunicación: CHATBOX.'), new Font(), new ParFormat());
	
	$sect = &$rtf->addSection();
	
	$table = &$sect->addTable();
	$table->addRowsList(array(0.65,2.21,0.8,2.21,0.8,2.21,0.8,2.21,0.65));
	$table->addColumnsList(array(0.2,2.15,0.8,2.20,0.9,2.10,0.9,2.20,0.1));
	$table->setVerticalAlignmentOfCells('center', 1, 1, 9, 9);
	
	/*INSERTO LAS IMAGENES*/
	if ($img[1][1]['ruta'] !='') { $table->addImageToCell(2, 2, str_replace('../../../../','../../../',$img[1][1]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[1][2]['ruta'] !='') { $table->addImageToCell(2, 4, str_replace('../../../../','../../../',$img[1][2]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[1][3]['ruta'] !='') { $table->addImageToCell(2, 6, str_replace('../../../../','../../../',$img[1][3]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[1][4]['ruta'] !='') { $table->addImageToCell(2, 8, str_replace('../../../../','../../../',$img[1][4]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	
	if ($img[2][1]['ruta'] !='') { $table->addImageToCell(4, 2, str_replace('../../../../','../../../',$img[2][1]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[2][2]['ruta'] !='') { $table->addImageToCell(4, 4, str_replace('../../../../','../../../',$img[2][2]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[2][3]['ruta'] !='') { $table->addImageToCell(4, 6, str_replace('../../../../','../../../',$img[2][3]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[2][4]['ruta'] !='') { $table->addImageToCell(4, 8, str_replace('../../../../','../../../',$img[2][4]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	
	if ($img[3][1]['ruta'] !='') { $table->addImageToCell(6, 2, str_replace('../../../../','../../../',$img[3][1]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[3][2]['ruta'] !='') { $table->addImageToCell(6, 4, str_replace('../../../../','../../../',$img[3][2]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[3][3]['ruta'] !='') { $table->addImageToCell(6, 6, str_replace('../../../../','../../../',$img[3][3]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[3][4]['ruta'] !='') { $table->addImageToCell(6, 8, str_replace('../../../../','../../../',$img[3][4]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	
	if ($img[4][1]['ruta'] !='') { $table->addImageToCell(8, 2, str_replace('../../../../','../../../',$img[4][1]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[4][2]['ruta'] !='') { $table->addImageToCell(8, 4, str_replace('../../../../','../../../',$img[4][2]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[4][3]['ruta'] !='') { $table->addImageToCell(8, 6, str_replace('../../../../','../../../',$img[4][3]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	if ($img[4][4]['ruta'] !='') { $table->addImageToCell(8, 8, str_replace('../../../../','../../../',$img[4][4]['ruta']), new ParFormat('center'), 2.1, 2.1); }
	
	//borders
	if ($borde==1) {
		$table->setBordersOfCells(new BorderFormat(0.1, $color_borde), 1, 1, 1, 9, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat(0.1, $color_borde), 9, 1, 9, 9, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat(0.1, $color_borde), 1, 1, 9, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat(0.1, $color_borde), 1, 9, 9, 9, false,false,true,false);
	}
	
	$rtf->sendRtf('chatbox');
	break; // Final de la Plantilla ChatBox
	
	//
	//*********************************************************************************************************************************
	//
	
	case 2:  // PLANTILLA A6 4 Cuadros Sin Cabecera
	
	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	
	if ($_POST['orientacion']==1) {
		$sect->setPaperHeight(14.8);
		$sect->setPaperWidth(10.5);
	} elseif ($_POST['orientacion']==2) {
		$sect->setPaperHeight(10.5);
		$sect->setPaperWidth(14.8);
	}
	
	$sect->setMargins(0.3,0.3,0.3,0.3); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.3;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

	$table = &$sect->addTable();

	if ($_POST['orientacion']==1) { //VERTICAL
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.045; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.005;
	
		//Medidas 1
		$m1_1=1.95;
		$m1_2=4;
		$m1_3=2.3;
		$m1_4=4;
		$m1_5=1.95;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$total_ancho_borde_columnas_celdas_2-14.2)/2;
			
		//Medidas 2
		
		$m2_1=0.4;
		$m2_2=4;
		$m2_3=1.2;
		$m2_4=4;
		$m2_5=0.4;
		
		$m2_a_descontar=($m2_1+$m2_2+$m2_3+$m2_4+$m2_5+$total_ancho_borde_filas_celdas_2-10)/2;
	
		$table->addRowsList(array($m1_1-$m1_a_descontar,$m1_2,$m1_3,$m1_4,$m1_5-$m1_a_descontar));
		$table->addColumnsList(array($m2_1-$m2_a_descontar,$m2_2,$m2_3,$m2_4,$m2_5-$m2_a_descontar));
	
	} elseif ($_POST['orientacion']==2) { //HORIZONTAL
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.005; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.045;
		
		//Medidas 1
		$m1_1=1.95;
		$m1_2=4;
		$m1_3=2.3;
		$m1_4=4;
		$m1_5=1.95;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$total_ancho_borde_columnas_celdas_2-14.2)/2;
			
		//Medidas 2
		
		$m2_1=0.4;
		$m2_2=4;
		$m2_3=0.2;
		$m2_4=4;
		$m2_5=0.4;
		
		$m2_a_descontar=$total_ancho_borde_filas_celdas_2;
		
		$table->addRowsList(array(0.5,3.5,1.2-$m2_a_descontar,3.5,0.5));
		$table->addColumnsList(array($m1_1-$m1_a_descontar,$m1_2,$m1_3,$m1_4,$m1_5-$m1_a_descontar));
	}
	
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 5, 5);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/
	if ($borde==1) {
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 5, 1, 5, 5, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 5, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 5, 5, false,false,true,false);
	}
	
	
	//	$sect->writeText('Total ancho borde columnas: '.$total_ancho_borde_columnas_celdas_2.'', new Font(14, 'Arial'), new ParFormat());
	//	$sect->writeText('Total ancho borde filas: '.$total_ancho_borde_filas_celdas_2.'', new Font(14, 'Arial'), new ParFormat());
	//	$sect->writeText('A descontar filas: '.$m2_a_descontar.'', new Font(14, 'Arial'), new ParFormat());
	//	$sect->writeText('M1 a descontar: '.$m1_a_descontar.'', new Font(14, 'Arial'), new ParFormat());
	//	$sect->writeText('M2 a descontar: '.$m2_a_descontar.'', new Font(14, 'Arial'), new ParFormat());
	
	$rtf->sendRtf('A6_2x2_No_cabecera');
	
	break; // Final de la Plantilla A6 4 Cuadros Sin Cabecera
	
	
	//
	//*********************************************************************************************************************************
	//
	
	case 3:  // PLANTILLA A6 6 Cuadros Sin Cabecera VERTICAL
	
	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	
	if ($_POST['orientacion']==1) {
		$sect->setPaperHeight(14.8);
		$sect->setPaperWidth(10.5);
	} elseif ($_POST['orientacion']==2) {
		$sect->setPaperHeight(10.5);
		$sect->setPaperWidth(14.8);
	}
	
	$sect->setMargins(0.3,0.3,0.3,0.3); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.3;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2)+($borde_celdas[1][6][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2)+($borde_celdas[1][6][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

	$table = &$sect->addTable();

	if ($_POST['orientacion']==1) { //VERTICAL
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.055; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.005;
	
		//Medidas 1
		$m1_1=1.65;
		$m1_2=2.5;
		$m1_3=1.65;
		$m1_4=2.5;
		$m1_5=1.65;
		$m1_6=2.5;
		$m1_7=1.65;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$m1_6+$m1_7+$total_ancho_borde_columnas_celdas_2-14.1)/4;
			
		//Medidas 2
		
		$m2_1=1.4;
		$m2_2=2.5;
		$m2_3=1.2;
		$m2_4=2.5;
		$m2_5=1.4;
		
		$m2_a_descontar=($m2_1+$m2_2+$m2_3+$m2_4+$m2_5+$total_ancho_borde_filas_celdas_2-10)/2;
	
		$table->addRowsList(array($m1_1-$m1_a_descontar,$m1_2,$m1_3-$m1_a_descontar,$m1_4,$m1_5-$m1_a_descontar,$m1_6,$m1_7-$m1_a_descontar));
		$table->addColumnsList(array($m2_1-$m2_a_descontar,$m2_2,$m2_3,$m2_4,$m2_5-$m2_a_descontar));
	
	} elseif ($_POST['orientacion']==2) { //HORIZONTAL
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.005; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.045;
		
		//Medidas 1
		$m1_1=1.65;
		$m1_2=2.5;
		$m1_3=1.65;
		$m1_4=2.5;
		$m1_5=1.65;
		$m1_6=2.5;
		$m1_7=1.65;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$total_ancho_borde_columnas_celdas_2-14.1)/4;
			
		//Medidas 2
		
		$m2_1=1.4;
		$m2_2=2.5;
		$m2_3=1.4;
		$m2_4=2.5;
		$m2_5=1.4;
		
		$m2_a_descontar=$total_ancho_borde_filas_celdas_2;
		
		$table->addRowsList(array($m2_1,$m2_2,$m2_3,$m2_4,$m2_5));
		$table->addColumnsList(array($m1_1,$m1_2,$m1_3,$m1_4,$m1_5,$m1_6,$m1_7));
	}
	
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 5, 5);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/ // setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		if ($_POST['orientacion']==1) { //VERTICAL
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 7, 1, 7, 5, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 7, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 7, 5, false,false,true,false);
		} elseif ($_POST['orientacion']==2) { //HORIZONTAL
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 7, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 5, 1, 5, 7, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 5, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 7, 5, 7, false,false,true,false);
		}
	}
	
	
	//	$sect->writeText('Total ancho borde columnas: '.$total_ancho_borde_columnas_celdas_2.'', new Font(14, 'Arial'), new ParFormat());
	//	$sect->writeText('Total ancho borde filas: '.$total_ancho_borde_filas_celdas_2.'', new Font(14, 'Arial'), new ParFormat());
	//	$sect->writeText('A descontar filas: '.$m2_a_descontar.'', new Font(14, 'Arial'), new ParFormat());
	//	$sect->writeText('M1 a descontar: '.$m1_a_descontar.'', new Font(14, 'Arial'), new ParFormat());
	//	$sect->writeText('M2 a descontar: '.$m2_a_descontar.'', new Font(14, 'Arial'), new ParFormat());
	
	$rtf->sendRtf('A6_2x3_No_cabecera_Vertical');
	
	break; // Final de la Plantilla A6 4 Cuadros Sin Cabecera
	
	//
	//*********************************************************************************************************************************
	//
	
	case 4:  // PLANTILLA A6 6 Cuadros Sin Cabecera HORIZONTAL
	
	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	
	$sect->setPaperHeight(10.5);
	$sect->setPaperWidth(14.8);
	
	$sect->setMargins(0.3,0.3,0.3,0.3); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.3;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2)+($borde_celdas[1][6][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2)+($borde_celdas[1][6][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

	$table = &$sect->addTable();
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas/2)*0.05; 
		//$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.045;
		
		//Medidas 1
		$m1_1=1.65;
		$m1_2=2.5;
		$m1_3=1.65;
		$m1_4=2.5;
		$m1_5=1.65;
		$m1_6=2.5;
		$m1_7=1.65;
		
		//$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$total_ancho_borde_columnas_celdas_2-14.1)/4;
			
		//Medidas 2
		
		$m2_1=1.6;
		$m2_2=2.5;
		$m2_3=1.5;
		$m2_4=2.5;
		$m2_5=1.6;
		
		$m2_a_descontar=(($borde_exterior_tablero/2)*0.05)+$total_ancho_borde_columnas_celdas_2;
		
		$table->addRowsList(array($m2_1-$m2_a_descontar,$m2_2,$m2_3,$m2_4,$m2_5-$m2_a_descontar));
		$table->addColumnsList(array($m1_1,$m1_2,$m1_3,$m1_4,$m1_5,$m1_6,$m1_7));
	
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 7, 7);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
			
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/ // setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 7, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 5, 1, 5, 7, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 5, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 7, 5, 7, false,false,true,false);
	}

	
	$rtf->sendRtf('A6_2x3_No_cabecera_Horizontal');
	
	break; // Final de la Plantilla A6 6 Cuadros Sin Cabecera HORIZONTAL

	//
	//*********************************************************************************************************************************
	//
	
	//
	//*********************************************************************************************************************************
	//
	
	case 5:  // PLANTILLA A6 4 Cuadros CON Cabecera
	
	//rtf document
	$rtf = new Rtf();
	
		//section 1
	$sect = &$rtf->addSection();
	
	if ($_POST['orientacion']==1) {
		$sect->setPaperHeight(14.8);
		$sect->setPaperWidth(10.5);
	} elseif ($_POST['orientacion']==2) {
		$sect->setPaperHeight(10.5);
		$sect->setPaperWidth(14.8);
	}
	
	$sect->setMargins(0.3,0.3,0.3,0.3); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.3;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	//ALMACENO LA IMAGEN DE LA CABECERA
	$img[99][99]=$_POST['img_1_img_1'];
	$encript->desencriptar($img[99][99],1);
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

		
	//AÑADO LA TABLA DE LA CABECERA
	$table = &$sect->addTable();
	$table->addRowsList(array(0.3,2.5));
	$table->addColumnsList(array(0.5,5.9,0.5,2.5,0.5));
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 2, 5);

	// setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 2, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 2, 5, false,false,true,false);
	}
	
	/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_1_txt_1']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_1_txt_1'], $_POST['cbc_1_txt_1'], $_POST['tbc_1_txt_1']),2,2); }
		if ($_POST['bc_1_img_1']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_1_img_1'], $_POST['cbc_1_img_1'], $_POST['tbc_1_img_1']),2,4); }

	/*COLOREO EL FONDO*/
		$table->setBackgroundOfCells($color_fondo_panel, 1, 1);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 2);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 3);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 4);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 5);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 1);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 3);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 5);
		
	//AÑADO EL TEXTO DE LA CABECERA	
	if ($_POST['ptc_1_txt_1'] > 0 && strlen($_POST['txt_1_txt_1']) > 0) { 
	
		$table->writeToCell(2, 2,  $_POST['txt_1_txt_1'], 
				new Font($_POST['sftc_1_txt_1'], $_POST['ftc_1_txt_1'],$_POST['ctc_1_txt_1']),
				new ParFormat('center'));
	}	
	
	if ($_POST['mtc_1_img_1']==0) { $texto_celda=strtolower($_POST['txt_1_img_1']); }
		elseif ($_POST['mtc_1_img_1']==1) { $texto_celda=strtoupper($_POST['txt_1_img_1']); }
		
		if ($_POST['ptc_1_img_1'] > 0 && strlen($_POST['txt_1_img_1']) > 0) { 
			if ($_POST['ptc_1_img_1']==1) {
				$table->writeToCell(2, 4,  $_POST['txt_1_img_1'], 
				new Font($_POST['sftc_1_img_1'], $_POST['ftc_1_img_1'],$_POST['ctc_1_img_1']),
				new ParFormat('center'));
				
					if ($img[99][99]['ruta'] !='') { 
						$table->addImageToCell(2, 4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
						new ParFormat('center'), $_POST['tict_1_img_1'], $_POST['tict_1_img_1']); 
					}
					
			} elseif ($_POST['ptc_1_img_1']==2) {
				if ($img[99][99]['ruta'] !='') { 
					$table->addImageToCell(2, 4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
					new ParFormat('center'), $_POST['tict_1_img_1'], $_POST['tict_1_img_1']); 
				}
				$table->writeToCell(2, 4,  $_POST['txt_1_img_1'], 
				new Font($_POST['sftc_1_img_1'], $_POST['ftc_1_img_1'],$_POST['ctc_1_img_1']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_1_img_1'] == 0) {
		
			if ($img[99][99]['ruta'] !='') { 
				$table->addImageToCell(2,4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
				new ParFormat('center'), $_POST['tist_1_img_1'], $_POST['tist_1_img_1']); 
			}
		} elseif ($_POST['ptc_1_img_1'] > 0 && strlen($_POST['txt_1_img_1']) ==0) {
		
			if ($img[99][99]['ruta'] !='') { 
				$table->addImageToCell(2,4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
				new ParFormat('center'), $_POST['tist_1_img_1'], $_POST['tist_1_img_1']); 
			}
		
		}
			
	
	$table = &$sect->addTable();

	if ($_POST['orientacion']==1) { //VERTICAL
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.045; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.005;
	
		//Medidas 1
		$m1_1=1.95;
		$m1_2=4;
		$m1_3=2.3;
		$m1_4=4;
		$m1_5=1.95;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$total_ancho_borde_columnas_celdas_2-14.2)/2;
			
		//Medidas 2
		
		$m2_1=0.4;
		$m2_2=4;
		$m2_3=1.2;
		$m2_4=4;
		$m2_5=0.4;
		
		$m2_a_descontar=($m2_1+$m2_2+$m2_3+$m2_4+$m2_5+$total_ancho_borde_filas_celdas_2-10)/2;
	
		$table->addRowsList(array(0.2,$m1_2,0.8,$m1_4,0.2));
		$table->addColumnsList(array($m2_1-$m2_a_descontar,$m2_2,$m2_3,$m2_4,$m2_5-$m2_a_descontar));
	
	} elseif ($_POST['orientacion']==2) { //HORIZONTAL
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.005; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.045;
		
		//Medidas 1
		$m1_1=1.95;
		$m1_2=4;
		$m1_3=2.3;
		$m1_4=4;
		$m1_5=1.95;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$total_ancho_borde_columnas_celdas_2-14.2)/2;
			
		//Medidas 2
		
		$m2_1=0.4;
		$m2_2=4;
		$m2_3=0.2;
		$m2_4=4;
		$m2_5=0.4;
		
		$m2_a_descontar=$total_ancho_borde_filas_celdas_2;
		
		$table->addRowsList(array(0.5,3.5,1.2-$m2_a_descontar,3.5,0.5));
		$table->addColumnsList(array($m1_1-$m1_a_descontar,$m1_2,$m1_3,$m1_4,$m1_5-$m1_a_descontar));
	}
	
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 5, 5);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/
	if ($borde==1) {
		//$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false); //SUPERIOR
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 5, 1, 5, 5, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 5, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 5, 5, false,false,true,false);
	}
	
	$rtf->sendRtf('A6_2x2_Con_cabecera');
	
	break; // Final de la Plantilla A6 4 Cuadros CON Cabecera
	
	
	//
	//*********************************************************************************************************************************
	//
	
	case 6:  // PLANTILLA A6 6 Cuadros CON Cabecera VERTICAL
	
	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	
	if ($_POST['orientacion']==1) {
		$sect->setPaperHeight(14.8);
		$sect->setPaperWidth(10.5);
	} elseif ($_POST['orientacion']==2) {
		$sect->setPaperHeight(10.5);
		$sect->setPaperWidth(14.8);
	}
	
	$sect->setMargins(0.3,0.3,0.3,0.3); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.3;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	//ALMACENO LA IMAGEN DE LA CABECERA
	$img[99][99]=$_POST['img_1_img_1'];
	$encript->desencriptar($img[99][99],1);
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2)+($borde_celdas[1][6][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2)+($borde_celdas[1][6][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

	
	//AÑADO LA TABLA DE LA CABECERA
	$table = &$sect->addTable();
	$table->addRowsList(array(0.3,2.5));
	$table->addColumnsList(array(0.5,5.9,0.5,2.5,0.5));
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 2, 5);

	// setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 2, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 2, 5, false,false,true,false);
	}
	
	/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_1_txt_1']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_1_txt_1'], $_POST['cbc_1_txt_1'], $_POST['tbc_1_txt_1']),2,2); }
		if ($_POST['bc_1_img_1']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_1_img_1'], $_POST['cbc_1_img_1'], $_POST['tbc_1_img_1']),2,4); }

	/*COLOREO EL FONDO*/
		$table->setBackgroundOfCells($color_fondo_panel, 1, 1);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 2);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 3);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 4);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 5);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 1);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 3);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 5);
		
	//AÑADOEL TEXTO DE LA CABECERA	
	if ($_POST['ptc_1_txt_1'] > 0 && strlen($_POST['txt_1_txt_1']) > 0) { 
	
		$table->writeToCell(2, 2,  $_POST['txt_1_txt_1'], 
				new Font($_POST['sftc_1_txt_1'], $_POST['ftc_1_txt_1'],$_POST['ctc_1_txt_1']),
				new ParFormat('center'));
	}	
	
	if ($_POST['mtc_1_img_1']==0) { $texto_celda=strtolower($_POST['txt_1_img_1']); }
		elseif ($_POST['mtc_1_img_1']==1) { $texto_celda=strtoupper($_POST['txt_1_img_1']); }
		
		if ($_POST['ptc_1_img_1'] > 0 && strlen($_POST['txt_1_img_1']) > 0) { 
			if ($_POST['ptc_1_img_1']==1) {
				$table->writeToCell(2, 4,  $_POST['txt_1_img_1'], 
				new Font($_POST['sftc_1_img_1'], $_POST['ftc_1_img_1'],$_POST['ctc_1_img_1']),
				new ParFormat('center'));
				
					if ($img[99][99]['ruta'] !='') { 
						$table->addImageToCell(2, 4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
						new ParFormat('center'), $_POST['tict_1_img_1'], $_POST['tict_1_img_1']); 
					}
					
			} elseif ($_POST['ptc_1_img_1']==2) {
				if ($img[99][99]['ruta'] !='') { 
					$table->addImageToCell(2, 4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
					new ParFormat('center'), $_POST['tict_1_img_1'], $_POST['tict_1_img_1']); 
				}
				$table->writeToCell(2, 4,  $_POST['txt_1_img_1'], 
				new Font($_POST['sftc_1_img_1'], $_POST['ftc_1_img_1'],$_POST['ctc_1_img_1']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_1_img_1'] == 0) {
		
			if ($img[99][99]['ruta'] !='') { 
				$table->addImageToCell(2,4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
				new ParFormat('center'), $_POST['tist_1_img_1'], $_POST['tist_1_img_1']); 
			}
		} elseif ($_POST['ptc_1_img_1'] > 0 && strlen($_POST['txt_1_img_1']) ==0) {
		
			if ($img[99][99]['ruta'] !='') { 
				$table->addImageToCell(2,4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
				new ParFormat('center'), $_POST['tist_1_img_1'], $_POST['tist_1_img_1']); 
			}
		
		}
		
	
	//AÑADO LA TABLA DEL PANEL
	$table = &$sect->addTable();

		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.055; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.005;
	
		//Medidas 1
		$m1_1=0.45;
		$m1_2=2.5;
		$m1_3=0.45;
		$m1_4=2.5;
		$m1_5=0.45;
		$m1_6=2.5;
		$m1_7=0.45;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$m1_6+$m1_7+$total_ancho_borde_columnas_celdas_2-10.9)/4;
			
		//Medidas 2
		
		$m2_1=1.1;
		$m2_2=2.5;
		$m2_3=1.5;
		$m2_4=2.5;
		$m2_5=1.1;
		
		$m2_a_descontar=($m2_1+$m2_2+$m2_3+$m2_4+$m2_5+$total_ancho_borde_filas_celdas_2-10)/2;
	
		$table->addRowsList(array($m1_1-$m1_a_descontar,$m1_2,$m1_3-$m1_a_descontar,$m1_4,$m1_5-$m1_a_descontar,$m1_6,$m1_7-$m1_a_descontar));
		$table->addColumnsList(array($m2_1-$m2_a_descontar,$m2_2,$m2_3,$m2_4,$m2_5-$m2_a_descontar));
	
	
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 5, 5);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/ // setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		//$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 7, 1, 7, 5, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 7, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 7, 5, false,false,true,false);
	}
	
	
	$rtf->sendRtf('A6_2x3_Con_cabecera_Vertical');
	
	break; // Final de la Plantilla A6 4 Cuadros Sin Cabecera
	
//
//*********************************************************************************************************************************
//
	
	case 7:  // PLANTILLA A4 6 Cuadros Sin Cabecera VERTICAL
	
	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	
	$sect->setPaperHeight(29.1);
	$sect->setPaperWidth(20.5);
	
	$sect->setMargins(0.6,0.6,0.6,0.6); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.6;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2)+($borde_celdas[1][6][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2)+($borde_celdas[1][6][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

	$table = &$sect->addTable();

	if ($_POST['orientacion']==1) { //VERTICAL
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.055; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.005;
	
		//Medidas 1
		$m1_1=1.7;
		$m1_2=6;
		$m1_3=2.5;
		$m1_4=6;
		$m1_5=2.5;
		$m1_6=6;
		$m1_7=1.7;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$m1_6+$m1_7+$total_ancho_borde_columnas_celdas_2)/4;
			
		//Medidas 2
		
		$m2_1=2.2;
		$m2_2=6;
		$m2_3=3;
		$m2_4=6;
		$m2_5=2.2;
		
		$m2_a_descontar=($m2_1+$m2_2+$m2_3+$m2_4+$m2_5+$total_ancho_borde_filas_celdas_2)/2;
	
		$table->addRowsList(array($m1_1,$m1_2,$m1_3,$m1_4,$m1_5,$m1_6,$m1_7));
		$table->addColumnsList(array($m2_1,$m2_2,$m2_3,$m2_4,$m2_5));
	
	} elseif ($_POST['orientacion']==2) { //HORIZONTAL
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.005; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.045;
		
		//Medidas 1
		$m1_1=1.65;
		$m1_2=2.5;
		$m1_3=1.65;
		$m1_4=2.5;
		$m1_5=1.65;
		$m1_6=2.5;
		$m1_7=1.65;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$total_ancho_borde_columnas_celdas_2-14.1)/4;
			
		//Medidas 2
		
		$m2_1=1.4;
		$m2_2=2.5;
		$m2_3=1.4;
		$m2_4=2.5;
		$m2_5=1.4;
		
		$m2_a_descontar=$total_ancho_borde_filas_celdas_2;
		
		$table->addRowsList(array($m2_1,$m2_2,$m2_3,$m2_4,$m2_5));
		$table->addColumnsList(array($m1_1,$m1_2,$m1_3,$m1_4,$m1_5,$m1_6,$m1_7));
	}
	
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 5, 5);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/ // setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		if ($_POST['orientacion']==1) { //VERTICAL
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 7, 1, 7, 5, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 7, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 7, 5, false,false,true,false);
		} elseif ($_POST['orientacion']==2) { //HORIZONTAL
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 7, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 5, 1, 5, 7, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 5, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 7, 5, 7, false,false,true,false);
		}
	}
	
	
	$rtf->sendRtf('A4_2x3_No_cabecera_Vertical');
	
	break; // Final de la Plantilla A6 4 Cuadros Sin Cabecera
	
	//
	//*********************************************************************************************************************************
	//
	
	case 8:  // PLANTILLA A4 6 Cuadros Sin Cabecera HORIZONTAL
	
	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	
	$sect->setPaperHeight(21);
	$sect->setPaperWidth(29.7);
	
	$sect->setMargins(0.8,0.8,0.8,0.8); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.8;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2)+($borde_celdas[1][6][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2)+($borde_celdas[1][6][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

	$table = &$sect->addTable();
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas/2)*0.05; 
		//$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.045;
		
		//Medidas 1
		$m1_1=2.5;
		$m1_2=6;
		$m1_3=2.5;
		$m1_4=6;
		$m1_5=2.5;
		$m1_6=6;
		$m1_7=2.5;
		
		//$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$m1_6+$m1_7+$total_ancho_borde_columnas_celdas_2)/4;
			
		//Medidas 2
		
		$m2_1=2;
		$m2_2=6;
		$m2_3=3;
		$m2_4=6;
		$m2_5=2;

		$m2_a_descontar=(($borde_exterior_tablero/2)*0.05)+$total_ancho_borde_columnas_celdas_2;
		
		$table->addRowsList(array($m2_1-$m2_a_descontar,$m2_2,$m2_3,$m2_4,$m2_5-$m2_a_descontar));
		$table->addColumnsList(array($m1_1,$m1_2,$m1_3,$m1_4,$m1_5,$m1_6,$m1_7));
	
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 7, 7);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
			
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/ // setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 7, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 5, 1, 5, 7, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 5, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 7, 5, 7, false,false,true,false);
	}

	
	$rtf->sendRtf('A4_2x3_No_cabecera_Horizontal');
	
	break; // Final de la Plantilla A6 6 Cuadros Sin Cabecera HORIZONTAL

//
//*********************************************************************************************************************************
//
	
	case 9:  // PLANTILLA A4 6 Cuadros Con Cabecera VERTICAL
	
	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	
	$sect->setPaperHeight(29.1);
	$sect->setPaperWidth(20.5);
	
	$sect->setMargins(0.6,0.6,0.6,0.6); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.6;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	//ALMACENO LA IMAGEN DE LA CABECERA
	$img[99][99]=$_POST['img_1_img_1'];
	$encript->desencriptar($img[99][99],1);
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2)+($borde_celdas[1][6][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2)+($borde_celdas[1][6][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

	//AÑADO LA TABLA DE LA CABECERA
	$table = &$sect->addTable();
	$table->addRowsList(array(0.3,4));
	$table->addColumnsList(array(0.8,13,0.6,4,0.8));
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 2, 5);

	// setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 2, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 2, 5, false,false,true,false);
	}
	
	/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_1_txt_1']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_1_txt_1'], $_POST['cbc_1_txt_1'], $_POST['tbc_1_txt_1']),2,2); }
		if ($_POST['bc_1_img_1']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_1_img_1'], $_POST['cbc_1_img_1'], $_POST['tbc_1_img_1']),2,4); }

	/*COLOREO EL FONDO*/
		$table->setBackgroundOfCells($color_fondo_panel, 1, 1);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 2);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 3);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 4);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 5);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 1);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 3);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 5);
		
	//AÑADOEL TEXTO DE LA CABECERA	
	if ($_POST['ptc_1_txt_1'] > 0 && strlen($_POST['txt_1_txt_1']) > 0) { 
	
		$table->writeToCell(2, 2,  $_POST['txt_1_txt_1'], 
				new Font($_POST['sftc_1_txt_1'], $_POST['ftc_1_txt_1'],$_POST['ctc_1_txt_1']),
				new ParFormat('center'));
	}	
	
	if ($_POST['mtc_1_img_1']==0) { $texto_celda=strtolower($_POST['txt_1_img_1']); }
		elseif ($_POST['mtc_1_img_1']==1) { $texto_celda=strtoupper($_POST['txt_1_img_1']); }
		
		if ($_POST['ptc_1_img_1'] > 0 && strlen($_POST['txt_1_img_1']) > 0) { 
			if ($_POST['ptc_1_img_1']==1) {
				$table->writeToCell(2, 4,  $_POST['txt_1_img_1'], 
				new Font($_POST['sftc_1_img_1'], $_POST['ftc_1_img_1'],$_POST['ctc_1_img_1']),
				new ParFormat('center'));
				
					if ($img[99][99]['ruta'] !='') { 
						$table->addImageToCell(2, 4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
						new ParFormat('center'), $_POST['tict_1_img_1'], $_POST['tict_1_img_1']); 
					}
					
			} elseif ($_POST['ptc_1_img_1']==2) {
				if ($img[99][99]['ruta'] !='') { 
					$table->addImageToCell(2, 4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
					new ParFormat('center'), $_POST['tict_1_img_1'], $_POST['tict_1_img_1']); 
				}
				$table->writeToCell(2, 4,  $_POST['txt_1_img_1'], 
				new Font($_POST['sftc_1_img_1'], $_POST['ftc_1_img_1'],$_POST['ctc_1_img_1']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_1_img_1'] == 0) {
		
			if ($img[99][99]['ruta'] !='') { 
				$table->addImageToCell(2,4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
				new ParFormat('center'), $_POST['tist_1_img_1'], $_POST['tist_1_img_1']); 
			}
		} elseif ($_POST['ptc_1_img_1'] > 0 && strlen($_POST['txt_1_img_1']) ==0) {
		
			if ($img[99][99]['ruta'] !='') { 
				$table->addImageToCell(2,4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
				new ParFormat('center'), $_POST['tist_1_img_1'], $_POST['tist_1_img_1']); 
			}
		
		}


	$table = &$sect->addTable();


		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.055; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.005;
	
		//Medidas 1
		$m1_1=0.6;
		$m1_2=6;
		$m1_3=1.2;
		$m1_4=6;
		$m1_5=1.2;
		$m1_6=6;
		$m1_7=0.6;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$m1_6+$m1_7+$total_ancho_borde_columnas_celdas_2)/4;
			
		//Medidas 2
		
		$m2_1=2.1;
		$m2_2=6;
		$m2_3=3;
		$m2_4=6;
		$m2_5=2.1;
		
		$m2_a_descontar=($m2_1+$m2_2+$m2_3+$m2_4+$m2_5+$total_ancho_borde_filas_celdas_2)/2;
	
		$table->addRowsList(array($m1_1,$m1_2,$m1_3,$m1_4,$m1_5,$m1_6,$m1_7));
		$table->addColumnsList(array($m2_1,$m2_2,$m2_3,$m2_4,$m2_5));
		
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 5, 5);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/ // setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		if ($_POST['orientacion']==1) { //VERTICAL
		//$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 7, 1, 7, 5, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 7, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 7, 5, false,false,true,false);
		} elseif ($_POST['orientacion']==2) { //HORIZONTAL
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 7, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 5, 1, 5, 7, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 5, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 7, 5, 7, false,false,true,false);
		}
	}
	
	
	$rtf->sendRtf('A4_2x3_Con_cabecera_Vertical');
	
	break; // Final de la Plantilla A6 4 Cuadros Sin Cabecera
	
//
//*********************************************************************************************************************************
//
	
	case 10:  // PLANTILLA A4 6 Cuadros Con Cabecera HORIZONTAL
	
	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	
	$sect->setPaperHeight(21);
	$sect->setPaperWidth(29.7);
	
	$sect->setMargins(0.8,0.8,0.8,0.8); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.8;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	//ALMACENO LA IMAGEN DE LA CABECERA
	$img[99][99]=$_POST['img_1_img_1'];
	$encript->desencriptar($img[99][99],1);
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2)+($borde_celdas[1][6][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2)+($borde_celdas[1][6][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

	//AÑADO LA TABLA DE LA CABECERA
	$table = &$sect->addTable();
	$table->addRowsList(array(0.3,4));
	$table->addColumnsList(array(3.2,17,0.6,4,3.2));
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 2, 5);

	// setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 2, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 2, 5, false,false,true,false);
	}
	
	/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_1_txt_1']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_1_txt_1'], $_POST['cbc_1_txt_1'], $_POST['tbc_1_txt_1']),2,2); }
		if ($_POST['bc_1_img_1']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_1_img_1'], $_POST['cbc_1_img_1'], $_POST['tbc_1_img_1']),2,4); }

	/*COLOREO EL FONDO*/
		$table->setBackgroundOfCells($color_fondo_panel, 1, 1);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 2);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 3);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 4);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 5);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 1);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 3);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 5);
		
	//AÑADOEL TEXTO DE LA CABECERA	
	if ($_POST['ptc_1_txt_1'] > 0 && strlen($_POST['txt_1_txt_1']) > 0) { 
	
		$table->writeToCell(2, 2,  $_POST['txt_1_txt_1'], 
				new Font($_POST['sftc_1_txt_1'], $_POST['ftc_1_txt_1'],$_POST['ctc_1_txt_1']),
				new ParFormat('center'));
	}	
	
	if ($_POST['mtc_1_img_1']==0) { $texto_celda=strtolower($_POST['txt_1_img_1']); }
		elseif ($_POST['mtc_1_img_1']==1) { $texto_celda=strtoupper($_POST['txt_1_img_1']); }
		
		if ($_POST['ptc_1_img_1'] > 0 && strlen($_POST['txt_1_img_1']) > 0) { 
			if ($_POST['ptc_1_img_1']==1) {
				$table->writeToCell(2, 4,  $_POST['txt_1_img_1'], 
				new Font($_POST['sftc_1_img_1'], $_POST['ftc_1_img_1'],$_POST['ctc_1_img_1']),
				new ParFormat('center'));
				
					if ($img[99][99]['ruta'] !='') { 
						$table->addImageToCell(2, 4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
						new ParFormat('center'), $_POST['tict_1_img_1'], $_POST['tict_1_img_1']); 
					}
					
			} elseif ($_POST['ptc_1_img_1']==2) {
				if ($img[99][99]['ruta'] !='') { 
					$table->addImageToCell(2, 4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
					new ParFormat('center'), $_POST['tict_1_img_1'], $_POST['tict_1_img_1']); 
				}
				$table->writeToCell(2, 4,  $_POST['txt_1_img_1'], 
				new Font($_POST['sftc_1_img_1'], $_POST['ftc_1_img_1'],$_POST['ctc_1_img_1']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_1_img_1'] == 0) {
		
			if ($img[99][99]['ruta'] !='') { 
				$table->addImageToCell(2,4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
				new ParFormat('center'), $_POST['tist_1_img_1'], $_POST['tist_1_img_1']); 
			}
		} elseif ($_POST['ptc_1_img_1'] > 0 && strlen($_POST['txt_1_img_1']) ==0) {
		
			if ($img[99][99]['ruta'] !='') { 
				$table->addImageToCell(2,4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
				new ParFormat('center'), $_POST['tist_1_img_1'], $_POST['tist_1_img_1']); 
			}
		
		}


	$table = &$sect->addTable();


		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.005; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.045;
		
		//Medidas 1
		$m1_1=3.8;
		$m1_2=6;
		$m1_3=1.2;
		$m1_4=6;
		$m1_5=1.2;
		$m1_6=6;
		$m1_7=3.8;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$total_ancho_borde_columnas_celdas_2-14.1)/4;
			
		//Medidas 2
		
		$m2_1=0.5;
		$m2_2=6;
		$m2_3=0.5;
		$m2_4=6;
		$m2_5=0.5;
		
		$m2_a_descontar=$total_ancho_borde_filas_celdas_2;
		
		$table->addRowsList(array($m2_1,$m2_2,$m2_3,$m2_4,$m2_5));
		$table->addColumnsList(array($m1_1,$m1_2,$m1_3,$m1_4,$m1_5,$m1_6,$m1_7));
	
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 5, 5);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/ // setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		if ($_POST['orientacion']==1) { //VERTICAL
		//$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 7, 1, 7, 5, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 7, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 7, 5, false,false,true,false);
		} elseif ($_POST['orientacion']==2) { //HORIZONTAL
		//$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 7, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 5, 1, 5, 7, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 5, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 7, 5, 7, false,false,true,false);
		}
	}
	
	
	$rtf->sendRtf('A4_3x2_Con_cabecera_Horizontal');
	
	break; // Final de la Plantilla A6 4 Cuadros Sin Cabecera
	
	//
	//*********************************************************************************************************************************
	//
	
	case 11:  // PLANTILLA A4 8 Cuadros Sin Cabecera VERTICAL
	
	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	
	$sect->setPaperHeight(29.1);
	$sect->setPaperWidth(20.5);
	
	$sect->setMargins(0.6,0.6,0.6,0.6); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.6;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2)+($borde_celdas[1][6][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2)+($borde_celdas[1][6][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

	$table = &$sect->addTable();
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.055; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.005;
	
		//Medidas 1
		$m1_1=1.1;
		$m1_2=4.5;
		$m1_3=2;
		$m1_4=4.5;
		$m1_5=2;
		$m1_6=4.5;
		$m1_7=2;
		$m1_8=4.5;
		$m1_9=1.1;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$m1_6+$m1_7+$total_ancho_borde_columnas_celdas_2)/4;
			
		//Medidas 2
		
		$m2_1=3.4;
		$m2_2=4.5;
		$m2_3=3.5;
		$m2_4=4.5;
		$m2_5=3.4;
		
		$m2_a_descontar=($m2_1+$m2_2+$m2_3+$m2_4+$m2_5+$total_ancho_borde_filas_celdas_2)/2;
	
		$table->addRowsList(array($m1_1,$m1_2,$m1_3,$m1_4,$m1_5,$m1_6,$m1_7,$m1_8,$m1_9));
		$table->addColumnsList(array($m2_1,$m2_2,$m2_3,$m2_4,$m2_5));
	
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 5, 5);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/ // setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		if ($_POST['orientacion']==1) { //VERTICAL
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 9, 1, 9, 5, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 9, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 9, 5, false,false,true,false);
		} elseif ($_POST['orientacion']==2) { //HORIZONTAL
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 9, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 5, 1, 5, 9, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 5, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 9, 5, 9, false,false,true,false);
		}
	}
	
	
	$rtf->sendRtf('A4_4x2_No_cabecera_Vertical');
	
	break; // Final de la Plantilla A6 4 Cuadros Sin Cabecera
	
	//
	//*********************************************************************************************************************************
	//
	
	case 12:  // PLANTILLA A4 8 Cuadros Sin Cabecera HORIZONTAL
	
	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	
	$sect->setPaperHeight(21);
	$sect->setPaperWidth(29.7);
	
	$sect->setMargins(0.8,0.8,0.8,0.8); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.8;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	//ALMACENO LA IMAGEN DE LA CABECERA
	$img[99][99]=$_POST['img_1_img_1'];
	$encript->desencriptar($img[99][99],1);
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2)+($borde_celdas[1][6][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2)+($borde_celdas[1][6][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

	$table = &$sect->addTable();
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas/2)*0.05; 
		//$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.045;
		
		//Medidas 1
		$m1_1=1.3;
		$m1_2=4.5;
		$m1_3=2.5;
		$m1_4=4.5;
		$m1_5=2.5;
		$m1_6=4.5;
		$m1_7=2.5;
		$m1_8=4.5;
		$m1_9=1.3;
		
		//$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$m1_6+$m1_7+$total_ancho_borde_columnas_celdas_2)/4;
			
		//Medidas 2
		
		$m2_1=3.3;
		$m2_2=4.5;
		$m2_3=3.3;
		$m2_4=4.5;
		$m2_5=3.3;

		$m2_a_descontar=(($borde_exterior_tablero/2)*0.05)+$total_ancho_borde_columnas_celdas_2;
		
		$table->addRowsList(array($m2_1-$m2_a_descontar,$m2_2,$m2_3,$m2_4,$m2_5-$m2_a_descontar));
		$table->addColumnsList(array($m1_1,$m1_2,$m1_3,$m1_4,$m1_5,$m1_6,$m1_7,$m1_8,$m1_9));
	
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 7, 7);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
			
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/ // setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 9, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 5, 1, 5, 9, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 5, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 9, 5, 9, false,false,true,false);
	}

	
	$rtf->sendRtf('A4_2x4_No_cabecera_Horizontal');
	
	break; // Final de la Plantilla A6 6 Cuadros Sin Cabecera HORIZONTAL

//
	//*********************************************************************************************************************************
	//
	
	case 13:  // PLANTILLA A4 8 Cuadros CON Cabecera VERTICAL
	
	//rtf document
	$rtf = new Rtf();
	
	//section 1
	$sect = &$rtf->addSection();
	
	$sect->setPaperHeight(29.1);
	$sect->setPaperWidth(20.5);
	
	$sect->setMargins(0.6,0.6,0.6,0.6); //setMargins (float $marginLeft, float $marginTop, float $marginRight, float $marginBottom)
	$margen=0.6;
	
	//paragraph formats
	//$parF = new ParFormat();
	
	$celdas_usadas=explode(',',$datos_plantilla['celdas_usadas']);
	$n_celdas_usadas=count($celdas_usadas);
	$bordes_celdas=0;
	
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0];
		$f=$d[1];
		$c=$d[2];
		$img[$f][$c]=$_POST['img_'.$p.'_'.$f.'_'.$c.''];
		$encript->desencriptar($img[$f][$c],1); 
		$bordes_celdas=$bordes_celdas+$_POST['bc_'.$p.'_'.$f.'_'.$c.''];
	}
	
	//ALMACENO LA IMAGEN DE LA CABECERA
	$img[99][99]=$_POST['img_1_img_1'];
	$encript->desencriptar($img[99][99],1);
	
	if ($borde==1) { $borde_exterior_tablero=$ancho_borde;} else { $borde_exterior_tablero=0; }
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
	$borde_celdas=array();
	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $borde_celdas[$p][$f][$c]=$_POST['abc_'.$p.'_'.$f.'_'.$c.'']; }
		else {$borde_celdas[$p][$f][$c]=0; }
	
	}
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS COLUMNAS
	
		$total_ancho_borde_columnas_celdas_f2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][2][4]*2);
		$total_ancho_borde_columnas_celdas_f4=($borde_celdas[1][4][2]*2)+($borde_celdas[1][4][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	if ($total_ancho_borde_columnas_celdas_f2 == $total_ancho_borde_columnas_celdas_f4) { 
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 > $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f2;
	} elseif ($total_ancho_borde_columnas_celdas_f2 < $total_ancho_borde_columnas_celdas_f4) {
			$total_ancho_borde_columnas_celdas=$total_ancho_borde_columnas_celdas_f4;
	}
	
	//SUMO LA MEDIDA DE LOS MARCOS DE LAS FILAS
	
		$total_ancho_borde_filas_celdas_c2=($borde_celdas[1][2][2]*2)+($borde_celdas[1][4][2]*2)+($borde_celdas[1][6][2]*2);
		$total_ancho_borde_filas_celdas_c4=($borde_celdas[1][2][4]*2)+($borde_celdas[1][4][4]*2)+($borde_celdas[1][6][4]*2);
	
	//ME QUEDO CON LA MEDIDA MAYOR
	
	if ($total_ancho_borde_filas_celdas_c2==$total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 > $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c2;
	} elseif ($total_ancho_borde_filas_celdas_c2 < $total_ancho_borde_filas_celdas_c4) {
			$total_ancho_borde_filas_celdas=$total_ancho_borde_filas_celdas_c4;
	}	

	//AÑADO LA TABLA DE LA CABECERA
	$table = &$sect->addTable();
	$table->addRowsList(array(0.3,3.5));
	$table->addColumnsList(array(1,13,0.8,3.5,1));
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 2, 5);

	// setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 1, 5, false,true,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 2, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 2, 5, false,false,true,false);
	}
	
	/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_1_txt_1']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_1_txt_1'], $_POST['cbc_1_txt_1'], $_POST['tbc_1_txt_1']),2,2); }
		if ($_POST['bc_1_img_1']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_1_img_1'], $_POST['cbc_1_img_1'], $_POST['tbc_1_img_1']),2,4); }

	/*COLOREO EL FONDO*/
		$table->setBackgroundOfCells($color_fondo_panel, 1, 1);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 2);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 3);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 4);
		$table->setBackgroundOfCells($color_fondo_panel, 1, 5);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 1);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 3);
		$table->setBackgroundOfCells($color_fondo_panel, 2, 5);
		
	//AÑADO EL TEXTO DE LA CABECERA	
	if ($_POST['ptc_1_txt_1'] > 0 && strlen($_POST['txt_1_txt_1']) > 0) { 
	
		$table->writeToCell(2, 2,  $_POST['txt_1_txt_1'], 
				new Font($_POST['sftc_1_txt_1'], $_POST['ftc_1_txt_1'],$_POST['ctc_1_txt_1']),
				new ParFormat('center'));
	}	
	
	if ($_POST['mtc_1_img_1']==0) { $texto_celda=strtolower($_POST['txt_1_img_1']); }
		elseif ($_POST['mtc_1_img_1']==1) { $texto_celda=strtoupper($_POST['txt_1_img_1']); }
		
		if ($_POST['ptc_1_img_1'] > 0 && strlen($_POST['txt_1_img_1']) > 0) { 
			if ($_POST['ptc_1_img_1']==1) {
				$table->writeToCell(2, 4,  $_POST['txt_1_img_1'], 
				new Font($_POST['sftc_1_img_1'], $_POST['ftc_1_img_1'],$_POST['ctc_1_img_1']),
				new ParFormat('center'));
				
					if ($img[99][99]['ruta'] !='') { 
						$table->addImageToCell(2, 4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
						new ParFormat('center'), $_POST['tict_1_img_1'], $_POST['tict_1_img_1']); 
					}
					
			} elseif ($_POST['ptc_1_img_1']==2) {
				if ($img[99][99]['ruta'] !='') { 
					$table->addImageToCell(2, 4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
					new ParFormat('center'), $_POST['tict_1_img_1'], $_POST['tict_1_img_1']); 
				}
				$table->writeToCell(2, 4,  $_POST['txt_1_img_1'], 
				new Font($_POST['sftc_1_img_1'], $_POST['ftc_1_img_1'],$_POST['ctc_1_img_1']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_1_img_1'] == 0) {
		
			if ($img[99][99]['ruta'] !='') { 
				$table->addImageToCell(2,4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
				new ParFormat('center'), $_POST['tist_1_img_1'], $_POST['tist_1_img_1']); 
			}
		} elseif ($_POST['ptc_1_img_1'] > 0 && strlen($_POST['txt_1_img_1']) ==0) {
		
			if ($img[99][99]['ruta'] !='') { 
				$table->addImageToCell(2,4, str_replace('../../../../','../../../',$img[99][99]['ruta']), 
				new ParFormat('center'), $_POST['tist_1_img_1'], $_POST['tist_1_img_1']); 
			}
		
		}

	// AÑADO LA TABLA DEL TABLERO
	$table = &$sect->addTable();
	
		// MUY IMPORTANTE NO VARFIAR LOS VALORES
		$total_ancho_borde_columnas_celdas_2=($total_ancho_borde_columnas_celdas+$borde_exterior_tablero)*0.055; 
		$total_ancho_borde_filas_celdas_2=($total_ancho_borde_filas_celdas+$borde_exterior_tablero)*0.005;
	
		//Medidas 1
		$m1_1=1.3;
		$m1_2=4;
		$m1_3=1.1;
		$m1_4=4;
		$m1_5=1.1;
		$m1_6=4;
		$m1_7=1.1;
		$m1_8=4;
		$m1_9=1.3;
		
		$m1_a_descontar=($m1_1+$m1_2+$m1_3+$m1_4+$m1_5+$m1_6+$m1_7+$total_ancho_borde_columnas_celdas_2)/4;
			
		//Medidas 2
		
		$m2_1=3.9;
		$m2_2=4;
		$m2_3=3.5;
		$m2_4=4;
		$m2_5=3.9;
		
		$m2_a_descontar=($m2_1+$m2_2+$m2_3+$m2_4+$m2_5+$total_ancho_borde_filas_celdas_2)/2;
	
		$table->addRowsList(array($m1_1,$m1_2,$m1_3,$m1_4,$m1_5,$m1_6,$m1_7,$m1_8,$m1_9));
		$table->addColumnsList(array($m2_1,$m2_2,$m2_3,$m2_4,$m2_5));
	
	/* ESTABLEZO LA ALINEACION DE LAS CELDAS */
	$table->setVerticalAlignmentOfCells('center', 1, 1, 5, 5);
	
	/*COLOREO EL FONDO*/
	
	$celdas_no_usadas=explode(',',$datos_plantilla['celdas_no_usadas']);
	$n_celdas_no_usadas=count($celdas_no_usadas);
	
	for ($in=0; $in<=$n_celdas_no_usadas; $in++){
	
		$dn=explode('-',$celdas_no_usadas[$in]);
		$pn=$dn[0];
		$fn=$dn[1];
		$cn=$dn[2];
		$table->setBackgroundOfCells($color_fondo_panel, $fn, $cn);
	}

	
	/* COMPONGO LAS CELDAS USADAS */
	for ($i=0; $i<=$n_celdas_usadas; $i++){
		$d=explode('-',$celdas_usadas[$i]);
		$p=$d[0]; $f=$d[1]; $c=$d[2];
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=strtolower($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
				
					if ($img[$f][$c]['ruta'] !='') { 
						$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
						new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
				if ($img[$f][$c]['ruta'] !='') { 
					$table->addImageToCell($f, $c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
					new ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
				}
				$table->writeToCell($f, $c,  $_POST['txt_'.$p.'_'.$f.'_'.$c.''], 
				new Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''],$_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
				new ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if ($img[$f][$c]['ruta'] !='') { 
				$table->addImageToCell($f,$c, str_replace('../../../../','../../../',$img[$f][$c]['ruta']), 
				new ParFormat('center'), $_POST['tist_'.$p.'_'.$f.'_'.$c.''], $_POST['tist_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}

		/*BORDES DE LAS CELDAS*/
		if ($_POST['bc_'.$p.'_'.$f.'_'.$c.'']==1) { $table->setBordersOfCells(new BorderFormat($_POST['abc_'.$p.'_'.$f.'_'.$c.''], $_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']), $f, $c); }
	
	}
	
	
	/*BORDE DEL TABLERO*/ // setBordersOfCells (BorderFormat &$borderFormat, $startRow, $startColumn, $endRow, $endColumn, [boolean $left = true], [boolean $top = true], [boolean $right = true], [boolean $bottom = true])
	if ($borde==1) {
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 9, 1, 9, 5, false,false,false,true);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 1, 9, 1, true,false,false,false);
		$table->setBordersOfCells(new BorderFormat($ancho_borde, $color_borde, $tipo_borde_panel), 1, 5, 9, 5, false,false,true,false);
	}
	
	
	$rtf->sendRtf('A4_4x2_Con_cabecera_Vertical');
	
	break; // Final de la Plantilla A6 4 Cuadros Sin Cabecera
	
	//
	//*********************************************************************************************************************************
	//
	
	} // Cierro el Switch para cada tipo de Plantilla

} // Cierro el IF de comprobacion de si es Personalizado o Plantilla
?>
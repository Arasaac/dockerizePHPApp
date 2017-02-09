<?php
session_start();
require('../classes/phprtflite1.2.0/lib/PHPRtfLite.php');
require('../../../funciones/funciones.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
require('../../../classes/querys/query.php');

$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1);
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

//RECOJO LAS IMAGENES A USAR Y LAS PALABRAS ASIGNADAS A CADA UNA
//---------------------------------------------------------------

//RECOJO LAS IMAGENES A USAR Y LAS PALABRAS ASIGNADAS A CADA UNA
//---------------------------------------------------------------

//RECOJO LAS IMAGENES A USAR Y LAS PALABRAS ASIGNADAS A CADA UNA
//---------------------------------------------------------------

	if (isset($_POST['usar']) && $_POST['usar'] !="") {
			
		foreach ($_POST['usar'] as $indice=>$valor){ 
			
			$url=$_POST['usar'][$indice]; //Importante es el indice no el valor
			$encript->desencriptar($url,1); //pasamos los datos a desencriptar
			$ruta=$url['ruta_cesto'];
			$imagenes[]=$ruta;
			$nombres[]=$_POST['name'][$indice]; //Importante es el indice no el valor
			$mayusculas[]=strtoupper_utf8($_POST['name'][$indice]); //Importante es el indice no el valor
			$mayusculas2[]=strtoupper_utf8($_POST['name'][$indice]); //Importante es el indice no el valor
			$minusculas[]=$_POST['name'][$indice]; //Importante es el indice no el valor		
												
		}
	}	


//VARIABLES
$papel=4; //3 - A3 , 4 - A4 , 5 - A5
$orientacion=2; //Vertical
$ajuste_altura_tabla="null"; //o valores del + (minimo) al - (maximo)
$ancho_borde_tabla=$_POST['ancho_borde_tabla'];
$color_borde_tabla=$_POST['color_borde_tabla'];
$color_fondo=$_POST['color_fondo'];
$color_fondo_cabecera=$_POST['color_fondo_cabecera'];
$tipo_borde_tabla=$_POST['tipo_borde_tabla']; //dot, dash, dotdash, single
$texto_en_mayusculas=$_POST['inf_may']; //0 - Minúsculas 1-Mayúsculas
$fuente_texto=$_POST['fuente_texto'];
$posic_texto_celda=$_POST['posic_texto_celda'];
$enunciado_ejercicio=$_POST['enunciado'];

/* IMAGEN CABECERA */
if ($_POST['img_0_0_0'] !="") {
	$imagen[0][0]=$_POST['img_0_0_0'];
	$encript->desencriptar($imagen[0][0],1);
	$img_cabecera_insertar=str_replace('../../../../','../../../',$imagen[0][0]['ruta']);
}

$n_paginas=$_POST['n_pags']; //DEFINIDO POR EL USUARIO 4,6,8
$n_elementos_pag=$_POST['n_elementos_pag'];
$n_elementos_necesarios=$n_paginas*$n_elementos_pag;

$n_imagenes=count($imagenes); 

while (count($imagenes) < $n_elementos_necesarios) {
	foreach ($_POST['usar'] as $indice=>$valor){
			$url=$_POST['usar'][$indice]; //Importante es el indice no el valor
			$encript->desencriptar($url,1); //pasamos los datos a desencriptar
			$ruta=$url['ruta_cesto'];
			$imagenes[]=$ruta;
			$nombres[]=$_POST['name'][$indice]; //Importante es el indice no el valor
			$mayusculas[]=strtoupper_utf8($_POST['name'][$indice]); //Importante es el indice no el valor
			$mayusculas2[]=strtoupper_utf8($_POST['name'][$indice]); //Importante es el indice no el valor
			$minusculas[]=$_POST['name'][$indice]; //Importante es el indice no el valor
	}
}

$imagenes_partidas=array_chunk($imagenes,$n_elementos_pag);
$nombres_partidos=array_chunk($nombres,$n_elementos_pag);

// register PHPRtfLite class loader
PHPRtfLite::registerAutoloader();

//NUMERO DE ELEMENTOS POR PÁGINA
	switch ($n_elementos_pag) {
		
		case 6: //2x3
			$filas=3;
			$columnas=2;
			$img_celda=5; //VALOR IMPORTANTE NO CAMBIAR
			$font2 = new PHPRtfLite_Font(20,$fuente_texto, '#000000'); //CELDAS CON PALABRAS
			$separacion=2.2; //VALOR IMPORTANTE NO CAMBIAR
			$ancho_columna=7; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=5;
			$count = $columnas; //COLUMNAS 
		break;
		
		case 9: //3x3
			$filas=3;
			$columnas=3;
			$img_celda=5; //VALOR IMPORTANTE NO CAMBIAR
			$font2 = new PHPRtfLite_Font(18,$fuente_texto, '#000000'); //CELDAS CON PALABRAS
			$separacion=1; //VALOR IMPORTANTE NO CAMBIAR
			$ancho_columna=7; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=5;
			$count = $columnas;
		break;
		
		case 16: //4x4
			$filas=4;
			$columnas=4;
			$img_celda=3.6;
			$font2 = new PHPRtfLite_Font(14,$fuente_texto, '#000000'); //CELDAS CON PALABRAS
			$separacion=0.1; //VALOR IMPORTANTE NO CAMBIAR
			$ancho_columna=5.6; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=5;
			$count = $columnas;
		break;
		
		case 25: //5x5
			$filas=5;
			$columnas=5;
			$img_celda=3;
			$font2 = new PHPRtfLite_Font(12,$fuente_texto, '#000000'); //CELDAS CON PALABRAS
			$separacion=0.1; //VALOR IMPORTANTE NO CAMBIAR
			$ancho_columna=5.6; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=3;
			$count = $columnas;
		break;
	}

//Formato de Fuentes
$font1 = new PHPRtfLite_Font(11,$fuente_texto,'#000055');
$font = new PHPRtfLite_Font(9,$fuente_texto,'#000066');
$font3 = new PHPRtfLite_Font(36,$fuente_texto,'#000000'); //CABECERA
$par = new PHPRtfLite_ParFormat('center');

//Paragraph formats
$parFC = new PHPRtfLite_ParFormat('center');
$parFL = new PHPRtfLite_ParFormat('left');

//Rtf document
$rtf = new PHPRtfLite();
//Header
$header = $rtf->addFooter('all');
$header->writeText(''.$translate['autor_pictogramas'].': Sergio Palao '.$translate['procedencia'].': ARASAAC (http://catedu.es/arasaac/) '.$translate['licencia'].': CC (BY-NC-SA)', new PHPRtfLite_Font(6, 'Arial', '#999'), new PHPRtfLite_ParFormat('right'));

$header = $rtf->addHeader('all');
$header->writeText(''.$translate['creador_bingos'].' ARASAAC', new PHPRtfLite_Font(6, 'Arial', '#999'), new PHPRtfLite_ParFormat('right'));

//SECCION
$sect = $rtf->addSection();

//TAMAÑO DEL PAPEL
switch ($papel) {
	
	case 5:
	$PaperHeight=21;
	$PaperWidth=14.8;
	break;
	
	case 4:
	$PaperHeight=29.7;
	$PaperWidth=21;
	break;
	
	case 3:
	$PaperHeight=42;
	$PaperWidth=29.7;
	break;

}

//ORIENTACION DEL PAPEL
if ($orientacion==1) { 
	//Horizontal
	$sect->setPaperHeight($PaperWidth);
	$sect->setPaperWidth($PaperHeight);
	
} elseif ($orientacion==2) {

	$sect->setPaperHeight($PaperHeight);
	$sect->setPaperWidth($PaperWidth);
	
}

/**
 * Sets the margins of document pages.
 * @param float $marginLeft     Margin left (default 3 cm)
 * @param float $marginTop      Margin top (default 1 cm)
 * @param float $marginRight    Margin right (default 3 cm)
 * @param float $marginBottom   Margin bottom (default 2 cm)
*/
$sect->setMargins(1, 0.3, 1, 0.3) ;

//Borde de la seccion: Gris
//$sect->setBorders(new PHPRtfLite_Border_Format(2,'#CCCCCC'));

for ($p=0;$p<=($n_paginas-1);$p++){ // PAGINAS

if ($_POST['img_0_0_0'] !="") {
	$sect->writeText(""); 
	$tablecab = $sect->addTable();
	$tablecab->addRow(2); // add a row with a height of 2cm 
	$tablecab->addColumnsList(array(3,13,3)); // add 3 columns (first: 1cm, second: 2cm, third: 3cm)
	
	/* IMAGEN CABECERA */
	$cellcab1 = $tablecab->getCell(1, 1);
	$imagecab1 = $cellcab1->addImage($img_cabecera_insertar);
	$imagecab1->setWidth(3);
	$imagecab1->setHeight(3);
	
	/* IMAGEN CABECERA */
	$cellcab3 = $tablecab->getCell(1, 3);
	$imagecab3 = $cellcab3->addImage($img_cabecera_insertar);
	$imagecab3->setWidth(3);
	$imagecab3->setHeight(3);
	
	/* TEXTO CABECERA */
	$cellcab2 = $tablecab->getCell(1, 2);
	$cellcab2->writeText($enunciado_ejercicio,$font3,$par);
	
	//ALINEAMIENTO TABLA
	$tablecab->setVerticalAlignmentForCellRange(PHPRtfLite_Table_Cell::VERTICAL_ALIGN_CENTER, 1, 1, 1, 3);
	$tablecab->setTextAlignmentForCellRange('center', 1, 1, 1, 3);
	
	//BORDES
	$border = PHPRtfLite_Border::create($rtf,$ancho_borde_tabla,$color_borde_tabla,$tipo_borde_tabla);
	$tablecab->setBorderForCellRange($border, 1, 1, 1, 3);
	
	//COLOR FONDO
	$tablecab->setBackgroundForCellRange($color_fondo_cabecera, 1, 2, 1, 2);
} else {
	$sect->writeText("");
	$tablecab = $sect->addTable();
	$tablecab->addRow(2); // add a row with a height of 2cm 
	$tablecab->addColumnsList(array(19)); // add 3 columns (first: 1cm, second: 2cm, third: 3cm)
		
	/* TEXTO CABECERA */
	$cellcab2 = $tablecab->getCell(1, 1);
	$cellcab2->writeText($enunciado_ejercicio,$font3,$par);
	
	//ALINEAMIENTO TABLA
	$tablecab->setVerticalAlignmentForCellRange(PHPRtfLite_Table_Cell::VERTICAL_ALIGN_CENTER, 1, 1, 1, 1);
	$tablecab->setTextAlignmentForCellRange('center', 1, 1, 1, 1);
	
	//BORDES
	$border = PHPRtfLite_Border::create($rtf,$ancho_borde_tabla,$color_borde_tabla,$tipo_borde_tabla);
	$tablecab->setBorderForCellRange($border, 1, 1, 1, 1);
	
	//COLOR FONDO
	$tablecab->setBackgroundForCellRange($color_fondo_cabecera, 1, 1, 1, 1);
}

//*********************************************************************************************************
//CALCULOS PARA EL NUMERO DE FILAS Y COLUMNAS
$countCols = $columnas;
$countRows = $filas;
$colWidth = ($sect->getLayoutWidth()) / $columnas;

//table creating and rows ands columns adding
$table = $sect->addTable();

for ($y = 1; $y <= $countRows; $y ++) {	
	$table->addRow($alto_fila); 
}

for ($i = 1; $i <= $countCols; $i ++) {	
    $table->addColumn($colWidth); 
}

//BORDES
$border = PHPRtfLite_Border::create($rtf,$ancho_borde_tabla,$color_borde_tabla,$tipo_borde_tabla);
$table->setBorderForCellRange($border, 1, 1, $countRows, $countCols);

//ALINEAMIENTO TABLA
$table->setVerticalAlignmentForCellRange(PHPRtfLite_Table_Cell::VERTICAL_ALIGN_CENTER, 1, 1, $countRows, $countCols);

$n=0;
$t=0;

for ($f=1; $f<=$filas; $f++){ // FILAS

	for ($c=1; $c<=$columnas; $c++){ //COLUMNAS 

		$cell = $table->getCell($f, $c);
				
				if ($imagenes_partidas[$p][$n] != "") {
					
					if ($posic_texto_celda==0) { //Sin texto
						
						$imageFile = '../../../'.$imagenes_partidas[$p][$n];
						$image = $cell->addImage($imageFile);
						$image->setWidth($img_celda);
						$image->setHeight($img_celda);
						
					} elseif ($posic_texto_celda==1) { //Superior
						
						if ($texto_en_mayusculas==0) { $cell->writeText($nombres_partidos[$p][$n]."\n",$font2,$par); }
						elseif ($texto_en_mayusculas==1) { $cell->writeText(strtoupper_utf8($nombres_partidos[$p][$n]."\n"),$font2,$par); }
						$imageFile = '../../../'.$imagenes_partidas[$p][$n];
						$image = $cell->addImage($imageFile);
						$image->setWidth($img_celda);
						$image->setHeight($img_celda);
						
					} elseif ($posic_texto_celda==2) { //Inferior
						
						$imageFile = '../../../'.$imagenes_partidas[$p][$n];
						$image = $cell->addImage($imageFile);
						$image->setWidth($img_celda);
						$image->setHeight($img_celda);
						
						if ($texto_en_mayusculas==0) { $cell->writeText("\n".$nombres_partidos[$p][$n],$font2,$par); }
						elseif ($texto_en_mayusculas==1) { $cell->writeText(strtoupper_utf8("\n".$nombres_partidos[$p][$n]),$font2,$par); }
					
					}
					
					$n++;
				}
		
	} //CIERRO EL FOR DE LAS COLUMNAS
	
} //CIERRO EL FOR DE LAS FILAS
$table->setTextAlignmentForCellRange('center', 1, 1, $countRows, $countCols);
$table->setBackgroundForCellRange('#FFFFFF', 1, 1, $countRows, $countCols);

if ($p!=($n_paginas-1)) {
	$sect->insertPageBreak();
}

} //Cierro el FOR de las páginas

// send to browser
$rtf->sendRtf('bingo.rtf');
?>
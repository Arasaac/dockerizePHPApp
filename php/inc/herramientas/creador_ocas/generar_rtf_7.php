<?php
session_start();
require('../classes/phprtflite1.2.0/lib/PHPRtfLite.php');
require('../funciones/funciones_herramientas.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
require('../../../classes/querys/query.php');
include_once ("../classes/framemaker/framemaker.php");
include_once('../classes/utf8/utf8.class.php');
require_once ('../classes/img/Image_Toolbox.class.php');
require "../classes/text_image/class.atextimage.php";
require("../../../classes/graficas/jpgraph/jpgraph.php");
require("../../../classes/graficas/jpgraph/jpgraph_scatter.php");
include("../classes/text_image/fagd.php");
require ('../classes/imagetransform/Zebra_Image.php');
require("../classes/mergepictures/mergePicture.php");

// create a new instance of the class
$pictograma = new Zebra_Image();
	
	
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1);
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

//RECOJO LAS IMAGENES A USAR Y LAS PALABRAS ASIGNADAS A CADA UNA
//---------------------------------------------------------------

//RECOJO LAS IMAGENES A USAR Y LAS PALABRAS ASIGNADAS A CADA UNA
//---------------------------------------------------------------

//RECOJO LAS IMAGENES A USAR Y LAS PALABRAS ASIGNADAS A CADA UNA
//---------------------------------------------------------------

	if (isset($_POST['usar']) && $_POST['usar'] !='') {
			
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
$papel=$_POST['papel']; //3 - A3 , 4 - A4 , 5 - A5
$orientacion=1; //HORIZONTAL
$ajuste_altura_tabla='null'; //o valores del + (minimo) al - (maximo)
$ancho_borde_tabla=$_POST['ancho_borde_tabla'];
$color_borde_tabla=$_POST['color_borde_tabla'];
$tipo_borde_tabla=$_POST['tipo_borde_tabla']; //dot, dash, dotdash, single
$texto_en_mayusculas=$_POST['inf_may']; //0 - Minúsculas 1-Mayúsculas
$fuente_texto=$_POST['fuente_texto'];
$enunciado=$_POST['enunciado'];
$ancho_separador_celdas=$_POST['ancho_borde_celdas'];
$color_borde_separador_celdas=$_POST['color_borde_celdas'];

$n_elementos_necesarios=41;

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

// register PHPRtfLite class loader
PHPRtfLite::registerAutoloader();

//Formato de Fuentes
$font1 = new PHPRtfLite_Font(11,$fuente_texto,'#000055');
$font = new PHPRtfLite_Font(9,$fuente_texto,'#000066');
$font3 = new PHPRtfLite_Font(18,$fuente_texto,'#000000'); //CABECERA

//Paragraph formats
$parFC = new PHPRtfLite_ParFormat('center');
$parFL = new PHPRtfLite_ParFormat('left');

//Rtf document
$rtf = new PHPRtfLite();
//Header
$header = $rtf->addFooter('all');
$header->writeText(''.$translate['autor_pictogramas'].': Sergio Palao '.$translate['procedencia'].': ARASAAC (http://catedu.es/arasaac/) '.$translate['licencia'].': CC (BY-NC-SA)', new PHPRtfLite_Font(6, 'Arial', '#999'), new PHPRtfLite_ParFormat('right'));

$header = $rtf->addHeader('all');

if ($texto_en_mayusculas==0) {
	$header->writeText($enunciado, new PHPRtfLite_Font(16, $fuente_texto, '#999'), new PHPRtfLite_ParFormat('left'));
} elseif ($texto_en_mayusculas==1) {
	$header->writeText(strtoupper_utf8($enunciado), new PHPRtfLite_Font(16, $fuente_texto, '#999'), new PHPRtfLite_ParFormat('left'));
}

//SECCION
$sect = $rtf->addSection();

/**
 * Sets the margins of document pages.
 * @param float $marginLeft     Margin left (default 3 cm)
 * @param float $marginTop      Margin top (default 1 cm)
 * @param float $marginRight    Margin right (default 3 cm)
 * @param float $marginBottom   Margin bottom (default 2 cm)
*/
//$sect->setMargins(6, 0.3, 1, 0.3);

//TAMAÑO DEL PAPEL
switch ($papel) {
	
	case 4:
	$PaperHeight=29.7;
	$PaperWidth=21;
	$colWidth = 2;
	$colHeight= 2;
	$imgWidth = 1.9;
	$imgHeight= 2;
	$sect->setMargins(5, 0.3, 1, 0.3) ;
	break;
	
	case 3:
	$PaperHeight=42;
	$PaperWidth=29.7;
	$colWidth = 3;
	$colHeight= 3;
	$imgWidth = 3;
	$imgHeight= 3;
	$sect->setMargins(6, 0.3, 1, 0.3) ;
	break;

}

//ORIENTACION DEL PAPEL
if ($orientacion==1) { 
	//Horizontal
	$sect->setPaperHeight($PaperWidth);
	$sect->setPaperWidth($PaperHeight);
}


//CALCULOS PARA EL NUMERO DE FILAS Y COLUMNAS
$filas=8;
$columnas=10;
$countr = 8;
$countCols = 10;
$countRows = $countr;

//table creating and rows ands columns adding
$table = $sect->addTable();
$table->addRows($countr,$colHeight);
$table->addColumnsList(array_fill(0, $countCols, $colWidth));

//BORDES
//$border = PHPRtfLite_Border::create($rtf,$ancho_borde_tabla,$color_borde_tabla,$tipo_borde_tabla);
//$table->setBorderForCellRange($border, 1, 1, $countRows, $countCols);

//ALINEAMIENTO TABLA
$table->setVerticalAlignmentForCellRange(PHPRtfLite_Table_Cell::VERTICAL_ALIGN_CENTER, 1, 1, $countRows, $countCols);

$border1 = new PHPRtfLite_Border(
    $rtf,                                       // PHPRtfLite instance
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas), // left border: 2pt, green color
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla), // top border: 1pt, yellow color
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas), // right border: 2pt, red color
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla)  // bottom border: 1pt, blue color
);

$border2 = new PHPRtfLite_Border(
    $rtf,                                       // PHPRtfLite instance
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla), // left border: 2pt, green color
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas), // top border: 1pt, yellow color
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla), // right border: 2pt, red color
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas)  // bottom border: 1pt, blue color
);

$border_esq_izq = new PHPRtfLite_Border(
    $rtf,                                       // PHPRtfLite instance
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla), // left border: 2pt, green color
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla), // top border: 1pt, yellow color
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas), // right border: 2pt, red color
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas)  // bottom border: 1pt, blue color
);

$border_esq_dch = new PHPRtfLite_Border(
    $rtf,                                       // PHPRtfLite instance
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas), // left border: 2pt, green color
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla), // top border: 1pt, yellow color
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla), // right border: 2pt, red color
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas)  // bottom border: 1pt, blue color
);

$border_esq_inf_izq = new PHPRtfLite_Border(
    $rtf,                                       // PHPRtfLite instance
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla), // left border: 2pt, green color
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas), // top border: 1pt, yellow color
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas), // right border: 2pt, red color
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla)  // bottom border: 1pt, blue color
);

$border_esq_inf_dch = new PHPRtfLite_Border(
    $rtf,                                       // PHPRtfLite instance
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas), // left border: 2pt, green color
    new PHPRtfLite_Border_Format($ancho_separador_celdas, $color_borde_separador_celdas), // top border: 1pt, yellow color
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla), // right border: 2pt, red color
    new PHPRtfLite_Border_Format($ancho_borde_tabla, $color_borde_tabla)  // bottom border: 1pt, blue color
);

$i=0;

for ($f=1; $f<=$filas; $f++){ // FILAS

	for ($c=1; $c<=$columnas; $c++){ //COLUMNAS 

		$cell = $table->getCell($f, $c);
		
		$fc=$f.'-'.$c;
		
		switch ($fc) {
		
		case '1-1': //CASILLA
		$cell->setBorder($border_esq_izq);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'25',270,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '1-2': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'24',180,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '1-3': //OCA
		$cell->setBorder($border1);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_23.png','23',180,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_23.png');
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '1-4': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'22',180,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '1-5': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'21',180,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '1-6': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'20',180,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '1-7': //POSADA
		$cell->setBorder($border1);
		//$img_para_procesar=generar_ficha_oca('images/oca/restaurante_posada.png','19',180,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/posada_19.png');
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#66cc00');
		break;
		
		case '1-8': //OCA
		$cell->setBorder($border1);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_18.png','18',180,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_18.png');
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '1-9': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'17',180,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '1-10': //CASILLA
		$cell->setBorder($border_esq_dch);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'16',90,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '2-1': //DADOS
		$cell->setBorder($border2);
		//$img_para_procesar=generar_ficha_oca('images/oca/dados.png','26',270,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/dados_26.png');
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FF0000');
		break;
		
		case '2-2': //CASILLA
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'51',180,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '2-3': //OCA
		$cell->setBorder($border1);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_50.png','50',180,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_50.png');
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '2-4': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'49',180,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '2-5': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'48',180,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '2-6': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'47',180,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '2-7': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'46',180,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '2-8': //OCA
		$cell->setBorder($border1);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_45.png','45',180,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_45.png');
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '2-9': //CASILLA
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'44',90,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '2-10': //CASILLA
		$cell->setBorder($border2);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'15',90,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '3-1': //OCA
		$cell->setBorder($border2);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_27.png','27',270,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_27.png');
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '3-2': //CARCEL
		$cell->setBorder($border2);
		//$img_para_procesar=generar_ficha_oca('images/oca/prisionero.png','52',270,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/carcel_52.png');
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#C1C1C1');
		break;
		
		case '3-3': //ZONA CENTRAL
			if ($papel==3) { 
				$image = $cell->addImage('../../../images/oca/pantano.png');
			} elseif ($papel==4) { 
				$image = $cell->addImage('../../../images/oca/pantano.png');
				$image->setWidth(10);
				$image->setHeight(6.3);
			}
		break;
		
		case '3-8': //ZONA CENTRAL
		$image = $cell->addImage('../../../images/oca/ganar.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		break;
		
		case '3-9': //CASILLA
		$cell->setBorder($border2);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'43',90,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '3-10': //OCA
		$cell->setBorder($border2);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_14.png','14',90,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_14.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '4-1': //CASILLA
		$cell->setBorder($border2);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'28',270,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '4-2': //DADOS
		$cell->setBorder($border2);
		//$img_para_procesar=generar_ficha_oca('images/oca/dados.png','53',270,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/dados_53.png');
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FF0000');
		break;
			
		case '4-8': //CASILLA
		$cell->setBorder($border2);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'63',90,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '4-9': //LABERINTO
		$cell->setBorder($border2);
		//$img_para_procesar=generar_ficha_oca('images/oca/laberinto.png','42',90,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/laberinto_42.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#CC00FF');
		break;
		
		case '4-10': //CASILLA
		$cell->setBorder($border2);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'13',90,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '5-1': //CASILLA
		$cell->setBorder($border2);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'29',270,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;

		case '5-2': //OCA
		$cell->setBorder($border2);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_54.png','54',270,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_54.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '5-8': //CASILLA
		$cell->setBorder($border2);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'62',90,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '5-9': //OCA
		$cell->setBorder($border2);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_41.png','41',90,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_41.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '5-10': //PUENTE
		$cell->setBorder($border2);
		//$img_para_procesar=generar_ficha_oca('images/oca/puente.png','12',90,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/puente_12.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#6699FF');
		break;
		
		case '6-1': //CASILLA
		$cell->setBorder($border2);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'30',270,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '6-2': //CASILLA
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'55',270,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '6-3': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'56',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '6-4': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'57',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '6-5': //CALAVERA
		$cell->setBorder($border1);
		//$img_para_procesar=generar_ficha_oca('images/oca/calavera.png','58',360,'#FFFFFF',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/calavera_58.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#000000');
		break;
		
		case '6-6': //OCA
		$cell->setBorder($border1);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_59.png','59',360,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_59.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '6-7': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'60',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '6-8': //CASILLA
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'61',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '6-9': //CASILLA
		$cell->setBorder($border2);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'40',90,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '6-10': //CASILLA
		$cell->setBorder($border2);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'11',90,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '7-1'://POZO
		$cell->setBorder($border_esq_inf_izq);
		//$img_para_procesar=generar_ficha_oca('images/oca/pozo.png','31',270,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/pozo_31.png');
		$image->setWidth($imgWidth-0.1);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#CC00FF');
		break;
		
		case '7-2': //OCA
		$cell->setBorder($border1);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_32.png','32',360,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_32.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '7-3': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'33',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '7-4': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'34',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '7-5': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'35',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '7-6': //OCA
		$cell->setBorder($border1);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_36.png','36',360,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_36.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '7-7': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'37',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '7-8': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'38',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '7-9': //CASILLA
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'39',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '7-10': //CASILLA
		$cell->setBorder($border2);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'10',90,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '8-1':	
		$cell->setBorder($border_esq_inf_izq);
		$cell->setBorder($border1);
		$image = $cell->addImage('../../../images/oca/salida.png');
		$image->setWidth($colWidth*2);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '8-2':
		$cell->setBorder($border1);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '8-3': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'2',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '8-4': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'3',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '8-5': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'4',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '8-6': //OCA
		$cell->setBorder($border1);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_5.png','5',360,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_5.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
		
		case '8-7': //PUENTE
		$cell->setBorder($border1);
		//$img_para_procesar=generar_ficha_oca('images/oca/puente.png','6',360,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/puente_6.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#6699FF');
		break;
		
		case '8-8': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'7',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '8-9': //CASILLA
		$cell->setBorder($border1);
		$img_para_procesar=generar_ficha_oca($imagenes[$i],'8',360,'#000000',42,$pictograma);
		$image = $cell->addImage($img_para_procesar);
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$i++;
		break;
		
		case '8-10': //CASILLA
		$cell->setBorder($border_esq_inf_dch);
		//$img_para_procesar=generar_ficha_oca('images/oca/oca_b.png','9',360,'#000000',42,$pictograma);
		$image = $cell->addImage('../../../images/oca/oca_9.png');
		$image->setWidth($imgWidth);
		$image->setHeight($imgHeight);
		$cell->setBackgroundColor('#FFFF00');
		break;
			
		
		}//CIERRO EL SWITCH
		
	} //CIERRO EL FOR DE LAS COLUMNAS
	
} //CIERRO EL FOR DE LAS FILAS

$table->setTextAlignmentForCellRange('left', 1, 1, $countRows, $countCols);
$table->setTextAlignmentForCellRange('right', 1, 1, 2, $countCols);
// merge cells from row 1 column 1 to row 2 and column 3
$table->mergeCellRange(3, 3, 5, 7);
$table->mergeCellRange(8, 1, 8, 2);

// send to browser
$rtf->sendRtf('oca.rtf');
?>
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

$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1);
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

// create a new instance of the class
$pictograma = new Zebra_Image();

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
	
	$n_imagenes=count($imagenes); 
	
	//VUELVO A RECORRER PARA LLENAR DOS VECES EL ARRAY
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
$papel=$_POST['papel']; //3 - A3 , 4 - A4 , 5 - A5
$orientacion=$_POST['orientacion']; //Vertical
$texto_en_mayusculas=$_POST['inf_may']; //0 - Minúsculas 1-Mayúsculas
$fuente_texto=$_POST['fuente_texto'];
$enunciado_ejercicio=$_POST['enunciado'];
$combinacion=$_POST['tipo_bingo'];
$sz_f_s=$_POST['size_font_pictos']; //TAMAÑO DEL TEXTO PARA LOS PICTOGRAMAS DE TEXTO
$fuente_pictos=$_POST['fuente_texto']; //FUENTE PARA LOS PICTOGRAMAS DE TEXTO 
$orientacion_ficha=$_POST['orientacion_ficha']; //1- Vertical 2-Horizontal
$tamanyo_ficha=$_POST['tamanyo_ficha']; //1-Normal 2-Grande
$color_ficha=$_POST['color_ficha']; 
$color_font=$_POST['color_texto']; //COLOR DE LA FUENTE PARA LOS PICTOGRAMAS DE TEXTO

// register PHPRtfLite class loader
PHPRtfLite::registerAutoloader();

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
$header->writeText($translate['generador_dominos_enacadenados'], new PHPRtfLite_Font(6, 'Arial', '#999'), new PHPRtfLite_ParFormat('right'));

//SECCION
$sect = $rtf->addSection();
$sect->writeText($enunciado_ejercicio."\n",new PHPRtfLite_Font(24,$fuente_pictos,'#000000'),new PHPRtfLite_ParFormat('center'));

//TAMAÑO DEL PAPEL
switch ($papel) {
	
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

$ficha=array();

//GENERO LAS FICHAS
if ($combinacion==1) { //SOLO IMAGENES
    		
		for ($t=0;$t<$n_imagenes;$t++) {
			$ficha[]=generar_ficha_domino($imagenes[$t],$imagenes[$t+1],$pictograma,$orientacion_ficha,$color_ficha);
		}

	
} elseif ($combinacion==2) { //IMAGENES - TEXTO

	$simbolo_texto=array();
	
	if ($texto_en_mayusculas==0) {
	
		for ($m=0;$m<$n_imagenes+1;$m++) {
			
		  $simbolo_texto[]=generar_simbolos_solo_texto(480,480,$sz_f_s,$color_font,$fuente_pictos,'center',$nombres[$m],'png');
			
		}
		
	} elseif ($texto_en_mayusculas==1) {
	
		for ($c=0;$c<$n_imagenes+1;$c++) {
			
		  $simbolo_texto[]=generar_simbolos_solo_texto(480,480,$sz_f_s,$color_font,$fuente_pictos,'center',$mayusculas[$c],'png');
			
		}
		
	}

	 for ($t=0;$t<$n_imagenes;$t++) {

		$ficha[]=generar_ficha_domino($imagenes[$t],str_replace('../../../','',$simbolo_texto[$t+1]),$pictograma,$orientacion_ficha,$color_ficha);
	
	 }

} elseif ($combinacion==3) { //MAYUSCULA-MINUSCULA
	
		$simbolo_minuscula=array();
		$simbolo_mayuscula=array();
	
		for ($m=0;$m<$n_imagenes+1;$m++) {
			
		  $simbolo_mayuscula[]=generar_simbolos_solo_texto(480,480,$sz_f_s,$color_font,$fuente_pictos,'center',$nombres[$m],'png');
			
		}
		
	
		for ($c=0;$c<$n_imagenes+1;$c++) {
			
		  $simbolo_minuscula[]=generar_simbolos_solo_texto(480,480,$sz_f_s,$color_font,$fuente_pictos,'center',$mayusculas[$c],'png');
			
		}
		

	 for ($t=0;$t<$n_imagenes;$t++) {

		$ficha[]=generar_ficha_domino(str_replace('../../../','',$simbolo_mayuscula[$t]),str_replace('../../../','',$simbolo_minuscula[$t+1]),$pictograma,$orientacion_ficha,$color_ficha);
	
	 }
	
} elseif ($combinacion==4) { //MINUSCULA-MAYUSCULA
	
		$simbolo_minuscula=array();
		$simbolo_mayuscula=array();
	
		for ($m=0;$m<$n_imagenes+1;$m++) {
			
		  $simbolo_mayuscula[]=generar_simbolos_solo_texto(480,480,$sz_f_s,$color_font,$fuente_pictos,'center',$nombres[$m],'png');
			
		}
		
	
		for ($c=0;$c<$n_imagenes+1;$c++) {
			
		  $simbolo_minuscula[]=generar_simbolos_solo_texto(480,480,$sz_f_s,$color_font,$fuente_pictos,'center',$mayusculas[$c],'png');
			
		}
		

	 for ($t=0;$t<$n_imagenes;$t++) {

		$ficha[]=generar_ficha_domino(str_replace('../../../','',$simbolo_minuscula[$t]),str_replace('../../../','',$simbolo_mayuscula[$t+1]),$pictograma,$orientacion_ficha,$color_ficha);
	
	 }
	
}

if ($orientacion==1 && $papel==4) { //A4 Horizontal

	if ($orientacion_ficha==1) { //Vertical
	
		if ($tamanyo_ficha==1) {
			$filas=4;
			$columnas=7;
			$img_celda=3;
			$font2 = new PHPRtfLite_Font(12,$fuente_texto, '#000000'); //CELDAS CON PALABRAS
			$ancho_columna=4; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=7;
			$count = $columnas;
			$ficha_width=3.2;
			$ficha_height=6.4;
		} elseif ($tamanyo_ficha==2) {
			$filas=7;
			$columnas=4;
			$img_celda=3;
			$font2 = new PHPRtfLite_Font(12,$fuente_texto, '#000000'); //CELDAS CON PALABRAS
			$ancho_columna=7; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=13;
			$count = $columnas;
			$ficha_width=6.4;
			$ficha_height=12.8;
		}
		
	} elseif ($orientacion_ficha==2) { //Horizontal
		if ($tamanyo_ficha==1) {
			$filas=7;
			$columnas=4;
			$img_celda=3;
			$font2 = new PHPRtfLite_Font(12,$fuente_texto, '#000000'); //CELDAS CON PALABRAS
			$ancho_columna=7; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=3.8;
			$count = $columnas;
			$ficha_width=6.4;
			$ficha_height=3.2;
		} elseif ($tamanyo_ficha==2) {
			$filas=14;
			$columnas=2;
			$img_celda=3;
			$font2 = new PHPRtfLite_Font(12,$fuente_texto, '#000000'); //CELDAS CON PALABRAS
			$ancho_columna=14; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=7;
			$count = $columnas;
			$ficha_width=12.8;
			$ficha_height=6.4;
			
		}
		
	}

} elseif ($orientacion==2 && $papel==4) { //A4 Vertical
	
	if ($orientacion_ficha==1) { //Vertical
		if ($tamanyo_ficha==1) {
			$filas=6;
			$columnas=5;
			$ancho_columna=3.8; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=6.8;
			$count = $columnas;
			$ficha_width=3.2;
			$ficha_height=6.4;
		} elseif ($tamanyo_ficha==2) {
			$filas=10;
			$columnas=3;
			$ancho_columna=6.5; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=12.2;
			$count = $columnas;
			$ficha_width=6;
			$ficha_height=12;
		}
	} elseif ($orientacion_ficha==2) { //Horizontal
		if ($tamanyo_ficha==1) {
			$filas=10;
			$columnas=3;
			$ancho_columna=6.5; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=3.4;
			$count = $columnas;
			$ficha_width=6.4;
			$ficha_height=3.2;
		} elseif ($tamanyo_ficha==2) {
			$filas=28;
			$columnas=1;
			$ancho_columna=18; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=6.1;
			$count = $columnas;
			$ficha_width=12;
			$ficha_height=6;
		}
	
	}

} elseif ($orientacion==1 && $papel==3) { //A3 Horizontal

	if ($orientacion_ficha==1) { //Vertical
		if ($tamanyo_ficha==1) {
			$columnas=7;
			$ancho_columna=5.2; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=10.2;
			$count = $columnas;
			$ficha_width=5;
			$ficha_height=10;
		} elseif ($tamanyo_ficha==2) {
			$columnas=4;
			$ancho_columna=10; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=20;
			$count = $columnas;
			$ficha_width=9.7;
			$ficha_height=19.4;
		}
	} elseif ($orientacion_ficha==2) { //Horizontal
		if ($tamanyo_ficha==1) {
			$columnas=4;
			$ancho_columna=10.2; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=5.2;
			$count = $columnas;
			$ficha_width=10;
			$ficha_height=5;
		} elseif ($tamanyo_ficha==2) {
			$columnas=2;
			$ancho_columna=20.2; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=11;
			$count = $columnas;
			$ficha_width=20;
			$ficha_height=10;
		}
	}

} elseif ($orientacion==2 && $papel==3) { //A3 Vertical
	
	if ($orientacion_ficha==1) { //Vertical
		if ($tamanyo_ficha==1) {
			$columnas=5;
			$ancho_columna=5.5; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=10.5;
			$count = $columnas;
			$ficha_width=5;
			$ficha_height=10;
		} elseif ($tamanyo_ficha==2) {
			$columnas=3;
			$ancho_columna=9.4; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=18.5;
			$count = $columnas;
			$ficha_width=9.2;
			$ficha_height=18.4;
		}
	} elseif ($orientacion_ficha==2) { //Horizontal
		if ($tamanyo_ficha==1) {
			$columnas=3;
			$ancho_columna=9.3; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=4.8;
			$count = $columnas;
			$ficha_width=9;
			$ficha_height=4.5;
		} elseif ($tamanyo_ficha==2) {
			$columnas=1;
			$ancho_columna=27; //VALOR IMPORTANTE NO CAMBIAR
			$alto_fila=11.9;
			$count = $columnas;
			$ficha_width=23;
			$ficha_height=11.5;
		}
	}

}

$n_fichas=count($ficha);
$n_filas=$n_fichas/$columnas;

if(is_float($n_filas)) {
	$n_filas=intval($n_filas)+1;
}

//table creating and rows ands columns adding
$table = $sect->addTable();
$table->addRows($n_filas,$alto_fila);
$table->addColumnsList(array_fill(0,$columnas,$ancho_columna));

$i=0;

for ($f=1; $f<=$n_filas; $f++){ // FILAS

	for ($c=1; $c<=$columnas; $c++){ //COLUMNAS 
		
		if ($ficha[$i] != '') {
			$cell = $table->getCell($f,$c);
			//$cell->writeText($n_filas);
			$image = $cell->addImage($ficha[$i]);
			$image->setWidth($ficha_width);
			$image->setHeight($ficha_height);
		}
		$i++;
		
	}
}

$table->setTextAlignmentForCellRange('center', 1, 1, $n_filas,$columnas);

// send to browser
$rtf->sendRtf('domino_encadenado.rtf');
?>
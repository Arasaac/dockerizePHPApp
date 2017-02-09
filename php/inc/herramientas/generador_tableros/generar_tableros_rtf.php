<?php
session_start();
require('../classes/phprtflite.1.0.1/lib/PHPRtfLite.php');
require('../../../funciones/funciones.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
require('../../../classes/querys/query.php');

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1);
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

if (isset($_POST['posicion_dias_horas'])) $posicion_dias_horas=$_POST['posicion_dias_horas'];
if (isset($_POST['orientacion'])) $orientacion=$_POST['orientacion']; //1-Horizontal 2-Vertical 
if (isset($_POST['borde'])) $borde=$_POST['borde'];
if (isset($_POST['color_borde'])) $color_borde=$_POST['color_borde'];
if (isset($_POST['ancho_borde'])) $ancho_borde=$_POST['ancho_borde'];
if (isset($_POST['color_fondo'])) $color_fondo_panel=$_POST['color_fondo'];
if (isset($_POST['tipo_borde'])) $tipo_borde_panel=$_POST['tipo_borde'];
if (isset($_POST['rows'])) $filas=$_POST['rows'];
if (isset($_POST['cols'])) $columnas=$_POST['cols'];

// register PHPRtfLite class loader
PHPRtfLite::registerAutoloader();

//Rtf document
$rtf = new PHPRtfLite();
//Header
$header = $rtf->addFooter('all');
$header->writeText(''.$translate['autor_pictogramas'].': Sergio Palao '.$translate['procedencia'].': ARASAAC (http://catedu.es/arasaac/) '.$translate['licencia'].': CC (BY-NC-SA)', new PHPRtfLite_Font(6, 'Arial', '#999'), new PHPRtfLite_ParFormat('right'));
$header = $rtf->addHeader('all');
$header->writeText(''.$translate['generador_tableros'].' ARASAAC v0.1', new PHPRtfLite_Font(6, 'Arial', '#999'), new PHPRtfLite_ParFormat('right'));

//section
$sect = $rtf->addSection();

switch ($_POST['papel']) {
	
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
$sect->setMargins($_POST['margen_izquierdo'], $_POST['margen_superior'], $_POST['margen_derecho'], $_POST['margen_inferior']) ;

/* IMAGEN CABECERA */
if ($_POST['img_0_0_0'] !="") {
	$imagen[0][0]=$_POST['img_0_0_0'];
	$encript->desencriptar($imagen[0][0],1);
	$img_insertar=str_replace('../../../../','../../../',$imagen[0][0]['ruta']);
	$sect->addImage($img_insertar, new PHPRtfLite_ParFormat('left'), $_POST['tict_0_0_0'], $_POST['tict_0_0_0']);
}

/* TEXTO CABECERA */
if ($_POST['txt_0_0_0'] !="") {
	$sect->writeText($_POST['txt_0_0_0'] . "\n", new PHPRtfLite_Font($_POST['sftc_0_0_0'], $_POST['ftc_0_0_0'], $_POST['ctc_0_0_0']), new PHPRtfLite_ParFormat());
}

$count = $columnas;
$countr = $filas;
$countCols = $count;
$countRows = $countr;

if ($_POST['ajuste_anchura_celdas']==1) {
	$colWidth = ($sect->getLayoutWidth()) / $countCols;
} elseif ($_POST['ajuste_anchura_celdas']==0) {
	$colWidth = $_POST['anchura_celdas'];
}

if ($_POST['ajuste_altura_celdas']==1) {
	$rowHeight = 'null';
} elseif ($_POST['ajuste_altura_celdas']==0) {
	$rowHeight = '-'.$_POST['altura_celdas'];
}
//table creating and rows ands columns adding
$table = $sect->addTable();
//$table->addRows(1,2);
$table->addRows($countr,$rowHeight);

for ($i = 1; $i <= $countCols; $i ++) {	
    $table->addColumn($colWidth);
}

//borders
$border = PHPRtfLite_Border::create($_POST['ancho_borde_tabla'],$_POST['color_borde_tabla'],$_POST['tipo_borde_tabla']);
$table->setBorderForCellRange($border, 1, 1, $countRows, $countCols);

//top row
$table->setVerticalAlignmentForCellRange(PHPRtfLite_Table_Cell::VERTICAL_ALIGN_CENTER, 1, 1, $countRows, $countCols);

$p=1;

for ($f=1; $f<=$countr; $f++){ // FILAS

	for ($c=1; $c<=$countCols; $c++){ //COLUMNAS 
		
		if ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=$_POST['txt_'.$p.'_'.$f.'_'.$c.'']; }
		elseif ($_POST['mtc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda=strtoupper_utf8($_POST['txt_'.$p.'_'.$f.'_'.$c.'']); }
		
		if ($_POST['ttc_'.$p.'_'.$f.'_'.$c.'']==0) { $texto_celda=$texto_celda; }
		elseif ($_POST['ttc_'.$p.'_'.$f.'_'.$c.'']==1) { $texto_celda='<b>'.$texto_celda.'</b>'; }
		elseif ($_POST['ttc_'.$p.'_'.$f.'_'.$c.'']==2) { $texto_celda='<i>'.$texto_celda.'</i>'; }
		elseif ($_POST['ttc_'.$p.'_'.$f.'_'.$c.'']==3) { $texto_celda='<b><i>'.$texto_celda.'</i></b>'; }
		
		$imagen[$f][$c]=$_POST['img_1_'.$f.'_'.$c.''];
		$encript->desencriptar($imagen[$f][$c],1);
		
		//echo $p.'_'.$f.'_'.$c.'/'.$imagen[$f][$c]['ruta'].'<br />';
		
		if (isset($imagen[$f][$c]['ruta'])) $img_insertar=str_replace('../../../../','../../../',$imagen[$f][$c]['ruta']);
					
		if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) > 0) { 
			if ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==1) {
					$cell = $table->getCell($f, $c);
					$cell->writeText($texto_celda, 
					new PHPRtfLite_Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
					new PHPRtfLite_ParFormat('center'));
				
					if ($imagen[$f][$c]['ruta'] !='') {
						$img = $cell->addImage($img_insertar, new PHPRtfLite_ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']);
					}
					
			} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.'']==2) {
					$cell = $table->getCell($f, $c);
					if ($imagen[$f][$c]['ruta'] !='') {
						$img = $cell->addImage($img_insertar, new PHPRtfLite_ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']);
					}
					
					$cell->writeText($texto_celda, 
					new PHPRtfLite_Font($_POST['sftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ftc_'.$p.'_'.$f.'_'.$c.''], $_POST['ctc_'.$p.'_'.$f.'_'.$c.'']),
					new PHPRtfLite_ParFormat('center'));
			}
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] == 0) {
		
			if ($imagen[$f][$c]['ruta'] !='') { 
				$cell = $table->getCell($f, $c);
				$img = $cell->addImage($img_insertar, new PHPRtfLite_ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
			}
			
		} elseif ($_POST['ptc_'.$p.'_'.$f.'_'.$c.''] > 0 && strlen($_POST['txt_'.$p.'_'.$f.'_'.$c.'']) ==0) {
		
			if (isset($imagen[$f][$c]['ruta']) &&  $imagen[$f][$c]['ruta'] !='') { 
				$cell = $table->getCell($f, $c);
				$img = $cell->addImage($img_insertar, new PHPRtfLite_ParFormat('center'), $_POST['tict_'.$p.'_'.$f.'_'.$c.''], $_POST['tict_'.$p.'_'.$f.'_'.$c.'']); 
			}
		
		}
		
		/*BORDES DE LAS CELDAS*/
		if ($_POST['cbc_'.$p.'_'.$f.'_'.$c.'']!=$_POST['color_borde_tabla']) { 
			$border = PHPRtfLite_Border::create($_POST['ancho_borde_tabla'],$_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tipo_borde_tabla']); 
			//$border = PHPRtfLite_Border::create($_POST['abc_'.$p.'_'.$f.'_'.$c.''],$_POST['cbc_'.$p.'_'.$f.'_'.$c.''], $_POST['tbc_'.$p.'_'.$f.'_'.$c.'']); ESTO ERA CUANDO SE PERSONALIZABAN LAS CELDAS INDIVIDUALMENTE
			$table->setBorderForCellRange($border, $f, $c);
			/*$table->setBackgroundForCellRange('#dddddd', $f, $c);*/
		}
		
		/*COLOR FONDO DE LAS CELDAS*/
			if ($_POST['cfc_'.$p.'_'.$f.'_'.$c.''] !="" || $_POST['cfc_'.$p.'_'.$f.'_'.$c.''] != NULL) { 
  				$table->setBackgroundForCellRange($_POST['cfc_'.$p.'_'.$f.'_'.$c.''], $f, $c);
			}
		
	}
	
}

/*$fontBold = new PHPRtfLite_Font(11, 'Times new Roman', '#7A2900');
$fontBold->setBold();*/

$table->setTextAlignmentForCellRange('center', 1, 1, $countRows, $countCols);
/*$table->setFontForCellRange(new PHPRtfLite_Font(11, 'Times new Roman', '#7A2900'), 2, 2, $countRows, $countCols - 1);
$table->setFontForCellRange($fontBold, 2, $countCols, $countRows);*/

/*$cell = $table->getCell(1,1);
$img = $cell->addImage('../../../repositorio/originales/6012.png', new PHPRtfLite_ParFormat('center'),2,2);*/

// send to browser
$rtf->sendRtf('tablero_'.$filas.'x'.$columnas.'.rtf');
?>
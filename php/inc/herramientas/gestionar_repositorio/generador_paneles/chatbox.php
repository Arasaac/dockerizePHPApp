<?php
require_once("../classes/phprtflite/Rtf.php");
require('../../../funciones/funciones.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$borde=$_POST['borde'];
$color_borde=$_POST['color_borde'];

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
?>
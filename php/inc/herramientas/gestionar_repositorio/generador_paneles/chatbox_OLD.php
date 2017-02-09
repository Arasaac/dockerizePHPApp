<?php
require_once("../classes/phprtflite/Rtf.php");

//paragraph formats
$parF = new ParFormat();

$img[1][1]='../../../repositorio/originales/8164.png';
$img[1][2]='../../../repositorio/originales/8165.png';
$img[1][3]='../../../repositorio/originales/8166.png';
$img[1][4]='../../../repositorio/originales/8167.png';
$img[2][1]='../../../repositorio/originales/8168.png';
$img[2][2]='../../../repositorio/originales/8169.png';
$img[2][3]='../../../repositorio/originales/8170.png';
$img[2][4]='../../../repositorio/originales/8171.png';
$img[3][1]='../../../repositorio/originales/8172.png';
$img[3][2]='../../../repositorio/originales/8173.png';
$img[3][3]='../../../repositorio/originales/8174.png';
$img[3][4]='../../../repositorio/originales/8175.png';
$img[4][1]='../../../repositorio/originales/8176.png';
$img[4][2]='../../../repositorio/originales/8177.png';
$img[4][3]='../../../repositorio/originales/8178.png';
$img[4][4]='../../../repositorio/originales/8179.png';

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
$table->addRows(4, 3);
$table->addColumnsList(array(3,3,3,3));
$table->setVerticalAlignmentOfCells('center', 1, 1, 4, 4);

for ($f=1; $f<=4; $f++){ // FILAS
	for ($c=1; $c<=4; $c++){ //COLUMNAS
		$table->addImageToCell($f, $c, $img[$f][$c], new ParFormat('center'), 2.8, 2.8);
	}
}

$rtf->sendRtf('chatbox');
?>
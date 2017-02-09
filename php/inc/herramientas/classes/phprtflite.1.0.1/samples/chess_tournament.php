<?php
require '../lib/PHPRtfLite.php';

// register PHPRtfLite class loader
PHPRtfLite::registerAutoloader();

//Font formats
$font1 = new PHPRtfLite_Font(11, 'Times new Roman', '#000055');

//Paragraph formats
$parFC = new PHPRtfLite_ParFormat('center');
$parFL = new PHPRtfLite_ParFormat('left');

//Rtf document
$rtf = new PHPRtfLite();

//Header
$header = $rtf->addHeader('first');
$header->writeText('Generador de Calendarios ARASAAC v0.1', new PHPRtfLite_Font(), new PHPRtfLite_ParFormat('right'));

//section
$sect->writeRtfCode('\par ');
$sect = $rtf->addSection();
$sect->writeText('Horario de: (write your data)' . "\n", new PHPRtfLite_Font(14, 'Arial'), new PHPRtfLite_ParFormat());

$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
$horas=array('9:00', '10:00', '11:00', '12:00', '13:00', '14:00','15:00','16:00');

/*$chessResults = (array(
				array(0  , 1  , 0.5, 1  , 0  , 1  , 0  , 0.5  , 1  , 1  ),
				array(0, 0, 0.5, 0.5, 0, 0, 0, 0, 0, 1),
				array(0.5, 1, 0, 1, 0.5, 1, 0.5, 0, 0, 1),
				array(0, 0.5, 0.5, 0, 0, 0.5, 0.5, 0, 0, 1),				


				array(1, 0.5, 1, 0, 0, 0.5, 0.5, 0, 0, 1),			

));*/

$count = count($dias);
$countr = count($horas);
$countCols = $count + 1;
$countRows = $countr + 1;

$colWidth = ($sect->getLayoutWidth() - 2) / $count;

//table creating and rows ands columns adding
$table = $sect->addTable();
$table->addRows(1, 2);
$table->addRows($countr, -0.6);

$table->addColumn(3);
for ($i = 1; $i <= count($dias); $i ++) {	
    $table->addColumn($colWidth);
}

//borders
$border = PHPRtfLite_Border::create(2, '#000');
$table->setBorderForCellRange($border, 1, 1, $countRows, $countCols);

//top row
$table->setVerticalAlignmentForCellRange(PHPRtfLite_Table_Cell::VERTICAL_ALIGN_CENTER, 1, 1, 1, $countCols);

$i = 2;
foreach ($dias as $celdadias) {
  	$table->writeToCell(1, $i, $celdadias, $font1, null);
  	$table->setBorderForCellRange($border, $i, $i);
  	$i++;
}

$s=2;
foreach ($horas as $celdahoras) {
  	$table->writeToCell($s, 1, $celdahoras, $font1, new PHPRtfLite_ParFormat('center'), false);
  	$table->setBorderForCellRange($border, $s, $s);
  	$s++;
}

//tournament result
/*$i = 1;
foreach ($chessResults as $playerResult) {
    $j = 1;
    $sum = 0;
    foreach ($playerResult as $result)  {
        if ($i != $j) {
            $table->writeToCell($i + 1, $j + 1, $result, new PHPRtfLite_Font(11, 'Times new Roman', '#7A2900'), new PHPRtfLite_ParFormat('center'));
            $sum += $result;
        }
        $j++;
    }
    $table->writeToCell($i + 1, $j + 1, '<b>'.$sum.'</b>', new PHPRtfLite_Font(11, 'Times new Roman', '#7A2900'), new PHPRtfLite_ParFormat('center'));
    $i++;
}*/

$fontBold = new PHPRtfLite_Font(11, 'Times new Roman', '#7A2900');
$fontBold->setBold();

$table->setTextAlignmentForCellRange('center', 1, 1, $countRows, $countCols);
$table->setFontForCellRange(new PHPRtfLite_Font(11, 'Times new Roman', '#7A2900'), 2, 2, $countRows, $countCols - 1);
$table->setFontForCellRange($fontBold, 2, $countCols, $countRows);

$table->writeToCell(1, 1, 'HORAS', $font1, new PHPRtfLite_ParFormat('center'));
$table->setBorderForCellRange($border, 1, $countCols, $countRows, $countCols);


// send to browser
$rtf->sendRtf('horario.rtf');
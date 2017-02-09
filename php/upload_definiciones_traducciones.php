<?php
include ('classes/querys/query.php');
require_once ('classes/xls_parser/reader.php');
set_time_limit(25000); 
$query=new query(); 

// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();

// Set output Encoding.

$id_idioma=7; 
$data->setOutputEncoding('UTF-8');

/*switch ($id_idioma) {

case 1:
$data->setOutputEncoding('windows-1251'); // Ruso
break;

case 2:
$data->setOutputEncoding('UTF-8'); // Rumano
break;

case 3:
$data->setOutputEncoding('windows-1256');  // Arabe windows-1256
break;

case 5:
$data->setOutputEncoding('windows-1251'); // Bulgaro
break;

case 6:
$data->setOutputEncoding('UTF-8'); // Polaco
break;

case 7:
$data->setOutputEncoding('UTF-8'); // Inglés
break;

case 8:
$data->setOutputEncoding('UTF-8'); // Frances
break;

case 9:
$data->setOutputEncoding('UTF-8'); // Catalan
break;
}*/

$dir_personal= "";
$nombre_archivo=basename(tempnam("temp",'tmp'));

$userfile_name="traduccion_ingles_con_definiciones.xls";
//$userfile_name="traduccion_portugues_con_definiciones.xls";
	
//  $userfile = $_FILES['userfile']['tmp_name']; /* NOMBRE QUE SE LE DA AL ARCHIVO EN LA CARPETA TEMPORAL */
//  $userfile_name = $_FILES['userfile']['name']; /* NOMBRE REAL DEL ARCHIVO */
//  $userfile_size = $_FILES['userfile']['size']; /* TAMAÑO DEL ARCHIVO EN BYTES */
//  $userfile_type = $_FILES['userfile']['type']; /* TIPO DE ARCHIVO */
//  $userfile_error = $_FILES['userfile']['error']; /* SI HAY ALGUN ERROR EN EL ENVIO */
//
///* SI SE HA PRODUCIDO ALGUN ERROR EN EL ENVIO DEL ARCHIVO EL VALOR DE LA VARIABLE SERÁ MAYOR DE 1 */	
//  if ($userfile_error > 0)
//  {
//    switch ($userfile_error) /* DIFERENCIO LOS MENSAJES A DEVOLVER AL USUARIO SEGUN EL TIPO DE ERROR ALMACENADO EN LA VARIABLE $USERFILE_ERROR */
//    {
//      case 1:  header ("Location: ../usuarios/equipos.php?mensaje=El archivo excede el tamaño maximo permitido");  break;
//      case 2:  header ("Location: ../usuarios/equipos.php?mensaje=El archivo excede el tamaño maximo permitido");  break;
//      case 3:  header ("Location: ../usuarios/equipos.php?mensaje=Archivo parcialmente almacenado");  break;
//      case 4:  header ("Location: ../usuarios/equipos.php?mensaje=No se ha seleccionado ningun archivo");  break;
//    }
//    exit;
//  }


/* DEL TIPO DE ARCHIVO ENVIADO DESDE EL FORMULARIO EXTRAIGO LAS DOS PARTES DE ESTE (image/jpeg)
EN LA PRIMERA SE ESTABLECE EL TIPO GENERAL DE ARCHIVO (TEXT, IMAGE, APLICATION, ETC.). EN LA SEGUNDA 
SE ESTABLECE LA EXTENSIÓN DEL ARCHIVO (JPG, BMP, GIF, etc.)  */
/* *********************************************************************************************** */
$tipo= explode (".", $userfile_name);

if ($tipo[1]=="xls"){

$upfile = $userfile_name; /* ESTABLEZCO LA RUTA COMPLETA DEL ARCHIVO JUNTO CON SU NOMBRE */
$data->read($upfile);

/*
 $data->sheets[0]['numRows'] - count rows
 $data->sheets[0]['numCols'] - count columns
 $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column

 $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
    
    $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
        if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
    $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format 
    $data->sheets[0]['cellsInfo'][$i][$j]['colspan'] 
    $data->sheets[0]['cellsInfo'][$i][$j]['rowspan'] 
*/

error_reporting(E_ALL ^ E_NOTICE);
 
for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { // NUMERO DE FILAS 

	if ($data->sheets[0]['cells'][$i][1] != "" && $data->sheets[0]['cells'][$i][2] != "") {
	  		//echo $data->sheets[0]['cells'][$i][1]."/".$data->sheets[0]['cells'][$i][3]."<br/>";
	  		$sql = $query->actualizar_definicion_traduccion($data->sheets[0]['cells'][$i][2],utf8_encode(utf8_encode($data->sheets[0]['cells'][$i][4])));
			//echo $data->sheets[0]['cells'][$i][1].'/'.utf8_encode(utf8_encode($data->sheets[0]['cells'][$i][4])).'<br />';
				
			//id_traduccion,definicion_traduccion
			
	} else {  $error1=true; echo $i.'/'.$data->sheets[0]['cells'][$i][2].'/'.$data->sheets[0]['cells'][$i][4].'<br />'; } // Cierro el IF de comprobación del array si está en blanco

}

$dir="temp/";

if ($error1==true) { $mensaje1="<br>Algunos de los registros estaban incompletos y han sido eliminados. Insértelos manualmente."; } 
if ($error2==true) { $mensaje2="<br>Algunos de los usuarios ya se encontraban registrados en su centro y no han sido añadidos."; } 

echo "Archivo importado".$mensaje1.$mensaje2;

} 
?>
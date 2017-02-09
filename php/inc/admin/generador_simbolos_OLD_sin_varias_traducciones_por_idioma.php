<?php 
include ('../../classes/querys/query.php');
require_once ('../../classes/img/Image_Toolbox.class.php');
include("../../classes/img/ImageEditor.php");
require('../../funciones/funciones.php');
include_once ("../../classes/querys/query.php");
include_once ("../../classes/framemaker/framemaker.php");
include_once('../../classes/utf8/utf8.class.php');
require_once ('../../classes/img/Image_Toolbox.class.php');
require "../../classes/text_image/class.atextimage.php";
require("../../classes/graficas/jpgraph/jpgraph.php");
require("../../classes/graficas/jpgraph/jpgraph_scatter.php");
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');
include("../../classes/text_image/fagd.php");

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$query=new query();

set_time_limit(9000); 

//echo 'Comenzando';

$id_tipo_simbolo=10;

/*$inicial=101;
$cantidad=50;*/

$inicial=0;
$cantidad=20;

$resultados=$query->listar_originales_limit_para_generador($inicial,$cantidad,$id_tipo_simbolo);

while ($row=mysql_fetch_array($resultados)) {

	$nombre_img='';
	$imagen_original='';
	$imagen_tratada='';
	$dir="../../";
	$dir_temp="../../temp/";
	$imagen_original="repositorio/originales/".$row['imagen'];
	$extension = strtolower(substr(strrchr($imagen_original, "."), 1));
	$id_imagen=$row['id_imagen'];

for ($idm=0;$idm<10;$idm++) {
	
	$id_palabra=$row['id_palabra'];
	
	switch ($idm) {
	
		case 0: //Sin idioma
		$con_idioma=0;
		$idioma_size_letter=0;
		$hay_traduccion=1;
		$pixels_lienzo=130;
		$contenido_traduccion='';
		$num_caracteres_traduccion =0;
		break;
		
		case 1: // Ruso
		$con_idioma=2;
		$traducciones_result=$query->buscar_traduccion($id_palabra,$idm);
		$hay_traduccion=mysql_num_rows($traducciones_result);
		$datos_traduccion=mysql_fetch_array($traducciones_result);
		$num_caracteres_traduccion = strlen($datos_traduccion['traduccion']);
		$contenido_traduccion=$datos_traduccion['traduccion'];
		$pixels_lienzo=130;
			
			if ($num_caracteres_traduccion > 1 && $num_caracteres_traduccion < 4) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 3 && $num_caracteres_traduccion < 6) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 5 && $num_caracteres_traduccion < 8) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 7 && $num_caracteres_traduccion < 10) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 9 && $num_caracteres_traduccion < 12) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 11 && $num_caracteres_traduccion < 14) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 13 && $num_caracteres_traduccion < 16) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 15 && $num_caracteres_traduccion < 18) {
				$idioma_size_letter=40;
			} elseif ($num_caracteres_traduccion > 17 && $num_caracteres_traduccion < 20) {
				$idioma_size_letter=38;
			} elseif ($num_caracteres_traduccion > 19 && $num_caracteres_traduccion < 22) {
				$idioma_size_letter=36;
			} elseif ($num_caracteres_traduccion > 21 && $num_caracteres_traduccion < 24) {
				$idioma_size_letter=34;
			} elseif ($num_caracteres_traduccion > 23 && $num_caracteres_traduccion < 26) {
				$idioma_size_letter=32;
			} elseif ($num_caracteres_traduccion > 25 && $num_caracteres_traduccion < 28) {
				$idioma_size_letter=30;
			} elseif ($num_caracteres_traduccion > 27 && $num_caracteres_traduccion < 30) {
				$idioma_size_letter=28;
			} elseif ($num_caracteres_traduccion > 29 && $num_caracteres_traduccion < 32) {
				$idioma_size_letter=26;
			} elseif ($num_caracteres_traduccion > 31 && $num_caracteres_traduccion < 34) {
				$idioma_size_letter=24;
			} elseif ($num_caracteres_traduccion > 33 && $num_caracteres_traduccion < 36) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 35 && $num_caracteres_traduccion < 38) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 37 && $num_caracteres_traduccion < 40) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 39 && $num_caracteres_traduccion < 42) {
				$idioma_size_letter=20;
			} elseif ($num_caracteres_traduccion > 41) {
				$idioma_size_letter=18;
			}
			
		break;
		
		case 2: //Rumano
		$con_idioma=2;
		$traducciones_result=$query->buscar_traduccion($id_palabra,$idm);
		$hay_traduccion=mysql_num_rows($traducciones_result);
		$datos_traduccion=mysql_fetch_array($traducciones_result);
		$num_caracteres_traduccion = strlen($datos_traduccion['traduccion']);
		$contenido_traduccion=$datos_traduccion['traduccion'];
		$pixels_lienzo=130;
		
			if ($num_caracteres_traduccion > 1 && $num_caracteres_traduccion < 4) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 3 && $num_caracteres_traduccion < 6) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 5 && $num_caracteres_traduccion < 8) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 7 && $num_caracteres_traduccion < 10) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 9 && $num_caracteres_traduccion < 12) {
				$idioma_size_letter=40;
			} elseif ($num_caracteres_traduccion > 11 && $num_caracteres_traduccion < 14) {
				$idioma_size_letter=38;
			} elseif ($num_caracteres_traduccion > 13 && $num_caracteres_traduccion < 16) {
				$idioma_size_letter=36;
			} elseif ($num_caracteres_traduccion > 15 && $num_caracteres_traduccion < 18) {
				$idioma_size_letter=34;
			} elseif ($num_caracteres_traduccion > 17 && $num_caracteres_traduccion < 20) {
				$idioma_size_letter=32;
			} elseif ($num_caracteres_traduccion > 19 && $num_caracteres_traduccion < 22) {
				$idioma_size_letter=30;
			} elseif ($num_caracteres_traduccion > 21 && $num_caracteres_traduccion < 24) {
				$idioma_size_letter=28;
			} elseif ($num_caracteres_traduccion > 23 && $num_caracteres_traduccion < 26) {
				$idioma_size_letter=26;
			} elseif ($num_caracteres_traduccion > 25 && $num_caracteres_traduccion < 28) {
				$idioma_size_letter=24;
			} elseif ($num_caracteres_traduccion > 27 && $num_caracteres_traduccion < 30) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 29 && $num_caracteres_traduccion < 32) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 31 && $num_caracteres_traduccion < 34) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 33 && $num_caracteres_traduccion < 36) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 35 && $num_caracteres_traduccion < 38) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 37 && $num_caracteres_traduccion < 40) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 39 && $num_caracteres_traduccion < 42) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 41) {
				$idioma_size_letter=18;
			}
		break;
		
		case 3: //Arabe
		$con_idioma=2;
		$traducciones_result=$query->buscar_traduccion($id_palabra,$idm);
		$hay_traduccion=mysql_num_rows($traducciones_result);
		$datos_traduccion=mysql_fetch_array($traducciones_result);
		$num_caracteres_traduccion = strlen($datos_traduccion['traduccion']);
		$contenido_traduccion=$datos_traduccion['traduccion'];
		$pixels_lienzo=150;	
		
			if ($num_caracteres_traduccion > 1 && $num_caracteres_traduccion < 4) {
				$idioma_size_letter=64;
			} elseif ($num_caracteres_traduccion > 3 && $num_caracteres_traduccion < 6) {
				$idioma_size_letter=64;
			} elseif ($num_caracteres_traduccion > 5 && $num_caracteres_traduccion < 8) {
				$idioma_size_letter=62;
			} elseif ($num_caracteres_traduccion > 7 && $num_caracteres_traduccion < 10) {
				$idioma_size_letter=62;
			} elseif ($num_caracteres_traduccion > 9 && $num_caracteres_traduccion < 12) {
				$idioma_size_letter=58;
			} elseif ($num_caracteres_traduccion > 11 && $num_caracteres_traduccion < 14) {
				$idioma_size_letter=54;
			} elseif ($num_caracteres_traduccion > 13 && $num_caracteres_traduccion < 16) {
				$idioma_size_letter=50;
			} elseif ($num_caracteres_traduccion > 15 && $num_caracteres_traduccion < 18) {
				$idioma_size_letter=46;
			} elseif ($num_caracteres_traduccion > 17 && $num_caracteres_traduccion < 20) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 19 && $num_caracteres_traduccion < 22) {
				$idioma_size_letter=38;
			} elseif ($num_caracteres_traduccion > 21 && $num_caracteres_traduccion < 24) {
				$idioma_size_letter=34;
			} elseif ($num_caracteres_traduccion > 23 && $num_caracteres_traduccion < 26) {
				$idioma_size_letter=30;
			} elseif ($num_caracteres_traduccion > 25 && $num_caracteres_traduccion < 28) {
				$idioma_size_letter=28;
			} elseif ($num_caracteres_traduccion > 27 && $num_caracteres_traduccion < 30) {
				$idioma_size_letter=26;
			} elseif ($num_caracteres_traduccion > 29 && $num_caracteres_traduccion < 32) {
				$idioma_size_letter=24;
			} elseif ($num_caracteres_traduccion > 31 && $num_caracteres_traduccion < 34) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 33 && $num_caracteres_traduccion < 36) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 35 && $num_caracteres_traduccion < 38) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 37 && $num_caracteres_traduccion < 40) {
				$idioma_size_letter=20;
			} elseif ($num_caracteres_traduccion > 39 && $num_caracteres_traduccion < 42) {
				$idioma_size_letter=20;
			} elseif ($num_caracteres_traduccion > 41) {
				$idioma_size_letter=18;
			}
		break;
		
		case 4: //Chino
		$con_idioma=2;
		$traducciones_result=$query->buscar_traduccion($id_palabra,$idm);
		$hay_traduccion=mysql_num_rows($traducciones_result);
		$datos_traduccion=mysql_fetch_array($traducciones_result);
		$num_caracteres_traduccion = strlen($datos_traduccion['traduccion']);
		$contenido_traduccion=$datos_traduccion['traduccion'];
		$pixels_lienzo=150;
		
		// 3 caracteres UTF-8 hacen 1 en escitura China
		
			if ($num_caracteres_traduccion > 0 && $num_caracteres_traduccion < 4) { // 1 Caracter
				$idioma_size_letter=50;
			} elseif ($num_caracteres_traduccion > 3 && $num_caracteres_traduccion < 7) { // 2 Caracteres
				$idioma_size_letter=50;
			} elseif ($num_caracteres_traduccion > 6 && $num_caracteres_traduccion < 10) { // 3 Caracteres
				$idioma_size_letter=50;
			} elseif ($num_caracteres_traduccion > 9 && $num_caracteres_traduccion < 13) { // 4
				$idioma_size_letter=50;
			} elseif ($num_caracteres_traduccion > 12 && $num_caracteres_traduccion < 16) { //5
				$idioma_size_letter=50;
			} elseif ($num_caracteres_traduccion > 15 && $num_caracteres_traduccion < 19) { //6
				$idioma_size_letter=50;
			} elseif ($num_caracteres_traduccion > 18 && $num_caracteres_traduccion < 22) { //7
				$idioma_size_letter=50;
			} elseif ($num_caracteres_traduccion > 21 && $num_caracteres_traduccion < 25) { //8
				$idioma_size_letter=50;
			} elseif ($num_caracteres_traduccion > 24 && $num_caracteres_traduccion < 28) { //9
				$idioma_size_letter=40;
			} elseif ($num_caracteres_traduccion > 27 && $num_caracteres_traduccion < 31) { //10
				$idioma_size_letter=36;
			} elseif ($num_caracteres_traduccion > 30 && $num_caracteres_traduccion < 34) { //11
				$idioma_size_letter=32;
			} elseif ($num_caracteres_traduccion > 33 && $num_caracteres_traduccion < 37) { //12
				$idioma_size_letter=30;
			} elseif ($num_caracteres_traduccion > 36 && $num_caracteres_traduccion < 40) { //13
				$idioma_size_letter=30;
			} elseif ($num_caracteres_traduccion > 39 && $num_caracteres_traduccion < 43) { //14
				$idioma_size_letter=26;
			} elseif ($num_caracteres_traduccion > 42 && $num_caracteres_traduccion < 46) { //15
				$idioma_size_letter=26;
			} elseif ($num_caracteres_traduccion > 45 && $num_caracteres_traduccion < 49) { //16
				$idioma_size_letter=26;
			} elseif ($num_caracteres_traduccion > 48 && $num_caracteres_traduccion < 52) {
				$idioma_size_letter=24;
			} elseif ($num_caracteres_traduccion > 51) {
				$idioma_size_letter=22;
			}
			
		break;
		
		case 5: //Bulgaro
		$con_idioma=2;
		$traducciones_result=$query->buscar_traduccion($id_palabra,$idm);
		$hay_traduccion=mysql_num_rows($traducciones_result);
		$datos_traduccion=mysql_fetch_array($traducciones_result);
		$num_caracteres_traduccion = strlen($datos_traduccion['traduccion']);
		$contenido_traduccion=$datos_traduccion['traduccion'];
		$pixels_lienzo=130;
		
			if ($num_caracteres_traduccion > 1 && $num_caracteres_traduccion < 4) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 3 && $num_caracteres_traduccion < 6) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 5 && $num_caracteres_traduccion < 8) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 7 && $num_caracteres_traduccion < 10) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 9 && $num_caracteres_traduccion < 12) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 11 && $num_caracteres_traduccion < 14) {
				$idioma_size_letter=48;
			} elseif ($num_caracteres_traduccion > 13 && $num_caracteres_traduccion < 16) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 15 && $num_caracteres_traduccion < 18) {
				$idioma_size_letter=40;
			} elseif ($num_caracteres_traduccion > 17 && $num_caracteres_traduccion < 20) {
				$idioma_size_letter=38;
			} elseif ($num_caracteres_traduccion > 19 && $num_caracteres_traduccion < 22) {
				$idioma_size_letter=36;
			} elseif ($num_caracteres_traduccion > 21 && $num_caracteres_traduccion < 24) {
				$idioma_size_letter=34;
			} elseif ($num_caracteres_traduccion > 23 && $num_caracteres_traduccion < 26) {
				$idioma_size_letter=32;
			} elseif ($num_caracteres_traduccion > 25 && $num_caracteres_traduccion < 28) {
				$idioma_size_letter=30;
			} elseif ($num_caracteres_traduccion > 27 && $num_caracteres_traduccion < 30) {
				$idioma_size_letter=28;
			} elseif ($num_caracteres_traduccion > 29 && $num_caracteres_traduccion < 32) {
				$idioma_size_letter=26;
			} elseif ($num_caracteres_traduccion > 31 && $num_caracteres_traduccion < 34) {
				$idioma_size_letter=24;
			} elseif ($num_caracteres_traduccion > 33 && $num_caracteres_traduccion < 36) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 35 && $num_caracteres_traduccion < 38) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 37 && $num_caracteres_traduccion < 40) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 39 && $num_caracteres_traduccion < 42) {
				$idioma_size_letter=20;
			} elseif ($num_caracteres_traduccion > 41) {
				$idioma_size_letter=18;
			}
			
		break;
		
		case 6: //Polaco
		$con_idioma=2;
		$traducciones_result=$query->buscar_traduccion($id_palabra,$idm);
		$hay_traduccion=mysql_num_rows($traducciones_result);
		$datos_traduccion=mysql_fetch_array($traducciones_result);
		$num_caracteres_traduccion = strlen($datos_traduccion['traduccion']);
		$contenido_traduccion=$datos_traduccion['traduccion'];
		$pixels_lienzo=130;
			
			if ($num_caracteres_traduccion > 1 && $num_caracteres_traduccion < 4) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 3 && $num_caracteres_traduccion < 6) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 5 && $num_caracteres_traduccion < 8) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 7 && $num_caracteres_traduccion < 10) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 9 && $num_caracteres_traduccion < 12) {
				$idioma_size_letter=40;
			} elseif ($num_caracteres_traduccion > 11 && $num_caracteres_traduccion < 14) {
				$idioma_size_letter=38;
			} elseif ($num_caracteres_traduccion > 13 && $num_caracteres_traduccion < 16) {
				$idioma_size_letter=36;
			} elseif ($num_caracteres_traduccion > 15 && $num_caracteres_traduccion < 18) {
				$idioma_size_letter=34;
			} elseif ($num_caracteres_traduccion > 17 && $num_caracteres_traduccion < 20) {
				$idioma_size_letter=32;
			} elseif ($num_caracteres_traduccion > 19 && $num_caracteres_traduccion < 22) {
				$idioma_size_letter=30;
			} elseif ($num_caracteres_traduccion > 21 && $num_caracteres_traduccion < 24) {
				$idioma_size_letter=28;
			} elseif ($num_caracteres_traduccion > 23 && $num_caracteres_traduccion < 26) {
				$idioma_size_letter=26;
			} elseif ($num_caracteres_traduccion > 25 && $num_caracteres_traduccion < 28) {
				$idioma_size_letter=24;
			} elseif ($num_caracteres_traduccion > 27 && $num_caracteres_traduccion < 30) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 29 && $num_caracteres_traduccion < 32) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 31 && $num_caracteres_traduccion < 34) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 33 && $num_caracteres_traduccion < 36) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 35 && $num_caracteres_traduccion < 38) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 37 && $num_caracteres_traduccion < 40) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 39 && $num_caracteres_traduccion < 42) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 41) {
				$idioma_size_letter=18;
			}
			
		break;
		
		case 7: //Inglés
		$con_idioma=2;
		$traducciones_result=$query->buscar_traduccion($id_palabra,$idm);
		$hay_traduccion=mysql_num_rows($traducciones_result);
		$datos_traduccion=mysql_fetch_array($traducciones_result);
		$num_caracteres_traduccion = strlen($datos_traduccion['traduccion']);
		$contenido_traduccion=$datos_traduccion['traduccion'];
		$pixels_lienzo=130;
		
			if ($num_caracteres_traduccion > 1 && $num_caracteres_traduccion < 4) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 3 && $num_caracteres_traduccion < 6) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 5 && $num_caracteres_traduccion < 8) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 7 && $num_caracteres_traduccion < 10) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 9 && $num_caracteres_traduccion < 12) {
				$idioma_size_letter=40;
			} elseif ($num_caracteres_traduccion > 11 && $num_caracteres_traduccion < 14) {
				$idioma_size_letter=38;
			} elseif ($num_caracteres_traduccion > 13 && $num_caracteres_traduccion < 16) {
				$idioma_size_letter=36;
			} elseif ($num_caracteres_traduccion > 15 && $num_caracteres_traduccion < 18) {
				$idioma_size_letter=34;
			} elseif ($num_caracteres_traduccion > 17 && $num_caracteres_traduccion < 20) {
				$idioma_size_letter=32;
			} elseif ($num_caracteres_traduccion > 19 && $num_caracteres_traduccion < 22) {
				$idioma_size_letter=30;
			} elseif ($num_caracteres_traduccion > 21 && $num_caracteres_traduccion < 24) {
				$idioma_size_letter=28;
			} elseif ($num_caracteres_traduccion > 23 && $num_caracteres_traduccion < 26) {
				$idioma_size_letter=26;
			} elseif ($num_caracteres_traduccion > 25 && $num_caracteres_traduccion < 28) {
				$idioma_size_letter=24;
			} elseif ($num_caracteres_traduccion > 27 && $num_caracteres_traduccion < 30) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 29 && $num_caracteres_traduccion < 32) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 31 && $num_caracteres_traduccion < 34) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 33 && $num_caracteres_traduccion < 36) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 35 && $num_caracteres_traduccion < 38) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 37 && $num_caracteres_traduccion < 40) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 39 && $num_caracteres_traduccion < 42) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 41) {
				$idioma_size_letter=18;
			}
			
		break;
		
		case 8: //Francés
		$con_idioma=2;
		$traducciones_result=$query->buscar_traduccion($id_palabra,$idm);
		$hay_traduccion=mysql_num_rows($traducciones_result);
		$datos_traduccion=mysql_fetch_array($traducciones_result);
		$num_caracteres_traduccion = strlen($datos_traduccion['traduccion']);
		$contenido_traduccion=$datos_traduccion['traduccion'];
		$pixels_lienzo=130;
		
			if ($num_caracteres_traduccion > 1 && $num_caracteres_traduccion < 4) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 3 && $num_caracteres_traduccion < 6) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 5 && $num_caracteres_traduccion < 8) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 7 && $num_caracteres_traduccion < 10) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 9 && $num_caracteres_traduccion < 12) {
				$idioma_size_letter=40;
			} elseif ($num_caracteres_traduccion > 11 && $num_caracteres_traduccion < 14) {
				$idioma_size_letter=38;
			} elseif ($num_caracteres_traduccion > 13 && $num_caracteres_traduccion < 16) {
				$idioma_size_letter=36;
			} elseif ($num_caracteres_traduccion > 15 && $num_caracteres_traduccion < 18) {
				$idioma_size_letter=34;
			} elseif ($num_caracteres_traduccion > 17 && $num_caracteres_traduccion < 20) {
				$idioma_size_letter=32;
			} elseif ($num_caracteres_traduccion > 19 && $num_caracteres_traduccion < 22) {
				$idioma_size_letter=30;
			} elseif ($num_caracteres_traduccion > 21 && $num_caracteres_traduccion < 24) {
				$idioma_size_letter=28;
			} elseif ($num_caracteres_traduccion > 23 && $num_caracteres_traduccion < 26) {
				$idioma_size_letter=26;
			} elseif ($num_caracteres_traduccion > 25 && $num_caracteres_traduccion < 28) {
				$idioma_size_letter=24;
			} elseif ($num_caracteres_traduccion > 27 && $num_caracteres_traduccion < 30) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 29 && $num_caracteres_traduccion < 32) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 31 && $num_caracteres_traduccion < 34) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 33 && $num_caracteres_traduccion < 36) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 35 && $num_caracteres_traduccion < 38) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 37 && $num_caracteres_traduccion < 40) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 39 && $num_caracteres_traduccion < 42) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 41) {
				$idioma_size_letter=18;
			}
			
		break;
		
		case 9: //Catalán
		$con_idioma=2;
		$traducciones_result=$query->buscar_traduccion($id_palabra,$idm);
		$hay_traduccion=mysql_num_rows($traducciones_result);
		$datos_traduccion=mysql_fetch_array($traducciones_result);
		$num_caracteres_traduccion = strlen($datos_traduccion['traduccion']);
		$contenido_traduccion=$datos_traduccion['traduccion'];
		$pixels_lienzo=130;
		
			if ($num_caracteres_traduccion > 1 && $num_caracteres_traduccion < 4) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 3 && $num_caracteres_traduccion < 6) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 5 && $num_caracteres_traduccion < 8) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 7 && $num_caracteres_traduccion < 10) {
				$idioma_size_letter=42;
			} elseif ($num_caracteres_traduccion > 9 && $num_caracteres_traduccion < 12) {
				$idioma_size_letter=40;
			} elseif ($num_caracteres_traduccion > 11 && $num_caracteres_traduccion < 14) {
				$idioma_size_letter=38;
			} elseif ($num_caracteres_traduccion > 13 && $num_caracteres_traduccion < 16) {
				$idioma_size_letter=36;
			} elseif ($num_caracteres_traduccion > 15 && $num_caracteres_traduccion < 18) {
				$idioma_size_letter=34;
			} elseif ($num_caracteres_traduccion > 17 && $num_caracteres_traduccion < 20) {
				$idioma_size_letter=32;
			} elseif ($num_caracteres_traduccion > 19 && $num_caracteres_traduccion < 22) {
				$idioma_size_letter=30;
			} elseif ($num_caracteres_traduccion > 21 && $num_caracteres_traduccion < 24) {
				$idioma_size_letter=28;
			} elseif ($num_caracteres_traduccion > 23 && $num_caracteres_traduccion < 26) {
				$idioma_size_letter=26;
			} elseif ($num_caracteres_traduccion > 25 && $num_caracteres_traduccion < 28) {
				$idioma_size_letter=24;
			} elseif ($num_caracteres_traduccion > 27 && $num_caracteres_traduccion < 30) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 29 && $num_caracteres_traduccion < 32) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 31 && $num_caracteres_traduccion < 34) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 33 && $num_caracteres_traduccion < 36) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 35 && $num_caracteres_traduccion < 38) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 37 && $num_caracteres_traduccion < 40) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 39 && $num_caracteres_traduccion < 42) {
				$idioma_size_letter=22;
			} elseif ($num_caracteres_traduccion > 41) {
				$idioma_size_letter=18;
			}
			
		break;	
	}
	
	$num_caracteres_castellano= strlen($row['palabra']);
	// Desde 1 hasta 13 caracteres tienen el mismo tamaño de letra
	if ($num_caracteres_castellano > 1 && $num_caracteres_castellano < 4) {
		$castellano_minuscula_size_letter=42;
		$castellano_mayuscula_size_letter=38;
	} elseif ($num_caracteres_castellano > 3 && $num_caracteres_castellano < 6) {
		$castellano_minuscula_size_letter=42;
		$castellano_mayuscula_size_letter=38;
	} elseif ($num_caracteres_castellano > 5 && $num_caracteres_castellano < 8) {
		$castellano_minuscula_size_letter=42;
		$castellano_mayuscula_size_letter=38;
	} elseif ($num_caracteres_castellano > 7 && $num_caracteres_castellano < 10) {
		$castellano_minuscula_size_letter=42;
		$castellano_mayuscula_size_letter=38;
	} elseif ($num_caracteres_castellano > 9 && $num_caracteres_castellano < 12) {
		$castellano_minuscula_size_letter=42;
		$castellano_mayuscula_size_letter=38;
	} elseif ($num_caracteres_castellano > 11 && $num_caracteres_castellano < 14) { // Ponerse Ropa = 12 
		$castellano_minuscula_size_letter=42;
		$castellano_mayuscula_size_letter=38;
	} elseif ($num_caracteres_castellano > 13 && $num_caracteres_castellano < 16) {
		$castellano_minuscula_size_letter=42;
		$castellano_mayuscula_size_letter=38;
	} elseif ($num_caracteres_castellano > 15 && $num_caracteres_castellano < 18) { // Postal de Navidad = 17
		$castellano_minuscula_size_letter=42;
		$castellano_mayuscula_size_letter=38;
	} elseif ($num_caracteres_castellano > 17 && $num_caracteres_castellano < 20) { // Utensilio de cocina = 19
		$castellano_minuscula_size_letter=42;
		$castellano_mayuscula_size_letter=36;
	} elseif ($num_caracteres_castellano > 19 && $num_caracteres_castellano < 22) {
		$castellano_minuscula_size_letter=34;
		$castellano_mayuscula_size_letter=32;
	} elseif ($num_caracteres_castellano > 21 && $num_caracteres_castellano < 24) {
		$castellano_minuscula_size_letter=32;
		$castellano_mayuscula_size_letter=30;
	} elseif ($num_caracteres_castellano > 23 && $num_caracteres_castellano < 26) { //BOLA DE NAVIDAD = 25 y con Caja de Destornilladores = 24
		$castellano_minuscula_size_letter=36;
		$castellano_mayuscula_size_letter=30;
	} elseif ($num_caracteres_castellano > 25 && $num_caracteres_castellano < 28) { //Ir de Excursion en Autobús = 26
		$castellano_minuscula_size_letter=32;
		$castellano_mayuscula_size_letter=30;
	} elseif ($num_caracteres_castellano > 27 && $num_caracteres_castellano < 29) { //Hamburguesa y Patatas Fritas = 28
		$castellano_minuscula_size_letter=28;
		$castellano_mayuscula_size_letter=24;
	} elseif ($num_caracteres_castellano > 29 && $num_caracteres_castellano < 32) { //Documento Nacional de Identidad = 31
		$castellano_minuscula_size_letter=26;
		$castellano_mayuscula_size_letter=22;
	} elseif ($num_caracteres_castellano > 31 && $num_caracteres_castellano < 34) {  //Monasterio de San Juan de la Pena = 33 y con Libros de Juegos, Deporte y Ocio = 32
		$castellano_minuscula_size_letter=26;
		$castellano_mayuscula_size_letter=24;
	} elseif ($num_caracteres_castellano > 33 && $num_caracteres_castellano < 36) {
		$castellano_minuscula_size_letter=22;
		$castellano_mayuscula_size_letter=20;
	} elseif ($num_caracteres_castellano > 35 && $num_caracteres_castellano < 38) {
		$castellano_minuscula_size_letter=22;
		$castellano_mayuscula_size_letter=20;
	}
	
	/* Si hay traducción para la palabra (en el caso de los idiomas) ejecuto las opciones sino ejecuto solo la de castellano (a la que he puesto 1 en $hay_traduccion) */
	if ($hay_traduccion > 0 && $contenido_traduccion != 'sin traduccion') { 	
	
	/* Si el idioma es 0 (castellano) no ejecuto las ultimas opciones (7 en adelante) porque son sólo para idiomas */
	if ($idm > 0) { $n_opciones=16; } else { $n_opciones=13; }
	
	for ($i=1;$i<$n_opciones;$i++) {
	
	$nombre_img=$num_caracteres_castellano.'_'.$num_caracteres_traduccion.'_'.$row['id_palabra'].'_'.basename(tempnam("../../temp/",'tmp')); 
	
		switch ($i) {
		
			case 1: //Simbolo normal con texto en castellano y minusculas abajo. Con Marco
				$accion="normal";
				$idioma=$idm;
				$castellano=$row['palabra'];
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='arial';
				$inf_font=1;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#000000";
				$color_inf="#000000";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_minuscula_size_letter; //tamaño letra inferior
				$marco=1;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=0;
				
				//Color de fondo del pictograma generado
				$colfnd="white";
	
			break;
			
			case 2: //Simbolo normal con texto en castellano y mayúsculas abajo. Con Marco		
				$accion="normal";
				$idioma=$idm;
				$castellano=$row['palabra'];
				
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='arial';
				
				$inf_font=1;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#000000";
				$color_inf="#000000";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_mayuscula_size_letter; //tamaño letra inferior
				$marco=1;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=1;
				
				//Color de fondo del pictograma generado
				$colfnd="white";
			break;
			
			case 3: //Simbolo normal con texto en castellano y minusculas abajo. SIN Marco		
				$accion="normal";
				$idioma=$idm;
				$castellano=$row['palabra'];
				
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='arial';
				
				$inf_font=1;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#000000";
				$color_inf="#000000";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_minuscula_size_letter; //tamaño letra inferior
				$marco=0;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=0;
				
				//Color de fondo del pictograma generado
				$colfnd="white";
			break;
			
			case 4: //Simbolo normal con texto en castellano y mayúsculas abajo. SIN Marco			
				$accion="normal";
				$idioma=$idm;
				$castellano=$row['palabra'];
				
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='arial';
				
				$inf_font=1;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#000000";
				$color_inf="#000000";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_mayuscula_size_letter; //tamaño letra inferior
				$marco=0;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=1;
				
				//Color de fondo del pictograma generado
				$colfnd="white";
			break;
			
			case 5: //Simbolo INVERTIDO con texto en castellano y minúsculas abajo. SIN Marco			
				$accion="invertir";
				$idioma=$idm;
				$castellano=$row['palabra'];
				
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='arial';
				
				$inf_font=1;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#FFFFFF";
				$color_inf="#FFFFFF";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_minuscula_size_letter; //tamaño letra inferior
				$marco=0;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=0;
				
				//Color de fondo del pictograma generado
				$colfnd="black";
			break;
			
			case 6: //Simbolo INVERTIDO con texto en castellano y mayúsculas abajo. SIN Marco			
				$accion="invertir";
				$idioma=$idm;
				$castellano=$row['palabra'];
				
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='arial';
				
				$inf_font=1;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#FFFFFF";
				$color_inf="#FFFFFF";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_mayuscula_size_letter; //tamaño letra inferior
				$marco=0;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=1;
				
				//Color de fondo del pictograma generado
				$colfnd="black";
			break;
			
			case 7: //Simbolo normal con texto en castellano y minusculas abajo. Con Marco
				$accion="normal";
				$idioma=$idm;
				$castellano=$row['palabra'];
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='edelfontmed';
				
				$inf_font=2;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#000000";
				$color_inf="#000000";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_minuscula_size_letter+6; //tamaño letra inferior
				$marco=1;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=0;
				
				//Color de fondo del pictograma generado
				$colfnd="white";
	
			break;
			
			case 8: //Simbolo normal con texto en castellano y mayúsculas abajo. Con Marco		
				$accion="normal";
				$idioma=$idm;
				$castellano=$row['palabra'];
				
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='edelfontmed';
				
				$inf_font=2;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#000000";
				$color_inf="#000000";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_mayuscula_size_letter+4; //tamaño letra inferior
				$marco=1;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=1;
				
				//Color de fondo del pictograma generado
				$colfnd="white";
			break;
			
			case 9: //Simbolo normal con texto en castellano y minusculas abajo. SIN Marco		
				$accion="normal";
				$idioma=$idm;
				$castellano=$row['palabra'];
				
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='edelfontmed';
				
				$inf_font=2;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#000000";
				$color_inf="#000000";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_minuscula_size_letter+6; //tamaño letra inferior
				$marco=0;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=0;
				
				//Color de fondo del pictograma generado
				$colfnd="white";
			break;
			
			case 10: //Simbolo normal con texto en castellano y mayúsculas abajo. SIN Marco			
				$accion="normal";
				$idioma=$idm;
				$castellano=$row['palabra'];
				
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='edelfontmed';
				
				$inf_font=2;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#000000";
				$color_inf="#000000";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_mayuscula_size_letter+6; //tamaño letra inferior
				$marco=0;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=1;
				
				//Color de fondo del pictograma generado
				$colfnd="white";
			break;
			
			case 11: //Simbolo INVERTIDO con texto en castellano y minúsculas abajo. SIN Marco			
				$accion="invertir";
				$idioma=$idm;
				$castellano=$row['palabra'];
				
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='edelfontmed';
				
				$inf_font=2;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#FFFFFF";
				$color_inf="#FFFFFF";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_minuscula_size_letter+6; //tamaño letra inferior
				$marco=0;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=0;
				
				//Color de fondo del pictograma generado
				$colfnd="black";
			break;
			
			case 12: //Simbolo INVERTIDO con texto en castellano y mayúsculas abajo. SIN Marco			
				$accion="invertir";
				$idioma=$idm;
				$castellano=$row['palabra'];
				
				$sup_idioma=$con_idioma;
				$inf_idioma=1;
				$fuente_castellano='edelfontmed';
				
				$inf_font=2;
				if ($idm==0) { $sup_font=0; } else { $sup_font=$query->buscar_fuente_idioma($idioma); }
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#FFFFFF";
				$color_inf="#FFFFFF";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$castellano_mayuscula_size_letter+4; //tamaño letra inferior
				$marco=0;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=1;
				
				//Color de fondo del pictograma generado
				$colfnd="black";
			break;
			
			case 13: //Simbolo normal con texto en castellano y minusculas abajo. Con Marco
				$accion="normal";
				$idioma=$idm;
				$castellano=$row['palabra'];
				$sup_idioma=0;
				$inf_idioma=2;
				$fuente_castellano='arial';
				
				$inf_font=$query->buscar_fuente_idioma($idioma);
				$sup_font=0;
				
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#000000";
				$color_inf="#000000";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$idioma_size_letter; //tamaño letra inferior
				$marco=1;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=0;
				
				//Color de fondo del pictograma generado
				$colfnd="white";
	
			break;
			
			case 14: //Simbolo normal con texto en castellano y minusculas abajo. Con Marco
				$accion="normal";
				$idioma=$idm;
				$castellano=$row['palabra'];
				$sup_idioma=0;
				$inf_idioma=2;
				$fuente_castellano='arial';
				$inf_font=$query->buscar_fuente_idioma($idioma);
				$sup_font=0;
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#000000";
				$color_inf="#000000";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$idioma_size_letter; //tamaño letra inferior
				$marco=0;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=0;
				
				//Color de fondo del pictograma generado
				$colfnd="white";
	
			break;
			
			case 15: //Simbolo INVERTIDO con texto en castellano y minúsculas abajo. SIN Marco			
				$accion="invertir";
				$idioma=$idm;
				$castellano=$row['palabra'];
				
				$sup_idioma=0;
				$inf_idioma=2;
				$fuente_castellano='arial';
				$inf_font=$query->buscar_fuente_idioma($idioma);
				$sup_font=0;
				//0-Sin idioma
				//1-Castellano
				//2-Idioma
				
				$color_sup="#FFFFFF";
				$color_inf="#FFFFFF";
				$sz=$idioma_size_letter; //tamaño letra superior
				$sz1=$idioma_size_letter; //tamaño letra inferior
				$marco=0;
				$pixels_borde=15;
				
				$sup_may=0;
				$inf_may=0;
				
				//Color de fondo del pictograma generado
				$colfnd="black";
			break;
			
			
			
		}

	/***************************************************/
	/*    CONFIGURACIÓN DEL BORDE DEL SÍMBOLO           */
	/***************************************************/
	
		$datos_palabra=$query->datos_palabra($row['id_palabra']);
		$id_tipo_palabra=$datos_palabra['id_tipo_palabra'];
		
		switch ($id_tipo_palabra) {
		
			case 1:
			$color_borde='#FFFF00';
			break;
		
			case 2:
			$color_borde='#FF9900';
			break;
			
			case 3:
			$color_borde='#33CC00';
			break;
			
			case 4:
			$color_borde='#3366FF';
			break;
			
			case 5:
			$color_borde='#FF66CC';
			break;
			
			case 6:
			$color_borde='#FFFFFF';
			break;
			
			default:
			$color_borde='#000000';
			break;
		
		}
		
	/***************************************************/
	
	/***************************************************/
	/*    RECUPERO TAMAÑO IMAGEN			           */
	/***************************************************/
	
	switch ($extension) {
	
		case "gif":
		$source = imagecreatefromgif($dir.$imagen_original); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
		$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
		$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
		
		if ($imageX < 500) { $imageX =500; }
		if ($imageY < 500) { $imageY =500; }
		
		break;
		
		case "png":
		$source = imagecreatefrompng($dir.$imagen_original); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
		$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
		$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
		
		if ($imageX < 500) { $imageX =500; }
		if ($imageY < 500) { $imageY =500; }
		
		break;
		
		case "jpg":
		$source = imagecreatefromjpeg($dir.$imagen_original); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
		$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
		$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
		
		if ($imageX < 500) { $imageX =500; }
		if ($imageY < 500) { $imageY =500; }
		break;
	
	}
	/**************************************************************************************************************************************/
	/******************COMPRUEBO SI EL SIMBOLO YA EXISTE EN LA TABLA DE SIMBOLOS DEFINITIVOS O TEMPORALES **********************************/
	/**************************************************************************************************************************************/
	switch ($accion) {
		case 'invertir':
		$contraste=2;
		break;
		
		case 'normal':
		$contraste=1;
		break;
		
		case 'alto_contraste':
		$contraste=3;
		break;
	
	}
	
	if ($sup_idioma > 0) { $sup_con_texto=1; } else { $sup_con_texto=0; }
	if ($inf_idioma > 0) { $inf_con_texto=1; } else { $inf_con_texto=0; }
	
	if ($sup_idioma == 1) { $superior_idioma=0; } elseif ($sup_idioma == 2)  { $superior_idioma=$idioma; } else {  $superior_idioma=99; }
	if ($inf_idioma == 1) { $inferior_idioma=0; } elseif ($inf_idioma == 2)  { $inferior_idioma=$idioma; } else {  $inferior_idioma=99; }
	
	$sup_mayusculas=$sup_may;
	$inf_mayusculas=$inf_may;
	
	$sup_font_size=$sz;
	$sup_font_color=$color_sup;
	$inf_font_size=$sz1;
	$inf_font_color=$color_inf;
	
	$existe_tmp=$query->buscar_si_existe_simbolo_tmp($id_palabra,$id_tipo_simbolo,$marco,$contraste,$sup_con_texto,$superior_idioma,$sup_mayusculas,$sup_font,$inf_con_texto,$inferior_idioma,$inf_mayusculas,$inf_font,$id_imagen);
	
	$existe_final=$query->buscar_si_existe_simbolo_final($id_palabra,$id_tipo_simbolo,$marco,$contraste,$sup_con_texto,$superior_idioma,$sup_mayusculas,$sup_font,$inf_con_texto,$inferior_idioma,$inf_mayusculas,$inf_font,$id_imagen);
	
	//echo $existe_tmp.'/'.$existe_final;

	$carpeta_destino=$id_tipo_simbolo.$marco.$contraste.$sup_con_texto.$superior_idioma.$sup_mayusculas.$sup_font.$inf_con_texto.$inferior_idioma.$inf_mayusculas.$inf_font;
	
	/******************SI EL SIMBOLO NO EXISTE EN LA TABLA TEMPORAL O EN LA DEFINITIVA LO CREO **********************************/
	/**************************************************************************************************************************************/
	if ($existe_tmp==0 && $existe_final==0) { 
	/***************************************************/
	switch ($accion) {
		
		case 'invertir':
		invert_image($dir.$imagen_original,'../../temp/'.$nombre_img.'.'.$extension,true,$extension);
		$imagen_tratada=$nombre_img.'.'.$extension;
		break;
		
		
		case 'alto_contraste':
		
		$color_contraste=substr($_POST['color_contraste'], 1);
		
		if ($extension=='jpg') {
			alto_contraste_jpg($dir.$imagen_original,'../../temp/'.$nombre_img.'.'.$extension,$color_contraste,$extension);
		} elseif ($extension=='png') {
			alto_contraste_png($dir.$imagen_original,'../../temp/'.$nombre_img.'.'.$extension,$color_contraste,$extension);
		} elseif ($extension=='gif') {
			alto_contraste_png($dir.$imagen_original,'../../temp/'.$nombre_img.'.'.$extension,$color_contraste,$extension);
		}
		
		$imagen_tratada=$nombre_img.'.'.$extension;
		break;
			
		case 'normal':
		copy($dir.$imagen_original,'../../temp/'.$nombre_img.'.'.$extension);
		$imagen_tratada=$nombre_img.'.'.$extension;
		break;
		
		case 'tratada':
		copy($dir.$imagen_original,'../../temp/'.$nombre_img.'.'.$extension);
		$imagen_tratada=$nombre_img.'.'.$extension;
		break;
	}
	
	
	/***************************************************/
	/*    AMPLIAR EL LIENZO SI ES NECESARIO           */
	/***************************************************/
	
	if ($pixels_lienzo > 0) {
		//DEFINE('SIMBOLO',$dir_temp.$imagen_tratada);
		$pixels=$pixels_lienzo;
		$graph = new Graph($imageX+$pixels,$imageY+$pixels);
		$graph->SetFrame(false);
		$graph->img->SetMargin(0,0,0,0);
		$graph->SetMarginColor($colfnd);
		$graph->SetColor($colfnd);
		$graph->SetScale('linlin',0,100,0,100);
		// We don't want any axis to be shown
		$graph->xaxis->Hide();
		$graph->yaxis->Hide();
		$graph->SetBackgroundImage($dir_temp.$imagen_tratada,BGIMG_CENTER);
		$graph->Stroke($dir_temp.$imagen_tratada);
		
		switch ($extension) {
	
			case "gif":
			$img = new Image_Toolbox($dir_temp.$imagen_tratada);
			$img->save($dir_temp.$imagen_tratada, 'gif', '100'); 
			break;
			
			case "png":
			$img = new Image_Toolbox($dir_temp.$imagen_tratada);
			$img->save($dir_temp.$imagen_tratada, 'png', '100'); 
			break;
			
			case "jpg":
			$img = new Image_Toolbox($dir_temp.$imagen_tratada);
			$img->save($dir_temp.$imagen_tratada, 'jpg', '100'); 
			break;
	
		}
	}
	/***************************************************/
	
	
	/***************************************************/
	/*    CODIFICACION DIFERENTES IDIOMAS           */
	/***************************************************/
	
	define("MAP_DIR","../../classes/utf8/MAPPING");
	define("CP1250",MAP_DIR . "/CP1250.MAP");
	define("CP1251",MAP_DIR . "/CP1251.MAP");
	define("CP1252",MAP_DIR . "/CP1252.MAP");
	define("CP1253",MAP_DIR . "/CP1253.MAP");
	define("CP1254",MAP_DIR . "/CP1254.MAP");
	define("CP1255",MAP_DIR . "/CP1255.MAP");
	define("CP1256",MAP_DIR . "/CP1256.MAP");
	define("CP1257",MAP_DIR . "/CP1257.MAP");
	define("CP1258",MAP_DIR . "/CP1258.MAP");
	define("CP874", MAP_DIR . "/CP874.MAP");
	define("CP932", MAP_DIR . "/CP932.MAP");
	define("CP936", MAP_DIR . "/CP936.MAP");
	define("CP949", MAP_DIR . "/CP949.MAP");
	define("CP950", MAP_DIR . "/CP950.MAP");
	define("GB2312", MAP_DIR . "/GB2312.MAP");
	define("BIG5", MAP_DIR . "/BIG5.MAP");
	
	
	$utfConverter = new utf8(CP1251); //defaults to CP1250.
	$utfConverter->loadCharset(CP1256);
	
	$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
	$utfConverter_ru->loadCharset(CP1251);
	
	$result=$query->buscar_traduccion($id_palabra,$idioma);
	$d_palabra=mysql_fetch_array($result);
	
	$res_ar = $utfConverter->strToUtf8($d_palabra['traduccion']);
	$res_ru = $utfConverter_ru->strToUtf8($d_palabra['traduccion']);
	$res_bulg = $utfConverter_ru->strToUtf8($d_palabra['traduccion']);
	
	
	$img=$imagen_tratada;
	$basead="../../temp/";
	
	switch ($d_palabra['idioma']) {
	
		case 'Chino':
		$lang_ext_minusc=$d_palabra['traduccion']; 
		$lang_ext_mayusc=$d_palabra['traduccion'];
		$font_ext="../../fonts/Cyberbit.ttf";	
		break;
		
		case 'Rumano':
		$lang_ext_mayusc=strtoupper($d_palabra['traduccion']);
		$lang_ext_minusc=$d_palabra['traduccion']; 
		$font_ext="../../plugins/html2ps/fonts/arial.ttf";
		break;
		
		case 'Polaco':
		$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
		$lang_ext_minusc=$d_palabra['traduccion'];
		$font_ext="../../plugins/html2ps/fonts/arial.ttf";
		break;
		
		case 'Ruso':
		$lang_ext_mayusc=strtoupper($res_ru);
		$lang_ext_minusc=$res_ru; 
		$font_ext="../../plugins/html2ps/fonts/times.ttf";
		break;
		
		case 'Bulgaro':
		$lang_ext_mayusc=strtoupper($res_bulg);
		$lang_ext_minusc=$res_bulg; 
		$font_ext="../../plugins/html2ps/fonts/times.ttf";
		break;
		
		case 'Arabe':
		$lang_ext_mayusc=fagd($res_ar,'','normal');
		$lang_ext_minusc=fagd($res_ar,'','normal'); 
		$font_ext= "../../plugins/html2ps/fonts/FreeFarsi.ttf";
		
		break;
		
		case 'Ingles':
		$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
		$lang_ext_minusc=$d_palabra['traduccion']; 
		$font_ext="../../plugins/html2ps/fonts/arial.ttf";
		break;
		
		case 'Frances':
		$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
		$lang_ext_minusc=$d_palabra['traduccion']; 
		$font_ext="../../plugins/html2ps/fonts/arial.ttf";
		break;
		
		case 'Catalan':
		$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
		$lang_ext_minusc=$d_palabra['traduccion']; 
		$font_ext="../../plugins/html2ps/fonts/arial.ttf";
		break;
		
		case 99:
		$lang_ext="";
		$font_ext="../../plugins/html2ps/fonts/arial.ttf";
		break;
		
		default:
		$lang_ext="";
		$font_ext="../../plugins/html2ps/fonts/arial.ttf";
		break;
	
	
	}
	
	$castellano_mayusc=strtoupper_utf8($castellano); 
	$castellano_minusc=$castellano; 
	
	$orden=$sup_idioma.$inf_idioma;
	
	switch ($orden) {
	
		case 12:
		$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
		$fnt2=$font_ext;
		if ($sup_may==1) { $texto1=$castellano_mayusc; } else { $texto1=$castellano_minusc; }
		if ($inf_may==1) { $texto2=$lang_ext_mayusc; } else { $texto2=$lang_ext_minusc; }
		
		break;
		
		case 21:
		$fnt1=$font_ext;
		$fnt2="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
		if ($sup_may==1) { $texto1=$lang_ext_mayusc; } else { $texto1=$lang_ext_minusc; }
		if ($inf_may==1) { $texto2=$castellano_mayusc; } else { $texto2=$castellano_minusc; }
		
		break;
		
		case 10:
		$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
		$fnt2="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
		if ($sup_may==1) { $texto1=$castellano_mayusc; } else { $texto1=$castellano_minusc; }
		$texto2="";
		break;
		
		case 01:
		$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
		$fnt2="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
		$texto1="";
		if ($inf_may==1) { $texto2=$castellano_mayusc; } else { $texto2=$castellano_minusc; }
		break;
		
		case 02:
		$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
		$texto1="";
		if ($inf_may==1) { $texto2=$lang_ext_mayusc; } else { $texto2=$lang_ext_minusc; }
		$fnt2=$font_ext;
		break;
		
		case 20:
		$fnt1=$font_ext;
		if ($sup_may==1) { $texto1=$lang_ext_mayusc; } else { $texto1=$lang_ext_minusc; }
		$texto2="";
		$fnt2="../../plugins/html2ps/fonts".$fuente_castellano.".ttf";
		break;
		
		case 0:
		$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
		$texto1="";
		$texto2="";
		$fnt2="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
		break;
		
		default:
		$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
		$texto1="";
		$texto2="";
		$fnt2="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
		break;
	}
	
	$timg = new ATextImage();
	$timg->SetBackground($c1,$c2,$c3);
	$timg->CreateImage($dir_temp.$imagen_tratada);
	
	
	$di=$_REQUEST['di'];
	$fm=$extension; // Extension de salida
	$si="yes";       //save image to atest.png?
	$wd=500;       //width of blank image
	$ht=500;       //height of blank image
	
	$just="center";
	$horz="center";
	$vert="top";
	$hex1=substr($color_sup, 1);
	$color1=hex2rgb($hex1);
	
	$timg->SetFont($fnt1,$sz);
	$timg->SetTextColor($color1[0], $color1[1], $color1[2]);
	$timg->SetPos("center","top","center"); 
	
	$txt=stripslashes($texto1);
	$tx=explode("\n",$txt);
	
	 foreach($tx as $t)
	 {
		$timg->AddLine($t);
	 }
	 
	$timg->MakeImage($wd,$ht);
	
	$hex2=substr($color_inf, 1);
	$color2=hex2rgb($hex2);
	
	$timg->SetFont($fnt2,$sz1);
	$timg->SetTextColor($color2[0], $color2[1], $color2[2]);
	//if($border=="1") { $timg->SetBorder(0,0,0); }
			
	$timg->SetPos("center","bottom","center");       
	$timg->AddLine($texto2,TRUE);
	$timg->MakeImage($wd,$ht);
	
	
	if($fm == "png"){
	
		$timg->ShowPng('../../temp/'.$nombre_img.'.png',$di);
		
		if ($marco == 1) {
			$frame = new FrameMaker();
			$frame->set_picture('../../temp/'.$nombre_img.'.png');
			$frame->set_border($pixels_borde,$color_borde,"solid");
			$frame->set_path('../../temp/'.$nombre_img.'.png');
			$frame->show_picture();
			$img = new Image_Toolbox('../../temp/'.$nombre_img.'.png');
			$img->save('../../temp/'.$nombre_img.'.png', 'png', '100'); 
		}
		
	}
	
	
	if($fm == "jpg"){
		$timg->ShowJpg('../../temp/'.$nombre_img.'.jpg',$di);
	
		if ($marco == 1) {
			$frame = new FrameMaker();
			$frame->set_picture('../../temp/'.$nombre_img.'.jpg');
			$frame->set_border($pixels_borde,$color_borde,"solid");
			$frame->set_path('../../temp/'.$nombre_img.'.jpg');
			$frame->show_picture();
		}
		
	}
	
	
	if($fm == "gif"){
		$timg->ShowGif('../../temp/'.$nombre_img.'.gif',$di);
		
			if ($marco == 1) {
				$frame = new FrameMaker();
				$frame->set_picture('../../temp/'.$nombre_img.'.gif');
				$frame->set_border($pixels_borde,$color_borde,"solid");
				$frame->set_path('../../temp/'.$nombre_img.'.gif');
				$frame->show_picture();
			}
		
	
	}
	
	
	if (!is_dir('../../repositorio/simbolos/pendientes/'.$carpeta_destino.'/')) {
	   mkdir('../../repositorio/simbolos/pendientes/'.$carpeta_destino.'/', 0777);
	} 
	
	copy($dir_temp.$imagen_tratada,'../../repositorio/simbolos/pendientes/'.$carpeta_destino.'/'.$imagen_tratada);
	unlink($dir_temp.$imagen_tratada);
	
	$simbolo_tmp=$query->grabar_simbolo_tmp($id_palabra,$id_tipo_simbolo,$marco,$contraste,$sup_con_texto,$superior_idioma,$sup_mayusculas,$sup_font,$inf_con_texto,$inferior_idioma,$inf_mayusculas,$inf_font,$imagen_tratada,$sup_font_size,$sup_font_color,$inf_font_size,$inf_font_color,$id_imagen);
	
	//   INSERTO EL SIMBOLO TEMPORAL DIRECTAMENTE EN LA CARPETA DEFINITIVA
	//*********************************************************************
	$validacion=$query->validar_simbolos_temporales($simbolo_tmp,1);
	
	//***********************************************************
		} // Cierro el IF que comprueba si el el simbolo ya existe en la tabla tenmporal o final
	
		//***********************************************************
		} // Cierro el For que crea todos los tipos de símbolos

	//***********************************************************
	} // Cierro el IF que comprueba si hay traduccuiones
//***********************************************************
} // Cierro el For que recorre todos los idiomas
		
//***********************************************************
} // Cierro el IF del Bucle que recorre los pictogramas

//echo 'Finalizado';
?>
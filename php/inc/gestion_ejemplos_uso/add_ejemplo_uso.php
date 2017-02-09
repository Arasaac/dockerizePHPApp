<?php 
session_start();
 
include ('../../classes/querys/query.php');

$query=new query();

if ($_POST['titulo'] != "") { 
$id_usuario=$_SESSION['ID_USER'];

$titulo=$_POST['titulo'];
$descripcion=$_POST['descripcion'];
$estado=$_POST['estado'];

if ($_POST['destacado']=='true') { $destacado=1; } elseif ($_POST['destacado']=='false') { $destacado=0; }

$archivos=$_POST['PickArchivos'];
$capturas=$_POST['PickCapturas'];
$autores=$_POST['PickAutores'];
$tipo=$_POST['PickTipo'];
$idiomas=$_POST['PickIdiomas'];
$url1=$_POST['url1'];
$url2=$_POST['url2'];
$url3=$_POST['url3'];

$add_ficha_eu=$query->add_new_ficha_eu($titulo,$descripcion,$estado,$destacado,$archivos,$capturas,$autores,$tipo,$idiomas,$url1,$url2,$url3);

echo $add_ficha_eu;

mkdir ('../../zona_descargas/ejemplos_uso/'.$add_ficha_eu.'/',0775);
mkdir ('../../zona_descargas/ejemplos_uso/'.$add_ficha_eu.'/screenshot/',0775);
  
  $files=str_replace('}{',',',$archivos);
  $files=str_replace('{','',$files);
  $files=str_replace('}','',$files);
  $files=explode(',',$files);
  
  for ($i=0;$i<count($files);$i++) { 
  	if ($files[$i]!='') {
 	  copy ('../../zona_descargas/ejemplos_uso/temp/'.$files[$i].'','../../zona_descargas/ejemplos_uso/'.$add_ficha_eu.'/'.$files[$i].'');
	  unlink ('../../zona_descargas/ejemplos_uso/temp/'.$files[$i].'');
	}
  }
  
  $captions=str_replace('}{',',',$capturas);
  $captions=str_replace('{','',$captions);
  $captions=str_replace('}','',$captions);
  $captions=explode(',',$captions);
  
  for ($i=0;$i<count($captions);$i++) { 
  	if ($captions[$i]!='') {
 	  copy ('../../zona_descargas/ejemplos_uso/temp/'.$captions[$i].'','../../zona_descargas/ejemplos_uso/'.$add_ficha_eu.'/screenshot/'.$captions[$i].'');
	  unlink ('../../zona_descargas/ejemplos_uso/temp/'.$captions[$i].'');
	}
  }

}


?>
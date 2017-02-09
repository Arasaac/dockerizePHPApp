<?php 
session_start();
 
include ('../../classes/querys/query.php');

$query=new query();

if ($_POST['titulo'] != "") { 
$id_usuario=$_SESSION['ID_USER'];

$titulo=$_POST['titulo'];
$descripcion=$_POST['descripcion'];
$objetivo=$_POST['objetivo'];
$informacion_adicional=$_POST['informacion_adicional'];
$estado=$_POST['estado'];
if ($_POST['destacado']=='true') { $destacado=1; } elseif ($_POST['destacado']=='false') { $destacado=0; }
$archivos=$_POST['PickArchivos'];
$capturas=$_POST['PickCapturas'];
$autores=$_POST['PickAutores'];
$tipo=$_POST['PickTipo'];
$so=$_POST['Pickso'];
$id_licencia=$_POST['id_licencia'];
$idiomas=$_POST['PickIdiomas'];
$url1=$_POST['url1'];
$url2=$_POST['url2'];
$url3=$_POST['url3'];
$precio=$_POST['precio'];

$add_ficha_software=$query->add_new_ficha_software($titulo,$descripcion,$objetivo,$informacion_adicional,$estado,$destacado,$archivos,$capturas,$autores,$tipo,$so,$id_licencia,$idiomas,$url1,$url2,$url3,$precio);

echo $add_ficha_software;

mkdir ('../../zona_descargas/software/'.$add_ficha_software.'/',0775);
mkdir ('../../zona_descargas/software/'.$add_ficha_software.'/screenshot/',0775);
  
  $files=str_replace('}{',',',$archivos);
  $files=str_replace('{','',$files);
  $files=str_replace('}','',$files);
  $files=explode(',',$files);
  
  for ($i=0;$i<count($files);$i++) { 
  	if ($files[$i]!='') {
 	  copy ('../../zona_descargas/software/temp/'.$files[$i].'','../../zona_descargas/software/'.$add_ficha_software.'/'.$files[$i].'');
	  unlink ('../../zona_descargas/software/temp/'.$files[$i].'');
	}
  }
  
  $captions=str_replace('}{',',',$capturas);
  $captions=str_replace('{','',$captions);
  $captions=str_replace('}','',$captions);
  $captions=explode(',',$captions);
  
  for ($i=0;$i<count($captions);$i++) { 
  	if ($captions[$i]!='') {
 	  copy ('../../zona_descargas/software/temp/'.$captions[$i].'','../../zona_descargas/software/'.$add_ficha_software.'/screenshot/'.$captions[$i].'');
	  unlink ('../../zona_descargas/software/temp/'.$captions[$i].'');
	}
  }

}


?>
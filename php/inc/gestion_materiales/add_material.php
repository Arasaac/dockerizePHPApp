<?php 
session_start();
 
include ('../../classes/querys/query.php');

$query=new query();

if ($_POST['titulo'] != "" && $_POST['descripcion'] != "") { 

$titulo=utf8_decode($_POST['titulo']);
$descripcion=utf8_decode($_POST['descripcion']);
$id_usuario=$_SESSION['ID_USER'];
$estado=$_POST['estado'];
$objetivos=utf8_decode($_POST['objetivos']);
$archivos=$_POST['PickArchivos'];

$autores=$_POST['PickAutores'];
$ac=$_POST['PickAC'];
$subac=$_POST['PickSUBAC'];
$dirigido=$_POST['Pickdirigido'];
$edad=$_POST['Pickedad'];
$nivel=$_POST['PickNivel'];
$saa=$_POST['PickSAA'];
$tipo=$_POST['PickTipo'];
$id_licencia=$_POST['id_licencia'];
$idiomas=$_POST['PickIdiomas'];

$add_material=$query->add_new_material($titulo,$descripcion,$objetivos,$estado,$autores,$ac,$dirigido,$edad,$nivel,$saa,$tipo,$archivos,$id_licencia,$subac,$idiomas);

mkdir ('../../zona_descargas/materiales/'.$add_material.'/',0775);

  $files=str_replace('}{',',',$archivos);
  $files=str_replace('{','',$files);
  $files=str_replace('}','',$files);
  $files=explode(',',$files);
  
  for ($i=0;$i<count($files);$i++) { 
  	if ($files[$i]!='') {
 	  copy ('../../zona_descargas/materiales/temp/'.$files[$i].'','../../zona_descargas/materiales/'.$add_material.'/'.$files[$i].'');
	  unlink ('../../zona_descargas/materiales/temp/'.$files[$i].'');
	}
  }

}


?>
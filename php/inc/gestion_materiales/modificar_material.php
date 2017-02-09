<?php 
session_start();

function inArray($array, $key)
{
  if(func_num_args() == 2 && is_string($key))
    return in_array($key, $array);
  else if(func_num_args() == 2 && is_array($key))
  {
    $r = true;
    for($i=0; $i < count($key); $i++)
      $r = (!in_array($key[$i], $array)) ? false : $r;
    
    return $r;
  }
  else if(func_num_args > 2)
  {
    $args = func_get_args();
    $r = true;
    for($i=1; $i < count($args); $i++)
      $r = (!in_array($args[$i], $array)) ? false : $r;
    
    return $r;
  }
}

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
$id_material=$_POST['id_material'];
$idiomas=$_POST['PickIdiomas'];

//Esta consulta hay que ponerla antes de actualizar la tabla
//IMPORTANTE
$row=$query->datos_material($id_material);
$ma=str_replace('}{',',',$row['material_archivos']);
$ma=str_replace('{','',$ma);
$ma=str_replace('}','',$ma);
$ma=explode(',',$ma);

//Actualizo la tabla
$add_material=$query->modificar_material($id_material,$titulo,$descripcion,$objetivos,$estado,$autores,$ac,$dirigido,$edad,$nivel,$saa,$tipo,$archivos,$id_licencia,$subac,$idiomas);

$files=str_replace('}{',',',$archivos);
$files=str_replace('{','',$files);
$files=str_replace('}','',$files);
$files=explode(',',$files);

  //BORRO los archivos que ya no están en la lista de archivos seleccionados
   for ($i=0;$i<count($ma);$i++) { 
  	if ($ma[$i]!='') {
  		if (!inArray($files,$ma[$i])) {
	  	  unlink ('../../zona_descargas/materiales/'.$id_material.'/'.$ma[$i].'');	
  		}
	  }
    }
  // AÑADO LOS NUEVOS archivos
  for ($i=0;$i<count($files);$i++) { 
  	if ($files[$i]!='') {
  		if (!inArray($ma,$files[$i])) {
  		  copy ('../../zona_descargas/materiales/temp/'.$files[$i].'','../../zona_descargas/materiales/'.$id_material.'/'.$files[$i].'');
	  	  unlink ('../../zona_descargas/materiales/temp/'.$files[$i].'');	
		  
  		}

	}
  }
}


?>
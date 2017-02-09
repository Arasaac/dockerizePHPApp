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
$id_eu=$_POST['id_eu'];

//Esta consulta hay que ponerla antes de actualizar la tabla
//IMPORTANTE
$row=$query->datos_ficha_eu($id_eu);
$ma=str_replace('}{',',',$row['eu_archivos']);
$ma=str_replace('{','',$ma);
$ma=str_replace('}','',$ma);
$ma=explode(',',$ma);

//Esta consulta hay que ponerla antes de actualizar la tabla
//IMPORTANTE
$ca=str_replace('}{',',',$row['eu_capturas']);
$ca=str_replace('{','',$ca);
$ca=str_replace('}','',$ca);
$ca=explode(',',$ca);

//Actualizo la tabla
$modificar_ficha=$query->modificar_eu($id_eu,$titulo,$descripcion,$estado,$destacado,$archivos,$capturas,$autores,$tipo,$idiomas,$url1,$url2,$url3);

$files=str_replace('}{',',',$archivos);
$files=str_replace('{','',$files);
$files=str_replace('}','',$files);
$files=explode(',',$files);

  //BORRO los archivos que ya no están en la lista de archivos seleccionados
   for ($i=0;$i<count($ma);$i++) { 
  	if ($ma[$i]!='') {
  		if (!inArray($files,$ma[$i])) {
	  	  unlink ('../../zona_descargas/ejemplos_uso/'.$id_eu.'/'.$ma[$i].'');	
  		}
	  }
    }
  // AÑADO LOS NUEVOS archivos
  for ($i=0;$i<count($files);$i++) { 
  	if ($files[$i]!='') {
  		if (!inArray($ma,$files[$i])) {
  		  copy ('../../zona_descargas/ejemplos_uso/temp/'.$files[$i].'','../../zona_descargas/ejemplos_uso/'.$id_eu.'/'.$files[$i].'');
	  	  unlink ('../../zona_descargas/ejemplos_uso/temp/'.$files[$i].'');	
		  
  		}

	}
  }
  
$captions=str_replace('}{',',',$capturas);
$captions=str_replace('{','',$captions);
$captions=str_replace('}','',$captions);
$captions=explode(',',$captions);

  //BORRO los archivos que ya no están en la lista de archivos seleccionados
   for ($i=0;$i<count($ca);$i++) { 
  	if ($ca[$i]!='') {
  		if (!inArray($captions,$ca[$i])) {
	  	  unlink ('../../zona_descargas/ejemplos_uso/'.$id_eu.'/screenshot/'.$ca[$i].'');	
  		}
	  }
    }
  // AÑADO LOS NUEVOS archivos
  for ($i=0;$i<count($captions);$i++) { 
  	if ($captions[$i]!='') {
  		if (!inArray($ca,$captions[$i])) {
  		  copy ('../../zona_descargas/ejemplos_uso/temp/'.$captions[$i].'','../../zona_descargas/ejemplos_uso/'.$id_eu.'/screenshot/'.$captions[$i].'');
	  	  unlink ('../../zona_descargas/ejemplos_uso/temp/'.$captions[$i].'');	
		  
  		}

	}
  } 
  
} // CIERRO EL IF
?>
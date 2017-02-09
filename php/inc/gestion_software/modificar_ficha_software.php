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
$id_software=$_POST['id_software'];

//Esta consulta hay que ponerla antes de actualizar la tabla
//IMPORTANTE
$row=$query->datos_software($id_software);
$ma=str_replace('}{',',',$row['software_archivos']);
$ma=str_replace('{','',$ma);
$ma=str_replace('}','',$ma);
$ma=explode(',',$ma);

//Esta consulta hay que ponerla antes de actualizar la tabla
//IMPORTANTE
$ca=str_replace('}{',',',$row['software_capturas']);
$ca=str_replace('{','',$ca);
$ca=str_replace('}','',$ca);
$ca=explode(',',$ca);

//Actualizo la tabla
$modificar_ficha=$query->modificar_software($id_software,$titulo,$descripcion,$objetivo,$informacion_adicional,$estado,$destacado,$archivos,$capturas,$autores,$tipo,$so,$id_licencia,$idiomas,$url1,$url2,$url3,$precio);

$files=str_replace('}{',',',$archivos);
$files=str_replace('{','',$files);
$files=str_replace('}','',$files);
$files=explode(',',$files);

  //BORRO los archivos que ya no están en la lista de archivos seleccionados
   for ($i=0;$i<count($ma);$i++) { 
  	if ($ma[$i]!='') {
  		if (!inArray($files,$ma[$i])) {
	  	  unlink ('../../zona_descargas/software/'.$id_software.'/'.$ma[$i].'');	
  		}
	  }
    }
  // AÑADO LOS NUEVOS archivos
  for ($i=0;$i<count($files);$i++) { 
  	if ($files[$i]!='') {
  		if (!inArray($ma,$files[$i])) {
  		  copy ('../../zona_descargas/software/temp/'.$files[$i].'','../../zona_descargas/software/'.$id_software.'/'.$files[$i].'');
	  	  unlink ('../../zona_descargas/software/temp/'.$files[$i].'');	
		  
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
	  	  unlink ('../../zona_descargas/software/'.$id_software.'/screenshot/'.$ca[$i].'');	
  		}
	  }
    }
  // AÑADO LOS NUEVOS archivos
  for ($i=0;$i<count($captions);$i++) { 
  	if ($captions[$i]!='') {
  		if (!inArray($ca,$captions[$i])) {
  		  copy ('../../zona_descargas/software/temp/'.$captions[$i].'','../../zona_descargas/software/'.$id_software.'/screenshot/'.$captions[$i].'');
	  	  unlink ('../../zona_descargas/software/temp/'.$captions[$i].'');	
		  
  		}

	}
  } 
  
} // CIERRO EL IF
?>
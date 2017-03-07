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

// código para que se actualice de forma automática la caché
// se ejecutan varias llamadas curl, una por cada posible varlor del lenguaje, ya que se debe purgar la página de la caché en cada idioma
// para purgar la paginación harían falta purges de más urls!!!!!
// ojo con la fecha, el resultado de esta página no se debería cachear!!!!!
$hostname = 'varnish';
$port = 80;
$URL = '/materiales.php';
$URL2 = '/materiales.php?id_material='.$id_material ;
$debug = false;

print "Purging varnish cache...\n";
purgeURL( $hostname, $port, $URL, $debug, '');
purgeURL( $hostname, $port, $URL, $debug, 'selected_language=en;');
purgeURL( $hostname, $port, $URL, $debug, 'selected_language=es;');
purgeURL( $hostname, $port, $URL, $debug, 'selected_language=ca;');
purgeURL( $hostname, $port, $URL, $debug, 'selected_language=fr;');
purgeURL( $hostname, $port, $URL, $debug, 'selected_language=ro;');
purgeURL( $hostname, $port, $URL, $debug, 'selected_language=pt;');
purgeURL( $hostname, $port, $URL, $debug, 'selected_language=br;');
purgeURL( $hostname, $port, $URL2, $debug, '');
purgeURL( $hostname, $port, $URL2, $debug, 'selected_language=en;');
purgeURL( $hostname, $port, $URL2, $debug, 'selected_language=es;');
purgeURL( $hostname, $port, $URL2, $debug, 'selected_language=ca;');
purgeURL( $hostname, $port, $URL2, $debug, 'selected_language=fr;');
purgeURL( $hostname, $port, $URL2, $debug, 'selected_language=ro;');
purgeURL( $hostname, $port, $URL2, $debug, 'selected_language=pt;');
purgeURL( $hostname, $port, $URL2, $debug, 'selected_language=br;');
$fecha=date("Y-m-d H:i:s");
print "Done...at $fecha\n";
// Purge items in cache:
function purgeURL( $hostname, $port, $purgeURL, $debug, $cookie )
{
    $finalURL = sprintf("http://%s:%d%s", $hostname, $port, $purgeURL);

    $curlOptionList = array(
          CURLOPT_RETURNTRANSFER     => true,
          CURLOPT_CUSTOMREQUEST      => 'PURGE',
          CURLOPT_HEADER             => true,
          CURLOPT_NOBODY             => true,
          CURLOPT_URL                => $finalURL,
          CURLOPT_CONNECTTIMEOUT_MS  => 2000,
          CURLOPT_COOKIE             => $cookie
    );

    $fd = false;
    if( $debug == true )
    {
        print "\n---- Curl debug -----\n";
        $fd = fopen("php://output", 'w+');
        $curlOptionList[CURLOPT_VERBOSE] = true;
        $curlOptionList[CURLOPT_STDERR] = $fd;
    }

    $curlHandler = curl_init();
    curl_setopt_array( $curlHandler, $curlOptionList );
    curl_exec( $curlHandler );
    curl_close( $curlHandler );

    if( $fd !== false )
    {
        fclose( $fd );
    }
}


?>

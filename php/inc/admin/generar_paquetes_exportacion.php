<?php 
include ('../../classes/querys/query.php');
include_once('../../classes/zip/pclzip.lib.php');

set_time_limit(95000); 

$query=new query();
$tipos=$query->listar_tipos_imagen();
	
$id_tipo_img=$_POST['id_tipo'];

switch ($id_tipo_img) {

	case 2:
	$nombre_zip="Realista";
	$archivos[]='../../zona_descargas/pictogramas/txt/_LEER_CONDICIONES_USO_FOTOGRAFIAS.txt';
	break;
	
	case 3:
	$nombre_zip="Animados";
	break;
	
	case 5:
	$nombre_zip="Pictogramas_ByN";
	$archivos[]='../../zona_descargas/pictogramas/txt/_LEER_CONDICIONES_USO.txt';
	break;
	
	case 9:
	$nombre_zip="Cliparts";
	break;
	
	case 10:
	$nombre_zip="Pictogramas_Color";
	$archivos[]='../../zona_descargas/pictogramas/txt/_LEER_CONDICIONES_USO.txt';
	break;
	
	case 11:
	$nombre_zip="Videos_LSE";
	$archivos[]='../../zona_descargas/pictogramas/txt/_LEER_CONDICIONES_USO_LSE.txt';
	break;
	
	case 12:
	$nombre_zip="LSE_color";
	$archivos[]='../../zona_descargas/pictogramas/txt/_LEER_CONDICIONES_USO_LSE.txt';
	break;

}



if (isset($_POST['id_tipo']) && $_POST['id_tipo'] > 0) { 

//$data=$query->listar_imagenes_orginales_para_exportar($id_tipo_img);
//10756
//12047
//16432
//18033
//19547
//22213
//22638
//23217
//24606
//24801
//25619
//26587
//27372
//29549
//29924
$inicio=0;
$fin=29924;

$data=$query->listar_imagenes_orginales_para_exportar_con_limite($id_tipo_img,$inicio,$fin);
	
	// MODO 1
	// Genera todas las imagenes sin exlusión con lo que hay imagenes duplicadas con la misma palabra 
	// ya que en el catálogo tienen la misma palabra pero diferente definición
	
	/*while ($row=mysql_fetch_array($data)) {
	
	$origen='../../repositorio/originales/'.$row['imagen'];
	$destino='../../zona_descargas/pictogramas/exportados/'.utf8_decode($row['palabra']).'.'.$row['extension'];
	
		if (file_exists($destino)) {
			
			for ($i = 1; $i <= 1000; $i++) {
			
				$destino_final='../../zona_descargas/pictogramas/exportados/'.utf8_decode($row['palabra']).'_'.$i.'.'.$row['extension'];
				if (!file_exists($destino_final)) { break; }
			}
			
		} else {
			
			$destino_final=$destino;
		}
	
	copy ($origen,$destino_final);
	
	}*/
	
	
	
	
	// MODO 2
	// Criba las imagenes/palabras para que no haya una misma imagen repetida 
	// para la misma palabra (no tiene en cuenta las acepciones de la misma palabra que pueda tener asociadas)
	
	while ($row=mysql_fetch_array($data)) {
	
	if ($id_tipo_img==11) { 
		$origen='../../repositorio/LSE_acepciones/'.$row['imagen'];
	} else { 
		$origen='../../repositorio/originales/'.$row['imagen'];
	}
	
	$a_reemplazar1 = array("¿","?");
	$a_reemplazar2 = array("/");
	
	$filtrado1 = str_replace($a_reemplazar1,"",$row['palabra']);
	$filtrado2 = str_replace($a_reemplazar2, "-", $filtrado1);

	$palabra_copiar=utf8_decode($filtrado2);
	
	$destino='../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/'.$row['id_imagen'].'_'.$palabra_copiar.'.'.$row['extension'];
	
		if (!file_exists($destino)) {
			
		 copy ($origen,$destino);
		
		}
	
	}
	
	if ($gestor = opendir('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/')) {
		while (false !== ($archivo = readdir($gestor))) {
			if ($archivo != "." && $archivo != ".." && $archivo != "final") {
			
				$archivo_img=explode('_',$archivo);
				$destino_img='../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/final/'.$archivo_img[1];
				$nombre_archivo=$archivo_img[1];
				
				if (file_exists($destino_img)) {
			
					for ($i = 1; $i <= 1000; $i++) {
					
						$choped_file=explode('.',$archivo_img[1]);
						$destino_final_img='../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/final/'.$choped_file[0].'_'.$i.'.'.$choped_file[1];
						$nombre_archivo_final=$choped_file[0].'_'.$i.'.'.$choped_file[1];
						if (!file_exists($destino_final_img)) { break; }
					}
					
				} else {
					
					$destino_final_img=$destino_img;
					$nombre_archivo_final=$nombre_archivo;
				}
		
				//rename('../../zona_descargas/pictogramas/exportados/'.$archivo,$destino_final_img);
				copy ('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/'.$archivo,'../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/final/'.$nombre_archivo_final);
				//echo $destino_final_img.'<br />';
			}
		}
		closedir($gestor);
	}
	
	if ($gestor = opendir('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/')) {
		while (false !== ($archivo = readdir($gestor))) {
			if ($archivo != "." && $archivo != ".." && $archivo != "final") {
				unlink ('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/'.$archivo);
			}
		}
	}	
	
	if ($gestor1 = opendir('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/final/')) {
		while (false !== ($archivo1 = readdir($gestor1))) {
			if ($archivo1 != "." && $archivo1 != ".." && $archivo1 != "final") {
			
				copy ('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/final/'.$archivo1,'../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/'.iconv("ISO-8859-1", "CP850", $archivo1));
				$archivos[]='../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/'.iconv("ISO-8859-1", "CP850", $archivo1);
				unlink ('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/final/'.$archivo1);
				
				
			}
		}
	}
	
	$dir='../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/final/';
	
	if ($inicio==0) {
		$file = $nombre_zip.'_completo.zip';
	} else {
		$file = $nombre_zip.'_'.$inicio.'-'.$fin.'.zip';
	}
	
	$archive = new PclZip($dir.$file);
	
	$v_list = $archive->add($archivos,PCLZIP_OPT_REMOVE_ALL_PATH);
							  
	  if ($v_list == 0) {
		die("Error : ".$archive->errorInfo(true));
	  } 
	
	if ($gestor2 = opendir('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/')) {
		while (false !== ($archivo2 = readdir($gestor2))) {
			if ($archivo2 != "." && $archivo2 != ".." && $archivo2 != "final") {
				unlink ('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/'.$archivo2);
			}
		}
	}
	
echo "Proceso realizado";


}
?>
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  Tipo a exportar
  <input name="id_tipo" type="text" id="id_tipo" size="5" maxlength="2" />
  <label>
  <input type="submit" name="button" id="button" value="Enviar" />
  </label>
  <p>2 - Realista</p>
  <p>3 - Animados</p>
  <p>5 - Pictogramas Blanco y Negro</p>
  <p>9 - Clipart</p>
  <p>10 - Pictogramas Color</p>
  <p>11 - Videos LSE</p>
  <p>12 - LSE Color</p>
  <p>13 - LSE ByN</p>
</form>


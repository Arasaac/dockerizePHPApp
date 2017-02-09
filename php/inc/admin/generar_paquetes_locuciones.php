<?php 
include ('../../classes/querys/query.php');
include_once('../../classes/zip/pclzip.lib.php');

set_time_limit(95000); 

$query=new query();
	
$id_idioma=$_POST['id_idioma'];


if (isset($_POST['id_idioma']) && $_POST['id_idioma'] == 0) { //PARA CASTELLANO

	$data=$query->listar_diccionario();
	
	while ($row=mysql_fetch_array($data)) {
		
		if (file_exists('../../repositorio/locuciones/0/'.$row['id_palabra'].'.mp3')) {
			
			$a_reemplazar1 = array("¿", "?");
			$a_reemplazar2 = array("/");
			
			$filtrado1 = str_replace($a_reemplazar1, "", $row['palabra']);
			$filtrado2 = str_replace($a_reemplazar2, "-", $filtrado1);
		
			$palabra_copiar=utf8_decode($filtrado2);
	
			$origen='../../repositorio/locuciones/0/'.$row['id_palabra'].'.mp3';
			$destino='../../zona_descargas/locuciones/'.$id_idioma.'/final/'.$palabra_copiar.'.mp3';
			
				if (!file_exists($destino)) {
					
					copy($origen,$destino);
					
				}
			
		}
		
	}
	
	if ($gestor1 = opendir('../../zona_descargas/locuciones/'.$id_idioma.'/final/')) {
		while (false !== ($archivo1 = readdir($gestor1))) {
			if ($archivo1 != "." && $archivo1 != ".." && $archivo1 != "final") {
			
				copy ('../../zona_descargas/locuciones/'.$id_idioma.'/final/'.$archivo1,'../../zona_descargas/locuciones/'.$id_idioma.'/'.iconv("ISO-8859-1", "CP850", $archivo1));
				$archivos[]='../../zona_descargas/locuciones/'.$id_idioma.'/'.iconv("ISO-8859-1", "CP850", $archivo1);
				unlink ('../../zona_descargas/locuciones/'.$id_idioma.'/final/'.$archivo1);
				
				
			}
		}
	}
	
	$dir='../../zona_descargas/locuciones/'.$id_idioma.'/final/';

	$file = $id_idioma.'_locuciones.zip';
	
	$archive = new PclZip($dir.$file);
	
	$v_list = $archive->add($archivos,PCLZIP_OPT_REMOVE_ALL_PATH);
							  
	  if ($v_list == 0) {
		die("Error : ".$archive->errorInfo(true));
	  } 
	 
	if ($gestor2 = opendir('../../zona_descargas/locuciones/'.$id_idioma.'/')) {
		while (false !== ($archivo2 = readdir($gestor2))) {
			if ($archivo2 != "." && $archivo2 != ".." && $archivo2 != "final") {
				unlink ('../../zona_descargas/locuciones/'.$id_idioma.'/'.$archivo2);
			}
		}
	}
	
	
} elseif (isset($_POST['id_idioma']) && $_POST['id_idioma'] > 0) {  // PARA OTRO IDIOMA

	$data=$query->listar_traducciones_por_idioma($id_idioma);

	while ($row=mysql_fetch_array($data)) {
		
		if (file_exists('../../repositorio/locuciones/'.$id_idioma.'/'.$row['id_traduccion'].'.mp3')) {
			
			if ($row['traduccion'] != NULL) { 
		
			$a_reemplazar1 = array("¿","?");
			$a_reemplazar2 = array("/");
			$a_reemplazar3 = array("â€™");
	
			$filtrado1 = str_replace($a_reemplazar1, "",$row['traduccion']);
			$filtrado2 = str_replace($a_reemplazar2, "-", $filtrado1);

			$palabra_copiar=utf8_decode($filtrado2); 
			
			$origen='../../repositorio/locuciones/'.$id_idioma.'/'.$row['id_traduccion'].'.mp3';
			$destino='../../zona_descargas/locuciones/'.$id_idioma.'/final/'.$palabra_copiar.'.mp3';
			
				if (!file_exists($destino)) {
					
					copy($origen,$destino);
					
				}
				
		 	} // Cierro el IF
		 
		}
	
	}
	
	if ($gestor1 = opendir('../../zona_descargas/locuciones/'.$id_idioma.'/final/')) {
		while (false !== ($archivo1 = readdir($gestor1))) {
			if ($archivo1 != "." && $archivo1 != ".." && $archivo1 != "final") {
			
				copy ('../../zona_descargas/locuciones/'.$id_idioma.'/final/'.$archivo1,'../../zona_descargas/locuciones/'.$id_idioma.'/'.iconv("ISO-8859-1", "CP850", $archivo1));
				$archivos[]='../../zona_descargas/locuciones/'.$id_idioma.'/'.iconv("ISO-8859-1", "CP850", $archivo1);
				unlink ('../../zona_descargas/locuciones/'.$id_idioma.'/final/'.$archivo1);
				
				
			}
		}
	}
	
	$dir='../../zona_descargas/locuciones/'.$id_idioma.'/final/';

	$file = $id_idioma.'_locuciones.zip';
	
	$archive = new PclZip($dir.$file);
	
	$v_list = $archive->add($archivos,PCLZIP_OPT_REMOVE_ALL_PATH);
							  
	  if ($v_list == 0) {
		die("Error : ".$archive->errorInfo(true));
	  } 
	 
	if ($gestor2 = opendir('../../zona_descargas/locuciones/'.$id_idioma.'/')) {
		while (false !== ($archivo2 = readdir($gestor2))) {
			if ($archivo2 != "." && $archivo2 != ".." && $archivo2 != "final") {
				unlink ('../../zona_descargas/locuciones/'.$id_idioma.'/'.$archivo2);
			}
		}
	}
	
}

echo "Proceso realizado";

?>
<form id="form1" name="form1" method="post" action="<?php echo $PHP_SELF; ?>">
  Idioma
    <input name="id_idioma" type="text" id="id_idioma" size="5" maxlength="2" />
  <label>
  <input type="submit" name="button" id="button" value="Enviar" />
  </label>
  <p>0 - Castellano  </p>
  <p>7-Inglés </p>
  <p>8-Francés </p>
  <p>9-Catalán </p>
  <p>11-Alemán </p>
  <p>12-Italiano </p>
</form>


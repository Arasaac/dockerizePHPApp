<?php 
include ('../../classes/querys/query.php');
include_once('../../classes/zip/pclzip.lib.php');

set_time_limit(95000); 

$query=new query();
	
$id_idioma=$_POST['id_idioma'];

if (isset($_POST['id_idioma'])) { 
	
	if ($gestor1 = opendir('../../repositorio/locuciones/'.$id_idioma.'/')) {
		while (false !== ($archivo1 = readdir($gestor1))) {
			if ($archivo1 != "." && $archivo1 != ".." && $archivo1 != "final") {
				
				$origen='../../repositorio/locuciones/'.$id_idioma.'/'.$archivo1;
				$destino='../../zona_descargas/locuciones/'.$id_idioma.'/'.$archivo1;
			
				if (!file_exists($destino)) { copy($origen,$destino); }
				
				$archivos[]='../../zona_descargas/locuciones/'.$id_idioma.'/'.$archivo1;
								
			}
		}
	}
	
	$dir='../../zona_descargas/locuciones/'.$id_idioma.'/final/';

	$file = $id_idioma.'_locuciones_ID.zip';
	
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

echo "Proceso realizado";

} //Cierro el IF Inicial
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


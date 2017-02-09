<?php 
include ('../../classes/querys/query.php');
include_once('../../classes/zip/pclzip.lib.php');

set_time_limit(45000); 

$query=new query();
	
if (isset($_POST['id_tipo']) && $_POST['id_tipo'] !='') {
	
$id_idioma=$_POST['id_tipo'];

	if ($id_idioma==0) { 
	
		$listado_palabras_es=$query->listar_palabras();
		
		while ($row=mysql_fetch_array($listado_palabras_es)) {
			
			if (file_exists('../../repositorio/locuciones/0/'.$row['id_palabra'].'.mp3')) {
				$actualizar=$query->actualizar_locucion_es($row['id_palabra'],1);
			} else {
				$actualizar=$query->actualizar_locucion_es($row['id_palabra'],0);
			}
			
		}
	echo "Proceso realizado";
	
	} elseif ($id_idioma>0) {
		
		$listado_traducciones=$query->listar_traducciones_por_idioma($id_idioma);
		
		while ($row=mysql_fetch_array($listado_traducciones)) {
			
			if (file_exists('../../repositorio/locuciones/'.$id_idioma.'/'.$row['id_traduccion'].'.mp3')) {
				$actualizar=$query->actualizar_locucion_traduccion($row['id_traduccion'],1);
			} else {
				$actualizar=$query->actualizar_locucion_traduccion($row['id_traduccion'],0);
			}
			
		}
	
	echo "Proceso realizado";
	
	}
	
}
?>
<form id="form1" name="form1" method="post" action="<?php echo $PHP_SELF; ?>">
  Idioma a actualizar
    <input name="id_tipo" type="text" id="id_tipo" size="5" maxlength="2" />
  <label>
  <input type="submit" name="button" id="button" value="Enviar" />
  </label>
  <p>0 - Castellano</p>
  <p>1 - Ruso</p>
  <p>2 - Rumano</p>
  <p>3 - Arabe</p>
  <p>4 - Chino</p>
  <p>5 - Bulgaro</p>
  <p>6 - Polaco</p>
  <p>7 - Ingles</p>
  <p>8 - Frances</p>
  <p>9 - Catalan</p>
  <p>10 - Euskera</p>
  <p>11 - Aleman</p>
  <p>12 - Italiano </p>
  <p>13 - Portugues</p>
</form>


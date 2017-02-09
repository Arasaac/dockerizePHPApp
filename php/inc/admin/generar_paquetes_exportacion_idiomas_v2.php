<?php 
require('../../classes/querys/query.php');
require('../../classes/zip/zip_min.inc');
$zipfile = new zipfile();
set_time_limit(95000); 
$query=new query();
$tipos=$query->listar_tipos_imagen();
$id_idioma=$_POST['id_idioma_seleccionado']; //7-Inglés 8-Francés 9-Catalán 11-Alemán 12-Italiano 13-Portugues 15-Brasileño	

switch ($id_idioma) {
	case 7: $abrev_idioma="EN"; break;
	case 8: $abrev_idioma="FR";	break;
	case 9: $abrev_idioma="CA";	break;	
	case 11: $abrev_idioma="DE"; break;
	case 12: $abrev_idioma="IT"; break;
	case 13: $abrev_idioma="PT"; break;
	case 15: $abrev_idioma="BR"; break;
}

$id_tipo_img=$_POST['id_tipo'];

switch ($id_tipo_img) {

	case 2:
	$nombre_zip="Realista";
	break;
	
	case 3:
	$nombre_zip="Animados";
	break;
	
	case 5:
	$nombre_zip="Pictogramas_ByN";
	if ($id_idioma==7) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_README_TERMS_OF_USE.txt';
	} elseif ($id_idioma==8) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_LIRE_CONDITIONS_D_UTILISATION.txt';
	} elseif ($id_idioma==13 || $id_idioma==15) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_LER_CONDIÇÕES_DE_USO.txt';
	} else { 
		$archivos[]='../../zona_descargas/pictogramas/txt/_README_TERMS_OF_USE.txt';
	}
	break;
	
	case 9:
	$nombre_zip="Cliparts";
	break;
	
	case 10:
	$nombre_zip="Pictogramas_Color";
	if ($id_idioma==7) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_README_TERMS_OF_USE.txt';
	} elseif ($id_idioma==8) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_LIRE_CONDITIONS_D_UTILISATION.txt';
	} elseif ($id_idioma==13 || $id_idioma==15) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_LER_CONDIÇÕES_DE_USO.txt';
	} else { 
		$archivos[]='../../zona_descargas/pictogramas/txt/_README_TERMS_OF_USE.txt';
	}
	break;

}



if (isset($_POST['id_tipo']) && $_POST['id_tipo'] > 0) { 

//$data=$query->listar_imagenes_orginales_para_exportar($id_tipo_img);

// 10-08-09 desde 8975 hasta 9438
// 29-01-10 desde 9439 hasta 10756
//12047
//16432
//22213
//22638
//23217
$inicio=$_POST['desde'];
$fin=$_POST['hasta'];

$data=$query->listar_imagenes_orginales_para_exportar_con_limite($id_tipo_img,$inicio,$fin);
	
	// Criba las imagenes/palabras para que no haya una misma imagen repetida 
	// para la misma palabra (no tiene en cuenta las acepciones de la misma palabra que pueda tener asociadas)
	
	while ($row=mysql_fetch_array($data)) {
	
	$origen='../../repositorio/originales/'.$row['imagen'];
	
	$a_reemplazar1 = array("¿","?");
	$a_reemplazar2 = array("/");
	$a_reemplazar3 = array("â€™");
	
	
	$data_traduccion=$query->buscar_traduccion($row['id_palabra'],$id_idioma);
	$traduccion=mysql_fetch_array($data_traduccion);
	$n_traducciones=mysql_num_rows($data_traduccion);
	
		if ($n_traducciones > 0 
			&& $traduccion['traduccion'] != 'sin traduccion'
			&& $traduccion['traduccion'] != '?'
			&& $traduccion['traduccion'] != '¿'
			&& $traduccion['traduccion'] != '¡'
			&& $traduccion['traduccion'] != '!'
			) { 
		
			$filtrado1 = str_replace($a_reemplazar1, "",$traduccion['traduccion']);
			$filtrado2 = str_replace($a_reemplazar2, "-", $filtrado1);

			$palabra_copiar=utf8_decode($filtrado2); //FRANCES
			
			$destino='../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/'.$row['id_imagen'].'_'.$palabra_copiar.'.'.$row['extension'];
			
				if (!file_exists($destino)) {
					
				 copy ($origen,$destino);
				
				}
				
		 } // Cierro el IF
			
	} // Cierro el While
			
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
					
						copy ('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/final/'.$archivo1,'../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/'.$archivo1);
						
						$zipfile -> addFile(file_get_contents('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/'.$archivo1.''), iconv("ISO-8859-1", "CP850", $archivo1));
						unlink ('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/final/'.$archivo1);
						
						
					}
				}
			}
			
			
			$dir='../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/final/';
			
			if ($inicio==0) {
				$file = $abrev_idioma.'_'.$nombre_zip.'.zip';
			} else {
				$file = $abrev_idioma.'_'.$nombre_zip.'_'.$inicio.'-'.$fin.'.zip';
			}
			
			$contents = $zipfile -> file();
			file_put_contents($dir.$file,$contents);

			if ($gestor2 = opendir('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/')) {
				while (false !== ($archivo2 = readdir($gestor2))) {
					if ($archivo2 != "." && $archivo2 != ".." && $archivo2 != "final") {
						unlink ('../../zona_descargas/pictogramas/exportados/'.$id_tipo_img.'/'.$archivo2);
					}
				}
			}

	echo "Proceso realizado";

} // Cierro el While
?>
<form id="form1" name="form1" method="post" action="<?php echo $PHP_SELF; ?>">
  <p>Idioma
    <select name="id_idioma_seleccionado">
      <option value="7">Inglés</option>
      <option value="8">Francés</option>
      <option value="9">Catalán</option>
      <option value="11">Alemán</option>
      <option value="12">Italiano</option>
      <option value="13">Portugués</option>
      <option value="15">Portugués Brasil</option>
    </select>
  </p>
  <p>
    <label>Desde
      <input name="desde" type="text" id="desde" value="0" size="6" />
    </label>
    <label>Hasta
      <input name="hasta" type="text" id="hasta" size="9" />
    </label>
  </p>
  <p>Tipo a exportar
  <input name="id_tipo" type="text" id="id_tipo" size="5" maxlength="2" />
    <label>
      <input type="submit" name="button" id="button" value="Enviar" />
    </label>
  </p>
  <p>2 - Realista</p>
  <p>5 - Pictogramas Blanco y Negro</p>
  <p>10 - Pictogramas Color</p>
</form>


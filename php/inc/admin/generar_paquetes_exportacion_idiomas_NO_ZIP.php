<?php 
include ('../../classes/querys/query.php');
include_once('../../classes/zip/pclzip.lib.php');
require('../../classes/utf8/utf8.class.php');
/***************************************************/
/*    CODIFICACION DIFERENTES IDIOMAS           */
/***************************************************/

define("MAP_DIR","../../classes/utf8/MAPPING");
define("CP1250",MAP_DIR . "/CP1250.MAP");
define("CP1251",MAP_DIR . "/CP1251.MAP");
define("CP1252",MAP_DIR . "/CP1252.MAP");
define("CP1253",MAP_DIR . "/CP1253.MAP");
define("CP1254",MAP_DIR . "/CP1254.MAP");
define("CP1255",MAP_DIR . "/CP1255.MAP");
define("CP1256",MAP_DIR . "/CP1256.MAP");
define("CP1257",MAP_DIR . "/CP1257.MAP");
define("CP1258",MAP_DIR . "/CP1258.MAP");
define("CP874", MAP_DIR . "/CP874.MAP");
define("CP932", MAP_DIR . "/CP932.MAP");
define("CP936", MAP_DIR . "/CP936.MAP");
define("CP949", MAP_DIR . "/CP949.MAP");
define("CP950", MAP_DIR . "/CP950.MAP");
define("GB2312", MAP_DIR . "/GB2312.MAP");
define("BIG5", MAP_DIR . "/BIG5.MAP");

$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_pl=new utf8(CP1250); //defaults to CP1250.
$utfConverter_pl->loadCharset(CP1250);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

set_time_limit(25000); 
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
	case 10: $abrev_idioma="EU"; break;
	case 14: $abrev_idioma="GA"; break;
}

$id_tipo_img=$_POST['id_tipo'];

switch ($id_tipo_img) {

	case 2:
	$nombre_zip="Realista";
	if ($id_idioma==7) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_README_TERMS_OF_USE.txt';
	} elseif ($id_idioma==8) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_LIRE_CONDITIONS_D_UTILISATION.txt';
	} elseif ($id_idioma==13 || $id_idioma==15) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_LER_CONDISOES_DE_USO.txt';
	} elseif ($id_idioma==14) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_LEER_CONDICIONES_USO.txt';
	} else { 
		$archivos[]='../../zona_descargas/pictogramas/txt/_README_TERMS_OF_USE.txt';
	}
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
		$archivos[]='../../zona_descargas/pictogramas/txt/_LER_CONDISOES_DE_USO.txt';
	} elseif ($id_idioma==14) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_LEER_CONDICIONES_USO.txt';
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
		$archivos[]='../../zona_descargas/pictogramas/txt/_LER_CONDISOES_DE_USO.txt';
	} elseif ($id_idioma==14) {
		$archivos[]='../../zona_descargas/pictogramas/txt/_LEER_CONDICIONES_USO.txt';
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
//24606
//24801
//25619
//27372
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
			&& $traduccion['traduccion'] != NULL
			&& $traduccion['traduccion'] != '?'
			&& $traduccion['traduccion'] != '¿'
			&& $traduccion['traduccion'] != '¡'
			&& $traduccion['traduccion'] != '!'
			) { 
			
				switch ($id_idioma) {
									
						case 1: //RUSO
						$file_name=$utfConverter_ru->strToUtf8($traduccion['traduccion']);
						break;
									
						case 5: //BULGARO
						$file_name=$utfConverter_ru->strToUtf8($traduccion['traduccion']);
						break;
						
						//case 6: //POLACO
						//$file_name=$utfConverter_pl->strToUtf8($traduccion['traduccion']);
						//break;
									
						default:
						$file_name=$traduccion['traduccion'];
						break;
									
				}
		
			$filtrado1 = str_replace($a_reemplazar1, "",$file_name);
			$filtrado2 = str_replace($a_reemplazar2, "-", $filtrado1);

			//$palabra_copiar=utf8_decode($filtrado2); //FRANCES
			$palabra_copiar=$filtrado2; //INGLES
			$palabra_copiar=iconv("UTF-8","ISO-8859-1", $filtrado2);
			
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
			

			
	
	echo "Proceso realizado";

} // Cierro el While
?>
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <p>Idioma
    <select name="id_idioma_seleccionado">
	  
      <option value="7">Ingles</option>
      <option value="8">Frances</option>
      <option value="9">Catalan</option>
      <option value="11">Aleman</option>
      <option value="12">Italiano</option>
      <option value="13">Portugues</option>
      <option value="15">Portugues Brasil</option>
	  <option value="10">Euskera</option>
      <option value="14">Gallego</option>
	  <option value="1">Ruso</option>
	  <option value="5">Bulgaro</option>
	  <option value="4">Chino</option>
	  <option value="6">Polaco</option>
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


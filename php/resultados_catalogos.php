<?php 
define("MAP_DIR","classes/utf8/MAPPING");
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

include_once('classes/utf8/utf8.class.php');
$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);
?>
<div <?php  if ((!isset($_GET['arbol']) || $_GET['arbol']==1)) { echo 'class="tabla_ultimas_imagenes"'; } else { echo 'class="tabla_ultimas_imagenes_100"'; } ?> id="ultimas_imagenes">
        <ul id="thelist3">
        <div id="barra_resultados_superior"><div class="alineacion_derecha"><strong><?php echo $translate['resultados']; ?>: </strong><?php echo $inicial ?> - <?php echo $inicial+$cantidad ?> <?php echo $translate['de']; ?> <?php echo $total_records ?></div> </div>
			<?php  	
				if ($total_records > 0 ) {
				
				while ($row=mysql_fetch_array($resultados)) {
				
					$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
					$encript->encriptar($ruta,1);
					
					$ruta_img='size='.$img_size.'&ruta=../../repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_cesto,1);
					
					if ($_SESSION['id_language'] > 0) {
			  
						//if (strlen($row['traduccion']) > 15) { $word=substr($row['traduccion'],0,15).".."; } else {  $word=$row['traduccion'];  }
						switch ($_SESSION['id_language']) {
								case 3:
								$word = $utfConverter->strToUtf8($row['traduccion']);
								break;
								
								default:
								$word=$row['traduccion'];
								break;
								
						}	
						
					if ($row['explicacion']!='') { $definition=':'.$row['explicacion']; } else { $definition=$row['explicacion']; }
										  
					} else {
				  
						//if (strlen($row['palabra']) > 15) { $word=substr($row['palabra'],0,15).".."; } else { $word=$row['palabra'];  }
						$word=utf8_encode($row['palabra']); 
						$definition=':'.$row['definicion'];
				  
					}
					
						$archivo='repositorio/originales/'.$row['imagen'].'';
						 
						$imagen='repositorio/originales/'.$row['imagen'];

						$extension = strtolower(substr(strrchr($imagen, "."), 1));
							
						switch ($extension) {
						
							case "gif":
							$source = imagecreatefromgif($imagen); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
							$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
							$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
							break;
							
							case "png":
							$source = imagecreatefrompng($imagen); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
							$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
							$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
							break;
							
							case "jpg":
							$source = imagecreatefromjpeg($imagen); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
							$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
							$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
							break;
						
						}	
						
						 if (file_exists($archivo)) {
						 		$peso_archivo = filesize($archivo);
								$info=$imageX.'X'.$imageY.'&nbsp;-&nbsp;'.tamano_archivo($peso_archivo).'&nbsp;-&nbsp;'.$extension;
						 }
			?>
          <li> <a href="<?php echo $PHP_SELF; ?>?<?php echo $cadena_url ?>id=<?php echo $row['id_imagen']; ?>&id_palabra=<?php echo $row['id_palabra']; ?>"><img src="<?php if (file_exists('repositorio/thumbs/'.$tipo_pictograma.'/'.$img_size.'/'.$row['imagen'][0].'/'.$row['imagen'])) { echo 'repositorio/thumbs/'.$tipo_pictograma.'/'.$img_size.'/'.$row['imagen'][0].'/'.$row['imagen']; } else { echo 'classes/img/thumbnail.php?i='.$ruta_img.''; } ?>" alt="<?php echo $translate['hacer_clic_para_acceder_a_la_ficha_de']; ?> <?php echo $word; ?><?php if (strlen($definition) > 100) { echo substr (utf8_encode($definition), 0, 100)."..."; } else { echo utf8_encode($definition); } ?>" class="image" title="<?php echo $translate['hacer_clic_para_acceder_a_la_ficha_de']; ?> <?php echo $word; ?><?php if (strlen($definition) > 100) { echo substr (utf8_encode($definition), 0, 100)."..."; } else { echo utf8_encode($definition); } ?>" /></a><br />
              <?php 	
					
			  echo '<input name="file[]" id="'.$ruta_cesto.'" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;<label for="'.$ruta_cesto.'">';
					
				$result_lse=$query->buscar_acepcion_lse($row['id_palabra']);
                $numrows_lse=mysql_num_rows($result_lse);
                 
                    if ($numrows_lse>0) {  
                        $r=1;
                            while ($row_lse=mysql_fetch_array($result_lse)) { 
                            echo '<a href="inc/public/ver_acepcion.php?i='.$row_lse['id_imagen'].'" target="_blank"><img src="images/acepcion_'.$r.'.jpg" alt="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" title="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" border=0" /></a>&nbsp;';
                            $r++;
                            }  
                    }
					
			  echo '<a href="'.$PHP_SELF.'?'.$cadena_url.'id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
			  
			  if (isset($_GET['TXTlocate']) && isset($_GET['letra']) && $_GET['TXTlocate'] < 4 && $_GET['letra']!='') { echo $resaltar->CheckSentence($word,$_GET['letra']); } elseif (isset($_GET['TXTlocate']) && isset($_GET['letra']) && $_GET['TXTlocate'] > 4 && $_GET['letra']!='') { echo $word; } else { echo $word; }
			  
			  echo '</a></label>';
			  		  
			  $ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
			  $encript->encriptar($ruta_creador,1); 
				
			  echo '<br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma">';
			  
			  echo '<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' alt="'.$translate['descargar_imagen'].'" title="'.$translate['descargar_imagen'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_imagen'].'</a><br /><a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)" onkeypress="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)"><img src=\'images/paint.gif\' alt="'.$translate['creador_de_simbolos'].'" title="'.$translate['creador_de_simbolos'].'"></a>&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)" onkeypress="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)">'.$translate['creador_de_simbolos'].'</a>';
			  
			  if ($_SESSION['id_language'] =='es') {
				  echo insertar_locucion_castellano_resultados($encript,$row,$cadena_url,$translate);
			  } elseif ($_SESSION['id_language'] !='es') {
				  echo insertar_locucion_idioma_resultados($encript,$row,$cadena_url,$translate);		
			  }
			  
			  echo '</div>';
			  
			  ?>
          </li>
          <?php } } ?>
            <div id="numeracion_inferior">
	 			 <?php require('numeracion_inferior.php'); ?>
 			 </div>
	    </ul>
         <br />
 
<input name="boton_seleccionar_todos" type="button" value="<?php echo $translate['seleccionar_todos']; ?>" class="boton_mediano" onclick="selydestodos(document.descarga_pictogramas,1)"/>  
 
<input name="boton_seleccionar_todos" type="button" value="<?php echo $translate['deseleccionar_todos']; ?>" class="boton_mediano" onclick="selydestodos(document.descarga_pictogramas,0)"/>

<input name="boton_descargar" type="submit" value="<?php echo $translate['add_archivos_mi_seleccion']; ?>" class="boton_mediano"/> 

</div>
     
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
				
					$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
					$archivo='repositorio/LSE_acepciones/'.$row['imagen'];
					$imagen='repositorio/LSE_acepciones/'.$row['imagen'];
					$extension = strtolower(substr(strrchr($imagen, "."), 1));
						
					$encript->encriptar($ruta_cesto,1);
				
					$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
					$encript->encriptar($ruta,1);
							
					echo '<li><object id="'.$row['id_imagen'].'" width="110" height="125" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
					type="application/x-shockwave-flash"> 
					 <param name="wmode" value="transparent">
					<param name="movie" value="plugins/flowplayer/flowplayer-3.1.1.swf" />  
					<param name="allowfullscreen" value="true" /> 
					 
					<param name="flashvars"  
						value=\'config={"clip": { "url": "repositorio/LSE_acepciones/'.$row['imagen'].'", "bufferLength": 2, "autoBuffering": true,
							"autoPlay": false, "scaling": "fit"}, "play": {"replayLabel": "'.$translate['repetir'].'" }, "plugins": { "controls": {"volume": false, "mute": false, "time":false, "height":15, "backgroundColor": "#FFFFFF", "progressColor": "#000000", "bufferColor": "#CCCCCC" } }  }\' /> 
				</object><br />';
				
					$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
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
						
						$definition=$row['explicacion'];
						echo '<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
						if (isset($_GET['TXTlocate']) && isset($_GET['letra']) && $_GET['TXTlocate'] < 4 && $_GET['letra']!='') { echo $resaltar->CheckSentence($word,$_GET['letra']); } elseif (isset($_GET['TXTlocate']) && isset($_GET['letra']) && $_GET['TXTlocate'] > 4 && $_GET['letra']!='') { echo $word; } else { echo $word; }
						
						echo '</a>';
				  
					} else {
				  
						if (strlen($row['palabra']) > 15) { $word=substr(utf8_encode($row['palabra']),0,15).".."; } else { $word=utf8_encode($row['palabra']);  }
						$definition=$row['definicion'];
						echo '<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;<label for="'.$ruta_cesto.'"><a href="'.$PHP_SELF.'?'.$cadena_url.'id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
						if (isset($_GET['TXTlocate']) && isset($_GET['letra']) && $_GET['TXTlocate'] < 4 && $_GET['letra']!='') { echo $resaltar->CheckSentence($word,$_GET['letra']); } elseif (isset($_GET['TXTlocate']) && isset($_GET['letra']) && $_GET['TXTlocate'] > 4 && $_GET['letra']!='') { echo $word; } else { echo $word; }
						
						echo '</a></label>';
				  
					}
					
					if (file_exists($archivo)) {
						$peso_archivo = filesize($archivo);
						$info=tamano_archivo($peso_archivo).'&nbsp;-&nbsp;'.$extension;
					}
						 											
				
			 		 echo '<br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma">';
					 
					    if (file_exists('repositorio/LSE_definiciones/'.$row['id_palabra'].'.flv')) {
                        echo '<a href="inc/public/ver_definicion.php?i='.$row['id_palabra'].'" target="_blank"><img src="images/icono_lse_13x13.jpg" alt="'.$translate['ver_definicion_lengua_signos'].'" title="'.$translate['ver_definicion_lengua_signos'].'" /></a> <a href="inc/public/ver_definicion.php?i='.$row['id_palabra'].'" target="_blank">'.$translate['ver_definicion_lse'].'</a><br />';
                        } 
						
					 echo '<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' alt="'.$translate['descargar_video'].'" title="'.$translate['descargar_video'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_video'].'</a>';
					 
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
     
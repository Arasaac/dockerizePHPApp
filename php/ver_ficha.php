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

$id_imagen=$_GET['id'];	
$id_palabra=$_GET['id_palabra'];

$row=$query->datos_imagen($id_imagen);

if ($_SESSION['language']=='es') {
	$datos_palabra=$query->datos_palabra($id_palabra);
	$word=utf8_encode($datos_palabra['palabra']);
	$definition=$datos_palabra['definicion'];
} elseif ($_SESSION['language']!='es') {
	$traduccion=$query->buscar_traduccion($id_palabra,$_SESSION['id_language']);
	$datos_palabra=mysql_fetch_array($traduccion);
	$word=$datos_palabra['traduccion'];
	$definition=$datos_palabra['explicacion'];
}

//$estadisticas=$query->imagen_numero_visitas($id_imagen); //SE ANULA AL HABER ELIMINADO EL CAMPO VECES_VISTO EN LA TABLA IMAGENES
$asociadas=$query->palabras_asociadas($id_imagen,$id_palabra);
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

if ($row['id_tipo_imagen']==11) { 
	$archivo='repositorio/LSE_acepciones/'.$row['imagen'];
} else {
	$archivo='repositorio/originales/'.$row['imagen'];
}

if (file_exists($archivo)) {
		$peso_archivo = filesize($archivo);
		$peso=tamano_archivo($peso_archivo);
}

//Con este código elimino la variable pg que es dinamica
	$str = $_SERVER['QUERY_STRING'];
	parse_str($str, $info);
	unset($info['product_id']);
	$cadena_url=http_build_query($info);
	if ($cadena_url !='') { $cadena_url=http_build_query($info).'&'; }
//************************************************************
?>	
<div <?php  if ((!isset($_GET['arbol']) || $_GET['arbol']==1)) { echo 'class="tabla_ultimas_imagenes"'; } else { echo 'class="tabla_ultimas_imagenes_100"'; } ?> id="ultimas_imagenes"> 
	<div id="thelist3">
    	<br />
   	  <div style="float:left; margin-left:10px; margin-right:10px; padding:20px; margin-bottom:20px;">
              <p>
              <?php 
            if ($row['id_tipo_imagen']==11) { 
            
                $ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
                $encript->encriptar($ruta_cesto,1);
                                
                $ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$datos_palabra['id_palabra'];
                $encript->encriptar($ruta,1);	
            
                    echo '<object id="'.$row['id_imagen'].'" width="310" height="325" vspace="10" hspace="10" align="left" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
                                type="application/x-shockwave-flash"> 
                                 <param name="wmode" value="transparent">
                                <param name="movie" value="plugins/flowplayer/flowplayer-3.1.1.swf" />  
                                <param name="allowfullscreen" value="true" /> 
                                 
                                <param name="flashvars"  
                                    value=\'config={"clip": { "url": "repositorio/LSE_acepciones/'.$row['imagen'].'", "bufferLength": 2, "autoBuffering": true,
                                        "autoPlay": false, "scaling": "fit"}, "play": {"replayLabel": "Repetir" }, "plugins": { "controls": {"volume": false, "mute": false, "time":false, "height":15, "backgroundColor": "#FFFFFF", "progressColor": "#000000", "bufferColor": "#CCCCCC" } }  }\' /> 
                        </object>';
                   
                   $acciones='<div id="informacion_pictograma_ficha"><a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_3.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a> | <a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_3.png\' border="0" alt="'.$translate['descargar_imagen'].'" title="'.$translate['descargar_imagen'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_imagen'].'</a></div>'; 
                        
                                    
            } else {
            
                $ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
                $encript->encriptar($ruta_cesto,1);
                    
                $ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
                $encript->encriptar($ruta,1);
                
                $ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$datos_palabra['id_palabra'];
                $encript->encriptar($ruta_creador,1);
            
                //$ruta_img='size='.$img_big_size.'&ruta=../../'.$imagen;
				if (isset($_GET['arbol']) && $_GET['arbol']==0) {
					$ruta_img='size='.$img_big_size.'&ruta=../../'.$imagen;
					$img_size2=$img_big_size;
					
				} else { 
					$ruta_img='size='.$img_little_size.'&ruta=../../'.$imagen;
					$img_size2=$img_little_size;
				}
				
                $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL		
                echo '<img src="';
				
				if (file_exists('repositorio/thumbs/'.$tipo_pictograma.'/'.$img_size2.'/'.$row['imagen'][0].'/'.$row['imagen'])) { 
				echo 'repositorio/thumbs/'.$tipo_pictograma.'/'.$img_size2.'/'.$row['imagen'][0].'/'.$row['imagen']; 
				
				} else { 
				
				echo 'classes/img/thumbnail.php?i='.$ruta_img.'';
				}
				
				echo '" border="0" class="image" title="'.$word.'" align="left">';
                
                 $acciones='<div id="informacion_pictograma_ficha"><a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_3.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a> | <a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)"><img src=\'images/creador.png\' border="0" alt="'.$translate['creador_de_simbolos'].'" title="'.$translate['creador_de_simbolos'].'"></a>&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)">'.$translate['creador_de_simbolos'].'</a> | <a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_3.png\' border="0" alt="'.$translate['descargar_imagen'].'" title="'.$translate['descargar_imagen'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_imagen'].' ('.$peso.')</a></div>'; 
                
            }
            ?>
              <?php if ($row['id_tipo_imagen']!=11) { ?>
              <strong><?php echo $translate['tamanyo']; ?>:</b></strong><?php echo $imageX."x".$imageY; ?><br />
              <?php } ?>
      		  <strong><?php echo $translate['peso']; ?>:</b></strong><?php echo $peso; ?><br />
                    <b><?php echo $translate['autor']; ?></b>&nbsp;<?php echo utf8_encode($row['autor']); ?>&nbsp; &nbsp;
                    <?php if ($row['web_autor'] != '') { echo '<a href="'.$row['web_autor'].'" target="_blank"><img src="images/webexport.png" alt="'.$translate['visitar_pagina_web'].'" title="'.$translate['visitar_pagina_web'].'" border=0" /></a>'; } ?>
            &nbsp;
            <?php if ($row['email_autor'] != '') { echo '<a href="mailto:'.$row['email_autor'].'"><img src="images/mail_new.png" alt="'.$translate['enviar_email'].'" title="'.$translate['enviar_email'].'" border=0" /></a>'; } ?>
            <br />
            <b><?php echo $translate['licencia']; ?>:</b>
            <?php if ($row['logo_licencia'] != '') { echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.$row['licencia'].'" title="'.$row['licencia'].'" border="0" /></a>';  }?>
      </p><br />
            <?php 
                $result_lse=$query->buscar_acepcion_lse($datos_palabra['id_palabra']);
                $numrows_lse=mysql_num_rows($result_lse);
                 
                    if ($numrows_lse>0) {  
                        $r=1;
                            while ($row_lse=mysql_fetch_array($result_lse)) { 
                            echo '<a href="inc/public/ver_acepcion.php?i='.$row_lse['id_imagen'].'" target="_blank"><img src="images/acepcion_'.$r.'.jpg" alt="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" title="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" border=0" /></a>&nbsp;';
                            $r++;
                            }  
                    }
                
						if ($_SESSION['language']=='es') {
							echo '<b>'.utf8_encode($datos_palabra['palabra']).' ';
							$url='repositorio/locuciones/0/'.$datos_palabra['id_palabra'].'.mp3';
							echo insertar_locucion_castellano($encript,$datos_palabra,$cadena_url,$translate);						
							echo ': </b>'; 
							echo '<em>'.utf8_encode($datos_palabra['definicion']).'</em> <a a href="escuchar_locucion.php?palabra='.htmlentities($datos_palabra['definicion']).'" target="_blank" onClick="window.open(this.href, this.target, \'width=70,height=70\'); return false;"><img src=\'images/speaker.png\' alt="Escuchar definicion de '.utf8_encode($datos_palabra['palabra']).'" title="Escuchar definicion de '.utf8_encode($datos_palabra['palabra']).'"></a>';
							
						} elseif ($_SESSION['language']!='es') {
							
							switch ($_SESSION['language']) {
								case 'ar':
								$traduccion = $utfConverter->strToUtf8($datos_palabra['traduccion']);
								break;
								
								default:
								$traduccion= $datos_palabra['traduccion'];
								break;
								
							}
							
							echo '<b>'.$traduccion.'</b>';
							echo insertar_locucion_idioma($encript,$datos_palabra,$cadena_url,$translate);
							
								if ($datos_palabra['explicacion']!='') {	
									echo ': <em>'.$datos_palabra['explicacion'].'</em>';
								}
						} //Cierro el IF de com probacion de idioma
                  	                  
                        if (file_exists('repositorio/LSE_definiciones/'.$datos_palabra['id_palabra'].'.flv')) {
                        echo '&nbsp;<a href="inc/public/ver_definicion.php?i='.$datos_palabra['id_palabra'].'" target="_blank"><img src="images/icono_lse_13x13.jpg" alt="'.$translate['ver_definicion_lengua_signos'].'" title="'.$translate['ver_definicion_lengua_signos'].'" border=0" /></a>';
                        } 
                
                    
                echo '<br /><br />'; 
              
			    if (mysql_num_rows($asociadas) > 0) { 
                        if (mysql_num_rows($asociadas) == 1) { echo '<b>'.mysql_num_rows($asociadas).' '.$translate['palabra_asociada'].'</b><br />'; }
                        elseif (mysql_num_rows($asociadas) > 1){ echo '<b>'.mysql_num_rows($asociadas).' '.$translate['palabras_asociadas'].'</b><br />'; } 
                      } 
                while ($pa=mysql_fetch_array($asociadas)) {
                
                        $result_lse1=$query->buscar_acepcion_lse($pa['id_palabra']);
                        $numrows_lse1=mysql_num_rows($result_lse1);
                       
                        
                            if ($numrows_lse1>0) {
                                $e=1;
                                while ($row_lse1=mysql_fetch_array($result_lse1)) { 
                                    echo '<a href="inc/public/ver_acepcion.php?i='.$row_lse1['id_imagen'].'" target="_blank"><img src="images/acepcion_'.$e.'.jpg" alt="'.$translate['ver_traduccion_num'].''.$e.' '.$translate['en_lse'].'" title="'.$translate['ver_traduccion_num'].''.$e.' '.$translate['en_lse'].'" border=0" /></a>&nbsp;';
                                    $r++;
                                }  
                                     
                        
                        }
                       
					   	if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
							echo '<small><b>'.utf8_encode($pa['palabra']).' ';
							echo insertar_locucion_castellano($encript,$pa,$cadena_url,$translate);
							echo ': </b>'.utf8_encode($pa['definicion']).'</small> <a a href="escuchar_locucion.php?palabra='.htmlentities($pa['definicion']).'" target="_blank" onClick="window.open(this.href, this.target, \'width=70,height=70\'); return false;"></a>';
						} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
							$traduccion1=$query->buscar_traduccion($pa['id_palabra'],$_SESSION['id_language']);
							$n_pa=mysql_num_rows($traduccion1);
							
							if ($n_pa > 0) {
								$pa=mysql_fetch_array($traduccion1);
								echo '<small><b>'.$pa['traduccion'].'</b>';
								echo insertar_locucion_idioma($encript,$pa,$cadena_url,$translate);
									if ($pa['explicacion']!='') {
										echo ': '.$pa['explicacion'];
									}
								echo '</small>';
							}
							
						}
			                  
                  
                        if (file_exists('repositorio/LSE_definiciones/'.$pa['id_palabra'].'.flv')) {
                        echo '&nbsp;<a href="inc/public/ver_definicion.php?i='.$pa['id_palabra'].'" target="_blank"><img src="images/icono_lse_13x13.jpg" alt="'.$translate['ver_definicion_lengua_signos'].'" title="'.$translate['ver_definicion_lengua_signos'].'" border=0" /></a>';
                        } 

                  
                  echo '<br />';
                }
                ?>
                </p>
                  <p>
                    <?php 
                  $idiomas_disponibles=$query->idiomas_disponibles($id_palabra,1);
                   echo idiomas_disponibles_modo_texto_3($id_palabra,$idiomas_disponibles,$query,$encript,$cadena_url,$translate);
				  
				  if ($_SESSION['language']=='es') {
					  
					  echo '<br />
				    		<div style="clear:both;"><strong>Tags</strong></strong>:<br /><br />';

					  $tags=str_replace('}{',',',$row['tags_imagen']);
					  $tags=str_replace('{','',$tags);
					  $tags=str_replace('}','',$tags);
					  $tags=explode(',',$tags);
					  
					  for ($i=0;$i<count($tags);$i++) { 
						if ($tags[$i]!='') {
						 echo '<a href="nube_tags.php?palabra='.$tags[$i].'">'.$tags[$i].'</a> '; 
						}
					  }
					  echo '</div><br />';
				 }
			  
			  	
				
			  	if ($row['id_tipo_imagen']==11) { 
			   		echo '<div style="clear:both;"><b>'.$translate['embeber_video'].':</b><br /><textarea name="embebed" rows="3"><object width="310" height="325" data="http://catedu.es/arasaac/plugins/flowplayer/flowplayer-3.1.1.swf" type="application/x-shockwave-flash"><param name="movie" value="http://catedu.es/arasaac/plugins/flowplayer/flowplayer-3.1.1.swf" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="flashvars" value=\'config={"clip":{"url":"http://catedu.es/arasaac/repositorio/LSE_acepciones/'.$row['imagen'].'","bufferLength":"2","autoBuffering":"true","autoPlay":"false","scaling":"fit"},"play":{"replayLabel":"Repetir"},"plugins":{"controls":{"volume":false,"mute":false,"time":false,"height":15,"backgroundColor":"#FFFFFF","progressColor":"#000000","bufferColor":"#CCCCCC"}},"playlist":[{"url":"http://catedu.es/arasaac/repositorio/LSE_acepciones/'.$row['imagen'].'"}]}\' /></object></textarea></div>';
			   	}
				
			   echo '<br /><div style="border-top:1px solid #CCC; clear:both;"><br />'.$acciones.'</div>'; 
			   ?>
                  </div>
    </div>
</div>
     
<?php 
require('classes/utf8/utf8.class.php');

/***************************************************/
/*    CODIFICACION DIFERENTES IDIOMAS           */
/***************************************************/

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
define("ISO88592", MAP_DIR . "/ISO8859-2.MAP");

$utfConverter = new utf8(); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_cr = new utf8(); //defaults to CP1250.
$utfConverter_cr->loadCharset(CP1250);

$pictogramas_color=0;
$pictogramas_byn=0;
$fotografia=0;
$simbolos=0;
$videos_lse=0;
$lse_color=0;
$lse_byn=0;
$inicial=0;
$cantidad=10;
$idiomasearch=0;
$buscar_por=0;

foreach($_GET AS $key => $value) {
    ${$key} = $value;
}

if ($buscar_por==1) {

	if (isset($id_palabra)) { 
				
		if ($idiomasearch==0) {
			$datos_palabra=$query->datos_palabra($id_palabra);
			$palabra=utf8_encode($datos_palabra['palabra']);
		} elseif ($idiomasearch > 0) {
			$traduccion=$query->buscar_traduccion_por_id($id_palabra);
			$datos_traduccion=mysql_fetch_array($traduccion);
			
				switch ($idiomasearch) {
						
					case 1:
					$palabra=$utfConverter_ru->strToUtf8($datos_traduccion['traduccion']);
					break;
					
					case 5:
					$palabra=$utfConverter_ru->strToUtf8($datos_traduccion['traduccion']);
					break;
					
					case 3:
					$palabra=$utfConverter->strToUtf8($datos_traduccion['traduccion']);
					break;
					
					default:
					$palabra=$datos_traduccion['traduccion'];
					break;
						
				}
			
			
		}	
		
		if ($idiomasearch==0) {
			$resultados='<h4>'.$translate['resultados_para'].': "'.$palabra.'"</h4><br />';
		} elseif ($idiomasearch>0) {
			$resultados='<h4>'.$translate['resultados_para'].': "'.$palabra.'"</h4><br />';
		}
		
		$tipos_imagen=$query->listar_tipos_imagen_seleccionados($pictogramas_color,$pictogramas_byn,$fotografia,$videos_lse,$lse_color,$lse_byn);

		while ($salida=mysql_fetch_array($tipos_imagen)) {
			
			if ($idiomasearch==0) {
				$img_disponibles=$query->imagenes_disponibles_tipo_limit($id_palabra,$salida['id_tipo'],$inicial,$cantidad);
				$contar=$query->imagenes_disponibles_tipo_contar($id_palabra,$salida['id_tipo']);
			} elseif ($idiomasearch>0) {
				$img_disponibles=$query->imagenes_disponibles_idioma_tipo_limit($id_palabra,$salida['id_tipo'],$idiomasearch,$inicial,$cantidad);
				$contar=$query->imagenes_disponibles_idioma_tipo_contar($id_palabra,$salida['id_tipo'],$idiomasearch);
			}
		
		$num_resultados=$contar;
		
		// Inicializo las variables
		$o=0;
		$img=array();
		$file='';
		
		// Si el numero de resultados es mayor de 0 muestro los resultados
		if ($num_resultados > 0) {
		
			if ($salida['ext']=='flv') { 
				$resultados.='<br /><b>'.utf8_encode($salida['tipo_imagen_'.$_SESSION['language'].'']).'</b><hr>';
			} else { 
				$resultados.='<br /><b>'.utf8_encode($salida['tipo_imagen_'.$_SESSION['language'].'']).'</b><hr>';
			}
			
			$resultados.='<div id="ultimas_imagenes">
						     <ul id="thelist3"><div id="barra_opciones_superior">';
							 
							 
			if ($num_resultados > 10) {			 
				$resultados.='<strong>'.$translate['resultados'].': </strong>'.$inicial.' - '.$cantidad.' '.$translate['de'].' '.$num_resultados.' ';
			} else {
				$resultados.='<strong>'.$translate['resultados'].': </strong> '.$num_resultados.' ';
			}
			
			if ($salida['ext']=='flv') { 
				$resultados.=$translate['videos'];
			} elseif ($salida['ext']=='jpg') { 
				$resultados.=$translate['fotografias'];
			} else {
				$resultados.=$translate['pictogramas'];
			}
			
			if ($num_resultados > 10) {	
				$resultados.=' | <a href="'.$PHP_SELF.'?buscar_por=3&id_tipo='.$salida['id_tipo'].'&id_palabra='.$id_palabra.'&idiomasearch='.$idiomasearch.'">'.$translate['mostrar_todos_resultados'].'</a></div>';
			} else {
				$resultados.='</div>';
			}
			
			
				while ($row=mysql_fetch_array($img_disponibles)) {
		
					if ($salida['id_tipo']==11) { //Si el tipo de original es Video de Acepciones en LSE
						
						$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
						$archivo='repositorio/LSE_acepciones/'.$row['imagen'];
						$imagen='repositorio/LSE_acepciones/'.$row['imagen'];
						$extension = strtolower(substr(strrchr($imagen, "."), 1));
							
						$encript->encriptar($ruta_cesto,1);
					
						$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$idiomasearch;
						$encript->encriptar($ruta,1);
								
						$resultados.='<li><object id="'.$row['id_imagen'].'" width="110" height="125" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
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
						
						if ($idiomasearch > 0) {
				  
				  			switch ($idiomasearch) {
						
								case 1:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']); 
								break;
								
								case 5:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 3:
								$palabra=$utfConverter->strToUtf8($row['traduccion']);
								$word=$utfConverter->strToUtf8($row['traduccion']); 
								break;
									
								default:
								$word=$row['traduccion'];
								break;
									
							}
							
							
							$definition=$row['explicacion'];
							$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
							$resultados.=$word;
							
							$resultados.='</a>';
					  
						} else {
					  
							if (strlen($row['palabra']) > 15) { $word=substr(utf8_encode($row['palabra']),0,15).".."; } else { $word=utf8_encode($row['palabra']);  }
							$definition=$row['definicion'];
							$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
							$resultados.=$word;
							
							$resultados.='</a>';
					  
						}
						
						if (file_exists($archivo)) {
							$peso_archivo = filesize($archivo);
							$info=tamano_archivo($peso_archivo).'&nbsp;-&nbsp;'.$extension;
						}
									
							
			 		 $resultados.='<br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma">';
					 
					    if (file_exists('repositorio/LSE_definiciones/'.$row['id_palabra'].'.flv')) {
                        	$resultados.='<a href="inc/public/ver_definicion.php?i='.$row['id_palabra'].'" target="_blank"><img src="images/icono_lse_13x13.jpg" alt="'.$translate['ver_definicion_lengua_signos'].'" title="'.$translate['ver_definicion_lengua_signos'].'" border=0" /></a> <a href="inc/public/ver_definicion.php?i='.$row['id_palabra'].'" target="_blank">'.$translate['ver_definicion_lse'].'</a><br />';
                        } 
						
					 $resultados.='<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' border="0" alt="'.$translate['descargar_video'].'" title="'.$translate['descargar_video'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_video'].'</a>';
					 
				  	  if ($idiomasearch==0) {
						  $resultados.=insertar_locucion_castellano_resultados($encript,$row,$cadena_url,$translate);		  
					  } elseif ($idiomasearch > 0) {
						  $resultados.=insertar_locucion_idioma_resultados($encript,$row,$cadena_url,$translate);
					  }
			  
					 $resultados.='</div></li>';
					
					} else { //Para el resto de tipos de Originales							
							
					$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$idiomasearch;
					$encript->encriptar($ruta,1);
					
					$ruta_img='size='.$img_size.'&ruta=../../repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_cesto,1);
					
						if ($idiomasearch > 0) {
				  			switch ($idiomasearch) {
						
								case 1:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 5:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 3:
								$palabra=$utfConverter->strToUtf8($row['traduccion']);
								$word=$utfConverter->strToUtf8($row['traduccion']);
								break;
								
								case 16:
								$palabra=$row['id_traduccion'];
								$datos_traduccion=$query->datos_traduccion($row['id_traduccion'],16);
								$word=$datos_traduccion['traduccion'];
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
						
						$resultados.='<li><a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'"><img src="';
						if (file_exists('repositorio/thumbs/'.$row['id_tipo_imagen'].'/'.$img_size.'/'.$row['imagen'][0].'/'.$row['imagen'])) { 
							$resultados.='repositorio/thumbs/'.$row['id_tipo_imagen'].'/'.$img_size.'/'.$row['imagen'][0].'/'.$row['imagen']; 
									
						} else { 
									
							$resultados.='classes/img/thumbnail.php?i='.$ruta_img.'';
						
						}
						
						$resultados.='" alt="'.$translate['hacer_clic_para_acceder_a_la_ficha_de'].' '.$word.'';
						if (strlen($definition) > 100) { $resultados.=substr(utf8_encode($definition), 0, 100)."..."; } else { $resultados.=utf8_encode($definition); } 
						
						$resultados.='" border="0" class="image" title="'.$word.'';
						
						if (strlen($definition) > 100) { $resultados.=substr (utf8_encode($definition), 0, 100)."..."; } else { $resultados.=utf8_encode($definition); } 
						
                        $resultados.='" /></a><br />';
						
						$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;';
					
						$result_lse=$query->buscar_acepcion_lse($row['id_palabra']);
						$numrows_lse=mysql_num_rows($result_lse);
						 
							if ($numrows_lse>0) {  
								$r=1;
									while ($row_lse=mysql_fetch_array($result_lse)) { 
									$resultados.='<a href="inc/public/ver_acepcion.php?i='.$row_lse['id_imagen'].'" target="_blank"><img src="images/acepcion_'.$r.'.jpg" alt="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" title="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" border=0" /></a>&nbsp;';
									$r++;
									}  
							}
							
					  $resultados.='<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
					  
					  $resultados.=$word;
					  
					  $resultados.='</a>';
		
					 /* ALTERNATIVA CUANDO SE TRASLADE A HERRAMIENTAS*/
					 
					  $ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
					  $encript->encriptar($ruta_creador,1); 
						
					  $resultados.='<br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma">';
					  			  
					  $resultados.='<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)"><img src=\'images/paint.gif\' border="0" alt="'.$translate['creador_de_simbolos'].'" title="'.$translate['creador_de_simbolos'].'"></a>&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)">'.$translate['creador_de_simbolos'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' border="0" alt="'.$translate['descargar_imagen'].'" title="'.$translate['descargar_imagen'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_imagen'].'</a>';
					  
					  if ($idiomasearch==0) {
						  $resultados.=insertar_locucion_castellano_resultados($encript,$row,$cadena_url,$translate);
					  } elseif ($idiomasearch > 0) {
						  $resultados.=insertar_locucion_idioma_resultados($encript,$row,$cadena_url,$translate);		
					  }
			  
					 $resultados.='</div></li>';
								 
					}		

				}
				
						$resultados.='</ul>';
				   $resultados.='</div>';
				 
		
			} 
		
			
		} // Cierro el While 
		
		$resultados.='<br /><input name="boton_seleccionar_todos" type="button" value="'.$translate['seleccionar_todos'].'" class="boton_mediano" onclick="selydestodos(document.descarga_pictogramas,1)"/>  
 
<input name="boton_seleccionar_todos" type="button" value="'.$translate['deseleccionar_todos'].'" class="boton_mediano" onclick="selydestodos(document.descarga_pictogramas,0)"/>

		<input name="boton_descargar" type="submit" value="'.$translate['add_archivos_mi_seleccion'].'" class="boton_mediano"/><br />';
		
		
	} elseif (isset($s)) {
		
		$resultados='<h4>'.$translate['resultados_para'].': "'.$s.'"</h4><br />';
		
		$tipos_imagen=$query->listar_tipos_imagen_seleccionados($pictogramas_color,$pictogramas_byn,$fotografia,$videos_lse,$lse_color,$lse_byn);

		while ($salida=mysql_fetch_array($tipos_imagen)) {
		
			if ($idiomasearch==0) {
				$img_disponibles=$query->imagenes_disponibles_tipo_por_palabra_limit($s,$salida['id_tipo'],$inicial,$cantidad);
				$contar=$query->imagenes_disponibles_tipo_por_palabra_contar($s,$salida['id_tipo']);
			
			} elseif ($idiomasearch>0) {
				
				switch ($idiomasearch) {
						case 1: //Ruso
						$s=$utfConverter_ru->utf8ToStr($_GET['s']);
						break;
						
						case 5: //Bulgaro
						$s=$utfConverter_ru->utf8ToStr($_GET['s']);
						break;
						
						case 3: //Arabe
						$s=$utfConverter->utf8ToStr($_GET['s']);
						break;
						
						default:
						break;
						
					}
					
				$img_disponibles=$query->imagenes_disponibles_idioma_tipo_por_palabra_limit($s,$salida['id_tipo'],$idiomasearch,$inicial,$cantidad);
				$contar=$query->imagenes_disponibles_idioma_tipo_por_palabra_contar($s,$salida['id_tipo'],$idiomasearch);
			}
		
		$num_resultados=$contar;
		
		// Inicializo las variables
		$o=0;
		$img=array();
		$file='';
		
		// Si el numero de resultados es mayor de 0 muestro los resultados
		if ($num_resultados > 0) {
		
			if ($salida['ext']=='flv') { 
				$resultados.='<br /><b>'.utf8_encode($salida['tipo_imagen_'.$_SESSION['language'].'']).'</b><hr>';
			} else { 
				$resultados.='<br /><b>'.utf8_encode($salida['tipo_imagen_'.$_SESSION['language'].'']).'</b><hr>';
			}
			
			$resultados.='<div id="ultimas_imagenes">
						     <ul id="thelist3"><div id="barra_opciones_superior">';
							 
			if ($num_resultados > 10) {			 
				$resultados.='<strong>'.$translate['resultados'].': </strong>'.$inicial.' - '.$cantidad.' '.$translate['de'].' '.$num_resultados.' ';
			} else {
				$resultados.='<strong>'.$translate['resultados'].': </strong> '.$num_resultados.' ';
			}
			
			if ($salida['ext']=='flv') { 
				$resultados.=$translate['videos'];
			} elseif ($salida['ext']=='jpg') { 
				$resultados.=$translate['fotografias'];
			} else {
				$resultados.=$translate['pictogramas'];
			}
			
			if ($num_resultados > 10) {
				$resultados.=' | <a href="'.$PHP_SELF.'?buscar_por=3&id_tipo='.$salida['id_tipo'].'&s='.$_GET['s'].'&idiomasearch='.$idiomasearch.'">'.$translate['mostrar_todos_resultados'].'</a></div>';
			} else {
				$resultados.='</div>';
			}
			
				while ($row=mysql_fetch_array($img_disponibles)) {
		
					if ($salida['id_tipo']==11) { //Si el tipo de original es Video de Acepciones en LSE
						
						$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
						$archivo='repositorio/LSE_acepciones/'.$row['imagen'];
						$imagen='repositorio/LSE_acepciones/'.$row['imagen'];
						$extension = strtolower(substr(strrchr($imagen, "."), 1));
							
						$encript->encriptar($ruta_cesto,1);
					
						$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$idiomasearch;
						$encript->encriptar($ruta,1);
								
						$resultados.='<li><object id="'.$row['id_imagen'].'" width="110" height="125" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
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
						
						if ($idiomasearch > 0) {
				  
							switch ($idiomasearch) {
						
								case 1:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 5:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 3:
								$palabra=$utfConverter->strToUtf8($row['traduccion']);
								$word=$utfConverter->strToUtf8($row['traduccion']);
								break;
								
								default:
								$word=$row['traduccion'];
								break;
									
							}
							
							$definition=$row['explicacion'];
							$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
						
						if ($resaltar->CheckSentence($word,$_GET['s'])=='') { 
							$resultados.=$word;
						} else {
							if ($idiomasearch==0) {
								$resultados.=$resaltar->CheckSentence($word,$_GET['s']);
							} elseif ($idiomasearch > 0) {
								if ($resaltar_idiomas->CheckSentence_idiomas($word,$_GET['s'])=="") {
								  $resultados.=$word;
								} else {
								  $resultados.=$resaltar_idiomas->CheckSentence_idiomas($word,$_GET['s']);
								}
							}
						}
							
							$resultados.='</a>';
					  
						} else {
					  
							if (strlen($row['palabra']) > 15) { $word=substr(utf8_encode($row['palabra']),0,15).".."; } else { $word=utf8_encode($row['palabra']);  }
							$definition=$row['definicion'];
							$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
							if ($resaltar->CheckSentence($word,$_GET['s'])=='') { 
								$resultados.=$word;
							} else {
								$resultados.=$resaltar->CheckSentence($word,$_GET['s']);
							}
							
							$resultados.='</a>';
					  
						}
						
						if (file_exists($archivo)) {
							$peso_archivo = filesize($archivo);
							$info=tamano_archivo($peso_archivo).'&nbsp;-&nbsp;'.$extension;
						}
									
							
			 		 $resultados.='<br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma">';
					 						
					 $resultados.='<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' border="0" alt="'.$translate['descargar_video'].'" title="'.$translate['descargar_video'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_video'].'</a>';
					 
					  if ($idiomasearch==0) {
						  $resultados.=insertar_locucion_castellano_resultados($encript,$row,$cadena_url,$translate);
					  } elseif ($idiomasearch > 0) {
						  $resultados.=insertar_locucion_idioma_resultados($encript,$row,$cadena_url,$translate);		
					  }
			  
					 $resultados.='</div></li>';
					
					} else { //Para el resto de tipos de Originales							
							
					$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$idiomasearch;
					$encript->encriptar($ruta,1);
					
					$ruta_img='size='.$img_size.'&ruta=../../repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_cesto,1);
					
						if ($idiomasearch > 0) {
				  
							switch ($idiomasearch) {
						
								case 1:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 5:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 3:
								$palabra=$utfConverter->strToUtf8($row['traduccion']);
								$word=$utfConverter->strToUtf8($row['traduccion']);
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
						
						$resultados.='<li><a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'"><img src="';
						if (file_exists('repositorio/thumbs/'.$row['id_tipo_imagen'].'/'.$img_size.'/'.$row['imagen'][0].'/'.$row['imagen'])) { 
							$resultados.='repositorio/thumbs/'.$row['id_tipo_imagen'].'/'.$img_size.'/'.$row['imagen'][0].'/'.$row['imagen']; 
									
						} else { 
									
							$resultados.='classes/img/thumbnail.php?i='.$ruta_img.'';
						
						}
						
						$resultados.='" alt="'.$translate['hacer_clic_para_acceder_a_la_ficha_de'].' '.$word.'';
						if (strlen($definition) > 100) { $resultados.=substr(utf8_encode($definition), 0, 100)."..."; } else { $resultados.=utf8_encode($definition); } 
						
						$resultados.='" border="0" class="image" title="'.$word.'';
						
						if (strlen($definition) > 100) { $resultados.=substr(utf8_encode($definition), 0, 100)."..."; } else { $resultados.=utf8_encode($definition); } 
						
                        $resultados.='" /></a><br />';
						
						$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;';
					
						$result_lse=$query->buscar_acepcion_lse($row['id_palabra']);
						$numrows_lse=mysql_num_rows($result_lse);
						 
							if ($numrows_lse>0) {  
								$r=1;
									while ($row_lse=mysql_fetch_array($result_lse)) { 
									$resultados.='<a href="inc/public/ver_acepcion.php?i='.$row_lse['id_imagen'].'" target="_blank"><img src="images/acepcion_'.$r.'.jpg" alt="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" title="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" border=0" /></a>&nbsp;';
									$r++;
									}  
							}
							
					  $resultados.='<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
					  
					  if ($resaltar->CheckSentence($word,$_GET['s'])=='') { 
							$resultados.=$word;
						} else {
							if ($idiomasearch==0) {
								$resultados.=$resaltar->CheckSentence($word,$_GET['s']);
							} elseif ($idiomasearch > 0) {
								if ($resaltar_idiomas->CheckSentence_idiomas($word,$_GET['s'])=="") {
								  $resultados.=$word;
								} else {
								  $resultados.=$resaltar_idiomas->CheckSentence_idiomas($word,$_GET['s']);
								}
							}
						}
					  
					  $resultados.='</a>';
		
					 /* ALTERNATIVA CUANDO SE TRASLADE A HERRAMIENTAS*/
					 
					  $ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
					  $encript->encriptar($ruta_creador,1); 
						
					  $resultados.='<br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma"><a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)"><img src=\'images/paint.gif\' border="0" alt="'.$translate['creador_de_simbolos'].'" title="'.$translate['creador_de_simbolos'].'"></a>&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)">'.$translate['creador_de_simbolos'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' border="0" alt="'.$translate['descargar_imagen'].'" title="'.$translate['descargar_imagen'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_imagen'].'</a>';
					  
					  if ($idiomasearch==0) {
						  $resultados.=insertar_locucion_castellano_resultados($encript,$row,$cadena_url,$translate);
					  } elseif ($idiomasearch > 0) {
						  $resultados.=insertar_locucion_idioma_resultados($encript,$row,$cadena_url,$translate);		
					  }
			  
					 $resultados.='</div></li>';
								 
					}		

				}
				
						$resultados.='</ul>';
				   $resultados.='</div>';
				 
		
			} 
		
			
		} // Cierro el While 
		
		$resultados.='<br /><input name="boton_seleccionar_todos" type="button" value="'.$translate['seleccionar_todos'].'" class="boton_mediano" onclick="selydestodos(document.descarga_pictogramas,1)"/>  
 
<input name="boton_seleccionar_todos" type="button" value="'.$translate['deseleccionar_todos'].'" class="boton_mediano" onclick="selydestodos(document.descarga_pictogramas,0)"/>

<input name="boton_descargar" type="submit" value="'.$translate['add_archivos_mi_seleccion'].'" class="boton_mediano"/><br />';
		
	}
	
	
} elseif($buscar_por==3) {
	
	if (!isset($pg)) {
		$pg = 0; // $pg es la pagina actual
	} 
	
	$cantidad=18;
	$inicial = $pg * $cantidad;
					
	$limite_inferior="5"; //resultados por debajo de la pagina actual
	$page_limit = $limite_inferior;
					
	$limitpages = $page_limit;
	$page_limit = $pg + $limitpages;
	
	if (isset($id_palabra)) { 
				
		if ($idiomasearch==0) {
			$datos_palabra=$query->datos_palabra($id_palabra);
			$palabra=utf8_encode($datos_palabra['palabra']);
		} elseif ($idiomasearch>0) {
			$traduccion=$query->buscar_traduccion_por_id($id_palabra);
			$datos_traduccion=mysql_fetch_array($traduccion);
				
				switch ($idiomasearch) {
						
					case 1:
					$palabra=$utfConverter_ru->strToUtf8($datos_traduccion['traduccion']);
					break;
					
					case 5:
					$palabra=$utfConverter_ru->strToUtf8($datos_traduccion['traduccion']);
					break;
					
					case 3:
					$palabra=$utfConverter->strToUtf8($datos_traduccion['traduccion']);
					break;
					
					default:
					$palabra=$datos_traduccion['traduccion'];
					break;
						
				}
		}	
		
		$row_tipo=$query->datos_tipo_imagen($id_tipo);
		
		$resultados='<h4>'.$translate['resultados_para'].': "'.$palabra.'" '.$translate['en'].' '.$row_tipo['tipo_imagen_'.$_SESSION['language'].''].'</h4><br />';
		
			if ($idiomasearch==0) {
				$img_disponibles=$query->imagenes_disponibles_tipo_limit($id_palabra,$id_tipo,$inicial,$cantidad);
				$contar=$query->imagenes_disponibles_tipo_contar($id_palabra,$id_tipo);
			} elseif ($idiomasearch>0) {
				$img_disponibles=$query->imagenes_disponibles_idioma_tipo_limit($id_palabra,$id_tipo,$idiomasearch,$inicial,$cantidad);
				$contar=$query->imagenes_disponibles_idioma_tipo_contar($id_palabra,$id_tipo,$idiomasearch);
			}
		
		$num_resultados=$contar;
		$total_records =$contar;
		$total_pages = intval($total_records / $cantidad);
		
		// Inicializo las variables
		$o=0;
		$img=array();
		$file='';
		
		// Si el numero de resultados es mayor de 0 muestro los resultados
		if ($num_resultados > 0) {
		
			if ($salida['ext']=='flv') { 
				$resultados.='<br /><b>'.utf8_encode($salida['tipo_imagen_'.$_SESSION['language'].'']).'</b><hr>';
			} else { 
				$resultados.='<br /><b>'.utf8_encode($salida['tipo_imagen_'.$_SESSION['language'].'']).'</b><hr>';
			}
			
			$resultados.='<div id="ultimas_imagenes">
						     <ul id="thelist3"><div id="barra_opciones_superior">';
							 
							 
			if ($num_resultados > 10) {			 
				$resultados.='<strong>'.$translate['resultados'].': </strong>'.$inicial.' - '.($inicial+$cantidad).' '.$translate['de'].' '.$num_resultados.' ';
			} else {
				$resultados.='<strong>'.$translate['resultados'].': </strong> '.$num_resultados.' ';
			}
			
			if ($salida['ext']=='flv') { 
				$resultados.=$translate['videos'];
			} elseif ($salida['ext']=='jpg') { 
				$resultados.=$translate['fotografias'];
			} else {
				$resultados.=$translate['pictogramas'];
			}
			
			$resultados.='</div>';
		
			
				while ($row=mysql_fetch_array($img_disponibles)) {
		
					if ($salida['id_tipo']==11) { //Si el tipo de original es Video de Acepciones en LSE
						
						$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
						$archivo='repositorio/LSE_acepciones/'.$row['imagen'];
						$imagen='repositorio/LSE_acepciones/'.$row['imagen'];
						$extension = strtolower(substr(strrchr($imagen, "."), 1));
							
						$encript->encriptar($ruta_cesto,1);
					
						$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$idiomasearch;
						$encript->encriptar($ruta,1);
								
						$resultados.='<li><object id="'.$row['id_imagen'].'" width="110" height="125" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
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
						
						if ($idiomasearch > 0) {
				  
							switch ($idiomasearch) {
						
								case 1:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
									
								case 5:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 3:
								$palabra=$utfConverter->strToUtf8($row['traduccion']);
								$word=$utfConverter->strToUtf8($row['traduccion']);
								break;
								
								default:
								$word=$row['traduccion'];
								break;
									
							}
							
							$definition=$row['explicacion'];
							$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
							$resultados.=$word;
							
							$resultados.='</a>';
					  
						} else {
					  
							if (strlen($row['palabra']) > 15) { $word=substr(utf8_encode($row['palabra']),0,15).".."; } else { $word=utf8_encode($row['palabra']);  }
							$definition=$row['definicion'];
							$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
							$resultados.=$word;
							
							$resultados.='</a>';
					  
						}
						
						if (file_exists($archivo)) {
							$peso_archivo = filesize($archivo);
							$info=tamano_archivo($peso_archivo).'&nbsp;-&nbsp;'.$extension;
						}
									
							
			 		 $resultados.='<br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma">';
					 
					    if (file_exists('repositorio/LSE_definiciones/'.$row['id_palabra'].'.flv')) {
                        	$resultados.='<a href="inc/public/ver_definicion.php?i='.$row['id_palabra'].'" target="_blank"><img src="images/icono_lse_13x13.jpg" alt="'.$translate['ver_definicion_lengua_signos'].'" title="'.$translate['ver_definicion_lengua_signos'].'" border=0" /></a> <a href="inc/public/ver_definicion.php?i='.$row['id_palabra'].'" target="_blank">'.$translate['ver_definicion_lse'].'</a><br />';
                        } 
						
					 $resultados.='<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' border="0" alt="'.$translate['descargar_video'].'" title="'.$translate['descargar_video'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_video'].'</a>';
					 
					  if ($idiomasearch==0) {
						  $resultados.=insertar_locucion_castellano_resultados($encript,$row,$cadena_url,$translate);
					  } elseif ($idiomasearch > 0) {
						  $resultados.=insertar_locucion_idioma_resultados($encript,$row,$cadena_url,$translate);		
					  }
						
					 $resultados.='</div></li>';
					
					} else { //Para el resto de tipos de Originales							
							
					$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$idiomasearch;
					$encript->encriptar($ruta,1);
					
					$ruta_img='size='.$img_size.'&ruta=../../repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_cesto,1);
					
						if ($idiomasearch > 0) {
				  
							switch ($idiomasearch) {
						
								case 1:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 5:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 3:
								$palabra=$utfConverter->strToUtf8($row['traduccion']);
								$word=$utfConverter->strToUtf8($row['traduccion']);
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
						
						$resultados.='<li><a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'"><img src="';
						if (file_exists('repositorio/thumbs/'.$row['id_tipo_imagen'].'/'.$img_size.'/'.$row['imagen'][0].'/'.$row['imagen'])) { 
							$resultados.='repositorio/thumbs/'.$row['id_tipo_imagen'].'/'.$img_size.'/'.$row['imagen'][0].'/'.$row['imagen']; 
									
						} else { 
									
							$resultados.='classes/img/thumbnail.php?i='.$ruta_img.'';
						
						}
						
						$resultados.='" alt="'.$translate['hacer_clic_para_acceder_a_la_ficha_de'].' '.$word.'';
						if (strlen($definition) > 100) { $resultados.=substr(utf8_encode($definition), 0, 100)."..."; } else { $resultados.=utf8_encode($definition); } 
						
						$resultados.='" border="0" class="image" title="'.$word.'';
						
						if (strlen($definition) > 100) { $resultados.=substr (utf8_encode($definition), 0, 100)."..."; } else { $resultados.=utf8_encode($definition); } 
						
                        $resultados.='" /></a><br />';
						
						$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;';
					
						$result_lse=$query->buscar_acepcion_lse($row['id_palabra']);
						$numrows_lse=mysql_num_rows($result_lse);
						 
							if ($numrows_lse>0) {  
								$r=1;
									while ($row_lse=mysql_fetch_array($result_lse)) { 
									$resultados.='<a href="inc/public/ver_acepcion.php?i='.$row_lse['id_imagen'].'" target="_blank"><img src="images/acepcion_'.$r.'.jpg" alt="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" title="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" border=0" /></a>&nbsp;';
									$r++;
									}  
							}
							
					  $resultados.='<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
					  
					  $resultados.=$word;
					  
					  $resultados.='</a>';
		
					 /* ALTERNATIVA CUANDO SE TRASLADE A HERRAMIENTAS*/
					 
					  $ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
					  $encript->encriptar($ruta_creador,1); 
						
					  $resultados.='<br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma"><a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)"><img src=\'images/paint.gif\' border="0" alt="'.$translate['creador_de_simbolos'].'" title="'.$translate['creador_de_simbolos'].'"></a>&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)">'.$translate['creador_de_simbolos'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' border="0" alt="'.$translate['descargar_imagen'].'" title="'.$translate['descargar_imagen'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_imagen'].'</a>';
					  
					  if ($idiomasearch==0) {
						  $resultados.=insertar_locucion_castellano_resultados($encript,$row,$cadena_url,$translate);
					  } elseif ($idiomasearch > 0) {
						  $resultados.=insertar_locucion_idioma_resultados($encript,$row,$cadena_url,$translate);		
					  }

					 $resultados.='</div></li>';
								 
					}		

				}
							require('numeracion_inferior_buscador_general.php');
						$resultados.='</ul>';
				   $resultados.='</div>';
				 
		
			} 
		
		
		$resultados.='<br /><input name="boton_seleccionar_todos" type="button" value="'.$translate['seleccionar_todos'].'" class="boton_mediano" onclick="selydestodos(document.descarga_pictogramas,1)"/>  
 
<input name="boton_seleccionar_todos" type="button" value="'.$translate['deseleccionar_todos'].'" class="boton_mediano" onclick="selydestodos(document.descarga_pictogramas,0)"/>

<input name="boton_descargar" type="submit" value="'.$translate['add_archivos_mi_seleccion'].'" class="boton_mediano"/><br />';
		$resultados.=$content;
		
		
	} elseif (isset($s)) {
		
		$row_tipo=$query->datos_tipo_imagen($id_tipo);
		$resultados.='<h4>'.$translate['resultados_para'].': "'.$s.'" '.$translate['en'].' '.$row_tipo['tipo_imagen_'.$_SESSION['language'].''].'</h4><br />';
		
			if ($idiomasearch==0) {
				$img_disponibles=$query->imagenes_disponibles_tipo_por_palabra_limit($s,$id_tipo,$inicial,$cantidad);
				$contar=$query->imagenes_disponibles_tipo_por_palabra_contar($s,$id_tipo);
			} elseif ($idiomasearch>0) {
					
					switch ($idiomasearch) {
						case 1: //Ruso
						$s=$utfConverter_ru->utf8ToStr($_GET['s']);
						break;
						
						case 5: //Bulgaro
						$s=$utfConverter_ru->utf8ToStr($_GET['s']);
						break;
						
						case 3: //Arabe
						$s=$utfConverter->utf8ToStr($_GET['s']);
						break;
						
						default:
						break;
						
					}
					
				$img_disponibles=$query->imagenes_disponibles_idioma_tipo_por_palabra_limit($s,$id_tipo,$idiomasearch,$inicial,$cantidad);
				$contar=$query->imagenes_disponibles_idioma_tipo_por_palabra_contar($s,$id_tipo,$idiomasearch);
			}
		
		$num_resultados=$contar;
		$total_records =$contar;
		$total_pages = intval($total_records / $cantidad);
		
		// Inicializo las variables
		$o=0;
		$img=array();
		$file='';
		
		// Si el numero de resultados es mayor de 0 muestro los resultados
		if ($num_resultados > 0) {
		
			if ($salida['ext']=='flv') { 
				$resultados.='<br /><b>'.utf8_encode($salida['tipo_imagen_'.$_SESSION['language'].'']).'</b><hr>';
			} else { 
				$resultados.='<br /><b>'.utf8_encode($salida['tipo_imagen_'.$_SESSION['language'].'']).'</b><hr>';
			}
			
			$resultados.='<div id="ultimas_imagenes">
						     <ul id="thelist3"><div id="barra_opciones_superior">';
							 
			if ($num_resultados > 10) {			 
				$resultados.='<strong>'.$translate['resultados'].': </strong>'.$inicial.' - '.($inicial+$cantidad).' '.$translate['de'].' '.$num_resultados.' ';
			} else {
				$resultados.='<strong>'.$translate['resultados'].': </strong> '.$num_resultados.' ';
			}
			
			if ($salida['ext']=='flv') { 
				$resultados.=$translate['videos'];
			} elseif ($salida['ext']=='jpg') { 
				$resultados.=$translate['fotografias'];
			} else {
				$resultados.=$translate['pictogramas'];
			}
			
			$resultados.='</div>';
			
				while ($row=mysql_fetch_array($img_disponibles)) {
		
					if ($_GET['id_tipo']==11) { //Si el tipo de original es Video de Acepciones en LSE
						
						$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
						$archivo='repositorio/LSE_acepciones/'.$row['imagen'];
						$imagen='repositorio/LSE_acepciones/'.$row['imagen'];
						$extension = strtolower(substr(strrchr($imagen, "."), 1));
							
						$encript->encriptar($ruta_cesto,1);
					
						$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$idiomasearch;
						$encript->encriptar($ruta,1);
								
						$resultados.='<li><object id="'.$row['id_imagen'].'" width="110" height="125" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
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
						
						if ($idiomasearch > 0) {
				  
							switch ($idiomasearch) {
						
								case 1:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 5:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 3:
								$palabra=$utfConverter->strToUtf8($row['traduccion']);
								$word=$utfConverter->strToUtf8($row['traduccion']);
								break;
								
								default:
								$word=$row['traduccion'];
								break;
									
							}
							
							$definition=$row['explicacion'];
							$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
							if ($resaltar->CheckSentence($word,$_GET['s'])=='') { 
								$resultados.=$word;
							} else {
								$resultados.=$resaltar->CheckSentence($word,$_GET['s']);
							}
							
							$resultados.='</a>';
					  
						} else {
					  
							if (strlen($row['palabra']) > 15) { $word=substr(utf8_encode($row['palabra']),0,15).".."; } else { $word=utf8_encode($row['palabra']);  }
							$definition=$row['definicion'];
							$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
							if ($resaltar->CheckSentence($word,$_GET['s'])=='') { 
								$resultados.=$word;
							} else {
								$resultados.=$resaltar->CheckSentence($word,$_GET['s']);
							}
							
							$resultados.='</a>';
					  
						}
						
						if (file_exists($archivo)) {
							$peso_archivo = filesize($archivo);
							$info=tamano_archivo($peso_archivo).'&nbsp;-&nbsp;'.$extension;
						}
									
							
			 		 $resultados.='<br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma">';
					 
					    if (file_exists('repositorio/LSE_definiciones/'.$row['id_palabra'].'.flv')) {
                        	$resultados.='<a href="inc/public/ver_definicion.php?i='.$row['id_palabra'].'" target="_blank"><img src="images/icono_lse_13x13.jpg" alt="'.$translate['ver_definicion_lengua_signos'].'" title="'.$translate['ver_definicion_lengua_signos'].'" border=0" /></a> <a href="inc/public/ver_definicion.php?i='.$row['id_palabra'].'" target="_blank">'.$translate['ver_definicion_lse'].'</a><br />';
                        } 
					 						
					 $resultados.='<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' border="0" alt="'.$translate['descargar_video'].'" title="'.$translate['descargar_video'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_video'].'</a>';
					 
					  if ($idiomasearch==0) {
						  $resultados.=insertar_locucion_castellano_resultados($encript,$row,$cadena_url,$translate);
					  } elseif ($idiomasearch > 0) {
						  $resultados.=insertar_locucion_idioma_resultados($encript,$row,$cadena_url,$translate);		
					  }
			  
					 $resultados.='</div></li>';
					
					} else { //Para el resto de tipos de Originales							
							
					$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$idiomasearch;
					$encript->encriptar($ruta,1);
					
					$ruta_img='size='.$img_size.'&ruta=../../repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_cesto,1);
					
						if ($idiomasearch > 0) {
				  
							switch ($idiomasearch) {
						
								case 1:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 5:
								$palabra=$utfConverter_ru->strToUtf8($row['traduccion']);
								$word=$utfConverter_ru->strToUtf8($row['traduccion']);
								break;
								
								case 3:
								$palabra=$utfConverter->strToUtf8($row['traduccion']);
								$word=$utfConverter->strToUtf8($row['traduccion']);
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
						
						$resultados.='<li><a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'"><img src="';
						if (file_exists('repositorio/thumbs/'.$row['id_tipo_imagen'].'/'.$img_size.'/'.$row['imagen'][0].'/'.$row['imagen'])) { 
							$resultados.='repositorio/thumbs/'.$row['id_tipo_imagen'].'/'.$img_size.'/'.$row['imagen'][0].'/'.$row['imagen']; 
									
						} else { 
									
							$resultados.='classes/img/thumbnail.php?i='.$ruta_img.'';
						
						}
						
						$resultados.='" alt="'.$translate['hacer_clic_para_acceder_a_la_ficha_de'].' '.$word.'';
						if (strlen($definition) > 100) { $resultados.=substr(utf8_encode($definition), 0, 100)."..."; } else { $resultados.=utf8_encode($definition); } 
						
						$resultados.='" border="0" class="image" title="'.$word.'';
						
						if (strlen($definition) > 100) { $resultados.=substr (utf8_encode($definition), 0, 100)."..."; } else { $resultados.=utf8_encode($definition); } 
						
                        $resultados.='" /></a><br />';
						
						$resultados.='<input name="file[]" type="checkbox" value="'.$ruta_cesto.'" />&nbsp;';
					
						$result_lse=$query->buscar_acepcion_lse($row['id_palabra']);
						$numrows_lse=mysql_num_rows($result_lse);
						 
							if ($numrows_lse>0) {  
								$r=1;
									while ($row_lse=mysql_fetch_array($result_lse)) { 
									$resultados.='<a href="inc/public/ver_acepcion.php?i='.$row_lse['id_imagen'].'" target="_blank"><img src="images/acepcion_'.$r.'.jpg" alt="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" title="'.$translate['ver_traduccion_num'].''.$r.' '.$translate['en_lse'].'" border=0" /></a>&nbsp;';
									$r++;
									}  
							}
							
					  $resultados.='<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
					  
					  if ($resaltar->CheckSentence($word,$_GET['s'])=='') { 
								$resultados.=$word;
						} else {
							if ($idiomasearch==0) {
								$resultados.=$resaltar->CheckSentence($word,$_GET['s']);
							} elseif ($idiomasearch > 0) {
								$resultados.=$resaltar_idiomas->CheckSentence_idiomas($word,$_GET['s']);
							}
						}
					  
					  $resultados.='</a>';
		
					 /* ALTERNATIVA CUANDO SE TRASLADE A HERRAMIENTAS*/
					 
					  $ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
					  $encript->encriptar($ruta_creador,1); 
						
					  $resultados.='<br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma"><a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)"><img src=\'images/paint.gif\' border="0" alt="'.$translate['creador_de_simbolos'].'" title="'.$translate['creador_de_simbolos'].'"></a>&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_simbolos'].'\', this.href)">'.$translate['creador_de_simbolos'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' border="0" alt="'.$translate['descargar_imagen'].'" title="'.$translate['descargar_imagen'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_imagen'].'</a>';
					  
					  if ($idiomasearch==0) {
						  $resultados.=insertar_locucion_castellano_resultados($encript,$row,$cadena_url,$translate);
					  } elseif ($idiomasearch > 0) {
						  $resultados.=insertar_locucion_idioma_resultados($encript,$row,$cadena_url,$translate);		
					  }

					 $resultados.='</div></li>';
								 
					}		

				}
							require('numeracion_inferior_buscador_general.php');
						$resultados.='</ul>';
				   $resultados.='</div>';
				 
		
			} 
		
		
		$resultados.='<br /><input name="boton_seleccionar_todos" type="button" value="'.$translate['seleccionar_todos'].'" class="boton_mediano" onclick="selydestodos(document.descarga_pictogramas,1)"/>  
 
<input name="boton_seleccionar_todos" type="button" value="'.$translate['deseleccionar_todos'].'" class="boton_mediano" onclick="selydestodos(document.descarga_pictogramas,0)"/>

<input name="boton_descargar" type="submit" value="'.$translate['add_archivos_mi_seleccion'].'" class="boton_mediano"/><br />';

		$resultados.=$content;
		
	}

}

?>
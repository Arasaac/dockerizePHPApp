<?php 
session_start();

include ('../../classes/querys/query.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');
include ('../../funciones/funciones.php');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$id_imagen=$_POST['id_imagen'];	
$id_palabra=$_POST['id_palabra'];	

$query=new query();
$row=$query->datos_imagen($id_imagen);
$datos_palabra=$query->datos_palabra($id_palabra);
//$estadisticas=$query->imagen_numero_visitas($id_imagen); //SE ANULA AL HABER ELIMINADO EL CAMPO VECES_VISTO EN LA TABLA IMAGENES
$asociadas=$query->palabras_asociadas($id_imagen,$id_palabra);
$imagen='../../repositorio/originales/'.$row['imagen'];

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

				
?>
<h4><?php echo $row['palabra']; ?></h4><br  />
<div style="border: 1px solid #CCCCCC; padding:20px; float:left; width:35%; margin-bottom:20px;" align="center";>
<?php 
if ($row['id_tipo_imagen']==11) { 

	$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
	$encript->encriptar($ruta_cesto,1);
					
	$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$datos_palabra['id_palabra'];
	$encript->encriptar($ruta,1);	

		echo '<object id="'.$row['id_imagen'].'" width="310" height="325" data="http://catedu.es/arasaac/plugins/flowplayer/flowplayer-3.1.1.swf"  
					type="application/x-shockwave-flash"> 
					 <param name="wmode" value="transparent">
					<param name="movie" value="http://catedu.es/arasaac/plugins/flowplayer/flowplayer-3.1.1.swf" />  
					<param name="allowfullscreen" value="true" /> 
					 
					<param name="flashvars"  
						value=\'config={"clip": { "url": "http://catedu.es/arasaac/repositorio/LSE_acepciones/'.$row['imagen'].'", "bufferLength": 2, "autoBuffering": true,
							"autoPlay": false, "scaling": "fit"}, "play": {"replayLabel": "Repetir" }, "plugins": { "controls": {"volume": false, "mute": false, "time":false, "height":15, "backgroundColor": "#FFFFFF", "progressColor": "#000000", "bufferColor": "#CCCCCC" } }  }\' /> 
			</object>';
	   
	   echo '<div id="products"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cart.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto" title="a&ntilde;adir imagen a mi cesto"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/backup.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a></div>'; 
			
						
} else {

	$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
	$encript->encriptar($ruta_cesto,1);
		
	$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_palabra='.$datos_palabra['id_palabra'];
	$encript->encriptar($ruta,1);
	
	$ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$datos_palabra['id_palabra'];
	$encript->encriptar($ruta_creador,1);

	$ruta_img='size=300&ruta='.$imagen;
	$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL		
	echo '<img src="classes/img/thumbnail.php?i='.$ruta_img.'" border="0" class="image" title="'.utf8_encode($row['palabra']).'">';
	
	echo '<div id="products"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cart.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto" title="a&ntilde;adir imagen a mi cesto"></a>&nbsp;&nbsp;&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\'Creador de Simbolos\', this.href)"><img src=\'images/creador.png\' border="0" alt="Utilizar imagen en el creador" title="Utilizar imagen en el creador"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/backup.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a></div>'; 
	
}
?></p>
</div>


<div style="float:left; border:1px solid #CCCCCC; margin-left:10px; padding:20px; margin-bottom:20px; width:53%;">
  <p><strong>Tama&ntilde;o:</b></strong><?php echo $imageX."x".$imageY; ?><br />
        <b><?php echo utf8_encode("Autor:"); ?></b>&nbsp;<?php echo utf8_encode($row['autor']); ?>&nbsp; &nbsp;
        <?php if ($row['web_autor'] != '') { echo '<a href="'.$row['web_autor'].'" target="_blank"><img src="images/webexport.png" alt="Visitar p&aacute;gina web" border=0" /></a>'; } ?>
&nbsp;
<?php if ($row['email_autor'] != '') { echo '<a href="mailto:'.$row['email_autor'].'"><img src="images/mail_new.png" alt="Enviar email" border=0" /></a>'; } ?>
<br />
<b>Licencia:</b>
<?php if ($row['logo_licencia'] != '') { echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'" border="0" /></a>';  }?>
</p><br />
<?php 
	$result_lse=$query->buscar_acepcion_lse($datos_palabra['id_palabra']);
	$numrows_lse=mysql_num_rows($result_lse);
	
	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { 
		if ($numrows_lse>0) {  
			$r=1;
				while ($row_lse=mysql_fetch_array($result_lse)) { 
				echo utf8_encode('<a href="javascript:MM_openBrWindow(\'inc/public/ver_acepcion.php?i='.$row_lse['id_imagen'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src="images/acepcion_'.$r.'.jpg" alt="Ver traducci&oacute;n n&ordm; '.$r.' en LSE" title="Ver traducci&oacute;n n&ordm; '.$r.' en LSE" border=0" /></a>&nbsp;');
				$r++;
				}  
		}
	}
	
	echo '<b>'.$datos_palabra['palabra'].': </b>'; ?>
      <?php echo '<em>'.utf8_encode($datos_palabra['definicion']).'</em>';
	  
	  if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { 
			if (file_exists('../../repositorio/LSE_definiciones/'.$datos_palabra['id_palabra'].'.flv')) {
			echo '&nbsp;<a href="javascript:MM_openBrWindow(\'inc/public/ver_definicion.php?i='.$datos_palabra['id_palabra'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src="images/icono_lse_13x13.jpg" alt="Ver definici&oacute;n en LSE" title="Ver definici&oacute;n en LSE" border=0" /></a>';
			} 
	
		}
		
	echo '<br /><br />'; 
	?>
      <?php if (mysql_num_rows($asociadas) > 0) { 
			if (mysql_num_rows($asociadas) == 1) { echo '<b>'.mysql_num_rows($asociadas).' palabra asociada</b><br />'; }
			elseif (mysql_num_rows($asociadas) > 1){ echo '<b>'.mysql_num_rows($asociadas).' palabras asociadas</b><br />'; } 
		  } 
	while ($pa=mysql_fetch_array($asociadas)) {
	
			$result_lse1=$query->buscar_acepcion_lse($pa['id_palabra']);
			$numrows_lse1=mysql_num_rows($result_lse1);
			
			if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { 
			
				if ($numrows_lse1>0) {
					$e=1;
					while ($row_lse1=mysql_fetch_array($result_lse1)) { 
						echo utf8_encode('<a href="javascript:MM_openBrWindow(\'inc/public/ver_acepcion.php?i='.$row_lse1['id_imagen'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src="images/acepcion_'.$e.'.jpg" alt="Ver traducci&oacute;n n&ordm; '.$e.' en LSE" title="Ver traducci&oacute;n n&ordm; '.$e.' en LSE" border=0" /></a>&nbsp;');
						$r++;
					}  
						 
				}
			
			}
			
	  echo '<small><b>'.$pa['palabra'].': </b>'.utf8_encode($pa['definicion']).'</small>';
	  
	  if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { 
	  
			if (file_exists('../../repositorio/LSE_definiciones/'.$pa['id_palabra'].'.flv')) {
			echo '&nbsp;<a href="javascript:MM_openBrWindow(\'inc/public/ver_definicion.php?i='.$pa['id_palabra'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src="images/icono_lse_13x13.jpg" alt="Ver definici&oacute;n en LSE" title="Ver definici&oacute;n en LSE" border=0" /></a>';
			} 
		
	  }
	  
	  echo '<br />';
	}
	?>
    </p>
      <p>
        <?php 
	  $idiomas_disponibles=$query->idiomas_disponibles($id_palabra,1);
	  echo idiomas_disponibles_modo_texto($id_palabra,$idiomas_disponibles,$query); 
	  ?>
	<br /><strong>Tags</strong></strong>:<br /><br />
      <?php 
  $tags=str_replace('}{',',',$row['tags_imagen']);
  $tags=str_replace('{','',$tags);
  $tags=str_replace('}','',$tags);
  $tags=explode(',',$tags);
  
  for ($i=0;$i<count($tags);$i++) { 
  	if ($tags[$i]!='') {
 	 echo '<a href="javascript:void(0);" onclick="recogercheckbox_buscador_principal_para_tags(\''.$tags[$i].'\');">'.$tags[$i].'</a> '; 
	}
  }
  
  ?>     
</div>

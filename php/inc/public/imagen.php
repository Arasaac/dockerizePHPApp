<?php 
session_start();
require ('../../classes/languages/language_detect.php');
include ('../../classes/querys/query.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');
include ('../../funciones/funciones.php');

$datos = $_GET['i']; //pasamos el paquete a una variable en nuestro caso es val
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$encript->desencriptar($datos,3); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
$imagen=$datos['img'];
$id_imagen=$datos['id_imagen'];	
$id_palabra=$datos['id_palabra'];	

$query=new query();
$row=$query->datos_imagen($id_imagen);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],24); 

if ($_SESSION['language']=='es') {
	$datos_palabra=$query->datos_palabra($id_palabra);
} elseif ($_SESSION['language']!='es') {
	$traduccion=$query->buscar_traduccion($id_palabra,$_SESSION['id_language']);
	$datos_palabra=mysql_fetch_array($traduccion);
}


//$estadisticas=$query->imagen_numero_visitas($id_imagen); //SE ANULA AL HABER ELIMINADO EL CAMPO VECES_VISTO EN LA TABLA IMAGENES
$asociadas=$query->palabras_asociadas($id_imagen,$id_palabra);

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

$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
$encript->encriptar($ruta_cesto,1);
	
$ruta='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$datos_palabra['id_palabra'];
$encript->encriptar($ruta,1);			
?>
<div id="mostrar_imagen" style="width:100%" align="center">
<div id="products" align="left">
<table width="100%" border="0">
  <tr>
    <td width="65%"><div id="loading"><img src="images/loading2.gif" alt="<?php echo $translate['cargando']; ?>..." /></div></td>
    <td width="35%" align="right"><?php echo '<div id="products" style="float:right; width:80px;"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt='.$translate['add_imagen_cesto'].'" title="'.$translate['add_imagen_cesto'].'"></a>&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta.'" onclick="return GB_showFullScreen(\''.$translate['creador_de_simbolos'].'\', this.href)"><img src=\'images/paint.gif\' border="0" alt="'.$translate['utilizar_imagen_creador'].'" title="'.$translate['utilizar_imagen_creador'].'"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="'.$translate['descargar_imagen'].'" title="'.$translate['descargar_imagen'].'"></a></div>'; ?> </td>
  </tr>
  <tr>
    <td align="center" valign="middle"><?php 
$ruta_img='size=200&ruta='.$imagen;
$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL		
echo '<img src="classes/img/thumbnail.php?i='.$ruta_img.'" border="0" class="image" title="';
	if ($_SESSION['language']=='es') {
		echo $datos_palabra['palabra'].': '.utf8_encode($datos_palabra['definicion']);
	} elseif ($_SESSION['language']!='es') {
		echo $datos_palabra['traduccion'].': '.$datos_palabra['explicacion'];
	}
echo '">';
?></td>
    <td align="left" valign="middle"><p><b><?php echo $translate['size']; ?>:</b><?php echo $imageX."x".$imageY; ?><br />
        <b><?php echo $translate['autor']; ?>:</b>&nbsp;<?php echo utf8_encode($row['autor']); ?>&nbsp; &nbsp;
        <?php if ($row['web_autor'] != '') { echo '<a href="'.$row['web_autor'].'" target="_blank"><img src="images/webexport.png" alt="'.$translate['visit_webpage'].'" title="'.$translate['visit_webpage'].'" border=0" /></a>'; } ?>
&nbsp;
<?php if ($row['email_autor'] != '') { echo '<a href="mailto:'.$row['email_autor'].'"><img src="images/mail_new.png" alt="'.$translate['enviar_email'].'" title="'.$translate['enviar_email'].'" border=0" /></a>'; } ?>
<br />
<b><?php echo $translate['licencia']; ?>:</b>
<?php 
if ($row['logo_licencia'] != '') { 
	if ($_SESSION['language']=='es') {
		echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'" border="0" /></a>'; 
	} else {
		echo '<a href="'.$row['link_licencia_'.$_SESSION['language'].''].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.$row['licencia_'.$_SESSION['language'].''].'" title="'.$row['licencia_'.$_SESSION['language'].''].'" border="0" /></a>'; 
	} 
} ?>
    </p>
      </td>
  </tr>
  <tr>
    <td height="213" valign="top">
	<?php 
	$result_lse=$query->buscar_acepcion_lse($datos_palabra['id_palabra']);
	$numrows_lse=mysql_num_rows($result_lse);
	
	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { 
	
		if ($numrows_lse>0) {  
			$r=1;
				while ($row_lse=mysql_fetch_array($result_lse)) { 
				echo utf8_encode('<a href="javascript:MM_openBrWindow(\'inc/public/ver_acepcion.php?i='.$row_lse['id_imagen'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src="images/acepcion_'.$r.'.jpg" alt="'.$translate['ver_traduccion'].' nº '.$r.' '.$translate['en_lse'].'" title="'.$translate['ver_traduccion'].' nº '.$r.' '.$translate['en_lse'].'" border=0" /></a>&nbsp;');
				$r++;
				}  
		}
	
	}
	
	if ($_SESSION['language']=='es') {
		echo '<b>'.$datos_palabra['palabra'].': </b>'; ?> <?php echo '<em>'.utf8_encode($datos_palabra['definicion']).'</em>';
	} elseif ($_SESSION['language']!='es') {
		echo '<b>'.$datos_palabra['traduccion'].': </b>'; ?> <?php echo '<em>'.utf8_encode($datos_palabra['explicacion']).'</em>';
	}

	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { 
	
		if (file_exists('../../repositorio/LSE_definiciones/'.$datos_palabra['id_palabra'].'.flv')) {
		echo '&nbsp;<a href="javascript:MM_openBrWindow(\'inc/public/ver_definicion.php?i='.$datos_palabra['id_palabra'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src="images/icono_lse_13x13.jpg" alt="'.$translate['ver_definicion_lse'].'" title="'.$translate['ver_definicion_lse'].'" border=0" /></a>';
		} 
		
	}
	
	echo '<br /><br />'; 
	?> 
	<?php if (mysql_num_rows($asociadas) > 0) { 
			if (mysql_num_rows($asociadas) == 1) { echo '<b>'.mysql_num_rows($asociadas).' '.$translate['palabra_asociada'].'</b><br />'; }
			elseif (mysql_num_rows($asociadas) > 1){ echo '<b>'.mysql_num_rows($asociadas).' '.$translate['palabras_asociadas'].'</b><br />'; } 
		  } 
	while ($pa=mysql_fetch_array($asociadas)) {
	
			$result_lse1=$query->buscar_acepcion_lse($pa['id_palabra']);
			$numrows_lse1=mysql_num_rows($result_lse1);
			
			if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { 
			
				if ($numrows_lse1>0) {
					$e=1;
					while ($row_lse1=mysql_fetch_array($result_lse1)) { 
						echo utf8_encode('<a href="javascript:MM_openBrWindow(\'inc/public/ver_acepcion.php?i='.$row_lse1['id_imagen'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src="images/acepcion_'.$e.'.jpg" alt="'.$translate['ver_traduccion'].' nº '.$r.' '.$translate['en_lse'].'" title="'.$translate['ver_traduccion'].' nº '.$r.' '.$translate['en_lse'].'" border=0" /></a>&nbsp;');
						$r++;
					}  
						 
				}
			}
			
			if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
				echo '<small><b>'.$pa['palabra'].': </b>'.utf8_encode($pa['definicion']).'</small>';
			} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
				$traduccion1=$query->buscar_traduccion($pa['id_palabra'],$_SESSION['id_language']);
				$n_pa=mysql_num_rows($traduccion1);
				
				if ($n_pa > 0) {
					$pa=mysql_fetch_array($traduccion1);
					echo '<small><b>'.$pa['traduccion'].': </b>'.utf8_encode($pa['explicacion']).'</small>';
				}
				
			}	
	  
	  	
		if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { 
		
			if (file_exists('../../repositorio/LSE_definiciones/'.$pa['id_palabra'].'.flv')) {
			echo '&nbsp;<a href="javascript:MM_openBrWindow(\'inc/public/ver_definicion.php?i='.$pa['id_palabra'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src="images/icono_lse_13x13.jpg" alt="'.$translate['ver_definicion_lse'].'" title="'.$translate['ver_definicion_lse'].'" border=0" /></a>';
			} 
			
		}
		
	  echo '<br />';
	}
	?><br />
     </td>
    <td align="left" valign="top"><p>
      <?php 
	  $idiomas_disponibles=$query->idiomas_disponibles($id_palabra,1);
	  echo idiomas_disponibles_modo_texto($id_palabra,$idiomas_disponibles,$query); ?>
      </p>
      </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <?php 
	  if ($_SESSION['language']=='es') {
	  
		  echo '<hr /><strong>TAGS</strong><br />';
		  
		  $tags=str_replace('}{',',',$row['tags_imagen']);
		  $tags=str_replace('{','',$tags);
		  $tags=str_replace('}','',$tags);
		  $tags=explode(',',$tags);
		  
		  for ($i=0;$i<count($tags);$i++) { 
			if ($tags[$i]!='') {
			 echo '<a href="javascript:void(0);" onclick="recogercheckbox_buscador_principal_para_tags(\''.$tags[$i].'\');">'.$tags[$i].'</a> '; 
			}
		  }
  	 }
  ?></td>
    </tr>
</table>
</div>
</div>
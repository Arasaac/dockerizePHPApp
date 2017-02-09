<?php 
session_start();
require ('../../classes/languages/language_detect.php');
include ('../../classes/querys/query.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');
include ('../../funciones/funciones.php');

$id_imagen = $_GET['i']; //pasamos el paquete a una variable en nuestro caso es val

$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],25); 

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$row=$query->datos_imagen($id_imagen);

if ($_SESSION['language']=='es') {
	$datos_palabra=$query->datos_palabra($row['id_palabra']);
} elseif ($_SESSION['language']!='es') {
	$traduccion=$query->buscar_traduccion($row['id_palabra'],$_SESSION['id_language']);
	$datos_palabra=mysql_fetch_array($traduccion);
}

//$estadisticas=$query->imagen_numero_visitas($id_imagen); //SE ANULA AL HABER ELIMINADO EL CAMPO VECES_VISTO EN LA TABLA IMAGENES
$asociadas=$query->palabras_asociadas($id_imagen,$row['id_palabra']);
$id_palabra=$row['id_palabra'];

$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
$encript->encriptar($ruta_cesto,1);
				
$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
$encript->encriptar($ruta,1);		
?>
<div id="mostrar_imagen" style="width:100%" align="center">
<div id="products" align="left">
<table width="100%" border="0">
  <tr>
    <td width="65%"><div id="loading"><img src="images/loading2.gif" alt="<?php echo $translate['cargando']; ?>..." /></div></td>
    <td width="35%" align="right"><?php echo '<div id="products" style="float:right; width:80px;"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="'.$translate['add_video_cesto'].'" title="'.$translate['add_video_cesto'].'"></a>&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="'.$translate['descargar_video'].'" title="'.$translate['descargar_video'].'"></a></div>'; ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle">
    <object id="<?php echo $row['imagen'] ?>" width="310" height="325" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
        type="application/x-shockwave-flash"> 
         
        <param name="movie" value="plugins/flowplayer/flowplayer-3.1.1.swf" />  
        <param name="allowfullscreen" value="true" /> 
         
        <param name="flashvars"  
            value='config={"clip": { "url": "repositorio/LSE_acepciones/<?php echo $row['imagen'] ?>", "bufferLength": 2, "autoBuffering": true,
				"autoPlay": false, "scaling": "fit" }, "play": { "label": "<?php echo $translate['reproducir']; ?>", "replayLabel": "<?php echo $translate['repetir']; ?>" }  }' /> 
    </object>

</td>
    <td rowspan="2" align="left" valign="top"><p><b><?php echo $translate['autor']; ?></b>&nbsp;<?php echo utf8_encode($row['autor']); ?>&nbsp; &nbsp;
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
    <br /><br />
      <p>
        <?php 
	  $idiomas_disponibles=$query->idiomas_disponibles($id_palabra,1);
	  echo idiomas_disponibles_modo_texto($id_palabra,$idiomas_disponibles,$query); ?></p></td>
  </tr>
  <tr>
    <td height="54" valign="top">
	<?php 
	if ($_SESSION['language']=='es') {
		echo '<b>'.$datos_palabra['palabra'].': </b>'; ?> <?php echo '<em>'.utf8_encode($datos_palabra['definicion']).'</em>';
	} elseif ($_SESSION['language']!='es') {
		echo '<b>'.$datos_palabra['traduccion'].': </b>'; ?> <?php echo '<em>'.utf8_encode($datos_palabra['explicacion']).'</em>';
	}	
	
	if (file_exists('../../repositorio/LSE_definiciones/'.$datos_palabra['id_palabra'].'.flv')) {
    echo '&nbsp;<a href="javascript:MM_openBrWindow(\'inc/public/ver_definicion.php?i='.$datos_palabra['id_palabra'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src="images/icono_lse_16x16.jpg" alt="'.$translate['ver_definicion_lse'].'" title="'.$translate['ver_definicion_lse'].'" border=0" /></a>';
	} 
	echo '<br /><br />'; 
	?> 
	<?php if (mysql_num_rows($asociadas) > 0) { 
			if (mysql_num_rows($asociadas) == 1) { echo '<b>'.mysql_num_rows($asociadas).' palabra asociada</b><br />'; }
			elseif (mysql_num_rows($asociadas) > 1){ echo '<b>'.mysql_num_rows($asociadas).' palabras asociadas</b><br />'; } 
		  } 
	while ($pa=mysql_fetch_array($asociadas)) {
	  echo '<small><b>'.$pa['palabra'].': </b>'.utf8_encode($pa['definicion']).'</small>';
	  	if (file_exists('../../repositorio/LSE_definiciones/'.$pa['id_palabra'].'.flv')) {
		echo '&nbsp;<a href="javascript:MM_openBrWindow(\'inc/public/ver_definicion.php?i='.$pa['id_palabra'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src="images/icono_lse_13x13.jpg" alt="'.$translate['ver_definicion_lse'].'" title="'.$translate['ver_definicion_lse'].'" border=0" /></a>';
		} 
	  echo '<br />';
	}
	?><br />     </td>
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
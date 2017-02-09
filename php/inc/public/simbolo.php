<?php 
include ('../../classes/querys/query.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');
include ('../../funciones/funciones.php');

$datos = $_GET['i']; //pasamos el paquete a una variable en nuestro caso es val
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$encript->desencriptar($datos,4); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
$imagen=$datos['img'];
$id_imagen=$datos['id_imagen'];	
$id_palabra=$datos['id_palabra'];
$id_simbolo=$datos['id_simbolo'];	

$query=new query();
$row=$query->datos_imagen($id_imagen);
$datos_palabra=$query->datos_palabra($id_palabra);
//$estadisticas=$query->imagen_numero_visitas($id_imagen); //SE ANULA AL HABER ELIMINADO EL CAMPO VECES_VISTO EN LA TABLA IMAGENES
$datos_simbolo=$query->datos_simbolo_arasaac($id_simbolo);

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

$folder=$datos_simbolo['id_tipo_simbolo'].$datos_simbolo['marco'].$datos_simbolo['contraste'].$datos_simbolo['sup_con_texto'].$datos_simbolo['sup_idioma'].$datos_simbolo['sup_mayusculas'].$datos_simbolo['sup_font'].$datos_simbolo['inf_con_texto'].$datos_simbolo['inf_idioma'].$datos_simbolo['inf_mayusculas'].$datos_simbolo['inf_font'];
					
$ruta_cesto='ruta_cesto=repositorio/simbolos/fuente/'.$folder.'/'.$datos_simbolo['id_simbolo'].'.'.$datos_simbolo['ext'];
$encript->encriptar($ruta_cesto,1);
	
$ruta='img=../../repositorio/simbolos/fuente/'.$folder.'/'.$datos_simbolo['id_simbolo'].'.'.$datos_simbolo['ext'].'&id_imagen='.$datos_simbolo['id_imagen'].'&id_palabra='.$datos_simbolo['id_palabra'].'&id_simbolo='.$datos_simbolo['id_simbolo'];
$encript->encriptar($ruta,1);			
?>
<div id="mostrar_imagen" style="width:100%" align="center">
<div id="products" align="left">
<table width="100%" border="0">
  <tr>
    <td width="46%"><div id="loading"><img src="images/loading2.gif" alt="Cargando..." /></div></td>
    <td width="54%" align="right"><?php echo '<div id="products" style="float:right; width:80px;"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto" title="a&ntilde;adir imagen a mi cesto"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a></div>'; ?> </td>
  </tr>
  <tr>
    <td align="center" valign="middle"><?php 
$ruta_img='size=200&ruta='.$imagen;
$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL		
echo '<a href="inc/public/descargar.php?i='.$ruta.'"><img src="classes/img/thumbnail.php?i='.$ruta_img.'" border="0" class="image" title="'.utf8_encode($row['palabra']).'"></a>';
?></td>
    <td align="left" valign="middle"><p><b>Tama&ntilde;o:</b><?php echo $imageX."x".$imageY; ?><br />
        <b><?php echo utf8_encode("Autor:"); ?></b>&nbsp;<?php echo utf8_encode($row['autor']); ?>&nbsp; &nbsp;
        <?php if ($row['web_autor'] != '') { echo '<a href="'.$row['web_autor'].'" target="_blank"><img src="images/webexport.png" alt="Visitar p&aacute;gina web" border=0" /></a>'; } ?>
&nbsp;
<?php if ($row['email_autor'] != '') { echo '<a href="mailto:'.$row['email_autor'].'"><img src="images/mail_new.png" alt="Enviar email" border=0" /></a>'; } ?>
<br />
<b>Licencia:</b>
<?php if ($row['logo_licencia'] != '') { echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'" border="0" /></a>';  }?>
    </p>
      <p>&nbsp;</p>
      <p><strong>Palabra</strong></p>
      <hr />
      <p><?php echo '<b>'.$datos_palabra['palabra'].': </b>'; ?> <?php echo '<em>'.utf8_encode($datos_palabra['definicion']).'</em><br /><br />'; ?> </p>
      <p><strong>Configuraci&oacute;n del S&iacute;mbolo</strong></p>
      <hr />
      <p><em><strong>Marco:</strong></em>
          <?php if ($datos_simbolo['marco']==1) { echo 'Con Marco'; } else { echo 'Sin Marco'; } ?>
      </p>
      <p><em><strong>Contraste:</strong></em>
          <?php if ($datos_simbolo['contraste']==1) { echo 'Normal'; } elseif ($datos_simbolo['contraste']==2) { echo 'Invertido'; } elseif ($datos_simbolo['contraste']==3) { echo 'Alto Contraste'; }?>
      </p>
      <p><em><strong>Tipo pictograma:</strong></em> <?php echo utf8_encode($datos_simbolo['tipo_simbolo']); ?></p>
      <p><em><strong>Idiomas:</strong></em>
          <?php 

if ($datos_simbolo['sup_con_texto']==1) { 

	if ($datos_simbolo['sup_idioma']==0) { 
		echo 'Castellano (Superior) | ';
	} else { 
		$datos_idioma_sup=$query->datos_idioma($datos_simbolo['sup_idioma']);
		echo $datos_idioma_sup.' (Superior) | ';
	}
	
} else { echo 'Sin texto (Superior) | '; }

if ($datos_simbolo['inf_con_texto']==1) { 

	if ($datos_simbolo['inf_idioma']==0) { 
		echo 'Castellano (Inferior)';
	} else { 
		$datos_idioma_inf=$query->datos_idioma($datos_simbolo['inf_idioma']);
		echo $datos_idioma_inf.' (Inferior)';
	}

} else { echo 'Sin texto (Inferior)'; }
?>
      </p>
      <p><em><strong>Fuentes:</strong></em>
          <?php 
if ($datos_simbolo['sup_con_texto']==1) { 

	$datos_fuente_sup=$query->datos_fuentes_simbolos($datos_simbolo['sup_font']);
	echo $datos_fuente_sup['nombre_fuente'].' (Superior) | ';

} else { echo 'Sin texto (Superior) | '; }

if ($datos_simbolo['inf_con_texto']==1) { 

	$datos_fuente_inf=$query->datos_fuentes_simbolos($datos_simbolo['inf_font']);
	echo $datos_fuente_inf['nombre_fuente'].' (Inferior)';

} else { echo 'Sin texto (Inferior)'; }
?>
      </p></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><p>&nbsp;</p>
    </td>
    </tr>
  <tr>
    <td colspan="2" align="center"><hr /><strong>TAGS</strong><br />
      <?php 
  $tags=str_replace('}{',',',$datos_simbolo['tags_simbolo']);
  $tags=str_replace('{','',$tags);
  $tags=str_replace('}','',$tags);
  $tags=explode(',',$tags);
  
  for ($i=0;$i<count($tags);$i++) { 
  	if ($tags[$i]!='') {
 	 echo '<a href="javascript:void(0);" onclick="recogercheckbox_buscador_principal_para_tags(\''.$tags[$i].'\');">'.$tags[$i].'</a> '; 
	}
  }
  
  ?></td>
    </tr>
</table>
</div>
</div>
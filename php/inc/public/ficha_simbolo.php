<?php 
include ('../../classes/querys/query.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$datos = $_GET['i']; //pasamos el paquete a una variable en nuestro caso es val
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$encript->desencriptar($datos,2); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
$imagen=$datos['img'];
$id_simbolo=$datos['id_simbolo'];	

$query=new query();
$row=$query->datos_simbolo($id_simbolo);

$estadisticas=$query->simbolo_numero_visitas($id_simbolo);
?>
<div id="products" style="float:right;"><div id="loading"><img src="images/loading2.gif" alt="Cargando..." /></div></div>
        <table width="400" border="0" cellspacing="0" cellpadding="0">
          
          <tr valign="middle">
            <td width="5%" height="291" valign="top"><div align="center">
              <?php 	
			 	    $ruta_img='size=150&ruta='.$imagen;
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL		
					echo '<img src="classes/img/thumbnail.php?i='.$ruta_img.'" border="0" class="image" title="'.utf8_encode($row['palabra']).'">';
	    		?>
            </div></td>
            <td width="95%" valign="top"><p align="left"><strong>Palabra:</strong> <em><strong><?php echo utf8_encode($row['palabra']); ?>,</strong></em>&nbsp;&nbsp; <?php if (strlen($row['definicion']) > 100) { echo substr (utf8_encode($row['definicion']), 0, 100)."..."; } else { echo utf8_encode($row['definicion']); } ?>
            </p>
              <p align="left"><strong>Tipo S&iacute;mbolo:</strong>
                    <?php echo $row['tipo_simbolo']; ?>              </p>
              <p align="left"><strong>Idioma:</strong>
                  <?php 
				  if ($_GET['id_idioma']==0) {
				 	 echo 'Sin idioma';
				  } else {
				  	echo $query->datos_idioma($_GET['id_idioma']); 
				  }
				  ?>
              </p>
              <p align="left">
			  <?php 
			  if ($row['castellano']==0) { echo '<img src="images/no_visible.gif" alt="'.utf8_encode("Traducción en ruso no visible").'" border="0">';  }
					 else { echo '<img src="images/visible.gif" alt="'.utf8_encode("Traducción en ruso visible").'" border="0">'; }
			  ?>&nbsp;Texto en Castellano </p>
              <p align="left">
			   <?php 
			  if ($row['mayusculas']==0) { echo '<img src="images/no_visible.gif" alt="'.utf8_encode("Traducción en ruso no visible").'" border="0">';  }
					 else { echo '<img src="images/visible.gif" alt="'.utf8_encode("Traducción en ruso visible").'" border="0">'; }
			  ?>
&nbsp;May&uacute;sculas</p>
              <p align="left"><strong>Marco:</strong>
                <?php if ($row['marco']==0) { echo 'Sin marco'; } elseif ($row['marco']==1){ echo 'Con marco'; } ?>
              </p>
              <p align="left"><strong>Constraste:</strong>
                <?php if ($row['contraste'] == 0) { echo 'Normal'; } elseif ($row['contraste'] == 1){ echo 'Invertido';} elseif ($row['contraste'] == 2){ echo 'Alto contraste';} ?>
              </p>
              <table width="100%" border="0">
                <tr>
                  <td><?php echo '<a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/simbolos/").'/'.$row['id_simbolo'].'_o.'.$row['ext'].'\');"><img src=\'images/image_40x40.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: Tama&ntilde;o original"><br><img src=\'images/cesto.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: Tama&ntilde;o original"></a>&nbsp;'; ?></td>
                  <td><?php echo '<a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/simbolos/").'/'.$row['id_simbolo'].'_150.'.$row['ext'].'\');"><img src=\'images/image_30x30.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: 150x150"><br><img src=\'images/cesto.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: 150x150"></a>&nbsp;'; ?></td>
                  <td><?php echo '<a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/simbolos/").'/'.$row['id_simbolo'].'.'.$row['ext'].'\');"><img src=\'images/image_20x20.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: 75x75"><br><img src=\'images/cesto.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: 75x75"></a>&nbsp;'; ?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
              </td>
          </tr>
        </table>

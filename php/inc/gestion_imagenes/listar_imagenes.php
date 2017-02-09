<?php  
session_start();

include ('../../classes/querys/query.php');
require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);


$query=new query();

$id_tipo="";
$letra="";

$id_tipo=$_POST['id_tipo'];
$letra=$_POST['letra'];
$id_tipo_imagen=$_POST['id_tipo_imagen'];
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);

		
/* ******************************************************************************************* */ 
/*                            LISTAR PALABRAS 												   */
/* ******************************************************************************************* */ 

	
		if(!isset($_POST['pg'])){ 
		  $pg = "0"; 
		} else {
		  $pg = $_POST['pg'];
		}
		$cantidad=10; // cantidad de resultados por p&aacute;gina 
		$inicial = $pg * $cantidad;
		
		$contar=$query->listar_diccionario_palabras_con_imagenes_por_tipo_imagen($id_tipo,$letra,$id_tipo_imagen);
		$pegar=$query->listar_diccionario_palabras_con_imagenes_limit_por_tipo_imagen($id_tipo,$letra,$inicial,$cantidad,$id_tipo_imagen);
		
		$total_records = mysql_num_rows($contar);
		$pages = intval($total_records / $cantidad);
		$color = 'tablaAlterno1';
?>
<table width="95%" border="0" cellpadding="0" cellspacing="0">
<thead>
      <tr>
        <th width="84" field="Name" dataType="String"><div align="left"><strong>Palabra</strong></div></th>
        <th width="249" field="DateAdded" dataType="Date" sort="asc"><div align="left"><strong>Acepci&oacute;n</strong></div></th>
        <th width="905" dataType="html"><div align="left"><strong>Im&aacute;genes disponibles </strong></div></th>
    </tr>
    </thead>
   <tbody>
      <?php
		while ($entrada = mysql_fetch_array($pegar)) {

		$estado='all';
		$result=$query->imagenes_por_palabra_y_tipo_imagen($entrada['id_palabra'],$_SESSION['AUTHORIZED'],$estado,$id_tipo_imagen);
		
		$color = ($color == 'tablaAlterno1') ? 'tablaAlterno2' : 'tablaAlterno1'
		?>
      <tr class="<?php echo $color; ?>">
        <td valign="middle"><div align="center"><b><?php echo utf8_encode($entrada['palabra']); ?></b></div></td>
        <td valign="middle"> <div align="left"><?php echo utf8_encode($entrada['definicion']); ?></div></td>
        <td valign="middle">
		  <div align="left">
		    <?php
		$content="";
		$simbol=array();
		 
		while ($row=mysql_fetch_array($result)) { 
		
		$borrar='';
		
			if ($permisos['borrar_imagenes']==1) {

				if ($row['extension']=='flv') { 
					$borrar='<a href="javascript:void(0);" 
					onClick="ventana_confirmacion(\'Esta seguro que desea borrar el vídeo seleccionado?\',
					\'300\',\'100\',
					\'inc/gestion_imagenes/borrar_video_acepcion_lse.php\', \'id='.$row['id_imagen'].'\', \'img_'.$row['id_imagen'].'\',
					\'\', \'\', \'\'
					);" /><img src="images/papelera.png" alt="Borrar Vídeo" title="Borrar Vídeo" border="0" /></a>';
				} else {
					$borrar='<a href="javascript:void(0);" 
					onClick="ventana_confirmacion(\'Esta seguro que desea borrar la imagen seleccionada?\',
					\'300\',\'100\',
					\'inc/gestion_imagenes/borrar_imagen.php\', \'id='.$row['id_imagen'].'\', \'img_'.$row['id_imagen'].'\',
					\'\', \'\', \'\'
					);" /><img src="images/papelera.png" alt="Borrar imagen"  title="Borrar imagen"border="0" /></a>';
				}
				
			} else { 
		
				$borrar='';
		
			}
		
				$ruta_img='size=50&ruta=../../repositorio/originales/'.$row['imagen'];
				$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
				
				$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
				$encript->encriptar($ruta_cesto,1);
			
			if ($row['extension']=='flv') { 
				$simbol[]='<div id="img_'.$row['id_imagen'].'"><object type="application/x-shockwave-flash" data="plugins/toobplayer/toobplayer_simple1.swf" style="outline: none;" width="110" height="125">
					<param name="movie" value="plugins/toobplayer/toobplayer_simple1.swf"></param>
					<param name="allowFullScreen" value="false"></param>
					<param name="FlashVars" value="url=../../repositorio/LSE_acepciones/'.$row['imagen'].'&autoPlay=false&volume=0&showFullScreenButton=false" />
				</object><br>'.$borrar.'&nbsp;<a href="javascript:void(0);" onClick="cargar_div(\'inc/gestion_imagenes/informacion_imagen.php\',\'id='.$row['id_imagen'].'\',\'informacion_imagen\');" /><img src="images/editar.gif" border="0"" alt="Mostrar informacion de la imagen"/></a>
				<td>
					</div>
				</div>
			</td>';
			} else { 
				$simbol[]='<td>
				<div id="img_'.$row['id_imagen'].'">
				<a href="javascript:void(0);" onClick="cargar_div(\'inc/gestion_imagenes/informacion_imagen.php\',\'id='.$row['id_imagen'].'\',\'informacion_imagen\');" /><img src="classes/img/thumbnail.php?i='.$ruta_img.'" border="0"" alt="Mostrar informacion de la imagen"/></a><br><div id="products">'.$borrar.'
					</div>
				</div>
			</td>';
			}
		} 
		
		$o=0;
		$content.='<table style="text-align:left;">';
			for ($i=1; $i<=20; $i++){ // FILAS
				$content.="<tr>"; 
					for ($e=1; $e<=3; $e++){ //COLUMNAS 
						$file=$simbol[$o];
							if ($file=="") { break; }
							$content.=$file;  
							$o++;
					} 
				$content.="</tr>"; 
			} 
		$content.='</table>';
		echo $content;
		
		?>		
        </div></td>
      </tr>
      <?php } ?>
   </tbody>
</table>
</div>
</br>
   <table width="60%" height="30" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr class="textos">
                <td width="9%" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">
                  <input type="button" name="Submit" value="&lt;&lt;" onclick='cargar_div("inc/gestion_imagenes/listar_imagenes.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&id_tipo_imagen="+document.diccionario.id_tipo_imagen.value+"&pg=0","tabla_admin_imagenes"); cargar_div("inc/gestion_imagenes/limpiar_cuadro_informacion.php","i=","informacion_imagen");'>              </td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
                  <input type="button" name="Submit" value="< Anterior" onclick='cargar_div("inc/gestion_imagenes/listar_imagenes.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&id_tipo_imagen="+document.diccionario.id_tipo_imagen.value+"&pg=<?php echo $url ?>","tabla_admin_imagenes"); cargar_div("inc/gestion_imagenes/limpiar_cuadro_informacion.php","i=","informacion_imagen");'>
              </div></td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">&nbsp;</td>
                <td width="26%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
                  <input type="button" name="Submit" value="Siguiente >" onclick='cargar_div("inc/gestion_imagenes/listar_imagenes.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&id_tipo_imagen="+document.diccionario.id_tipo_imagen.value+"&pg=<?php echo $url ?>","tabla_admin_imagenes"); cargar_div("inc/gestion_imagenes/limpiar_cuadro_informacion.php","i=","informacion_imagen");'>
              </div></td>
              <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="button" value="&gt;&gt;" onclick='cargar_div("inc/gestion_imagenes/listar_imagenes.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&id_tipo_imagen="+document.diccionario.id_tipo_imagen.value+"&pg=<?php echo $pages; ?>","tabla_admin_imagenes"); cargar_div("inc/gestion_imagenes/limpiar_cuadro_informacion.php","i=","informacion_imagen");'></td>
            </tr>
</table>      
<?php
session_start();

include ('../../classes/querys/query.php');
require_once ('../../classes/img/Image_Toolbox.class.php');
include("../../classes/img/ImageEditor.php");

$id_imagen=$_POST['id_imagen'];
$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$autores=$query->listar_autores();
$licencias=$query->listar_licencias();

if ($_POST['registrado']=="false") { $estado_registrado=0; } elseif ($_POST['registrado']=="true") { $estado_registrado=1;}
if ($_POST['validos_senyalectica']=="false") { $validos_senyalectica=0; } elseif ($_POST['validos_senyalectica']=="true") { $validos_senyalectica=1;}
$tipo_pictograma=$_POST['tipo_picto'];
$tags=$_POST['tags'];

$tags=explode(',',$tags);

for ($i=0;$i<count($tags);$i++) { 
  	if ($tags[$i]!='') {
		$tags_convertidos.='{'.$tags[$i].'}';
	}
}

$row1=$query->datos_imagen($id_imagen);

//	COMPRUEBO SI EL TIPO DE IMAGEN ES EL MISMO QUE ESTABA DEFINIDO O CAMBIA. SINO CAMBIO ACTUALIZO COMO HASTA AHORA
if ($row1['tipo_imagen']==$_POST['tipo_imagen']) { 
	$actualizar_imagen=$query->actualizar_imagen($_POST['id_imagen'],$_POST['tipo_imagen'],$_POST['estado'],$estado_registrado,$_POST['licencia'],$_POST['autor'],$tags_convertidos,$tipo_pictograma,$validos_senyalectica);
}
// 	SI EL TIPO DE IMAGEN CAMBIA AL TRABAJAR CON DOS TABLAS (LA GENERAL Y LA ESPECIFICA DEL TIPO DE IMAGEN) NECESITO BORRAR LA ENTRADA CREADA EN LA TABLA DEL TIPO DE IMAGEN ANTERIOR Y AÑADIRLO A LA TABLA DEL NUEVO TIPO DE IMAGEN. lA TABLA GENERAL NO VARIA.
elseif ($row1['tipo_imagen'] != $_POST['tipo_imagen']) {
	$actualizar_imagen=$query->actualizar_imagen_cambiando_tipo_imagen($_POST['id_imagen'],$_POST['tipo_imagen'],$_POST['estado'],$estado_registrado,$_POST['licencia'],$_POST['autor'],$tags_convertidos,$tipo_pictograma,$validos_senyalectica,$row1['id_tipo_imagen'],$row1['id_colaborador'],$row1[13],$row1['original_filename'],$row1['imagen'],$row1['extension']);
}

$nube_tags=$query->construir_nube_tags(200);
$row=$query->datos_imagen($id_imagen);

if ($permisos['borrar_imagenes']==1) {

				$borrar='<a href="javascript:void(0);" 
				onClick="ventana_confirmacion(\'Esta seguro que desea borrar la imagen seleccionada?\',
				\'300\',\'100\',
				\'inc/gestion_imagenes/borrar_imagen.php\', \'id='.$row['id_imagen'].'\', \'img_'.$row['id_imagen'].'\',
				\'\', \'\', \'\'
				);" /><img src="images/papelera.png" alt="Borrar imagen" border="0" /></a>';
				

} else { 

$borrar='';

}

// RECOPilO INFORMACION DE LA IMAGEN

$fsize = @filesize("../../repositorio/originales/".$row['imagen'])/1024;

	switch ($row['extension']) {
		case "gif":	$src = "gif"; $img = @imagecreatefromgif("../../repositorio/originales/".$row['imagen']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "jpg":		$src = "jpeg"; $img = @imagecreatefromjpeg("../../repositorio/originales/".$row['imagen']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "jpeg":	$src = "jpeg"; $img = @imagecreatefromjpeg("../../repositorio/originales/".$row['imagen']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "png":		$src = "png"; $img = @imagecreatefrompng("../../repositorio/originales/".$row['imagen']); $img_y = imagesy($img); $img_x = imagesx($img); break;
	 }
				
 ?>
 
<div class="right" style="height:700px;">
<h3>Imagen:</h3>
<div class="right_articles" align="center" style="height:270px;">
			<img src="classes/img/thumbnail.php?size=250&ruta=../../repositorio/originales/<?php echo $row['imagen']; ?>&enc=0" border="0" alt="Mostrar informacion de la imagen"/>	
			</div>
			<h3>Informaci&oacute;n:</h3>
			<div class="right_articles">
			  <p><b>Peso: </b> <?php printf(" %.2f kB", $fsize);?><br>
			    <b>Tama&ntilde;o: </b><?php echo $img_x.'x'.$img_y; ?><br>
			    <b>A&ntilde;adida: </b><?php echo $row['fecha_creacion']; ?><br>
		        <b>Modificada: </b><?php echo $row['ultima_modificacion']; ?></p>
	 		</div>
			<form action="" method="POST" name="form1" id="form1">
			<h3>Configuraci&oacute;n:			</h3>
			<div class="right_articles">
			  <div id="selected_word">
			    <p><strong>Palabra:</strong><a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/gestion_imagenes/seleccionar_palabra_para_modificar.php?i=<?php echo rand(100000000000,99999999999999999999999999); ?>&amp;id_imagen=<?php echo $id_imagen; ?>', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:450}, okLabel: 'Cerrar'});"><img src="images/mas.gif" alt="Asociar palabra a imagen" border="0" /></a> <em><strong> </strong></em></p>
			    <div id="selected_word2">
                  <p>
                    <?php 
				$palabras=$query->buscar_palabras_asociadas_imagen($id_imagen); 
				
				while ($row_palabras=mysql_fetch_array($palabras)) { 
				
				$valores.=$row_palabras['id_palabra'].';';
				?>
                    <em><strong><?php echo utf8_encode($row_palabras['palabra']); ?>,</strong></em>&nbsp;&nbsp;<?php echo utf8_encode($row_palabras['definicion']); ?><a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/gestion_simbolos/seleccionar_palabra.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:450}, okLabel: 'Cerrar'});"></a> &nbsp; <?php echo '<a href="javascript:void(0);" 
				onClick="ventana_confirmacion(\'&iquest;Esta seguro que desea borrar la palabra adscrita?\',
				\'300\',\'100\',
				\'inc/gestion_imagenes/borrar_adscripcion_palabra.php\', \'id_palabra='.$row_palabras['id_palabra'].'&id_imagen='.$id_imagen.'\',
				\'\', \'\', \'\'
				);" /><img src="images/papelera.png" alt="Borrar imagen" border="0" /></a>'; ?><br/>
                    <?php } ?>
                  </p>
		        </div>
			  </div>
			  <p><strong>Tipo Imagen </strong>
			    <?php $categ2=$query->listar_tipos_imagen(); ?>
			    <select name="id_tipo_imagen" id="id_tipo_imagen" required="1" realname="Categor&iacute;a" class="fonty">
					<option value="<?php echo $row['id_tipo_imagen']?>" selected="selected"><?php echo utf8_encode($row['tipo_imagen']); ?>
 						 <?php
							while ($row_rsCategorias=mysql_fetch_array($categ2)) { 
								if ($row_rsCategorias['ext'] != 'gif') { 
		  			 	 ?>
				  <option value="<?php echo $row_rsCategorias['id_tipo']?>"><?php echo utf8_encode($row_rsCategorias['tipo_imagen']); ?></option>
 							 <?php } // Cierro el If
			  }  // Cierro el While ?>
</select>
</p>
			  <p><strong>Estado:</strong>
			    <select name="estado" id="estado">
                  <option value="2"  <?php if ($row[5]==2) {echo 'selected="selected"';} ?>>Pendiente revisi&oacute;n</option>
                  <option value="1"  <?php if ($row[5]==1) {echo 'selected="selected"';} ?>>Visible</option>
                  <option value="0"  <?php if ($row[5]==0) {echo 'selected="selected"';} ?>>No Visible</option>
                </select>
</p>
			  <p><strong>Tipo de pictograma:</strong>
                <select name="tipo_picto" id="tipo_picto">
                  <option value="2"  <?php if ($row['tipo_pictograma']==2) {echo "SELECTED";} ?>>Esquem&aacute;tico</option>
                  <option value="1"  <?php if ($row['tipo_pictograma']==1) {echo "SELECTED";} ?>>Realista</option>
                </select>
              </p>
			  <p><strong>Autor:</strong>
          <select name="autor" id="autor" required="1" realname="Autor" class="fonty">
                	<option value="<?php echo $row['id_autor']?>" selected="selected"><?php echo utf8_encode($row['autor']); ?>
                  <?php
						while ($row_rsAutor=mysql_fetch_array($autores)) { 
		  			  ?>
                  <option value="<?php echo $row_rsAutor['id_autor']?>"><?php echo utf8_encode($row_rsAutor['autor']); ?></option>
                  <?php 
			 		 }  // Cierro el While ?>
                </select>
</p>
			  <p><strong>Licencia:</strong>
                  <select name="licencia" id="licencia" required="1" realname="Categor&iacute;a" class="fonty">
                    <option value="<?php echo $row['id_licencia']?>" selected="selected"><?php echo utf8_encode($row['licencia']); ?>
                    <?php
						while ($row_rsLicencia=mysql_fetch_array($licencias)) { 
					?>
                    <option value="<?php echo $row_rsLicencia['id_licencia']?>"><?php echo utf8_encode($row_rsLicencia['licencia']); ?></option>
                    <?php 
			 		 }  // Cierro el While ?>
                  </select>
              </p>
			  <p><strong>Tags: </strong></p>
			  <p>
                <label>
                <textarea name="tags" cols="40" rows="4" id="tags"><?php $tags=str_replace('}{',',',$row['tags_imagen']); $tags=str_replace('{','',$tags); $tags=str_replace('}','',$tags); echo $tags; ?></textarea>
                </label>
              </p>
			  <p>
                <input name="registrado" type="checkbox" id="registrado" value="1" <?php if ($row['registrado']==1) { echo 'checked'; } ?>/>
  &nbsp;Registrado
  <input name="validos_senyalectica" type="checkbox" id="validos_senyalectica" value="1" <?php if ($row['validos_senyalectica']==1) { echo 'checked'; } ?>/>
&nbsp;V&aacute;lido Se&ntilde;al&eacute;ctica
<input name="id_imagen" type="hidden" id="id_imagen" value="<?php echo $id_imagen ?>" />
			  </p>
			  <p align="center">
			    <input type="button" name="Submit" value="Modificar" onclick="cargar_div('inc/gestion_imagenes/modificar_imagen.php','id_imagen='+document.form1.id_imagen.value+'&tipo_imagen='+document.form1.id_tipo_imagen.value+'&estado='+document.form1.estado.value+'&registrado='+document.form1.registrado.checked+'&autor='+document.form1.autor.value+'&licencia='+document.form1.licencia.value+'&tags='+document.form1.tags.value+'','informacion_imagen');" />
</p>
			</div>
  </form>
</div>



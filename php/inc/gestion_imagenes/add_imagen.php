<?php 
include ('../../classes/querys/query.php');

$query=new query();

$categ2=$query->listar_tipos_imagen();
$autores=$query->listar_autores();
$licencias=$query->listar_licencias();
?>

<div class="left" style="height:600px;">
	<h4>A&Ntilde;ADIR NUEVA  IMAGEN:</h4>
		<div class="left_box">
			<?php if (isset($mensaje)) { ?>
			<div id="mensaje" align="center"><?php echo $mensaje; ?></div>
			<?php } ?>

			<div id="simbolo" align="center"></div>

  </div>
</div>	
<div class="right">
	<h3>Crear desde:</h3>
		<div id="iframe"><iframe src="inc/upload.php" frameborder="0"></iframe></div>
			<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">		  
             <h3>Opciones:</h3>
			 <div class="right_articles" style="height:230px;">
                   <strong>Tipo imagen:</strong> 
                    <select name="id_tipo_imagen" id="id_tipo_imagen" required="1" realname="Categor&iacute;a" class="fonty">
                      <?php
						while ($row_rsCategorias=mysql_fetch_array($categ2)) { 
							if ($row_rsCategorias['ext'] != 'gif') { 
		  			  ?>
                      <option value="<?php echo $row_rsCategorias['id_tipo']?>"><?php echo utf8_encode($row_rsCategorias['tipo_imagen']); ?></option>
                      <?php 		} // Cierro el If
			 		 }  // Cierro el While ?>
                     </select>
                <p><strong>Estado:</strong>
                  <select name="estado" id="estado">
                    <option value="2">Pendiente revisi&oacute;n</option>
                    <option value="1" selected="selected">Visible</option>
                    <option value="0">No Visible</option>
                  </select>
				</p>
                <p><strong>Tipo de pictograma:</strong>
                  <select name="tipo_picto" id="tipo_picto">
                    <option value="2">Esquem&aacute;tico</option>
                    <option value="1" selected="selected">Realista</option>
                  </select>
                </p>
                <p><strong>Autor:</strong> 
                  <select name="autor" id="autor" required="1" realname="Autor" class="fonty">
                    <?php
						while ($row_rsAutor=mysql_fetch_array($autores)) { 
		  			  ?>
                    <option value="<?php echo $row_rsAutor['id_autor']?>" <?php if ($row_rsAutor['id_autor']==2) {echo "SELECTED";} ?>><?php echo utf8_encode($row_rsAutor['autor']); ?></option>
                    <?php 
			 		 }  // Cierro el While ?>
                  </select>
                </p>
                <p><strong>Licencia:</strong>
                  <select name="licencia" id="licencia" required="1" realname="Categor&iacute;a" class="fonty">
                    <?php
						while ($row_rsLicencia=mysql_fetch_array($licencias)) { 
					?>
                    <option value="<?php echo $row_rsLicencia['id_licencia']?>" <?php if ($row_rsLicencia['id_licencia']==2) {echo "SELECTED";} ?>><?php echo utf8_encode($row_rsLicencia['licencia']); ?></option>
                    <?php 
			 		 }  // Cierro el While ?>
                  </select>
				</p>
                <p><strong>Tags: </strong></p>
                <p>
                  <label>
                  <textarea name="tags" cols="30" rows="3" id="tags"></textarea>
                  </label>
                </p>
               <p>
             <input name="registrado" type="checkbox" id="registrado" value="1"/>
  &nbsp;<strong>Registrado</strong> 
  <input name="validos_senyalectica" type="checkbox" id="validos_senyalectica" value="1" />
&nbsp;V&aacute;lido Se&ntilde;al&eacute;ctica<br /></p>
			 </div>
             <h3><a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/gestion_imagenes/seleccionar_palabra.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:450}, okLabel: 'Cerrar'});"><img src="images/mas.gif" alt="Asociar palabra a imagen" border="0" /></a>Palabra/acepci&oacute;n:</h3>
             <p>
               <label>
               <input type="hidden" name="palabras_seleccionadas" id="palabras_seleccionadas" />
               </label>
             </p>
             <div class="right_articles" style="height:30px;">
			<div id="selected_word">
			
				  <div align="center">
				  <br><br>
                      <input type="button" name="Submit2" value="Guardar imagen" onclick="cargar_div('inc/gestion_imagenes/add_new_picture.php','tipo_imagen='+document.form1.id_tipo_imagen.value+'&imagen='+document.img_subida.imagen_subida.value+'&original_filename='+document.img_subida.original_filename.value+'&id_palabra='+document.form1.id_palabra.value+'&estado='+document.form1.estado.value+'&registrado='+document.form1.registrado.checked+'&autor='+document.form1.autor.value+'&licencia='+document.form1.licencia.value+'&tags='+document.form1.tags.value+'&tipo_picto='+document.form1.tipo_picto.value+'&validos_senyalectica='+document.form1.validos_senyalectica.checked+'','principal'); " disabled="disabled"/>
  				  </div>
				  			
			</div>

			</div>

  </form>
</div>
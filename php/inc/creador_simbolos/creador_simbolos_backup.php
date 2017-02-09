<?php 
session_start();

include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);

if (isset($_POST['img']) && $_POST['img'] !='' && isset($_POST['id_palabra']) && $_POST['id_palabra'] !='') {

	$id_palabra=$_POST['id_palabra'];
	$datos_palabra=$query->datos_palabra($_POST['id_palabra']);
	$idiomas_disponibles=$query->idiomas_disponibles($id_palabra,1);
	$tipos_imagen=$query->listar_tipos_imagen();

	$dir="../../temp/";
	$borrar=CleanFiles($dir); //Borro los archivos temporales
	$nombre_img=basename(tempnam("../../temp",'tmp')); 
	
	$imagen_original=$_POST['img'];
	$extension = strtolower(substr(strrchr($imagen_original, "."), 1));
	
	$nueva_imagen=$nombre_img.'.'.$extension;
	
	copy ('../../repositorio/originales/'.$imagen_original,'../../temp/'.$nueva_imagen);
	
	$usar_imagen='<div id="products"><a href="javascript:void(0);" onClick="sendData(\''.md5('temp/').'/'.$nueva_imagen.'\');"><img src=\'images/cesto.gif\' border="0" alt="Añadir simbolo a mi cesto"></a></div><br><br><div align="center"><img src=\'temp/'.$nueva_imagen.'\'><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$nueva_imagen.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nueva_imagen.'"/></form></div>';
	
	$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty">'.utf8_encode($datos_palabra['palabra']).'</textarea>  <input name="id_palabra" type="hidden" id="id_palabra" value="'.$datos_palabra['id_palabra'].'" size="3" maxlength="3" /> <br><em><strong>'.utf8_encode($datos_palabra['palabra']).',</strong></em>&nbsp;'.utf8_encode($datos_palabra['definicion']).'<br><br><strong>Idiomas disponibles</strong><br>';
	
	$palabra_seleccionada.=idiomas_disponibles($id_palabra,$idiomas_disponibles);
	
	$imagenes_disponibles=imagenes_disponibes($tipos_imagen,$query,$datos_palabra['id_palabra']);

} else {

	$usar_imagen='';
	$id_palabra='';
	$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty"></textarea>  <input name="id_palabra" type="hidden" id="id_palabra" value="" size="3" maxlength="3" /> <input name="idioma" type="hidden" id="idioma" value="0" />';
	$imagenes_disponibles='';

}
?>
<div class="left" style="height:650px;">
	<h3>CREADOR DE SIMBOLOS:</h3>
			<div class="left_box">
				<?php if ($mensaje) { ?>
<div id="mensaje" align="center"><?php echo $mensaje; ?></div>
<?php } ?>

<div id="simbolo" align="center">
<?php echo $usar_imagen; ?>
</div>

<h3>IMAGENES DISPONIBLES:</h3>
<div id="imagenes_disponibles" align="left">
<?php echo $imagenes_disponibles; ?>
</div>

	</div>
</div>	
		<div class="right">
			<h3>Crear:</h3>
		    <div align="center">
                      <p>
                        <input type="button" name="Submit2" value="Previsualizar" onclick="previsualizar();" />
                        <?php if ($_SESSION['AUTHORIZED']== true && $permisos['add_simbolos']==1) { ?>
                        <input type="button" name="Submit2" value="Incorporar al catalogo" onclick="Dialog.alert({url: 'inc/creador_simbolos/incorporar_catalogo.php?img='+document.img_subida.imagen_actual.value+'&id_palabra='+document.form1.id_palabra.value+'&id_idioma='+document.form1.idioma.value+'&marco='+document.form1.marco.value+'&contraste='+document.form1.accion.value+'', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:450}, okLabel: 'Cerrar'});" />
                        <?php } ?>
                      </p>
                      <p>&nbsp;</p>
		    </div>
			<h3>Texto &nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/creador_simbolos/seleccionar_palabra.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:700}, okLabel: 'Cerrar'});"><img src="images/traduccion.gif" alt="Seleccionar palabra" border="0" /></a></h3>
			<div class="right_articles" style="height:260px;">
				<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                  <p>
				  
				  
				  <div id="selected_word">
                    <?php echo $palabra_seleccionada; ?>			  
				  </div>
				</p>

                  <div id="posicion_texto"> <strong>Posici&oacute;n del texto en la imagen</strong> <br />
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><div align="center">Castell</div></td>
                          <td><div align="center">Idioma</div></td>
                          <td><div align="center">Castell</div></td>
                          <td><div align="center">Sin idioma</div></td>
                          <td><div align="center">Sin texto </div></td>
                        </tr>
                        <tr>
                          <td width="20%"><div align="center">
                              <input name="orden" type="radio" value="1" />
                          </div></td>
                          <td width="20%"><div align="center">
                              <input name="orden" type="radio" value="2" />
                          </div></td>
                          <td width="20%"><div align="center">
                              <input name="orden" type="radio" value="3" />
                          </div></td>
                          <td width="20%"><div align="center">
                              <input name="orden" type="radio" value="4" checked="checked" />
                          </div></td>
                          <td width="20%"><div align="center">
                              <input name="orden" type="radio" value="5" />
                          </div></td>
                        </tr>
                        <tr>
                          <td width="20%"><div align="center">Idioma</div></td>
                          <td width="20%"><div align="center">Castell</div></td>
                          <td width="20%"><div align="center">Sin idioma </div></td>
                          <td width="20%"><div align="center">Castell</div></td>
                          <td width="20%"><div align="center">Sin texto </div></td>
                        </tr>
                    </table>
                    <div id="idiomas_disponibles" align="center"></div>
                  </div>
                  <br />
                  <p align="center"><strong>Parte superior </strong><br />
                      <select name="size_font_sup" size="1" id="size_font_sup" class="fonty">
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="12">12</option>
                        <option value="14">14</option>
                        <option value="16">16</option>
                        <option value="18">18</option>
                        <option value="20">20</option>
                        <option value="24">24</option>
                        <option value="28">28</option>
                        <option value="32">32</option>
                        <option value="36" selected="selected">36</option>
                        <option value="40">40</option>
                        <option value="44">44</option>
                        <option value="48">48</option>
                        <option value="52">52</option>
                      </select>
                      <select name="sup_may" size="1" id="sup_may" class="fonty">
                        <option value="0" selected="selected">Min&uacute;sculas</option>
                        <option value="1">May&uacute;sculas</option>
                      </select>
                      <span class="Estilo1">
                      <input name="color_sup" type="text" id="color_sup" value="#000000" size="7" maxlength="7" readonly="yes"/>
                      </span><a href="javascript:TCP.popup(document.forms['form1'].elements['color_sup'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="images/color_font.gif" /></a> <a href="javascript:TCP.popup(document.forms['form1'].elements['color_sup'])"></a> <br />
                      <br />
                  </p>
                  <div align="center">
                    <p><strong>Parte inferior</strong><br />
                        <select name="size_font_inf" size="1" id="size_font_inf" class="fonty">
                          <option value="9">9</option>
                          <option value="10">10</option>
                          <option value="12">12</option>
                          <option value="14">14</option>
                          <option value="16">16</option>
                          <option value="18">18</option>
                          <option value="20">20</option>
                          <option value="24">24</option>
                          <option value="28">28</option>
                          <option value="32">32</option>
                          <option value="36" selected="selected">36</option>
                          <option value="40">40</option>
                          <option value="44">44</option>
                          <option value="48">48</option>
                          <option value="52">52</option>
                        </select>
                        <select name="inf_may" size="1" id="inf_may" class="fonty">
                          <option value="0" selected="selected">Min&uacute;sculas</option>
                          <option value="1">May&uacute;sculas</option>
                        </select>
                        <span class="Estilo1">
                        <input name="color_inf" type="text" id="color_inf" value="#000000" size="7" maxlength="7" readonly="yes"/>
                        </span> <a href="javascript:TCP.popup(document.forms['form1'].elements['color_inf'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="images/color_font.gif" /></a><br />
                    </p>
					<br />
                  </div>
				
                  <h3>Opciones:</h3>
				  <div class="right_articles" style="height:150px;">
                  <p><strong>Marco:</strong><br />
                    <select name="marco" size="1" id="marco" class="fonty">
                                    <option value="0">Sin marco</option>
                                    <option value="1" selected="selected">Con marco</option>
                    </select>
                    <input name="accion" type="hidden" id="accion" value="normal" />
                    <span class="Estilo1">
                    <input name="grosor" type="text" id="grosor" value="3" size="2" maxlength="1"/>
                    </span>                    <span class="Estilo1">
                    <input name="color_borde" type="text" id="color_borde" value="#000000" size="7" maxlength="7" readonly="yes"/>
                    </span> <a href="javascript:TCP.popup(document.forms['form1'].elements['color_borde'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="images/color_font.gif" /></a></p>
                  <p><strong>Contraste:</strong></p>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="31%"><div align="center"><a href="javascript:void(0);" onclick="document.form1.accion.value='normal'; previsualizar();"><img src="images/normal.jpg" width="50" height="49" border="0" /></a></div></td>
                      <td width="25%"><div align="center"><a href="javascript:void(0);" onclick="document.form1.accion.value='invertir'; previsualizar();"><img src="images/invertir.jpg" width="50" height="49" border="0" /></a></div></td>
                      <td width="44%"><div align="center"><a href="javascript:void(0);" onclick="document.form1.accion.value='alto_contraste'; previsualizar();"><img src="images/alto_contraste.jpg" width="50" height="49" border="0" /></a></div></td>
                    </tr>
                    <tr>
                      <td><div align="center">Normal</div></td>
                      <td><div align="center">Invertido</div></td>
                      <td><div align="center">
                        Alto contraste<br />
                        <input name="color_alto_contraste" type="text" id="color_alto_contraste" value="#FFFF00" size="7" maxlength="7" readonly="yes" style="background-color:#FFFF00;"/>
                        <a href="javascript:TCP.popup(document.forms['form1'].elements['color_alto_contraste'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="images/color_font.gif" /></a><a href="javascript:void(0);" onclick="document.form1.accion.value='alto_contraste'; previsualizar();"></a><a href="javascript:void(0);" onclick="document.form1.accion.value='invertir'; previsualizar();"></a><a href="javascript:void(0);" onclick="document.form1.accion.value='normal'; previsualizar();"></a></div></td>
                    </tr>
                  </table>
				</div>
<h3>Crear desde archivo:</h3>
		<div id="iframe">
<iframe src="inc/upload.php" frameborder="0"></iframe>
</div>

		</form>
			</div>
			
		</div>	

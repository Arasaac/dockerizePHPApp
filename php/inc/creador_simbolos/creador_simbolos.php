<?php 
session_start();

include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$color='#000000';

if (isset($_POST['img']) && $_POST['img'] !='' && isset($_POST['id_palabra']) && $_POST['id_palabra'] !='') {

	$id_palabra=$_POST['id_palabra'];
	$datos_palabra=$query->datos_palabra($_POST['id_palabra']);
	$idiomas_disponibles=$query->idiomas_disponibles($id_palabra,1);
	$tipos_imagen=$query->listar_tipos_imagen();
	
	$id_tipo_palabra=$datos_palabra['id_tipo_palabra'];
	
	switch ($id_tipo_palabra) {
	
		case 1:
		$color='#FFFF00';
		break;
	
		case 2:
		$color='#FF9900';
		break;
		
		case 3:
		$color='#33CC00';
		break;
		
		case 4:
		$color='#3366FF';
		break;
		
		case 5:
		$color='#FF66CC';
		break;
		
		case 6:
		$color='#FFFFFF';
		break;
		
		default:
		$color='#000000';
		break;
	
	}

	$dir="../../temp/";
	$borrar=CleanFiles($dir); //Borro los archivos temporales
	$nombre_img=basename(tempnam("../../temp",'tmp')).'_'.$_POST['id_palabra']; 
	
	$imagen_original=$_POST['img'];
	$extension = strtolower(substr(strrchr($imagen_original, "."), 1));
	
	$nueva_imagen=$nombre_img.'.'.$extension;
	
	copy ('../../repositorio/originales/'.$imagen_original,'../../temp/'.$nueva_imagen);
	
	$ruta_cesto='ruta_cesto=temp/'.$nueva_imagen;
	$encript->encriptar($ruta_cesto,1);
	
	$ruta='img=../../temp/'.$nueva_imagen;
	$encript->encriptar($ruta,1);
					
	$usar_imagen='<div id="products" style="height:5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="Añadir simbolo a mi cesto"></a><a href="inc/public/descargar.php?i='.$ruta.'""><img src=\'images/download1.png\' border="0" alt="Descargar simbolo"></a></div><br><div align="center"><img src=\'temp/'.$nueva_imagen.'\'><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$nueva_imagen.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nueva_imagen.'"/></form></div>';
	
	$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty">'.$datos_palabra['palabra'].'</textarea>  <input name="id_palabra" type="hidden" id="id_palabra" value="'.$datos_palabra['id_palabra'].'" size="3" maxlength="3" /> <br><em><strong>'.$datos_palabra['palabra'].',</strong></em>&nbsp;'.utf8_encode($datos_palabra['definicion']).'<br><br><strong>Idiomas disponibles</strong><br>';
	
	$palabra_seleccionada.=idiomas_disponibles($id_palabra,$idiomas_disponibles,$query);
	
	$imagenes_disponibles=imagenes_disponibes($tipos_imagen,$query,$datos_palabra['id_palabra'],$encript);

} else {

	$usar_imagen='';
	$id_palabra='';
	$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty"></textarea>  <input name="id_palabra" type="hidden" id="id_palabra" value="" size="3" maxlength="3" /> <input name="id_traduccion" type="hidden" id="id_traduccion" value="0" />';
	$imagenes_disponibles='';

}
?>
<div class="left" style="height:1550px;">
	<h4>CREADOR DE SIMBOLOS:</h4>
<div class="left_box">
				<?php if ($mensaje) { ?>
<div id="mensaje" align="center"><?php echo $mensaje; ?></div>
<?php } ?>

<div id="simbolo" align="center">
<?php echo $usar_imagen; ?>
</div>
<br /><br /><br />
<h4>IMAGENES DISPONIBLES:</h4>
<br />
<div id="imagenes_disponibles" align="left" style="width:100%">
<?php echo $imagenes_disponibles; ?>
</div>

	</div>
</div>	
<div class="right">
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

<!-- ITEM 0 -->
<h3><a  href="javascript:void();" onClick="shoh('imagen9');" ><img src="images/u.gif" alt="Desplegar opciones" name="imgimagen9" width="9" height="9" border="0" ></a>&nbsp;Buscar pictograma/imagen</h3>

	<div style="display:block;" id="imagen9" >
      <blockquote>
        <p style="font-size:12px;"><a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/creador_simbolos/seleccionar_palabra.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:700}, okLabel: 'Cerrar'});"><img src="images/search.gif" alt="Seleccionar palabra" title="Seleccionar palabra" border="0" /></a> &nbsp;<a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/creador_simbolos/seleccionar_palabra.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:700}, okLabel: 'Cerrar'});"><b>Por palabra</b></a>	<br />
          <br />
          </p>
      </blockquote>
	</div>
    
<!-- PRIMER ITEM -->
<h3><a  href="javascript:void();" onClick="shoh('imagen1');" ><img src="images/u.gif" alt="Desplegar opciones" name="imgimagen1" width="9" height="9" border="0" ></a>&nbsp;Crear </h3>

	<div style="display:block;" id="imagen1" >
			
		    <div align="center">
                      <p>
                      <input type="button" name="Submit2" value="Limpiar &aacute;rea de trabajo" onclick="limpiar_lienzo_creador_simbolos();" />
                        <input type="button" name="Submit2" value="Previsualizar" onclick="previsualizar(); document.form1.pixels_lienzo.value='';" />
                        <?php if ($_SESSION['AUTHORIZED']== true && $permisos['add_simbolos']==1) { ?>
                        <input type="button" name="Submit2" value="Incorporar al catalogo" onclick="Dialog.alert({url: 'inc/creador_simbolos/incorporar_catalogo.php?img='+document.img_subida.imagen_actual.value+'&id_palabra='+document.form1.id_palabra.value+'&id_idioma='+document.form1.idioma.value+'&marco='+document.form1.marco.value+'&contraste='+document.form1.accion.value+'', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:450, height:400}, okLabel: 'Cerrar'});" />
                        <?php } ?>
                      </p>
                      <p>&nbsp;</p>
		    </div>	
	</div>
    
<!-- SEGUNDO ITEM -->	
<h3><a  href="javascript:void();" onClick="shoh('imagen2');" ><img src="images/u.gif" alt="" name="imgimagen2" width="9" height="9" border="0" ></a>&nbsp;Texto del s&iacute;mbolo: </h3>		 

	<div style="display:block;" id="imagen2" >
	  <div id="selected_word">
                    <?php echo $palabra_seleccionada; ?>				  </div>		
	</div>

<!-- SEGUNDO ITEM -->	
<h3><a  href="javascript:void();" onClick="shoh('imagen3');" ><img src="images/u.gif" alt="" name="imgimagen3" width="9" height="9" border="0" ></a>&nbsp;Texto en la imagen: </h3>

				<div style="display:block;" id="imagen3" align="left">
				  <p><strong>Fuente para texto en Castellano:</strong> 
				    <select name="fuente_castellano" size="1" id="fuente_castellano" class="fonty">
                      <option value="arial" selected="selected">Arial</option>
                      <option value="times">Times</option>
                      <option value="timesi">Times Cursiva</option>
                      <option value="georgia">Georgia</option>
                      <option value="georgiab">Georgia Negrita</option>
                      <option value="georgiai">Georgia Cursiva</option>
                      <option value="verdana">Verdana</option>
                      <option value="verdanab">Verdana Negrita</option>
                      <option value="verdanai">Verdana Cursiva</option>
                      <option value="booescolar8c">Escolar 1</option>
                      <option value="edelfontmed">Escolar 2</option>
                      <option value="massallerac">Escolar 3</option>
                      <option value="Memim">Escolar 4</option>
                      <option value="MemimBol">Escolar 4 Negrita</option>
                      <option value="escolar4pc">Escolar Punteada</option>
                    </select>
				  </p>
				  <p><strong>Parte superior</strong></p>
<p>
				      <select name="sup_idioma" size="1" id="sup_idioma" class="fonty">
				        <option value="0" selected="selected">Sin idioma</option>
				        <option value="1">Castellano</option>
				        <option value="2">Idioma</option>
		                </select> 
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
				        <option value="30">30</option>
				        <option value="32">32</option>
				        <option value="34">34</option>
				        <option value="36" selected="selected">36</option>
				        <option value="40">40</option>
				        <option value="42">42</option>
				        <option value="44">44</option>
				        <option value="44">46</option>
				        <option value="48">48</option>
				        <option value="52">52</option>
                        <option value="56">56</option>
                        <option value="58">58</option>
                        <option value="60">60</option>
                        <option value="62">62</option>
                        <option value="66">66</option>
                        <option value="70">70</option>
		                </select>
				      <select name="sup_may" size="1" id="sup_may" class="fonty">
				        <option value="0" selected="selected">Min&uacute;sculas</option>
				        <option value="1">May&uacute;sculas</option>
		                </select>
		            <input name="color_sup" type="text" id="color_sup" value="#000000" size="7" maxlength="7" readonly="yes"/>
		            <a href="javascript:TCP.popup(document.forms['form1'].elements['color_sup'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="images/color_font.gif" /></a> <a href="javascript:TCP.popup(document.forms['form1'].elements['color_sup'])"></a></p>
				  <p><strong>Parte inferior</strong></p>
				  <p>
				    <select name="inf_idioma" size="1" id="inf_idioma" class="fonty">
				      <option value="0">Sin idioma</option>
				      <option value="1" selected="selected">Castellano</option>
				      <option value="2">Idioma</option>
			        </select>                                    
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
				      <option value="30">30</option>
				      <option value="32">32</option>
				      <option value="34">34</option>
				      <option value="36" selected="selected">36</option>
				      <option value="40">40</option>
				      <option value="42">42</option>
				      <option value="44">44</option>
				      <option value="44">46</option>
				      <option value="48">48</option>
				      <option value="52">52</option>
                      <option value="56">56</option>
                      <option value="58">58</option>
                      <option value="60">60</option>
                      <option value="62">62</option>
                      <option value="66">66</option>
                      <option value="70">70</option>
			        </select>
				    <select name="inf_may" size="1" id="inf_may" class="fonty">
				      <option value="0" selected="selected">Min&uacute;sculas</option>
				      <option value="1">May&uacute;sculas</option>
				      </select>
				    <input name="color_inf" type="text" id="color_inf" value="#000000" size="7" maxlength="7" readonly="yes"/>
				    </span> <a href="javascript:TCP.popup(document.forms['form1'].elements['color_inf'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="images/color_font.gif" /></a><br />
			      </p>
	</div>

<!-- CUARTO ITEM -->	                        
<h3><a  href="javascript:void();" onClick="shoh('imagen4');" ><img src="images/u.gif" alt="" name="imgimagen4" width="9" height="9" border="0" ></a>&nbsp;Marco</h3>

	<div style="display: block;" id="imagen4" >	      
  		<p>
		  
  		<table width="300" border="0" cellpadding="0" cellspacing="0">
<tr align="left">
                    <td width="73%"><select name="marco" size="1" id="marco" class="fonty">
                      <option value="0">Sin marco</option>
                      <option value="1" selected="selected">Con marco</option>
                    </select>
                      <input name="accion" type="hidden" id="accion" value="normal" />
                      &nbsp;&nbsp;Grosor
                      <input name="grosor" type="text" id="grosor" value="9" size="3" maxlength="2"/>
          px</td>
<td width="14%" align="left"><div id="color_borde">
		  <input name="color_borde" type="text" id="color_borde" value="<?php echo $color ?>" size="7" maxlength="7" readonly="yes" style="background-color:<?php echo $color ?>;"/> </div></td>
          <td width="13%" align="left"><a href="javascript:TCP.popup(document.forms['form1'].elements['color_borde'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="images/color_font.gif" /></a></td>
          </tr>
                </table>
                
	  </p>
	</div>
<br/>	
<!-- LIENZAO ITEM -->	                        
<h3><a  href="javascript:void();" onClick="shoh('imagen7');" ><img src="images/u.gif" alt="" name="imgimagen7" width="9" height="9" border="0" ></a>&nbsp;Lienzo</h3>

	<div style="display: block;" id="imagen7" >	      
  		<p>Ampliar lienzo: <input name="pixels_lienzo" type="text" id="pixels_lienzo" size="3" maxlength="3"/> pixels (entre 1 y 999)</p>
  		<p>Tama&ntilde;o final del lienzo: 
  		  <select name="pixels_final" size="1" id="pixels_final" class="fonty">
            <option value="0" selected="selected">No redimensionar</option>
            <option value="100">100x100</option>
            <option value="150">150x150</option>
            <option value="200">200x200</option>
            <option value="250">250x250</option>
            <option value="300">300x300</option>
            <option value="350">350x350</option>
            <option value="400">400x400</option>
            <option value="450">450x450</option>
            <option value="500">500x500</option>
            <option value="600">600x600</option>
            <option value="700">700x700</option>
            <option value="800">800x800</option>
          </select>
  		</p>
	</div>
   
<br/>
<!-- CUARTO ITEM -->	
<h3><a  href="javascript:void();" onClick="shoh('imagen5');" ><img src="images/u.gif" alt="" name="imgimagen5" width="9" height="9" border="0" ></a>&nbsp;Contraste</h3>

	<div style="display: block;" id="imagen5" >
	
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


<!-- SEXTO ITEM -->	
<h3><a href="javascript:void();" onClick="shoh('imagen6');" ><img src="images/u.gif" alt="" name="imgimagen6" width="9" height="9" border="0" ></a>&nbsp;Crear desde archivo</h3>

	<div style="display: none;" id="imagen6" >
 		<div id="iframe">
			<iframe src="inc/upload.php" frameborder="0"></iframe>
		</div>
	</div>
  </form>
	
</div>
		
</div>

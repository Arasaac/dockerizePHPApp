<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
$query=new query();

if (isset($_POST['desde']) && $_POST['desde']==1) { //Si la plantilla es personalizada muestro el menú de tablero perasonalizado
 
} else { // en caso contrario compruebo que esté estblecido el numero de plantilla y que sea mayor de 0

if (isset($_POST['id']) && $_POST['id'] >0) {

$datos=$query->datos_plantilla_panel($_POST['id']);
?>
<p><strong>Borde:</strong></p>
    <p>Borde celda:
      <select name="borde_celdas" id="borde_celdas">
      <option value="<?php echo $datos['default_borde_celda']; ?>" selected="selected"><?php if ($datos['default_borde_celda']==1) { echo "Con Borde"; } elseif ($datos['default_borde_celda']==0) { echo "Sin Borde"; } ?></option>
        <option value="1">Con Borde</option>
        <option value="0">Sin Borde</option>
      </select>
      <select name="tipo_borde_celdas" id="tipo_borde_celdas">
        <option value="single">single</option>
        <option value="dot">dot</option>
        <option value="dash">dash</option>
        <option value="dotdash">dotdash</option>
      </select>
    </p>
    <p>Ancho borde:
      <label>
      <select name="ancho_borde_celdas" id="ancho_borde_celdas">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select>
      </label>
puntos
<input name="color_borde_celdas" type="text" id="color_borde_celdas" value="#000000"  size="3" maxlength="7" disabled="disabled"  style="background-color:#000000;" />
<a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_borde_celdas'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="../../../images/color_font.gif" /></a></p>
    <p><strong>Texto:</strong></p>
    <p>Posici&oacute;n:
      <select name="posic_texto_celda" size="1" id="posic_texto_celda">
      
      <option value="<?php echo $datos['default_posicion_texto_celda']; ?>" selected="selected"><?php if ($datos['default_posicion_texto_celda']==0) { echo "Sin texto"; } elseif ($datos['default_posicion_texto_celda']==1) { echo "Superior"; } elseif ($datos['default_posicion_texto_celda']==2) { echo "Inferior"; }?></option>
        <option value="0">Sin texto</option>
        <option value="1">Superior</option>
        <option value="2">Inferior</option>
      </select>
</p>
    <p>Fuente:
      <select name="fuente_texto_celda" size="1" id="fuente_texto_celda" class="fonty">
          <option value="Arial">Arial</option>
          <option value="Times">Times</option>
          <option value="Georgia">Georgia</option>
          <option value="Verdana">Verdana</option>
          <option value="Memima">Memima</option>
      </select>
      <select name="transform_texto_celda" size="1" id="transform_texto_celda" class="fonty">
        <option value="0">Normal</option>
        <option value="1">Negrita</option>
        <option value="2">Cursiva</option>
        <option value="3">Negrita y Cursiva</option>
      </select>
    </p>
    <p>Tama&ntilde;o:
      <select name="size_font_texto_celda" size="1" id="size_font_texto_celda" class="fonty">
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
          <option value="36">36</option>
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
      <select name="may_texto_celda" size="1" id="may_texto_celda" class="fonty">
          <option value="0">Min&uacute;sculas</option>
          <option value="1">May&uacute;sculas</option>
      </select>
      <input name="color_texto_celdas" type="text" id="color_texto_celdas" value="#000000"  size="3" maxlength="7" disabled="disabled"  style="background-color:#000000;" />
      <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_texto_celdas'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="../../../images/color_font.gif" /></a></p>
    <p><strong>Imagen:</strong></p>
    <p>Tama&ntilde;o imagen sin texto: 
      <select name="tist" size="1" id="tist" class="fonty">
      	<option value="<?php echo $datos['img_size_no_text']; ?>"selected="selected"><?php echo $datos['img_size_no_text']; ?></option>
        <option value="1">1</option>
        <option value="1.5">1.5</option>
        <option value="2">2</option>
        <option value="2.5">2.5</option>
        <option value="2.8">2.8</option>
        <option value="3">3</option>
        <option value="3.3">3.3</option>
        <option value="3.6">3.6</option>
        <option value="3.9">3.9</option>
        <option value="4">4</option>
        <option value="4.3">4.3</option>
        <option value="4.6">4.6</option>
        <option value="4.9">4.9</option>
        <option value="5">5</option>
        <option value="5.3">5.3</option>
        <option value="5.6">5.6</option>
        <option value="5.9">5.9</option>
        <option value="48">48</option>
        <option value="6">6</option>
        <option value="6.5">6.5</option>
        <option value="7">7</option>
        <option value="7.5">7.5</option>
        <option value="8">8</option>
        <option value="8.5">8.5</option>
        <option value="9">9</option>
      </select>
    </p>
    <p>Tama&ntilde;o imagen con texto: 
      <select name="tict" size="1" id="tict">
      	<option value="<?php echo $datos['img_size_with_text']; ?>"selected="selected"><?php echo $datos['img_size_with_text']; ?></option>
        <option value="1">1</option>
        <option value="1.5">1.5</option>
        <option value="2">2</option>
        <option value="2.5">2.5</option>
        <option value="2.8">2.8</option>
        <option value="3">3</option>
        <option value="3.3">3.3</option>
        <option value="3.6">3.6</option>
        <option value="3.9">3.9</option>
        <option value="4">4</option>
        <option value="4.3">4.3</option>
        <option value="4.6">4.6</option>
        <option value="4.9">4.9</option>
        <option value="5">5</option>
        <option value="5.3">5.3</option>
        <option value="5.6">5.6</option>
        <option value="5.9">5.9</option>
        <option value="48">48</option>
        <option value="6">6</option>
        <option value="6.5">6.5</option>
        <option value="7">7</option>
        <option value="7.5">7.5</option>
        <option value="8">8</option>
        <option value="8.5">8.5</option>
        <option value="9">9</option>
      </select>
    </p>
    <p>&nbsp;</p>
    <div align="center">
      <input type="button" value="APLICAR TODAS LAS CELDAS" style="font-size:16px;" onclick="configurar_todas_celdas(''+document.generador_paneles.n_paneles.value+'',''+document.generador_paneles.n_filas.value+'',''+document.generador_paneles.n_columnas.value+'',''+document.generador_paneles.borde_celdas.value+'',''+document.generador_paneles.ancho_borde_celdas.value+'',''+document.generador_paneles.posic_texto_celda.value+'',''+document.generador_paneles.fuente_texto_celda.value+'',''+document.generador_paneles.size_font_texto_celda.value+'',''+document.generador_paneles.may_texto_celda.value+'',''+document.generador_paneles.tist.value+'',''+document.generador_paneles.tict.value+'',''+document.generador_paneles.tipo_borde_celdas.value+'',''+document.generador_paneles.color_borde_celdas.value+'',''+document.generador_paneles.color_texto_celdas.value+'');" />
      <label></label>
    </div>

<?php }

} ?>
</p>

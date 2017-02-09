<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
$query=new query();

if (isset($_POST['desde']) && $_POST['desde']==1) { //Si la plantilla es personalizada muestro el menú de tablero perasonalizado
?>
<p><strong>Configuraci&oacute;n del Panel:</strong></p><br />
<p>Papel:
  <select name="papel" id="papel">
    <option value="a4h" selected="selected">A4 Horizontal</option>
    <option value="a4v">A4 Vertival</option>
    <option value="a5h">A5 Horizontal</option>
    <option value="a5v">A5 Vertical</option>
    </select> 
  <label></label>
</p>
<p>Filas: 
          <label>
          <input name="filas" type="text" id="filas" size="3" maxlength="2" />
          </label>
</p>
        <p>Columnas: 
          <input name="columnas" type="text" id="columnas" size="3" maxlength="2" />
</p>
        <p>Borde: 
          <select name="borde" id="borde">
            <option value="1">Marco exterior Tabla</option>
            <option value="2" selected="selected">Tabla y Celdas</option>
          </select>
          <input name="color_borde" type="text" id="color_borde" value="#000000"  size="3" maxlength="7" disabled="disabled"  style="background-color:#000000;" />
<a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_borde'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="../../../images/color_font.gif" /></a></p>
        <p>Encabezado: 
          <label>
          <select name="encabezado" id="encabezado">
            <option value="1">Con encabezado</option>
            <option value="0">Sin encabezado</option>
          </select>
          </label>
<?php 
} else { // en caso contrario compruebo que esté estblecido el numero de plantilla y que sea mayor de 0

if (isset($_POST['id']) && $_POST['id'] >0) {

$datos=$query->datos_plantilla_panel($_POST['id']);
?>
<p><strong>Configuraci&oacute;n del Panel:</strong></p>
<?php if ($datos['selector_orientacion']==1) { ?>
Orientaci&oacute;n: 
<select name="orientacion" id="orientacion">
  <option value="<?php echo $datos['default_orientacion']; ?>" selected="selected"><?php if ($datos['default_orientacion']==1) { echo "Vertical"; } elseif ($datos['default_orientacion']==2) { echo "Horizontal"; } ?></option>
  <option value="1">Vertical</option>
  <option value="2">Horizontal</option>
</select>
<?php } else { ?>
<input name="orientacion" type="hidden" value="<?php echo $datos['default_orientacion']; ?>" />
<?php }?>
<br /><br />
<p>N&ordm; Paneles:
  <label>
  <input name="n_paneles" type="text" id="n_paneles" value="<?php echo $datos['n_paneles']; ?>" size="3" maxlength="1" disabled="disabled" />
  </label>
</p>
<p>N&ordm; Hojas: 
  <input name="n_hojas" type="text" id="n_hojas" value="<?php echo $datos['n_hojas']; ?>" size="3" maxlength="1" disabled="disabled"/>
</p>
<p>N&ordm; Filas:

  <input name="n_filas" type="text" id="n_filas" value="<?php echo $datos['n_filas']; ?>" size="3" maxlength="2" disabled="disabled"/>
</p>
<p>N&ordm; Columnas: 
  <input name="n_columnas" type="text" id="n_columnas" value="<?php echo $datos['n_columnas']; ?>" size="3" maxlength="2" disabled="disabled"/>
</p>
<p>Ancho Panel: 
  
  <input name="ancho_panel" type="text" id="ancho_panel" value="<?php echo $datos['ancho_panel']; ?>" size="3" maxlength="2" disabled="disabled"/> 
pt.</p>
<p>Alto Panel: 
  <input name="alto_panel" type="text" id="alto_panel" value="<?php echo $datos['alto_panel']; ?>" size="3" maxlength="2" disabled="disabled"/> 
  pt.</p>
  <?php if ($datos['color_fondo_panel']) { ?>
<p>Color de fondo 
  <input name="color_fondo" type="text" id="color_fondo" value="<?php echo $datos['default_color_fondo_panel']; ?>"  size="7" maxlength="7" />
  <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_fondo'])"><img width="18" height="18" border="0" alt="Seleccione el color de fondo" src="../../../images/color_font.gif" /></a></p>
  <?php } ?>
<p><strong>Borde exterior panel:</strong></p>
<p>Borde:<strong> 
  <label>    </label>
</strong>
  <label><select name="borde" id="borde">
    <option value="1" <?php if ($datos['con_borde']==1) { echo 'selected="selected" '; } ?>>Con Borde</option>
    <option value="0" <?php if ($datos['con_borde']==0) { echo 'selected="selected" '; } ?>>Sin Borde</option>
  </select>
  </label>
  <select name="tipo_borde" id="tipo_borde">
    <option value="single" selected="selected">single</option>
    <option value="dot">dot</option>
    <option value="dash">dash</option>
    <option value="dotdash">dotdash</option>
    </select>
</p>
<p>Ancho borde: 
  <label>
  <select name="ancho_borde" id="ancho_borde">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3" selected="selected">3</option>
  </select>
  </label> 
  puntos
</p>
<p>Color borde: 
  <input name="color_borde" type="text" id="color_borde" value="<?php echo $datos['color_borde']; ?>"  size="7" maxlength="7" />
  <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_borde'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="../../../images/color_font.gif" /></a>
  <?php } 

} ?>
</p>

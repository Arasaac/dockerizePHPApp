<div class="left">
<h4>Gesti&oacute;n de s&iacute;mbolos </h4>
<br />
<form action="" method="post" name="catalogo_simbolos" id="catalogo_simbolos">
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr valign="middle">
      <td><p><strong>Tipo de palabra: </strong>
            <?php $categ3=$query->listar_categorias_palabras(); ?>
            <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">
              <option value="99" <?php echo $seleccionado_tipo_palabra; ?>>Todas</option>
              <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
              <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>" <?php if ($id_tipo==$row_rsCategorias3['id_tipo_palabra']) { echo 'selected="selected"'; } ?>><?php echo $row_rsCategorias3['tipo_palabra']; ?></option>
              <?php }  ?>
            </select>
      <strong>comienza por</strong>
            <input name="letra" type="text" id="letra" onkeypress="return handleEnter(this, event)" value="<?php echo $letra; ?>" size="20"/>
        <strong>Tipo de Pictograma</strong>
            <label>
            <select name="tipo_simbolo" id="tipo_simbolo">
              <option value="99" selected="selected" <?php echo $seleccionado_tipo_pictograma; ?>>Cualquiera</option>
              <option value="5 <?php if ($id_tipo_simbolo==5) { echo 'selected="selected"'; } ?>">Pictogramas ByN</option>
              <option value="10" <?php if ($id_tipo_simbolo==10) { echo 'selected="selected"'; } ?>>Pictogramas Color</option>
              <option value="2" <?php if ($id_tipo_simbolo==2) { echo 'selected="selected"'; } ?>>Fotograf&iacute;a</option>
            </select>
            </label>
        <strong>Marco</strong>
            <label>
            <select name="marco" id="marco">
              <?php 
							if ($marco==1) { echo '<option value="1" selected="selected">Con marco</option>'; } 
							elseif ($marco==0) { echo '<option value="0">Sin marco</option>'; } 
							elseif ($marco==99) { echo '<option value="99">Con y Sin Marco</option>'; } 
							?>
              <option value="1">Con marco</option>
              <option value="0">Sin marco</option>
              <option value="99" selected="selected">Con y Sin Marco</option>
            </select>
            </label>
        </p>
        <p><strong>Contraste</strong>
          <label>
            <select name="contraste" id="contraste">
              <?php 
							if ($contraste==1) { echo '<option value="1" selected="selected">Normal</option>'; } 
							elseif ($contraste==2) { echo '<option value="2" selected="selected">Invertido</option>'; }
							elseif ($contraste==99) { echo '<option value="99" selected="selected">Cualquiera</option>'; }  
							?>
              <option value="1">Normal</option>
              <option value="2">Invertido</option>
              <option value="99" selected="selected">Cualquiera</option>
            </select>
            </label>
            <strong>Tipo de letra</strong>
          <label>
            <select name="tipo_letra" id="tipo_letra">
              <?php 
							if ($tipo_letra==1) { echo '<option value="1" selected="selected">Arial</option>'; } 
							elseif ($tipo_letra==2) { echo '<option value="2" selected="selected">Escolar ligada</option>'; } 
							elseif ($tipo_letra==99) { echo '<option value="99" selected="selected">Cualquiera</option>'; } 
							?>
              <option value="1">Arial</option>
              <option value="2">Escolar ligada</option>
              <option value="99" selected="selected">Cualquiera</option>
            </select>
            </label>
        <strong>Min&uacute;sculas
          <input name="minusculas" type="checkbox" id="minusculas" value="1" <?php if ($minusculas==1) { echo 'checked="checked"'; } ?> />
              <label></label>
          </strong><strong>May&uacute;sculas
            <label> </label>
          </strong>
          <label></label>
          <strong>
          <input name="mayusculas" type="checkbox" id="mayusculas" value="1" <?php if ($mayusculas==1) { echo 'checked="checked"'; } ?>/>
        </strong></p>
        <p><strong>Idiomas: </strong>Castellano
            <label>
            <input name="castellano" type="checkbox" id="castellano" value="1" <?php if ($castellano==1) { echo 'checked="checked"'; } ?> />
            </label>
          Ruso
            <input name="ruso" type="checkbox" id="ruso" value="1"  <?php if ($ruso==1) { echo 'checked="checked"'; } ?>/>
          Rumano
            <input name="rumano" type="checkbox" id="rumano" value="1" <?php if ($rumano==1) { echo 'checked="checked"'; } ?>/>
            &Aacute;rabe
            <input name="arabe" type="checkbox" id="arabe" value="1" <?php if ($arabe==1) { echo 'checked="checked"'; } ?>/>
          Chino
            <input name="chino" type="checkbox" id="chino" value="1" <?php if ($chino==1) { echo 'checked="checked"'; } ?>/>
            B&uacute;lgaro
            <input name="bulgaro" type="checkbox" id="bulgaro" value="1" <?php if ($bulgaro==1) { echo 'checked="checked"'; } ?>/>
          Polaco
            <input name="polaco" type="checkbox" id="polaco" value="1" <?php if ($polaco==1) { echo 'checked="checked"'; } ?>/>
            Ingl&eacute;s
            <input name="ingles" type="checkbox" id="ingles" value="1" <?php if ($ingles==1) { echo 'checked="checked"'; } ?>/>
            Franc&eacute;s
            <input name="frances" type="checkbox" id="frances" value="1" <?php if ($frances==1) { echo 'checked="checked"'; } ?>/>
            Catal&aacute;n
            <input name="catalan" type="checkbox" id="catalan" value="1" <?php if ($catalan==1) { echo 'checked="checked"'; } ?>/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="Submit2" value="Buscar" onclick="recogercheckbox_administrador_simbolos();" />
        </p></td>
    </tr>
  </table>
    <br/>
  <hr style="border-bottom:1px solid #CCCCCC;" />
</form>
<div id="tabla_simbolos"> </div>
</div>
<div id="informacion_simbolo">
  <div class="right">
		<h3>S&iacute;mbolo:</h3>
			<div class="right_articles"><p>&nbsp;</p></div>
		<h3>Informaci&oacute;n:</h3>
			<div class="right_articles"><p>&nbsp;</p></div>
  </div>
</div>
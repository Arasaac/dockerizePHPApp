<?php 
session_start();

require ('../../lang/lang_es.php');
include ('../../classes/querys/query.php');
$query= new query();
?>
<div id="products" style="float:right;">
	<div id="loading"><img src="images/loading2.gif" alt="Cargando..." /></div>
</div>
<div id="mensaje"></div>
<div id="formulario_login" style="width:400px; padding:2px; background:url(images/busqueda_avanzada.jpg) no-repeat top right;">
  <form action="" method="post" name="opciones_busqueda_simbolos" id="opciones_busqueda_simbolos">
  <p align="left">Seleccione las opciones de filtrado para la b&uacute;squeda de s&iacute;mbolos</p>
    <p align="left"><strong>Tipo de Pictograma</strong>
              <label>
              <select name="tipo_simbolo" id="tipo_simbolo">
                <option value="99" <?php if ($_SESSION['id_tipo_simbolo']==99) { echo 'selected="selected"'; } ?>>Cualquiera</option>
                <option value="5 <?php if ($_SESSION['id_tipo_simbolo']==5) { echo 'selected="selected"'; } ?>">Pictogramas ByN</option>
                <option value="10" <?php if ($_SESSION['id_tipo_simbolo']==10) { echo 'selected="selected"'; } ?>>Pictogramas Color</option>
                <option value="2" <?php if ($_SESSION['id_tipo_simbolo']==2) { echo 'selected="selected"'; } ?>>Fotograf&iacute;a</option>
                </select>
                              </label>
    </p>
          <p align="left"><strong>Marco</strong>
            <label>
            <select name="marco" id="marco">
              <?php 
							if ($_SESSION['marco']==1) { echo '<option value="1" selected="selected">Con marco</option>'; } 
							elseif ($_SESSION['marco']==0) { echo '<option value="0">Sin marco</option>'; } 
							elseif ($_SESSION['marco']==99) { echo '<option value="99">Con y Sin Marco</option>'; } 
							?>
              <option value="1">Con marco</option>
              <option value="0">Sin marco</option>
              <option value="99" selected="selected">Con y Sin Marco</option>
            </select>
                                            </label>
                              <strong>Contraste</strong>
              <label>
              <select name="contraste" id="contraste">
                <?php 
							if ($_SESSION['contraste']==1) { echo '<option value="1" selected="selected">Normal</option>'; } 
							elseif ($_SESSION['contraste']==2) { echo '<option value="2" selected="selected">Invertido</option>'; }
							elseif ($_SESSION['contraste']==99) { echo '<option value="99" selected="selected">Cualquiera</option>'; }  
							?>
                <option value="1">Normal</option>
                <option value="2">Invertido</option>
                <option value="99" selected="selected">Cualquiera</option>
              </select>
              </label>
    </p>
          <p align="left"><strong>Tipo de letra</strong>
            <label>
            <select name="tipo_letra" id="tipo_letra">
              <?php 
							if ($_SESSION['tipo_letra']==1) { echo '<option value="1" selected="selected">Arial</option>'; } 
							elseif ($_SESSION['tipo_letra']==2) { echo '<option value="2" selected="selected">Escolar ligada</option>'; } 
							elseif ($_SESSION['tipo_letra']==99) { echo '<option value="99" selected="selected">Cualquiera</option>'; } 
							?>
              <option value="1">Arial</option>
              <option value="2">Escolar ligada</option>
              <option value="99" selected="selected">Cualquiera</option>
            </select>
            </label>
    </p>
          <p align="left"><strong>Min&uacute;sculas
          <input name="minusculas" type="checkbox" id="minusculas" value="1" <?php if ($_SESSION['minusculas']==1) { echo 'checked="checked"'; } ?> />
          <label></label>
          </strong><strong>May&uacute;sculas
            <label> </label>
          </strong>
            <label></label>
            <strong>
            <input name="mayusculas" type="checkbox" id="mayusculas" value="1" <?php if ($_SESSION['mayusculas']==1) { echo 'checked="checked"'; } ?>/>
              </strong></p>
    <p align="left"><strong>Idiomas: </strong></p>
          <p align="left">
            <input name="castellano" type="checkbox" id="castellano" value="1" <?php if ($_SESSION['castellano']==1) { echo 'checked="checked"'; } ?> />
            Castellano
            <label></label>
            <input name="ruso" type="checkbox" id="ruso" value="1"  <?php if ($_SESSION['ruso']==1) { echo 'checked="checked"'; } ?>/>
            Ruso
            
            <input name="rumano" type="checkbox" id="rumano" value="1" <?php if ($_SESSION['rumano']==1) { echo 'checked="checked"'; } ?>/>
            Rumano 
            <input name="arabe" type="checkbox" id="arabe" value="1" <?php if ($_SESSION['arabe']==1) { echo 'checked="checked"'; } ?>/>
            &Aacute;rabe

            <input name="chino" type="checkbox" id="chino" value="1" <?php if ($_SESSION['chino']==1) { echo 'checked="checked"'; } ?>/>
            Chino
            
            <input name="bulgaro" type="checkbox" id="bulgaro" value="1" <?php if ($_SESSION['bulgaro']==1) { echo 'checked="checked"'; } ?>/>
            B&uacute;lgaro
            
            <input name="polaco" type="checkbox" id="polaco" value="1" <?php if ($_SESSION['polaco']==1) { echo 'checked="checked"'; } ?>/>
            Polaco
            
            <input name="ingles" type="checkbox" id="ingles" value="1" <?php if ($_SESSION['ingles']==1) { echo 'checked="checked"'; } ?>/>
            Ingl&eacute;s
            
            <input name="frances" type="checkbox" id="frances" value="1" <?php if ($_SESSION['frances']==1) { echo 'checked="checked"'; } ?>/>
            Franc&eacute;s
            
            <input name="catalan" type="checkbox" id="catalan" value="1" <?php if ($_SESSION['catalan']==1) { echo 'checked="checked"'; } ?>/>
    Catal&aacute;n&nbsp;&nbsp;</p>
          <br />
    <p align="center">
  <input type="button" name="submit" value="Guardar par&aacute;metros de b&uacute;squeda" onClick="recogercheckbox_opciones_busqueda_simbolos();"/>
</p>
</form>
</div><br />

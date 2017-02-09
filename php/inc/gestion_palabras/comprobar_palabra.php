<?php 
include ('../../classes/querys/query.php');

$query=new query();

if ($_POST['palabra'] !="") {
	
	$palabra_comprobar=utf8_decode($_POST['palabra']);
	$datos_palabra=$query->comprobar_palabra($palabra_comprobar);
	
	$num_rows=mysql_num_rows($datos_palabra);
	
	
	if ($num_rows==0) {
	?>
    <br />
	<div  align="center"><div class="mensaje"><?php echo utf8_encode("La palabra no está registrada."); ?></div></div>
	<div align="center" id="nueva_palabra">
	  <TABLE>
					  <TR>
					    <TD colspan="3"><?php echo utf8_encode("<p>Escriba la definición, seleccione el tipo de palabra y los subtemas que le corresponden.</p>"); ?></TD>
	    </TR>
					  <TR>
					    <TD colspan="3"><strong>Palabra:</strong>
                        <input name="palabra" type="text" id="palabra" value="<?php echo $_POST['palabra'] ?>" size="50"  readonly="yes" /></TD>
	    </TR>
					  <TR>
					    <TD colspan="3" valign="top"><strong>Definici&oacute;n:</strong><br />
                        <textarea name="definicion" cols="70" rows="3" id="definicion" checkallownull="false" checktype="text" checkmessage="<?php echo utf8_encode("Debe introducir una definici&oacute;n") ?>"></textarea></TD>
	    </TR>
					  <TR>
					    <TD colspan="3"><?php $categ2=$query->listar_categorias_palabras(); ?>
					      <strong>Tipo de Palabra:</strong>
                          <select name="id_tipo_palabra" id="id_tipo_palabra">
                            <?php while ($row_rsCategorias=mysql_fetch_array($categ2)) {  ?>
                            <option value="<?php echo $row_rsCategorias['id_tipo_palabra']?>"><?php echo $row_rsCategorias['tipo_palabra']; ?></option>
                            <?php  }  // Cierro el While ?>
                        </select></TD>
	    </TR>
					  <TR>
					    <TD colspan="3"><?php $temas=$query->listado_temas(); ?>
                          <strong>Temas:</strong>
                          <select name="temas" id="temas" required="1" realname="Categor&iacute;a" class="fonty" onchange="cargar_div2('../listar_subtemas.php','tema='+document.nueva_palabra.temas.value+'','subtemas')">
                            <option value="0" selected="selected">Seleccione un tema</option>
                            <?php while ($row_rsTemas=mysql_fetch_array($temas)) {  ?>
                            <option value="<?php echo $row_rsTemas['id_tema']?>"><?php echo $row_rsTemas['tema']; ?></option>
                            <?php }  // Cierro el While ?>
                        </select></TD>
	    </TR>
					  <TR>
					    <TD><strong>Subtemas</strong></TD>
						<TD>&nbsp;</TD>
						<TD><strong>Subtemas seleccionados </strong></TD>
					  </TR>
					  <TR>
					    <TD><div id="subtemas"><select id=SelectList style="width: 280px; height:180px;" multiple size=5 name=SelectList>
                                                </select></div></TD>
					    <TD><input name="button" type=button onclick=addIt(); value="->" />
                          <br />
                        <input name="button" type=button onclick=delIt(); value="<-" /></TD>
					    <TD><select id="PickList" style="width: 280px; height:180px;" multiple size=5 name="PickList[]" checkallownull="false" checktype="text" checkmessage="<?php echo utf8_encode("Debe definir algún subtema") ?>">
                        </select></TD>
	    </TR>
	  </TABLE>
<br />
        <input type="submit" name="Submit" value="A&ntilde;adir" onclick="return selIt_sin();" />
          </p>
</div>
	<?php
	} elseif ($num_rows > 0) {
	?>
	<div  align="center"><div class="mensaje">La palabra ya existe</div></div>
	<br />
	<div align="center" id="nueva_palabra">
	  <p><strong>Palabra: 
		</strong>
	    <input name="palabra" type="text" id="palabra"  readonly="yes" value="<?php echo $_POST['palabra'] ?>">
		  <br>
	      <strong>Definiciones de la palabra:</strong></p>

	  <div align="left">
	  <?php 
	  
	  while ($row=mysql_fetch_array($datos_palabra)) {
	  
	 if ($row['definicion']==""){ echo "<li>Sin definir</li>"; } else { echo "<li>".utf8_encode($row['definicion'])."</li>"; }
	  }
	  ?>
	  </div>

      <h2><a  href="#first" onClick="shoh('imagen4');" ><img src="../../images/u.gif" alt="<?php echo $lang['desplegar_opciones']; ?>" name="imgimagen4" width="9" height="9" border="0" ></a>&nbsp;Nueva</h5>

	<div style="display:none;" id="imagen4" >
	   <div style="border:1px solid #CCCCCC; margin-top:20px; margin-bottom:10px; padding-top:5px;">
	     <table>
        <tr>
          <td colspan="3"><strong>Nueva definici&oacute;n:</strong><br />
          <textarea name="definicion" cols="80" rows="2" id="definicion" checkallownull="false" checktype="text" checkmessage="<?php echo utf8_encode("Debe introducir una definición") ?>"></textarea></td>
        </tr>
        <tr>
          <td colspan="3"><strong>
            <?php $categ2=$query->listar_categorias_palabras(); ?>
          Tipo de Palabra:</strong>
		<select name="id_tipo_palabra" id="id_tipo_palabra">
		  <?php while ($row_rsCategorias=mysql_fetch_array($categ2)) {  ?>
		  <option value="<?php echo $row_rsCategorias['id_tipo_palabra']?>"><?php echo $row_rsCategorias['tipo_palabra']; ?></option>
		  <?php  }  // Cierro el While ?>
	    </select></td>
        </tr>
        <tr>
          <td colspan="3"><strong>
            <?php $temas=$query->listado_temas(); ?>
          Temas:</strong>
  <select name="temas" id="temas" onChange="cargar_div2('../listar_subtemas.php','tema='+document.nueva_palabra.temas.value+'','subtemas')">
    <option value="0" selected="selected">Seleccione un tema</option>
    <?php while ($row_rsTemas=mysql_fetch_array($temas)) {  ?>
    <option value="<?php echo $row_rsTemas['id_tema']?>"><?php echo $row_rsTemas['tema']; ?></option>
    <?php }  // Cierro el While ?>
  </select></td>
          </tr>
        <tr>
          <td><strong>Subtemas</strong></td>
          <td>&nbsp;</td>
          <td><strong>Subtemas seleccionados</strong> </td>
        </tr>
        <tr>
          <td><div id="subtemas"><select id=SelectList style="width: 280px; height:180px;" multiple size=5 name=SelectList></select></div></td>
          <td><input name="button2" type="button" onClick="addIt();" value="-&gt;" />
              <br />
              <input name="button2" type="button" onClick="delIt();" value="&lt;-" /></td>
          <td><select id="PickList" style="width: 280px; height:180px;" multiple="multiple" size="5" name="PickList[]" checkallownull="false" checktype="text" checkmessage="<?php echo utf8_encode("Debe definir algún subtema") ?>">
                    </select></td>
        </tr>
        <tr>
          <td colspan="3" align="center"><input type="submit" name="Submit2" value="A&ntilde;adir" onClick="return selIt_sin();" /></td>
          </tr>
         </table>	
     </div>
	</div>
  <?php
	}
} else { // Si la palabra está vacía ?>
<div  align="center"><div class="mensaje">Escriba una palabra</div></div>
  <div align="center" id="nueva_palabra">
    <h2>Introduzca la nueva palabra</h2>
      <br />
        <input name="palabra" type="text" id="palabra" value="" size="50" maxlength="100">
    <br> 
      <br>
        <input type="button" name="Submit" value="Comprobar" onClick="cargar_div2('comprobar_palabra.php','palabra='+document.nueva_palabra.palabra.value+'','nueva_palabra');"> <br />

  </div>
<?php } ?>


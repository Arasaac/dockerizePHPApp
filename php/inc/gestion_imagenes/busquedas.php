<div class="left" style="height:1800px;">
<h4>Gesti&oacute;n de im&aacute;genes/pictogramas originales</h4>
<br />
<form action="" method="post" name="diccionario" id="diccionario">
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr valign="middle">
      <td width="89%"><strong>Diccionario de palabras</strong>
        <?php $categ3=$query->listar_categorias_palabras(); ?>
          <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">
            <option value="99">Todas</option>
            <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
            <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra']; ?></option>
            <?php }  ?>
          </select>
          <strong>Tipo imagen:</strong>
          <select name="id_tipo_imagen" id="id_tipo_imagen" required="1" realname="Categor&iacute;a" class="fonty">
          	<option value="99">Todos</option>
            <?php		$categ2=$query->listar_tipos_imagen();
						while ($row_rsCategorias=mysql_fetch_array($categ2)) { 
							if ($row_rsCategorias['ext'] != 'gif') { 
		  			  ?>
            <option value="<?php echo $row_rsCategorias['id_tipo']?>"><?php echo utf8_encode($row_rsCategorias['tipo_imagen']); ?></option>
            <?php 		} // Cierro el If
			 		 }  // Cierro el While ?>
          </select>
          <strong>comienza por</strong>
        <input name="letra" type="text" id="letra" size="10" onkeypress="return handleEnter(this, event)"/>
        <input type="button" name="Submit2" value="Buscar" onClick="cargar_div('inc/gestion_imagenes/listar_imagenes.php','id_tipo='+document.diccionario.tipo_palabra.value+'&amp;letra='+document.diccionario.letra.value+'&id_tipo_imagen='+document.diccionario.id_tipo_imagen.value+'','tabla_admin_imagenes'); cargar_div('inc/gestion_imagenes/limpiar_cuadro_informacion.php','i=','informacion_imagen');" /></td>
      <td width="11%" align="center" valign="middle">
        <?php 
			if ($permisos['add_imagenes']==1) {
				echo '<a href="javascript:void(0);" onclick=\'cargar_div("inc/gestion_imagenes/add_imagen.php","i=","principal");\' target="_self"><img src="images/mas.gif" alt="A&ntilde;adir imagen" title="A&ntilde;adir imagen" border="0" />&nbsp;</a>';
			}
		?>      </td>
    </tr>
  </table>
  <br/>
  <hr style="border-bottom:1px solid #CCCCCC;" />
  <div id="tabla_admin_imagenes"> </div>
</form>
</div>
<div id="informacion_imagen">
  <div class="right">
		<h3>Imagen:</h3>
			<div class="right_articles"><p>&nbsp;</p></div>
		<h3>Informaci&oacute;n:</h3>
			<div class="right_articles"><p>&nbsp;</p></div>
  </div>
</div>
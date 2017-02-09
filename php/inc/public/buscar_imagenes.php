<?php 
include ('../../classes/querys/query.php');
$query= new query();
?>
<div class="left">
<h3>B&uacute;squeda de im&aacute;genes </h3>
<br />
<form action="" method="post" name="diccionario" id="diccionario">
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr valign="middle">
      <td><strong>Tipo de palabra:
        </strong>
        <?php $categ3=$query->listar_categorias_palabras(); ?>
          <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">
            <option value="99" selected="selected">Todas</option>
            <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
            <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra']; ?></option>
            <?php }  ?>
          </select>
          <strong>comienza por</strong>
        <input name="letra" type="text" id="letra" size="10" onkeypress="return handleEnter(this, event)"/>
        <input type="button" name="Submit2" value="Buscar" onClick="cargar_div('inc/public/listar_imagenes.php','id_tipo='+document.diccionario.tipo_palabra.value+'&amp;letra='+document.diccionario.letra.value+'','tabla_imagenes'); cargar_div('inc/gestion_imagenes/limpiar_cuadro_informacion.php','i=','informacion_imagen');" /></td>
    </tr>
  </table>
  <div id="tabla_imagenes"> </div>
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
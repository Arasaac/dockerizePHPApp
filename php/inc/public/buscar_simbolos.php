<?php 
include ('../../classes/querys/query.php');
$query= new query();
?>
<div class="left">
<h3>B&uacute;squeda de s&iacute;mbolos </h3>
<br />
<form action="" method="post" name="catalogo_simbolos" id="catalogo_simbolos">
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr valign="middle">
      <td><strong>Tipos de s&iacute;mbolos</strong> 
        <?php $categ3=$query->listar_categorias_simbolos(); ?>
          <select name="tipo_simbolo" class="textos" id="tipo_simbolo" required="1" realname="Categor&iacute;a">
            <option value="99">Todas</option>
            <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
            <option value="<?php echo $row_rsCategorias3['id_tipo']?>"><?php echo $row_rsCategorias3['tipo_simbolo']; ?></option>
            <?php }  ?>
          </select>
          <strong>Idioma</strong>  
        <?php $idiomas=$query->listar_idiomas(); ?>
        <select name="idioma" class="textos" id="idioma" required="1" realname="Idioma">
          <option value="99">Todos</option>
		  <option value="98">Solo Castellano</option>
		  <option value="97">Sin texto</option>
          <?php while ($row_idiomas=mysql_fetch_array($idiomas)) {  ?>
          <option value="<?php echo $row_idiomas['id_idioma']?>"><?php echo $row_idiomas['idioma']; ?></option>
          <?php }  ?>
        </select> <br />
        <strong>Diccionario de palabras
        <?php $categ3=$query->listar_categorias_palabras(); ?>
        <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">
          <option value="99">Todas</option>
          <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
          <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra']; ?></option>
          <?php }  ?>
        </select>
empieza por</strong>
        <input name="letra" type="text" id="letra" size="10" onkeypress="return handleEnter(this, event)"/>
        <input type="button" name="Submit2" value="Buscar" onClick="cargar_div('inc/public/listar_simbolos.php','id_tipo_palabra='+document.catalogo_simbolos.tipo_palabra.value+'&letra='+document.catalogo_simbolos.letra.value+'&id_tipo_simbolo='+document.catalogo_simbolos.tipo_simbolo.value+'&idioma='+document.catalogo_simbolos.idioma.value+'','tabla_simbolos'); cargar_div('inc/gestion_simbolos/limpiar_cuadro_informacion.php','i=','informacion_simbolo');" /></td>
    </tr>
  </table>
  <div id="tabla_simbolos"> </div>
</form>
</div>
<div id="informacion_simbolo">
  <div class="right">
		<h3>S&iacute;mbolo:</h3>
			<div class="right_articles"><p>&nbsp;</p></div>
		<h3>Informaci&oacute;n:</h3>
			<div class="right_articles"><p>&nbsp;</p></div>
  </div>
</div>
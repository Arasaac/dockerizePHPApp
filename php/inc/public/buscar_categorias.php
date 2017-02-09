<?php 
include ('../../classes/querys/query.php');
$query= new query();
?>
<div class="left">
<h3>B&uacute;squeda por categor&iacute;as </h3><br />
<form action="" method="post" name="diccionario" id="diccionario">
  <strong>Categor&iacute;as</strong>
      <?php $categ3=$query->listado_temas(); ?>
      <select name="id_tema" class="textos" id="id_tema" onchange="cargar_div('inc/public/listar_subtemas.php','id_tema='+document.diccionario.id_tema.value+'','subtemas')">
        <option value="">Seleccione categoria</option>
        <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
        <option value="<?php echo $row_rsCategorias3['id_tema']?>"><?php echo $row_rsCategorias3['tema']; ?></option>
        <?php }  ?>
      </select> 
    <input type="button" name="Submit2" value="Buscar" onclick="cargar_div('inc/public/listar_categorias.php','id_tema='+document.diccionario.id_tema.value+'&amp;id_subtema='+document.diccionario.id_subtema.value+'','tabla_categorias'); cargar_div('inc/public/previsualizacion.php','i=','previsualizacion');" />
    
	<br />
	
	<div id="subtemas">
      <input name="id_subtema" type="hidden" id="id_subtema" />
    </div>
	
</form>
<br />
<div id="tabla_categorias">  </div>
</div>
<div id="previsualizacion">
  <div class="right">
		<h3>Informaci&oacute;n:</h3>
			<div class="right_articles"><p>&nbsp;</p></div>
  </div>
</div>
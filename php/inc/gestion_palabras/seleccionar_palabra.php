<?php 
include ('../../classes/querys/query.php');

$query=new query();

?>
<div align="center" id="actualizar_definicion" style="width:400px; height:300px; background-color:#FFFFFF;">
<form action="" method="post" name="vm_diccionario">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr valign="middle">
            <td width="94%"><div align="left"></div></td>
          </tr>
          <tr valign="middle">
            <td><strong>Diccionario:
              </strong>
              <?php $categ3=$query->listar_categorias_palabras();
						//$cat_palabra=$query->datos_categoria_palabras($_POST['tipo_palabra']); ?>
              <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">
                <option value="<?php echo $_POST['tipo_palabra']; ?>"selected="selected"><?php echo $cat_palabra['tipo_palabra'] ?></option>
                <option value="99">Todas</option>
                <?php
							while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  
		 					 ?>
                <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra']; ?></option>
                <?php }  ?>
              </select>
<br />
<strong>comienza por</strong>
<input name="letra" type="text" id="letra" size="30" onkeypress="return handleEnter(this, event)"/>
<input type="button" name="Submit2" value="Buscar" onclick="cargar_div('inc/gestion_palabras/listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'','tabla_palabras');" /></td>
          </tr>
        </table>
<br /><br />
<div id="tabla_palabras">


</div>
</form>
  </p>
</div>

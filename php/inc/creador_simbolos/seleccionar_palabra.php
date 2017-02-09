<?php 
include ('../../classes/querys/query.php');

$query=new query();

?>
<div align="center" id="actualizar_definicion" style="width:650px; height:500px; background:#FFFFFF url(images/find.gif) no-repeat bottom right;">
<form action="" method="post" name="vm_diccionario">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr valign="middle">
            <td width="94%"><div align="left"><a href="javascript:void(0);" onclick=""></a></div></td>
          </tr>
          <tr valign="middle">
            <td><strong>Diccionario:
              </strong>
              <?php $categ3=$query->listar_categorias_palabras(); ?>
              <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">
                <option value="99">Todas</option>
                <?php
							while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  
		 					 ?>
                <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra']; ?></option>
                <?php }  ?>
              </select> 
              <strong>comienza por</strong>
              <input name="letra" type="text" id="letra" size="30" onkeypress="return handleEnter(this, event)"/>
<input type="button" name="Submit2" value="Buscar" onclick="cargar_div('inc/creador_simbolos/listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'','tabla_palabras');" /></td>
          </tr>
        </table>
<hr />
</form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="80%" valign="top"><div id="tabla_palabras"></div></td>
     <td width="20%"><br />
      <br />
      <div id="clearCart"></div><div id="loading" align="center"><img src="images/loading11.gif" alt="Cargando..." /></div></td>
   </tr>
 </table>
</div>

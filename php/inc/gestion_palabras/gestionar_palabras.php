<?php 
include ('../../classes/querys/query.php');

$query=new query();

?>
<div align="center"><?php echo $mensaje1 ?></div>
<h4>Gesti&oacute;n de palabras y traducciones</h4>
<br />
	  <a href="javascript:void(0);" onclick="ventana_modal('id_palabra=<?php echo $entrada['id_palabra']; ?>','inc/editar_definicion.php');"></a><a href="javascript:void(0);" onclick="ventana_modal('','inc/gestion_palabras/nueva_palabra.php');"></a>
	  <form action="" method="post" name="diccionario">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr valign="middle">
            <td colspan="2"><div align="left"><a href="javacript:void(0);" onclick="return GB_show('Nueva palabra', 'inc/gestion_palabras/nueva_palabra.php', 500, 550)" target="_self"></a></div></td>
          </tr>
          <tr valign="middle">
            <td width="87%"><strong>Diccionario de palabras</strong>
              <?php $categ3=$query->listar_categorias_palabras();
						//$cat_palabra=$query->datos_categoria_palabras($_POST['tipo_palabra']); ?>
              <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">
                <option value="99">Todas</option>
                <?php
							while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  
		 					 ?>
                <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra']; ?></option>
                <?php }  ?>
              </select>
              <strong>comienza por</strong>
<input name="letra" type="text" id="letra" size="10" onkeypress="return handleEnter(this, event)"/>
<input type="button" name="Submit2" value="Buscar" onclick="cargar_div('inc/gestion_palabras/listar_palabras.php','id_tipo='+document.diccionario.tipo_palabra.value+'&letra='+document.diccionario.letra.value+'','tabla_admin_palabras'); editbox_init();" /></td>
            <td width="13%" align="right"><a href="inc/gestion_palabras/nueva_palabra.php" onclick="return GB_showCenter('Nueva palabra', this.href, 550, 800)" target="_self">Nueva palabra</a>&nbsp;<a href="inc/gestion_palabras/nueva_palabra.php" onclick="return GB_showCenter('Nueva palabra', this.href)" target="_self"><img src="images/mas.gif" alt="Nueva palabra/acepcion" border="0" /></a></td>
          </tr>
        </table>
  <br/>
  <hr style="border-bottom:1px solid #CCCCCC;" />
<div id="tabla_admin_palabras">


</div>
</form><br />

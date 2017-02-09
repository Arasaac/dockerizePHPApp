<?php 
include ('../../../classes/querys/query.php');
$query=new query();
?>
<div align="center" id="actualizar_definicion" style="width:650px; height:500px; background:#FFFFFF url(images/find.gif) no-repeat bottom right;">
<form action="" method="post" name="vm_diccionario">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr valign="middle">
            <td width="94%">&nbsp;</td>
          </tr>
          <tr valign="middle">
            <td align="center"><strong>Buscar</strong><strong> por</strong>
              <input name="letra" type="text" id="letra" size="30" onkeypress="return handleEnter(this, event)"/>
<input type="button" name="Submit2" value="Buscar" onclick="cargar_div('gestionar_seleccion/listar_selecciones.php','letra='+document.vm_diccionario.letra.value+'','tabla_palabras');" /></td>
          </tr>
        </table>
<hr />
</form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="80%" valign="top"><div id="tabla_palabras"></div></td>
     <td width="20%"><br />
      <br />
      <div id="clearCart"></div><div id="loading" align="center"><img src="../../images/loading11.gif" alt="Cargando..." /></div></td>
   </tr>
 </table>
</div>

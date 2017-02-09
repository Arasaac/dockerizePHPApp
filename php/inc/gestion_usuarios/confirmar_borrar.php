<div align="center">&iquest;Est&aacute; seguro que desea borrar el usuario seleccionado?<br>
  <input type="button" value="Si" onClick="cargar_div('inc/gestion_usuarios/borrar_usuarios.php','id=<?php echo $_POST['id']; ?>','listado_usuarios'); closeDialog();" />
  <input name="button" type="button" value="No" onClick="closeDialog();" />
</div>
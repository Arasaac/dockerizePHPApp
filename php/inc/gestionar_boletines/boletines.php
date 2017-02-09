<?php 
include ('../../classes/querys/query.php');
$query=new query();
?>
<div>
	<h4>Boletines</h4>
    <br /><div align="center" id="resultado" class="mensaje"></div><br />
	 <div id="listado_usuarios">
  <p><a href="javascript:void(0);" onClick="cargar_div('inc/gestionar_boletines/nuevo_boletin.php','id=','resultado');"><img src="images/add_user.png" alt="Nuevo usuario" width="16" height="16" border="0" /></a>&nbsp;<a href="javascript:void(0);" onClick="cargar_div('inc/gestionar_boletines/nuevo_boletin.php','id=','resultado');">Nuevo bolet&iacute;n</a></p><br />
			<div align="center" style="height:550px;">
              <form action="" method="post" name="usuarios" id="usuarios">
                <table width="50%"  border="0" cellspacing="0" cellpadding="0">
				<thead>
                  <tr align="center">
                    <td colspan="3" class="tabla_linea_inferior"><div align="left"><strong>Opciones</strong></div></td>
                    <td width="49%" align="left" class="tabla_linea_inferior"><strong>Id Bolet&iacute;n<span class="list_action_button">
                      <input name="id_pag" type="hidden" id="id_pag" value="0" />
                      <input name="busqueda" type="hidden" id="busqueda" value="<?php echo rand(1,100000); ?>" />
                    </span></strong></td>
                    <td width="32%" align="left" class="tabla_linea_inferior"><strong>Fecha</strong></td>
                  </tr>
                  </thead>
                  <?php 
					$pg = 0;
					$cantidad=10; // cantidad de resultados por p&aacute;gina 
					$inicial = $pg * $cantidad;
					
					$contar=$query->listar_boletines();
					$pegar=$query->listar_boletines_limit($inicial,$cantidad);
					
					$total_records = mysql_num_rows($contar);
					$pages = intval($total_records / $cantidad);
					
					$color = 'tablaAlterno1';
					
					while ($row=mysql_fetch_array($pegar)) {
					
					$color = ($color == 'tablaAlterno1') ? 'tablaAlterno2' : 'tablaAlterno1'
					?>
                  <tr class="<?php echo $color; ?>">
                    <td width="5%" align="center" class="tabla_linea_inferior">
					<a href="javascript:void(0);" 
					onClick="ventana_confirmacion('Esta seguro que desea borrar el usuario seleccionado?', '300','100',
				'inc/gestion_usuarios/borrar_usuarios.php', 'id=<?php echo $row['id_colaborador']; ?>', 'listado_usuarios',
				'', '', ''
				);" /><img src="images/delete_user.png" alt="Borrar usuario: <?php echo $row['primer_apellido']."&nbsp;".$row['segundo_apellido'].",&nbsp;".$row['nombre']; ?>" border="0" /></a></td>
                    <td width="5%" align="center" class="tabla_linea_inferior"><a href="javascript:void(0);" onClick="cargar_div('inc/gestion_usuarios/editar_usuario.php','id=<?php echo $row['id_colaborador'] ?>','usuario');"><img src="images/vcard_edit.png" alt="Editar usuario: <?php echo $row['primer_apellido']."&nbsp;".$row['segundo_apellido'].",&nbsp;".$row['nombre']; ?>" border="0" /></a>                        </td>
                    <td width="9%" align="center" class="tabla_linea_inferior">&nbsp;</td>
                    <td align="left" class="tabla_linea_inferior"><?php echo utf8_encode('Boletín nº '.$row['id_newsletter']); ?></td>
                    <td align="left" class="tabla_linea_inferior"><?php echo $row['fecha_publicacion']; ?></td>
                  </tr>
                  <?php 

}
?>
                </table>
              </form>
  </div>
			<div align="center" class="textos">Boletines: <?php echo $inicial ?> a <?php echo $inicial+$cantidad ?> de <?php echo $total_records ?> <br />
            </div>
			<table width="60%" height="30" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="textos">
                <td width="9%" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="Submit" value="&lt;&lt;" onclick='cargar_div("inc/gestion_palabras/listar_palabras.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=0","tabla_palabras");'>
                </td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center">
                  <?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
                    <input type="button" name="Submit" value="< Anterior" onclick='cargar_div("inc/gestion_palabras/listar_palabras.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=<?php echo $url ?>","tabla_palabras");'>
                </div></td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">&nbsp;</td>
                <td width="26%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center">
                  <?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
                    <input type="button" name="Submit" value="Siguiente >" onclick='cargar_div("inc/gestion_palabras/listar_palabras.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=<?php echo $url ?>","tabla_palabras");'>
                </div></td>
                <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="button" value="&gt;&gt;" onclick='cargar_div("inc/gestion_palabras/listar_palabras.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=<?php echo $pages; ?>","tabla_palabras");'></td>
              </tr>
            </table>

			
	</div>
</div>



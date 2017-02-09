<p><a href="javascript:void(0);" onClick="cargar_div('inc/gestion_autores/nuevo_autor.php','id=','usuario');"><img src="images/add_user.png" alt="Nuevo autor" width="16" height="16" border="0" /></a>&nbsp;<a href="javascript:void(0);" onClick="cargar_div('inc/gestion_autores/nuevo_autor.php','id=','usuario');">Nuevo autor</a></p><br />
			<div align="center" style="height:550px;">
              <form action="" method="post" name="usuarios" id="usuarios">
                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<thead>
                  <tr align="center">
                    <td align="center" class="tabla_linea_inferior">&nbsp;</td>
                    <td width="31%" align="center" class="tabla_linea_inferior"><strong>Autor<span class="list_action_button">
                      <input name="id_pag" type="hidden" id="id_pag" value="0" />
                      <input name="busqueda" type="hidden" id="busqueda" value="<?php echo rand(1,100000); ?>" />
                    </span></strong></td>
                    <td width="29%" align="center" class="tabla_linea_inferior"><strong>Empresa/institució</strong>n</td>
                    <td width="14%" align="center" class="tabla_linea_inferior"><strong>web</strong></td>
                    <td width="17%" align="center" class="tabla_linea_inferior"><strong>Email</strong></td>
                  </tr>
                  </thead>
<?php 
$query=new query();

if (!isset($_POST['pg'])) {
	$pg = 0; // $pg es la pagina actual
} else { $pg=$_POST['pg']; }

$cantidad=21; // cantidad de resultados por p&aacute;gina 
$inicial = $pg * $cantidad;

$contar=$query->listar_autores();
$pegar=$query->listar_autores_limit($inicial,$cantidad);

$total_records = mysql_num_rows($contar);
$pages = intval($total_records / $cantidad);

$color = 'tablaAlterno1';

while ($row=mysql_fetch_array($pegar)) {

$color = ($color == 'tablaAlterno1') ? 'tablaAlterno2' : 'tablaAlterno1'
?>
                  <tr class="<?php echo $color; ?>">
                    <td width="9%" align="center" class="tabla_linea_inferior"><a href="javascript:void(0);" onClick="cargar_div('inc/gestion_autores/editar_autor.php','id=<?php echo $row['id_autor']; ?>&pg=<?php echo $pg; ?>','usuario');"><img src="images/vcard_edit.png" alt="Editar autor: <?php echo $row['autor']; ?>" border="0" /></a>                        </td>
                    <td align="left" class="tabla_linea_inferior"><?php echo utf8_encode($row['autor']); ?></td>
                    <td align="left" class="tabla_linea_inferior"><?php echo utf8_encode($row['empresa_institucion']); ?></td>
                    <td align="left" class="tabla_linea_inferior"><?php echo $row['web_autor']; ?></td>
                    <td align="left" class="tabla_linea_inferior"><?php echo $row['email_autor']; ?></td>
                  </tr>
                  <?php 

}
?>
                </table>
              </form>
  </div>
			<div align="center" class="textos">Usuarios: <?php echo $inicial ?> a <?php echo $inicial+$cantidad ?> de <?php echo $total_records ?> <br />
            </div>
			<table width="60%" height="30" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="textos">
                <td width="9%" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="Submit" value="&lt;&lt;" onclick='cargar_div("inc/gestion_autores/tabla_autores_pg.php","pg=0","listado_usuarios");'>
                </td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center">
                  <?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
                    <input type="button" name="Submit" value="< Anterior" onclick='cargar_div("inc/gestion_autores/tabla_autores_pg.php","pg=<?php echo $url ?>","listado_usuarios");'>
                </div></td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">&nbsp;</td>
                <td width="26%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center">
                  <?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
                    <input type="button" name="Submit" value="Siguiente >" onclick='cargar_div("inc/gestion_autores/tabla_autores_pg.php","pg=<?php echo $url ?>","listado_usuarios");'>
                </div></td>
                <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="button" value="&gt;&gt;" onclick='cargar_div("inc/gestion_autores/tabla_autores_pg.php","pg=<?php echo $pages; ?>","listado_usuarios");'></td>
              </tr>
            </table>

<?php 
session_start();  // INICIO LA SESION
include ('../../classes/querys/query.php');
require ('../../classes/languages/language_detect.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],8); 

echo '<h4>'.$translate['comunicacion_aumentativa_alternativa'].'</h4><br />'.$translate['explicacion_seccion_caa'].'<br /><br />';
?>
<div style="width:100%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="javascript:void(0);" onClick='cargar_div("inc/public/software_caa.php","i=","principal");'><img src="images/software.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['software_caa']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['software_caa']; ?>" /></a></td>
    <td align="center"><a href="javascript:void(0);" onClick='cargar_div("inc/public/listado_enlaces.php","i=","principal");'><img src="images/webs.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['otras_webs']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['otras_webs']; ?>" /></a></td>
    <td align="center"><a href="javascript:void(0);" onclick='cargar_div("inc/public/bibliografia.php","i=","principal");'><img src="images/bibliografia.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['bibliografia']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['bibliografia']; ?>" /></a></td>
    <td align="center"><a href="javascript:void(0);" onclick='cargar_div("inc/public/ejemplos_uso.php","i=","principal");'><img src="images/ejemplos_uso.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['bibliografia']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['ejemplos_de_uso']; ?>" /></a></td>
    </tr>
  <tr>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onClick='cargar_div("inc/public/software_caa.php","i=","principal");'><?php echo $translate['software_caa']; ?></a></td>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onClick='cargar_div("inc/public/listado_enlaces.php","i=","principal");'><?php echo $translate['otras_webs']; ?></a></td>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onclick='cargar_div("inc/public/bibliografia.php","i=","principal");'><?php echo $translate['bibliografia']; ?></a></td>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onclick='cargar_div("inc/public/ejemplos_uso.php","i=","principal");'><?php echo $translate['ejemplos_de_uso']; ?></a></td>
    </tr>
</table>
</div>
<p><br />
  <br />
</p>

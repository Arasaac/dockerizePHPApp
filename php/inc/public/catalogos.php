<?php 
session_start();  // INICIO LA SESION
include ('../../classes/querys/query.php');
require ('../../classes/languages/language_detect.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],8); 

echo '<h4>'.$translate['catalogos'].'</h4> <br />'.$translate['explicacion_catalogos'].'<br /><br />';
?>
<div style="width:100%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="javascript:void(0);" onClick='cargar_div("inc/public/ultimos_pictogramas_color.php","i=","principal");'><img src="images/pict_c.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['pictogramas_color']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['pictogramas_color']; ?>" /></a></td>
    <td align="center"><a href="javascript:void(0);" onClick='cargar_div("inc/public/ultimos_pictogramas_byn.php","i=","principal");'><img src="images/pict_byn.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['pictogramas_byn']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['pictogramas_byn']; ?>" /></a></td>
    <td align="center"><a href="javascript:void(0);" onClick='cargar_div("inc/public/ultimas_imagenes.php","i=","principal");'><img src="images/lphoto.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['imagenes']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['imagenes']; ?>" /></a></td>
  </tr>
  <tr>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onClick='cargar_div("inc/public/ultimos_pictogramas_color.php","i=","principal");'><?php echo $translate['pictogramas_color']; ?></a></td>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onClick='cargar_div("inc/public/ultimos_pictogramas_byn.php","i=","principal");'><?php echo $translate['pictogramas_byn']; ?></a></td>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onClick='cargar_div("inc/public/ultimas_imagenes.php","i=","principal");'><?php echo $translate['imagenes']; ?></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
   <?php if (isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== true) { ?>
    <td align="center"><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_videos_lse.php","i=","principal");'><img src="images/lse_videos.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['videos_lse']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['videos_lse']; ?>" /></a></td>
    <td align="center"><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_signos_lse_color.php","i=","principal");'><img src="images/lse_color.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['lse_color']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['lse_color']; ?>" /></a><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_cliparts.php","i=","principal");'></a></td>
    <td align="center"><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_signos_lse_byn.php","i=","principal");'><img src="images/lse_byn.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['lse_byn']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['lse_byn']; ?>" /></a><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_simbolos_arasaac.php","i=","principal");'></a></td>
    <?php } ?>
  </tr>
  <tr>
      <?php if (isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== true) { ?>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_videos_lse.php","i=","principal");'><?php echo $translate['videos_lse']; ?></a><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_pictogramas_byn.php","i=","principal");'></a></td>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_signos_lse_color.php","i=","principal");'><?php echo $translate['lse_color']; ?></a><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_pictogramas_byn.php","i=","principal");'></a><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_cliparts.php","i=","principal");'></a></td>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_simbolos_arasaac.php","i=","principal");'></a>    <a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_signos_lse_byn.php","i=","principal");'><?php echo $translate['lse_byn']; ?></a><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_pictogramas_byn.php","i=","principal");'></a><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_cliparts.php","i=","principal");'></a></td>
     <?php } ?>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
  <?php if (isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== true) { ?>
    <td align="center"><a href="javascript:void(0);" onclick='cargar_div(&quot;inc/public/ultimos_simbolos_arasaac.php&quot;,&quot;i=&quot;,&quot;principal&quot;);'><img src="images/simbolos.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['simbolos']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['simbolos']; ?>" /></a><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_cliparts.php","i=","principal");'></a></td>
    <td align="center"><a href="javascript:void(0);" onclick='cargar_div(&quot;inc/public/ultimos_cliparts.php&quot;,&quot;i=&quot;,&quot;principal&quot;);'><img src="images/clipart.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['cliparts']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['cliparts']; ?>" /></a><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_simbolos_arasaac.php","i=","principal");'></a></td>
  <?php } ?>
    <td align="center"><a href="javascript:void(0);" onclick='cargar_div(&quot;inc/public/ultimos_cliparts.php&quot;,&quot;i=&quot;,&quot;principal&quot;);'></a></td>
  </tr>
  <tr>
  <?php if (isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== true) { ?>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onclick='cargar_div(&quot;inc/public/ultimos_simbolos_arasaac.php&quot;,&quot;i=&quot;,&quot;principal&quot;);'><?php echo $translate['simbolos']; ?></a><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_cliparts.php","i=","principal");'></a></td>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onclick='cargar_div("inc/public/ultimos_simbolos_arasaac.php","i=","principal");'></a>    <a href="javascript:void(0);" onclick='cargar_div(&quot;inc/public/ultimos_cliparts.php&quot;,&quot;i=&quot;,&quot;principal&quot;);'><?php echo $translate['cliparts']; ?></a></td>
  <?php } ?>
    <td align="center" style="text-transform:uppercase;"><a href="javascript:void(0);" onclick='cargar_div(&quot;inc/public/ultimos_cliparts.php&quot;,&quot;i=&quot;,&quot;principal&quot;);'></a></td>
  </tr>
</table>
</div>
<p><br />
  <br />
</p>

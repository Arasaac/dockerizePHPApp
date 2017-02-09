<?php 
session_start();  // INICIO LA SESION

require ('../classes/querys/query.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],4); 

echo '<div style="font-size:10px;"><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ultimos_pictogramas_color.php","i=","principal");\'>'.$translate['pictogramas_color'].'</a>  |  <a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ultimos_pictogramas_byn.php","i=","principal");\'>'.$translate['pictogramas_byn'].'</a>  |  <a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ultimas_imagenes.php","i=","principal");\'>'.$translate['imagenes'].'</a>';

if (isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== true) {
echo ' |  <a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ultimos_cliparts.php","i=","principal");\'>Cliparts</a> |  <a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ultimos_simbolos_arasaac.php","i=","principal");\'>'.$translate['simbolos'].'</a> |  <a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ultimos_videos_lse.php","i=","principal");\'>'.$translate['videos_lse'].'</a> |  <a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ultimos_signos_lse_color.php","i=","principal");\'>'.$translate['lse_color'].'</a> |  <a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ultimos_signos_lse_byn.php","i=","principal");\'>'.$translate['lse_byn'].'</a>';
}
echo '</div>';
 ?>
<?php 
session_start();  // INICIO LA SESION

require ('../classes/querys/query.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],4); 

echo '<div style="font-size:10px;"><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/software_caa.php","i=","principal");\'>'.$translate['software_caa'].'</a>  |  <a href="javascript:void(0);" onClick=\'cargar_div("inc/public/listado_enlaces.php","i=","principal");\'>'.$translate['otras_webs'].'</a> | <a href="javascript:void(0);" onClick=\'cargar_div("inc/public/bibliografia.php","i=","principal");\'>'.$translate['bibliografia'].'</a> | <a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ejemplos_uso.php","i=","principal");\'>'.$translate['ejemplos_de_uso'].'</a>';

echo '</div>';
 ?>
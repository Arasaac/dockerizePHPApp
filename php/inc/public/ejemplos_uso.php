<?php 
session_start();  // INICIO LA SESION
include ('../../classes/querys/query.php');
require ('../../classes/languages/language_detect.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],30); 

$query=new query();										
$ejemplos_uso=$query->listar_ejemplos_uso();

echo '<a name="select" id="select"></a><h4>'.$translate['ejemplos_de_uso'].'</h4> <br />'.$translate['explicacion_ejemplos_de_uso'].' <br /><br />'; 

while ($row=mysql_fetch_array($ejemplos_uso)) {

	if ($_SESSION['language']=='es') { 
		echo '<div style="border:2px solid #F2F2F2; padding:10px;"><div class="otras_web"><h4>'.$row['titulo_eu'].'<a href="#select" target="_self"><img src="images/up.gif" alt="'.$translate['menu_webs'].'" title="'.$translate['menu_webs'].'" border="0" /></a></h4>'.$row['descripcion_eu'].'</div></div><br />';
		
	} elseif ($_SESSION['language'] !='es' && $row['titulo_eu_'.$_SESSION['language'].''] != NULL && $row['descripcion_eu_'.$_SESSION['language'].'']) {
		
		echo '<div style="border:2px solid #F2F2F2; padding:10px;"><div class="otras_web"><h4>'.$row['titulo_eu_'.$_SESSION['language'].''].'<a href="#select" target="_self"><img src="images/up.gif" alt="'.$translate['menu_webs'].'" title="'.$translate['menu_webs'].'" border="0" /></a></h4>'.$row['descripcion_eu_'.$_SESSION['language'].''].'</div></div><br />';
		
	} 

}


?>

<?php 
include ('../../classes/querys/query.php');
require ('../../classes/languages/language_detect.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],6); 

echo '<h4>'.$translate['condiciones_uso'].'</h4>'.$translate['descipcion_condiciones_uso'];

?>
<?php 
session_start();  // INICIO LA SESION
include ('../../classes/querys/query.php');
require ('../../classes/languages/language_detect.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],12); 
$id_area=$_POST['id_area'];
$listado_subareas=$query->listar_subareas_curriculares($id_area);

if (mysql_num_rows($listado_subareas) > 0 ) {

echo '<label><strong>'.$translate['subarea'].'</strong></label>
    <div class="suboption" id="so2">
    <select name="subarea_curricular_basico" id="subarea_curricular_basico" realname="Subarea">';
     	echo '<option value="0">'.$translate['cualquiera'].'</option>';
	 	while ($row=mysql_fetch_array($listado_subareas)) {
							
			echo '<option value="'.$row['id_subac_material'].'">';
				if ($_SESSION['id_language'] > 0) {
					echo $row['subac_material_'.$_SESSION['language'].''];
				} else {
					echo $row['subac_material'];
				}
			echo '</option>'; 
		
		}
	 
echo '</select></div>';
} else {

	echo '<input name="subarea_curricular_basico" type="hidden" value="0" />';
}
?>

<?php 
session_start();
include ('../../classes/querys/query.php');
$query=new query();
$id_area=$_POST['id_area'];
$listado_subareas=$query->listar_subareas_curriculares_sin($_POST['msc'],$id_area);

echo '<select id="SUBACList" style="WIDTH: 150px" multiple="multiple" size="5" name="SUBACList">';
					if (mysql_num_rows($listado_subareas) > 0 ) {
					    while ($row=mysql_fetch_array($listado_subareas)) {
							echo '<option value="'.$row['id_subac_material'].'" sel="sel">'.$row['subac_material'].'</option>'; 
						}
					}			  
echo '</select>'; 
?>
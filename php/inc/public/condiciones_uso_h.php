<?php 
include ('../../classes/querys/query.php');
require ('../../classes/languages/language_detect.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],6); 
?>
<div class="left_50">
<?php include ('../menu_lateral.php'); ?>
</div>

<div class="right_50">

	<div id="right">
       <?php 
			echo '<h4>'.$translate['condiciones_uso'].'</h4>'.$translate['descipcion_condiciones_uso'];
			
			?>
    
    </div>
    
</div>

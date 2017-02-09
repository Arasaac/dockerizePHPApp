<?php 
session_start();  // INICIO LA SESION
require ('../classes/languages/language_detect.php');
require ('../classes/querys/query.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],5); 
?>
<div class="left_50">
<?php include ('menu_lateral.php'); ?>
</div>

<div class="right_50">

	<div id="right">
		<?php echo utf8_encode('<h4>'.$translate['que_es_arasaac_question'].'</h4> <br /> 
        <img src="images/img01.jpg" align="left" />'.$translate['explicacion_que_es_arasaac'].'');?>
	</div>

</div>


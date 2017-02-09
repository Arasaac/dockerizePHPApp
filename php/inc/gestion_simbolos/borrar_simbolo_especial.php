<?php 
include ('../../classes/querys/query.php');

$query=new query();

$id_simbolo=$_POST['id'];
$borrar_simbolo=$query->delete_simbolo_especial($id_simbolo);

echo  '<div class="right">
			<h3>S&iacute;mbolo: </h3>
			<div class="right_articles">
			
			</div>
			<h3>Informaci&oacute;n:</h3>
			<div class="right_articles">

			</div>
</div>';
?>


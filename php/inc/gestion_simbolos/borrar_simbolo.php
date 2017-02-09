<?php 
include ('../../classes/querys/query.php');

$query=new query();


$condicionantes=explode('||',$_POST['checkboxes']);

foreach ($condicionantes as $nombre_campo => $valor) {

	if ($valor != '') {
		$borrar_simbolo=$query->delete_simbolo($valor);
		//echo $valor.'/';
	}
	
}

echo  '<div class="right">
			<h3>S&iacute;mbolo: </h3>
			<div class="right_articles">
			
			</div>
			<h3>Informaci&oacute;n:</h3>
			<div class="right_articles">

			</div>
</div>';
?>


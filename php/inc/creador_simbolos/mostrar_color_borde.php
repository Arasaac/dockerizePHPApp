<?php 
require('../../funciones/funciones.php');
include_once ("../../classes/querys/query.php");
$query=new query();

$id_palabra=$_POST['id'];
$datos_palabra=$query->datos_palabra($id_palabra);

$id_tipo_palabra=$datos_palabra['id_tipo_palabra'];
	
	switch ($id_tipo_palabra) {
	
		case 1:
		$color='#FFFF00';
		break;
	
		case 2:
		$color='#FF9900';
		break;
		
		case 3:
		$color='#33CC00';
		break;
		
		case 4:
		$color='#3366FF';
		break;
		
		case 5:
		$color='#FF66CC';
		break;
		
		case 6:
		$color='#FFFFFF';
		break;
		
		default:
		$color='#000000';
		break;
	
	}
	
echo '<div id="color_borde"><input name="color_borde" type="text" id="color_borde" value="'.$color.'" size="7" maxlength="7" readonly="yes" style="background-color:'.$color.';"/> </div>';



?>
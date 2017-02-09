<?php 
include ('../../classes/querys/query.php');
$query=new query();
$datos_palabra=$query->datos_palabra($_POST['id']);

echo '<input name="id_palabra" type="hidden" id="id_palabra" value="'.$_POST['id'].'"><em><strong>'.utf8_encode($datos_palabra['palabra']).',</strong></em>&nbsp;'.utf8_encode($datos_palabra['definicion']).'';
?>


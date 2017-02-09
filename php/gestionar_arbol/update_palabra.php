<?php
session_start();
 
include ('../classes/querys/query.php');

$query=new query();

$palabra=$_POST['palabra'];
$id_palabra=$_POST['id_palabra'];
$id_tema=$_POST['temas'];
$pg=$_POST['pg'];

//$datos_palabra=$query->update_palabra($id_palabra, $_POST['PickList'],$palabra,$_POST['id_tipo_palabra'],1);
//$datos_palabra=$query->update_palabra_catalogador($id_palabra,$_POST['PickList']);
$datos_palabra=$query->update_palabra_catalogador_tmp($id_palabra,$_POST['PickList']);
if (isset($_POST['origen']) && $_POST['origen']=='revisor' && isset($_POST['tema_id']) && $_POST['tema_id'] > 0) {
	
	header ("Location: revisor.php?id_tema=".$_POST['tema_id']."&pg=$pg&mensaje=Palabra modificada");
	
} else {
	
	if ($pg=='' && $id_palabra > 0) {
		header ("Location: index.php?id_palabra=$id_palabra&mensaje=Palabra modificada");
	} else {
		header ("Location: index.php?pg=$pg&mensaje=Palabra modificada");
	}

}
?>
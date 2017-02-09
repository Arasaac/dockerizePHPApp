<?php 
session_start();

include ('../../../classes/querys/query.php');
$query=new query();

$file_id=$_POST['file_id'];
$id_palabra=$_POST['id_palabra'];

$actualizar=$query->actualizar_palabra_asociada_archivo_repositorio($file_id,$id_palabra);
echo "<br /><br /><br /><br /><br /><br /><br /><blockquote><blockquote><img src=\"../../images/button_ok.gif\" border=\"0\" alt=\"PALABRA ASOCIADA CORRECTAMENTE\"/>&nbsp;<b>PALABRA ASOCIADA CORRECTAMENTE</b></blockquote></blockquote>";
?>
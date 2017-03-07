<?php
session_start();
 
include ('../../classes/querys/query.php');

$query=new query();

if ($_POST['titulo'] != "" && $_POST['noticia'] != "") { 

$titulo=utf8_decode($_POST['titulo']);
$noticia=utf8_decode($_POST['noticia']);
$id_usuario=$_SESSION['ID_USER'];
$estado=$_POST['estado'];
$id_noticia=$_POST['id_noticia'];
$idioma=$_POST['idioma'];

$datos_palabra=$query->actualizar_noticia($id_noticia,$titulo,$noticia,$estado,$idioma);
echo "Noticia actualizada";

} else {
echo "Rellene todos los datos";
}




?>
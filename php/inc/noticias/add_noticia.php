<?php
session_start();
 
include ('../../classes/querys/query.php');

$query=new query();

if ($_POST['titulo'] != "" && $_POST['noticia'] != "") { 

$titulo=utf8_decode($_POST['titulo']);
$noticia=utf8_decode($_POST['noticia']);
$id_usuario=$_SESSION['ID_USER'];
$estado=$_POST['estado'];
$idioma=$_POST['idioma'];

$datos_palabra=$query->add_noticia($id_usuario,$titulo,$noticia,$estado,$idioma);
echo utf8_encode("Noticia añadida");


} else {
echo "Rellene todos los datos";
}




?>
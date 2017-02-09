<?php 
if (!isset($_SESSION)) {
  	session_start();
  	$_SESSION['AUTHORIZED']=false;
	$_SESSION['ID_USER']=0;
	$PHP_SELF=$_SERVER['PHP_SELF'];
}

require ('classes/querys/query.php');
require ('classes/languages/language_detect.php');
require ('text_size.php');
require ('thumbnail_size.php'); 

/* INICIALIZO LA CLASE QUERY (BUSQUEDAS) */
$query=new query();
?>
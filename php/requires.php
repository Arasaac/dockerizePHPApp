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

require ('funciones/funciones.php');
require ('classes/date/Date.class.php'); 
require ("classes/rss/feedcreator.class.php");
require ('operaciones_cesto.php');
require ('classes/zip/pclzip.lib.php');

require ('configuration/key.inc');
require ('classes/crypt/5CR.php');
$encript = new E5CR($llave);

require ('classes/highlight/highlight.class.php'); 
$resaltar = new Highlighter();

/* INICIALIZO LA CLASE FILTER QUE PREVIENE ATAQUES XSS de INYECCION DE CODIGO HTML */
require ('classes/inputfilter/class.inputfilter.php');
$ifilter = new InputFilter();
?>
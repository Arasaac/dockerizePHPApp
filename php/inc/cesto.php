<?php
session_start();
require_once('../classes/crypt/5CR.php');
require_once('../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

function stringForJavascript($in_string) {
   $str = ereg_replace("[\r\n]", " \\n\\\n", $in_string);
   $str = ereg_replace('"', '\\"', $str);
   Return $str;
}
if (isset($_GET['clearProduct'])) {
	$_SESSION['cart'][$_GET['id']]--;
	if ($_SESSION['cart'][$_GET['id']] == 0) {
		unset($_SESSION['cart'][$_GET['id']]);	
	}
	echo '<ul id="thelist1">';
	foreach ($_SESSION['cart'] as $key => $value) {
	
			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
			$ruta=$key['ruta_cesto'];
			$ruta_img='size=30&ruta=../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 
			
				echo "<li id=\"$key\"><a href=\"javascript:ventana_modal('img=../../$key&enc=0','inc/imagen.php')\"><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><span onclick=\"clearProduct('$ruta_cesto');\"><img src=\"images/papelera.png\" border=\"0\"/></span></li>";
	}
	echo '</li>';
	sleep(1);
	die;
}
if (isset($_GET['clear'])) {
	unset($_SESSION['cart']);
	sleep(1);
	die;
}
$prodid = $_GET['product_id'];
$_SESSION['cart'][$prodid] = 1;
echo '<ul id="thelist1">';
foreach ($_SESSION['cart'] as $key => $value) {

			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
			$ruta=$key['ruta_cesto'];
			$ruta_img='size=30&ruta=../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 
			
				print "<li id=\"$key\"><a href=\"javascript:ventana_modal('img=../../$key&enc=0','inc/imagen.php')\"><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><span onclick=\"clearProduct('$ruta_cesto');\"><img src=\"images/papelera.png\" border=\"0\"/></span></li>";
}
echo '</li>';
sleep(1);
?>

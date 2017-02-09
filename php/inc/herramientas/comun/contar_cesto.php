<?php 
session_start();

if (isset($_POST['accion']) && $_POST['accion']=='numero_simbolos') {

	$n=0;
	
		foreach ($_SESSION['cart'] as $key => $value) {
		 $n=$n+1;
		}
	
	echo $n;
}
?>

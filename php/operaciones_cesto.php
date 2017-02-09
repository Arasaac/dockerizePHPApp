<?php
/* ************************************************************************* */
/*  MI SELECCION */
/* ************************************************************************* */
if (isset($_POST['file'])) {
	
	$prodid='';

		foreach ($_POST['file'] as $key => $value) {
		
			$prodid = $value;
			$_SESSION['cart'][$prodid] = 1;
				
		}
}

if (isset($_GET['clearProduct'])) {
	$_SESSION['cart'][$_GET['id']]--;
	if ($_SESSION['cart'][$_GET['id']] == 0) {
		unset($_SESSION['cart'][$_GET['id']]);	
	}

}

if (isset($_GET['clear'])) {
	unset($_SESSION['cart']);
}

if (isset($_GET['product_id'])) {
	$prodid = $_GET['product_id'];
	$_SESSION['cart'][$prodid] = 1;
}
/* ************************************************************************* */

/* ************************************************************************* */
/*  CARPETA DE TRABAJO */
/* ************************************************************************* */
if (isset($_GET['clearWorkFolder'])) {
	unset($_SESSION['carpeta_personal']);
}

if (isset($_GET['clearFile'])) {
	$_SESSION['carpeta_personal'][$_GET['id']]--;
	if ($_SESSION['carpeta_personal'][$_GET['id']] == 0) {
		unset($_SESSION['carpeta_personal'][$_GET['id']]);	
	}

}
?>

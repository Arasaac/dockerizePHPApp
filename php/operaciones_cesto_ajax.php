<?php
	session_start();  // INICIO LA SESION	
	
	require ('configuration/key.inc');
	require ('classes/crypt/5CR.php');
	$encript = new E5CR($llave);
	
/* ************************************************************************* */
/*  MI SELECCION */
/* ************************************************************************* */
if (isset($_POST['file'])) {
	
	$prodid='';

		foreach ($_POST['file'] as $key => $value) {
		
			$prodid = $value;
			$_SESSION['cart'][$prodid] = 1;
				
		}
		
	$n=0; 
	$peso_total=0;
	
	if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") { 
		foreach ($_SESSION['cart'] as $key => $value) { 
			
			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
            $ruta=$key['ruta_cesto'];
			
			if (file_exists($ruta)) {
				$peso_total=$peso_total+filesize($ruta);
			}

			$n=$n+1; 
		} 
	}
	
	echo $n;
}

if (isset($_POST['clearProduct'])) {
	$_SESSION['cart'][$_POST['id']]--;
	if ($_SESSION['cart'][$_POST['id']] == 0) {
		unset($_SESSION['cart'][$_POST['id']]);	
	}
	
	$n=0; 
	$peso_total=0;
	
	if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") { 
		foreach ($_SESSION['cart'] as $key => $value) { 
			
			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
            $ruta=$key['ruta_cesto'];
			
			if (file_exists($ruta)) {
				$peso_total=$peso_total+filesize($ruta);
			}

			$n=$n+1; 
		} 
	}
	
	echo $n;

}

if (isset($_POST['clear'])) {
	unset($_SESSION['cart']);
	
	$n=0; 
	$peso_total=0;
	
	if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") { 
		foreach ($_SESSION['cart'] as $key => $value) { 
			
			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
            $ruta=$key['ruta_cesto'];
			
			if (file_exists($ruta)) {
				$peso_total=$peso_total+filesize($ruta);
			}

			$n=$n+1; 
		} 
	}
	
	echo $n;
}

if (isset($_POST['product_id'])) {
	
	$prodid = $_POST['product_id'];
	$_SESSION['cart'][$prodid] = 1;
	
	$n=0; 
	$peso_total=0;
	
	if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") { 
		foreach ($_SESSION['cart'] as $key => $value) { 
			
			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
            $ruta=$key['ruta_cesto'];
			
			if (file_exists($ruta)) {
				$peso_total=$peso_total+filesize($ruta);
			}

			$n=$n+1; 
		} 
	}
	
	echo $n;
}
/* ************************************************************************* */

/* ************************************************************************* */
/*  CARPETA DE TRABAJO */
/* ************************************************************************* */
if (isset($_POST['clearWorkFolder'])) {
	unset($_SESSION['carpeta_personal']);
}

if (isset($_POST['clearFile'])) {
	$_SESSION['carpeta_personal'][$_POST['id']]--;
	if ($_SESSION['carpeta_personal'][$_POST['id']] == 0) {
		unset($_SESSION['carpeta_personal'][$_POST['id']]);	
	}

}

?>

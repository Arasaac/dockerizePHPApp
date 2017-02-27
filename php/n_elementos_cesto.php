<?php 
	// Turn off all error reporting
	//evito que me salga el warning "session_start(): Cannot send session cookie - headers already sent"
    //error_reporting(0);
	
	session_start();  // INICIO LA SESION	
	
	require ('configuration/key.inc');
	require ('classes/crypt/5CR.php');
	$encript = new E5CR($llave);

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
?>
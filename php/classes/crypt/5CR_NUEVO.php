<?php
class E5CR{

  function encriptar(&$encript, $tipo)
  {
	$encript=base64_encode($encript);
  }

  function destrozar(&$cadena, $num){
		for($i=0;$i<$num;$i++){
			$pos = strpos($cadena,"="); // posición del primer =
			$campo = substr($cadena,0,$pos); // sustración del nombre del campo
			$cadena = substr($cadena,$pos+1,strlen($cadena)); // actualización de la cadena
			$pos = strpos($cadena,"&"); // posición del primer &
			if($pos == null)
				$pos = strlen($cadena);
			$contenido = substr($cadena,0,$pos);
			$cadena = substr($cadena,$pos+1,strlen($cadena)); // actualización de la cadena
			$datos[$campo] = $contenido;
			
		}
		return $datos;
  }
  
  function desencriptar(&$desencript, $num)
  {
  	$desencript = $this->destrozar(base64_decode($desencript), $num);
  }
}
?>
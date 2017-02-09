<?php
/*
 * Ejemplo practico para encriptar contraseñas con 5CR
*/

include("5CR.php");

$llave = "54123698741()5632147893++";
$msg = "Hola Mundo!";

$encriptacion = new E5CR($llave);
echo "Mensaje Original: <b>$msg</b><br>";
$encriptacion->encriptar($msg,0);
echo "Mensaje Encriptado: <b>$msg<b>";
?>
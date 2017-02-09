<?php
/*
 * Ejemplo practico para pasar variables encriptadas por el metodo GET con 5CR
*/

include("5CR.php");
$llave = "1jula3845jjk3f900+094n45?n3$5bekl2890556v189fk";

if($_GET['val'] != null){
	$encriptacion = new E5CR($llave);
	$datos = $_GET['val'];
	$encriptacion->desencriptar($datos,3);
	echo '
	  <p>
    <input type="text" name="textfield" value="'.$datos['nombre'].'">
</p>
  <p>
    <input type="text" name="textfield" value="'.$datos['apellidos'].'">
</p>
  <p>
    <input type="text" name="textfield" value="'.$datos['tel'].'">
  </p>';
}
else{
	$encriptacion = new E5CR($llave);
	$msg = 'nombre=Julian Andrés&apellidos=Lasso Figueroa&tel=443-9837';
  $encriptacion->encriptar($msg,1);
  echo '
<p>Este es un ejemplo donde pasaremos tres variables</p>
<p>nombre = Julian Andr&eacute;s<br>
apellidos = Lasso Figueroa<br>
tel = 443-9837</p>
<p>quedando el link asi:<br>
http://www.hola.com/ejemplo_url.php?nombre=Julian Andr&eacute;s&amp;apellidos=Lasso Figueroa&amp;tel=443-9837</p>
<p>pero lo encriptamos y queda asi has clic en Julian:<br>
<a href="ejemplo_url.php?val='.$msg.'">Julian</a></p>
  ';
}

?>
<?php 
include ('../../classes/querys/query.php');

$caracteres=0;
$login=$_POST['login'];
$boton=$_POST['boton'];
$caracteres=strlen($login);

$query=new query();
$comprobar_login=$query->comprobar_login($login);

if ($comprobar_login==0 && $caracteres > 4) {
echo ' <input type="submit" name="Submit2" value="'.$boton.'"/>';
} elseif ($comprobar_login > 0 || $caracteres <= 4) {
echo ' <input type="submit" name="Submit2" value="'.$boton.'" disabled="disabled"/>';
}
?>

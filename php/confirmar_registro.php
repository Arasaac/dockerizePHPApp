<?php 
require_once("lang/lang_es.php");
require_once("funciones/funciones.php");
include ('classes/querys/query.php');

$query=new query();

require_once('classes/crypt/5CR.php');
require_once('configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$usuario=$_GET['i'];

$encript->desencriptar($usuario,1);

$id_usuario=$usuario['id_usuario'];

$usuario=$query->activar_usuario($id_usuario);

$oldumask = umask(0);
mkdir ("usuarios/$id_usuario/", 0777);
umask ($oldumask);

header ('Location: index.php');

?>
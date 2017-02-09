<?php 
session_start();  // INICIO LA SESION
include('menu_principal.php');
include ('../funciones/funciones.php');
include ('../classes/querys/query.php');
$query=new query();

$usuario='';
$password='';
$usuario=$_POST['usuario'];
$password=$_POST['password'];

$comprobar_usuario=$query->authenticate($usuario,$password);
$logeado=mysql_num_rows($comprobar_usuario);
$row=mysql_fetch_array($comprobar_usuario);


$username=$row['login'];
$id_user=$row['id_colaborador'];
$permisos=1;


if ($logeado==1) {

$_SESSION['USERNAME'] = $username;
$_SESSION['ID_USER'] = $id_user;
$_SESSION['PRIVILEGES'] = $permisos;
$_SESSION['AUTHORIZED'] = true;

$permisos=$query->permisos_usuario($_SESSION['ID_USER']);

print '<br><br>'.utf8_encode(saludo()).', <b>'.$row['login'].'</b><img src="images/button_ok.gif" alt="Bienvenido al rinc&oacute;n ARASAAC" title="Bienvenido al rinc&oacute;n ARASAAC" align="left"><br>Bienvenido a ARASAAC';
		
} else {

$_SESSION['AUTHORIZED'] = false;

print '<img src="images/error.gif" alt="Nombre de usuario o contrase&ntilde;a incorrectas" title="Nombre de usuario o contrase&ntilde;a incorrectas"><br>Nombre de usuario o contrase&ntilde;a incorrectas';

}

?>



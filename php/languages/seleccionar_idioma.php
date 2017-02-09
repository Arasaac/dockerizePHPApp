<?php
session_start();
require ('../classes/querys/query.php');
require('LoginSystem.class.php');

$loginSys = new LoginSystem();

/**
 * if not logged in goto login form, otherwise we can view our page
 */
if(!$loginSys->isLoggedIn())
{
	header("Location: languages/loginForm.php");
	exit;
} else {
	
	$_SESSION['idioma_a_traducir']=$_GET['lang'];
	header("Location: ../gestionar_internacionalizacion.php");
}

?>
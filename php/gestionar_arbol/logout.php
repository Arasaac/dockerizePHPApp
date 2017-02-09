<?php
/**
 * 	logout.php
 * 
 * 	signs the user out, destroying session data etc.
 * 
 */

session_start();
require ('../classes/querys/query.php');
require('LoginSystem.class.php');

$loginSys = new LoginSystem();

$loginSys->logout();

header('location: loginForm.php');

?>
<?php
/**
 * makeSecure.php
 * 
 * This file is included at the top of any page you wish to make secure with a login.
 *
 * Access will be granted only if they are logged in, else returned to login page.
 * 
 * Usage:	require('../Copia de languages/makeSecure.php');
 * 
 */

session_start();
require ('../classes/querys/query.php');
require('LoginSystem.class.php');

$loginSys = new LoginSystem();

/**
 * if not logged in goto login form, otherwise we can view our page
 */
if(!$loginSys->isLoggedIn())
{
	header("Location: loginForm.php");
	exit;
}
?>
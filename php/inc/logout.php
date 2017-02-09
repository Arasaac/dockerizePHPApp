<?
	session_start();
	
		$_SESSION['USERNAME'] = "";
		$_SESSION['ID_USER'] = "";
		$_SESSION['PRIVILEGES'] = "";
		$_SESSION['AUTHORIZED'] = false;

	session_unset();
	//session_destroy();
	echo '';

?>
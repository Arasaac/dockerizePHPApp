<?php session_start(); 
	require ('../classes/querys/query.php');
	require_once('LoginSystem.class.php');
	
	if(isset($_POST['Submit']))
	{
		if((!$_POST['Username']) || (!$_POST['Password']))
		{
			// display error message
			header('location: loginForm.php?msg=1');// show error
			exit;
		}
		
		$loginSystem = new LoginSystem();
		if($loginSystem->doLogin($_POST['Username'],$_POST['Password']))
		{
			/**
			 * Redirect here to your secure page
			 */
			if ($_SESSION['IsReviser']==0) { 
				header('location: index.php');
			} elseif ($_SESSION['IsReviser']==1) {
				header('location: revisor.php');
			}
		}
		else
		{
			header('location: loginForm.php?msg=2');
			exit;
		}
	}
	
	/**
	 * show Error messages
	 *
	 */
	function showMessage()
	{
		if(is_numeric($_GET['msg']))
		{
			switch($_GET['msg'])
			{
				case 1: echo "Rellena todos los campos";
				break;
				
				case 2: echo "Datos incorrectos";
				break;
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Form</title>
	<link href="../Copia de languages/css/styles.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<div id="wrapper">
	<div class="cent" style="border-bottom: #000000 1px solid;">
	  <h1>Acceder</h1></div>
	<div class="cent"><h3 class="error"><?php showMessage();?></h3></div>
	<div>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input name="Username" type="text" size="30" maxlength="30" /><br />
			<input name="Password" type="password" size="30" maxlength="30" /><br />
			<input name="Submit" type="submit" value="Logearse" /><br />
		</form>
	</div>
</div>
</body>
</html>

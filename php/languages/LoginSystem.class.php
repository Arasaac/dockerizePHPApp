<?php session_start();
/**
 * LoginSystem
 * 
 * Simple Login system with sessions and MySQL User DB
 * 
 * @version		1.0
 * @author 		A.Surrey	(www.surneo.com)
 * 
 * 
 */

class LoginSystem extends query 
{
	var	$db_host,
		$db_name,
		$db_user,
		$db_password,
		$connection,
		$username,
		$password;

	/**
	 * Constructor
	 */
	function LoginSystem()
	{
		
		$this->db_host = $this->HOST;
		$this->db_name = $this->DBNAME;
		$this->db_user = $this->USERNAME;
		$this->db_password = $this->PASSWORD;
	}
	
	/**
	 * Check if the user is logged in
	 * 
	 * @return true or false
	 */
	function isLoggedIn()
	{
		if($_SESSION['LoggedIn'])
		{
			return true;
		}
		else return false;
	}
	
	/**
	 * Check username and password against DB
	 *
	 * @return true/false
	 */
	function doLogin($username, $password)
	{
		$this->connect();
		
		$this->username = $username;
		$this->password = $password;
		
		// check db for user and pass here.
		$sql = sprintf("SELECT * FROM traductores WHERE login = '%s' and password = '%s'", 
											$this->clean($this->username), $this->clean($this->password));
						
		$result = mysql_query($sql, $this->connection);
		// If no user/password combo exists return false
		if(mysql_affected_rows($this->connection) != 1)
		{
			$this->disconnect();
			return false;
		}
		else // matching login ok
		{
			$row = mysql_fetch_assoc($result);
			
			// more secure to regenerate a new id.
			session_regenerate_id();
			
			//set session vars up
			$_SESSION['LoggedIn'] = true;
			$_SESSION['userName'] = $this->username;
			
		}
		
		$this->disconnect();
		return true;
	}
	
	/**
	 * Destroy session data/Logout.
	 */
	function logout()
	{
		unset($_SESSION['LoggedIn']);
		unset($_SESSION['userName']);
		unset($_SESSION['idioma_a_traducir']);
		session_destroy();
	}
	
	/**
	 * Connect to the Database
	 * 
	 * @return true/false
	 */
	function connect()
	{
		$this->connection = mysql_connect($this->db_host, $this->db_user, $this->db_password) 
														or die("Unable to connect to MySQL");
		
		mysql_select_db($this->db_name, $this->connection) or die("Unable to select DB!");
		
		// Valid connection object? everything ok?
		if($this->connection)
		{
			return true;
		}
		else return false;
	}
	
	/**
	 * Disconnect from the db
	 */
	function disconnect()
	{
		mysql_close($this->connection);
	}
	
	/**
	 * Cleans a string for input into a MySQL Database.
	 * Gets rid of unwanted characters/SQL injection etc.
	 * 
	 * @return string
	 */
	function clean($str)
	{
		// Only remove slashes if it's already been slashed by PHP
		if(get_magic_quotes_gpc())
		{
			$str = stripslashes($str);
		}
		// Let MySQL remove nasty characters.
		$str = mysql_real_escape_string($str);
		
		return $str;
	}
	
	/**
	 * create a random password
	 * 
	 * @param	int $length - length of the returned password
	 * @return	string - password
	 *
	 */
	function randomPassword($length = 8)
	{
		$pass = "";
		
		// possible password chars.
		$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",
			   "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",
			   "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
			   
		for($i=0 ; $i < $length ; $i++)
		{
			$pass .= $chars[mt_rand(0, count($chars) -1)];
		}
		
		return $pass;
	}

}

?>
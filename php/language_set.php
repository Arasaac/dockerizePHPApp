<?php 
if(isset($_GET["lan"])){
   //es que estoy recibiendo un idioma nuevo, lo tengo que meter en las cookies
   $selected_language = $_GET["lan"];
   //meto el idioma en una cookie
   setcookie("selected_language", $selected_language, time() + (60 * 60 * 24 * 7));  // COOKIE para 7 días
   
}
header("Location: index.php"); 
?>
<?php 
session_start();

/*if ($_SESSION['ID_USER'] == '' || $_SESSION['ID_USER']==0) {
die;
} else {*/

$imagen=$_GET['img'];

echo '<img src="'.$imagen.'" border="0">';

/*}*/
?>
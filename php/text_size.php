<?php 
if (isset($_SESSION["selected_text_size"])){
	$letter_size=$_SESSION["selected_text_size"];
} else {
	$letter_size=0.9;
}

if (isset($_GET['l'])) { 
				 
	switch ($_GET['l']) {
		case -1:
		$letter_size=$letter_size-0.1;
		$_SESSION["selected_text_size"]=$letter_size;
		break;
		
		case 0:
		$letter_size=0.9;
		$_SESSION["selected_text_size"]=$letter_size;
		break;
		
		case 1:
		$letter_size=$letter_size+0.1;
		$_SESSION["selected_text_size"]=$letter_size;
		break;
	}
}



?>
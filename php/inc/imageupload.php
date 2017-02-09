<?php
	/**
	 * This file uploads a file in the back end, without refreshing the page
	 *  
	 */
	
	if (isset($_POST['id'])) {
		if (!copy($_FILES[$_POST['id']]['tmp_name'], '../temp/'.$_FILES[$_POST['id']]['name'])) {
			echo '<script> alert("Error en la transferencia del archivo");</script>';
		}
	}
	else {
		echo "Archivo almacenado";
	}
?>
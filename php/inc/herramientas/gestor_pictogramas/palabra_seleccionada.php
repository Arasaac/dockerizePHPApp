<?php 
include ('../../../classes/querys/query.php');
$query=new query();
$palabras_seleccionadas=explode(';',$_POST['id']);

foreach ($palabras_seleccionadas as $key => $value) {

	if ($value != '') {
		$datos_palabra=$query->datos_palabra($value);
		echo '<em><strong>'.utf8_encode($datos_palabra['palabra']).',</strong></em>&nbsp;'.utf8_encode($datos_palabra['definicion']).'&nbsp;<a href="javascript:void(0);" onclick="borrar_palabra(\'palabra_seleccionada.php\',\''.$value.'\',\'selected_word\');">Borrar</a><br>';
	}

}

$n_palabras=count($palabras_seleccionadas)-1;

if ($n_palabras>0) {

	echo '<div align="center">
			 <br><br>
		   <input type="submit" name="Submit2" value="Guardar imagen"/>
		</div>';
} else {

	echo '<div align="center">
			 <br><br>
		   <input type="submit" name="Submit2" value="Guardar imagen"/>
		</div>';
}
?>


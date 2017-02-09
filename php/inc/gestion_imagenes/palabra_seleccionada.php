<?php 
include ('../../classes/querys/query.php');
$query=new query();
$palabras_seleccionadas=explode(';',$_POST['id']);

foreach ($palabras_seleccionadas as $key => $value) {

	if ($value != '') {
		$datos_palabra=$query->datos_palabra($value);
		echo '<em><strong>'.utf8_encode($datos_palabra['palabra']).',</strong></em>&nbsp;'.utf8_encode($datos_palabra['definicion']).'&nbsp;<a href="javascript:void(0);" onclick="borrar_palabra(\'inc/gestion_imagenes/palabra_seleccionada.php\',\''.$value.'\',\'selected_word\');">Borrar</a><br>';
	}

}

$n_palabras=count($palabras_seleccionadas)-1;

if ($n_palabras>0) {

	echo '<div align="center">
			 <br><br>
		   <input type="button" name="Submit2" value="Guardar imagen" onclick="cargar_div(\'inc/gestion_imagenes/add_new_picture.php\',\'tipo_imagen=\'+document.form1.id_tipo_imagen.value+\'&imagen=\'+document.img_subida.imagen_subida.value+\'&id_palabra=\'+document.form1.palabras_seleccionadas.value+\'&original_filename=\'+document.img_subida.original_filename.value+\'&estado=\'+document.form1.estado.value+\'&registrado=\'+document.form1.registrado.checked+\'&autor=\'+document.form1.autor.value+\'&licencia=\'+document.form1.licencia.value+\'&tags=\'+document.form1.tags.value+\'&tipo_picto=\'+document.form1.tipo_picto.value+\'&validos_senyalectica=\'+document.form1.validos_senyalectica.checked+\'\',\'principal\'); "/>
		</div>';
} else {

	echo '<div align="center">
			 <br><br>
		   <input type="button" name="Submit2" value="Guardar imagen" onclick="cargar_div(\'inc/gestion_imagenes/add_new_picture.php\',\'tipo_imagen=\'+document.form1.id_tipo_imagen.value+\'&imagen=\'+document.img_subida.imagen_subida.value+\'&original_filename=\'+document.img_subida.original_filename.value+\'&id_palabra=\'+document.form1.palabras_seleccionadas.value+\'&estado=\'+document.form1.estado.value+\'&registrado=\'+document.form1.registrado.checked+\'&autor=\'+document.form1.autor.value+\'&licencia=\'+document.form1.licencia.value+\'&tags=\'+document.form1.tags.value+\'\',\'principal\'); " disabled="disabled"/>
		</div>';
}
?>


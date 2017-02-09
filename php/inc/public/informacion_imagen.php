<?php 
session_start();

include ('../../classes/querys/query.php');
$query=new query();

$id_imagen=$_POST['id'];
$row=$query->datos_imagen($id_imagen);

// RECOPilO INFORMACION DE LA IMAGEN

$fsize = @filesize("../../repositorio/originales/".$row['imagen'])/1024;

	switch ($row['extension']) {
		case "gif":	$src = "gif"; $img = @imagecreatefromgif("../../repositorio/originales/".$row['imagen']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "jpg":		$src = "jpeg"; $img = @imagecreatefromjpeg("../../repositorio/originales/".$row['imagen']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "jpeg":	$src = "jpeg"; $img = @imagecreatefromjpeg("../../repositorio/originales/".$row['imagen']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "png":		$src = "png"; $img = @imagecreatefrompng("../../repositorio/originales/".$row['imagen']); $img_y = imagesy($img); $img_x = imagesx($img); break;
	 }
				

echo  '<div class="right">
			<h3>Imagen: </h3><div id="products" style="float:right;"><a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/originales/").'/'.$row['imagen'].'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir s&iacute;mbolo a mi cesto"></a></div><br>
			    
			<img src="classes/img/thumbnail.php?size=250&ruta='.md5("../../").'/'.md5("repositorio/originales/").'/'.$row['imagen'].'" border="0"" alt="Mostrar informacion de la imagen"/>	
			<h3>Informaci&oacute;n:</h3>
			<div class="right_articles">
			  <b>Peso: </b>'; printf(" %.2f kB", $fsize);

echo '<br><b>Tama&ntilde;o: </b>'.$img_x.'x'.$img_y.'
			</div>
</div>';

 ?>
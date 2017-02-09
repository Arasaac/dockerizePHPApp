<?php 
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

include ('../../../classes/querys/query.php');
$query=new query();

$tipos_imagen=$query->listar_tipos_imagen();


while ($salida=mysql_fetch_array($tipos_imagen)) {

$img_disponibles=$query->imagenes_disponibles_tipo($_POST['id'],$salida['id_tipo']);
$num_resultados=mysql_num_rows($img_disponibles);

// Inicializo las variables
$o=0;
$img=array();
$file='';

// Si el numero de resultados es mayor de 0 muestro los resultados
if ($num_resultados > 0) {

	$resultados.='<div id="b'.$salida['id_tipo'].'" name="'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' imagen/es)">';
	
		while ($row=mysql_fetch_array($img_disponibles)) {
			$img[]=$row['imagen'];
		}
	
		for ($i=1; $i<=10; $i++){ // FILAS
			
					$file=$img[$o];
					
					$ruta_img='size=50&ruta=../../../../repositorio/originales/'.$file;
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					if ($file=="") { break; }
					$resultados.="
					<a href=\"javascript:void()\" onclick=\"javascript:cargar_div('utilizar_imagen.php','img=".$file."','simbolo');\">
					<img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" alt=\"Imagen: ".$file."\" border=\"0\"/>
					</a>"; 
					$o++;  
		} 
	$resultados.='</div>';

	} // Cierro el IF de comprobacion de si hay resultados
	

} // Cierro el While 

echo $resultados;
?>
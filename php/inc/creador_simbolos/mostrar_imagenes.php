<?php 
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

include ('../../classes/querys/query.php');
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

		$resultados.='<b>'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' imagen/es)</b><hr>';
	
		while ($row=mysql_fetch_array($img_disponibles)) {
			$img[]=$row['imagen'];
		}

	$resultados.='<table class=\"tabla_img\">';
	
		for ($i=1; $i<=10; $i++){ // FILAS
			$resultados.="<tr>"; 
				for ($e=1; $e<=5; $e++){ //COLUMNAS
				
					$file=$img[$o];
					
					if ($file=="") { break; }
					
					$ruta_img='size=50&ruta=../../repositorio/originales/'.$file;
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$resultados.="<td width=\"25%\" class=\"tabla_img\" style=\"padding:15px;\"><div align=\"center\">
					<a href=\"javascript:void()\" onclick=\"javascript:cargar_div('inc/creador_simbolos/utilizar_imagen.php','img=".$file."','simbolo');\">
					<img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" alt=\"Imagen: ".$file."\" border=\"0\"/>
					</a></div></td>"; 
					$o++; 
				} 
			$resultados.="</tr>"; 
		} 
	$resultados.='</table></div>';

	} // Cierro el IF de comprobacion de si hay resultados


} // Cierro el While 

echo $resultados;
?>
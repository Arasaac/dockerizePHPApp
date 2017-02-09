<?php 
session_start();
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

include ('../../../classes/querys/query.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1);
$tipos_imagen=$query->listar_tipos_imagen();

$resultados.='<ul id="thelist5">';

while ($salida=mysql_fetch_array($tipos_imagen)) {

$img_disponibles=$query->imagenes_disponibles_tipo($_POST['id'],$salida['id_tipo']);
$num_resultados=mysql_num_rows($img_disponibles);

// Inicializo las variables
$o=0;
$img=array();
$file='';
$panel=$_POST['panel'];
$fila=$_POST['fila'];
$columna=$_POST['columna'];

// Si el numero de resultados es mayor de 0 muestro los resultados
if ($num_resultados > 0) {
	$r=0;	
		while ($row=mysql_fetch_array($img_disponibles)) {
				
				if ($row['id_tipo_imagen'] !=11) {
				$ruta_img='ruta=../../../../repositorio/originales/'.$row['imagen'].'&size=60';
                $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
				$ruta_img_previa='ruta=../../../../repositorio/originales/'.$row['imagen'].'&size=30';
                $encript->encriptar($ruta_img_previa,1); //OJO uno(1) es para encriptar variables para URL
									
				$resultados.='<li id="thelist5_'.$r.'"><a href="javascript:void(0);" onclick="seleccionar_pictograma_horarios(\''.$panel.'\',\''.$fila.'\',\''.$columna.'\',\''.$ruta_img.'\',\''.$_POST['acepcion'].'\');" target="_self"><img src="../classes/img/thumbnail.php?i='.$ruta_img_previa.'" alt="'.$translate['utilizar_imagen_en_el_generador_horarios'].'" title="'.$translate['utilizar_imagen_en_el_generador_horarios'].'" border="0"></a></li>';
				
				$r++;
				}
				
		}
	
	

	} // Cierro el IF de comprobacion de si hay resultados
	

} // Cierro el While 

$resultados.='</ul>';
echo $resultados;
?>
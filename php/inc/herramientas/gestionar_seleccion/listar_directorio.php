<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$query=new query();
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$id=$_GET['id'];
$nivel=$_GET['nivel'];
$id_usuario=$_SESSION['ID_USER'];

$dir=$query->datos_directorio($id,$_SESSION['ID_USER']);

?>
<ul id="thelist1" style="height:450px; overflow:scroll;">
<?php 
		 
		 $contenido_directorio=$query->contenido_directorio($dir['id']);
		 
		 while ($row=mysql_fetch_array($contenido_directorio)) {
			
			if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
			elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
			
			$ruta_img='size=30&ruta=../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 	
			
			$miruta='img='.$ruta.'&file_id='.$row['file_id'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
			$encript->encriptar($miruta,1);
			
			echo utf8_encode("<li id=\"thelist1_".$ruta_cesto."\"><a href=\"javascript:void(0);\" onclick=\"Dialog.alert({url: 'imagen.php?i=".$miruta."', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:400, height:500, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});\"><img src=\"../../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><span onclick=\"cargar_div2('gestionar_seleccion/add_to_selection.php','id_file=".$row['file_id']."&s=".$_GET['s']."','thelist2');\"><img src=\"../../images/mas.gif\" border=\"0\" title=\"Añadir a selección\" alt=\"Añadir a selección\"/></span></li>");
			}
		 ?>
</ul>
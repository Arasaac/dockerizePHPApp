<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$query=new query();
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$id=$_POST['id'];
$nivel=$_POST['nivel'];
$id_usuario=$_POST['id_usuario'];

$dir=$query->datos_directorio($id,$id_usuario);

?>
<div id="dir_files">
<?php 
		 
		 $contenido_directorio=$query->contenido_directorio($dir['id']);
		 
		 while ($row=mysql_fetch_array($contenido_directorio)) {
			
			if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$id_usuario.'/'.$row['file_name']; }
			elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
			
			
			$ruta_img='size=30&ruta=../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 	
			
				echo "<li id=\"thelist1_".$ruta_cesto."\"><a href=\"javascript:void(0)\"><img src=\"../../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><span onclick=\"clearProduct_herramientas('$ruta_cesto');\"><img src=\"../../images/papelera.png\" border=\"0\"/></span></li>";
			}
		 ?>
</div>
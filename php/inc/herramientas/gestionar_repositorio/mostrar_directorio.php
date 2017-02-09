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
<div id="directorio_actual" style="border-bottom:1px solid #999999;">
 <p>Repositorio / <strong> <?php echo $dir['name']; ?></strong></p>
         <p>Nueva carpeta: 
           <label>
           <input type="text" name="nombre_carpeta" id="nombre_carpeta" />
           <input name="parent" type="hidden" id="parent" value="<?php echo $dir['id']; ?>" />
           <input name="id_usuario" type="hidden" id="id_usuario" value="<?php echo $id_usuario; ?>" />
           </label>
           <input name="nivel" type="hidden" id="nivel" value="<?php echo $id_nivel ?>" />
           <input name="id_directorio" type="hidden" id="id_directorio" value="<?php echo $dir['id']; ?>" />
           <label>
           <input type="submit" name="button" id="button" value="Crear Carpeta" onclick="cargar_div('gestionar_repositorio/crear_directorio.php','directorio='+document.gestionar_repositorio.nombre_carpeta.value+'&nivel='+document.gestionar_repositorio.nivel.value+'&id_usuario='+document.gestionar_repositorio.id_usuario.value+'&parent='+document.gestionar_repositorio.parent.value+'','mi_repositorio');" />
           </label>
         </p>

</div>
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
			
				echo "<li><a href=\"javascript:void(0)\"><img src=\"../../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><span onclick=\"clearProduct_herramientas('$ruta_cesto');\"><img src=\"../../images/papelera.png\" border=\"0\"/></span></li>";
			}
		 ?>
</div>
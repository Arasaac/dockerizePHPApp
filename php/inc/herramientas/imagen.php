<?php 
include ('../../classes/querys/query.php');
require_once('classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$datos = $_GET['i']; //pasamos el paquete a una variable en nuestro caso es val
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$encript->desencriptar($datos,3); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
$imagen='../../'.$datos['img'];
$id_imagen=$datos['id_imagen'];	
$id_palabra=$datos['id_palabra'];
$file_id=$datos['file_id'];

$query=new query();
$row=$query->datos_archivo_repositorio($file_id);
$datos_palabra=$query->datos_palabra($row['id_palabra']);

$extension = strtolower(substr(strrchr($imagen, "."), 1));
	
switch ($extension) {

	case "gif":
	$source = imagecreatefromgif($imagen); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
	break;
	
	case "png":
	$source = imagecreatefrompng($imagen); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
	break;
	
	case "jpg":
	$source = imagecreatefromjpeg($imagen); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
	break;

}
$ruta='img=../../'.$datos['img'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$datos_palabra['id_palabra'];
$encript->encriptar($ruta,1);			
?>
<div id="mostrar_imagen" style="width:100%" align="center">
<div id="products" align="left">
<table width="100%" border="0">
  <tr>
    <td width="89%"><div id="loading"><img src="images/loading2.gif" alt="Cargando..." /></div></td>
    <td width="11%" align="right"><?php echo '<div id="products" style="float:right; width:80px;"><a href="../../inc/public/descargar.php?i='.$ruta.'"><img src=\'../../images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a></div>'; ?> </td>
  </tr>
</table>
</div>
<?php 
$ruta_img='size=250&ruta=../../../../'.$datos['img'];

$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL		
echo '<img src="classes/img/thumbnail.php?i='.$ruta_img.'" border="0" class="image" title="'.utf8_encode($row['palabra']).'">';
?>
<p align="left"><b>Tama&ntilde;o:</b><?php echo $imageX."x".$imageY; ?> <br />
	<b>Palabra:</b><?php echo $datos_palabra['palabra']; ?> <br />
    <b><?php echo utf8_encode("Definición:"); ?></b><?php echo utf8_encode($datos_palabra['definicion']); ?> <br />
    <br />
</p>


<hr />
<p align="center"><strong>TAGS</strong><br />
  <?php 
  $tags=str_replace('}{',',',$row['tags_imagen']);
  $tags=str_replace('{','',$tags);
  $tags=str_replace('}','',$tags);
  $tags=explode(',',$tags);
  
  for ($i=0;$i<count($tags);$i++) { 
  	if ($tags[$i]!='') {
 	 echo '<a href="javascript:void(0);" onclick="cargar_div2(\'inc/public/buscar_por_tags.php\',\'palabra='.$tags[$i].'\',\'principal\');">'.$tags[$i].'</a> '; 
	}
  }
  
  ?>  </p>
</div>
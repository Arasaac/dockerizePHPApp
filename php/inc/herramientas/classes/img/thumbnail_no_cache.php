<?php
require_once('../crypt/5CR.php');
require_once('../../configuration/key.inc');
include_once ("../querys/query.php");
$query=new query();

if (isset($_GET['i'])) { 

	$datos = $_GET['i']; //pasamos el paquete a una variable en nuestro caso es val
	$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
	$encript->desencriptar($datos,2); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
	$ruta=$datos['ruta'];
	$tamaño_max=$datos['size'];	/* RECOJO Y GUARDO EL TAMAÑO DE LA IMAGEN */
	
} else {

	if (!isset($_GET['enc']) || $_GET['enc'] <> 0) {
	
		$path=explode('/',$_GET['ruta']);
		
		switch ($path[0]) {
		
			case md5('../'):
			$ruta='../';
			break;
			
			case md5('../../'):
			$ruta='../../';
			break;
			
			case md5('../../../'):
			$ruta='../../../';
			break;
		}
		
		switch ($path[1]) {
		
			case md5('repositorio/originales/'):
			$ruta.='repositorio/originales/';
			break;
			
			case md5('repositorio/simbolos/'):
			$ruta.='repositorio/simbolos/';
			break;
			
			case md5('repositorio/specials_smbl/'):
			$ruta.='repositorio/specials_smbl/';
			break;
			
			case md5('temp/'):
			$ruta.='temp/';
			break;
		}
		
		$ruta.=$path[2];
	
	} elseif (isset($_GET['enc']) && $_GET['enc']==0) {
	
		$ruta=$_GET['ruta'];
	} 
$tamaño_max=$_GET['size'];

}
/* *********************************************************************************** */
/* PAGINA QUE CONSTRUYE EL THUMBNAIL DE UNA IMAGEN DADA                                */
/* *********************************************************************************** */

      $thumbnailWidth=$tamaño_max; /* DEFINO CUAL VA A SER LA ANCHURA MAXIMA DEL THUMBNAIL CON EL VALOR MANDADO $TAMAÑO_MAX */   
      $filename = $ruta; /* GUARDO EL NOMBRE DE LA IMAGEN */
	  $extension = strtolower(substr(strrchr($filename, "."), 1)); /* EXTRAIGO CUAL ES LA EXTENSIÓN DE LA IMAGEN TOMANDO EL PUNTO COMO CORTE */
	  
	  $buscar = "temp";
	  $resultado = strpos($ruta,$buscar);
	  
	  switch ($extension) { /* EN FUNCIÓN DE LA EXTENSIÓN DE LA IMAGEN..... */
		
		/* SI LA IMAGEN ES GIF. LA LIBRERIA GD YA NO SOPORTA IMAGENES GIF POR LO QUE ESTA ES TRATATADA COMO JPEG PERDIENDO
		EN EL THUMNAIL LAS TRASPARENCIAS QUE PUDIERA TENER */
		case "gif": 
		
		$nombre_archivo=basename($filename, ".gif");
		$di=$query->datos_imagen_tipo_imagen($nombre_archivo);
		
		$source = imagecreatefromgif($filename); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
   		$thumbX = $thumbnailWidth;   /* ESTABLEZCO LA ANCHURA DEL THUBNAIL */ 
   		$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
		$imageY = imagesy($source);  /* ALMAVENO LA ALTURA DE LA IMAGEN */
		$thumbY = (int)(($thumbX*$imageY) / $imageX ); /* REALIZO LAS OPERACIONES NECESARIAS PARA AVERIGUAR LA ALTURA PROPORCIONAL A LA ANCHURA DEL THUMBNAIL */       
   		if ($imageX > $thumbX)
		{
		$dest  = imagecreatetruecolor($thumbX, $thumbY); /* CREO LA IMAGEN DE DESTINO COMO TRUECOLOR A FIN DE MANTENER EL MAYOR NUMERO DE COLORES SIN PERDIDA CON LA ALTURA Y LA ANCHURA DADAS */
   		imagecopyresampled ($dest, $source, 0, 0, 0, 0, $thumbX, $thumbY, $imageX, $imageY); 
		}
		else
		{
		$dest  = imagecreatetruecolor($imageX, $imageY); /* CREO LA IMAGEN DE DESTINO COMO TRUECOLOR A FIN DE MANTENER EL MAYOR NUMERO DE COLORES SIN PERDIDA CON LA ALTURA Y LA ANCHURA DADAS */
   		imagecopyresampled ($dest, $source, 0, 0, 0, 0, $imageX, $imageY, $imageX, $imageY); 
		}
		header("Content-type: image/jpeg"); /* INFORMO AL NAVEGADOR QUE LO QUE DEVUELVO ES UNA IMAGEN JPEG */
		
		imagejpeg($dest); /* CREO LA IMAGEN */
		
   		imagedestroy($dest); /* DESTRUYO LA IMAGEN OBTENIDA */
   		imagedestroy($source); /* DESTRUYO LA IMAGEN ORIGINAL */
		break;
		
		case "jpg":	/* SI LA IMAGEN ES JPG */
		
		header("Content-type: image/jpeg"); 
		$nombre_archivo=basename($filename, ".jpg");
		$di=$query->datos_imagen_tipo_imagen($nombre_archivo);   
   		$source = imagecreatefromjpeg($filename);  
   		$thumbX = $thumbnailWidth;    
   		$imageX = imagesx($source);
   		$imageY = imagesy($source);    
   		$thumbY = (int)(($thumbX*$imageY) / $imageX ); 
		if ($imageX > $thumbX)
		{
		$dest  = imagecreatetruecolor($thumbX, $thumbY); /* CREO LA IMAGEN DE DESTINO COMO TRUECOLOR A FIN DE MANTENER EL MAYOR NUMERO DE COLORES SIN PERDIDA CON LA ALTURA Y LA ANCHURA DADAS */
   		imagecopyresampled ($dest, $source, 0, 0, 0, 0, $thumbX, $thumbY, $imageX, $imageY); 
		}
		else
		{
		$dest  = imagecreatetruecolor($imageX, $imageY); /* CREO LA IMAGEN DE DESTINO COMO TRUECOLOR A FIN DE MANTENER EL MAYOR NUMERO DE COLORES SIN PERDIDA CON LA ALTURA Y LA ANCHURA DADAS */
   		imagecopyresampled ($dest, $source, 0, 0, 0, 0, $imageX, $imageY, $imageX, $imageY); 
		}           
   			
		imagejpeg($dest); /* CREO LA IMAGEN */
		
   		imagedestroy($dest);
   		imagedestroy($source);
		break;
		
		case "jpeg": /* SI LA IMAGEN ES JPEG */
		
		header("Content-type: image/jpeg"); 
		$nombre_archivo=basename($filename, ".jpeg");
		$di=$query->datos_imagen_tipo_imagen($nombre_archivo);   
   		$source = imagecreatefromjpeg($filename);  
   		$thumbX = $thumbnailWidth;    
   		$imageX = imagesx($source);
   		$imageY = imagesy($source);    
   		$thumbY = (int)(($thumbX*$imageY) / $imageX ); 
		if ($imageX > $thumbX)
		{
		$dest  = imagecreatetruecolor($thumbX, $thumbY); /* CREO LA IMAGEN DE DESTINO COMO TRUECOLOR A FIN DE MANTENER EL MAYOR NUMERO DE COLORES SIN PERDIDA CON LA ALTURA Y LA ANCHURA DADAS */
   		imagecopyresampled ($dest, $source, 0, 0, 0, 0, $thumbX, $thumbY, $imageX, $imageY); 
		}
		else
		{
		$dest  = imagecreatetruecolor($imageX, $imageY); /* CREO LA IMAGEN DE DESTINO COMO TRUECOLOR A FIN DE MANTENER EL MAYOR NUMERO DE COLORES SIN PERDIDA CON LA ALTURA Y LA ANCHURA DADAS */
   		imagecopyresampled ($dest, $source, 0, 0, 0, 0, $imageX, $imageY, $imageX, $imageY); 
		}       	   
		
		imagejpeg($dest); /* CREO LA IMAGEN */
		
   		imagedestroy($dest);
   		imagedestroy($source);
		break;
		
		case "png":	/* SI LA IMAGEN ES PNG. ESTA EXTENSIÓN SI QUE CONSERVA LAS TRASPARENCIAS  */
		
		header("Content-type: image/png");
		
		$nombre_archivo=basename($filename, ".png");
		$di=$query->datos_imagen_tipo_imagen($nombre_archivo); 
		    
   		$source = imagecreatefrompng($filename);  
   		$thumbX = $thumbnailWidth;    
   		$imageX = imagesx($source);
   		$imageY = imagesy($source);    
   		$thumbY = (int)(($thumbX*$imageY) / $imageX );        
   		if ($imageX > $thumbX)
		{
		$dest  = imagecreatetruecolor($thumbX, $thumbY); /* CREO LA IMAGEN DE DESTINO COMO TRUECOLOR A FIN DE MANTENER EL MAYOR NUMERO DE COLORES SIN PERDIDA CON LA ALTURA Y LA ANCHURA DADAS */
   		imagecopyresampled ($dest, $source, 0, 0, 0, 0, $thumbX, $thumbY, $imageX, $imageY); 
		}
		else
		{
		$dest  = imagecreatetruecolor($imageX, $imageY); /* CREO LA IMAGEN DE DESTINO COMO TRUECOLOR A FIN DE MANTENER EL MAYOR NUMERO DE COLORES SIN PERDIDA CON LA ALTURA Y LA ANCHURA DADAS */
   		imagecopyresampled ($dest, $source, 0, 0, 0, 0, $imageX, $imageY, $imageX, $imageY); 
		} 
		
		imagejpeg($dest); /* CREO LA IMAGEN */
		
		imagedestroy($dest);
   		imagedestroy($source);
		break;		
	}
?>

<?php 
$query=new query();
$d_conf=$query->datos_configuracion_portal();

$dir="../../CACHE/";
$borrar=CleanFiles($dir); //Borro los archivos temporales


/* ******************************************************************************************* */ 
/*                            AÑADIR NUEVO SIMBOLO												   */
/* ******************************************************************************************* */ 
if (isset($_POST['simbolo']) && ($_POST['simbolo']=='subir_simbolo')) {

$query= new query();

$id_palabra=$_POST['id_palabra'];
$tipo_simbolo=$_POST['tipo_simbolo'];
$ext=$query->datos_tipo_simbolo($tipo_simbolo);

/* RECOJO LOS VALORES ENVIADOS DESDE EL FORMULARIO RELACIONADOS CON EL ARCHIVO DE IMAGEN */	
  $userfile = $_FILES['userfile']['tmp_name']; /* NOMBRE QUE SE LE DA AL ARCHIVO EN LA CARPETA TEMPORAL */
  $userfile_name = $_FILES['userfile']['name']; /* NOMBRE REAL DEL ARCHIVO */
  $userfile_size = $_FILES['userfile']['size']; /* TAMAÑO DEL ARCHIVO EN BYTES */
  $userfile_type = $_FILES['userfile']['type']; /* TIPO DE ARCHIVO */
  $userfile_error = $_FILES['userfile']['error']; /* SI HAY ALGUN ERROR EN EL ENVIO */

/* SI SE HA PRODUCIDO ALGUN ERROR EN EL ENVIO DEL ARCHIVO EL VALOR DE LA VARIABLE SERÁ MAYOR DE 1 */	
  if ($userfile_error > 0)
  {
    switch ($userfile_error) /* DIFERENCIO LOS MENSAJES A DEVOLVER AL USUARIO SEGUN EL TIPO DE ERROR ALMACENADO EN LA VARIABLE $USERFILE_ERROR */
    {
      case 1:  $mensaje="El archivo excede el tamaño maximo permitido";  break;
      case 2:  $mensaje="El archivo excede el tamaño maximo permitido";  break;
      case 3:  $mensaje="Archivo parcialmente almacenado";  break;
      case 4:  $mensaje="No se ha seleccionado ningun archivo";  break;
    }
  }

$tipo= explode ("/", $userfile_type);
$ext= explode (".", $userfile_name);

if ($tipo[0] != "image" || $tipo[1] == "bmp" || $tipo[1] == "BMP")
		{
		$mensaje="Formato de imagen no válido";
		}
		elseif ($tipo[1] == "gif" || $tipo[1] == "png" || $tipo[1] == "GIF" || $tipo[1] == "PNG" || $tipo[1] == "x-png" || $tipo[1] == "X-PNG") {  
  
  		$link = "../../CACHE/"; /* ESTABLEZCO CUAL ES LA RUTA DE DESTINO */
		  
		  /* LIMPIO EL NOMBRE DE ESPACIOS EN BLANCO Y CARACTERES LATINOS NO VÁLIDOS  */
		  $userfile_name=basename(tempnam("../../CACHE",'tmp')).".".$ext[1]; 
		  $upfile = $link.$userfile_name;
		 
		 
		  if (is_uploaded_file($userfile)) /* ME ASEGURO QUE EL ARCHIVO HA SIDO SUBIDO CORRECTAMENTE AL SERVIDOR (CARPETA TEMPORAL) */
		  {
			 if (!move_uploaded_file($userfile, $upfile)) /* SI SE HA PRODUCIDO ALGUN ERROR EN LA COPIA DEL ARCHIVO A LA CARPETA UN MENSAJE DE AVISO */
			 {
				$mensaje= "Problema: No se pudo mover el archivo al directorio";
			 }
		  } else  {
			$mensaje= "Fallo en el envío del fichero:".$userfile_name;
		  }
		  
		  $mensaje= "Archivo almacenado correctamente";	
		  $archivo=$userfile_name;	 
		}
		elseif ($tipo[1] == "jpg" || $tipo[1] == "JPG" || $tipo[1] == "pjpeg" || $tipo[1] == "PJPEG") /* SI EL TIPO DE ARCHIVO Y LA EXTENSIÓN SON CORRECTAS COPIO LA IMAGEN AL DIRECTORIO  */
		{
		
			$link = "../../CACHE/"; /* ESTABLEZCO CUAL ES LA RUTA DE DESTINO */
		  
		  /* LIMPIO EL NOMBRE DE ESPACIOS EN BLANCO Y CARACTERES LATINOS NO VÁLIDOS  */
		  $userfile_name=basename(tempnam("../../CACHE",'tmp')).".".$ext[1];
		  $upfile = $link.$userfile_name;
		 
		 
		  if (is_uploaded_file($userfile)) /* ME ASEGURO QUE EL ARCHIVO HA SIDO SUBIDO CORRECTAMENTE AL SERVIDOR (CARPETA TEMPORAL) */
		  {
			 if (!move_uploaded_file($userfile, $upfile)) /* SI SE HA PRODUCIDO ALGUN ERROR EN LA COPIA DEL ARCHIVO A LA CARPETA UN MENSAJE DE AVISO */
			 {
				$mensaje= "Problema: No se pudo mover el archivo al directorio";
			 }
		  } else  {
			$mensaje= "Fallo en el envío del fichero:".$userfile_name;
		  }
		  
		  $mensaje= "Archivo almacenado correctamente";		
		  $archivo=$userfile_name;
		}
		
} else { 
$mensaje="Seleccione un archivo";
}
 
?>
      <form action="<?php $PHP_SELF ?>" method="post" enctype="multipart/form-data" name="subir" id="subir" onSubmit="return validateCompleteForm(this,'error');">
  <h3 align="center"><span class="titulos">Archivo
    <input name="userfile" type="file" class="textos" required="1" realname="Archivo de imagen">
    </span>
    <input type="submit" name="Submit" value="Subir">
    <input name="simbolo" type="hidden" id="simbolo" value="subir_simbolo">
    &nbsp;</h3>
</form>

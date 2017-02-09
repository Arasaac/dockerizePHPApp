<?php 
require('requires_basico.php');
require('funciones/funciones.php');

require ('configuration/key.inc');
require ('classes/crypt/5CR.php');
$encript = new E5CR($llave);

$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],18); 
require('operaciones_cesto.php');

function rm_recursive($filepath)
{
    if (is_dir($filepath) && !is_link($filepath))
    {
        if ($dh = opendir($filepath))
        {
            while (($sf = readdir($dh)) !== false)
            {
                if ($sf == '.' || $sf == '..')
                {
                    continue;
                }
                if (!rm_recursive($filepath.'/'.$sf))
                {
                    //throw new Exception($filepath.'/'.$sf.' could not be deleted.');
                }
            }
            closedir($dh);
        }
        return rmdir($filepath);
    }
    return unlink($filepath);
}

//vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
//   You may change maxsize, and allowable upload file types.
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//Mmaximum file size. You may increase or decrease.
$MAX_SIZE = 2000000;
                            
//Allowable file ext. names. you may add more extension names.            
$FILE_EXTS  = array('zip','jpg','png','gif','mp3');                     

/************************************************************
 *     Setup variables
 ************************************************************/
/*$site_name = $_SERVER['HTTP_HOST'];
$url_dir = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
$url_this =  "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];*/

$upload_dir = "temp/";
$upload_url = "temp/";
$message ="";

/************************************************************
 *     Process User's Request
 ************************************************************/
if (isset($_FILES['userfile']) && $_FILES['userfile']) {

  $file_type = $_FILES['userfile']['type']; 
  $file_name = $_FILES['userfile']['name'];
  $file_ext = strtolower(substr(strrchr($file_name, "."), 1));

  //File Size Check
  if ( $_FILES['userfile']['size'] > $MAX_SIZE) { 
     $message = $translate['error_upload_1'];
  //File Extension Check
  } else if (!in_array($file_ext, $FILE_EXTS)) { 
     $message = $translate['lo_sentimos']." $file_name($file_type) ".$translate['no_formato_archivo_permitido'];
  } else {
  
  	 if ($file_ext=="zip") {
	    
	 	$temp_name = $_FILES['userfile']['tmp_name'];
		$file_name = $_FILES['userfile']['name']; 
		$file_name = str_replace("\\","",$file_name);
		$file_name = str_replace("'","",$file_name);
		  
	 	$upload_temp = "temp/";
		$name_folder=basename(tempnam("temp",'tmp')).rand(100,100000000000000000000000000000);
		$dir="temp/".$name_folder;
		$file_path = $upload_temp.$file_name;
		$result  =  move_uploaded_file($temp_name,$file_path);
		mkdir($dir,0775);

		$archive = new PclZip($file_path);
		if ($archive->extract(PCLZIP_OPT_PATH, $dir) == 0) {
			$message="Error : ".$archive->errorInfo(true);
		} else { unlink($file_path); }
		
		//Recorro el directorio para añadir las imagenes que contenga a la BBDD
		$llistat=recursive_dirlist($dir);
		$num_files= count($llistat['files']);
		
		for ($i=0; $i<$num_files; $i++)
		{
		 $extension = strtolower(substr(strrchr($llistat['files'][$i], "."), 1)); 
		 
			  if ($extension=='jpg' || $extension=='JPG' || $extension=='JPEG' || $extension=='jpeg' || $extension=='gif' || $extension=='png' || $extension=='mp3' || $extension=='MP3') {
			    $name_file=basename(tempnam("temp",'tmp'));
			    copy($llistat['files'][$i],$upload_dir.$name_file.'.'.$extension);

				$ruta_cesto='ruta_cesto=temp/'.$name_file.'.'.$extension;
				$encript->encriptar($ruta_cesto,1);
				$_SESSION['carpeta_personal'][$ruta_cesto] = 1;
				
				$message = "$file_name ".$translate['extraido_correctamente'];
			 }
		
		}

		//Borro la carpeta la carpeta temporal utilizada y todo su contenido
		//************************************************************************
		
			$folder_delete=rm_recursive($dir);
  
  		//************************************************************************
		
	 } else {
    	 //$message = $query->do_upload($upload_dir, $upload_url,$query,$id_dir,$ruta,$id_usuario);
		  $temp_name = $_FILES['userfile']['tmp_name'];
		  $file_name = $_FILES['userfile']['name']; 
		  $file_name = str_replace("\\","",$file_name);
		  $file_name = str_replace("'","",$file_name);
		  $name_file=basename(tempnam("temp",'tmp'));
		  
		  $file_path = $upload_dir.$name_file.'.'.$file_ext;
		
			//File Name Check
		  if ( $file_name =="") { 
			$message = $translate['error_upload_2'];
			return $message;
		  }
		
		  $result  =  move_uploaded_file($temp_name, $file_path);
		  
		  $ruta_cesto='ruta_cesto=temp/'.$name_file.'.'.$file_ext;
		  $encript->encriptar($ruta_cesto,1);
		  $_SESSION['carpeta_personal'][$ruta_cesto] = 1;
				
		  if (!file_exists($file_path))
			$message = $translate['error_upload_3'];
		  else
			$message = "$file_name ".$translate['mensaje_upload_1'];
			 }
  }
 
}
else if (!isset($_FILES['userfile'])) { } else  { $message = "Invalid File Specified."; }
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['mi_carpeta_trabajo']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
	<link media="screen" rel="stylesheet" href="js/colorbox/example1/colorbox.css" />
	<script src="js/jQuery/jquery-latest.pack.js"></script>
	<script src="js/colorbox/colorbox/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				$(".iframe").colorbox({width:"95%", height:"99%", iframe:true});
				//Example of preserving a JavaScript event for inline calls.
			});
		</script>
    <?php require ('text_size_css.php'); ?>
</head>

<body>
            
<div class="body_content"> 

	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
      <?php include ('menu_principal.php'); ?>
      <?php include ('menu_subprincipal_herramientas.php'); ?>
      <br /><h4 style="text-transform:uppercase;"><?php echo $translate['mi_carpeta_trabajo']; ?>:&nbsp;</h4>	
  <div id="principal">
		<div id="clearcarpeta_trabajo"><a href="<?php echo $PHP_SELF; ?>?clearWorkFolder=true"><img src="images/trash_2.png" alt="<?php echo $translate['vaciar_mi_carpeta_trabajo']; ?>" border="0" title="<?php echo $translate['vaciar_mi_carpeta_trabajo']; ?>"/></a> <?php echo $translate['explicacion_mi_carpeta_trabajo']; ?></div>
        <div id="loading"><img src="images/indicator.gif" alt="<?php echo $translate['cargando']; ?>..." /></div>
        
<div id="carpeta_trabajo"> 
          <ul id="thelist1">
                    <?php 
                    if (isset($_SESSION['carpeta_personal']) && $_SESSION['carpeta_personal'] !="") {
                        foreach ($_SESSION['carpeta_personal'] as $key => $value) {
                        
                        $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                        $ruta=$key['ruta_cesto'];
                        $ruta_img='size=50&ruta=../../'.$ruta;
                        $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
                        $ruta_cesto='ruta_cesto='.$ruta;
                        $encript->encriptar($ruta_cesto,1); 	
                        
						$extension = strtolower(substr(strrchr($ruta, "."), 1));
													
							if ($extension=='jpg' || $extension=='png' || $extension=='gif' || $extension=='jpeg' || $extension=='JPG' || $extension=='GIF' ||$extension=='PNG' || $extension=='mp3' || $extension=='MP3') {
								
								if ($extension=='mp3') {
								echo '<li><object type="application/x-shockwave-flash" 
								data="swf/round1.swf?src='.$ruta.'" 
								height="50" width="50">
								<param name="movie"
								value="ruta_del_enlace/angular1.swf?src=ruta_del_enlace/blues.mp3" />
								<param name="quality" value="high" />
								<param name="bgcolor" value="#ffffff" />
								</object><br><a href="'.$PHP_SELF.'?clearFile=true&id='.$ruta_cesto.'"><img src="images/delete.gif" border="0" alt="'.$translate['eliminar_de_mi_seleccion'].'" title="'.$translate['eliminar_de_mi_seleccion'].'"/></a></li>';			
							   } else {
								echo "<li><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/><br><a href=\"".$_SERVER['PHP_SELF']."?clearFile=true&id=".$ruta_cesto."\"><img src=\"images/delete.gif\" border=\"0\" alt=\"".$translate['eliminar_de_mi_carpeta_trabajo']."\" title=\"".$translate['eliminar_de_mi_carpeta_trabajo']."\"/></a></li>";
							   }
							   
							}
                        }
                    }
                    ?>
          </ul>
    </div>
</div>

<div id="subir_archivo">
<div id="caja_pictos_aleatorios_titulo"><?php echo $translate['subir_archivos_mi_carpeta_trabajo']; ?></div><br />
<form action="carpeta_trabajo.php" method="post" name="gestionar_repositorio" id="gestionar_repositorio" ENCTYPE="multipart/form-data">
<p><?php if (isset($message) && $message !='') echo '<div style="color: #F00; border:1px solid #C00;">'.$message.'</div>'; ?></p><input type="file" id="userfile" name="userfile"><input type="submit" name="upload" value="<?php echo $translate['subir_archivo']; ?>" class="boton_mediano"><br /><br />
       <p><?php echo $translate['explicacion_subir_archivos_cesto']; ?></p><br />
</form>
</div>

<?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


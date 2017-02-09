<?php 
session_start();
require ('../classes/languages/language_detect.php');
require ('../classes/crypt/5CR.php'); 
require_once('../configuration/key.inc');
$encript = new E5CR($llave);

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

include ('../classes/querys/query.php');
require('../funciones/funciones.php');
include('../classes/zip/pclzip.lib.php');

$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],18);

//vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
//   You may change maxsize, and allowable upload file types.
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//Mmaximum file size. You may increase or decrease.
$MAX_SIZE = 2000000;
                            
//Allowable file ext. names. you may add more extension names.            
$FILE_EXTS  = array('.zip','.jpg','.png','.gif','.mp3');                     

/************************************************************
 *     Setup variables
 ************************************************************/
/*$site_name = $_SERVER['HTTP_HOST'];
$url_dir = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
$url_this =  "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];*/

$upload_dir = "../temp/";
$upload_url = "../temp/";
$message ="";

/************************************************************
 *     Process User's Request
 ************************************************************/
if ($_FILES['userfile']) {

  $file_type = $_FILES['userfile']['type']; 
  $file_name = $_FILES['userfile']['name'];
  $file_ext = strtolower(substr($file_name,strrpos($file_name,".")));

  //File Size Check
  if ( $_FILES['userfile']['size'] > $MAX_SIZE) { 
     $message = $translate['error_upload_1'];
  //File Extension Check
  } else if (!in_array($file_ext, $FILE_EXTS)) { 
     $message = $translate['lo_sentimos']." $file_name($file_type) ".$translate['no_formato_archivo_permitido'];
  } else {
  
  	 if ($file_ext==".zip") {
	    
	 	$temp_name = $_FILES['userfile']['tmp_name'];
		$file_name = $_FILES['userfile']['name']; 
		$file_name = str_replace("\\","",$file_name);
		$file_name = str_replace("'","",$file_name);
		  
	 	$upload_temp = "../temp/";
		$name_folder=basename(tempnam("../temp",'tmp')).rand(100,100000000000000000000000000000);
		$dir="../temp/".$name_folder;
		$file_path = $upload_temp.$file_name;
		$result  =  move_uploaded_file($temp_name,$file_path);
		mkdir($dir,0777);

		$archive = new PclZip($file_path);
		if ($archive->extract(PCLZIP_OPT_PATH, $dir) == 0) {
			$message="Error : ".$archive->errorInfo(true);
		} else { unlink($file_path); }
		
		//Recorro el directorio para añadir las imagenes que contenga a la BBDD
		$llistat=recursive_dirlist($dir);
		$num_files= count($llistat[files]);
		
		for ($i=0; $i<$num_files; $i++)
		{
		 $extension = strtolower(substr(strrchr($llistat[files][$i], "."), 1)); 
		 
			 if ($extension=='jpg' || $extension=='JPG' || $extension=='JPEG' || $extension=='jpeg' || $extension=='gif' || $extension=='png' || $extension=='mp3' || $extension=='MP3') {
			    $name_file=basename(tempnam("../temp",'tmp'));
			    copy($llistat[files][$i],$upload_dir.$name_file.'.'.$extension);

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
		  $name_file=basename(tempnam("../temp",'tmp'));
		  
		  $file_path = $upload_dir.$name_file.$file_ext;
		
			//File Name Check
		  if ( $file_name =="") { 
			$message = $translate['error_upload_2'];
			return $message;
		  }
		
		  $result  =  move_uploaded_file($temp_name, $file_path);
		  
		  $ruta_cesto='ruta_cesto=temp/'.$name_file.$file_ext;
		  $encript->encriptar($ruta_cesto,1);
		  $_SESSION['carpeta_personal'][$ruta_cesto] = 1;
				
		  if (!chmod($file_path,0777))
			$message = $translate['error_upload_3'];
		  else
			$message = "$file_name ".$translate['mensaje_upload_1'];
			 }
  }
  
  /*print "<script>window.location.href='$url_this?message=$message'</script>";*/
}
else if (!$_FILES['userfile']) { } else  { $message = "Invalid File Specified."; }

header("Location: upload_cesto.php?mensaje=".$message."");

?>
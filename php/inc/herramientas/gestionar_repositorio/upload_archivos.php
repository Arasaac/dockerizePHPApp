<?php 
session_start();

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

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
include('../../../classes/zip/pclzip.lib.php');

$query=new query();

$dir=$query->datos_directorio($_POST['id_directorio'],$_SESSION['ID_USER']);
$ruta=$dir['ruta_dir'];
$id_dir=$_POST['id_directorio'];
$id_usuario=$_POST['id_usuario'];

//vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
//   You may change maxsize, and allowable upload file types.
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//Mmaximum file size. You may increase or decrease.
$MAX_SIZE = 2000000;
                            
//Allowable file ext. names. you may add more extension names.            
$FILE_EXTS  = array('.zip','.jpg','.png','.gif');                     

/************************************************************
 *     Setup variables
 ************************************************************/
/*$site_name = $_SERVER['HTTP_HOST'];
$url_dir = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
$url_this =  "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];*/

$upload_dir = "../../../usuarios/".$ruta.'/';
$upload_url = "../../../usuarios/".$ruta.'/';
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
     $message = "El archivo sobrepasa los 2MB permitidos.";
  //File Extension Check
  } else if (!in_array($file_ext, $FILE_EXTS)) { 
     $message = "Lo sentimos, $file_name($file_type) no es un formato de archivo permitido.";
  } else {
  
  	 if ($file_ext==".zip") {
	 
	 	$temp_name = $_FILES['userfile']['tmp_name'];
		$file_name = $_FILES['userfile']['name']; 
		$file_name = str_replace("\\","",$file_name);
		$file_name = str_replace("'","",$file_name);
		  
	 	$upload_temp = "../../../temp/";
		$name_folder=basename(tempnam("temp",'tmp'));
		$dir="../../../temp/".$name_folder;
		$file_path = $upload_temp.$file_name;
		$result  =  move_uploaded_file($temp_name,$file_path);
		mkdir($dir,0777);

		$archive = new PclZip($file_path);
		if ($archive->extract(PCLZIP_OPT_PATH, $dir) == 0) {
			//$message="Error : ".$archive->errorInfo(true);
		} else { unlink($file_path); }
		
		//Recorro el directorio para añadir las imagenes que contenga a la BBDD
		$llistat=recursive_dirlist($dir);
		$num_files= count($llistat[files]);
		
		for ($i=0; $i<$num_files; $i++)
		{
		 $extension = strtolower(substr(strrchr($llistat[files][$i], "."), 1)); 
		 
			 if ($extension=='jpg' || $extension=='JPG' ||$extension=='JPEG' ||$extension=='jpeg' ||$extension=='gif' ||$extension=='png') {
			 
			    $add=$query->add_zip_repositorio($id_dir,$_SESSION['ID_USER'],$llistat[files][$i]);
			 }
		
		}

		//Borro la carpeta la carpeta temporal utilizada y todo su contenido
		//************************************************************************
		
			$folder_delete=rm_recursive($dir);
  
  		//************************************************************************
		
	 } else {
    	 $message = $query->do_upload($upload_dir, $upload_url,$query,$id_dir,$ruta,$id_usuario);
	 }
  }
  
  /*print "<script>window.location.href='$url_this?message=$message'</script>";*/
}
else if (!$_FILES['userfile']) { } else  { $message = "Invalid File Specified."; }

header("Location: ../gestionar_repositorio.php?idd=".$_POST['id_directorio']."&mensaje=".$message."");

?>
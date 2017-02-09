<?php 
session_start();  // INICIO LA SESION
require ('../classes/languages/language_detect.php');
include ('../classes/querys/query.php');
$query= new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],18); 
?>
<div id="subir_archivo" style="font-size: 10px; margin-bottom:10px; margin-top:5px; padding-left:5px; border:1px solid #CCCCCC; width: 100%; text-align:left;">
<form action="upload_archivos_cesto.php" method="post" name="gestionar_repositorio" id="gestionar_repositorio" ENCTYPE="multipart/form-data">
  <p align="center" style="color:#FF0000; font-size:14px;"><?php echo $_GET['mensaje']; ?></p>
       <div align="center">
          <input type="file" id="userfile" name="userfile">
          <br />
       <p style="font-family:Georgia,Times, serif; font-size:14px;"><?php echo $translate['explicacion_subir_archivos_cesto']; ?></p>
       <br />
       </div>
       <p align="center"><input type="submit" name="upload" value="<?php echo $translate['subir_archivo']; ?>" style="font-size:24px;">
       </p>
</form>


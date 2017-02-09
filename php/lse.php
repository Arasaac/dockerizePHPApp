<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],8); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <META NAME="keywords" CONTENT="saac,aac,Augmentative and alternative communication,educacion especial,catedu,aragón,educación,sistemas aumentativos y alternativos de comunicación,pictograph,pictogramas,pictograms,special education">
    <META NAME="Description" CONTENT="Portal ARASAAC.El portal Aragonés de la Comunicación Aumentativa y Alternativa reune pictogramas, imágenes, materiales y software que facilitan la comunicación de aquellos alumnos con algún tipo de necesidad educativa de comunicación.">
    <META NAME="Author" CONTENT="CATEDU">
    <META NAME="Revisit" CONTENT="8 days">
    <META NAME="Robots" CONTENT="all">
    <META NAME="Language" CONTENT="Spanish">
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <title>ARASAAC: <?php echo $translate['lse']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
    <?php require ('text_size_css.php'); ?>
 <?php 
//Averiguar resolucion en pantalla
//********************************************
$siteurl = $_SERVER['REQUEST_URI'];
$GLOBALS['siteurl'] = $siteurl;
require('funciones/getres.php');
?>
</head>

<body>
            
<div class="body_content"> 

	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
        <?php include ('menu_principal.php'); ?>
        <?php include ('menu_subprincipal_lse.php'); ?>
       
		<?php echo '<h4>'.$translate['lse_catedu_arasaac'].'</h4>'; ?>
		<div id="principal">
        	<div id="marco"><?php echo $translate['biblioteca_signos']; ?></div>
			<?php echo $translate['lse_presentacion']; ?>
  		</div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


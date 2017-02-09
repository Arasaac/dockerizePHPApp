<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],8); 
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['lse']; ?>-><?php echo $translate['consejos_comunicacion']; ?></title>
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
       
		<?php echo '<h4>'.$translate['lse'].'->'.$translate['consejos_comunicacion'].'</h4>'; ?>
		<div id="principal">
          <div id="marco"><?php echo $translate['biblioteca_signos']; ?></div>
		  <?php echo $translate['lse_consejos_comunicacion']; ?>	     
  		</div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


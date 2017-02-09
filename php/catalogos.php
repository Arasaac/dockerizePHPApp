<?php 
require('requires_basico.php');
require ('funciones/funciones.php');
require ('configuration/key.inc');
require ('classes/crypt/5CR.php');
$encript = new E5CR($llave);

require('operaciones_cesto.php');

$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],8); 
require('buscar_por_palabra.php');
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['catalogos']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
    <link rel="stylesheet" href="js/autoComplete/autoComplete_css.css" type="text/css" media="screen" charset="utf-8" />
	<script type="text/javascript" src="js/ajax2.js"></script>
    <script type="text/javascript" src="js/prototype/prototype.js"> </script> 
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
        <?php include ('menu_subprincipal_catalogos.php'); ?>
        <?php echo '<h4>'.$translate['catalogos'].'</h4>'; ?>
        <?php include ('buscador.php'); ?>
        <?php include ('cesto.php'); ?>  
		<div id="principal">
			<?php include ('catalogos_menu.php'); ?>
        </div><br />
	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


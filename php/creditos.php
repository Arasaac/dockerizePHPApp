<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1);
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['creditos']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
    <?php require ('text_size_css.php'); ?>
</head>

<body>
            
<div class="body_content"> 

	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
        <?php include ('menu_principal.php'); ?>	
      <?php echo '<br /><h4>'.$translate['creditos'].'</h4>'; ?>	
		<div id="principal">
        	<b><?php echo $translate['catalogo_pictogramas_catedu_color']; ?>/<?php echo $translate['catalogo_pictogramas_catedu_byn']; ?></b><br /><br />
        	<?php echo $translate['explicacion_catalogo_pictogramas_color']; ?>
            <br /><br />
            <b><?php echo $translate['catalogo_de_imagenes']; ?></b><br /><br />
            <?php echo $translate['explicacion_catalogo_imagenes']; ?> 
            <br /><br />
            <b><?php echo $translate['catalogo_videos_lse']; ?>/<?php echo $translate['catalogo_signos_color']; ?></b><br /><br />
            <?php echo $translate['descripcion_catalogos_videos_asza']; ?>
            <br /><br />
            <b><?php echo $translate['traduccion_portal_frances']; ?></b><br /><br />
            <?php echo $translate['descripcion_traduccion_portal_frances']; ?>
            <br /><br />
            <b><?php echo $translate['traduccion_portal_portugues_brasil']; ?></b><br /><br />
            <?php echo $translate['descripcion_traduccion_brasil']; ?>
            <br /><br />
            <b><?php echo $translate['traduccion_portal_portugues']; ?></b><br /><br />
            <?php echo $translate['descripcion_traduccion_portugues']; ?>
            <br /><br />
            <b><?php echo $translate['traduccion_euskera']; ?></b><br /><br />
            <?php echo $translate['descripcion_traduccion_euskera']; ?>
            <br /><br />
            <b><?php echo $translate['traduccion_gallego']; ?></b><br /><br />
            <?php echo $translate['descripcion_traduccion_gallego']; ?>
            <br />
            <b><?php echo $translate['traduccion_rumano']; ?></b><br /><br />
            <?php echo $translate['descripcion_traduccion_rumano']; ?>
            <br /><br />
        </div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


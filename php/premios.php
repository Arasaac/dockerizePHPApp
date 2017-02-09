<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],6); 
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['premios_reconocimientos']; ?></title>
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
      <?php echo '<br /><h4>'.$translate['premios_reconocimientos'].'</h4>'; ?>	
	<div id="principal">
	 <?php echo $translate['mencion_coordinadores_arasaac2']; ?>
	 <?php echo $translate['premio_ceapat_25_aniversario']; ?>
        <?php echo $translate['candidato_principe_asturias']; ?>
        <?php echo $translate['aragoneses_2013']; ?>
        <?php echo $translate['premio_fed_autismo_madrid_2013']; ?>
        <?php echo $translate['premio_cine_salud_2013']; ?>
        <?php echo $translate['premio_design_for_all_2013']; ?>
        <?php echo $translate['vii_premio_periodismo_integracion']; ?>
        <?php echo $translate['descipcion_premios_reconocimientos']; ?>
        </div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],6); 
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['condiciones_uso']; ?></title>
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
      <?php echo '<br /><h4>'.$translate['condiciones_uso'].'</h4>'; ?>	
		<div id="principal">
        <?php echo $translate['descipcion_condiciones_uso']; ?>
        </div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


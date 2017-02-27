<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1); 
require('cabecera_html.php');
?>
    <title>ARASAAC - <?php echo $translate['ayuda_preguntas_frecuentes']; ?></title>
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
      <?php echo '<br /><h4>'.$translate['ayuda_preguntas_frecuentes'].'</h4>'; ?>	
		<div id="principal">
        <ul>
          <li><a name="A-1" id="A-1"></a><strong>[A-1] <?php echo $translate['buscar_en_catalogos']; ?></strong><br /><br /><p><?php echo $translate['explicacion_buscar_por']; ?></p><br />
          <span class="verde_oscuro_little">(<?php echo $translate['para_regresar']; ?>)</span>
          </li>
        </ul>
 <br /><br /><br /><br />       
</div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1); 
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['comunicacion_aumentativa_alternativa']; ?></title>
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
        <?php include ('menu_subprincipal_caa.php'); ?>
       
		<?php echo '<h4>'.$translate['comunicacion_aumentativa_alternativa'].'</h4><br />'.$translate['explicacion_seccion_caa'].'<br /><br />'; ?>
		<div id="principal">
          <div style="width:100%">
       	    <ul id="thelist4">
              <li id="thelist4"><a href="software.php"><img src="images/software.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['software_minusculas']; ?>" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['software_minusculas']; ?>" /></a><br /><a href="software.php"><?php echo $translate['software_minusculas']; ?></a></li>
       	      <li id="thelist4"><a href="listado_enlaces.php"><img src="images/webs.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['otras_webs']; ?>" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['otras_webs']; ?>" /></a><br /><a href="listado_enlaces.php"><?php echo $translate['otras_webs']; ?></a></li>
                <li id="thelist4"><a href="bibliografia.php"><img src="images/bibliografia.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['bibliografia']; ?>" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['bibliografia']; ?>" /></a><br /><a href="bibliografia.php"><?php echo $translate['bibliografia']; ?></a></li>
                <li id="thelist4"><a href="ejemplos_uso.php"><img src="images/ejemplos_uso.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['bibliografia']; ?>" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['ejemplos_de_uso']; ?>" /></a><br /><a href="ejemplos_uso.php"><?php echo $translate['ejemplos_de_uso']; ?></a></li>
                
                <li id="thelist4"><a href="lse.php"><img src="images/lse_128x128.jpg" alt="<?php echo $translate['lse']; ?>" width="128" height="128" title="<?php echo $translate['lse']; ?>" /></a><br /><a href="lse.php"><?php echo $translate['lse']; ?></a></li>
                
            </ul>
          </div>
            <p><br />
              <br />
            </p>

        </div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


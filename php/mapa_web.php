<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],6); 
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['mapa_web']; ?></title>
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
     <br /> <h4><?php echo $translate['mapa_web']; ?></h4>
		<div id="principal">
        	<div id="marco">
            	<ul>
                   <li><b><a href="index2.php"><?php echo $translate['inicio']; ?></a></b></li><br />
                     <li><b><a href="catalogos.php"><?php echo $translate['catalogos']; ?></a></b>
                       <ul>
                         <li><a href="ultimos_pictogramas_color.php"><?php echo $translate['pictogramas_color']; ?></a></li>
                         <li><a href="ultimos_pictogramas_byn.php"><?php echo $translate['pictogramas_byn']; ?></a></li>
                         <li><a href="ultimas_imagenes.php"><?php echo $translate['imagenes']; ?></a></li>
                         <li><a href="videos_lse.php"><?php echo $translate['videos_lse']; ?></a></li>
                         <li><a href="signos_lse_color.php"><?php echo $translate['lse_color']; ?></a></li>
                       </ul>
                     </li>
                     <br />
                     <li><b><a href="materiales.php"><?php echo $translate['materiales']; ?></a></b></li>
                     <br />
                     <li><b><a href="herramientas.php"><?php echo $translate['herramientas']; ?></a></b></li>
                     <br />
                     <li><b><a href="descargas.php"><?php echo $translate['descargas']; ?></a></b><br />
                     <br />
                     <li><b><a href="software.php"><?php echo $translate['SOFTWARE']; ?></a></b></li>
                     <br />
                     <li><b><a href="ejemplos_uso.php"><?php echo $translate['ejemplos_de_uso']; ?></a></b></li></ul>
                    <ul>
                     <li><b><a href="caa.php"><?php echo $translate['caa']; ?></a></b>
                       <ul>
                         <li><a href="listado_enlaces.php"><?php echo $translate['otras_webs']; ?></a></li>
                         <li><a href="bibliografia.php"><?php echo $translate['bibliografia']; ?></a></li>
                         <li><a href="lse.php"><?php echo $translate['lse']; ?></a></li>
                         
                       </ul>
                     </li>
                     <br />
                     <li><b><a href="premios.php"><?php echo $translate['premios']; ?></a></b></li>
                     <br />
                     <li><b><a href="condiciones_uso.php"><?php echo $translate['condiciones_uso']; ?></a></b></li>
                     <br />
                     <li><b><a href="cesta.php"><?php echo $translate['mi_seleccion']; ?></a></b></li>
                     <br />
                     <li><b><a href="contacta.php"><?php echo $translate['contacta']; ?></a></b></li>
                     <br />
                     <li><b><a href="ayuda.php"><?php echo $translate['ayuda']; ?></a></b></li>
                     <br />
                     <li><b><a href="subscripciones.php"><?php echo $translate['subscripciones']; ?></a></b></li>
                     <br />
                     <li><b><a href="creditos.php"><?php echo $translate['creditos']; ?></a></b></li>
              </ul>
          </div>

  </div>
<?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


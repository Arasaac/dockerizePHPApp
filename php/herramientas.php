<?php 
require('requires_basico.php');

$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],17); 
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['herramientas']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
	<link media="screen" rel="stylesheet" href="js/colorbox/example1/colorbox.css" />
	<script src="js/jQuery/jquery-latest.pack.js"></script>
	<script src="js/colorbox/colorbox/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				$(".iframe").colorbox({width:"95%", height:"99%", iframe:true});
				//Example of preserving a JavaScript event for inline calls.
			});
		</script>
     <?php require ('text_size_css.php'); ?>
</head>

<body>
            
<div class="body_content"> 

	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
      <?php include ('menu_principal.php'); ?>
      <?php include ('menu_subprincipal_herramientas.php'); ?>
      <br /><h4 > <?php echo $translate['herramientas']; ?></h4>	
		<div id="principal">
        	<?php echo $translate['bienvenida_zona_herramientas_breve']; ?><br /><br />
      		<ul id="thelist9"><?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) { 
			  			
						echo '<li id="thelist9"><a href="inc/herramientas/seleccion.php" onclick="return GB_showFullScreen(\'Mis selecciones\', this.href)"><strong><img src="images/elegir.png" alt="Mis Selecciones" width="75" height="75"  /></strong></a><br /><a href="inc/herramientas/seleccion.php" onclick="return GB_showFullScreen(\'Mis selecciones\', this.href)"><strong>MIS SELECCIONES</strong></a></li>';                   
              } ?>
                <li id="thelist9" ><strong><a href="cesta.php"><img src="images/box_1.png" alt="<?php echo $translate['ver_mi_seleccion']; ?>" title="<?php echo $translate['ver_mi_seleccion']; ?>"  /></a></strong><br />
                    <strong><a href="cesta.php"><?php echo $translate['mi_seleccion']; ?></a></strong></li>
                <li id="thelist9" ><strong><a href="carpeta_trabajo.php"><img src="images/carpeta_trabajo.png" alt="<?php echo $translate['gestionar_carpeta_trabajo']; ?>" title="<?php echo $translate['gestionar_carpeta_trabajo']; ?>"/></a></strong><br />
               <strong><a href="carpeta_trabajo.php"><?php echo $translate['carpeta_trabajo']; ?></a></strong></li>
		        <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {
			  
			  	echo '<li id="thelist9"><strong><a href="inc/herramientas/gestionar_repositorio.php" onclick="return GB_showFullScreen(\'Gestionar repositorio\', this.href)"><img src="images/archivar.png" alt="Gestionar Repositorio" width="75" height="75"  /></</strong><br /><strong><a href="inc/herramientas/gestionar_repositorio.php" onclick="return GB_showFullScreen(\'Gestionar repositorio\', this.href)">GESTONAR REPOSITORIO</a></strong></li>'; 
				} ?>
                <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {
             		 echo '<li id="thelist9" ><strong><a href="inc/herramientas/generador_paneles/generador_paneles.php" onclick="return GB_showFullScreen(\''.$translate['creador_paneles'].'\', this.href)"><img src="images/comunicador.png" alt="'.$translate['creador_paneles'].'" title="'.$translate['creador_paneles'].'" width="75" height="75"  /></a></strong><br /><strong><a href="inc/herramientas/generador_paneles/generador_paneles.php" onclick="return GB_showFullScreen(\''.$translate['creador_paneles'].'\', this.href)">'.$translate['creador_paneles'].'</a></strong></li>';
			  } ?>
                <li id="thelist9" ><strong><a class="iframe" href="inc/herramientas/creador_animaciones.php"><img src="images/verbos.png" alt="<?php echo $translate['creador_animaciones']; ?>" title="<?php echo $translate['creador_animaciones']; ?>"  /></a></strong><br />
                    <strong><a class="iframe" href="inc/herramientas/creador_animaciones.php"><?php echo $translate['creador_animaciones']; ?></a></strong></li>
		        <li id="thelist9" ><strong><a class="iframe" href="inc/herramientas/creador_simbolos/creador_simbolos.php"><img src="images/dibujar.png" alt="<?php echo $translate['creador_de_simbolos']; ?>" title="<?php echo $translate['creador_de_simbolos']; ?>"  /></a></strong> <br />
	              <a class="iframe" href="inc/herramientas/creador_simbolos/creador_simbolos.php"><strong><?php echo $translate['creador_simbolos']; ?></strong></a></li>
		        <?php 
             		// echo '<li id="thelist9"><strong><a class="iframe" href="inc/herramientas/creador_ejercicios/creador_ejercicios.php"><img src="images/actividades.png" alt="Creador de Ejercicios" width="75" height="75"  /></a></strong><br /><strong><a class="iframe" href="inc/herramientas/creador_ejercicios/creador_ejercicios.php">CREADOR DE EJERCICIOS</a></strong></li>';
			   ?>
                <li id="thelist9" ><strong><a class="iframe" href="inc/herramientas/creador_frases/creador_frases.php"><img src="images/frases.png" alt="<?php echo $translate['creador_frases']; ?>" title="<?php echo $translate['creador_frases']; ?>"  /></a></strong><br /><a class="iframe" href="inc/herramientas/creador_frases/creador_frases.php"><strong><?php echo $translate['creador_frases']; ?></strong></a>      </li>
                <li id="thelist9" ><strong><a class="iframe" href="inc/herramientas/generador_horarios/generador_horarios.php"><img src="images/horario.png" alt="<?php echo $translate['generador_horarios']; ?>" title="<?php echo $translate['generador_horarios']; ?>"  /></a></strong><br /><a class="iframe" href="inc/herramientas/generador_horarios/generador_horarios.php"><strong><?php echo $translate['generador_horarios']; ?></strong></a></li>
                <li id="thelist9" ><strong><a class="iframe" href="inc/herramientas/generador_calendarios/generador_calendarios.php"><img src="images/calendario.png" alt="<?php echo $translate['generador_calendarios']; ?>" title="<?php echo $translate['generador_calendarios']; ?>"  /></a></strong><br /><a class="iframe" href="inc/herramientas/generador_calendarios/generador_calendarios.php"><strong><?php echo $translate['generador_calendarios']; ?></strong></a></li>
              
               <li id="thelist9" ><strong><a class="iframe" href="inc/herramientas/generador_tableros/generador_tableros.php"><img src="images/tablero.png" alt="<?php echo $translate['generador_tableros']; ?>" title="<?php echo $translate['generador_tableros']; ?>"  /></a></strong><br /><a class="iframe" href="inc/herramientas/generador_tableros/generador_tableros.php"><strong><?php echo $translate['generador_tableros']; ?></strong></a></li>
               
              <li id="thelist9"><strong><a class="iframe" href="inc/herramientas/creador_bingos/creador_bingos.php"><img src="images/bingo.jpg" alt="<?php echo $translate['creador_bingos']; ?>" title="<?php echo $translate['creador_bingos']; ?>" width="75" height="75"  /></a></strong><br /><strong><a class="iframe" href="inc/herramientas/creador_bingos/creador_bingos.php"><?php echo $translate['creador_bingos']; ?></a></strong></li>
              
             <li id="thelist9"><strong><a class="iframe" href="inc/herramientas/creador_ocas/creador_ocas.php"><img src="images/oca.png" alt="<?php echo $translate['juego_oca']; ?>" title="<?php echo $translate['juego_oca']; ?>" width="75" height="75"  /></a></strong><br /><strong><a class="iframe" href="inc/herramientas/creador_ocas/creador_ocas.php"><?php echo $translate['juego_oca']; ?></a></strong></li>
             
           <li id="thelist9"><strong><a class="iframe" href="inc/herramientas/generador_dominos/generador_dominos.php"><img src="images/domino/domino.png" alt="<?php echo $translate['generador_dominos']; ?>" title="<?php echo $translate['generador_dominos']; ?>" width="75" height="75"  /></a></strong><br /><strong><a class="iframe" href="inc/herramientas/generador_dominos/generador_dominos.php"><?php echo $translate['dominos']; ?></a></strong></li>
           
           <li id="thelist9"><strong><a class="iframe" href="inc/herramientas/generador_encadenados/generador_dominos_encadenados.php"><img src="images/domino/encadenado_500x500.png" alt="<?php echo $translate['generador_dominos_encadenados']; ?>" title="<?php echo $translate['generador_dominos_encadenados']; ?>" width="75" height="75"  /></a></strong><br /><strong><a class="iframe" href="inc/herramientas/generador_encadenados/generador_dominos_encadenados.php"><?php echo $translate['dominos_encadenados']; ?></a></strong></li>
                               
	          </ul>
           </div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


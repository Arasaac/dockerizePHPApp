<?php 
session_start();  // INICIO LA SESION
require ('../../classes/languages/language_detect.php');
include ('../../classes/querys/query.php');
$query= new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],17); 
?>
<h4 style="text-transform:uppercase;"> <?php echo $translate['herramientas']; ?></h4>
<div id="principal">
              <?php echo $translate['bienvenida_zona_herramientas']; ?>
		      <ul id="thelist4" style="border: 1px dashed #CCCCCC; width:96%; height:300px; padding:20px; margin-bottom:10px;"><?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) { 
			  			
						echo '<li id="thelist4"><a href="inc/herramientas/seleccion.php" onclick="return GB_showFullScreen(\'Mis selecciones\', this.href)"><strong><img src="images/elegir.png" alt="Mis Selecciones" width="75" height="75" border="0" /></strong></a><br /><a href="inc/herramientas/seleccion.php" onclick="return GB_showFullScreen(\'Mis selecciones\', this.href)"><strong>MIS SELECCIONES</strong></a></li>';                   
              } ?>
                <li id="thelist4" style="text-transform:uppercase;"><strong><a href="javascript:void(0);" onclick="cargar_div('inc/cesta.php','i=','principal');"><img src="images/cesta.png" alt="<?php echo $translate['gestionar_cesto']; ?>" title="<?php echo $translate['gestionar_cesto']; ?>" width="75" height="75" border="0" /></a></strong><br />
                    <strong><a href="javascript:void(0);" onclick="cargar_div('inc/cesta.php','i=','principal');"><?php echo $translate['gestionar_cesto']; ?></a></strong></li>
		        <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {
			  
			  	echo '<li id="thelist4"><strong><a href="inc/herramientas/gestionar_repositorio.php" onclick="return GB_showFullScreen(\'Gestionar repositorio\', this.href)"><img src="images/archivar.png" alt="Gestionar Repositorio" width="75" height="75" border="0" /></</strong><br /><strong><a href="inc/herramientas/gestionar_repositorio.php" onclick="return GB_showFullScreen(\'Gestionar repositorio\', this.href)">GESTONAR REPOSITORIO</a></strong></li>'; 
				} ?>
                <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {
             		 echo '<li id="thelist4" style="text-transform:uppercase;"><strong><a href="inc/herramientas/generador_paneles/generador_paneles.php" onclick="return GB_showFullScreen(\''.$translate['creador_paneles'].'\', this.href)"><img src="images/comunicador.png" alt="'.$translate['creador_paneles'].'" title="'.$translate['creador_paneles'].'" width="75" height="75" border="0" /></a></strong><br /><strong><a href="inc/herramientas/generador_paneles/generador_paneles.php" onclick="return GB_showFullScreen(\''.$translate['creador_paneles'].'\', this.href)">'.$translate['creador_paneles'].'</a></strong></li>';
			  } ?>
                <li id="thelist4" style="text-transform:uppercase;"><strong><a href="inc/herramientas/creador_animaciones.php" onclick="return GB_showFullScreen('<?php echo $translate['creador_animaciones']; ?>', this.href)"><img src="images/verbos.png" alt="<?php echo $translate['creador_animaciones']; ?>" title="<?php echo $translate['creador_animaciones']; ?>" width="75" height="75" border="0" /></a></strong><br />
                    <strong><a href="inc/herramientas/creador_animaciones.php" onclick="return GB_showFullScreen('<?php echo $translate['creador_animaciones']; ?>', this.href)"><?php echo $translate['creador_animaciones']; ?></a></strong></li>
		        <li id="thelist4" style="text-transform:uppercase;"><strong><a href="inc/herramientas/creador_simbolos/creador_simbolos.php" onclick="return GB_showFullScreen('<?php echo $translate['creador_de_simbolos']; ?>', this.href)"><img src="images/dibujar.png" alt="<?php echo $translate['creador_de_simbolos']; ?>" title="<?php echo $translate['creador_de_simbolos']; ?>" width="75" height="75" border="0" /></a></strong> <br />
	              <a href="inc/herramientas/creador_simbolos/creador_simbolos.php" onclick="return GB_showFullScreen('<?php echo $translate['creador_de_simbolos']; ?>', this.href)"><strong><?php echo $translate['creador_simbolos']; ?></strong></a></li>
		        <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {
             		 echo '<li id="thelist4"><strong><a href="creador_ejercicios/creador_ejercicios.php"><img src="images/actividades.png" alt="Creador de Ejercicios" width="75" height="75" border="0" /></a></strong><br /><strong><a href="creador_ejercicios/creador_ejercicios.php">CREADOR DE EJERCICIOS</a></strong></li>';
			  } ?>
                <li id="thelist4" style="text-transform:uppercase;"><strong><a href="inc/herramientas/creador_frases/creador_frases.php" onclick="return GB_showFullScreen('<?php echo $translate['creador_frases']; ?>', this.href)"><img src="images/frases.png" alt="<?php echo $translate['creador_frases']; ?>" title="<?php echo $translate['creador_frases']; ?>" width="75" height="75" border="0" /></a></strong><br /><a href="inc/herramientas/creador_frases/creador_frases.php" onclick="return GB_showFullScreen('<?php echo $translate['creador_frases']; ?>', this.href)"><strong><?php echo $translate['creador_frases']; ?></strong></a>                  </li>
	          </ul>
</div>
<br /><br />

<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],14); 
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['software_caa']; ?></title>
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
		<?php echo '<a name="select" id="select"></a><h4 style="text-transform:"uppercase;">'.$translate['software_caa'].'</h4>'; ?>
		<div id="principal">
           <div align="left"><?php echo $translate['software_soporta_pictos_arasaac']; ?>: <br /><br /><a href="#tico" target="_self"><?php echo $translate['tico']; ?></a> | <a href="#vocaliza" target="_self"><?php echo $translate['vocaliza']; ?></a> | <a href="#raton_virtual" target="_self"><?php echo $translate['raton_virtual']; ?></a> | <a href="#escribir_simbolos" target="_self"><?php echo strtoupper($translate['escribir_simbolos_2000']); ?></a> | <a href="#cubo_imagenes" target="_self"><?php echo $translate['cubo_imagenes']; ?></a> | <a href="#in_tic" target="_self"><?php echo $translate['in_tic']; ?></a> | <a href="#plaphoons" target="_self"><?php echo $translate['plaphoons']; ?></a> | <a href="#messengervisual" target="_self"><?php echo $translate['messengervisual']; ?></a> | <a href="#pictoselector" target="_self"><?php echo $translate['pictoselector']; ?></a> | <a href="#mira" target="_self"><?php echo $translate['mira_cucs']; ?></a></div>
            <br />
            <h4><a name="tico" id="tico"></a><?php echo $translate['tico']; ?> <a href="#select" target="_self"><img src="images/up.gif" alt="<?php echo $translate['seleccionar_software']; ?>" title="<?php echo $translate['seleccionar_software']; ?>" border="0" /></a></h4>
            <?php echo $translate['tico_explicacion']; ?>
            <p align="right">[<a href="http://www.proyectotico.es/wiki/index.php/Inicio" target="_blank"><?php echo $translate['ampliar_informacion']; ?></a>]</p>
            <p align="center"><a href="http://centros6.pntic.mec.es/cpee.alborada/" target="_blank"><img src="images/logo_alborada.jpg" alt="CPEE ALBORADA (ZARAGOZA)" width="145" height="99" title="CPEE ALBORADA (ZARAGOZA)" border="0" /></a> &nbsp;&nbsp;<a href="http://www.cps.unizar.es/" target="_blank"><img src="images/logo_cps.jpg" alt="Grupo de Tecnolog&iacute;a de las Comunicaciones (GTC)" title="Grupo de Tecnolog&iacute;a de las Comunicaciones (GTC)" width="99" height="99" border="0" /></a></p>
            <div class="informacion" align="left">
            <a href="http://www.proyectotico.es/wiki/index.php/Descargas" target="_blank"><img src="images/filesave.png" alt="<?php echo $translate['descargar_programa']; ?>" border="0" title="<?php echo $translate['descargar_programa']; ?>" /></a> <a href="mailto:cpeealborada@gmail.com"></a>&nbsp;&nbsp;<a href="http://proyectotico.gidhe.es/wiki/manualTICO.pdf" target="_blank"><img src="images/page_white_acrobat.png" alt="<?php echo $translate['descargar_manual_pdf']; ?>" border="0"  title="<?php echo $translate['descargar_manual_pdf']; ?>"/></a>&nbsp;&nbsp;<a href="zona_descargas/software/tico2 version-bin-w32-2.1.exe"></a><a href="mailto:ticoproyecto@gmail.com"><img src="images/email_go.png" alt="<?php echo $translate['contactar_cpee_alborada']; ?>" title="<?php echo $translate['contactar_cpee_alborada']; ?>"border="0" /></a>
    </div>
            <br /><br />
            <h4><a name="vocaliza" id="vocaliza"></a><?php echo $translate['vocaliza']; ?> <a href="#select" target="_self"><img src="images/up.gif" alt="<?php echo $translate['seleccionar_software']; ?>" title="<?php echo $translate['seleccionar_software']; ?>" border="0" /></a></h4>
            <?php echo $translate['explicacion_vocaliza']; ?>
            <p align="right">[<a href="http://centros6.pntic.mec.es/cpee.alborada/cps//vocaliza/index.html" target="_blank"><?php echo $translate['ampliar_informacion']; ?></a>]</p>
            <p align="center"><a href="http://centros6.pntic.mec.es/cpee.alborada/" target="_blank"><img src="images/logo_alborada.jpg" alt="CPEE ALBORADA (ZARAGOZA)" width="145" height="99" title="CPEE ALBORADA (ZARAGOZA)" border="0" /></a> &nbsp;&nbsp;<a href="http://www.cps.unizar.es/" target="_blank"><img src="images/logo_cps.jpg" alt="Grupo de Tecnolog&iacute;a de las Comunicaciones (GTC)" title="Grupo de Tecnolog&iacute;a de las Comunicaciones (GTC)" width="99" height="99" border="0" /></a></p>
            <div class="informacion"><a href="http://www.vocaliza.es/" target="_blank"><img src="images/filesave.png" alt="<?php echo $translate['descargar_programa']; ?>" border="0" title="<?php echo $translate['descargar_programa']; ?>" /></a> &nbsp;&nbsp;<a href="mailto:cpeealborada@gmail.com"><img src="images/email_go.png" alt="<?php echo $translate['contactar_cpee_alborada']; ?>" title="<?php echo $translate['contactar_cpee_alborada']; ?>" border="0" /></a></div>
            <br /><br />
            <h4><a name="raton_virtual" id="raton_virtual"></a><?php echo $translate['raton_virtual']; ?> <a href="#select" target="_self"><img src="images/up.gif" alt="<?php echo $translate['seleccionar_software']; ?>" title="<?php echo $translate['seleccionar_software']; ?>" border="0" /></a></h4>
            <?php echo $translate['explicacion_raton_virtual']; ?>
            <p align="right">[<a href="http://centros6.pntic.mec.es/cpee.alborada/cps//raton/index.html" target="_blank"><?php echo $translate['ampliar_informacion']; ?></a>]</p>
            <p align="center"><a href="http://centros6.pntic.mec.es/cpee.alborada/" target="_blank"><img src="images/logo_alborada.jpg" alt="CPEE ALBORADA (ZARAGOZA)" title="CPEE ALBORADA (ZARAGOZA)" width="145" height="99" border="0" /></a> &nbsp;&nbsp;<a href="http://www.cps.unizar.es/" target="_blank"><img src="images/logo_cps.jpg" alt="Grupo de Tecnolog&iacute;a de las Comunicaciones (GTC)" title="Grupo de Tecnolog&iacute;a de las Comunicaciones (GTC)" width="99" height="99" border="0" /></a></p>
            <div class="informacion"><a href="zona_descargas/software/raton-virtual-w32-1.0.zip"><img src="images/filesave.png" alt="<?php echo $translate['descargar_programa']; ?>" border="0" title="<?php echo $translate['descargar_programa']; ?>" /></a>&nbsp;&nbsp;<a href="zona_descargas/documentacion/manual_de_usuario.pdf" target="_blank"><img src="images/page_white_acrobat.png" alt="<?php echo $translate['descargar_manual_pdf']; ?>" border="0"  title="<?php echo $translate['descargar_manual_pdf']; ?>"/></a>&nbsp;&nbsp;<a href="mailto:cpeealborada@gmail.com"><img src="images/email_go.png" alt="<?php echo $translate['contactar_cpee_alborada']; ?>" title="<?php echo $translate['contactar_cpee_alborada']; ?>" border="0" /></a></div>
            <br /><br />
           
            <h4><a name="escribir_simbolos" id="escribir_simbolos"></a><?php echo $translate['escribir_simbolos_2000']; ?> <a href="#select" target="_self"><img src="images/up.gif" alt="<?php echo $translate['seleccionar_software']; ?>" title="<?php echo $translate['seleccionar_software']; ?>" border="0" /></a></h4>
            <p><?php echo $translate['escribir_simbolos_2000_descripcion']; ?></p>
            <p align="center">
            <?php if ($_SESSION['language']=='es') {  
					echo '[<a href="zona_descargas/documentacion/introducir_pictogramas_ECS2000.pdf" target="_blank">'.strtoupper($translate['tutorial']).'</a>]';
				  } elseif ($_SESSION['language']=='en') {
					 echo '[<a href="zona_descargas/documentacion/ECS2000_en.pdf" target="_blank">'.strtoupper($translate['tutorial']).'</a>]'; 
				  } elseif ($_SESSION['language']=='fr') {
					 echo '[<a href="zona_descargas/documentacion/ECS2000_en.pdf" target="_blank">'.strtoupper($translate['tutorial']).'</a>]'; 
				  } else {
					  echo '[<a href="zona_descargas/documentacion/ECS2000_en.pdf" target="_blank">'.strtoupper($translate['tutorial']).'</a>]';
				  }
			?>
            </p>
            <br  /> <br  />
            <h4><a name="cubo_imagenes" id="cubo_imagenes"></a><?php echo $translate['cubo_imagenes']; ?> <a href="#select" target="_self"><img src="images/up.gif" alt="<?php echo $translate['seleccionar_software']; ?>" title="<?php echo $translate['seleccionar_software']; ?>" border="0" /></a></h4>
            <?php echo $translate['explicacion_cubo_imagenes']; ?>
            <p align="center">[<a href="zona_descargas/documentacion/cubo_de_imagenes.pdf" target="_blank"><?php echo $translate['DESCARGAR_DOCUMENTACION']; ?></a>]</p>
            <br /><br />
            <h4><a name="in_tic" id="in_tic"></a><?php echo $translate['in_tic']; ?> <a href="#select" target="_self"><img src="images/up.gif" alt="<?php echo $translate['seleccionar_software']; ?>" title="<?php echo $translate['seleccionar_software']; ?>" border="0" /></a></h4>
            <div>
            <?php echo $translate['explicacion_intic']; ?>
            </div>
            <div class="informacion"><a href="http://www.intic.udc.es/" target="_blank"><img src="images/filesave.png" alt="<?php echo $translate['descargar_programa']; ?>" border="0" title="<?php echo $translate['descargar_programa']; ?>" /></a>&nbsp;&nbsp;<a href="mailto:intic@udc.es"><img src="images/email_go.png" alt="<?php echo $translate['contactar_cpee_alborada']; ?>" title="<?php echo $translate['contactar_cpee_alborada']; ?>" border="0" /></a></div>
            <br /><br />
            <h4><a name="plaphoons" id="plaphoons"></a><?php echo $translate['plaphoons']; ?> <a href="#select" target="_self"><img src="images/up.gif" alt="<?php echo $translate['seleccionar_software']; ?>" title="<?php echo $translate['seleccionar_software']; ?>" border="0" /></a></h4>
            <div>
            <?php echo $translate['explicacion_plaphoons']; ?>
            </div>
            <div class="informacion"><a href="http://www.xtec.cat/~jlagares/download/plaphoons.zip" target="_blank"><img src="images/filesave.png" alt="<?php echo $translate['descargar_programa']; ?>" border="0" title="<?php echo $translate['descargar_programa']; ?>" /></a>&nbsp;&nbsp;<a href="mailto:jordi@lagares.org"><img src="images/email_go.png" alt="<?php echo $translate['contactar']; ?>" title="<?php echo $translate['contactar']; ?>" border="0" /></a></div>
            <br /><br />
            <h4><a name="messengervisual" id="messengervisual"></a><?php echo $translate['messengervisual']; ?> <a href="#select" target="_self"><img src="images/up.gif" alt="<?php echo $translate['seleccionar_software']; ?>" title="<?php echo $translate['seleccionar_software']; ?>" border="0" /></a></h4>
            <div>
            <?php echo $translate['explicacion_messengervisual']; ?>
            </div>
            <div class="informacion"><a href="http://devel.cpl.upc.edu/messengervisual/" target="_blank"><img src="images/filesave.png" alt="<?php echo $translate['descargar_programa']; ?>" border="0" title="<?php echo $translate['descargar_programa']; ?>" /></a>&nbsp;&nbsp;<a href="mailto:fundmaresme@fundmaresme.cat"><img src="images/email_go.png" alt="<?php echo $translate['contactar']; ?>" title="<?php echo $translate['contactar']; ?>" border="0" /></a></div>
            
            <br /><br />
            <h4><a name="pictoselector" id="pictoselector"></a><?php echo $translate['pictoselector']; ?> <a href="#select" target="_self"><img src="images/up.gif" alt="<?php echo $translate['seleccionar_software']; ?>" title="<?php echo $translate['seleccionar_software']; ?>" border="0" /></a></h4>
            <div>
            <?php echo $translate['explicacion_pictoselector']; ?>
            </div>
            
            <div class="informacion"><a href="http://pecsforall.com/" target="_blank"><img src="images/filesave.png" alt="<?php echo $translate['descargar_programa']; ?>" border="0" title="<?php echo $translate['descargar_programa']; ?>" /></a>&nbsp;&nbsp;<a href="mailto:contact@pecsforall.com"><img src="images/email_go.png" alt="<?php echo $translate['contactar']; ?>" title="<?php echo $translate['contactar']; ?>" border="0" /></a></div>
            
            <br /><br />
            <h4><a name="mira" id="mira"></a><?php echo $translate['mira_cucs']; ?> <a href="#select" target="_self"><img src="images/up.gif" alt="<?php echo $translate['seleccionar_software']; ?>" title="<?php echo $translate['seleccionar_software']; ?>" border="0" /></a></h4>
            <div>
            <?php echo $translate['mira_cucs_descripcion']; ?>
            </div>
            
            <div class="informacion"><a href="http://sites.google.com/site/miracucs/Home" target="_blank"><img src="images/filesave.png" alt="<?php echo $translate['descargar_programa']; ?>" border="0" title="<?php echo $translate['descargar_programa']; ?>" /></a>&nbsp;&nbsp;<a href="mailto:bernat.edu@gmail.com"><img src="images/email_go.png" alt="<?php echo $translate['contactar']; ?>" title="<?php echo $translate['contactar']; ?>" border="0" /></a></div>
            
</div>
	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


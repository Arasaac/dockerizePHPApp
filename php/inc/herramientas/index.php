<?php 
session_start();

require('../../funciones/funciones.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Herramientas ARASAAC</title>
<link rel="stylesheet" href="../../css/style.css" type="text/css" />
<script type="text/javascript" src="js/ajax_herramientas.js"></script>
    <script type="text/javascript">
        var GB_ROOT_DIR = "js/greybox/";
    </script>

    <script type="text/javascript" src="js/greybox/AJS.js"></script>
    <script type="text/javascript" src="js/greybox/AJS_fx.js"></script>
    <script type="text/javascript" src="js/greybox/gb_scripts.js"></script>
    <link href="js/greybox/gb_styles.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div class="body_content">
	<link rel="STYLESHEET" type="text/css" href="js/dhtmlxMenu/css/dhtmlXMenu.css">
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXProtobar.js"></script>
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXMenuBar.js"></script>
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXCommon.js"></script>
    <table width="100%">
	  <tr>
			<td width="78%">
			  <div id="menu_zone" style="width:600;background-color:#f5f5f5;border :1px solid Silver;"/>
			</td>
     <td width="22%">
<table width="100%" border="0">
              <tr>
                <td align="right">
				 <?php if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { ?>
                <a href="javascript:void(0);" onclick="Dialog.alert({url: '../public/login.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:350, height:140}, okLabel: 'Cerrar', ok:function(win) { setTimeout(window.location.reload(),1000); } });">Logearse</a>
                <?php 
				} else { ?>
                <b><?php echo utf8_encode(saludo()); ?></b>&nbsp;<?php echo $_SESSION['USERNAME']; ?>&nbsp;| <a href="javascript:void(0);" onclick="desconectar();">Desconectar</a>
                <?php  } ?></td>
          </tr>
            </table>
        </td>
		</tr>
	</table>
	<hr>
	<script>
	
		function onButtonClick(itemId,itemValue)
		{};
		aMenuBar=new dhtmlXMenuBarObject(document.getElementById('menu_zone'),'100%',16,"");
		aMenuBar.setOnClickHandler(onButtonClick);
		aMenuBar.setGfxPath("js/dhtmlxMenu/img/");
		<?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {  ?>
		aMenuBar.loadXML("js/dhtmlxMenu/_menu.xml");
		<?php } else {  ?>
		aMenuBar.loadXML("js/dhtmlxMenu/_menu_invitado.xml");
		<?php } ?>
		aMenuBar.showBar();
	</script>
	<div id="principal">
    <p>Bienvenidos a la Zona de Herramientas de ARASAAC. Como complemento al catálogo de pictogramas, imágenes y materiales que se ofrecen en ARASAAC se está desarrollando una serie de Herremientas que permitan al profesorado, crear diferentes recursos y materiales para utilizar en las aulas con sus alumnos o aquellas personas que requieren un sistema alternativo de comunicación.      </p>
    <p>Para trabajar con la mayor parte de las herramientas es aconsejable, en primar lugar, visitar los diferentes catálogos de pictogramas o imágenes e ir echando al nuestra caja aquellos que queramos utilizar para crear materiales. Una vez hecho esto, podemos volver a esta zona de materiales y trabajar con aquellas herramientas que necesitemos.      </p>
    <p>Esta zona está en continua evolución y, por ello, rogamos disculpen si algunos aspectos cambian o surgen problemas de funcionamiento. No duden en comunicarnos cualquier incidencia o sugerencia de mejora. </p>
    <p><a href="creador_frases/creador_frases.php" title="Creador de frases" rel="gb_page_fs[]">Creador de Frases</a></p>
<ul id="thelist4" style="border: 1px dashed #CCCCCC; width:96%; height:400px; padding:20px;">
    
                <li id="thelist4"><strong><a href="../../index.php"><img src="../../images/home.png" alt="Inicio ARASAAC" width="75" height="75" border="0" /></a></strong><br /><strong><a href="cesta.php">INICIO ARASAAC</a></strong></li>
              <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) { 
			  			
						echo '<li id="thelist4"><a href="seleccion.php"><strong><img src="../../images/elegir.png" alt="Mis Selecciones" width="75" height="75" border="0" /></strong></a><br /><a href="seleccion.php"><strong>MIS SELECCIONES</strong></a></li>';                   
              } ?>
                <li id="thelist4"><strong><a href="cesta.php"><img src="../../images/cesta.png" alt="Gestionar Cesto de Símbolos" width="75" height="75" border="0" /></a></strong><br /><strong><a href="cesta.php">GESTIONAR CESTO DE SÍMBOLOS</a></strong></li>
                <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {
			  
			  	echo '<li id="thelist4"><strong><a href="gestionar_repositorio.php"><img src="../../images/archivar.png" alt="Gestionar Repositorio" width="75" height="75" border="0" /></</strong><br /><strong><a href="gestionar_repositorio.php">GESTONAR REPOSITORIO</a></strong></li>'; 
				} ?>				
                <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {
             		 echo '<li id="thelist4"><strong><a href="creador_paneles/nuevo_panel.php"><img src="../../images/comunicador.png" alt="Creador de Paneles de Comunicación" width="75" height="75" border="0" /></a></strong><br /><strong><a href="creador_paneles/nuevo_panel.php">CREADOR DE PANELES</a></strong></li>';
			  } ?>			  
                <li id="thelist4"><strong><a href="creador_animaciones.php"><img src="../../images/verbos.png" alt="Creador de Animaciones" width="75" height="75" border="0" /></a></strong><br /><strong><a href="creador_animaciones.php">CREADOR DE ANIMACIONES</a></strong></li>
                
                <li id="thelist4"><strong><a href="creador_simbolos/creador_simbolos.php"><img src="../../images/dibujar.png" alt="Creador de Símbolos" width="75" height="75" border="0" /></a></strong>   
                <br /><strong><a href="creador_simbolos/creador_simbolos.php">CREADOR DE SIMBOLOS</a></strong></li>
                 <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {
             		 echo '<li id="thelist4"><strong><a href="creador_ejercicios/creador_ejercicios.php"><img src="../../images/actividades.png" alt="Creador de Ejercicios" width="75" height="75" border="0" /></a></strong><br /><strong><a href="creador_ejercicios/creador_ejercicios.php">CREADOR DE EJERCICIOS</a></strong></li>';
			  } ?>	
                
                <li id="thelist4"><strong><a href="creador_frases/creador_frases.php"><img src="../../images/frases.png" alt="Creador de Paneles de Comunicación" width="75" height="75" border="0" /></a></strong><br /><a href="creador_frases/creador_frases.php"><strong>CREADOR DE FRASES</strong></a></li>
                
                </ul>
	</div>
    <br />
<div align="center" class="footer">
      <p><a href="../../index.php">Qu&eacute; es Arasaac</a> | <a href="../../index.php?ref=condiciones_uso_h">Condiciones de Uso</a> | <a href="../../index.php?ref=mapa_web_h">Mapa Web</a><br />
&copy; Herramientas ARASAAC, CATEDU <?php echo date("Y"); ?> | Departamento de Educaci&oacute;n Cultura y Deporte<br />
<a href="http://www.aragob.es" target="_blank"><img src="../../images/minilogo_aragob.gif" alt="Gobierno de Aragón" border="0" tittle="Gobierno de Aragón"/></a></p>
  </div>
</div>
</body>
</html>

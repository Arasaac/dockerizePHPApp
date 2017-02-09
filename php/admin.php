<?php 
session_start();  // INICIO LA SESION
require ('classes/languages/language_detect.php');
include ('classes/date/Date.class.php'); 
include("classes/rss/feedcreator.class.php");
include ('classes/querys/query.php');
include ('funciones/funciones.php');
require ('lang/lang_es.php');
require_once('classes/rc4crypt/class.rc4crypt.php');
require_once('configuration/key.inc');
require ('classes/crypt/5CR.php'); 
$encript = new E5CR($llave);

$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],2); 
$fecha=new date();

$permisos=$query->permisos_usuario($_SESSION['ID_USER']);

include ('inc/menu_principal.php');
include ('inc/menu_administracion.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
    <META NAME="keywords" CONTENT="saac,aac,Augmentative and alternative communication,educacion especial,catedu,aragón,educación,sistemas aumentativos y alternativos de comunicación,pictograph,pictogramas,pictograms,special education">
    <META NAME="Description" CONTENT="Portal ARASAAC.El portal Aragonés de la Comunicación Aumentativa y Alternativa reune pictogramas, imágenes, materiales y software que facilitan la comunicación de aquellos alumnos con algún tipo de necesidad educativa de comunicación.">
    <META NAME="Author" CONTENT="CATEDU">
    <META NAME="Revisit" CONTENT="8 days">
    <META NAME="Robots" CONTENT="all">
    <META NAME="Language" CONTENT="Spanish">
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <title><?php echo $translate['portal_aragones_caa_txt']; ?></title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
	<link rel="stylesheet" href="js/lightbox_v2/lightbox.css" media="screen,projection" type="text/css" />
	<link rel="stylesheet" href="js/lightbox_v2/screen.css" media="screen,projection" type="text/css" />
    <link rel="stylesheet" href="js/autoComplete/autoComplete_css.css" type="text/css" media="screen" charset="utf-8" />
	<script type="text/javascript" src="js/ajax.js"></script>
    <script type="text/javascript">
        var GB_ROOT_DIR = "js/greybox_v5/";
    </script>
    <script type="text/javascript" src="js/greybox_v5/AJS.js"></script>
    <script type="text/javascript" src="js/greybox_v5/AJS_fx.js"></script>
    <script type="text/javascript" src="js/greybox_v5/gb_scripts.js"></script>
    <link href="js/greybox_v5/gb_styles.css" rel="stylesheet" type="text/css" media="all" />
	<script type="text/javascript" src="js/js_validate/form-validation.js"></script>
    <script type="text/javascript" src="js/js_validate/my-conditions.js"></script>
    <script type="text/javascript" src="js/prototype/prototype.js"> </script> 
  	<script type="text/javascript" src="js/windows_js_0.96.2/javascripts/effects.js"> </script>
  	<script type="text/javascript" src="js/windows_js_0.96.2/javascripts/window.js"> </script>
  	<script type="text/javascript" src="js/windows_js_0.96.2/javascripts/debug.js"> </script>
	<!--<script type="text/javascript" src="js/jsval/jsval.js"> </script>--> 
    <!--<script type="text/javascript" src="js/autosuggest/js/autosuggest.js" charset="utf-8"></script>-->
    <script type="text/javascript" src="js/nornixtreemenu/treemenu/nornix-treemenu.js"></script>
    <link rel="StyleSheet" href="js/nornixtreemenu/skins/default/menu.css" type="text/css" media="screen" />
	 
	<!--<script type="text/javascript" src="js/dhtmlxTree/dhtmlXCommon.js"></script>	
  	<script type="text/javascript" src="js/dhtmlxTree/dhtmlXTree.js"></script>
	<link rel="stylesheet" type="text/css" href="js/dhtmlxTree/css/dhtmlXTree.css">-->
	
  	<link href="js/windows_js_0.96.2/themes/default.css" rel="stylesheet" type="text/css" >	 </link>
  	<link href="js/windows_js_0.96.2/themes/alphacube.css" rel="stylesheet" type="text/css" >	 </link>
	<link href="js/windows_js_0.96.2/themes/alert.css" rel="stylesheet" type="text/css" >	 </link>
	<link href="js/windows_js_0.96.2/themes/alert_lite.css" rel="stylesheet" type="text/css" >	 </link>
  	<link href="js/windows_js_0.96.2/themes/debug.css" rel="stylesheet" type="text/css" >	 </link>

   <!-- <link rel="stylesheet" href="js/autosuggest/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />-->
 <?php 
//Averiguar resolucion en pantalla
//********************************************
$siteurl = $_SERVER['REQUEST_URI'];
$GLOBALS['siteurl'] = $siteurl;
require('funciones/getres.php'); 
?>
</head>

<body <?php if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { ?> onload="Dialog.alert({url: 'inc/public/login.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:350, height:200}, okLabel: '<?php echo $translate['cerrar']; ?>', ok:function(win) { setTimeout(window.location.reload(),1000); } });" <?php } else { echo "onload=\"cargar_div('inc/public/inicio_admin.php','i=','principal');\""; } ?>>
	
                 
<div class="body_content"> 

	  <div class="header">
  <div id="parte_superior" align="center">
      <table width="100%" height="80" border="0" cellpadding="0" cellspacing="0">
<tr>
          <td width="45%" rowspan="2" align="left" valign="middle"><h1><a href="index.php" target="_self"><img src="images/arasaac.jpg" alt="<?php echo $translate['ir_pagina_inicio']; ?>" title="<?php echo $translate['ir_pagina_inicio']; ?>" border="0" /></a></h1>
          <h3>&nbsp;&nbsp;&nbsp;ADMINISTRACI&Oacute;N</h3></td>
                <td height="25" colspan="2" align="right" valign="middle"><?php if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { } else { ?>
                  <a href="javascript:void(0);" onclick="desconectar();"><?php echo $translate['desconectar']; ?></a>
                <?php } ?></td>
        </tr>
              <tr>
                <td width="39%" align="right" valign="middle">&nbsp;</td>
                <td width="16%" align="right" valign="middle"><div id="products" align="left" style="border: 1px solid #CCCCCC; width:200px;">
                  <table width="100%" border="0">
                    <tr>
                      <td rowspan="2" align="center"><a href="javascript:void(0);" onclick="cargar_div('inc/cesta.php','i=','principal');"><img src="images/carrito_compra_b3.gif" alt="<?php echo $translate['ver_mi_cesto']; ?>" title="<?php echo $translate['ver_mi_cesto']; ?>" width="32" height="32" border="0" /></a></td>
                      <td colspan="3" align="left"><span class="azul_claro"><b><?php echo $translate['mi_cesto']; ?></b></span></td>
                    </tr>
                    <tr>
                      <td align="left"><?php $n=0; if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") { foreach ($_SESSION['cart'] as $key => $value) { $n=$n+1; } }  echo '<a href="javascript:void(0);" onclick="cargar_div(\'inc/cesta.php\',\'i=\',\'principal\');"><small>'.$translate['tengo'].'</small>&nbsp;<b><big><span id="n_cesto">'.$n.'</span></big></b>&nbsp;<small>'.$translate['elementos_en_mi_cesto'].'</small></a>'; ?></td>
                      <td align="right"><a href="javascript:void(0);" onclick="Dialog.alert({url: 'zip.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:300, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: '<?php echo $translate['cerrar']; ?>'});"><img src="images/zip-icon.gif" alt="<?php echo $translate['comprimir_cesto_zip']; ?>" width="16" height="16" border="0" title="<?php echo $translate['comprimir_cesto_zip']; ?>" /></a></td>
                      <td align="right"><div id="clearCart" onclick="clearCart();"> <img src="images/papelera.png" alt="<?php echo $translate['vaciar_mi_cesto']; ?>" width="16" height="16" title="<?php echo $translate['vaciar_mi_cesto']; ?>"/></div>
                        <div id="loading">
                          <div align="center"><img src="images/indicator.gif" alt="<?php echo $translate['cargando']; ?>" title="<?php echo $translate['cargando']; ?>"/></div>
                        </div></td>
                    </tr>
                  </table>
                </div></td>
        </tr>
      </table>         
</div>
	    <table width="100%" height="151" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%" height="83" colspan="2" align="center">
              <div style="border-top:1px solid #c5e953; margin-top:5px;"></div>
           <?php echo utf8_encode('<div class="bar" style="text-align:center;"><ul id="bar">
					<li><a href="admin.php">'.$translate['inicio'].'</a></li><span class="separador_naranja">|
					<li><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/catalogos.php","i=","principal"); cargar_div("inc/menu_subprincipal.php","i=","submenu");\'>'.$translate['catalogos'].'</a></li><span class="separador_naranja">|</span><li><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/materiales.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");\'>'.$translate['materiales'].'</a></li>  <span class="separador_naranja">|</span><li><a href="javascript:void(0);" onClick=\'cargar_div("inc/gestion_software/software.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");\'>'.$translate['SOFTWARE'].'</a></li> <span class="separador_naranja">|</span><li><a href="javascript:void(0);" onClick=\'cargar_div("inc/gestion_ejemplos_uso/ejemplos_uso.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");\'>'.$translate['ejemplos_de_uso'].'</a></li></ul></div>'); ?>
                      <div id="submenu" align="center"></div>
            <div style="border-top:1px solid #c5e953; margin-top:15px;"></div>
              <div class="search_field">
                <form action="javascript: $('suggestions').hide(); var buscar=document.getElementById('s').value; document.getElementById('s').value=''; var elem=document.getElementsByName('buscar_por'); if (elem[0].checked) { var buscar_por=1; } else { var buscar_por=2; }  recogercheckbox_buscador_principal(''+buscar+'',''+buscar_por+'');" method="POST" id="autossugest">
                  <strong><?php echo $translate['buscar_catalogos_superior']; ?>:</strong>
                  <input name="buscar_por" type="radio" id="buscar_por2" value="1" checked="checked" />
                  <?php echo $translate['palabras_acepciones']; ?>
                  <?php if ($_SESSION['language'] =='es' && $_SESSION['id_language'] == 0) { ?>
                  <input name="buscar_por" type="radio" id="buscar_por" value="2" />
                  <?php echo $translate['tags']; ?>
                  <?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;
                   <img src="images/information_icon.gif" alt="<?php echo $translate['explicacion_buscar_por']; ?>" title="<?php echo $translate['explicacion_buscar_por']; ?>"/> 
        		<div id="search" style="margin-bottom:10px;">
        		  <input type="text" name="s" id="s" size="25" onkeyup="lookup(this.value,document.getElementById('idiomaweb').value);"  onfocus="$('suggestions').hide();" onclick="$('suggestions').hide();"/>
        		  <input type="hidden" id="idiomaweb" name="idiomaweb" value="<?php echo $_SESSION['language']; ?>"/>
     			 </div> 
                 <div style="position:relative; width:650px; z-index:30;">
                       <div class="suggestionsBox" id="suggestions" style="display: none;">
                            <img src="js/autoComplete/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                            <div class="suggestionList" id="autoSuggestionsList"></div>
                 	  </div>
                 </div>		
                      <input type="hidden" id="id_palabra" />                
                  
                  <strong><?php echo $translate['mostrar']; ?>&nbsp;<img src="images/information_icon.gif" alt="<?php echo $translate['explicacion_mostrar']; ?>" title="<?php echo $translate['explicacion_mostrar']; ?>"/>&nbsp;:</strong>&nbsp;
                  <input name="pictogramas_color" type="checkbox" id="pictogramas_color" value="1" checked="checked" />
                  <?php echo $translate['pictogramas_color']; ?>
                  <input name="pictogramas_byn" type="checkbox" id="pictogramas_byn" value="1" checked="checked" />
                  <?php echo $translate['pictogramas_byn']; ?>
                  <input name="fotografia" type="checkbox" id="fotografia" value="1" checked="checked" />
                  <?php echo $translate['imagenes']; ?>
              
      				<?php if (isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== true) { ?>
                    <input name="simbolos" type="checkbox" id="simbolos" value="1" />
                  <a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/opciones_busqueda_simbolos.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:420, height:350}, okLabel: '<?php echo $translate['cerrar']; ?>' });"><?php echo $translate['simbolos']; ?></a>
                  <input name="videos_lse" type="checkbox" id="videos_lse" value="1" checked="checked" /> 
                <label></label>
                   <?php echo $translate['videos_lse']; ?>
                   <label></label>
                    <input name="lse_color" type="checkbox" id="lse_color" value="1" checked="checked" />
                  <?php echo $translate['lse_color']; ?>
                  <input name="lse_byn" type="checkbox" id="lse_byn" value="1" />
				  <?php echo $translate['lse_byn']; ?>
                  
                  <?php } ?>
				<?php echo '&nbsp;<b>'.$translate['en_resultados'].'</b>'; ?><br />
                </form>
                </div></td>
            </tr>
            <tr>
              <td height="31" colspan="2" align="center"> <div style="border-top:1px solid #c5e953; margin-top:5px;"></div><br />
			  <?php  if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { echo $menu_administracion.'<br /><br />'; } ?></td>
          </tr>
        </table> 
                
	  </div>

		<div id="mensaje"></div>
		
		<div id="principal"> </div>

	  <div class="down">
	  		
	    <div class="footer">
	      <div style="float:left; margin: 5px;">&copy; ARASAAC - Augmentative and Alternative Communication (AAC) <br />
          <a href="http://www.aragob.es" target="_blank"><img src="images/minilogo_aragob.gif" alt="<?php echo $translate['dto_educacion']; ?>" width="12" height="12" border="0" title="<?php echo $translate['dto_educacion']; ?>"/></a>  <?php echo $translate['dto_educacion']; ?> | <a href="http://catedu.es" target="_blank">CATEDU</a> <?php echo date("Y"); ?></div>
              
        </div>
	</div>
    </div> 
  </body>
</html>
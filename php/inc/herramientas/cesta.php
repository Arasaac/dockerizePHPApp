<?php 
session_start();

require_once('classes/crypt/5CR.php');
require_once('../../configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

include ('../../classes/querys/query.php');
$query=new query();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Herramientas ARASAAC</title>
<link rel="stylesheet" href="../../css/style.css" type="text/css" />
<script type="text/javascript" src="js/ajax_herramientas.js"></script>
<script src="js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script type="text/javascript" src="js/prototype/prototype.js"> </script> 
<script src="js/XHConn.js" type="text/javascript"></script>
<link rel="stylesheet" href="../../css/scriptaculous.css" type="text/css" />

<script type="text/javascript" src="js/windows_js_0.96.2/javascripts/effects.js"> </script>
<script type="text/javascript" src="js/windows_js_0.96.2/javascripts/window.js"> </script>
<script type="text/javascript" src="js/windows_js_0.96.2/javascripts/debug.js"> </script>
<link href="js/windows_js_0.96.2/themes/default.css" rel="stylesheet" type="text/css" >	 </link>
<link href="js/windows_js_0.96.2/themes/alphacube.css" rel="stylesheet" type="text/css" >	 </link>
<link href="js/windows_js_0.96.2/themes/alert.css" rel="stylesheet" type="text/css" >	 </link>
<link href="js/windows_js_0.96.2/themes/alert_lite.css" rel="stylesheet" type="text/css" >	 </link>
<link href="js/windows_js_0.96.2/themes/debug.css" rel="stylesheet" type="text/css" >	 </link>
</head>

<body>
<div class="body_content" style="height:700px;">
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
                <td width="54%" align="right"> <img src="../../images/refresh.png" alt="Refrescar página" width="48" height="48" /></td>
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
      <h4>Mi cesto de s&iacute;mbolos:&nbsp;</h4>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="5%" align="center" valign="middle">
              <div id="clearCart" onClick="clearCart();"><img src="../../images/trashcan_empty.gif" alt="Vaciar mi cesto de s&iacute;mbolos" title="Vaciar mi cesto de s&iacute;mbolos"/></div>
            <div id="loading"><img src="../../images/indicator.gif" alt="Cargando..." /></div>      </p></td>
            <td width="4%" align="center" valign="middle"><a href="javascript:void(0);" onClick="Dialog.alert({url: 'zip.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:300, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});"><img src="../../images/zip.gif" alt="Comprimir mi cesto en un archivo ZIP" title="Comprimir mi cesto en un archivo ZIP" border="0" /></a></td>
            <td width="91%" align="center" valign="middle">&nbsp;</td>
          </tr>
        </table>
    <div id="cart" style="position:relative; width:98%;"> 
      <ul id="thelist1" style="border:none; width:95%;">
            <?php 
            if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") {
                foreach ($_SESSION['cart'] as $key => $value) {
                
                $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                $ruta=$key['ruta_cesto'];
                $ruta_img='size=30&ruta=../../../../'.$ruta;
                $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
                $ruta_cesto='ruta_cesto='.$ruta;
                $encript->encriptar($ruta_cesto,1); 	
                
				$origen=explode("/",$ruta);
				$n_img=explode(".",$origen[2]);
									
				$datos_img=$query->datos_imagen($n_img[0]);
									
				$ruta_usar_img="img=".$ruta."&id_palabra=".$datos_img['id_palabra'];
				$encript->encriptar($ruta_usar_img,1);
									
                echo "<li id=\"thelist1_".$ruta_cesto."\" style=\"cursor:pointer; background-color:#FFFFFF;\"><a href=\"javascript:void(0);\"><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><a href=\"javascript:void(0);\" onclick=\"clearProduct_herramientas('".$ruta_cesto."');\"><img src=\"../../images/papelera.png\" border=\"0\"/></a>";
				
				if ($origen[0]=='repositorio' &&   $origen[1]=='originales') { 
				
					echo "<a href=\"creador_simbolos/creador_simbolos.php?i=".$ruta_usar_img."\" target=\"_self\" \"><img src=\"../../images/paint.gif\" alt=\"Utilizar imagen en el Creador\" border=\"0\"/></a>";
				
				}
				
				echo "</li>";
                }
            }
            ?>
    </ul>
    </div>
    </div>
    
    <div align="center" class="footer">
      <p><a href="../../index.php">Qu&eacute; es Arasaac</a> | <a href="../../index.php?ref=condiciones_uso_h">Condiciones de Uso</a> | <a href="../../index.php?ref=mapa_web_h">Mapa Web</a><br />
&copy; Herramientas ARASAAC, CATEDU <?php echo date("Y"); ?> | Departamento de Educaci&oacute;n Cultura y Deporte<br />
<a href="http://www.aragob.es" target="_blank"><img src="../../images/minilogo_aragob.gif" alt="Gobierno de Aragón" border="0" tittle="Gobierno de Aragón"/></a></p>
  </div>
  
</div>
</body>
</html>

<?php 
session_start();
include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');


$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$color='#000000';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Herramientas ARASAAC: Creador de Animaciones</title>
<script type="text/javascript" src="../js/ajax_herramientas.js"></script>
<script type="text/javascript" src="../../../js/prototype/prototype.js"> </script> 
<script type="text/javascript" src="../../../js/windows_js_0.96.2/javascripts/effects.js"> </script>
<script type="text/javascript" src="../../../js/windows_js_0.96.2/javascripts/window.js"> </script>
<script type="text/javascript" src="../../../js/windows_js_0.96.2/javascripts/debug.js"> </script>
<script type="text/javascript" src="../../../js/windows_js_0.96.2/javascripts/window_effects.js"> </script> 
    
<link href="../../../js/windows_js_0.96.2/themes/default.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../../js/windows_js_0.96.2/themes/alphacube.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../../js/windows_js_0.96.2/themes/alert.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../../js/windows_js_0.96.2/themes/alert_lite.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../../js/windows_js_0.96.2/themes/spread.css" rel="stylesheet" type="text/css" ></link> 
<link href="../../../js/windows_js_0.96.2/themes/debug.css" rel="stylesheet" type="text/css" ></link>
<link rel="stylesheet" href="../../../css/style.css" type="text/css" />
<link rel="STYLESHEET" type="text/css" href="../js/dhtmlxTabbar/codebase/dhtmlxtabbar.css">

<script  src="../js/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
<script  src="../js/dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
<script  src="../js/dhtmlxTabbar/codebase/dhtmlxtabbar_start.js"></script>

<script type="text/javascript" src="../js/color/picker.js"></script>
</head>
<body>
<form action="generar_panel_rtf.php" method="post" enctype="multipart/form-data" name="generador_paneles" id="generador_paneles">
<div class="body_content" style="height:950px;">
<link rel="STYLESHEET" type="text/css" href="../js/dhtmlxMenu/css/dhtmlXMenu.css">
	<div id="principal">
    
    <div class="left" style="height:900px;">
      <h4>GENERADOR DE PANELES:</h4>
      <div class="left_box">
       <br />
          <div id="b_tabbar" class="dhtmlxTabBar" imgpath="../js/dhtmlxTabbar/codebase/imgs/" style="width:100%; height:850px;"  skinColors="#FCFBFC,#F4F3EE" >
          
                <div id="b1" name="Previsualización" align="left" style="padding:10px;">
                	<div id="animacion" align="center"></div>                  
                </div>
                
		  </div>
      </div>
      </div>	
        <div class="right" style="width:315px;">
        
<div style="display:block; border:1px solid #CCCCCC; width:295px; margin-left:10px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  
  <tr>
    <td>  <div align="center">
            <p>
            <p>
            <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {  ?>
            <strong>Crear panel: </strong><br />
                <select name="desde" id="desde" onChange="procesar('listar_plantillas.php','id='+document.generador_paneles.desde.value+'','mis_selecciones'); procesar('mostrar_opciones_plantilla.php','desde='+document.generador_paneles.desde.value+'','opciones'); procesar('mostrar_opciones_celda.php','desde='+document.generador_paneles.desde.value+'','opciones_celda');">
                  <option value="1">Personalizado</option>
                  <option value="2">Plantilla</option>
                </select>
             <?php } else { ?>
             	   <input name="desde" type="hidden" value="1" />
             <?php } ?>
              <div id="mis_selecciones"><input name="mi_seleccion" type="hidden" value="" /></div>
            </div>
      <div align="center"><div id="loading"><img src="../../../images/loading1.gif" alt="Cargando..." /></div><div id="clearCart"><a href="javascript:void(0);" onClick="generar_animacion(<?php echo $_SESSION['ID_USER']; ?>);"><img src="../../../images/player_play.png" alt="Previsualizar" width="50" height="50" border="0" /></a></div>
      <input type="image" src="../../../images/print_me.jpg" alt="Imprimir"><br />
      </div> </td>
  </tr>
</table>
	</div>
    <br />
    <div id="a_tabbar" class="dhtmlxTabBar" imgpath="../js/dhtmlxTabbar/codebase/imgs/" style="width:290px; height:570px; margin-left:10px;" skinColors="#FCFBFC,#F4F3EE" mode="right">
    
      <!-- PESTAÑA 1 -->
    <div id="a1" name="C" style="padding-left:10px;">
      <div style="display:block;" id="opciones" >
        <p><strong>Configuración del Panel:</strong></p>
        <br />
        <p><strong>Papel:</strong>
          <select name="papel" id="papel">
            <option value="a4h" selected="selected">A4 Horizontal</option>
            <option value="a4v">A4 Vertival</option>
            <option value="a5h">A5 Horizontal</option>
            <option value="a5v">A5 Vertical</option>
                                                                </select> 
          <label></label>
        </p>
        <p><strong>Filas:</strong> 
          <label>
          <input name="filas" type="text" id="filas" size="3" maxlength="2" />
          </label>
        </p>
        <p><strong>Columnas:</strong> 
          <input name="columnas" type="text" id="columnas" size="3" maxlength="2" />
          </p>
        <p><strong>Borde:</strong> 
          <select name="borde" id="borde">
            <option value="1">Marco exterior Tabla</option>
            <option value="2" selected="selected">Tabla y Celdas</option>
                              </select>
          <input name="color_borde" type="text" id="color_borde" value="#000000"  size="3" maxlength="7" disabled="disabled"  style="background-color:#000000;" />
          <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_borde'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="../../../images/color_font.gif" /></a></p>
        <p><strong>Encabezado:</strong> 
          <label>
          <select name="encabezado" id="encabezado">
            <option value="1">Con encabezado</option>
            <option value="0">Sin encabezado</option>
          </select>
          </label>
          <br>	
        </p>
        </div>
    </div>
    
     <!-- **********************************************************************************************  -->
    
      <!-- PESTAÑA 1 -->
    <div id="a2" name="OC" style="padding-left:10px;">
    	<div style="display:block;" id="opciones_celda" >
        </div>
    </div>
    
    </div>  
     
            </div>
             
           <div align="center" class="footer">
              <p>&copy; Herramientas ARASAAC, CATEDU <?php echo date("Y"); ?> | Departamento de Educaci&oacute;n Cultura y Deporte<br />
        <a href="http://www.aragob.es" target="_blank"><img src="../../../images/minilogo_aragob.gif" alt="Gobierno de Aragón" border="0" tittle="Gobierno de Aragón"/></a></p>
          </div>   
        </div>     
    </div>
</div>
</form>
</body>
</html>
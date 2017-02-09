<?php 
session_start();
include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
require ('../../../classes/languages/language_detect.php');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],28);

//DEFINIMOS VARIABLES
$color='#000000';
$thumbnail_size=30;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Herramientas ARASAAC: Creador de Ejercicios</title>
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
<script>
function selydestodos(form,activa)
{
for(i=0;i<form.elements.length;i++)
if(form.elements[i].type=="checkbox")
form.elements[i].checked=activa;
}

function muestra(n){

	cargar_div2('formularios_configuracion.php','id='+n+'','configuracion'); 
 
}
</script>  
</head>
<body>
<div class="body_content">
<div id="principal">
  <form action="generar_rtf.php" method="post" name="seleccion_simbolos" id="seleccion_simbolos">
<div id="mi_repositorio">
 <div style="float:right; font-size:1.1em; width:10%; text-align:center;"><?php if ($_SESSION['language']=='es') { echo '<a href="../../../zona_descargas/documentacion/manual_creador_bingos_es.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } ?></div>
 <h4 style="text-transform:uppercase;"><?php echo $translate['creador_bingos']; ?></h4>
      <table width="100%" border="0">
        <tr>
          <td colspan="2" align="left" valign="top"><div class="left" style="height:400px; width:100%;">
            <div class="left_box">
              <div id="b_tabbar" class="dhtmlxTabBar" imgpath="../js/dhtmlxTabbar/codebase/imgs/" style="width:100%; height:400px;"  skinColors="#FCFBFC,#F4F3EE" >
                
<div id="b2" name="PASO 1" style="padding:10px; text-align:left;">
<table width="100%" border="0">
  <tr>
    <td width="94%"><?php echo $translate['explicacion_ejercicios_paso_1']; ?></td>
    <td width="6%">
    <div id="clearCart"><a href="javascript:void(0);" onclick="Dialog.alert({url: 'uploadcesto.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:500, height:430, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: '<?php echo $translate['cerrar']; ?>', ok:function(win) { cargar_div2('carpeta_trabajo.php','i=','b2'); return true; }});"><img src="../../../images/upload.png" alt="<?php echo $translate['subir_archivos_mi_carpeta_trabajo']; ?>" title="<?php echo $translate['subir_archivos_mi_carpeta_trabajo']; ?>" border="0" /></a></div>
    </td>
  </tr>
</table>
<input name="seleccion_cesto" type="hidden" id="seleccion_cesto" size="100" />
                  <input name="boton_seleccionar_todos" type="button" value="<?php echo $translate['seleccionar_todos']; ?>" class="boton_mediano" onclick="selydestodos(document.seleccion_simbolos,1)"/>
            <input name="boton_seleccionar_todos" type="button" value="<?php echo $translate['deseleccionar_todos']; ?>" class="boton_mediano" onclick="selydestodos(document.seleccion_simbolos,0)"/>
            
                  <ul id="thelist2" style="height:980px; overflow:auto; width:100%; border:none; float:left;">
                    <?php 
								$r=0;
								
                                if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") {

                                    foreach ($_SESSION['cart'] as $key => $value) {
                                    
                                    $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                                    $ruta=$key['ruta_cesto'];
                                    $ruta_img='size='.$thumbnail_size.'&ruta=../../../../'.$ruta;
                                    $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
                                    $ruta_cesto='ruta_cesto='.$ruta;
                                    $encript->encriptar($ruta_cesto,1);
									$extension = strtolower(substr(strrchr($ruta, "."), 1));

									$filename=array_pop(explode('/',$ruta));
									$filaname1=explode('.',$filename);
									$filaname2=$filaname1[0];
									
									$palabras_asociadas=$query->buscar_palabras_asociadas_imagen($filaname2);
									$di=$query->datos_imagen_tipo_imagen($filaname2);
									$pa=mysql_fetch_array($palabras_asociadas);
						
									if ($_SESSION['language']=='es') {
										$palabra_es= utf8_encode($pa['palabra']);
									} elseif ($_SESSION['language']!='es') {
										$traduccion=$query->buscar_traduccion($pa['id_palabra'],$_SESSION['id_language']);
										$datos_palabra=mysql_fetch_array($traduccion);
										$palabra_es=$datos_palabra['traduccion'];
									}

									if ($extension=='jpg' || $extension=='png' || $extension=='gif' || $extension=='jpeg' || $extension=='JPG' || $extension=='GIF' ||$extension=='PNG') {
										echo "<li id=\"thelist2_".$r."\" style=\"cursor:pointer; background-color:#FFFFFF;\" onmousemove=\"populateHiddenVars();\"><a href=\"javascript:void(0);\"><img src=\"";

										if (file_exists('../../../repositorio/thumbs/'.$di['id_tipo_imagen'].'/'.$thumbnail_size.'/'.$filaname2[0].'/'.$filaname2.'.'.$extension)) { 
										echo '../../../repositorio/thumbs/'.$di['id_tipo_imagen'].'/'.$thumbnail_size.'/'.$filaname2[0].'/'.$filaname2.'.'.$extension; 
										
										} else { 
										
										echo '../classes/img/thumbnail.php?i='.$ruta_img.'';
										}
										
										echo "\" border=\"0\"/></a><br><input name=\"usar[".$r."]\" type=\"checkbox\" value=\"".$ruta_cesto."\" /><input name=\"name[".$r."]\" type=\"text\" value=\"".$palabra_es."\"value=\"40\" size=\"11\" /></li>";
										$r++;
										}
                                    }
                                }
								
								if (isset($_SESSION['carpeta_personal']) && $_SESSION['carpeta_personal'] !="") {
									
                                    foreach ($_SESSION['carpeta_personal'] as $key => $value) {
                                    
                                    $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                                    $ruta=$key['ruta_cesto'];
                                    $ruta_img='size='.$thumbnail_size.'&ruta=../../../../'.$ruta;
                                    $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
                                    $ruta_cesto='ruta_cesto='.$ruta;
                                    $encript->encriptar($ruta_cesto,1); 	
                                    
                                    echo "<li id=\"thelist2_".$r."\" style=\"cursor:pointer; background-color:#FFFFFF;\" onmousemove=\"populateHiddenVars();\"><a href=\"javascript:void(0);\"><img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><input name=\"usar[".$r."]\" type=\"checkbox\" value=\"".$ruta_cesto."\" /><input name=\"name[".$r."]\" type=\"text\" value=\"\"value=\"40\" size=\"11\" /></li>";
									$r++;
                                    }
                                }
                                ?>
                    </ul>
                    
                  </div>

<!-- 			PASO 2 					 -->
<!-- *********************************** -->
<div id="b3" name="PASO 2" style="padding:10px; text-align:left;">         
<!--BINGO-->
     
<fieldset>
          <legend><strong><?php echo $translate['configuracion_general']; ?></strong></legend>
          <p><?php echo $translate['borde_tablas_celdas']; ?>:
            <input name="color_borde_tabla" type="text" id="color_borde_tabla" value="#000000"  size="1" maxlength="7" style="background-color:#000000; width:15px;" readonly="readonly" />
            <a href="javascript:TCP.popup(document.forms['seleccion_simbolos'].elements['color_borde_tabla'])"><img width="15" height="15" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/colors.gif" /></a>&nbsp;<?php echo $translate['ancho_borde']; ?>:
            <label>
              <select name="ancho_borde_tabla" id="ancho_borde_tabla">
              <option value="0">0</option>
                <option value="1" selected="selected">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
            </label>
            <select name="tipo_borde_tabla" id="tipo_borde_tabla">
              <option value="single" selected="selected"><?php echo $translate['simple']; ?></option>
              <option value="dot"><?php echo $translate['punteado']; ?></option>
              <option value="dash"><?php echo $translate['linea_discontinua']; ?></option>
              <option value="dotdash"><?php echo $translate['alternando_puntos_guiones']; ?></option>
            </select>
          </p>
          <p>
          <?php echo $translate['texto']; ?>:
            <select name="inf_may" size="1" id="inf_may" class="fonty">
              <option value="0" selected="selected"><?php echo $translate['minusculas']; ?></option>
              <option value="1" selected="selected"><?php echo $translate['mayusculas']; ?></option>
            </select>
            <?php echo $translate['fuente']; ?>:
            <select name="fuente_texto" size="1" id="fuente_texto" class="fonty">
              <option value="Arial" selected="selected">Arial</option>
              <option value="Times">Times</option>
              <option value="Georgia">Georgia</option>
              <option value="Verdana">Verdana</option>
              <option value="Memima">Memima</option>
              <option value="Print Clearly">Print Clearly</option>
              <option value="Comic Sans MS">Comic Sans MS</option>
            </select>
  </p>
</fieldset>
          <br />
          <fieldset>
          <legend><strong><?php echo $translate['configuracion_ejercicio']; ?></strong></legend>
          <p><strong><?php echo $translate['encabezado']; ?>:</strong></p>
          <p>
            <label for="enunciado"><?php echo $translate['enunciado_ejercicio']; ?></label>
            <input name="enunciado" type="text" id="enunciado" value="<?php echo strtoupper_utf8($translate['bingo']); ?>" size="20" />
            <?php echo $translate['color_fondo']; ?>: 
            <input name="color_fondo_cabecera" type="text" id="color_fondo_cabecera" value="#FF6" size="5" maxlength="7" style="background-color:#FF6; width:15px;" />
            <a href="javascript:TCP.popup(document.forms['seleccion_simbolos'].elements['color_fondo_cabecera'])"><img border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/colors.gif" /></a></p>
            <p><?php echo $translate['imagen_categoria']; ?>: <?php echo '<input type="hidden" name="img_0_0_0" id="img_0_0_0" value=""/><a href="javascript:void(0);" onclick="Dialog.alert({url: \'seleccionar_pictograma.php?panel=0&fila=0&columna=0\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:500}, okLabel: \''.$translate['cerrar'].'\'});"><img src="../../../images/dhtmlgoodies_plus.gif" alt="'.$translate['adjuntar_pictograma_celda'].': 0-0-0" title="'.$translate['adjuntar_pictograma_celda'].': 0-0-0" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="eliminar_pictograma_paneles(0,0,0);"><img src="../../../images/dhtmlgoodies_minus.gif" alt="'.$translate['borrar_pictograma_celda'].': 0-0-0" title="'.$translate['borrar_pictograma_celda'].': 0-0-0"  border="0" /></a>&nbsp;&nbsp;';
						
		echo '<input type="hidden" name="txt_0_0_0" id="txt_0_0_0" value=""/><br /><br /><img name="imagen_0_0_0" id="imagen_0_0_0" src="../../../images/empty.jpg" border="0">'; ?></p>
            <p><strong><?php echo $translate['posicion'].' '.$translate['texto']; ?>:</strong>
            <select name="posic_texto_celda" size="1" id="posic_texto_celda">
              <option value="0"><?php echo $translate['sin_texto']; ?></option>
              <option value="1"><?php echo $translate['superior']; ?></option>
              <option value="2" selected="selected"><?php echo $translate['inferior']; ?></option>
            </select>
          </p>
          <p>
            <label for="n_elementos_pag"><strong><?php echo $translate['n_elementos_x_pag']; ?></strong></label>
            <select name="n_elementos_pag" id="n_elementos_pag">
              <option value="6">2x3</option>
              <option value="9" selected="selected">3x3</option>
              <option value="16">4x4</option>
              <option value="25">5x5</option>
            </select> 
            <label for="n_pags"><strong><?php echo "Número de páginas"; ?></strong></label>
            <select name="n_pags" id="n_pags">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected="selected">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="12">12</option>
              <option value="14">14</option>
              <option value="16">16</option>
              <option value="18">18</option>
              <option value="20">20</option>
              <option value="24">24</option>
            </select>
          </p>
</fieldset><br />        
<input name="crear" type="submit" value="<?php echo $translate['generar_bingo']; ?>" style="font-size:24px;" onclick="seleccion_simbolos.action='generar_rtf_8.php'; return true;"/>
</div> 
</td>
        </tr>
        </table>
 </div>
</form>
<div align="center" class="footer">
           <p><b><?php echo $translate['autores_herramienta']; ?>:</b> David Romero <?php echo $translate['y']; ?> José Manuel Marcos</p>
             <p>&copy; <?php echo $translate['herramientas_arasaac_catedu']; ?> <?php echo date("Y"); ?> | <?php echo $translate['dto_educacion']; ?><br />
        <a href="http://www.aragob.es" target="_blank"><img src="../../../images/minilogo_aragob.gif" alt="<?php echo $translate['dto_educacion']; ?>" border="0" title="<?php echo $translate['dto_educacion']; ?>"/></a></p>
          </div>
</div>     
    </div>
</body>
</html>
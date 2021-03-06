<?php 
session_start();
require ('../../../classes/languages/language_detect.php');
include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1);
$color='#000000';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $translate['herramientas_arasaac_catedu']; ?>: <?php echo $translate['generador_horarios']; ?></title>
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
<form action="generar_calendario_rtf.php" method="post" enctype="multipart/form-data" name="generador_paneles" id="generador_paneles">
<div class="body_content" style="height:2200px;">
      <h4><?php echo strtoupper($translate['generador_calendarios']); ?>:
      <div style="float:right; font-size:0.8em;"><?php if ($_SESSION['language']=='es') { echo '<a href="../../../zona_descargas/documentacion/manual_generador_calendarios_es.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } elseif ($_SESSION['language']=='br') { echo '<a href="../../../zona_descargas/documentacion/manual_ferramenta_gerador_calendarios.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } elseif ($_SESSION['language']=='pt') { echo '<a href="../../../zona_descargas/documentacion/manual_ferramenta_gerador_calendarios_pt.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } else { echo '<a href="../../../zona_descargas/documentacion/calendar_generator_tool_manual.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>';  }?></div>
      </h4>
	<div id="principal">
    
    <div style="width:100%;">
     <fieldset>
       <legend><strong><?php echo $translate['configuracion_plantilla']; ?></strong></legend>
       <p><?php echo $translate['mes']; ?>: 
         <label>
           <select name="mes" id="mes">
             <option value="1" <?php if (date("n") ==1) { echo 'selected="selected"'; } ?>><?php echo $translate['enero']; ?></option>
             <option value="2" <?php if (date("n") ==2) { echo 'selected="selected"'; } ?>><?php echo $translate['febrero']; ?></option>
             <option value="3" <?php if (date("n") ==3) { echo 'selected="selected"'; } ?>><?php echo $translate['marzo']; ?></option>
             <option value="4" <?php if (date("n") ==4) { echo 'selected="selected"'; } ?>><?php echo $translate['abril']; ?></option>
             <option value="5" <?php if (date("n") ==5) { echo 'selected="selected"'; } ?>><?php echo $translate['mayo']; ?></option>
             <option value="6" <?php if (date("n") ==6) { echo 'selected="selected"'; } ?>><?php echo $translate['junio']; ?></option>
             <option value="7" <?php if (date("n") ==7) { echo 'selected="selected"'; } ?>><?php echo $translate['julio']; ?></option>
             <option value="8" <?php if (date("n") ==8) { echo 'selected="selected"'; } ?>><?php echo $translate['agosto']; ?></option>
             <option value="9" <?php if (date("n") ==9) { echo 'selected="selected"'; } ?>><?php echo $translate['septiembre']; ?></option>
             <option value="10" <?php if (date("n") ==10) { echo 'selected="selected"'; } ?>><?php echo $translate['octubre']; ?></option>
             <option value="11" <?php if (date("n") ==11) { echo 'selected="selected"'; } ?>><?php echo $translate['noviembre']; ?></option>
             <option value="12" <?php if (date("n") ==12) { echo 'selected="selected"'; } ?>><?php echo $translate['diciembre']; ?></option>
           </select>
         </label>
         <?php echo $translate['year']; ?>
         <label>
           <select name="year" id="year">
             <option value="2010" <?php if (date("Y") ==2010) { echo 'selected="selected"'; } ?>>2010</option>
             <option value="2011" <?php if (date("Y") ==2011) { echo 'selected="selected"'; } ?>>2011</option>
             <option value="2012" <?php if (date("Y") ==2012) { echo 'selected="selected"'; } ?>>2012</option>
             <option value="2013" <?php if (date("Y") ==2013) { echo 'selected="selected"'; } ?>>2013</option>
             <option value="2014" <?php if (date("Y") ==2014) { echo 'selected="selected"'; } ?>>2014</option>
             <option value="2015" <?php if (date("Y") ==2015) { echo 'selected="selected"'; } ?>>2015</option>
             <option value="2016" <?php if (date("Y") ==2016) { echo 'selected="selected"'; } ?>>2016</option>
             <option value="2017" <?php if (date("Y") ==2017) { echo 'selected="selected"'; } ?>>2017</option>
             <option value="2018" <?php if (date("Y") ==2018) { echo 'selected="selected"'; } ?>>2018</option>
             <option value="2019" <?php if (date("Y") ==2019) { echo 'selected="selected"'; } ?>>2019</option>
             <option value="2020" <?php if (date("Y") ==2020) { echo 'selected="selected"'; } ?>>2020</option>
           </select>
         </label>
         &nbsp;<?php echo $translate['idioma']; ?>:
         <select name="idioma" id="idioma">
           <option value="0" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='es') { echo 'selected="selected"'; } ?>><?php echo $translate['spanish']; ?></option>
           <option value="7" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='en') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(7); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="9" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='ca') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(9); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
             <option value="14" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='ga') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(14); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="8" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='fr') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(8); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="11" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='de') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(11); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="12" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='it') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(12); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="13" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='pt') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(13); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="15" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='br') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(15); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="10" <?php if (isset($_GET['idiomasearch']) && $_SESSION['language']=='eu') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(10); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
           </option>
           <option value="2" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='ro') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(2); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="6" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='po') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(6); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="4" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='zh') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(4); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="3" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='ar') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(3); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="1" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='ru') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(1); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
           <option value="5" <?php if (!isset($_GET['idiomasearch']) && $_SESSION['language']=='bg') { echo 'selected="selected"'; } ?>>
             <?php $datos_idioma=$query->datos_idioma_completo(5); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
             </option>
         </select>
<?php echo $translate['encabezado']; ?>:
         <label>
          <select name="encabezado" id="encabezado">
            <option value="1" selected="selected"><?php echo $translate['con_encabezado']; ?></option>
            <option value="0"><?php echo $translate['sin_encabezado']; ?></option>
            </select>
        </label>
       </p>
       <p>
         <label>
           <select name="rellenar_dias" id="rellenar_dias">
             <option value="true" selected="selected">Mostrar</option>
             <option value="false">No mostrar</option>
           </select>
         </label>
         <?php echo $translate['dias_con']; ?>:
<input name="mostrar_imagen_dias" type="checkbox" id="mostrar_imagen_dias" value="1" checked="checked" /> 
<?php echo $translate['imagenes']; ?>
<label>
  <select name="tipo_imagenes_dias" id="tipo_imagenes_dias">
    <option value="1"><?php echo $translate['color']; ?></option>
    <option value="2"><?php echo $translate['byn']; ?></option>
  </select>
</label>
<label>
  <input name="mostrar_text_dias" type="checkbox" id="mostrar_text_dias" value="1" checked="checked" />
</label>
         <?php echo $translate['texto']; ?>
         <input name="rellenar_dias_comenzando" id="rellenar_dias_comenzando" type="hidden" value="0" />
         <br />
         <?php echo $translate['n_dia']; ?>: <?php echo $translate['posicion']; ?>:
         <select name="posic_ndia" size="1" id="posic_ndia">
           <option value="0"><?php echo $translate['sin_n_dia']; ?></option>
           <option value="1" selected="selected"><?php echo $translate['izquierda']; ?></option>
           <option value="2"><?php echo $translate['derecha']; ?></option>
         </select>
         <?php echo $translate['fuente']; ?>:
         <select name="fuente_ndia" size="1" id="fuente_ndia" class="fonty">
           <option value="Arial" selected="selected">Arial</option>
           <option value="Times">Times</option>
           <option value="Georgia">Georgia</option>
           <option value="Verdana">Verdana</option>
           <option value="Memima">Memima</option>
           <option value="Print Clearly">Print Clearly</option>
           <option value="Comic Sans MS">Comic Sans MS</option>
         </select>
         <select name="transform_ndia" size="1" id="transform_ndia" class="fonty">
           <option value="0" selected="selected"><?php echo $translate['normal']; ?></option>
           <option value="1"><?php echo $translate['negrita']; ?></option>
           <option value="2"><?php echo $translate['cursiva']; ?></option>
           <option value="3"><?php echo $translate['negrita_y_cursiva']; ?></option>
         </select>
         <?php echo $translate['size']; ?>:
         <select name="size_font_ndia" size="1" id="size_font_ndia" class="fonty">
           <option value="9">9</option>
           <option value="10">10</option>
           <option value="12">12</option>
           <option value="14" selected="selected">14</option>
           <option value="16">16</option>
           <option value="18">18</option>
           <option value="20">20</option>
           <option value="24">24</option>
           <option value="28">28</option>
           <option value="30">30</option>
           <option value="32">32</option>
           <option value="34">34</option>
           <option value="36">36</option>
           <option value="40">40</option>
           <option value="42">42</option>
           <option value="44">44</option>
           <option value="46">46</option>
           <option value="48">48</option>
           <option value="52">52</option>
           <option value="56">56</option>
           <option value="58">58</option>
           <option value="60">60</option>
           <option value="62">62</option>
           <option value="66">66</option>
           <option value="70">70</option>
         </select>
         <input name="color_texto_ndia" type="text" id="color_texto_ndia" value="#000000"  size="5" maxlength="7" style="background-color:#000000; width:15px; "/>
         <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_texto_ndia'])"><img width="18" height="18" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/color_font.gif" /></a> 
         <br />
         <?php echo $translate['dias_mes_anterior_posterior']; ?>: <?php echo $translate['numeros']; ?>
         <input name="color_texto_ndia_otros_meses" type="text" id="color_texto_ndia_otros_meses" value="#999"  size="5" maxlength="7" style="background-color:#999; width:15px; "/>
         <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_texto_ndia_otros_meses'])"><img width="18" height="18" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/color_font.gif" /></a> <?php echo $translate['fondo_celda']; ?>: 
         <input name="color_fondo_ndia_otros_meses" type="text" id="color_fondo_ndia_otros_meses" value="#F3F3F3"  size="5" maxlength="7" style="background-color:#F3F3F3; width:15px; "/>
         <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_fondo_ndia_otros_meses'])"><img width="15" height="15" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/colors.gif" /></a><br />
         <?php echo $translate['borde_tablas_celdas']; ?>:
         <input name="color_borde_tabla" type="text" id="color_borde_tabla" value="#999999"  size="1" maxlength="7" style="background-color:#999999; width:15px;" readonly="readonly" />
         <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_borde_tabla'])"><img width="15" height="15" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/colors.gif" /></a>&nbsp;<?php echo $translate['ancho_borde']; ?>:
         <label>
           <select name="ancho_borde_tabla" id="ancho_borde_tabla">
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
         <input name="cols" type="hidden" id="cols" size="3" maxlength="2" value="7"/>
         <input name="rows" type="hidden" id="rows" size="3" maxlength="2" value="7"/>
         </p>
       <p>
         <input type="button" name="crear" id="crear" value="<?php echo $translate['generar_plantilla_previa']; ?>" onclick="procesar('mostrar_panel_plantilla.php','rows='+document.generador_paneles.rows.value+'&cols='+document.generador_paneles.cols.value+'&img_size_no_text='+document.generador_paneles.tist.value+'&img_size_with_text='+document.generador_paneles.tict.value+'&default_posicion_texto_celda='+document.generador_paneles.posic_texto_celda.value+'&con_cabecera='+document.generador_paneles.encabezado.value+'&rellenar_dias='+document.generador_paneles.rellenar_dias.value+'&rellenar_dias_comenzando='+document.generador_paneles.rellenar_dias_comenzando.value+'&mostrar_imagen_dias='+document.generador_paneles.mostrar_imagen_dias.value+'&mostrar_imagen_dias='+document.getElementById('mostrar_imagen_dias').checked+'&mostrar_text_dias='+document.getElementById('mostrar_text_dias').checked+'&idioma='+document.generador_paneles.idioma.value+'&tipo_imagenes_dias='+document.generador_paneles.tipo_imagenes_dias.value+'&color_borde_tabla='+document.generador_paneles.color_borde_tabla.value+'&ancho_borde_tabla='+document.generador_paneles.ancho_borde_tabla.value+'&tipo_borde_tabla='+document.generador_paneles.tipo_borde_tabla.value+'&mes='+document.generador_paneles.mes.value+'&year='+document.generador_paneles.year.value+'&posic_ndia='+document.generador_paneles.posic_ndia.value+'&fuente_ndia='+document.generador_paneles.fuente_ndia.value+'&transform_ndia='+document.generador_paneles.transform_ndia.value+'&size_font_ndia='+document.generador_paneles.size_font_ndia.value+'&color_texto_ndia='+document.generador_paneles.color_texto_ndia.value+'&color_texto_ndia_otros_meses='+document.generador_paneles.color_texto_ndia_otros_meses.value+'&color_fondo_ndia_otros_meses='+document.generador_paneles.color_fondo_ndia_otros_meses.value+'','b1');" style="font-size:1.2em;" />
         <br />
       </p>
     </fieldset>
     <fieldset>
     <legend><strong><?php echo $translate['configuracion_general']; ?></strong></legend>
     <p><?php echo $translate['papel']; ?>:
       <select name="papel" id="papel">
         <option value="4" selected="selected">A4</option>
         <option value="3">A3</option>
         <option value="5">A5</option>
       </select>
       <label></label>
<?php echo $translate['orientacion']; ?>:
<select name="orientacion" id="orientacion">
  <option value="1"><?php echo $translate['horizontal']; ?></option>
  <option value="2"><?php echo $translate['vertical']; ?></option>
</select>
<?php echo $translate['altura_celdas']; ?>: 
  <label>
    <select name="ajuste_altura_tabla" id="ajuste_altura_tabla">
      <option value="null" selected="selected"><?php echo $translate['automatico_segun_contenido']; ?></option>
      <option value="+0.5"><?php echo $translate['minimo']; ?> 0.5cm</option>
      <option value="+1"><?php echo $translate['minimo']; ?> 1cm</option>
      <option value="+1.2"><?php echo $translate['minimo']; ?> 1.2cm</option>
      <option value="+1.5"><?php echo $translate['minimo']; ?> 1.5cm</option>
      <option value="+1.8"><?php echo $translate['minimo']; ?> 1.8cm</option>
      <option value="+2"><?php echo $translate['minimo']; ?> 2cm</option>
      <option value="+2.5"><?php echo $translate['minimo']; ?> 2.5cm</option>
      <option value="+3"><?php echo $translate['minimo']; ?> 3cm</option>
      <option value="+4"><?php echo $translate['minimo']; ?> 4cm</option>
      <option value="+5"><?php echo $translate['minimo']; ?> 5cm</option>
      <option value="+6"><?php echo $translate['minimo']; ?> 6cm</option>
      <option value="+7"><?php echo $translate['minimo']; ?> 7cm</option>
      <option value="-0.5"><?php echo $translate['maximo']; ?> 0.5cm</option>
      <option value="-1"><?php echo $translate['maximo']; ?> 1cm</option>
      <option value="-1.2"><?php echo $translate['maximo']; ?> 1.2cm</option>
      <option value="-1.5"><?php echo $translate['maximo']; ?>1.5cm</option>
      <option value="-1.8"><?php echo $translate['maximo']; ?> 1.8cm</option>
      <option value="-2"><?php echo $translate['maximo']; ?> 2cm</option>
      <option value="-2.2"><?php echo $translate['maximo']; ?> 2.2cm</option>
      <option value="-2.4"><?php echo $translate['maximo']; ?> 2.4cm</option>
      <option value="-2.6"><?php echo $translate['maximo']; ?> 2.6cm</option>
      <option value="-2.8"><?php echo $translate['maximo']; ?> 2.8cm</option>
      <option value="-3"><?php echo $translate['maximo']; ?> 3cm</option>
      <option value="-4"><?php echo $translate['maximo']; ?> 4cm</option>
      <option value="-5"><?php echo $translate['maximo']; ?> 5cm</option>
      <option value="-6"><?php echo $translate['maximo']; ?> 6cm</option>
      <option value="-7"><?php echo $translate['maximo']; ?> 7cm</option>
    </select>
  </label><br />
     </p>
</fieldset>  
     <fieldset>
       <legend><strong><?php echo $translate['configuracion_celdas']; ?></strong></legend>
       <p><strong><?php echo $translate['aplicar_configuracion_a']; ?>: 
         <label>
           <select name="aplicar_configuracion_a" id="aplicar_configuracion_a" onchange="mostrar_capa_calendario(''+document.generador_paneles.aplicar_configuracion_a.value+'');">
             <option value="1"><?php echo $translate['cabecera_dias']; ?></option>
             <option value="3"><?php echo $translate['resto_celdas']; ?></option>
             <option value="4" selected="selected"><?php echo $translate['todas_celdas']; ?></option>
           </select>
         </label>
       </strong>       
         
         <input name="n_paneles" type="hidden" id="n_paneles" value="1" />
       </p>
       <div id="1" style="display:none;"> <!-- ABRO LA CAPA 1 -->
       <p><strong><?php echo $translate['texto']; ?>:</strong> <?php echo $translate['posicion']; ?>:
         <select name="posic_texto_celda" size="1" id="posic_texto_celda">
           <option value="0"><?php echo $translate['sin_texto']; ?></option>
           <option value="1"><?php echo $translate['superior']; ?></option>
           <option value="2" selected="selected"><?php echo $translate['inferior']; ?></option>
         </select>
       <?php echo $translate['fuente']; ?>:
       <select name="fuente_texto_celda" size="1" id="fuente_texto_celda" class="fonty">
         <option value="Arial" selected="selected">Arial</option>
         <option value="Times">Times</option>
         <option value="Georgia">Georgia</option>
         <option value="Verdana">Verdana</option>
         <option value="Memima">Memima</option>
       </select>
       <select name="transform_texto_celda" size="1" id="transform_texto_celda" class="fonty">
         <option value="0" selected="selected"><?php echo $translate['normal']; ?></option>
         <option value="1"><?php echo $translate['negrita']; ?></option>
         <option value="2"><?php echo $translate['cursiva']; ?></option>
         <option value="3"><?php echo $translate['negrita_y_cursiva']; ?></option>
       </select>
       <?php echo $translate['size']; ?>:
       <select name="size_font_texto_celda" size="1" id="size_font_texto_celda" class="fonty">
         <option value="9" selected="selected">9</option>
         <option value="10">10</option>
         <option value="12">12</option>
         <option value="14">14</option>
         <option value="16">16</option>
         <option value="18">18</option>
         <option value="20">20</option>
         <option value="24">24</option>
         <option value="28">28</option>
         <option value="30">30</option>
         <option value="32">32</option>
         <option value="34">34</option>
         <option value="36">36</option>
         <option value="40">40</option>
         <option value="42">42</option>
         <option value="44">44</option>
         <option value="46">46</option>
         <option value="48">48</option>
         <option value="52">52</option>
         <option value="56">56</option>
         <option value="58">58</option>
         <option value="60">60</option>
         <option value="62">62</option>
         <option value="66">66</option>
         <option value="70">70</option>
       </select>
       <select name="may_texto_celda" size="1" id="may_texto_celda" class="fonty">
         <option value="0" selected="selected"><?php echo $translate['minusculas']; ?></option>
         <option value="1"><?php echo $translate['mayusculas']; ?></option>
       </select>
       <input name="color_texto_celdas" type="text" id="color_texto_celdas" value="#000000"  size="1" maxlength="7" style="background-color:#000000; width:15px;"/>
       <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_texto_celdas'])"><img width="18" height="18" border="0" alt="<?php echo $translate['seleccione_color_texto']; ?>" title="<?php echo $translate['seleccione_color_texto']; ?>" src="../../../images/color_font.gif" /></a></p>
       <p><strong><?php echo $translate['color_fondo']; ?>: </strong>
         <input name="color_fondo" type="text" id="color_fondo" value="#FFFFFF" size="1" maxlength="7" style="background-color:#FFF; width:15px;" />
         <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_fondo'])"><img width="15" height="15" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/colors.gif" /></a>
         <br /><strong><?php echo $translate['imagen']; ?>:</strong> <?php echo $translate['size_sin_texto']; ?>:
         <select name="tist" size="1" id="tist" class="fonty">
           <option value="1">1</option>
           <option value="1.5">1.5</option>
           <option value="2" selected="selected">2</option>
           <option value="2.5">2.5</option>
           <option value="2.8">2.8</option>
           <option value="3">3</option>
           <option value="3.3">3.3</option>
           <option value="3.6">3.6</option>
           <option value="3.9">3.9</option>
           <option value="4">4</option>
           <option value="4.3">4.3</option>
           <option value="4.6">4.6</option>
           <option value="4.9">4.9</option>
           <option value="5">5</option>
           <option value="5.3">5.3</option>
           <option value="5.6">5.6</option>
           <option value="5.9">5.9</option>
           <option value="6">6</option>
           <option value="6.5">6.5</option>
           <option value="7">7</option>
           <option value="7.5">7.5</option>
           <option value="8">8</option>
           <option value="8.5">8.5</option>
           <option value="9">9</option>
         </select>
         <?php echo $translate['size_con_texto']; ?>:
         <select name="tict" size="1" id="tict">
           <option value="1">1</option>
           <option value="1.5" selected="selected">1.5</option>
           <option value="2">2</option>
           <option value="2.5">2.5</option>
           <option value="2.8">2.8</option>
           <option value="3">3</option>
           <option value="3.3">3.3</option>
           <option value="3.6">3.6</option>
           <option value="3.9">3.9</option>
           <option value="4">4</option>
           <option value="4.3">4.3</option>
           <option value="4.6">4.6</option>
           <option value="4.9">4.9</option>
           <option value="5">5</option>
           <option value="5.3">5.3</option>
           <option value="5.6">5.6</option>
           <option value="5.9">5.9</option>
           <option value="6">6</option>
           <option value="6.5">6.5</option>
           <option value="7">7</option>
           <option value="7.5">7.5</option>
           <option value="8">8</option>
           <option value="8.5">8.5</option>
           <option value="9">9</option>
         </select>
         <br />
         <input type="button" value="<?php echo $translate['aplicar_configuracion_todas_celdas']; ?>" onclick="configurar_todas_celdas_calendario(
   ''+document.generador_paneles.n_paneles.value+'',
   ''+document.generador_paneles.rows.value+'',
   ''+document.generador_paneles.cols.value+'',
   ''+document.generador_paneles.posic_texto_celda.value+'',
   ''+document.generador_paneles.fuente_texto_celda.value+'',
   ''+document.generador_paneles.size_font_texto_celda.value+'',
   ''+document.generador_paneles.may_texto_celda.value+'',
   ''+document.generador_paneles.tist.value+'',
   ''+document.generador_paneles.tict.value+'',
   ''+document.generador_paneles.color_texto_celdas.value+'',
   ''+document.generador_paneles.color_fondo.value+'',
   ''+document.generador_paneles.aplicar_configuracion_a.value+'',
   ''+document.generador_paneles.transform_texto_celda.value+'');" style="font-size:1.2em;"/>
       </p>
</div> <!-- CIERRO LA CAPA 1-->
       
       
       <div id="3" style="display:none;"> <!-- ABRO LA CAPA 3 -->
       <p><strong><?php echo $translate['texto']; ?>:</strong> <?php echo $translate['posicion']; ?>:
         <select name="posic_texto_celda3" size="1" id="posic_texto_celda3">
           <option value="0"><?php echo $translate['sin_texto']; ?></option>
           <option value="1"><?php echo $translate['superior']; ?></option>
           <option value="2" selected="selected"><?php echo $translate['inferior']; ?></option>
         </select>
       <?php echo $translate['fuente']; ?>:
       <select name="fuente_texto_celda3" size="1" id="fuente_texto_celda3" class="fonty">
         <option value="Arial" selected="selected">Arial</option>
         <option value="Times">Times</option>
         <option value="Georgia">Georgia</option>
         <option value="Verdana">Verdana</option>
         <option value="Memima">Memima</option>
       </select>
       <select name="transform_texto_celda3" size="1" id="transform_texto_celda3" class="fonty">
         <option value="0" selected="selected"><?php echo $translate['normal']; ?></option>
         <option value="1"><?php echo $translate['negrita']; ?></option>
         <option value="2"><?php echo $translate['cursiva']; ?></option>
         <option value="3"><?php echo $translate['negrita_y_cursiva']; ?></option>
       </select>
       <?php echo $translate['size']; ?>:
       <select name="size_font_texto_celda3" size="1" id="size_font_texto_celda3" class="fonty">
         <option value="9" selected="selected">9</option>
         <option value="10">10</option>
         <option value="12">12</option>
         <option value="14">14</option>
         <option value="16">16</option>
         <option value="18">18</option>
         <option value="20">20</option>
         <option value="24">24</option>
         <option value="28">28</option>
         <option value="30">30</option>
         <option value="32">32</option>
         <option value="34">34</option>
         <option value="36">36</option>
         <option value="40">40</option>
         <option value="42">42</option>
         <option value="44">44</option>
         <option value="46">46</option>
         <option value="48">48</option>
         <option value="52">52</option>
         <option value="56">56</option>
         <option value="58">58</option>
         <option value="60">60</option>
         <option value="62">62</option>
         <option value="66">66</option>
         <option value="70">70</option>
       </select>
       <select name="may_texto_celda3" size="1" id="may_texto_celda3" class="fonty">
         <option value="0" selected="selected"><?php echo $translate['minusculas']; ?></option>
         <option value="1"><?php echo $translate['mayusculas']; ?></option>
       </select>
       <input name="color_texto_celdas3" type="text" id="color_texto_celdas3" value="#000000"  size="5" maxlength="7" style="background-color:#000000; width:15px;"/>
       <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_texto_celdas3'])"><img width="18" height="18" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/color_font.gif" /></a></p>
       <p><strong><?php echo $translate['color_fondo']; ?>: </strong>
         <input name="color_fondo3" type="text" id="color_fondo3" value="#FFFFFF" size="5" maxlength="7" style="background-color:#FFF; width:15px;" />
         <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_fondo3'])"><img border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/colors.gif" /></a> <strong><br /><?php echo $translate['imagen']; ?>:</strong> <?php echo $translate['size_sin_texto']; ?>:
         <select name="tist3" size="1" id="tist3" class="fonty">
           <option value="1">1</option>
           <option value="1.5">1.5</option>
           <option value="2" selected="selected">2</option>
           <option value="2.5">2.5</option>
           <option value="2.8">2.8</option>
           <option value="3">3</option>
           <option value="3.3">3.3</option>
           <option value="3.6">3.6</option>
           <option value="3.9">3.9</option>
           <option value="4">4</option>
           <option value="4.3">4.3</option>
           <option value="4.6">4.6</option>
           <option value="4.9">4.9</option>
           <option value="5">5</option>
           <option value="5.3">5.3</option>
           <option value="5.6">5.6</option>
           <option value="5.9">5.9</option>
           <option value="6">6</option>
           <option value="6.5">6.5</option>
           <option value="7">7</option>
           <option value="7.5">7.5</option>
           <option value="8">8</option>
           <option value="8.5">8.5</option>
           <option value="9">9</option>
         </select>
       <?php echo $translate['size_con_texto']; ?>:
       <select name="tict3" size="1" id="tict3">
         <option value="1">1</option>
         <option value="1.5" selected="selected">1.5</option>
         <option value="2">2</option>
         <option value="2.5">2.5</option>
         <option value="2.8">2.8</option>
         <option value="3">3</option>
         <option value="3.3">3.3</option>
         <option value="3.6">3.6</option>
         <option value="3.9">3.9</option>
         <option value="4">4</option>
         <option value="4.3">4.3</option>
         <option value="4.6">4.6</option>
         <option value="4.9">4.9</option>
         <option value="5">5</option>
         <option value="5.3">5.3</option>
         <option value="5.6">5.6</option>
         <option value="5.9">5.9</option>
         <option value="6">6</option>
         <option value="6.5">6.5</option>
         <option value="7">7</option>
         <option value="7.5">7.5</option>
         <option value="8">8</option>
         <option value="8.5">8.5</option>
         <option value="9">9</option>
       </select><br />
       <input type="button" value="<?php echo $translate['aplicar_configuracion_todas_celdas']; ?>" onclick="configurar_todas_celdas_calendario(
   ''+document.generador_paneles.n_paneles.value+'',
   ''+document.generador_paneles.rows.value+'',
   ''+document.generador_paneles.cols.value+'',
   ''+document.generador_paneles.posic_texto_celda3.value+'',
   ''+document.generador_paneles.fuente_texto_celda3.value+'',
   ''+document.generador_paneles.size_font_texto_celda3.value+'',
   ''+document.generador_paneles.may_texto_celda3.value+'',
   ''+document.generador_paneles.tist3.value+'',
   ''+document.generador_paneles.tict3.value+'',
   ''+document.generador_paneles.color_texto_celdas3.value+'',
   ''+document.generador_paneles.color_fondo3.value+'',
   ''+document.generador_paneles.aplicar_configuracion_a.value+'',
   ''+document.generador_paneles.transform_texto_celda3.value+'');" style="font-size:1.2em;"/>
       </p>
       </div> <!-- CIERRO LA CAPA 3-->
       
      <div id="4" style="display:block;"> <!-- ABRO LA CAPA 4 -->
       <p><strong><?php echo $translate['texto']; ?>:</strong> <?php echo $translate['posicion']; ?>:
         <select name="posic_texto_celda4" size="1" id="posic_texto_celda4">
           <option value="0"><?php echo $translate['sin_texto']; ?></option>
           <option value="1"><?php echo $translate['superior']; ?></option>
           <option value="2" selected="selected"><?php echo $translate['inferior']; ?></option>
         </select>
       <?php echo $translate['fuente']; ?>:
       <select name="fuente_texto_celda4" size="1" id="fuente_texto_celda4" class="fonty">
         <option value="Arial" selected="selected">Arial</option>
         <option value="Times">Times</option>
         <option value="Georgia">Georgia</option>
         <option value="Verdana">Verdana</option>
         <option value="Memima">Memima</option>
         <option value="Print Clearly">Print Clearly</option>
         <option value="Comic Sans MS">Comic Sans MS</option>
       </select>
       <select name="transform_texto_celda4" size="1" id="transform_texto_celda4" class="fonty">
         <option value="0" selected="selected"><?php echo $translate['normal']; ?></option>
         <option value="1"><?php echo $translate['negrita']; ?></option>
         <option value="2"><?php echo $translate['cursiva']; ?></option>
         <option value="3"><?php echo $translate['negrita_y_cursiva']; ?></option>
       </select>
       <?php echo $translate['size']; ?>:
       <select name="size_font_texto_celda4" size="1" id="size_font_texto_celda4" class="fonty">
         <option value="9" selected="selected">9</option>
         <option value="10">10</option>
         <option value="12">12</option>
         <option value="14">14</option>
         <option value="16">16</option>
         <option value="18">18</option>
         <option value="20">20</option>
         <option value="24">24</option>
         <option value="28">28</option>
         <option value="30">30</option>
         <option value="32">32</option>
         <option value="34">34</option>
         <option value="36">36</option>
         <option value="40">40</option>
         <option value="42">42</option>
         <option value="44">44</option>
         <option value="46">46</option>
         <option value="48">48</option>
         <option value="52">52</option>
         <option value="56">56</option>
         <option value="58">58</option>
         <option value="60">60</option>
         <option value="62">62</option>
         <option value="66">66</option>
         <option value="70">70</option>
       </select>
       <select name="may_texto_celda4" size="1" id="may_texto_celda4" class="fonty">
         <option value="0" selected="selected"><?php echo $translate['minusculas']; ?></option>
         <option value="1"><?php echo $translate['mayusculas']; ?></option>
       </select>
       <input name="color_texto_celdas4" type="text" id="color_texto_celdas4" value="#000000"  size="5" maxlength="7" style="background-color:#000000; width:15px;"/>
       <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_texto_celdas4'])"><img width="18" height="18" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/color_font.gif" /></a></p>
       <p><strong><?php echo $translate['color_fondo']; ?>: </strong>
         <input name="color_fondo4" type="text" id="color_fondo4" value="#FFFFFF" size="5" maxlength="7" style="background-color:#FFF; width:15px;" />
         <a href="javascript:TCP.popup(document.forms['generador_paneles'].elements['color_fondo4'])"><img border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/colors.gif" /></a> <strong><br /><?php echo $translate['imagen']; ?>:</strong> <?php echo $translate['size_sin_texto']; ?>:
         <select name="tist4" size="1" id="tist4" class="fonty">
           <option value="1">1</option>
           <option value="1.5">1.5</option>
           <option value="2" selected="selected">2</option>
           <option value="2.5">2.5</option>
           <option value="2.8">2.8</option>
           <option value="3">3</option>
           <option value="3.3">3.3</option>
           <option value="3.6">3.6</option>
           <option value="3.9">3.9</option>
           <option value="4">4</option>
           <option value="4.3">4.3</option>
           <option value="4.6">4.6</option>
           <option value="4.9">4.9</option>
           <option value="5">5</option>
           <option value="5.3">5.3</option>
           <option value="5.6">5.6</option>
           <option value="5.9">5.9</option>
           <option value="6">6</option>
           <option value="6.5">6.5</option>
           <option value="7">7</option>
           <option value="7.5">7.5</option>
           <option value="8">8</option>
           <option value="8.5">8.5</option>
           <option value="9">9</option>
         </select>
       <?php echo $translate['size_con_texto']; ?>:
       <select name="tict4" size="1" id="tict4">
         <option value="1" selected="selected">1</option>
         <option value="1.5" selected="selected">1.5</option>
         <option value="2">2</option>
         <option value="2.5">2.5</option>
         <option value="2.8">2.8</option>
         <option value="3">3</option>
         <option value="3.3">3.3</option>
         <option value="3.6">3.6</option>
         <option value="3.9">3.9</option>
         <option value="4">4</option>
         <option value="4.3">4.3</option>
         <option value="4.6">4.6</option>
         <option value="4.9">4.9</option>
         <option value="5">5</option>
         <option value="5.3">5.3</option>
         <option value="5.6">5.6</option>
         <option value="5.9">5.9</option>
         <option value="6">6</option>
         <option value="6.5">6.5</option>
         <option value="7">7</option>
         <option value="7.5">7.5</option>
         <option value="8">8</option>
         <option value="8.5">8.5</option>
         <option value="9">9</option>
       </select><br />
       <input type="button" value="<?php echo $translate['aplicar_configuracion_todas_celdas']; ?>" onclick="configurar_todas_celdas_calendario(
   ''+document.generador_paneles.n_paneles.value+'',
   ''+document.generador_paneles.rows.value+'',
   ''+document.generador_paneles.cols.value+'',
   ''+document.generador_paneles.posic_texto_celda4.value+'',
   ''+document.generador_paneles.fuente_texto_celda4.value+'',
   ''+document.generador_paneles.size_font_texto_celda4.value+'',
   ''+document.generador_paneles.may_texto_celda4.value+'',
   ''+document.generador_paneles.tist4.value+'',
   ''+document.generador_paneles.tict4.value+'',
   ''+document.generador_paneles.color_texto_celdas4.value+'',
   ''+document.generador_paneles.color_fondo4.value+'',
   ''+document.generador_paneles.aplicar_configuracion_a.value+'',
   ''+document.generador_paneles.transform_texto_celda4.value+'');" style="font-size:1.2em;"/>
       </p>
       </div> <!-- CIERRO LA CAPA 4-->
     </fieldset> 
     <br />
     
     <div id="a_tabbar" class="dhtmlxTabBar" imgpath="../js/dhtmlxTabbar/codebase/imgs/" style="width:100%;margin-left:10px;" skinColors="#FCFBFC,#F4F3EE" mode="right">
       
       <!-- PESTAÑA 1 -->
</div>  
  </div>
    <!-- **********************************************************************************************  -->               
		<fieldset>
        <legend><strong><?php echo $translate['plantilla_previa']; ?></strong></legend>
                 <div id="b1" name="Previsualización" align="left" style="padding:10px;">
                	<div id="animacion" align="center"></div>                  
                </div>
        </fieldset>	
         <br /> 
           <div align="center" class="footer">
           <p><b><?php echo $translate['autores_herramienta']; ?>:</b> David Romero <?php echo $translate['y']; ?> José Manuel Marcos</p>
             <p>&copy; <?php echo $translate['herramientas_arasaac_catedu']; ?> <?php echo date("Y"); ?> | <?php echo $translate['dto_educacion']; ?><br />
        <a href="http://www.aragob.es" target="_blank"><img src="../../../images/minilogo_aragob.gif" alt="<?php echo $translate['dto_educacion']; ?>" border="0" title="<?php echo $translate['dto_educacion']; ?>"/></a></p>
          </div>   
        </div>     
    </div>
</div>
</form>
</body>
</html>
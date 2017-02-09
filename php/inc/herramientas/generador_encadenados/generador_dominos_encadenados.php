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
$color='#000000';
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

function contar(form) {
  var cont = 0; //Variable que lleva la cuenta de los checkbox pulsados

 for(i=0;i<form.elements.length;i++) {
	if(form.elements[i].type=="checkbox") {
	   if (form.elements[i].checked==1) {
		 cont = cont + 1;
	   }
	}
 }
 
 if (cont < 3) {
	alert('Debe seleccionar al menos 3 imágenes/pictogramas'); 
	return false;
 } else {
	 seleccion_simbolos.action='generar_domino_encadenado.php';
	 form.submit();
	 return true;
 }

}
</script>  
</head>
<body>
<div class="body_content">
<div id="principal">
<form action="" method="post" name="seleccion_simbolos" id="seleccion_simbolos">
<div id="mi_repositorio">
 <div style="float:left; width:90%;"><h4 style="text-transform:uppercase;"><?php echo $translate['generador_dominos_encadenados']; ?></h4></div>
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
                                    $ruta_img='size=30&ruta=../../../../'.$ruta;
                                    $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
                                    $ruta_cesto='ruta_cesto='.$ruta;
                                    $encript->encriptar($ruta_cesto,1);
									$extension = strtolower(substr(strrchr($ruta, "."), 1));

									$filename=array_pop(explode('/',$ruta));
									$filaname1=explode('.',$filename);
									$filaname2=$filaname1[0];
									
									$palabras_asociadas=$query->buscar_palabras_asociadas_imagen($filaname2);
					
									$pa=mysql_fetch_array($palabras_asociadas);
						
									if ($_SESSION['language']=='es') {
										$palabra_es= utf8_encode($pa['palabra']);
									} elseif ($_SESSION['language']!='es') {
										$traduccion=$query->buscar_traduccion($pa['id_palabra'],$_SESSION['id_language']);
										$datos_palabra=mysql_fetch_array($traduccion);
										$palabra_es=$datos_palabra['traduccion'];
									}

									if ($extension=='jpg' || $extension=='png' || $extension=='gif' || $extension=='jpeg' || $extension=='JPG' || $extension=='GIF' ||$extension=='PNG') {
											echo "<li id=\"thelist2_".$r."\" style=\"cursor:pointer; background-color:#FFFFFF;\" onmousemove=\"populateHiddenVars();\"><a href=\"javascript:void(0);\"><img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><input name=\"usar[".$r."]\" type=\"checkbox\" value=\"".$ruta_cesto."\" /><input name=\"name[".$r."]\" type=\"text\" value=\"".$palabra_es."\"value=\"40\" size=\"11\" /></li>";
										$r++;
										}
                                    }
                                }
								
								if (isset($_SESSION['carpeta_personal']) && $_SESSION['carpeta_personal'] !="") {
									
                                    foreach ($_SESSION['carpeta_personal'] as $key => $value) {
                                    
                                    $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                                    $ruta=$key['ruta_cesto'];
                                    $ruta_img='size=30&ruta=../../../../'.$ruta;
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
          <p><?php echo $translate['papel']; ?>:
            <select name="papel" id="papel">
              <option value="4" selected="selected">A4</option>
              <option value="3">A3</option>
            </select>
            <?php echo $translate['orientacion']; ?>:
            <select name="orientacion" id="orientacion">
              <option value="1"><?php echo $translate['horizontal']; ?></option>
              <option value="2" selected="selected"><?php echo $translate['vertical']; ?></option>
            </select>
          </p>
</fieldset>
          <br />
          <fieldset>
          <legend><strong><?php echo $translate['configuracion_domino']; ?></strong></legend>
          <p><strong><?php echo $translate['encabezado']; ?>:</strong></p>
          <p>
            <label for="enunciado"><?php echo $translate['enunciado_ejercicio']; ?></label>
            <input name="enunciado" type="text" id="enunciado" value="" size="60" />
          </p>
          <p>
            <label for="tipo_bingo"><?php echo $translate['tipo_domino']; ?> </label>
            <select name="tipo_bingo" size="1" id="tipo_bingo">
              <option value="1" selected="selected"><?php echo $translate['pictograma_pictograma']; ?></option>
              <option value="2"><?php echo $translate['texto_pictograma']; ?></option>
              <option value="3"><?php echo $translate['mayusculas_minusculas']; ?></option>
              <option value="4"><?php echo $translate['minusculas_mayusculas']; ?></option>
            </select>
            </p>
          <p><?php echo $translate['orientacion_fichas']; ?>:
            <select name="orientacion_ficha" id="orientacion_ficha">
              <option value="1"><?php echo $translate['vertical']; ?></option>
              <option value="2" selected="selected"><?php echo $translate['horizontal']; ?></option>
            </select>
            <label for="tamanyo_ficha"><?php echo $translate['tamanyo_ficha']; ?>:</label>
            <select name="tamanyo_ficha" id="tamanyo_ficha">
              <option value="1" selected="selected"><?php echo $translate['normal']; ?></option>
              <option value="2"><?php echo $translate['grande']; ?></option>
            </select>
            <label for="color_ficha"><?php echo $translate['color_ficha']; ?> </label>
            <select name="color_ficha" size="1" id="color_ficha" class="fonty">
              <option value="#000000" selected="selected"><?php echo $translate['negro']; ?></option>
              <option value="#0000ff"><?php echo $translate['azul']; ?></option>
              <option value="#00ff00"><?php echo $translate['verde']; ?></option>
              <option value="#cc00ff"><?php echo $translate['morado']; ?></option>
              <option value="#ff0000"><?php echo $translate['rojo']; ?></option>
              <option value="#ff00ff"><?php echo $translate['rosa']; ?></option>
              <option value="#ff9900"><?php echo $translate['naranja']; ?></option>
              <option value="#ffff00"><?php echo $translate['amarillo']; ?></option>
            </select>
          </p>
          <p><?php echo $translate['fichas_con_texto']; ?>:
            <select name="inf_may" size="1" id="inf_may" class="fonty">
              <option value="0"><?php echo $translate['minusculas']; ?></option>
              <option value="1" selected="selected"><?php echo $translate['mayusculas']; ?></option>
            </select>
            <?php echo $translate['fuente']; ?>:
            <select name="fuente_texto" size="1" id="fuente_pictogramas" class="fonty">
              <option value="arial" selected="selected">Arial</option>
              <option value="times">Times</option>
              <option value="timesi">Times Cursiva</option>
              <option value="georgia">Georgia</option>
              <option value="georgiab">Georgia Negrita</option>
              <option value="georgiai">Georgia Cursiva</option>
              <option value="verdana">Verdana</option>
              <option value="verdanab">Verdana Negrita</option>
              <option value="verdanai">Verdana Cursiva</option>
              <option value="booescolar8c">Escolar 1</option>
              <option value="edelfontmed">Escolar 2</option>
              <option value="massallerac">Escolar 3</option>
              <option value="Memim">Escolar 4</option>
              <option value="MemimBol">Escolar 4 Negrita</option>
              <option value="escolar4pc">Escolar Punteada</option>
              <option value="PrintClearly_TT">Print Clearly</option>
              <option value="comic">Comic Sans MS</option>
            </select>
<select name="size_font_pictos" size="1" id="size_font_pictos" class="fonty">
  <option value="9">9</option>
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
  <option value="40" selected="selected">40</option>
  <option value="42">42</option>
  <option value="44">44</option>
  <option value="44">46</option>
  <option value="48">48</option>
  <option value="52">52</option>
  <option value="56">56</option>
  <option value="58">58</option>
  <option value="60">60</option>
  <option value="62">62</option>
  <option value="66">66</option>
  <option value="70">70</option>
  <option value="75">75</option>
  <option value="80">80</option>
  <option value="85">85</option>
  <option value="100">100</option>
  <option value="120">120</option>
  <option value="140">140</option>
</select>
          <select name="color_texto" size="1" id="color_texto" class="fonty">
            <option value="#000000" selected="selected"><?php echo $translate['negro']; ?></option>
              <option value="#0000ff"><?php echo $translate['azul']; ?></option>
              <option value="#00ff00"><?php echo $translate['verde']; ?></option>
              <option value="#cc00ff"><?php echo $translate['morado']; ?></option>
              <option value="#ff0000"><?php echo $translate['rojo']; ?></option>
              <option value="#ff00ff"><?php echo $translate['rosa']; ?></option>
              <option value="#ff9900"><?php echo $translate['naranja']; ?></option>
              <option value="#ffff00"><?php echo $translate['amarillo']; ?></option>
          </select>
          </p>
            <p>&nbsp;</p>
          </fieldset>
          <br />        
<input name="crear" type="button" value="<?php echo $translate['generar_domino']; ?>" style="font-size:24px;" onclick="contar(document.seleccion_simbolos);"/>
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
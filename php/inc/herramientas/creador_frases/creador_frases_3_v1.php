<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
$query=new query();
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave


for ($i=0;$i<$_POST['n_elementos'];$i++) {

//Recojo la palabra a insertar en el texto
$frase.=$_POST['p_'.$i.''].'&nbsp;';

}

//Recojo la imagen a insertar
for ($t=0;$t<$_POST['n_elementos'];$t++) {

$imagen[]=$_POST[''.$t.''];

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>Herramientas ARASAAC: Creador de Frases - PASO 3</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="../js/scriptaculous/prototype.js" type="text/javascript"></script>
<script src="../js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script src="../js/scriptaculous/unittest.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/ajax_herramientas.js"></script>
<link rel="stylesheet" href="../../../css/style.css" type="text/css" />
<link rel="STYLESHEET" type="text/css" href="../js/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
<script  src="../js/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
<script  src="../js/dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
<script  src="../js/dhtmlxTabbar/codebase/dhtmlxtabbar_start.js"></script>
<script type="text/javascript" src="../js/color/picker.js"></script>
</head>
<body>
<div class="body_content" style="height:1100px;">
<link rel="STYLESHEET" type="text/css" href="../js/dhtmlxMenu/css/dhtmlXMenu.css">
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXProtobar.js"></script>
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXMenuBar.js"></script>
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXCommon.js"></script>
<form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
<h4>CREADOR DE FRASES: PASO 3</h4>
<p><br />
</p>
<div class="left">
<div align="center">
  <input name="guardar2" type="submit" id="guardar2" value="&lt;&lt; IR AL PASO 1" style="font-size:24px;" onclick="form1.action='creador_frases.php'; return true;" />
  &nbsp;&nbsp;
        <input name="guardar" type="submit" id="guardar" value="<< IR AL PASO 2" style="font-size:24px;" onclick="form1.action='creador_frases_2.php'; return true;" />
      </div>
	<div class="left_box"><br /><br />
    <h4>FRASE A INSERTAR
      <input name="pictcolor" type="hidden" id="pictcolor" value="<?php echo $_POST['pictcolor'];?>" />
      <input type="hidden" name="pictnegro" id="pictnegro" value="<?php echo $_POST['pictnegro'];?>"/>
      <input type="hidden" name="with_imagenes" id="with_imagenes" value="<?php echo $_POST['with_imagenes'];?>"/>
      <input name="mi_seleccion" type="hidden" id="mi_seleccion" value="<?php echo $_POST['mi_seleccion']; ?>"/>
    </h4>
<br />
<p style="font-size:18px;"><?php echo $frase; ?></p><br /><br />
    <h4>IMAGENES/PICTOGRAMAS/PALABRAS: </h4><br />
   		 <div id="frase" align="center">
			<?php 
			
				echo '<div id="products" style="height:5px;" align="left"><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value=""/><input name="imagen_actual" type="hidden" id="imagen_actual" value=""/></form></div>';
				
		  			$o=0;
					echo '<table cellspacing="0" cellpadding="0" width="100%" style="border: 1px solid #999999; padding: 20px;">';
						for ($i=1; $i<=20; $i++){ // FILAS
							echo '<tr align="center" valign="middle">'; 
							for ($e=1; $e<=5; $e++){ //COLUMNAS 
								$file=$imagen[$o];
								if ($file != "") {
								  	if ($file > 0) {
									
									    $row=$query->datos_imagen($file);
									  
									  	$ruta_img='size=50&ruta=../../../../repositorio/originales/'.$row['imagen'];
										$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
										
										$ruta='img=repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
										$encript->encriptar($ruta,1);
										
										$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
										$encript->encriptar($ruta_cesto,1);
						
									  echo '<td style="border:1px dashed #CCCCCC; padding: 10px;"><a href="javascript:void(0);" onclick="Dialog.alert({url: \'imagen.php?i='.$ruta.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="Imagen: '.$file.'" border="0"/></a></td>';
									} else {
									  echo '<td style="border:1px dashed #CCCCCC; padding: 10px;"><span style="font-size:24px">'.$file.'<span /></td>';
									}
								 $o++;  			
								} else { 
								$o++;
								}
						   
							} 
							echo "</tr>"; 
						} 
					echo '</table>';
		  ?>
</div>
<br />
<br />
</div>
</div>	
<div class="right" style="width:295px;">
    <div style="display:block; border:1px solid #CCCCCC; width:280px; margin-left:10px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="33%" align="right"><span class="formw">
      <input type="image" src="../../../images/print_me.jpg" name="convert2" value="IMPRIMIR" onclick="form1.action='../../../plugins/html2ps_v2042/public_html/demo/html2ps.php'; return true;" style="border:none;"/>
    </span></td>
    <td width="18%"><label></label></td>
    <td width="18%" align="center"><div id="loading"><img src="../../../images/loading1.gif" alt="Cargando..." /></div><div id="clearCart"><a href="javascript:void(0);" onclick="previsualizar_frase();"><img src="../../../images/player_play.png" alt="Previsualizar" width="50" height="50" border="0" /></a></div></td>
    <td width="18%" align="center">&nbsp;</td>
    <td width="13%" align="center"><a href="javascript:void(0);" onclick="limpiar_lienzo_creador_simbolos();"><img src="../../../images/trashcan_empty.png" alt="Limpiar área de trabajo" width="50" height="50" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="5" align="center">&nbsp;</td>
    </tr>
</table>
	</div>
    <br>
<div id="a_tabbar" class="dhtmlxTabBar" imgpath="../js/dhtmlxTabbar/codebase/imgs/" style="width:290px; height:790px; margin-left:10px;" skinColors="#FCFBFC,#F4F3EE" mode="right">
    
      <!-- PESTAÑA 1 -->
    <div id="a1" name="T" style="padding-left:10px;">
      <div style="display:block;" id="imagen2" >
        <p><strong>CONTENEDOR DE LA FRASE</strong>
          <input name="imagenes" type="hidden" id="imagenes" value="<?php for ($y=0;$y<$_POST['n_elementos'];$y++) { echo '&thelist2[]='.$_POST[''.$y.'']; }?>" />
          <input name="frase_completa" type="hidden" id="frase_completa" value="<?php echo $frase; ?>" />
          <input name="frase_secciones" type="hidden" id="frase_secciones" value="<?php for ($s=0;$s<$_POST['n_elementos'];$s++) { echo '&thelist3[]='.$_POST['p_'.$s.'']; }?>" />
          <br/>
        </p>
      <p>&nbsp;</p>
      <p><strong>Distribución de la frase:</strong></p>
      <p>Filas
        <input name="filas" type="text" id="filas" value="1" size="3" maxlength="2" />
        <label></label>
        Columnas 
        <input name="columnas" type="text" id="columnas" value="<?php echo $_POST['n_elementos']; ?>" size="3" maxlength="2" />
      </p>
      <p>&nbsp;</p>
      <p><strong>Marco exterior del liezo</strong></p>
      <p>
        <select name="marco" size="1" id="marco" class="fonty">
          <option value="0">Sin marco</option>
          <option value="1" selected="selected">Con marco</option>
        </select>
        <input name="accion" type="hidden" id="accion" value="normal" />
  &nbsp;&nbsp;</p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="46%" valign="middle">Grosor
            <input name="grosor" type="text" id="grosor" value="15" size="3" maxlength="2"/>
            px </td>
          <td width="24%" valign="middle"><div id="color_borde">
            <input name="color_borde_lienzo" type="text" id="color_borde_lienzo" value="#000000" size="7" maxlength="7" readonly="yes" style="background-color:#000000;"/>
          </div></td>
          <td width="30%" valign="middle"><a href="javascript:TCP.popup(document.forms['form1'].elements['color_borde_lienzo'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="../../../images/color_font.gif" /></a></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <p><strong>Tamaño del lienzo contenedor</strong></p>
      <p>Ampliar lienzo:
        <input name="pixels_lienzo" type="text" id="pixels_lienzo" value="200" size="3" maxlength="3"/>
        pixels (entre 1 y 999)</p>
      <p>&nbsp;</p>
      <p><strong>Frase:</strong><br />
        Posición:
        <select name="posic_frase" size="1" id="posic_frase" class="fonty">
          <option value="0">Sin frase</option>
          <option value="1">Superior</option>
          <option value="2" selected="selected">Inferior</option>
          </select>
      </p>
      <p>Fuente: 
        <select name="fuente_frase" size="1" id="fuente_frase" class="fonty">
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
        </select>
      </p>
      <p>Tamaño: 
          <select name="frase_size_font" size="1" id="frase_size_font" class="fonty">
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
                <option value="40">40</option>
                <option value="42">42</option>
                <option value="44">44</option>
                <option value="44">46</option>
                <option value="48">48</option>
                <option value="52">52</option>
                <option value="56">56</option>
                <option value="58">58</option>
                <option value="60"selected="selected">60</option>
                <option value="62">62</option>
                <option value="66">66</option>
                <option value="70">70</option>
                              </select>
            <select name="may_frase" size="1" id="may_frase" class="fonty">
                <option value="0" selected="selected">Min&uacute;sculas</option>
                <option value="1">May&uacute;sculas</option>
                              </select>
            </p>
      <p>
        Color: 
        <input name="color_frase" type="text" id="color_frase" value="#000000" size="7" maxlength="7" readonly="yes"/>
        <a href="javascript:TCP.popup(document.forms['form1'].elements['color_frase'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="../../../images/color_font.gif" /></a> <a href="javascript:TCP.popup(document.forms['form1'].elements['color_sup'])"></a></p>
      <p>&nbsp;</p>
      <p></p>
      <p><br>	
        </p>
      </div>
    </div>
    
     <!-- **********************************************************************************************  -->
     
     <!-- PESTAÑA 2 -->
    <div id="a2" name="S" style="padding-left:10px;">
      <p><strong>SIMBOLOS</strong></p>
      <p>&nbsp;</p>
      <p><strong>Fuente texto símbolos (inferior o superior):</strong></p>
      <p>
        <select name="fuente_simbolo" size="1" id="fuente_simbolo" class="fonty">
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
          </select>
      </p>
      <p>&nbsp; </p>
      <p><strong>Texto superior</strong></p>
      <p>
        <select name="sup_idioma" size="1" id="sup_idioma" class="fonty">
          <option value="0" selected="selected">Sin idioma</option>
          <option value="1">Castellano</option>
        </select>
        <select name="size_font_sup" size="1" id="size_font_sup" class="fonty">
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
          <option value="40">40</option>
          <option value="42">42</option>
          <option value="44">44</option>
          <option value="44">46</option>
          <option value="48">48</option>
          <option value="52">52</option>
          <option value="56">56</option>
          <option value="58">58</option>
          <option value="60"selected="selected">60</option>
          <option value="62">62</option>
          <option value="66">66</option>
          <option value="70">70</option>
        </select>
        <select name="sup_may" size="1" id="sup_may" class="fonty">
          <option value="0" selected="selected">Min&uacute;sculas</option>
          <option value="1">May&uacute;sculas</option>
        </select>
      </p>
      <p>
        <input name="color_sup" type="text" id="color_sup" value="#000000" size="7" maxlength="7" readonly="yes"/>
      <a href="javascript:TCP.popup(document.forms['form1'].elements['color_sup'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="../../../images/color_font.gif" /></a> <a href="javascript:TCP.popup(document.forms['form1'].elements['color_sup'])"></a></p>
      <p>&nbsp;</p>
      <p><strong>Texto inferior</strong></p>
      <p>
        <select name="inf_idioma" size="1" id="inf_idioma" class="fonty">
          <option value="0" selected="selected">Sin idioma</option>
          <option value="1">Castellano</option>
        </select>
        <select name="size_font_inf" size="1" id="size_font_inf" class="fonty">
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
          <option value="40">40</option>
          <option value="42">42</option>
          <option value="44">44</option>
          <option value="44">46</option>
          <option value="48">48</option>
          <option value="52">52</option>
          <option value="56">56</option>
          <option value="58">58</option>
          <option value="60" selected="selected">60</option>
          <option value="62">62</option>
          <option value="66">66</option>
          <option value="70">70</option>
        </select>
        <select name="inf_may" size="1" id="inf_may" class="fonty">
          <option value="0" selected="selected">Min&uacute;sculas</option>
          <option value="1">May&uacute;sculas</option>
        </select>
      </p>
      <p>
        <input name="color_inf" type="text" id="color_inf" value="#000000" size="7" maxlength="7" readonly="yes"/>
        </span> <a href="javascript:TCP.popup(document.forms['form1'].elements['color_inf'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="../../../images/color_font.gif" /></a></p>
      <p>&nbsp;</p>
      <p><strong>Fuente para palabras sin pictograma:</strong></p>
      <p>Texto central que sustituye a la imagen<br />
          <select name="fuente_pictogramas" size="1" id="fuente_pictogramas" class="fonty">
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
              <option value="40">40</option>
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
              <option value="70" selected="selected">70</option>
              <option value="75">75</option>
              <option value="80">80</option>
              <option value="85">85</option>
              <option value="100">100</option>
              <option value="120">120</option>
              <option value="140">140</option>
                  </select>
          <select name="pictos_may" size="1" id="pictos_may" class="fonty">
              <option value="0" selected="selected">Min&uacute;sculas</option>
              <option value="1">May&uacute;sculas</option>
                  </select>
      </p>
      <p>&nbsp;</p>
      <p><strong>Marco exterior del símbolo</strong></p>
      <p>
        <select name="marco_simbolo" size="1" id="marco_simbolo" class="fonty">
          <option value="0">Sin marco</option>
          <option value="1" selected="selected">Con marco</option>
        </select>
        <input name="accion2" type="hidden" id="accion2" value="normal" />
  &nbsp;&nbsp;</p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="46%" valign="middle">Grosor
            <input name="grosor_borde_simbolo" type="text" id="grosor_borde_simbolo" value="9" size="3" maxlength="2"/>
            px </td>
          <td width="24%" valign="middle"><div id="color_borde2">
            <input name="color_borde_simbolo" type="text" id="color_borde_simbolo" value="#000000" size="7" maxlength="7" readonly="yes" style="background-color:#000000;"/>
          </div></td>
          <td width="30%" valign="middle"><a href="javascript:TCP.popup(document.forms['form1'].elements['color_borde_simbolo'])"><img width="18" height="18" border="0" alt="Seleccione el color" src="../../../images/color_font.gif" /></a></td>
        </tr>
      </table>
      <p></p>
      <p>&nbsp;</p>
      <p><strong>Lienzo del símbolo</strong></p>
      <p>Ampliar lienzo:
        <input name="pixels_lienzo_simbolo" type="text" id="pixels_lienzo_simbolo" value="120" size="3" maxlength="3"/>
        pixels (entre 1 y 999)</p>
      <p>&nbsp;</p>
      </div>
     <!-- *******************************************************************  -->
     
     <!-- PESTAÑA 3 -->
    <div id="a3" name="L" style="padding-left:10px;">
      <p><strong>SALIDA</strong></p>
      <p><strong>Formato de salida imagen</strong></p>
      <p>
        <select name="formato_salida" size="1" id="formato_salida" class="fonty">
          <option value="jpg">JPG</option>
          <option value="png" selected="selected">PNG</option>
          <option value="gif">GIF</option>
          <option value="swf">SWF/FLASH</option>
        </select>
      </p>
      <p><strong>Reducir imagen generada</strong> (se recomienda)</p>
      <p>
        <select name="pixels_final" size="1" id="pixels_final" class="fonty">
          <option value="0">No redimensionar</option>
          <option value="100">100</option>
          <option value="150">150</option>
          <option value="200">200</option>
          <option value="250">250</option>
          <option value="300">300</option>
          <option value="350">350</option>
          <option value="400">400</option>
          <option value="450">450</option>
          <option value="500">500</option>
          <option value="600">600</option>
          <option value="700">700</option>
          <option value="800">800</option>
          <option value="1000">1000</option>
          <option value="1200" selected="selected">1200</option>
          <option value="1400">1400</option>
          <option value="1500">1500</option>
          <option value="1700">1700</option>
          <option value="1900">1900</option>
        </select>
      </p>
      <b>Exportar PDF</b>
          <fieldset>
        <legend>&nbsp;Formato</legend>
        <div class="form-row">
        <label class="hand" for="pixel">
        <span class="labl">PIXELS de la P&aacute;gina</a></span></label>
        <span class="formw">
        <select name="pixels" id="pixel">
        <option value="640">640</option>
        <option value="800">800</option>
        <option value="1024">1024</option>
        <option value="1280" selected="selected">1280</option>
        </select>
        <input name="process_mode" type="hidden" id="process_mode" value="single" />
        
        </span></div>
        
        <div class="form-row">
        <label class="hand" for="scalepoint"><span class="labl">Mantener proporcionalidad</a></span></label>
        <span class="formw">
        <input class="nulinp" type="checkbox" name="scalepoints" value="1" checked="checked" id="scalepoint"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="renderi"><span class="labl">Renderizar im&aacute;genes</span></label>
        <span class="formw">
         <input class="nulinp" type="checkbox" name="renderimages" value="1" checked="checked" id="renderi"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="renderi"><span class="labl">Procesar hipervinculos</a></span></label>
        <span class="formw">
         <input class="nulinp" type="checkbox" name="renderlinks" value="1" checked="checked" id="renderl"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="renderf"><span class="labl">Formularios Interactivos</span></label>
        <span class="formw">
        <input class="nulinp" type="checkbox" name="renderforms" value="1" id="renderl"/><sup style="color: red">FPDF/PDFLIB <em>1.6</em> output only!</sup>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="renderi"><span class="labl">Substitute special fields</span></label>
        <span class="formw">
         <input class="nulinp" type="checkbox" name="renderfields" value="1" checked="checked" id="renderl" disabled="disabled"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="medi"><span class="labl">Formato de impresi&oacute;n</span></label>
        <span class="formw">
        <select name="media" id="medi">
        <!--Can use php here to obtain predefined media types OR leave as is-->
        <option value="Letter">Letter</option>
        <option value="Legal">Legal</option>
        <option value="Executive">Executive</option>
        <option value="A0Oversize">A0Oversize</option>
        <option value="A0">A0</option>
        <option value="A1">A1</option>
        <option value="A2">A2</option>
        <option value="A3">A3</option>
        <option value="A4" selected="selected">A4</option>
        <option value="A5">A5</option>
        <option value="B5">B5</option>
        <option value="Folio">Folio</option>
        <option value="A6">A6</option>
        <option value="A7">A7</option>
        <option value="A8">A8</option>
        <option value="A9">A9</option>
        <option value="A10">A10</option>
        <option value="Screenshot640">Image 640&times;480</option>
        <option value="Screenshot800">Image 800&times;600</option>
        <option value="Screenshot1024">Image 1024&times;768</option>
        <!--end php predefined media options if used-->
        </select>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="cssmedia"><span class="labl">CSS</span></label>
        <span class="formw">
        <select name="cssmedia" id="cssmedia" disabled="disabled">
        <option value="handheld">Handheld</option>
        <option value="print">Print</option>
        <option value="projection">Projection</option>
        <option value="Screen" selected="selected">Screen</option>
        <option value="tty">TTY</option>
        <option value="tv">TV</option>
        </select>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="lm"><span class="labl">Margen izquierdo:mm</span></label>
        <span class="formw">
        <input id="lm" type="text" size="3" name="leftmargin" value="30" disabled="disabled"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="rm"><span class="labl">Margen derecho:mm</span></label>
        <span class="formw">
        <input id="rm" type="text" size="3" name="rightmargin" value="15" disabled="disabled"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="tm"><span class="labl">Margen Superior:mm</span></label>
        <span class="formw">
        <input id="tm" type="text" size="3" name="topmargin" value="15" disabled="disabled"/>
        </span>
        </div>
        <div class="form-row">
        <label class="hand" for="bm"><span class="labl">Margen inferior:mm</span></label>
        <span class="formw">
        <input id="bm" type="text" size="3" name="bottommargin" value="15" disabled="disabled"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="automargins"><span class="labl">Auto-size vertical margins</span></label>
        <span class="formw">
        <input id="automargins" class="nulinp" type="checkbox" name="automargins" value="1" disabled="disabled"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="landsc"><span class="labl">Apaisado</span></label>
        <span class="formw">
        <input name="landscape" type="checkbox" class="nulinp" id="landsc" value="1" checked="checked"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="encod"><span class="labl">Codificaci&oacute;n</span></label>
        <span class="formw">
        <select id="encod" name="encoding">
        <option value="" selected="selected">Autodetect</option>
        <option value="utf-8">utf-8</option>
        <option value="iso-8859-1">iso-8859-1</option>
        <option value="iso-8859-2">iso-8859-2</option>
        <option value="iso-8859-3">iso-8859-3</option>
        <option value="iso-8859-4">iso-8859-4</option>
        <option value="iso-8859-5">iso-8859-5</option>
        <option value="iso-8859-6">iso-8859-6</option>
        <option value="iso-8859-7">iso-8859-7</option>
        <option value="iso-8859-9">iso-8859-9</option>
        <option value="iso-8859-10">iso-8859-10</option>
        <option value="iso-8859-11">iso-8859-11</option>
        <option value="iso-8859-13">iso-8859-13</option>
        <option value="iso-8859-14">iso-8859-14</option>
        <option value="iso-8859-15">iso-8859-15</option>
        <option value="windows-1250">windows-1250</option>
        <option value="windows-1251">windows-1251</option>
        <option value="windows-1252">windows-1252</option>
        <option value="koi8-r">koi8-r</option>
        </select>
        </span>
        </div>
        <div class="spacer"></div><br />
        </fieldset>
        
        <fieldset>
        <legend>&nbsp;Formato Archivo&nbsp;</legend>
        <div class="form-row">
        <label class="hand" for="ps"><span class="labl">Salida</span></label>
        <span class="formw">
        <input class="nulinp" type="radio" id="pdf" name="method" value="fpdf" checked="checked" />PDF (FPDF)
        <br />
        <!--<br /><input class="nulinp" type="radio" id="png" name="method" value="pcl"/>PCL <span style="color: red; vertical-align: super; font-size: smaller;">alpha</span>-->
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="ps"><span class="labl">Compatibilidad PDF:</span></label>
        <span class="formw">
        <select name="pdfversion">
        <option value="1.2">PDF 1.2 (NOT supported by PDFLIB!)</b></option>
        <option value="1.3" selected="selected">PDF 1.3 (Acrobat Reader 4)</option>
        <option value="1.4">PDF 1.4 (Acrobat Reader 5)</option>
        <option value="1.5">PDF 1.5 (Acrobat Reader 6)</option>
        </select>
        <br/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="towher"><span class="labl">Destino</span></label>
        <span class="formw">
        <label for="towher1">&nbsp;</label>
        <input name="output" type="radio" class="nulinp" id="towher1" value="1" checked="checked" /> 
        Descargar
        <br /><br />
        </span></div>
        
        <div class="form-row">
        &nbsp;
        <span class="formw">
        <!-- <input class="submit" type="submit" value="Download File (debugging only)" /> -->
        <input class="submit" type="reset"  name="reset"  value="RESETEAR" />
        &nbsp;
        <input class="submit" type="submit" name="convert" value="CONVERTIR" onclick="form1.action='../../../plugins/html2ps_v2042/public_html/demo/html2ps.php'; return true;" />
        </span>
        </div>
        <div class="spacer"></div><br />
	</fieldset>
      </div>
     <!-- *******************************************************************  -->
     
</div>
  
	
</div>
</form>	
<div align="center" class="footer">
      <p><!--<a href="../../../index.php">Qu&eacute; es Arasaac</a> | <a href="../../../index.php?ref=condiciones_uso_h">Condiciones de Uso</a> | <a href="../../../index.php?ref=mapa_web_h">Mapa Web</a><br />-->
&copy; Herramientas ARASAAC, CATEDU <?php echo date("Y"); ?> | Departamento de Educaci&oacute;n Cultura y Deporte<br />
<a href="http://www.aragob.es" target="_blank"><img src="../../../images/minilogo_aragob.gif" alt="Gobierno de Aragón" border="0" tittle="Gobierno de Aragón"/></a></p>
  </div>
</div>	
</div>
</body> 
</html>
<?php 
session_start();
define("MAP_DIR","../../../classes/utf8/MAPPING");
define("CP1250",MAP_DIR . "/CP1250.MAP");
define("CP1251",MAP_DIR . "/CP1251.MAP");
define("CP1252",MAP_DIR . "/CP1252.MAP");
define("CP1253",MAP_DIR . "/CP1253.MAP");
define("CP1254",MAP_DIR . "/CP1254.MAP");
define("CP1255",MAP_DIR . "/CP1255.MAP");
define("CP1256",MAP_DIR . "/CP1256.MAP");
define("CP1257",MAP_DIR . "/CP1257.MAP");
define("CP1258",MAP_DIR . "/CP1258.MAP");
define("CP874", MAP_DIR . "/CP874.MAP");
define("CP932", MAP_DIR . "/CP932.MAP");
define("CP936", MAP_DIR . "/CP936.MAP");
define("CP949", MAP_DIR . "/CP949.MAP");
define("CP950", MAP_DIR . "/CP950.MAP");
define("GB2312", MAP_DIR . "/GB2312.MAP");
define("BIG5", MAP_DIR . "/BIG5.MAP");
include_once('../../../classes/utf8/utf8.class.php');
$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

require ('../../../classes/languages/language_detect.php');
include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1);
$campos_cabecera=array('txt','img');

function sumahoras ($hora1,$hora2){
$hora1=explode(":",$hora1);
$hora2=explode(":",$hora2);
$horas=(int)$hora1[0]+(int)$hora2[0];
$minutos=(int)$hora1[1]+(int)$hora2[1];
$segundos=(int)$hora1[2]+(int)$hora2[2];
$horas+=(int)($minutos/60);
$minutos=(int)($minutos%60)+(int)($segundos/60);
$segundos=(int)($segundos%60);
return (intval($horas)<10?'0'.intval($horas):intval($horas)).':'.($minutos<10?'0'.$minutos:$minutos).':'.($segundos<10?'0'.$segundos:$segundos);
}

$posicion_dias_horas=$_POST['posicion_dias_horas'];
$rellenar_horas=$_POST['rellenar_horas'];
$hora_comienzo=$_POST['hora_comienzo'];
$sumando_horas=$_POST['sumando_horas'];
$unidad_suma_horas=$_POST['unidad_suma_horas'];
$rellenar_dias=$_POST['rellenar_dias'];
$rellenar_dias_comenzando=$_POST['rellenar_dias_comenzando'];
$mostrar_imagen_dias=$_POST['mostrar_imagen_dias'];
$rellenar_dias=$_POST['rellenar_dias'];
$mostrar_text_dias=$_POST['mostrar_text_dias'];
$idioma=$_POST['idioma'];
$tipo_imagenes_dias=$_POST['tipo_imagenes_dias'];
$mostrar_text_horas=$_POST['mostrar_text_horas'];
$tipo_reloj=$_POST['tipo_reloj'];
$ham=0;
$dam=0;
if (isset($_POST['default_borde_celda'])) { $default_borde_celda=$_POST['default_borde_celda']; } else { $default_borde_celda=''; };

if ($unidad_suma_horas=='horas') {
	$cantidad_tiempo_a_sumar=''.$sumando_horas.':00:00';
	$horas=array(12,1,2,3,4,5,6,7,8,9,10,11,12,1,2,3,4,5,6,7,8,9,10,11);
	$horas_digital=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);
} elseif ($unidad_suma_horas=='minutos') {
	$cantidad_tiempo_a_sumar='00:'.$sumando_horas.':00';
}
	
$horatotal = sumahoras($hora_comienzo,$cantidad_tiempo_a_sumar); 

//$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado','Domingo');
$dias = array(211,212,213,214,215,216,217,211,212,213,214,215,216,217,211,212,213,214,215,216,217,211,212,213,214,215,216,217);

if ($tipo_imagenes_dias==1) { 
	$dias_imagenes=array(6554,6557,6563,6536,6629,6605,6478,6554,6557,6563,6536,6629,6605,6478,6554,6557,6563,6536,6629,6605,6478,6554,6557,6563,6536,6629,6605,6478);
} elseif ($tipo_imagenes_dias==2) { 
	$dias_imagenes=array(6796,6799,6804,6778,6867,6844,6728,6796,6799,6804,6778,6867,6844,6728,6796,6799,6804,6778,6867,6844,6728,6796,6799,6804,6778,6867,6844,6728);
}

if ($posicion_dias_horas==1) {
	$filas=$_POST['rows'];
	$columnas=$_POST['cols'];
} elseif ($posicion_dias_horas==2) { 
	$filas=$_POST['cols'];
	$columnas=$_POST['rows'];
}

$p=1; //NO BORRAR
$tablero='<div style="float:right;">
        <a href="javascript:void(0);" onclick="Dialog.alert({url: \'../generador_horarios/uploadcesto.php\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:500, height:430, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \''.$translate['cerrar'].'\', ok:function(win) { cargar_div2(\'creador_animaciones/carpeta_trabajo.php\',\'i=\',\'b2\'); return true; }});"><img src="../../../images/upload.png" alt="'.$translate['subir_archivos_mi_carpeta_trabajo'].'" title="'.$translate['subir_archivos_mi_carpeta_trabajo'].'" border="0" /></a>
		<a href="javascript:void(0);" onclick="generar_animacion('.$_SESSION['ID_USER'].');">
       <input type="image" src="../../../images/player_play.png" alt="'.$translate['generar_horario_RTF'].'" title="'.$translate['generar_horario_RTF'].'"/>
       </a>
     </div>{{0_0_0}}<br /><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" {{borde}}>';
  
	for ($f=1; $f<=$filas+1; $f++){ // FILAS		
		$tablero.='<tr align="center" valign="middle">';
		
		for ($c=1; $c<=$columnas+1; $c++){ //COLUMNAS 
		
			if ($f==1 && $c==1) { 
				$tablero.='<td {{borde}}>{{1_'.$f.'_'.$c.'}}</td>'; 
			} elseif ($c==1 && $f!=1) {
				if ($posicion_dias_horas==1) {
					$tablero.='<td {{borde}} bgcolor="#FFFFCC"><strong>'.$translate['hora'].':</strong><br />{{1_'.$f.'_'.$c.'}}</td>';
				} elseif ($posicion_dias_horas==2) { 
					$tablero.='<td {{borde}} bgcolor="#FFFFCC"><strong>'.$translate['dia'].':</strong><br />{{1_'.$f.'_'.$c.'}}</td>';
				}
			} elseif ($f==1 && $c!=1) {
				if ($posicion_dias_horas==1) {
					$tablero.='<td {{borde}} bgcolor="#FFFFCC"><strong>'.$translate['dia'].':</strong><br />{{1_'.$f.'_'.$c.'}}</td>';
				} elseif ($posicion_dias_horas==2) { 
					$tablero.='<td {{borde}} bgcolor="#FFFFCC"><strong>'.$translate['hora'].':</strong><br />{{1_'.$f.'_'.$c.'}}</td>';
				}
			} else {
				$tablero.='<td {{borde}}>{{1_'.$f.'_'.$c.'}}</td>';
			}			
		}
		$tablero.='</tr>';
	}
					
$tablero.='</table><br /><strong>M</strong>-> '.$translate['marco'].' || <strong>F</strong>-> '.$translate['fondo'].'';


// GESTIONO LA INSERCION DE LOS CAMPOS DE LA CABECERA
//*************************************************************************
if ($_POST['con_cabecera']==1){
	
		for ($v=0; $v<=count($campos_cabecera); $v++){ // CAMPOS A INSERTAR EN LA CABECERA
		
		$f=$campos_cabecera[$v];
		$c=1;
		
		$contenido='';
		
						$contenido.='<input type="hidden" name="img_0_0_0" id="img_0_0_0" value=""/>
						<a href="javascript:void(0);" onclick="Dialog.alert({url: \'seleccionar_pictograma.php?panel=0&fila=0&columna=0\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:500}, okLabel: \''.$translate['cerrar'].'\'});"><img src="../../../images/dhtmlgoodies_plus.gif" alt="'.$translate['adjuntar_pictograma_celda'].': 0-0-0" title="'.$translate['adjuntar_pictograma_celda'].': 0-0-0" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="eliminar_pictograma_paneles(0,0,0);"><img src="../../../images/dhtmlgoodies_minus.gif" alt="'.$translate['borrar_pictograma_celda'].': 0-0-0" title="'.$translate['borrar_pictograma_celda'].': 0-0-0"  border="0" /></a>&nbsp;&nbsp;';
						
						$contenido.='
							<input type="hidden" name="bc_0_0_0" id="bc_0_0_0" value="'.$default_borde_celda.'"/>
							<input type="hidden" name="tbc_0_0_0" id="tbc_0_0_0" value="single"/>
							<input type="hidden" name="abc_0_0_0" id="abc_0_0_0" value="3"/>
							<input type="hidden" name="ptc_0_0_0" id="ptc_0_0_0" value="2"/>
							<input type="hidden" name="ftc_0_0_0" id="ftc_0_0_0" value="Arial"/>';
							$contenido.='<input type="hidden" name="sftc_0_0_0" id="sftc_0_0_0" value="9"/>';
							$contenido.='<input type="hidden" name="mtc_0_0_0" id="mtc_0_0_0" value="0"/>
							<input type="hidden" name="tist_0_0_0" id="tist_0_0_0" value="'.$_POST['img_size_no_text'].'"/>
							<input type="hidden" name="tict_0_0_0" id="tict_0_0_0" value="'.$_POST['img_size_with_text'].'"/>';
						

						
						$contenido.='<br /><br /><img name="imagen_0_0_0" id="imagen_0_0_0" src="../../../images/empty.jpg" border="0">';
					
						
						$contenido.='&nbsp;&nbsp;&nbsp;<strong>'.$translate['cabecera'].':</strong> <input type="text" name="txt_0_0_0" id="txt_0_0_0" value="" size="20"/><input type="text" name="ctc_0_0_0" id="ctc_0_0_0" value="#000000" size="2" maxlength="7" style="background-color:#000000; width:15px;"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_0_0_0\'])"><img width="18" height="18" border="0" alt="'.$translate['seleccione_color_texto'].'" title="'.$translate['seleccione_color_texto'].'" src="../../../images/color_font.gif" /></a>
						'.$translate['fuente'].':
      <select name="ftc_0_0_0" size="1" id="ftc_0_0_0">
          <option value="Arial" selected="selected">Arial</option>
          <option value="Times">Times</option>
          <option value="Georgia">Georgia</option>
          <option value="Verdana">Verdana</option>
          <option value="Memima">Memima</option>
        </select>
      <select name="ttc_0_0_0" size="1" id="ttc_0_0_0">
        <option value="0">'.$translate['normal'].'</option>
        <option value="1" selected="selected">'.$translate['negrita'].'</option>
        <option value="2">'.$translate['cursiva'].'</option>
        <option value="3">'.$translate['negrita_y_cursiva'].'</option>
      </select>
	  '.$translate['size'].':
      <select name="sftc_0_0_0" size="1" id="sftc_0_0_0">
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
          <option value="44">46</option>
          <option value="48">48</option>
          <option value="52">52</option>
          <option value="56">56</option>
          <option value="58">58</option>
      	  <option value="60">60</option>
          <option value="62">62</option>
          <option value="66">66</option>
          <option value="70">70</option>
        </select>
        <select name="mtc_0_0_0" size="1" id="mtc_0_0_0">
          <option value="0" selected="selected">'.$translate['minusculas'].'</option>
          <option value="1">'.$translate['mayusculas'].'</option>
        </select>
    
    <br />';
						
						
						$que[] = "{{0_0_0}}"; 
						$por[] = $contenido; 
						
		
		
		}
		

} else {
	
	$que[] = "{{0_0_0}}"; 
	$por[] = "";
}

if ($posicion_dias_horas==1) { //SI ES 1 EN EL EJE HORIZONTAL EST�N LOS DIAS Y EN EL VERTICAL LAS HORAS
	
		$dam=$rellenar_dias_comenzando;
		
		if ($_POST['tipo_borde_tabla']=='single') { $tipoborde='solid'; }
		elseif ($_POST['tipo_borde_tabla']=='dash') { $tipoborde='dashed'; }
		elseif ($_POST['tipo_borde_tabla']=='dot') { $tipoborde='dotted'; }
		elseif ($_POST['tipo_borde_tabla']=='dotdash') { $tipoborde='dashed'; }
		
		$borde='style="border: '.$_POST['ancho_borde_tabla'].'px '.$tipoborde.' '.$_POST['color_borde_tabla'].';"';
		
			for ($f=1; $f<=$filas+1; $f++){ // FILAS

					for ($c=1; $c<=$columnas+1; $c++){ //COLUMNAS 
						
						$contenido='';
						if ($c==1 && $f!=1 && $rellenar_horas=='true' && $tipo_reloj > 0) {
							
							if ($unidad_suma_horas=='horas') {
								if ($tipo_reloj==1) {
									$ruta_img='ruta=../../../../images/horas/'.$horas[intval($hora_comienzo)].'.png&size=60';
								} elseif ($tipo_reloj==2) {
									$ruta_img='ruta=../../../../images/horas/d'.$horas_digital[intval($hora_comienzo)].'.png&size=60';
								}
							} elseif ($unidad_suma_horas=='minutos') {
								
								$hora_reloj=explode(":",$hora_comienzo);
									if ($hora_reloj[1] != 00) {
										if ($hora_reloj[0]==0) {
											$imagen_hora='0'.intval($hora_reloj[1]);
										} else {
											$imagen_hora=intval($hora_reloj[0].$hora_reloj[1]);
										}
									} elseif ($hora_reloj[1] == 00) {
										$imagen_hora=intval($hora_reloj[0]);	
									}
									
									if ($tipo_reloj==1) {
										if (file_exists('../../../images/horas/'.$imagen_hora.'.png')) { 
											$ruta_img='ruta=../../../../images/horas/'.$imagen_hora.'.png&size=60';
										} else {
											$ruta_img='ruta=../../../../images/empty.jpg&size=60';
										}
									} elseif ($tipo_reloj==2) {
										if (file_exists('../../../images/horas/d'.$imagen_hora.'.png')) { 
											$ruta_img='ruta=../../../../images/horas/d'.$imagen_hora.'.png&size=60';
										} else {
											$ruta_img='ruta=../../../../images/empty.jpg&size=60';
										}
									}
									
							} 

							$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
							$contenido.='<input type="hidden" name="img_'.$p.'_'.$f.'_'.$c.'" id="img_'.$p.'_'.$f.'_'.$c.'" value="'.$ruta_img.'"/>';
						} elseif ($f==1 && $c!=1 && $rellenar_dias=='true' && $mostrar_imagen_dias=='true') {
							$ruta_img='ruta=../../../../repositorio/originales/'.$dias_imagenes[$dam].'.png&size=60';
							$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
							$contenido.='<input type="hidden" name="img_'.$p.'_'.$f.'_'.$c.'" id="img_'.$p.'_'.$f.'_'.$c.'" value="'.$ruta_img.'"/>';
						} elseif ($f==1 && $c==1) {
							$ruta_img='ruta=../../../../repositorio/originales/6012.png&size=60';
							$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
							$contenido.='<input type="hidden" name="img_'.$p.'_'.$f.'_'.$c.'" id="img_'.$p.'_'.$f.'_'.$c.'" value="'.$ruta_img.'"/>';
						} else { 
						
							$contenido.='<input type="hidden" name="img_'.$p.'_'.$f.'_'.$c.'" id="img_'.$p.'_'.$f.'_'.$c.'" value=""/>'; 
						}
							
						$contenido.='<a href="javascript:void(0);" onclick="Dialog.alert({url: \'seleccionar_pictograma.php?panel='.$p.'&fila='.$f.'&columna='.$c.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:500}, okLabel: \''.$translate['cerrar'].'\'});"><img src="../../../images/dhtmlgoodies_plus.gif" alt="'.$translate['adjuntar_pictograma_celda'].': '.$p.'-'.$f.'-'.$c.'" title="'.$translate['adjuntar_pictograma_celda'].': '.$p.'-'.$f.'-'.$c.'" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="eliminar_pictograma_paneles('.$p.','.$f.','.$c.');"><img src="../../../images/dhtmlgoodies_minus.gif" alt="'.$translate['borrar_pictograma_celda'].': '.$p.'-'.$f.'-'.$c.'" title="'.$translate['borrar_pictograma_celda'].': '.$p.'-'.$f.'-'.$c.'"  border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="copiar_contenido_celda('.($filas+1).','.($columnas+1).','.$p.','.$f.','.$c.');"><img src="../../../images/copy.gif" alt="'.$translate['copiar_contenido_celda'].': '.$p.'-'.$f.'-'.$c.'" title="'.$translate['copiar_contenido_celda'].': '.$p.'-'.$f.'-'.$c.'"  border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="pegar_contenido_celda('.$p.','.$f.','.$c.');"><img src="../../../images/ed_paste.gif" alt="'.$translate['pegar_contenido_portapapeles_a_celda'].': '.$p.'-'.$f.'-'.$c.'" title="'.$translate['pegar_contenido_portapapeles_a_celda'].': '.$p.'-'.$f.'-'.$c.'"  border="0" /></a>';
						
						//$contenido.='<a href="javascript:void(0);" onclick="Dialog.alert({url: \'configurar_celda.php?panel='.$p.'&fila='.$f.'&columna='.$c.'&bc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.bc_'.$p.'_'.$f.'_'.$c.'.value+\'&abc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.abc_'.$p.'_'.$f.'_'.$c.'.value+\'&ptc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.ptc_'.$p.'_'.$f.'_'.$c.'.value+\'&ftc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.ftc_'.$p.'_'.$f.'_'.$c.'.value+\'&sftc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.sftc_'.$p.'_'.$f.'_'.$c.'.value+\'&mtc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.mtc_'.$p.'_'.$f.'_'.$c.'.value+\'&tist_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.tist_'.$p.'_'.$f.'_'.$c.'.value+\'&tict_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.tict_'.$p.'_'.$f.'_'.$c.'.value+\'&tbc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.tbc_'.$p.'_'.$f.'_'.$c.'.value+\'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:300, height:350}, okLabel: \'Cerrar\'});"><img border="0" alt="Configurar Celda"  title="Configurar Celda" src="../../../images/vcard_edit.png" /></a>';
						
						$contenido.='<input type="hidden" name="bc_'.$p.'_'.$f.'_'.$c.'" id="bc_'.$p.'_'.$f.'_'.$c.'" value="1"/>
							<input type="hidden" name="tbc_'.$p.'_'.$f.'_'.$c.'" id="tbc_'.$p.'_'.$f.'_'.$c.'" value="'.$_POST['tipo_borde_tabla'].'"/>
							<input type="hidden" name="abc_'.$p.'_'.$f.'_'.$c.'" id="abc_'.$p.'_'.$f.'_'.$c.'" value="'.$_POST['ancho_borde_tabla'].'"/>
							<input type="hidden" name="ptc_'.$p.'_'.$f.'_'.$c.'" id="ptc_'.$p.'_'.$f.'_'.$c.'" value="'.$_POST['default_posicion_texto_celda'].'"/>
							<input type="hidden" name="ftc_'.$p.'_'.$f.'_'.$c.'" id="ftc_'.$p.'_'.$f.'_'.$c.'" value="Arial"/>
							<input type="hidden" name="sftc_'.$p.'_'.$f.'_'.$c.'" id="sftc_'.$p.'_'.$f.'_'.$c.'" value="10"/>
							<input type="hidden" name="mtc_'.$p.'_'.$f.'_'.$c.'" id="mtc_'.$p.'_'.$f.'_'.$c.'" value="0"/>
							<input type="hidden" name="ttc_'.$p.'_'.$f.'_'.$c.'" id="ttc_'.$p.'_'.$f.'_'.$c.'" value="0"/>
							<input type="hidden" name="tist_'.$p.'_'.$f.'_'.$c.'" id="tist_'.$p.'_'.$f.'_'.$c.'" value="'.$_POST['img_size_no_text'].'"/>
							<input type="hidden" name="tict_'.$p.'_'.$f.'_'.$c.'" id="tict_'.$p.'_'.$f.'_'.$c.'" value="'.$_POST['img_size_with_text'].'"/>
							<input type="hidden" name="portapapeles_img_'.$p.'_'.$f.'_'.$c.'" id="portapapeles_img_'.$p.'_'.$f.'_'.$c.'" value=""/>
							<input type="hidden" name="portapapeles_txt_'.$p.'_'.$f.'_'.$c.'" id="portapapeles_txt_'.$p.'_'.$f.'_'.$c.'" value=""/>';
						
						if ($c==1 && $f!=1 && $rellenar_horas=='true' && $tipo_reloj > 0) {
							$contenido.='<br /><br /><img name="imagen_'.$p.'_'.$f.'_'.$c.'" id="imagen_'.$p.'_'.$f.'_'.$c.'" src="../classes/img/thumbnail.php?i='.$ruta_img.'" border="0">';
						} elseif ($f==1 && $c!=1 && $rellenar_dias=='true' && $mostrar_imagen_dias=='true') {
						   $contenido.='<br /><br /><img name="imagen_'.$p.'_'.$f.'_'.$c.'" id="imagen_'.$p.'_'.$f.'_'.$c.'" src="../classes/img/thumbnail.php?i='.$ruta_img.'" border="0">';
						} elseif ($f==1 && $c==1) {
							$contenido.='<br /><br /><img name="imagen_'.$p.'_'.$f.'_'.$c.'" id="imagen_'.$p.'_'.$f.'_'.$c.'" src="../classes/img/thumbnail.php?i='.$ruta_img.'" border="0">';
						} else { 
						   $contenido.='<br /><br /><img name="imagen_'.$p.'_'.$f.'_'.$c.'" id="imagen_'.$p.'_'.$f.'_'.$c.'" src="../../../images/empty.jpg" border="0">';
						}
						
						if ($c==1 && $f!=1 && $rellenar_horas=='true' && $mostrar_text_horas=='true') {
							if ($c==1 && $f==2) {
								$contenido.='<br /><input type="text" name="txt_'.$p.'_'.$f.'_'.$c.'" id="txt_'.$p.'_'.$f.'_'.$c.'" value="'.$hora_comienzo.'" style="width:60%;"/><input type="text" name="ctc_'.$p.'_'.$f.'_'.$c.'" id="ctc_'.$p.'_'.$f.'_'.$c.'" value="#000000" style="background-color:#000000; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="'.$translate['seleccione_color_texto'].'" title="'.$translate['seleccione_color_texto'].'" src="../../../images/color_font.gif" /></a>';
							} else {
								$contenido.='<br /><input type="text" name="txt_'.$p.'_'.$f.'_'.$c.'" id="txt_'.$p.'_'.$f.'_'.$c.'" value="'.substr ($hora_comienzo, 0, strlen($hora_comienzo) - 3).'" style="width:60%;"/><input type="text" name="ctc_'.$p.'_'.$f.'_'.$c.'" id="ctc_'.$p.'_'.$f.'_'.$c.'" value="#000000" style="background-color:#000000; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="'.$translate['seleccione_color_texto'].'" title="'.$translate['seleccione_color_texto'].'" src="../../../images/color_font.gif" /></a>';
								
							}
							
						$hora_comienzo=sumahoras($hora_comienzo,$cantidad_tiempo_a_sumar);
						
						} elseif ($c==1 && $f!=1 && $rellenar_horas=='true' && $mostrar_text_horas!='true') {

							if ($c==1 && $f==2) {
								$contenido.='<br /><input type="text" name="txt_'.$p.'_'.$f.'_'.$c.'" id="txt_'.$p.'_'.$f.'_'.$c.'" value="" style="width:60%;"/><input type="text" name="ctc_'.$p.'_'.$f.'_'.$c.'" id="ctc_'.$p.'_'.$f.'_'.$c.'" value="#000000" style="background-color:#000000; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="'.$translate['seleccione_color_texto'].'" title="'.$translate['seleccione_color_texto'].'" src="../../../images/color_font.gif" /></a>';
							} else {
								$contenido.='<br /><input type="text" name="txt_'.$p.'_'.$f.'_'.$c.'" id="txt_'.$p.'_'.$f.'_'.$c.'" value="" style="width:60%;"/><input type="text" name="ctc_'.$p.'_'.$f.'_'.$c.'" id="ctc_'.$p.'_'.$f.'_'.$c.'" value="#000000" style="background-color:#000000; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="'.$translate['seleccione_color_texto'].'" title="'.$translate['seleccione_color_texto'].'" src="../../../images/color_font.gif" /></a>';
								
							}
							
						} elseif ($f==1 && $c!=1 && $rellenar_dias=='true' && $mostrar_text_dias=='true') {
							if ($idioma==0) {
								$row_palabra=$query->datos_palabra($dias[$dam]);
								$dia_a_mostrar=utf8_encode($row_palabra['palabra']);
							} elseif ($idioma==1 || $idioma==5) {
								$query_palabra=$query->buscar_traduccion($dias[$dam],$idioma);
								$row_palabra=mysql_fetch_array($query_palabra); 
								$dia_a_mostrar=$utfConverter_ru->strToUtf8($row_palabra['traduccion']);
							} elseif ($idioma==3) {
								$query_palabra=$query->buscar_traduccion($dias[$dam],$idioma);
								$row_palabra=mysql_fetch_array($query_palabra);
								$dia_a_mostrar=$utfConverter->strToUtf8($row_palabra['traduccion']);
							} else {
								$query_palabra=$query->buscar_traduccion($dias[$dam],$idioma);
								$row_palabra=mysql_fetch_array($query_palabra);
								$dia_a_mostrar=$row_palabra['traduccion'];
							}
							
						$contenido.='<br /><input type="text" name="txt_'.$p.'_'.$f.'_'.$c.'" id="txt_'.$p.'_'.$f.'_'.$c.'" value="'.$dia_a_mostrar.'" style="width:60%;"/><input type="text" name="ctc_'.$p.'_'.$f.'_'.$c.'" id="ctc_'.$p.'_'.$f.'_'.$c.'" value="#000000" style="background-color:#000000; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="'.$translate['seleccione_color_texto'].'" title="'.$translate['seleccione_color_texto'].'" src="../../../images/color_font.gif" /></a>';

						} else { 
						$contenido.='<br /><input type="text" name="txt_'.$p.'_'.$f.'_'.$c.'" id="txt_'.$p.'_'.$f.'_'.$c.'" value="" style="width:60%;"/><input type="text" name="ctc_'.$p.'_'.$f.'_'.$c.'" id="ctc_'.$p.'_'.$f.'_'.$c.'" value="#000000" style="background-color:#000000; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="'.$translate['seleccione_color_texto'].'" title="'.$translate['seleccione_color_texto'].'" src="../../../images/color_font.gif" /></a>';
						}

						$contenido.='<br /><b><a alt="'.$translate['marco'].'" title="'.$translate['marco'].'">M</a>:</b> <input type="text" name="cbc_'.$p.'_'.$f.'_'.$c.'" id="cbc_'.$p.'_'.$f.'_'.$c.'" value="'.$_POST['color_borde_tabla'].'" style="background-color:'.$_POST['color_borde_tabla'].'; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'cbc_'.$p.'_'.$f.'_'.$c.'\'])">&nbsp;<img border="0" alt="'.$translate['seleccione_color_marco'].'" title="'.$translate['seleccione_color_marco'].'" src="../../../images/colors.gif" /></a>';
						
						$contenido.='&nbsp;<b><a alt=alt="'.$translate['fondo'].'" title="'.$translate['fondo'].'">F:</a></b> <input type="text" name="cfc_'.$p.'_'.$f.'_'.$c.'" id="cfc_'.$p.'_'.$f.'_'.$c.'" value="#FFFFFF" style="background-color:#FFF; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'cfc_'.$p.'_'.$f.'_'.$c.'\'])">&nbsp;<img border="0" alt="'.$translate['seleccione_color_fondo_celda'].'" title="'.$translate['seleccione_color_fondo_celda'].'" src="../../../images/colors.gif" /></a>';
						
						if ($f==1 && $c!=1 && $rellenar_dias=='true') {
							$dam=$dam+1;
							$ham=$ham+1;
						}
						
						$que[] = "{{".$p."_".$f."_".$c."}}"; 
						$por[] = $contenido; 
					} 
					
			}

} elseif ($posicion_dias_horas==2) { //SI ES 2 EN EL EJE HORIZONTAL EST�N LAS HORAS Y EN EL VERTICAL LOS DIAS

		$dam=$rellenar_dias_comenzando;
		if ($_POST['tipo_borde_tabla']=='single') { $tipoborde='solid'; }
		elseif ($_POST['tipo_borde_tabla']=='dash') { $tipoborde='dashed'; }
		elseif ($_POST['tipo_borde_tabla']=='dot') { $tipoborde='dotted'; }
		elseif ($_POST['tipo_borde_tabla']=='dotdash') { $tipoborde='dashed'; }
		
		$borde='style="border: '.$_POST['ancho_borde_tabla'].'px '.$tipoborde.' '.$_POST['color_borde_tabla'].';"';
		
			for ($f=1; $f<=$filas+1; $f++){ // FILAS

					for ($c=1; $c<=$columnas+1; $c++){ //COLUMNAS 
						
						$contenido='';
						if ($f==1 && $c!=1 && $rellenar_horas=='true' && $tipo_reloj > 0) {
							
							if ($unidad_suma_horas=='horas') {
								if ($tipo_reloj==1) {
									$ruta_img='ruta=../../../../images/horas/'.$horas[intval($hora_comienzo)].'.png&size=60';
								} elseif ($tipo_reloj==2) {
									$ruta_img='ruta=../../../../images/horas/d'.$horas_digital[intval($hora_comienzo)].'.png&size=60';
								}
							} elseif ($unidad_suma_horas=='minutos') {
								
								$hora_reloj=explode(":",$hora_comienzo);
									if ($hora_reloj[1] != 00) {
										if ($hora_reloj[0]==0) {
											$imagen_hora='0'.intval($hora_reloj[1]);
										} else {
											$imagen_hora=intval($hora_reloj[0].$hora_reloj[1]);
										}
									} elseif ($hora_reloj[1] == 00) {
										$imagen_hora=intval($hora_reloj[0]);	
									}
									
									if ($tipo_reloj==1) {
										if (file_exists('../../../images/horas/'.$imagen_hora.'.png')) { 
											$ruta_img='ruta=../../../../images/horas/'.$imagen_hora.'.png&size=60';
										} else {
											$ruta_img='ruta=../../../../images/empty.jpg&size=60';
										}
									} elseif ($tipo_reloj==2) {
										if (file_exists('../../../images/horas/d'.$imagen_hora.'.png')) { 
											$ruta_img='ruta=../../../../images/horas/d'.$imagen_hora.'.png&size=60';
										} else {
											$ruta_img='ruta=../../../../images/empty.jpg&size=60';
										}
									}
									
							} 

							$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
							$contenido.='<input type="hidden" name="img_'.$p.'_'.$f.'_'.$c.'" id="img_'.$p.'_'.$f.'_'.$c.'" value="'.$ruta_img.'"/>';
						} elseif ($c==1 && $f!=1 && $rellenar_dias=='true' && $mostrar_imagen_dias=='true') {
							$ruta_img='ruta=../../../../repositorio/originales/'.$dias_imagenes[$dam].'.png&size=60';
							$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
							$contenido.='<input type="hidden" name="img_'.$p.'_'.$f.'_'.$c.'" id="img_'.$p.'_'.$f.'_'.$c.'" value="'.$ruta_img.'"/>';
						} elseif ($f==1 && $c==1) {
							$ruta_img='ruta=../../../../repositorio/originales/6012.png&size=60';
							$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
							$contenido.='<input type="hidden" name="img_'.$p.'_'.$f.'_'.$c.'" id="img_'.$p.'_'.$f.'_'.$c.'" value="'.$ruta_img.'"/>';
						} else { 
						
							$contenido.='<input type="hidden" name="img_'.$p.'_'.$f.'_'.$c.'" id="img_'.$p.'_'.$f.'_'.$c.'" value=""/>'; 
						}
							
						$contenido.='<a href="javascript:void(0);" onclick="Dialog.alert({url: \'seleccionar_pictograma.php?panel='.$p.'&fila='.$f.'&columna='.$c.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:500}, okLabel: \'Cerrar\'});"><img src="../../../images/dhtmlgoodies_plus.gif" alt="'.$translate['adjuntar_pictograma_celda'].': '.$p.'-'.$f.'-'.$c.'" title="'.$translate['adjuntar_pictograma_celda'].': '.$p.'-'.$f.'-'.$c.'" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="eliminar_pictograma_paneles('.$p.','.$f.','.$c.');"><img src="../../../images/dhtmlgoodies_minus.gif" alt="'.$translate['borrar_pictograma_celda'].': '.$p.'-'.$f.'-'.$c.'" title="'.$translate['borrar_pictograma_celda'].': '.$p.'-'.$f.'-'.$c.'"  border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="copiar_contenido_celda('.($filas+1).','.($columnas+1).','.$p.','.$f.','.$c.');"><img src="../../../images/copy.gif" alt="'.$translate['copiar_contenido_celda'].': '.$p.'-'.$f.'-'.$c.'" title="'.$translate['copiar_contenido_celda'].': '.$p.'-'.$f.'-'.$c.'"  border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="pegar_contenido_celda('.$p.','.$f.','.$c.');"><img src="../../../images/ed_paste.gif" alt="'.$translate['pegar_contenido_portapapeles_a_celda'].': '.$p.'-'.$f.'-'.$c.'" title="'.$translate['pegar_contenido_portapapeles_a_celda'].': '.$p.'-'.$f.'-'.$c.'"  border="0" /></a>';
						
						//$contenido.='<a href="javascript:void(0);" onclick="Dialog.alert({url: \'configurar_celda.php?panel='.$p.'&fila='.$f.'&columna='.$c.'&bc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.bc_'.$p.'_'.$f.'_'.$c.'.value+\'&abc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.abc_'.$p.'_'.$f.'_'.$c.'.value+\'&ptc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.ptc_'.$p.'_'.$f.'_'.$c.'.value+\'&ftc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.ftc_'.$p.'_'.$f.'_'.$c.'.value+\'&sftc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.sftc_'.$p.'_'.$f.'_'.$c.'.value+\'&mtc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.mtc_'.$p.'_'.$f.'_'.$c.'.value+\'&tist_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.tist_'.$p.'_'.$f.'_'.$c.'.value+\'&tict_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.tict_'.$p.'_'.$f.'_'.$c.'.value+\'&tbc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.tbc_'.$p.'_'.$f.'_'.$c.'.value+\'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:300, height:350}, okLabel: \'Cerrar\'});"><img border="0" alt="Configurar Celda"  title="Configurar Celda" src="../../../images/vcard_edit.png" /></a>';
						
						$contenido.='<input type="hidden" name="bc_'.$p.'_'.$f.'_'.$c.'" id="bc_'.$p.'_'.$f.'_'.$c.'" value="0"/>
							<input type="hidden" name="tbc_'.$p.'_'.$f.'_'.$c.'" id="tbc_'.$p.'_'.$f.'_'.$c.'" value="single"/>
							<input type="hidden" name="abc_'.$p.'_'.$f.'_'.$c.'" id="abc_'.$p.'_'.$f.'_'.$c.'" value="2"/>
							<input type="hidden" name="ptc_'.$p.'_'.$f.'_'.$c.'" id="ptc_'.$p.'_'.$f.'_'.$c.'" value="'.$_POST['default_posicion_texto_celda'].'"/>
							<input type="hidden" name="ftc_'.$p.'_'.$f.'_'.$c.'" id="ftc_'.$p.'_'.$f.'_'.$c.'" value="Arial"/>
							<input type="hidden" name="sftc_'.$p.'_'.$f.'_'.$c.'" id="sftc_'.$p.'_'.$f.'_'.$c.'" value="10"/>
							<input type="hidden" name="mtc_'.$p.'_'.$f.'_'.$c.'" id="mtc_'.$p.'_'.$f.'_'.$c.'" value="0"/>
							<input type="hidden" name="ttc_'.$p.'_'.$f.'_'.$c.'" id="ttc_'.$p.'_'.$f.'_'.$c.'" value="0"/>
							<input type="hidden" name="tist_'.$p.'_'.$f.'_'.$c.'" id="tist_'.$p.'_'.$f.'_'.$c.'" value="'.$_POST['img_size_no_text'].'"/>
							<input type="hidden" name="tict_'.$p.'_'.$f.'_'.$c.'" id="tict_'.$p.'_'.$f.'_'.$c.'" value="'.$_POST['img_size_with_text'].'"/>
							<input type="hidden" name="portapapeles_img_'.$p.'_'.$f.'_'.$c.'" id="portapapeles_img_'.$p.'_'.$f.'_'.$c.'" value=""/>
							<input type="hidden" name="portapapeles_txt_'.$p.'_'.$f.'_'.$c.'" id="portapapeles_txt_'.$p.'_'.$f.'_'.$c.'" value=""/>';
						
						if ($f==1 && $c!=1 && $rellenar_horas=='true' && $tipo_reloj > 0) {
							$contenido.='<br /><br /><img name="imagen_'.$p.'_'.$f.'_'.$c.'" id="imagen_'.$p.'_'.$f.'_'.$c.'" src="../classes/img/thumbnail.php?i='.$ruta_img.'" border="0">';
						} elseif ($c==1 && $f!=1 && $rellenar_dias=='true' && $mostrar_imagen_dias=='true') {
						   $contenido.='<br /><br /><img name="imagen_'.$p.'_'.$f.'_'.$c.'" id="imagen_'.$p.'_'.$f.'_'.$c.'" src="../classes/img/thumbnail.php?i='.$ruta_img.'" border="0">';
						} elseif ($f==1 && $c==1) {
							$contenido.='<br /><br /><img name="imagen_'.$p.'_'.$f.'_'.$c.'" id="imagen_'.$p.'_'.$f.'_'.$c.'" src="../classes/img/thumbnail.php?i='.$ruta_img.'" border="0">';
						} else { 
						   $contenido.='<br /><br /><img name="imagen_'.$p.'_'.$f.'_'.$c.'" id="imagen_'.$p.'_'.$f.'_'.$c.'" src="../../../images/empty.jpg" border="0">';
						}
						
						if ($f==1 && $c!=1 && $rellenar_horas=='true') {
							if ($f==1 && $c==2 && $rellenar_horas=='true') {
								$contenido.='<br /><input type="text" name="txt_'.$p.'_'.$f.'_'.$c.'" id="txt_'.$p.'_'.$f.'_'.$c.'" value="'.$hora_comienzo.'" style="width:60%;"/><input type="text" name="ctc_'.$p.'_'.$f.'_'.$c.'" id="ctc_'.$p.'_'.$f.'_'.$c.'" value="#000000" style="background-color:#000000; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="'.$translate['seleccione_color_texto'].'" title="'.$translate['seleccione_color_texto'].'" src="../../../images/color_font.gif" /></a>';
							} else {
								$contenido.='<br /><input type="text" name="txt_'.$p.'_'.$f.'_'.$c.'" id="txt_'.$p.'_'.$f.'_'.$c.'" value="'.substr ($hora_comienzo, 0, strlen($hora_comienzo) - 3).'" style="width:60%;"/><input type="text" name="ctc_'.$p.'_'.$f.'_'.$c.'" id="ctc_'.$p.'_'.$f.'_'.$c.'" value="#000000" style="background-color:#000000; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="'.$translate['seleccione_color_texto'].'" title="'.$translate['seleccione_color_texto'].'" src="../../../images/color_font.gif" /></a>';
								
							}
							
						$hora_comienzo=sumahoras($hora_comienzo,$cantidad_tiempo_a_sumar);
						
						} elseif ($c==1 && $f!=1 && $rellenar_dias=='true' && $mostrar_text_dias=='true') {
							if ($idioma==0) {
								$row_palabra=$query->datos_palabra($dias[$dam]);
								$dia_a_mostrar=utf8_encode($row_palabra['palabra']);
							} elseif ($idioma==1 || $idioma==5) {
								$query_palabra=$query->buscar_traduccion($dias[$dam],$idioma);
								$row_palabra=mysql_fetch_array($query_palabra); 
								$dia_a_mostrar=$utfConverter_ru->strToUtf8($row_palabra['traduccion']);
							} elseif ($idioma==3) {
								$query_palabra=$query->buscar_traduccion($dias[$dam],$idioma);
								$row_palabra=mysql_fetch_array($query_palabra);
								$dia_a_mostrar=$utfConverter->strToUtf8($row_palabra['traduccion']);
							} else {
								$query_palabra=$query->buscar_traduccion($dias[$dam],$idioma);
								$row_palabra=mysql_fetch_array($query_palabra);
								$dia_a_mostrar=$row_palabra['traduccion'];
							}
							
						$contenido.='<br /><input type="text" name="txt_'.$p.'_'.$f.'_'.$c.'" id="txt_'.$p.'_'.$f.'_'.$c.'" value="'.$dia_a_mostrar.'" style="width:60%;"/><input type="text" name="ctc_'.$p.'_'.$f.'_'.$c.'" id="ctc_'.$p.'_'.$f.'_'.$c.'" value="#000000" style="background-color:#000000; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="'.$translate['seleccione_color_texto'].'" title="'.$translate['seleccione_color_texto'].'" src="../../../images/color_font.gif" /></a>';

						} else { 
						$contenido.='<br /><input type="text" name="txt_'.$p.'_'.$f.'_'.$c.'" id="txt_'.$p.'_'.$f.'_'.$c.'" value="" style="width:60%;"/><input type="text" name="ctc_'.$p.'_'.$f.'_'.$c.'" id="ctc_'.$p.'_'.$f.'_'.$c.'" value="#000000" style="background-color:#000000; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="'.$translate['seleccione_color_texto'].'" title="'.$translate['seleccione_color_texto'].'" src="../../../images/color_font.gif" /></a>';
						}

						$contenido.='<br /><b><a alt="'.$translate['marco'].'" title="'.$translate['marco'].'">M</a>:</b> <input type="text" name="cbc_'.$p.'_'.$f.'_'.$c.'" id="cbc_'.$p.'_'.$f.'_'.$c.'" value="'.$_POST['color_borde_tabla'].'" style="background-color:'.$_POST['color_borde_tabla'].'; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'cbc_'.$p.'_'.$f.'_'.$c.'\'])">&nbsp;<img border="0" alt="'.$translate['seleccione_color_marco'].'" title="'.$translate['seleccione_color_marco'].'" src="../../../images/colors.gif" /></a>';
						
						$contenido.='&nbsp;<b><a alt=alt="'.$translate['fondo'].'" title="'.$translate['fondo'].'">F:</a></b> <input type="text" name="cfc_'.$p.'_'.$f.'_'.$c.'" id="cfc_'.$p.'_'.$f.'_'.$c.'" value="#FFFFFF" style="background-color:#FFF; width:15px;" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'cfc_'.$p.'_'.$f.'_'.$c.'\'])">&nbsp;<img border="0" alt="'.$translate['seleccione_color_fondo_celda'].'" title="'.$translate['seleccione_color_fondo_celda'].'" src="../../../images/colors.gif" /></a>';
						
						if ($c==1 && $f!=1 && $rellenar_dias=='true') {
							$dam=$dam+1;
							$ham=$ham+1;
						}
						
						$que[] = "{{".$p."_".$f."_".$c."}}"; 
						$por[] = $contenido; 
					} 
					
			}

} //CIERRO LA COMPROBACI�N DE LA POSICI�N DE LA FECHA Y HORA

$contenido=str_replace($que,$por,$tablero);
$contenido2=str_replace("{{borde}}", $borde, $contenido);
echo $contenido2;
?>

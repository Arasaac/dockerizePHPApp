<?php 
session_start();
$id_usuario=$_SESSION['ID_USER'];

require ('../../../classes/languages/language_detect.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
include ('../../../classes/querys/query.php');
require('../funciones/funciones_herramientas.php');

$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],27);
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);

//DEFINIMOS VARIABLES
$color='#000000';
$thumbnail_size=70;


if (isset($_GET['i'])) { 
	$datos = $_GET['i']; //pasamos el paquete a una variable en nuestro caso es val
	$encript->desencriptar($datos,2); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
	$img=$datos['img'];
	$id_palabra=$datos['id_palabra'];
}

if (isset($img) && $img !='NULO' && isset($id_palabra) && $id_palabra !='') {

	$id_palabra=$id_palabra;

	if ($_SESSION['language']=='es') {
		$datos_palabra=$query->datos_palabra($id_palabra);
	} elseif ($_SESSION['language']!='es') {
		$traduccion=$query->buscar_traduccion($id_palabra,$_SESSION['id_language']);
		$datos_palabra=mysql_fetch_array($traduccion);
	}

	$idiomas_disponibles=$query->idiomas_disponibles($id_palabra,1);
	$tipos_imagen=$query->listar_tipos_imagen();
	$id_tipo_palabra=$datos_palabra['id_tipo_palabra'];

	switch ($id_tipo_palabra) {

		case 1:
		$color='#FFFF00';
		break;

		case 2:
		$color='#FF9900';
		break;

		case 3:
		$color='#33CC00';
		break;

		case 4:
		$color='#3366FF';
		break;

		case 5:
		$color='#FF66CC';
		break;

		case 6:
		$color='#FFFFFF';
		break;	

		default:
		$color='#000000';
		break;
	}

	$dir="../../../temp/";
	$borrar=CleanFiles($dir); //Borro los archivos temporales
	$nombre_img=basename(tempnam("../../../temp",'tmp')).'_'.$id_palabra; 

	$imagen_original=$img;
	$extension = strtolower(substr(strrchr($imagen_original, "."), 1));
	$nueva_imagen=$nombre_img.'.'.$extension;

	copy ('../../../'.$imagen_original,'../../../temp/'.$nueva_imagen);
	$ruta_cesto='ruta_cesto=temp/'.$nueva_imagen;
	$encript->encriptar($ruta_cesto,1);

	$ruta='img=../../temp/'.$nueva_imagen;
	$encript->encriptar($ruta,1);

	$usar_imagen='<div id="products" style="height:40px; border:1px solid #CCC; padding: 5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'../../../images/add_3.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a> <a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');">'.$translate['add_seleccion'].'</a> | <a href="../../../inc/public/descargar.php?i='.$ruta.'""><img src=\'../../../images/download_3.png\' border="0" alt="'.$translate['descargar_simbolo'].'" title="'.$translate['descargar_simbolo'].'"></a> <a href="../../../inc/public/descargar.php?i='.$ruta.'"">'.$translate['descargar_simbolo'].'</a></div><br><div align="center"><img src=\'../../../temp/'.$nueva_imagen.'\'><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$nueva_imagen.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nueva_imagen.'"/></form></div>';

	if ($_SESSION['language']=='es') {

		$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty">'.utf8_encode($datos_palabra['palabra']).'</textarea>  <input name="id_palabra" type="hidden" id="id_palabra" value="'.$datos_palabra['id_palabra'].'" size="3" maxlength="3" /> <br><em><strong>'.utf8_encode($datos_palabra['palabra']).',</strong></em>&nbsp;'.utf8_encode($datos_palabra['definicion']).'<br><br>';

	} elseif ($_SESSION['language']!='es') {

		$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty">'.$datos_palabra['traduccion'].'</textarea>  <input name="id_palabra" type="hidden" id="id_palabra" value="'.$datos_palabra['id_palabra'].'" size="3" maxlength="3" /> <br><em><strong>'.$datos_palabra['traduccion'].',</strong></em>&nbsp;'.$datos_palabra['explicacion'].'<br><br>';	

	}

	$palabra_seleccionada.='<strong>'.$translate['traducciones_disponibles'].'</strong><br>';
	$palabra_seleccionada.=idiomas_disponibles_con_castellano($id_palabra,$idiomas_disponibles,$query);
	$imagenes_disponibles=imagenes_disponibes($tipos_imagen,$query,$datos_palabra['id_palabra'],$encript);

} elseif (isset($img) && $img=='NULO' && isset($id_palabra) && $id_palabra !='') {

	$choped=explode('||',$id_palabra);
	$id_palabra=$choped[0];
	$id_idioma_selected=$choped[1];

	if ($id_idioma_selected==0) {
		$datos_palabra=$query->datos_palabra($id_palabra);
	} elseif ($id_idioma_selected > 0) {
		$traduccion=$query->buscar_traduccion($id_palabra,$id_idioma_selected);
		$datos_palabra=mysql_fetch_array($traduccion);
	}

	$idiomas_disponibles=$query->idiomas_disponibles($id_palabra,1);
	$tipos_imagen=$query->listar_tipos_imagen();
	$id_tipo_palabra=$datos_palabra['id_tipo_palabra'];

	switch ($id_tipo_palabra) {

		case 1:
		$color='#FFFF00';
		break;


		case 2:
		$color='#FF9900';
		break;

		case 3:
		$color='#33CC00';
		break;

		case 4:
		$color='#3366FF';
		break;
	

		case 5:
		$color='#FF66CC';
		break;

		case 6:
		$color='#FFFFFF';
		break;

		default:
		$color='#000000';
		break;

	}

	$usar_imagen='';

	if ($id_idioma_selected==0) {

		$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty">'.utf8_encode($datos_palabra['palabra']).'</textarea>  <input name="id_palabra" type="hidden" id="id_palabra" value="'.$datos_palabra['id_palabra'].'" size="3" maxlength="3" /> <br><em><strong>'.utf8_encode($datos_palabra['palabra']).',</strong></em>&nbsp;'.utf8_encode($datos_palabra['definicion']).'<br><br>';

	} elseif ($id_idioma_selected>0) {

		$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty">'.$datos_palabra['traduccion'].'</textarea>  <input name="id_palabra" type="hidden" id="id_palabra" value="'.$datos_palabra['id_palabra'].'" size="3" maxlength="3" /> <br><em><strong>'.$datos_palabra['traduccion'].',</strong></em>&nbsp;'.$datos_palabra['explicacion'].'<br><br>';

	}

	$palabra_seleccionada.='<strong>'.$translate['traducciones_disponibles'].'</strong><br>';

	$palabra_seleccionada.=idiomas_disponibles_con_castellano($id_palabra,$idiomas_disponibles,$query);

	$imagenes_disponibles=imagenes_disponibes($tipos_imagen,$query,$datos_palabra['id_palabra'],$encript);

} elseif (isset($img) && $img !='NULO' && !isset($id_palabra)) {

	$dir="../../../temp/";
	$borrar=CleanFiles($dir); //Borro los archivos temporales
	$nombre_img=basename(tempnam("../../../temp",'tmp')).'_'.$id_palabra; 

	$imagen_original=$img;
	$extension = strtolower(substr(strrchr($imagen_original, "."), 1));
	$nueva_imagen=$nombre_img.'.'.$extension;

	copy ('../../../'.$imagen_original,'../../../temp/'.$nueva_imagen);

	$ruta_cesto='ruta_cesto=temp/'.$nueva_imagen;
	$encript->encriptar($ruta_cesto,1);

	$ruta='img=../../temp/'.$nueva_imagen;
	$encript->encriptar($ruta,1);

	$usar_imagen='<div id="products" style="height:40px; border:1px solid #CCC; padding: 5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'../../../images/add_3.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a> <a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');">'.$translate['add_seleccion'].'</a> | <a href="../../../inc/public/descargar.php?i='.$ruta.'""><img src=\'../../../images/download_3.png\' border="0" alt="'.$translate['descargar_simbolo'].'" title="'.$translate['descargar_simbolo'].'"></a> <a href="../../../inc/public/descargar.php?i='.$ruta.'"">'.$translate['descargar_simbolo'].'</a></div><br><div align="center"><img src=\'../../../temp/'.$nueva_imagen.'\'><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$nueva_imagen.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nueva_imagen.'"/></form></div>';

	$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty"></textarea> <input name="id_palabra" type="hidden" id="id_palabra" value="" size="3" maxlength="3" /><input name="id_traduccion" type="hidden" id="id_traduccion" value="0" />';
	
	$imagenes_disponibles='';

} else {
	$usar_imagen='';
	$id_palabra='';
	$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty"></textarea>  <input name="id_palabra" type="hidden" id="id_palabra" value="" size="3" maxlength="3" /> <input name="id_traduccion" type="hidden" id="id_traduccion" value="0" />';
	$imagenes_disponibles='';

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 

<html><head> 

<link rel="stylesheet" href="../../../css/style.css" type="text/css" />	



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



<link rel="STYLESHEET" type="text/css" href="../js/dhtmlxTabbar/codebase/dhtmlxtabbar.css">

<script  src="../js/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>

<script  src="../js/dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>

<script  src="../js/dhtmlxTabbar/codebase/dhtmlxtabbar_start.js"></script>

<script type="text/javascript" src="../js/color/picker.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title><?php echo $translate['herramientas_arasaac_catedu']; ?>: <?php echo $translate['creador_simbolos']; ?></title>

</head> 

<body>

<div class="body_content" style="height:1350px;">

<link rel="STYLESHEET" type="text/css" href="../js/dhtmlxMenu/css/dhtmlXMenu.css">

<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXProtobar.js"></script>

<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXMenuBar.js"></script>

<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXCommon.js"></script>

<h4 style="text-transform:uppercase;"><?php echo $translate['creador_simbolos']; ?>:

<div style="float:right; font-size:0.8em;"><?php if ($_SESSION['language']=='es') { echo '<a href="../../../zona_descargas/documentacion/manual_creador_simbolos_es.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } elseif ($_SESSION['language']=='br') { echo '<a href="../../../zona_descargas/documentacion/manual_ferramenta_criador_simbolos.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } elseif ($_SESSION['language']=='pt') { echo '<a href="../../../zona_descargas/documentacion/manual_ferramenta_criador_simbolos_pt.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } else { echo '<a href="../../../zona_descargas/documentacion/manual_creador_simbolos_en.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>';  }?></div></h4><br />

<div class="left" style="height:900px;">

<div class="left_box">

<?php if (isset($mensaje)) { ?>

<div id="mensaje" align="center"><?php echo $mensaje; ?></div>

<?php } ?>

<div id="simbolo" align="center">

<?php echo $usar_imagen; ?>

</div>

<br /><br /><br />

<h4 style="text-transform:uppercase;"><?php echo $translate['imagenes_disponibles']; ?>:</h4>

<br />



<div id="imagenes_disponibles" align="left">

    <div id="b_tabbar" class="dhtmlxTabBar" imgpath="../js/dhtmlxTabbar/codebase/imgs/" style="width:100%; height:400px;" skinColors="#FCFBFC,#F4F3EE" >

	   

        <div id="b0" name="<?php echo $translate['mi_seleccion']; ?>" style="padding:10px;">

    		<ul id="thelist2" style="height:280px; overflow:auto; width:100%; border:none; float:left;">

            	<?php echo $translate['explicacion_cesto_creador_simbolos']; ?><br />

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
									$origen=explode("/",$ruta);

									if ($origen[0]=='repositorio' && $origen[1]=='originales') {  

									    $n_img=explode(".",$origen[2]);
										$datos_img=$query->datos_imagen($n_img[0]);
										$ruta_usar_img="img=".$ruta."&id_palabra=".$datos_img['id_palabra'];

										$encript->encriptar($ruta_usar_img,1);
										echo '<li id="thelist2_'.$r.'"><a href="creador_simbolos.php?i='.$ruta_usar_img.'" target="_self"><img src="';
										if (file_exists('../../../repositorio/thumbs/'.$datos_img['id_tipo_imagen'].'/'.$thumbnail_size.'/'.$datos_img['imagen'][0].'/'.$datos_img['imagen'])) { 
										echo '../../../repositorio/thumbs/'.$datos_img['id_tipo_imagen'].'/'.$thumbnail_size.'/'.$datos_img['imagen'][0].'/'.$datos_img['imagen']; 
										
										} else { 
										
											echo '../classes/img/thumbnail.php?i='.$ruta_img.'';
										
										}
										
										echo '" alt="'.$translate['hacer_clic_para_creador'].'" border="0"></a></li>';
	

									} elseif ($origen[0]=='temp') {

									     $ruta_usar_img="img=".$ruta;
										 $encript->encriptar($ruta_usar_img,1);   
						 				 
										 echo '<li id="thelist2_'.$r.'"><a href="creador_simbolos.php?i='.$ruta_usar_img.'" target="_self"><img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="'.$translate['hacer_clic_para_creador'].'" title="'.$translate['hacer_clic_para_creador'].'" border="0"></a></li>';

									}

									$r++;

                               }

                          }
                      ?>

          </ul>
    </div>

    <div id="b1" name="<?php echo $translate['carpeta_trabajo']; ?>" style="padding:10px;">

    		<ul id="thelist2" style="height:280px; overflow:auto; width:100%; border:none; float:left;">

            <?php echo $translate['explicacion_carpeta_trabajo']; ?><br />

            	<?php 

					 if (isset($_SESSION['carpeta_personal']) && $_SESSION['carpeta_personal'] !="") {

                               foreach ($_SESSION['carpeta_personal'] as $key => $value) {

                                    									

                                    $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete

                                    $ruta=$key['ruta_cesto'];

                                    $ruta_img='size='.$thumbnail_size.'&ruta=../../../../'.$ruta;

                                    $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	

                                    $ruta_cesto='ruta_cesto='.$ruta;

                                    $encript->encriptar($ruta_cesto,1); 

									

									$origen=explode("/",$ruta);

									

									

									if ($origen[0]=='repositorio' && $origen[1]=='originales') {  

									

									    $n_img=explode(".",$origen[2]);

									

										$datos_img=$query->datos_imagen($n_img[0]);

									

										$ruta_usar_img="img=".$ruta."&id_palabra=".$datos_img['id_palabra'];

																			

										$encript->encriptar($ruta_usar_img,1);                             

                                   		

										echo '<li id="thelist2_'.$r.'"><a href="creador_simbolos.php?i='.$ruta_usar_img.'" target="_self"><img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="'.$translate['hacer_clic_para_creador'].'" border="0"></a></li>';

										

									} elseif ($origen[0]=='temp') {

									

									     $ruta_usar_img="img=".$ruta;

										 $encript->encriptar($ruta_usar_img,1);   

										 

										 echo '<li id="thelist2_'.$r.'"><a href="creador_simbolos.php?i='.$ruta_usar_img.'" target="_self"><img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="'.$translate['hacer_clic_para_creador'].'" title="'.$translate['hacer_clic_para_creador'].'" border="0"></a></li>';

									

									}

									

									$r++;

                               }

                          }

					?>

            </ul>

    </div>
	<?php echo $imagenes_disponibles; ?>
    </div>

</div>
	</div>

</div>	

<div class="right" style="width:295px;">
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
 <div style="display:block; border:1px solid #CCCCCC; width:280px; margin-left:10px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td align="center"><a href="javascript:void(0);" onClick="Dialog.alert({url: 'uploadcesto.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:500, height:430, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: '<?php echo $translate['cerrar']; ?>', ok:function(win) { cargar_div2('carpeta_trabajo.php','i=','b1'); return true; }});"><img src="../../../images/upload.png" alt="<?php echo $translate['subir_archivos_mi_carpeta_trabajo']; ?>" title="<?php echo $translate['subir_archivos_mi_carpeta_trabajo']; ?>" border="0" /></a></td>

    <td align="center"><a href="javascript:void(0);" onclick="Dialog.alert({url: 'seleccionar_palabra.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:700}, okLabel: '<?php echo $translate['cerrar']; ?>'});"><img src="../../../images/kappfinder.png" alt="<?php echo $translate['buscar_palabra']; ?>" title="<?php echo $translate['buscar_palabra']; ?>" border="0" /></a></td>

    <td align="center"><div id="loading"><img src="../../../images/loading1.gif" alt="<?php echo $translate['cargando']; ?>..." /></div><div id="clearCart"><a href="javascript:void(0);" onclick="previsualizar(); document.form1.pixels_lienzo.value='';"><img src="../../../images/player_play.png" alt="<?php echo $translate['previsualizar']; ?>" title="<?php echo $translate['previsualizar']; ?>" width="50" height="50" border="0"></a><a href="javascript:void(0);" onclick="limpiar_lienzo_creador_simbolos();"></a></div></td>

    <td align="center"><a href="javascript:void(0);" onclick="limpiar_lienzo_creador_simbolos();"><img src="../../../images/trashcan_empty.png" alt="<?php echo $translate['limpiar_area_trabajo']; ?>" title="<?php echo $translate['limpiar_area_trabajo']; ?>" width="50" height="50" border="0"></a></td>

    <td align="center"><a href="javascript:void(0);" onclick="Dialog.alert({url: 'seleccionar_palabra.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:700}, okLabel: '<?php echo $translate['cerrar']; ?>'});"></a></td>

</tr>

  </table>

	</div>

    <br>

<div id="a_tabbar" class="dhtmlxTabBar" imgpath="../js/dhtmlxTabbar/codebase/imgs/" style="width:290px; height:1050px; margin-left:10px;" skinColors="#FCFBFC,#F4F3EE" mode="right">

      <!-- PESTAÑA 1 -->

    <div id="a1" name="T" style="padding-left:10px;">

      <div style="display:block;" id="imagen2" >

        <p><strong><?php echo $translate['texto']; ?></strong><br/>

          </p>

        <div id="selected_word">

         <?php echo $palabra_seleccionada; ?>

      </div>	

      <p>&nbsp;</p>

      <p><strong><?php echo $translate['fuente_idioma_actual']; ?>:</strong>

        <select name="fuente_castellano" size="1" id="fuente_castellano" class="fonty">

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

         <option value="Cyberbit">Cyberbit - Chinese</option>

         <option value="FreeFarsi">FreeFarsi - Arabic</option>

         <option value="penmp">Penmamship Print</option>

         <option value="PrintClearly_TT">Print Clearly</option>

         <option value="comic">Comic Sans MS</option>

        </select>

</p>

      <p>&nbsp;</p>

      <p><strong><?php echo $translate['parte_superior']; ?></strong></p>

      <p>

        <select name="sup_idioma" size="1" id="sup_idioma" class="fonty">

          <option value="0" selected="selected"><?php echo $translate['sin_traduccion']; ?></option>

          <option value="1"><?php echo $translate['idioma_actual']; ?></option>

          <option value="2"><?php echo $translate['traduccion_seleccionada']; ?></option>

        </select>

      </p>

      <p>

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

              <option value="36" selected="selected">36</option>

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

      </p>

      <p>

            <select name="sup_may" size="1" id="sup_may" class="fonty">

                <option value="0" selected="selected"><?php echo $translate['minusculas']; ?></option>

                <option value="1"><?php echo $translate['mayusculas']; ?></option>

            </select>

            </p>

      <p>

        <input name="color_sup" type="text" id="color_sup" value="#000000" size="7" maxlength="7" readonly/>

          <a href="javascript:TCP.popup(document.forms['form1'].elements['color_sup'])"><img width="18" height="18" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/color_font.gif" /></a></p>

      <p>&nbsp;</p>

      <p><strong><?php echo $translate['parte_inferior']; ?></strong></p>

      <p>

        <select name="inf_idioma" size="1" id="inf_idioma" class="fonty">

          <option value="0"><?php echo $translate['sin_traduccion']; ?></option>

          <option value="1" selected="selected"><?php echo $translate['idioma_actual']; ?></option>

          <option value="2"><?php echo $translate['traduccion_seleccionada']; ?></option>

        </select>

      </p>

      <p>

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

              <option value="36" selected="selected">36</option>

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

      </p>

      <p>

            <select name="inf_may" size="1" id="inf_may" class="fonty">

                <option value="0" selected="selected"><?php echo $translate['minusculas']; ?></option>

                <option value="1"><?php echo $translate['mayusculas']; ?></option>

             </select>

            </p>

      <p>

        <input name="color_inf" type="text" id="color_inf" value="#000000" size="7" maxlength="7" readonly/>

              </span> <a href="javascript:TCP.popup(document.forms['form1'].elements['color_inf'])"><img width="18" height="18" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/color_font.gif" /></a></p>

      <p></p>

      <p><strong><?php echo $translate['marco']; ?></strong></p>

      <p>

        <select name="marco" size="1" id="marco" class="fonty">

          <option value="0"><?php echo $translate['sin_marco']; ?></option>

          <option value="1" selected="selected"><?php echo $translate['con_marco']; ?></option>

        </select>

        <input name="accion" type="hidden" id="accion" value="normal" />

  &nbsp;&nbsp;</p>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="41%" valign="middle"><?php echo $translate['grosor']; ?>

            <input name="grosor" type="text" id="grosor" value="15" size="3" maxlength="2"/>

            px </td>

          <td width="19%" valign="middle"><div id="color_borde">

            <input name="color_borde" type="text" id="color_borde" value="<?php echo $color ?>" size="7" maxlength="7" readonly style="background-color:<?php echo $color ?>;"/>

          </div></td>

          <td width="40%" valign="middle"><a href="javascript:TCP.popup(document.forms['form1'].elements['color_borde'])"><img width="18" height="18" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/color_font.gif" /></a></td>

        </tr>

      </table>

      <p>&nbsp;</p>

      <p><strong><?php echo $translate['lienzo']; ?></strong></p>

      <p><?php echo $translate['ampliar_lienzo']; ?>:

        <input name="pixels_lienzo" type="text" id="pixels_lienzo" value="100" size="3" maxlength="3"/>

        <?php echo $translate['pixels_entre_1_999']; ?></p>

      <p><?php echo $translate['tamanyo_final_lienzo']; ?>:

        <select name="pixels_final" size="1" id="pixels_final" class="fonty">
            <option value="0"><?php echo $translate['no_redimensionar']; ?></option>
            <option value="100">100x100</option>
            <option value="150">150x150</option>
            <option value="200">200x200</option>
            <option value="250">250x250</option>
            <option value="300">300x300</option>
            <option value="350">350x350</option>
            <option value="400">400x400</option>
            <option value="450">450x450</option>
            <option value="500" selected="selected">500x500</option>
            <option value="600">600x600</option>
            <option value="700">700x700</option>
            <option value="800">800x800</option>
         </select>

      </p>
      <p>&nbsp;</p>
      <p><strong><?php echo $translate['transformaciones']; ?></strong></p>
      <table width="86%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td width="29%"><div align="center"><a href="javascript:void(0);" onclick="document.form1.accion.value='normal'; previsualizar();"><img src="../../../images/normal.jpg" alt="<?php echo $translate['normal']; ?>" title="<?php echo $translate['normal']; ?>" width="50" height="49" border="0" /></a></div></td>

          <td width="29%"><div align="center"><a href="javascript:void(0);" onclick="document.form1.accion.value='invertir'; previsualizar();"><img src="../../../images/invertir.jpg" alt="<?php echo $translate['invertir']; ?>" title="<?php echo $translate['invertir']; ?>" width="50" height="49" border="0" /></a></div></td>

          <td width="29%"><div align="center"><a href="javascript:void(0);" onclick="document.form1.accion.value='alto_contraste'; previsualizar();"><img src="../../../images/alto_contraste.jpg" alt="<?php echo $translate['alto_contraste']; ?>" title="<?php echo $translate['alto_contraste']; ?>" width="50" height="49" border="0" /></a></div></td>

          <td width="13%"><br />
              <input name="color_alto_contraste" type="text" id="color_alto_contraste" value="#FFFF00" size="4" maxlength="7" readonly style="background-color:#FFFF00;"/>
            <a href="javascript:TCP.popup(document.forms['form1'].elements['color_alto_contraste'])"><img width="18" height="18" border="0" alt="<?php echo $translate['seleccione_color']; ?>" title="<?php echo $translate['seleccione_color']; ?>" src="../../../images/color_font.gif" /></a><a href="javascript:void(0);" onclick="document.form1.accion.value='alto_contraste'; previsualizar();"></a><a href="javascript:void(0);" onclick="document.form1.accion.value='invertir'; previsualizar();"></a><a href="javascript:void(0);" onclick="document.form1.accion.value='normal'; previsualizar();"></a></td>
        </tr>
      </table>
      <p></p>
      <p>&nbsp;</p>
      <p></p>
      <p><br>	
      </p>

      </div>

    </div>

     <!-- **********************************************************************************************  -->

     

     <!-- PESTAÑA 2 -->

<!--    <div id="a2" name="C" style="padding-left:10px;">

      <p>&nbsp;</p>

      </div>-->

     <!-- *******************************************************************  -->
    
</div>

  </form>
</div>

<div align="center" class="footer">
	<p><b><?php echo $translate['autores_herramienta']; ?>:</b> David Romero <?php echo $translate['y']; ?> José Manuel Marcos</p>
      <p><!--<a href="../../../index.php">Qu&eacute; es Arasaac</a> | <a href="../../../index.php?ref=condiciones_uso_h">Condiciones de Uso</a> | <a href="../../../index.php?ref=mapa_web_h">Mapa Web</a><br />-->

        &copy; <?php echo $translate['herramientas_arasaac_catedu']; ?> <?php echo date("Y"); ?> | <?php echo $translate['dto_educacion']; ?><br />

        <a href="http://www.aragob.es" target="_blank"><img src="../../../images/minilogo_aragob.gif" alt="<?php echo $translate['dto_educacion']; ?>" border="0" tittle="<?php echo $translate['dto_educacion']; ?>"/></a></p>
  </div>
</div>		
</div>
</body> 
</html>
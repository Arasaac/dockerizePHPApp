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

require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
include ('../../../classes/querys/query.php');
require ('../../../classes/languages/language_detect.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1);

$id_usuario=$_SESSION['ID_USER'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $translate['herramientas_arasaac_catedu']; ?>: <?php echo $translate['seleccionar_imagen']; ?></title>
<script type="text/javascript" src="../js/ajax_herramientas.js"></script>
</head>
<body>
<div id="principal" style="height:350px;">
<div id="menu_superior" style="text-align:center;"><a href="javascript:void(0);" onclick="showDIV('palabras'); hideDIV('cesto');" ><?php echo $translate['diccionario']; ?></a> <?php if (isset($_SESSION['cart']) && $_SESSION['cart'] !="" || isset($_SESSION['carpeta_personal']) && $_SESSION['carpeta_personal'] !="") { ?> | <a href="javascript:void(0);" onclick="showDIV('cesto'); hideDIV('palabras');" ><?php echo $translate['mi_seleccion']; ?>/<?php echo $translate['carpeta_trabajo']; ?></a><?php } ?></div><hr />

<!-- CAPA DE BUSQUEDA EN EL CESTO -->
<div id="cesto" style="display:none;">
<ul id="thelist5" style="height:280px; overflow:auto; width:100%; border:none; float:left;">
					<?php 
                       if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") {
								
							$r=0;
									
                               foreach ($_SESSION['cart'] as $key => $value) {
                                    									
                                    $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                                    $ruta=$key['ruta_cesto'];
                                    $ruta_img='ruta=../../../../'.$ruta.'&size=60';
                                    $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
									$ruta_img_previa='ruta=../../../../'.$ruta.'&size=30';
                                    $encript->encriptar($ruta_img_previa,1); //OJO uno(1) es para encriptar variables para URL	
                                    $ruta_cesto='ruta_cesto='.$ruta;
                                    $encript->encriptar($ruta_cesto,1); 
									
									$origen=explode("/",$ruta);
									
									
									if ($origen[0]=='repositorio' && $origen[1]=='originales') {  
									
									    $n_img=explode(".",$origen[2]);
									
										$datos_img=$query->datos_imagen($n_img[0]);
										
										if ($_SESSION['id_language']==0) { 
											$acepcion=$datos_img['palabra']; 
										} elseif ($_SESSION['id_language']==1 || $_SESSION['id_language']==5) {
											$query_palabra=$query->buscar_traduccion($datos_img['id_palabra'],$_SESSION['id_language']);
											$row_acepcion=mysql_fetch_array($query_palabra); 
											$acepcion=$utfConverter_ru->strToUtf8($row_acepcion['traduccion']);
										} elseif ($_SESSION['id_language']==3) {
											$query_palabra=$query->buscar_traduccion($datos_img['id_palabra'],$_SESSION['id_language']);
											$row_acepcion=mysql_fetch_array($query_palabra);
											$acepcion=$utfConverter->strToUtf8($row_acepcion['traduccion']);
										} else {
											$query_palabra=$query->buscar_traduccion($datos_img['id_palabra'],$_SESSION['id_language']);
											$row_acepcion=mysql_fetch_array($query_palabra);
											$acepcion=$row_acepcion['traduccion'];
										}
										
										$ruta_usar_img="img=".$ruta."&id_palabra=".$datos_img['id_palabra'];
																			
										$encript->encriptar($ruta_usar_img,1);                             
                                   		
										echo '<li id="thelist5_'.$r.'"><a href="javascript:void(0);" onclick="seleccionar_pictograma_horarios(\''.$_GET['panel'].'\',\''.$_GET['fila'].'\',\''.$_GET['columna'].'\',\''.$ruta_img.'\',\''.$acepcion.'\');" target="_self"><img src="../classes/img/thumbnail.php?i='.$ruta_img_previa.'" alt="'.$translate['utilizar_imagen_en_el_generador_horarios'].'" title="'.$translate['utilizar_imagen_en_el_generador_horarios'].'" border="0"></a></li>';
										
									} elseif ($origen[0]=='temp') {
									
									     $ruta_usar_img="img=".$ruta;
										 $encript->encriptar($ruta_usar_img,1);  
										 
										 echo '<li id="thelist5_'.$r.'"><a href="javascript:void(0);" onclick="seleccionar_pictograma_paneles(\''.$_GET['panel'].'\',\''.$_GET['fila'].'\',\''.$_GET['columna'].'\',\''.$ruta_img.'\');" target="_self"><img src="../classes/img/thumbnail.php?i='.$ruta_img_previa.'" alt="'.$translate['utilizar_imagen_en_el_generador_horarios'].'" title="'.$translate['utilizar_imagen_en_el_generador_horarios'].'" border="0"></a></li>';
									
									}
									
									$r++;
                               }
                          }
						  
						  if (isset($_SESSION['carpeta_personal']) && $_SESSION['carpeta_personal'] !="") {
									
                               foreach ($_SESSION['carpeta_personal'] as $key => $value) {
                                    
                                    $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                                    $ruta=$key['ruta_cesto'];
                                    $ruta_img='ruta=../../../../'.$ruta.'&size=60';
                                    $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
									$ruta_img_previa='ruta=../../../../'.$ruta.'&size=30';
                                    $encript->encriptar($ruta_img_previa,1); //OJO uno(1) es para encriptar variables para URL
                                    $ruta_cesto='ruta_cesto='.$ruta;
                                    $encript->encriptar($ruta_cesto,1); 
									
									$origen=explode("/",$ruta);	
                                    if ($origen[0]=='temp') {
                                   		$ruta_usar_img="img=".$ruta;
										$encript->encriptar($ruta_usar_img,1);  
										 
										 echo '<li id="thelist5_'.$r.'"><a href="javascript:void(0);" onclick="seleccionar_pictograma_paneles(\''.$_GET['panel'].'\',\''.$_GET['fila'].'\',\''.$_GET['columna'].'\',\''.$ruta_img.'\');" target="_self"><img src="../classes/img/thumbnail.php?i='.$ruta_img_previa.'" alt="'.$translate['utilizar_imagen_en_el_generador_horarios'].'" title="'.$translate['utilizar_imagen_en_el_generador_horarios'].'" border="0"></a></li>';
									}
									
									$r++;
                                 }
                            }
?>
</ul>
</div>
<!-- FIN DE LA CAPA DE BUSQUEDA EN EL CESTO -->

<!-- CAPA DE BUSQUEDA POR PALABRAS -->
<div id="palabras" style="display:block; text-align:left;">
<form action="" method="post" name="vm_diccionario">
              <strong><?php echo $translate['diccionario']; ?>:
              </strong></strong>
              <?php $categ3=$query->listar_categorias_palabras(); ?>
              <select name="tipo_palabra" class="textos" id="tipo_palabra">
                <option value="99"><?php echo $translate['todas']; ?></option>
                <?php
					while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  
		 		?>
                <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra_'.$_SESSION['language'].'']; ?></option>
                <?php }  ?>
              </select> 
              <select name="idiomabusqueda" id="idiomabusqueda">
                <option value="0" <?php if ($_SESSION['language']=='es') { echo 'selected="selected"'; } ?>><?php echo $translate['spanish']; ?></option>
                <option value="7" <?php if ($_SESSION['language']=='en') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(7); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
                <option value="9" <?php if ($_SESSION['language']=='ca') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(9); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
                <option value="14" <?php if ($_SESSION['language']=='ga') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(14); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
                <option value="8" <?php if ($_SESSION['language']=='fr') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(8); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
                <option value="11" <?php if ($_SESSION['language']=='de') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(11); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
                <option value="12" <?php if ($_SESSION['language']=='it') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(12); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
                <option value="13" <?php if ($_SESSION['language']=='pt') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(13); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
                <option value="15" <?php if ($_SESSION['language']=='br') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(15); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
                <option value="10" <?php if ($_SESSION['language']=='eu') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(10); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
                <option value="2" <?php if ($_SESSION['language']=='ru') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(2); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
                <option value="6" <?php if ($_SESSION['language']=='po') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(6); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
				<option value="16" <?php if ($_SESSION['language']=='cr') { echo 'selected="selected"'; } ?>>
                  <?php $datos_idioma=$query->datos_idioma_completo(16); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                </option>
              </select>
      <br/>
              <strong><?php echo $translate['comienza_por']; ?></strong>
              <input name="letra" type="text" id="letra" size="30" onkeypress="return handleEnter(this, event)"/>
<input type="button" name="Submit2" value="<?php echo $translate['buscar']; ?>" onclick="procesar('listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'&panel=<?php echo $_GET['panel']; ?>&fila=<?php echo $_GET['fila']; ?>&columna=<?php echo $_GET['columna']; ?>&id_idioma='+document.vm_diccionario.idiomabusqueda.value+'','tabla_palabras');" />
<hr />
</form>
<div id="tabla_palabras" style="height:280px; overflow:auto"></div>
</div>
<!-- FIN DE LA CAPA DE BUSQUEDA POR PALABRAS -->


</div>
</body>
</html>
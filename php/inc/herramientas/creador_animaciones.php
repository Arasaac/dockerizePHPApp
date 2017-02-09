<?php 
session_start();
include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
require_once('classes/crypt/5CR.php');
require_once('../../configuration/key.inc');
require ('../../classes/languages/language_detect.php');

require_once('classes/sllists/SLLists.class.php');
$sortableLists = new SLLists('classes/sllists/scriptaculous');
$sortableLists->addList('thelist2','seleccion_cesto');
$sortableLists->addList('imageFloatContainer','imageFloatOrder','img',"overlap:'horizontal',constraint:false");
$sortableLists->debug = true;

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],26);

//DEFINIMOS VARIABLES
$color='#000000';
$thumbnail_size=50;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Herramientas ARASAAC: Creador de Animaciones</title>
<?php
$sortableLists->printTopJS();
?>
<script type="text/javascript" src="js/ajax_herramientas.js"></script>
<link rel="stylesheet" href="../../css/style.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="classes/sllists/css/lists.css"/>
<link rel="STYLESHEET" type="text/css" href="js/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
<script  src="js/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
<script  src="js/dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
<script  src="js/dhtmlxTabbar/codebase/dhtmlxtabbar_start.js"></script>
<script type="text/javascript" src="../../js/prototype/prototype.js"> </script> 
<script type="text/javascript" src="../../js/windows_js_0.96.2/javascripts/effects.js"> </script>
<script type="text/javascript" src="../../js/windows_js_0.96.2/javascripts/window.js"> </script>
<script type="text/javascript" src="../../js/windows_js_0.96.2/javascripts/debug.js"> </script>
<script type="text/javascript" src="../../js/windows_js_0.96.2/javascripts/window_effects.js"> </script> 
    
<link href="../../js/windows_js_0.96.2/themes/default.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../js/windows_js_0.96.2/themes/alphacube.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../js/windows_js_0.96.2/themes/alert.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../js/windows_js_0.96.2/themes/alert_lite.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../js/windows_js_0.96.2/themes/spread.css" rel="stylesheet" type="text/css" ></link> 
<link href="../../js/windows_js_0.96.2/themes/debug.css" rel="stylesheet" type="text/css" ></link>
</head>
<body>
<div class="body_content" style="height:800px;">
<h4 style="text-transform:uppercase;"><?php echo $translate['creador_animaciones']; ?>:
<div style="float:right; font-size:0.8em;"><?php if ($_SESSION['language']=='es') { echo '<a href="../../zona_descargas/documentacion/manual_creador_animaciones_es.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } elseif ($_SESSION['language']=='br') { echo '<a href="../../zona_descargas/documentacion/manual_ferramenta_criador_animações.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } elseif ($_SESSION['language']=='pt') { echo '<a href="../../zona_descargas/documentacion/manual_ferramentas_criador_animações_pt.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } else { echo '<a href="../../zona_descargas/documentacion/animations_maker_tool_manual.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>';  }?></div></h4>
	<div id="principal">
    <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <div class="left" style="height:700px;">
      <div class="left_box">
          <div id="b_tabbar" class="dhtmlxTabBar" imgpath="js/dhtmlxTabbar/codebase/imgs/" style="width:100%; height:650px;"  skinColors="#FCFBFC,#F4F3EE" >
          
                <div id="b1" name="<?php echo $translate['previsualizacion']; ?>" align="center" style="padding:10px;">
                	<div id="animacion" align="center"></div>                  
                </div>
                
    			<div id="b2" name="<?php echo $translate['mi_seleccion']; ?>/<?php echo $translate['carpeta_trabajo']; ?>" style="padding:10px; text-align:left;">
    			 	<?php echo $translate['explicacion_creador_animaciones']; ?>
    			    <input name="seleccion_cesto" type="hidden" id="seleccion_cesto" size="100" />
					<ul id="thelist2" style="height:280px; overflow:auto; width:100%; border:none; float:left;">
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
									$nombre_archivo=basename($ruta, ".".$extension."");
									$di=$query->datos_imagen_tipo_imagen($nombre_archivo);
									
										if ($extension=='jpg' || $extension=='png' || $extension=='gif' || $extension=='jpeg' || $extension=='JPG' || $extension=='GIF' ||$extension=='PNG') {
											echo "<li id=\"thelist2_".$r."\" style=\"cursor:pointer; background-color:#FFFFFF;\" onmousemove=\"populateHiddenVars();\"><a href=\"javascript:void(0);\"><img src=\"";
											
										if (file_exists('../../repositorio/thumbs/'.$di['id_tipo_imagen'].'/'.$thumbnail_size.'/'.$nombre_archivo[0].'/'.$nombre_archivo.'.'.$extension)) { 
										echo '../../repositorio/thumbs/'.$di['id_tipo_imagen'].'/'.$thumbnail_size.'/'.$nombre_archivo[0].'/'.$nombre_archivo.'.'.$extension; 
										
										} else { 
										
											echo 'classes/img/thumbnail.php?i='.$ruta_img.'';
										
										}
										
										echo "\" border=\"0\"/></a><br><input name=\"usar[".$r."]\" type=\"checkbox\" value=\"".$ruta_cesto."\" /></li>";
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
                                    
                                    echo "<li id=\"thelist2_".$r."\" style=\"cursor:pointer; background-color:#FFFFFF;\" onmousemove=\"populateHiddenVars();\"><a href=\"javascript:void(0);\"><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><input name=\"usar[".$r."]\" type=\"checkbox\" value=\"".$ruta_cesto."\" /></li>";
									$r++;
                                    }
                                }
                                ?>
                  </ul>
            </div>
          </div>
        </div>
        </div>	
<div class="right" style="width:215px;">
        
<div style="display:block; border:1px solid #CCCCCC; width:195px; margin-left:10px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  
  <tr>
    <td>  <div align="center">
            <p>
            <p>
            <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {  ?>
            <strong><?php echo $translate['crear_desde']; ?></strong><br />
                <select name="desde" id="desde" onChange="procesar('comun/listar_mis_selecciones.php','id='+document.form1.desde.value+'','mis_selecciones');">
                  <option value="1"><?php echo $translate['mi_cesto']; ?></option>
                  <option value="2"><?php echo $translate['mi_seleccion']; ?></option>
                </select>
             <?php } else { ?>
             	   <input name="desde" type="hidden" value="1" />
             <?php } ?>
              <div id="mis_selecciones"><input name="mi_seleccion" type="hidden" value="" /></div>
            </div>
      <div align="center"><div id="loading"><img src="../../images/loading1.gif" alt="<?php echo $translate['cargando']; ?>..." /></div><div id="clearCart"><a href="javascript:void(0);" onclick="Dialog.alert({url: 'creador_animaciones/uploadcesto.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:500, height:430, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: '<?php echo $translate['cerrar']; ?>', ok:function(win) { cargar_div2('creador_animaciones/carpeta_trabajo.php','i=','b2'); return true; }});"><img src="../../images/upload.png" alt="<?php echo $translate['subir_archivos_mi_carpeta_trabajo']; ?>" title="<?php echo $translate['subir_archivos_mi_carpeta_trabajo']; ?>" border="0" /></a> <a href="javascript:void(0);" onClick="generar_animacion(<?php echo $_SESSION['ID_USER']; ?>);"><img src="../../images/player_play.png" alt="<?php echo $translate['previsualizar']; ?>" width="50" height="50" border="0" /></a></div><br />
      </div></td>
    </tr>
</table>
	</div>
    <br />
    <div id="a_tabbar" class="dhtmlxTabBar" imgpath="js/dhtmlxTabbar/codebase/imgs/" style="width:190px; height:370px; margin-left:10px;" skinColors="#FCFBFC,#F4F3EE" mode="right">
    
      <!-- PESTAÑA 1 -->
    <div id="a1" name="C" style="padding-left:10px;">
      <div style="display:block;" id="imagen2" >
        <p><strong><?php echo $translate['formato_salida']; ?></strong></p>
        <p>
          <label>
          <select name="output" id="output">
            <option value="1" selected="selected"><?php echo $translate['gif_animado']; ?></option>
            <option value="2"><?php echo $translate['swf_flash']; ?></option>
          </select>
          </label>
        </p>
        <p><strong><?php echo $translate['intervalo_entre_simbolos']; ?></strong></p>
        <p>&nbsp;</p>
        <p>
          <input name="milisegundos" type="text" id="milisegundos" value="100" size="3" maxlength="3"/>
          <?php echo $translate['milisegundos']; ?></p>
        <p> <?php echo $translate['1sg_100milisg']; ?></p>
        <p>&nbsp;</p>
      <p><strong><?php echo $translate['repeticiones']; ?></strong></p>
      <p>&nbsp;</p>
      <p>Loops:
        <input name="loops" type="text" id="loops" value="0" size="2" maxlength="2"/><?php echo $translate['0_equivale_infinitas']; ?> <br>	
      </p>
      </div>
    </div>
    
     <!-- **********************************************************************************************  -->
 </div>  
      </div>
      </form>  
           <div align="center" class="footer">
           <p><b><?php echo $translate['autores_herramienta']; ?>:</b> David Romero <?php echo $translate['y']; ?> José Manuel Marcos</p>
              <p>&copy; <?php echo $translate['herramientas_arasaac_catedu']; ?> <?php echo date("Y"); ?> | <?php echo $translate['dto_educacion']; ?><br />
        <a href="http://www.aragob.es" target="_blank"><img src="../../images/minilogo_aragob.gif" alt="<?php echo $translate['dto_educacion']; ?>" border="0" tittle="<?php echo $translate['dto_educacion']; ?>"/></a></p>
          </div>   
  </div>     
    </div>
</div>
<?php
$sortableLists->printBottomJS();
?>
</body>
</html>
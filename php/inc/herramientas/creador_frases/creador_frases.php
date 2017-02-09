<?php 
session_start();
require ('../../../classes/languages/language_detect.php');
include ('../../../classes/querys/query.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],28);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title><?php echo $translate['Herramientas ARASAAC']; ?>: <?php echo $translate['creador_frases']; ?></title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../js/autoComplete/autoComplete_css.css" type="text/css" media="screen" charset="utf-8" />
    <script type="text/javascript" src="../js/ajax_herramientas.js"></script>
 	<link rel="stylesheet" href="../../../css/style.css" type="text/css" />
 	<script src="../js/scriptaculous/prototype.js" type="text/javascript"></script>
 	<script src="../js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
 	<script src="../js/scriptaculous/unittest.js" type="text/javascript"></script>
</head>
<body>
<div class="body_content">
<div id="principal">
<form action="creador_frases_2.php" method="post" name="seleccion_simbolos" id="seleccion_simbolos">
<div id="mi_repositorio">
 <h4 style="text-transform:uppercase;"><?php echo $translate['creador_frases']; ?>: <?php echo $translate['paso_1']; ?>
 <div style="float:right; font-size:0.8em;"><?php if ($_SESSION['language']=='es') { echo '<a href="../../../zona_descargas/documentacion/manual_creador_frases_es.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } elseif ($_SESSION['language']=='br') { echo '<a href="../../../zona_descargas/documentacion/Manual_da_ferramenta_Criador_de_Frases.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } else { echo '<a href="../../../zona_descargas/documentacion/manual_creador_frases_es.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>';  }?></div></h4>
      <table width="100%" border="0">
        <tr>
          <td colspan="2" valign="top"><?php echo $translate['explicacion_paso_1']; ?></td>
        </tr>
        <tr>
          <td width="71%" colspan="2" align="left" valign="top">
          <div id="creador_frases">
          <strong><?php echo $translate['palabra']; ?>:
              <input name="s" type="text" id="s" onkeyup="lookup(this.value,document.getElementById('idiomafrase').value);" value="" size="85" onfocus="$('suggestions').hide();" onclick="$('suggestions').hide();" />
          </strong>
          <label>
            <select name="idiomafrase" id="idiomafrase">
              <option value="0" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==0) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='es') { echo 'selected="selected"'; } ?>><?php echo $translate['spanish']; ?>
              </option>
              <option value="7" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==7) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='en') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(7); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
              <option value="9" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==9) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='ca') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(9); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
              <option value="14" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==14) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='ga') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(14); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
              <option value="8" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==8) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='fr') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(8); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
              <option value="11" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==11) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='de') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(11); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
              <option value="12" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==12) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='it') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(12); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
              <option value="13" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==13) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='pt') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(13); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
              <option value="15" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==15) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='br') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(15); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
              <option value="10" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==10) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='eu') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(10); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
              <option value="2" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==2) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='ru') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(2); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
              <option value="6" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==6) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='po') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(6); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
			  <option value="6" <?php if (isset($_POST['idiomafrase']) && $_POST['idiomafrase']==16) { echo 'selected="selected"'; } elseif (!isset($_POST['idiomafrase']) && $_SESSION['language']=='cr') { echo 'selected="selected"'; } ?>><?php $datos_idioma=$query->datos_idioma_completo(16); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
              </option>
            </select>
          </label>
          &nbsp;
          <a href="javascript:void(0);" onClick="var buscar=document.getElementById('s').value; var mi_seleccion=document.getElementById('mi_seleccion').value; var idioma_palabra=document.getElementById('idiomafrase').value; cargar_div2('paso2.php',''+mi_seleccion+'&palabra='+buscar+'&language='+idioma_palabra+'&tipo=2','thelist2'); document.seleccion_simbolos.s.value=''; $('suggestions').hide();"><strong>
          <?php echo $translate['add']; ?></strong></a><img src="../../../images/add.png" alt="Añadir" width="16" height="16" onClick="var buscar=document.getElementById('s').value; var mi_seleccion=document.getElementById('mi_seleccion').value; var idioma_palabra=document.getElementById('idiomafrase').value; cargar_div2('paso2.php',''+mi_seleccion+'&palabra='+buscar+'&language='+idioma_palabra+'&tipo=2','thelist2'); document.seleccion_simbolos.s.value=''; " />
          <div class="suggestionsBox" id="suggestions" style="display: none;">
            <img src="../js/autoComplete/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
            <div class="suggestionList" id="autoSuggestionsList">
&nbsp;				</div>
			</div>
            <p>
              <input name="id_palabra" type="hidden" id="id_palabra" />
              <br/>  
              </p>
            <p><strong><?php echo $translate['mostrar']; ?>: 
              <input name="pictogramas_color" type="checkbox" id="pictogramas_color" value="1" <?php if (isset($_POST['pictogramas_color'])) { echo 'checked="checked"'; } elseif (!isset($_POST['pictogramas_color']) && !isset($_POST['pictogramas_byn']) && !isset($_POST['fotografia']) && !isset($_POST['lse_color']) && !isset($_POST['lse_byn'])) { echo 'checked="checked"'; } ?>/>
              <?php echo $translate['pictogramas_color']; ?>
              <input name="pictogramas_byn" type="checkbox" id="pictogramas_byn" value="1" <?php if (isset($_POST['pictogramas_byn'])) { echo 'checked="checked"'; } ?>/>
              <?php echo $translate['pictogramas_byn']; ?>
              <input name="fotografia" type="checkbox" id="fotografia" value="1" <?php if (isset($_POST['fotografia'])) { echo 'checked="checked"'; } ?>/>
              <?php echo $translate['imagenes']; ?>
              <input name="lse_color" type="checkbox" id="lse_color" value="1" <?php if (isset($_POST['lse_color'])) { echo 'checked="checked"'; } ?>/>
              <?php echo $translate['lse_color']; ?>
              <?php if (isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== true) { ?>
              <input name="lse_byn" type="checkbox" id="lse_byn" value="1" <?php if (isset($_POST['lse_byn'])) { echo 'checked="checked"'; } ?>/>
              <?php echo $translate['lse_byn']; ?>
              <?php } ?>
            </strong><br /> <br />
              <strong><?php echo $translate['delete_word_sentence']; ?></strong><br />
              <br />
            </p>
            <ul id="thelist3" style="height:360px; margin-right:10px; background:url(../../../images/trash.png) no-repeat left top; border:1px dashed #999999; float:left; width:30%; z-index:5;">
            </ul>
        <p><strong><?php echo $translate['frase']; ?></strong></p>
        <p><a href="javascript:void(0);" onClick="Sortable.create('thelist2',{containment:['thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){ document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); },
        onChange:function(element){ document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2');  }}); return false;"><?php echo $translate['ordenar_seleccion']; ?></a> | 
  <a href="javascript:void(0);" onClick="Sortable.destroy('thelist2');return false;"><?php echo $translate['dejar_de_ordenar']; ?></a> | <a href="creador_frases.php"><?php echo $translate['delete_sentence']; ?></a></p>        
  <ul id="thelist2" style="height:300px; overflow:scroll; border:1px dashed #CCCCCC; font-size:22px; float:right; width:65%; z-index:10;">
  <?php 
//INICIALIZO LA VARIABLE
  $li='';
  $frase='';
//*************************

if (isset($_POST['mi_seleccion'])) {
	
	$seleccion=explode('&',rawurldecode($_POST['mi_seleccion']));

	foreach ($seleccion as $indice=>$valor){ 

			$elemento=explode('thelist2[]=',$valor);
				
			if ($elemento[1] !='') {
				
				$elemento2=explode("||",rawurldecode($elemento[1]));
				$frase.='thelist2[]='.$elemento[1].'&';
				
				if ($elemento2[2]==1) {
					
					if ($elemento2[0] > 0) {
						
						if ($elemento2[1] == 0) {
							$dp=$query->datos_palabra($elemento[1]);
							$row_palabra=utf8_encode($dp['palabra']);
						} elseif ($elemento2[1] > 0) {
							$dt=$query->buscar_traduccion_por_id($elemento2[0]);
							$row_dt=mysql_fetch_array($dt);
							$row_palabra=$row_dt['traduccion'];
						}
						
						$li.="<li id=\"thelist2_".rawurldecode($elemento[1])."\">".$row_palabra."</li>";
					} else {
						$li.="<li id=\"thelist2_".rawurldecode($elemento[1])."\">".$elemento2[0]."</li>";
					}
					
				} elseif ($elemento2[2]==2) {
					
					$li.="<li id=\"thelist2_".rawurldecode($elemento[1])."\">".$elemento2[0]."</li>";
					
				}
		
			}

	}
}
echo $li."<input name=\"mi_seleccion\" type=\"hidden\" id=\"mi_seleccion\" value=\"".$frase."\"/>";
?>
        </ul>
        
        </div></td>
          </tr>
        
        <tr>
          <td height="22" colspan="2" align="center" valign="top">&nbsp;</td>
          </tr>
        <tr>
          <td height="22" colspan="2" align="center" valign="top"><p><?php echo $translate['antes_paso_2']; ?></p>
            <p>
              <input name="guardar" type="submit" id="guardar" value="<?php echo $translate['ir_paso_2']; ?>" style="font-size:24px;" />
            </p></td>
        </tr>
      </table>
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
    <script type="text/javascript" language="javascript" charset="utf-8">
// <![CDATA[
		
		Sortable.create('thelist2',{containment:['thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); },
        onChange:function(element){document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2');  }});
		
		Sortable.create('thelist3',{containment:['thelist3','thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); },
        onChange:function(element){document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); }});
		
		Droppables.add('thelist3', {onDrop:function(element){ 
		document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); 
			}});
					  
	// ]]>
  </script>	
</body>
</html>


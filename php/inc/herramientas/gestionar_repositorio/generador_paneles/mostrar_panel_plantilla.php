<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
$query=new query();

$datos=$query->datos_plantilla_panel($_POST['id']);

echo utf8_encode($datos['descripcion_plantilla'].'<br /><br /><b>Vista Previa:</b><br />La apariencia de esta vista no se corresponde plenamente con el resultado final, una vez exportado. El tablero mostrado es sólo a efectos de composición.<br /><br />');

$tablero=$datos['tablero_html'];

	for ($p=1; $p<=$datos['n_paneles']; $p++){ // PANELES
	
		if ($datos['con_borde']==1) { $borde='style="border: 1px solid '.$datos['color_borde'].';"'; } else { $borde='style="border: 1px dashed #CCC;"';}
		
			for ($f=1; $f<=$datos['n_filas']; $f++){ // FILAS

					for ($c=1; $c<=$datos['n_columnas']; $c++){ //COLUMNAS 
						
						$contenido='';
						
						//$contenido.=''.$p.'-'.$f.'-'.$c.'&nbsp;&nbsp;';
														
						$contenido.='<input type="hidden" name="img_'.$p.'_'.$f.'_'.$c.'" id="img_'.$p.'_'.$f.'_'.$c.'" value=""/>
						<a href="javascript:void(0);" onclick="Dialog.alert({url: \'seleccionar_pictograma.php?panel='.$p.'&fila='.$f.'&columna='.$c.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:500}, okLabel: \'Cerrar\'});"><img src="../../../images/dhtmlgoodies_plus.gif" alt="Adjuntar pictograma a la celda: '.$p.'-'.$f.'-'.$c.'" title="Adjuntar pictograma a la celda: '.$p.'-'.$f.'-'.$c.'" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="eliminar_pictograma_paneles('.$p.','.$f.','.$c.');"><img src="../../../images/dhtmlgoodies_minus.gif" alt="Borrar pictograma de la celda: '.$p.'-'.$f.'-'.$c.'" title="Borrar pictograma de la celda: '.$p.'-'.$f.'-'.$c.'"  border="0" /></a>&nbsp;&nbsp;';
						if ($datos['configuracion_celda']==1) {
						
							$contenido.='<a href="javascript:void(0);" onclick="Dialog.alert({url: \'configurar_celda.php?panel='.$p.'&fila='.$f.'&columna='.$c.'&bc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.bc_'.$p.'_'.$f.'_'.$c.'.value+\'&abc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.abc_'.$p.'_'.$f.'_'.$c.'.value+\'&ptc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.ptc_'.$p.'_'.$f.'_'.$c.'.value+\'&ftc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.ftc_'.$p.'_'.$f.'_'.$c.'.value+\'&sftc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.sftc_'.$p.'_'.$f.'_'.$c.'.value+\'&mtc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.mtc_'.$p.'_'.$f.'_'.$c.'.value+\'&tist_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.tist_'.$p.'_'.$f.'_'.$c.'.value+\'&tict_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.tict_'.$p.'_'.$f.'_'.$c.'.value+\'&tbc_'.$p.'_'.$f.'_'.$c.'=\'+document.generador_paneles.tbc_'.$p.'_'.$f.'_'.$c.'.value+\'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:300, height:350}, okLabel: \'Cerrar\'});"><img border="0" alt="Configurar Celda"  title="Configurar Celda" src="../../../images/vcard_edit.png" /></a>
							<input type="hidden" name="bc_'.$p.'_'.$f.'_'.$c.'" id="bc_'.$p.'_'.$f.'_'.$c.'" value="'.$datos['default_borde_celda'].'"/>
							<input type="hidden" name="tbc_'.$p.'_'.$f.'_'.$c.'" id="tbc_'.$p.'_'.$f.'_'.$c.'" value="single"/>
							<input type="hidden" name="abc_'.$p.'_'.$f.'_'.$c.'" id="abc_'.$p.'_'.$f.'_'.$c.'" value="3"/>
							<input type="hidden" name="ptc_'.$p.'_'.$f.'_'.$c.'" id="ptc_'.$p.'_'.$f.'_'.$c.'" value="'.$datos['default_posicion_texto_celda'].'"/>
							<input type="hidden" name="ftc_'.$p.'_'.$f.'_'.$c.'" id="ftc_'.$p.'_'.$f.'_'.$c.'" value="Arial"/>
							<input type="hidden" name="sftc_'.$p.'_'.$f.'_'.$c.'" id="sftc_'.$p.'_'.$f.'_'.$c.'" value="18"/>
							<input type="hidden" name="mtc_'.$p.'_'.$f.'_'.$c.'" id="mtc_'.$p.'_'.$f.'_'.$c.'" value="0"/>
							<input type="hidden" name="tist_'.$p.'_'.$f.'_'.$c.'" id="tist_'.$p.'_'.$f.'_'.$c.'" value="'.$datos['img_size_no_text'].'"/>
							<input type="hidden" name="tict_'.$p.'_'.$f.'_'.$c.'" id="tict_'.$p.'_'.$f.'_'.$c.'" value="'.$datos['img_size_with_text'].'"/>';
						
						}

						$contenido.='<br /><br /><img name="imagen_'.$p.'_'.$f.'_'.$c.'" id="imagen_'.$p.'_'.$f.'_'.$c.'" src="../../../images/blank.jpg" border="0">';
						if ($datos['con_texto']==1) {
							$contenido.='<br /><input type="text" name="txt_'.$p.'_'.$f.'_'.$c.'" id="txt_'.$p.'_'.$f.'_'.$c.'" value="" size="10"/><input type="text" name="ctc_'.$p.'_'.$f.'_'.$c.'" id="ctc_'.$p.'_'.$f.'_'.$c.'" value="#000000" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'ctc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="Seleccione el color del Texto" title="Seleccione el color del Texto" src="../../../images/color_font.gif" /></a>';
						}
						
						if ($datos['configuracion_celda']==1) {
						
							$contenido.='<br /><b>Marco celda:</b> <input type="text" name="cbc_'.$p.'_'.$f.'_'.$c.'" id="cbc_'.$p.'_'.$f.'_'.$c.'" value="#000000" size="2" maxlength="7"/><a href="javascript:TCP.popup(document.forms[\'generador_paneles\'].elements[\'cbc_'.$p.'_'.$f.'_'.$c.'\'])"><img width="18" height="18" border="0" alt="Seleccione el color del marco" title="Seleccione el color del marco" src="../../../images/color_font.gif" /></a>';
						
						}
						
						$que[] = "{{".$p."_".$f."_".$c."}}"; 
						$por[] = $contenido; 
					} 
					
			} 
	}	
$contenido=str_replace($que,$por,$tablero);
$contenido2=str_replace("{{borde}}", $borde, $contenido);
echo $contenido2;			
?>

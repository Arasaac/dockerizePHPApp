<?php 
session_start();

include ('../../../classes/querys/query.php');
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$query=new query();

$n_items=$_POST['n_items'];
$principal=$_POST['principal'];
$panel_width=$_POST['panel_width'];
$simbolos_width=$_POST['simbolos_width'];
$principal_width=$_POST['principal_width'];
$borde_panel=$_POST['borde_panel'];
$grosor_borde_panel=$_POST['grosor_borde_panel'];
$color_borde_panel=$_POST['color_borde_panel'];
$panel_color_fondo=$_POST['panel_color_fondo'];

$borde_simbolos=$_POST['borde_simbolos'];
$grosor_borde_simbolos=$_POST['grosor_borde_simbolos'];
$color_borde_simbolos=$_POST['color_borde_simbolos'];
$espacio_entre_simbolos=$_POST['espacio_entre_simbolos'];

$borde_simbolo_principal=$_POST['borde_simbolo_principal'];
$grosor_borde_simbolo_principal=$_POST['grosor_borde_simbolo_principal'];
$color_borde_simbolo_principal=$_POST['color_borde_simbolo_principal'];

$contenido_panel=$_POST['contenido_panel'];
$nombre_panel=$_POST['nombre_panel'];
$tags_panel=$_POST['tags_panel'];

$txt_inferior=$_POST['txt_inferior'];
$txt_superior=$_POST['txt_superior'];

$id_panel=$_POST['id_panel'];
$id_usuario=$_POST['id_usuario'];

if (isset($id_panel) && $id_panel=='') {

$text_smb=explode(";",$contenido_panel); 	
$text_n_simb=count($text_smb);
			
	for ($h=0; $h<=$text_n_simb; $h++){
			if (!empty($text_smb[$h])) {
				$text_simbolo=explode("|", $text_smb[$h]);
				
					if ($text_simbolo[0] != 'allItems') {
						
						if (substr_count($text_simbolo[1],'node') > 0) { $item=explode('node',$text_simbolo[1]); }
						elseif (substr_count($text_simbolo[1],'txt') > 0) { $item=explode('txt',$text_simbolo[1]); }
						
						$contenido_panel.=$text_simbolo[0].'|'.$text_simbolo[1].';';
						//$item_box=explode('box',$text_simbolo[0]);
						//$box[$item_box[1]]=$item[1];
					} 
			}
	}
	
$n_panel=$query->guardar_nuevo_panel($id_usuario,$n_items,$principal,$panel_width,$simbolos_width,$principal_width,$borde_panel,$grosor_borde_panel,$color_borde_panel,$borde_simbolos,$grosor_borde_simbolos,$color_borde_simbolos,$borde_simbolo_principal,$grosor_borde_simbolo_principal,$color_borde_simbolo_principal,$contenido_panel,$nombre_panel,$tags_panel,$txt_inferior,$txt_superior,$panel_color_fondo,$espacio_entre_simbolos);

echo '<input name="id_panel" type="hidden" id="id_panel" value="'.$n_panel.'">SU PANEL HA SIDO GUARDADO ';

} elseif (isset($id_panel) && $id_panel !='') {

$text_smb=explode(";",$contenido_panel); 	
$text_n_simb=count($text_smb);
			
	for ($h=0; $h<=$text_n_simb; $h++){
			if (!empty($text_smb[$h])) {
				$text_simbolo=explode("|", $text_smb[$h]);
				
					if ($text_simbolo[0] != 'allItems') {
						
						if (substr_count($text_simbolo[1],'node') > 0) { $item=explode('node',$text_simbolo[1]); }
						elseif (substr_count($text_simbolo[1],'txt') > 0) { $item=explode('txt',$text_simbolo[1]); }
						$contenido_panel.=$text_simbolo[0].'|'.$text_simbolo[1].';';
					} 
			}
	}

$panel=$query->actualizar_panel($id_panel,$id_usuario,$n_items,$principal,$panel_width,$simbolos_width,$principal_width,$borde_panel,$grosor_borde_panel,$color_borde_panel,$borde_simbolos,$grosor_borde_simbolos,$color_borde_simbolos,$borde_simbolo_principal,$grosor_borde_simbolo_principal,$color_borde_simbolo_principal,$contenido_panel,$nombre_panel,$tags_panel,$txt_inferior,$txt_superior,$panel_color_fondo,$espacio_entre_simbolos);

echo '<input name="id_panel" type="hidden" id="id_panel" value="'.$id_panel.'">SU PANEL HA SIDO ACTUALIZADO';

}



?>
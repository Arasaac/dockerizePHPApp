<?php 
//displayMessage("creador_simbolos/creador_simbolos.php");

	$menu_principal=utf8_encode('<div class="bar" style="text-align:center;"><ul id="bar">
					<li><a href="index.php">'.$translate['inicio'].'</a></li><span class="separador_naranja">|
					<li><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/condiciones_uso.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");\'>'.$translate['condiciones_uso'].'</a></li><span class="separador_naranja">|</span>
					<li><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/catalogos.php","i=","principal"); cargar_div("inc/menu_subprincipal.php","i=","submenu");\'>'.$translate['catalogos'].'</a></li><span class="separador_naranja">|</span>');
	
	$menu_principal.='<li><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/descargas.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");\'>'.$translate['descargas'].'</a></li><span class="separador_naranja">|<li><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/caa.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu"); cargar_div("inc/menu_subprincipal_caa.php","i=","submenu");\'>'.$translate['caa'].'</a></li><span class="separador_naranja">|</span>
	<li><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/materiales.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");\'>'.$translate['materiales'].'</a></li>';
	
	$menu_principal.='<span class="separador_naranja">|</span> <li><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/herramientas.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");\'>'.$translate['herramientas'].'</a></li>';		
	
	$menu_principal.='</ul></div>';
?>	

<!--<span class="separador_naranja">|</span> 					<li><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/listado_enlaces.php","i=","principal");\'>'.$translate['otras_webs'].'</a></li><span class="separador_naranja"> | </span> <li><a href="javascript:void(0);" onClick="Dialog.alert({url: \'inc/public/contacta.php\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:550, height:470}, okLabel: \''.$translate['cerrar'].'\'});">'.$translate['contacta'].'</a></li>-->

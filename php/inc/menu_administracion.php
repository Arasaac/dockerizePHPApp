<?php 
$menu_administracion='';

///******************************************************************************************///
///******************************************************************************************///

if ($permisos['add_imagenes']==1 || $permisos['borrar_imagenes']==1 ) {

	$menu_administracion.='<b>Administracion:</b> <a href="javascript:void(0);" onClick=\'cargar_div("inc/gestion_imagenes/gestionar_imagenes.php","i=","principal");\'> Gestionar Originales</a> | ';

}

///******************************************************************************************///
///******************************************************************************************///

if ($permisos['add_simbolos']==1 || $permisos['borrar_simbolos']==1 ) {

	$menu_administracion.=utf8_encode('<a href="javascript:void(0);" onClick=\'cargar_div("inc/gestion_simbolos/gestionar_simbolos.php","i=","principal");\'> Gestionar Símbolos </a> | <a href="javascript:void(0);" onClick=\'cargar_div("inc/gestion_simbolos/busqueda_simbolos_especiales.php","i=","principal");\'> Gestionar Símbolos Especiales</a> | ');

}

///******************************************************************************************///
///******************************************************************************************///

if ($permisos['traduccion_ruso']==1 || $permisos['traduccion_arabe']==1 || $permisos['traduccion_rumano']==1 || $permisos['traduccion_chino']==1 || $permisos['definicion_palabras']==1 ||  $permisos['gestion_palabras']==1) {

$menu_administracion.='<a href="javascript:void(0);" onClick=\'cargar_div("inc/gestion_palabras/gestionar_palabras.php","i=","principal");\'> Gestionar Palabras</a> | ';

}

///******************************************************************************************///
///******************************************************************************************///

if ($permisos['gestion_usuarios']==1) {

$menu_administracion.='<a href="javascript:void(0);" onClick=\'cargar_div("inc/gestion_usuarios/gestionar_usuarios.php","i=","principal");\'> Gestionar Usuarios</a> | <a href="javascript:void(0);" onClick=\'cargar_div("inc/gestion_autores/gestionar_autores.php","i=","principal");\'> Gestionar Autores</a> | <a href="javascript:void(0);" onClick=\'cargar_div("inc/admin/listados.php","i=","principal");\'> Listados</a>';

}
?>
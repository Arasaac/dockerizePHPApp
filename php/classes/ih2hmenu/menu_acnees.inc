 <?
	$menu->setMainLink('Mi panel');
	$menu->setSubLink('Mi panel','Abrir',''.$PHP_SELF.'?id_usuario='.$_GET['id_usuario'].'&id_blog='.$_GET['id_blog'].'&opc=30');
	$menu->setSubLink('Mi panel','Guardar',''.$PHP_SELF.'?id_usuario='.$_GET['id_usuario'].'&id_blog='.$_GET['id_blog'].'&opc=29');
	$menu->setSubLink('Mi panel','Editar Mi Panel',''.$PHP_SELF.'?id_usuario='.$_GET['id_usuario'].'&id_blog='.$_GET['id_blog'].'&opc=19');
	$menu->setSubLink('Mi panel','Configurar entorno',''.$PHP_SELF.'?id_usuario='.$_GET['id_usuario'].'&id_blog='.$_GET['id_blog'].'&opc=26');
	$menu->setSubLink('Mi panel','Reordenar símbolos',''.$PHP_SELF.'?id_usuario='.$_GET['id_usuario'].'&id_blog='.$_GET['id_blog'].'&opc=28');
	
	$menu->setMainLink('Gestión Paneles');
	$menu->setSubLink('Gestión Paneles','Asignar',''.$PHP_SELF.'?id_usuario='.$_GET['id_usuario'].'&id_blog='.$_GET['id_blog'].'&opc=31');
	$menu->setSubLink('Gestión Paneles','Editar',''.$PHP_SELF.'?id_usuario='.$_GET['id_usuario'].'&id_blog='.$_GET['id_blog'].'&opc=33');
	$menu->setSubLink('Gestión Paneles','Borrar',''.$PHP_SELF.'?id_usuario='.$_GET['id_usuario'].'&id_blog='.$_GET['id_blog'].'&opc=32');
	
	$menu->setMainLink('Diccionarios');
	$menu->setSubLink('Diccionarios','PDF',''.$PHP_SELF.'?id_usuario='.$_GET['id_usuario'].'&id_blog='.$_GET['id_blog'].'&opc=27');
	
	$menu->setMainLink('Teclado');
	$menu->setSubLink('Teclado','Configuración',''.$PHP_SELF.'?id_usuario='.$_GET['id_usuario'].'&id_blog='.$_GET['id_blog'].'&opc=22');
	
	$menu->setMainLink('Datos Usuario',''.$PHP_SELF.'?id_usuario='.$_GET['id_usuario'].'&opc=8');

	$menu->makeDivs();
?>
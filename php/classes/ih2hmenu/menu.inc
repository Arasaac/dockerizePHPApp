 <?
	$menu->setMainLink($lang['seleccionar_blog'],''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=11');
	
	$menu->setMainLink($lang['edicion_blog']);
	$menu->setSubLink($lang['edicion_blog'],$lang['nuevo_articulo'],''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=17');
	$menu->setSubLink($lang['edicion_blog'],$lang['gestionar_articulos'],''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=12');
	$menu->setSubLink($lang['edicion_blog'],$lang['categorias'],''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=13');
	$menu->setSubLink($lang['edicion_blog'],$lang['enlaces'],''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=14');
	
	$menu->setMainLink($lang['podcast']);
	$menu->setSubLink($lang['podcast'],$lang['nuevo_podcast'],''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=35');
	$menu->setSubLink($lang['podcast'],$lang['gestionar_podcast'],''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=36');
	$menu->setSubLink($lang['podcast'],$lang['canales_podcast'],''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=34');
	
	$menu->setMainLink($lang['blog']);
	$menu->setSubLink($lang['blog'],$lang['configurar_blog'],''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=18');
	$menu->setSubLink($lang['blog'],$lang['estadisticas'],''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=20');
	
	$menu->setMainLink($lang['catalogo_imagenes']);
	$menu->setSubLink($lang['catalogo_imagenes'],'Subir Imágenes',''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=3');
	$menu->setSubLink($lang['catalogo_imagenes'],'Ver Catálogo',''.$PHP_SELF.'?id_blog='.$_GET['id_blog'].'&opc=10');

	$menu->makeDivs();
?>
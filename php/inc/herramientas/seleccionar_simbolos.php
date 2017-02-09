<?php 
session_start();

include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Herramientas ARASAAC</title>
	<link rel="stylesheet" href="../../css/style.css" type="text/css" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <script src="../../js/scriptaculous/prototype.js" type="text/javascript"></script>
  <script src="../../js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
  <script src="../../js/scriptaculous/unittest.js" type="text/javascript"></script>
  <script type="text/javascript" src="../../js/ajax.js"></script>
  <link rel="stylesheet" href="../../css/style.css" type="text/css" />
  <style type="text/css" media="screen">
    ul { height: 100px; border:1px dotted #888; }
  </style>
</head>
<body>
<div class="body_content">
<link rel="STYLESHEET" type="text/css" href="../../js/dhtmlxMenu/css/dhtmlXMenu.css">
	<script language="JavaScript" src="../../js/dhtmlxMenu/js/dhtmlXProtobar.js"></script>
	<script language="JavaScript" src="../../js/dhtmlxMenu/js/dhtmlXMenuBar.js"></script>
	<script language="JavaScript" src="../../js/dhtmlxMenu/js/dhtmlXCommon.js"></script>	
    	<table>
		<tr>
			<td>
				<div id="menu_zone" style="width:600;background-color:#f5f5f5;border :1px solid Silver;"/>
			</td>
		</tr>
		<tr>
		<td>
			
		</td>
		</tr>
	</table>
<hr>

	<script>
	
		function onButtonClick(itemId,itemValue)
		{};
		aMenuBar=new dhtmlXMenuBarObject(document.getElementById('menu_zone'),'100%',16,"");
		aMenuBar.setOnClickHandler(onButtonClick);
		aMenuBar.setGfxPath("../../images/");
		aMenuBar.loadXML("../../js/dhtmlxMenu/_menu.xml");
		aMenuBar.showBar();
	</script>
    <table width="144" border="0">
              <tr>
                <td width="25%"><img src="../../images/carrito_compra.gif" alt="Ver mi cesto de s&iacute;mbolos"  title="Ver mi cesto de s&iacute;mbolos" border="0" />&nbsp;&nbsp;</td>
                <td width="17%">
                <div id="n_cesto">
                  <?php $n=0;
		if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") { foreach ($_SESSION['cart'] as $key => $value) { $n=$n+1; } }  echo $n; ?>
                </div></td>
                <td width="17%"><a href="javascript:void(0);" onClick="Dialog.alert({url: 'zip.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:400, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});"><img src="../../images/zip-icon.gif" alt="Comprimir mi cesto en un archivo ZIP" border="0" /></a></td>
                <td width="41%"><div id="clearCart" onclick="clearCart();"><img src="../../images/papelera.png" alt="Vaciar mi cesto de s&iacute;mbolos" /></div>
                <div id="loading"><img src="images/loading2.gif" alt="Cargando..." /></div> </td>
              </tr>
            </table>
            
<div id="principal">
<form action="javacript:void();" name="seleccion_simbolos" id="seleccion_simbolos" >
<table width="100%" border="0">
  <tr>
    <td width="50%">Carrito de la Compra
      <ul id="thelist1">
<?php foreach ($_SESSION['cart'] as $key => $value) {

			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
			$ruta=$key['ruta_cesto'];
			$ruta_img='size=50&ruta=../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 
			
				print "<li id=\"thelist1_".$ruta_cesto."\"><a href=\"javascript:ventana_modal('img=../../$key&enc=0','inc/imagen.php')\"><img src=\"../../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a></li>";
} ?>
</ul></td>
    <td width="50%" valign="top">Mi Repositorio
      <ul id="thelist1">
<?php foreach ($_SESSION['cart'] as $key => $value) {

			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
			$ruta=$key['ruta_cesto'];
			$ruta_img='size=50&ruta=../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 
			
				print "<li id=\"thelist1_".$ruta_cesto."\"><a href=\"javascript:ventana_modal('img=../../$key&enc=0','inc/imagen.php')\"><img src=\"../../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a></li>";
} ?>
</ul></td>
  </tr>
</table>



Selección
<div id="borrar_mi_seleccion" onclick="borrar_mi_seleccion();"><img src="../../images/papelera.png" alt="Vaciar mi seleccion" /></div>
<ul id="thelist2">
  <?php foreach ($_SESSION['mi_seleccion'] as $key => $value) {

			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
			$ruta=$key['ruta_cesto'];
			$ruta_img='size=50&ruta=../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 
			
			print "<li id=\"thelist2_".$ruta_cesto."\"><a href=\"javascript:ventana_modal('img=../../$key&enc=0','inc/imagen.php')\"><img src=\"../../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a></li>";
} ?>
</ul>

<div align="center">
  <p>
    <script type="text/javascript" language="javascript" charset="utf-8">
// <![CDATA[
		Sortable.create('thelist1',{containment:['thelist1','thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){document.seleccion_simbolos.cesto.value=Sortable.serialize('thelist1'); document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2');  },
        onChange:function(element){document.seleccion_simbolos.cesto.value=Sortable.serialize('thelist1'); document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); }});
		
		
		Sortable.create('thelist2',{containment:['thelist1','thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){document.seleccion_simbolos.cesto.value=Sortable.serialize('thelist1'); document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); },
        onChange:function(element){document.seleccion_simbolos.cesto.value=Sortable.serialize('thelist1'); document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2');  }});
					  
		Droppables.add('thelist2', {onDrop:function(element){ 
		document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2');
		document.seleccion_simbolos.cesto.value=Sortable.serialize('thelist1'); 
			}});  
		Droppables.add('thelist1', {onDrop:function(element){ 
		document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2');
		document.seleccion_simbolos.cesto.value=Sortable.serialize('thelist1'); 
			}});
	// ]]>
  </script>
    <input name="guardar" type="button" id="guardar" value="GUARDAR MI SELECCION" onclick="cargar_div('guardar_mi_seleccion.php',''+document.seleccion_simbolos.mi_seleccion.value+'','resultado');" />
  </p>
  <p>
    <input name="cesto" type="hidden" id="texto" value="" size="100" />
    <input name="mi_seleccion" type="hidden" id="simbolos" value="" size="100" />
    </p>
</div>

</form>
<div id="resultado"></div>
</div>
</div>
</body>
</html>


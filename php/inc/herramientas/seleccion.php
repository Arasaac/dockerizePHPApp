<?php 
session_start();

if ($_SESSION['ID_USER'] == '' || $_SESSION['ID_USER']==0) {

}

unset($_SESSION['mi_seleccion']);

include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
require_once('classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$id_usuario=$_SESSION['ID_USER'];

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$id_usuario=$_SESSION['ID_USER'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Herramientas ARASAAC</title>
	<link rel="stylesheet" href="../../css/style.css" type="text/css" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <script src="js/scriptaculous/prototype.js" type="text/javascript"></script>
  <script src="js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
  <script src="js/scriptaculous/unittest.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/ajax_herramientas.js"></script>
  <link rel="stylesheet" href="../../css/style.css" type="text/css" />
  
    <link rel="StyleSheet" href="js/dtree/dtree.css" type="text/css" />
	<script type="text/javascript" src="js/dtree/dtree.js"></script>
    
    <script type="text/javascript" src="js/windows_js_0.96.2/javascripts/effects.js"> </script>
  	<script type="text/javascript" src="js/windows_js_0.96.2/javascripts/window.js"> </script>
  	<script type="text/javascript" src="js/windows_js_0.96.2/javascripts/debug.js"> </script>
	<link href="js/windows_js_0.96.2/themes/default.css" rel="stylesheet" type="text/css" >	 </link>
  	<link href="js/windows_js_0.96.2/themes/alphacube.css" rel="stylesheet" type="text/css" >	 </link>
	<link href="js/windows_js_0.96.2/themes/alert.css" rel="stylesheet" type="text/css" >	 </link>
	<link href="js/windows_js_0.96.2/themes/alert_lite.css" rel="stylesheet" type="text/css" >	 </link>
  	<link href="js/windows_js_0.96.2/themes/debug.css" rel="stylesheet" type="text/css" >	 </link>
    
  <style type="text/css" media="screen">
    ul { height: 100px; border:1px dotted #888; }
  </style>
</head>
<body>
<div class="body_content">
<link rel="STYLESHEET" type="text/css" href="js/dhtmlxMenu/css/dhtmlXMenu.css">
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXProtobar.js"></script>
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXMenuBar.js"></script>
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXCommon.js"></script>
     <script type="text/javascript" src="js/nornixtreemenu/treemenu/nornix-treemenu.js"></script>
    <link rel="StyleSheet" href="js/nornixtreemenu/skins/default/menu.css" type="text/css" media="screen" />
        <table width="100%">
	  <tr>
			<td width="78%">
			  <div id="menu_zone" style="width:600;background-color:#f5f5f5;border :1px solid Silver;"/>
			</td>
     <td width="22%">
<table width="100%" border="0">
              <tr>
                <td width="54%" align="right"> <img src="../../images/refresh.png" alt="Refrescar página" width="48" height="48" onClick="javascript:window.location.reload();" /></td>
        </tr>
            </table>
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
		<?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {  ?>
		aMenuBar.loadXML("js/dhtmlxMenu/_menu.xml");
		<?php } else {  ?>
		aMenuBar.loadXML("js/dhtmlxMenu/_menu_invitado.xml");
		<?php } ?>
		aMenuBar.showBar();
	</script>
	<div id="principal">
<form action="javacript:void();" name="seleccion_simbolos" id="seleccion_simbolos" >

<div id="mi_repositorio">
      <table width="100%" border="0">
        <tr>
          <td valign="top"><a href="javascript:void(0);" onClick="Dialog.alert({url: 'gestionar_seleccion/abrir_seleccion.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:700}, okLabel: 'Cerrar'});"><img src="../../images/kappfinder.png" alt="Abrir Panel" width="35" height="35" border="0" /></a><a href="seleccion.php" target="_self"><img src="../../images/new_f2.png" alt="Nuevo Panel" width="32" height="32" border="0" /></a></td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="16%" valign="top">
          <p><strong>Añadir pictogramas desde mi repositorio </strong><br/></p> 
          <div class="dtree">
            <script type="text/javascript">
                <!--
        
                d = new dTree('d');
        
                <?php  
                $folders=$query->listado_directorios_usuario($id_usuario);
                                        
                    while ($inf=mysql_fetch_array($folders)) {
                    
                         if ($inf["parent"]==0) {
                         
                             print "d.add(".$inf["id"].",-1,'Mi repositorio','javascript:Dialog.alert({url:  \'gestionar_seleccion/listar_directorio.php?id=".$inf['id']."&id_usuario=".$id_usuario."&s=".$_GET['s']."\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:700}, okLabel: \'Cerrar\'});');
							 ";
                      
                         } else {
                                
                            print "d.add(".$inf["id"].",".$inf["parent"].",'".$inf["name"]."','javascript:Dialog.alert({url:  \'gestionar_seleccion/listar_directorio.php?id=".$inf['id']."&id_usuario=".$id_usuario."&s=".$_GET['s']."\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:700}, okLabel: \'Cerrar\'});');
							 ";
                    
                        }
                    
                    }
                ?>
        
                document.write(d);
        
                //-->
            </script>

		</div>
        <br />
        <strong>Borrar pictogramas de la selección        </strong><br /><br />
        <ul id="thelist3" style="height:350px; margin-right:10px; background:url(../../images/trash.png) no-repeat left top; border:1px dashed #999999;"></ul>        </td>
       <td width="44%" valign="top"><p><strong>Nueva Selección</strong></p>
        <?php 
		 if (isset($_GET['s']) && $_GET['s']>0) {
		   
		   $datos_seleccion=$query->datos_seleccion($_GET['s'],$id_usuario);
		 }
		?>
        <div id="mensaje" style="border:1px solid #CC0000; margin:10px; color:#FF0000; height:20px; text-align:center; font-size:14px;"></div>
          <p><strong>Nombre:</strong>
  <input name="nombre_seleccion" type="text" id="nombre_seleccion" size="50" maxlength="100" value="<?php echo $datos_seleccion['seleccion'];  ?>" />
</p>
<p><strong>Tags:</strong>
  <input name="tags" type="text" id="tags" size="50" maxlength="100"  value="<?php echo $datos_seleccion['tags'];  ?>" /> 
  (separados por comas)</p>
<p><a href="javascript:void(0);" onClick="Sortable.create('thelist2',{containment:['thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){ document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); },
        onChange:function(element){ document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2');  }}); return false;">Ordenar Selección</a> | 
<a href="javascript:void(0);" onClick="Sortable.destroy('thelist2');return false;">Dejar de Ordenar</a></p>
<ul id="thelist2" style="height:300px; overflow:scroll;">
  <?php 
if (isset($_GET['s']) && $_GET['s']>0) {
	$simbolos_seleccion=$query->datos_simbolos_seleccion($_GET['s'],$id_usuario);
	while ($row=mysql_fetch_array($simbolos_seleccion)) {
	
			if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
			elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
			
			$ruta_img='size=80&ruta=../../../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 
			$_SESSION['mi_seleccion'][$id_file] = 1;
			print "<li id=\"thelist2_".$row['file_id']."\><a href=\"javascript:void(0)\"><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a></li>";
			
	}
} elseif (!isset($_GET['s']))   {
  if (isset($_SESSION['mi_seleccion']) != '' ) { 
  		foreach ($_SESSION['mi_seleccion'] as $key => $value) {

			$row=$query->datos_archivo_repositorio($key);
			
			if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
			elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
	
			$ruta_img='size=80&ruta=../../../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 
			print "<li id=\"thelist2_".$key."\"><a href=\"javascript:void(0)\"><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a></li>";
		} 
	}
}  ?>
</ul>
<div align="center">
<?php if (isset($_GET['s']) && $_GET['s']>0) { ?>
  <input name="guardar" type="button" id="guardar" value="MODIFICAR MI SELECCION" onClick="document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2');procesar('gestionar_seleccion/modificar_seleccion.php',''+document.seleccion_simbolos.mi_seleccion.value+'&id_usuario='+document.seleccion_simbolos.id_usuario.value+'&nombre_seleccion='+document.seleccion_simbolos.nombre_seleccion.value+'&tags='+document.seleccion_simbolos.tags.value+'&id_seleccion=<?php echo $_GET['s']; ?>','mensaje');" style="font-size:18px;" />
<?php } else { ?>
  <input name="guardar" type="button" id="guardar" value="GUARDAR MI SELECCION" onClick="document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2');guardar_nueva_seleccion('gestionar_seleccion/guardar_nueva_seleccion.php',''+document.seleccion_simbolos.mi_seleccion.value+'&id_usuario='+document.seleccion_simbolos.id_usuario.value+'&nombre_seleccion='+document.seleccion_simbolos.nombre_seleccion.value+'&tags='+document.seleccion_simbolos.tags.value+'','mensaje');" style="font-size:18px;" />
<?php } ?>
  </p>
</div>
<p>
    <input name="id_usuario" type="hidden" id="id_usuario" value="<?php echo $_SESSION['ID_USER']; ?>" size="100" />
    <input name="mi_seleccion" type="hidden" id="mi_seleccion" size="100" />
    <input name="accion" type="hidden" id="accion" value="" size="100" />
</td>
        </tr>
      </table>
 </div>
<div align="center">
</div>
    <script type="text/javascript" language="javascript" charset="utf-8">
// <![CDATA[
		
		Sortable.create('thelist2',{containment:['thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); },
        onChange:function(element){document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2');  }});
		
		Sortable.create('thelist3',{containment:['thelist3','thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); document.seleccion_simbolos.accion.value=Sortable.serialize('thelist3'); },
        onChange:function(element){document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); document.seleccion_simbolos.accion.value=Sortable.serialize('thelist3'); }});
		
		
		Droppables.add('thelist3', {onDrop:function(element){ 
		document.seleccion_simbolos.accion.value=Sortable.serialize('thelist3');
		document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); 
			}});
					  
	// ]]>
  </script>
</form>
</div>
</div>
</body>
</html>


<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>Herramientas ARASAAC: Creador de Frases</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <script src="../js/scriptaculous/prototype.js" type="text/javascript"></script>
  <script src="../js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
  <script src="../js/scriptaculous/unittest.js" type="text/javascript"></script>
  <script type="text/javascript" src="../js/ajax_herramientas.js"></script>
  <link rel="stylesheet" href="../../../css/style.css" type="text/css" />
  <script type="text/javascript" src="../js/autosuggest/js/autosuggest.js" charset="utf-8"></script>
<link rel="stylesheet" href="../js/autosuggest/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
</head>
<body>
<div class="body_content">
<link rel="STYLESHEET" type="text/css" href="../js/dhtmlxMenu/css/dhtmlXMenu.css">
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXProtobar.js"></script>
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXMenuBar.js"></script>
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXCommon.js"></script>
        <table width="100%">
	  <tr>
			<td width="78%">
			  <div id="menu_zone" style="width:600;background-color:#f5f5f5;border :1px solid Silver;"/>
			</td>
     <td width="22%">
<table width="100%" border="0">
              <tr>
                <td width="54%" align="right"> <img src="../../../images/refresh.png" alt="Refrescar página" width="48" height="48" onClick="javascript:window.location.reload();" /></td>
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
		aMenuBar.setGfxPath("../../../images/");
		<?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {  ?>
		aMenuBar.loadXML("../js/dhtmlxMenu/_menu4.xml");
		<?php } else {  ?>
		aMenuBar.loadXML("../js/dhtmlxMenu/_menu4_invitado.xml");
		<?php } ?>
		aMenuBar.showBar();
	</script>
	<div id="principal">
<form action="creador_frases_2.php" method="post" name="seleccion_simbolos" id="seleccion_simbolos">
<div id="mi_repositorio">
 <h4>CREADOR DE FRASES v 0.1: PASO 1</h4>
      <table width="100%" border="0">
        <tr>
          <td colspan="2" valign="top">Escoge las palabras que forman tu frase. En caso de que la palabra no esté en el diccionario o que se desee añadir la palabra en modo texto (sin pictograma) pulsa en el signo más. Los verbos deben buscarse en infinitivo. En el siguiente paso, será posible conjugar el verbo.</td>
        </tr>
        <tr>
          <td colspan="2" align="center" valign="top"><input type="text" name="s" id="s" size="95" style="font-size:14px;"/>
            <input type="hidden" id="id_palabra" />
            <img src="../../../images/add.png" alt="Añadir" width="16" height="16" onClick="var buscar=document.getElementById('s').value; var mi_seleccion=document.getElementById('mi_seleccion').value; cargar_div2('paso2.php',''+mi_seleccion+'&amp;palabra='+buscar+'','thelist2'); document.seleccion_simbolos.s.value=''; " />
            <script type="text/javascript">
					var options = {
								script:"../js/autosuggest/procesar_para_frases.php?json=true&limit=15&",
								varname:"input",
								json:true,
								shownoresults:false,
								maxresults:10,
								callback: function (obj) { document.getElementById('id_palabra').value = obj.id; var mi_seleccion=document.getElementById('mi_seleccion').value; cargar_div2('paso2.php',''+mi_seleccion+'&palabra='+obj.id+'','thelist2'); document.seleccion_simbolos.s.value=""; }
							};
					var as_json = new bsn.AutoSuggest('s', options);
			 </script><hr /></td>
          </tr>
        <tr>
          <td width="29%" height="390" valign="top">
        <strong>Borrar palabras de la frase        </strong><br /><br />
        <ul id="thelist3" style="height:310px; margin-right:10px; background:url(../../../images/trash.png) no-repeat left top; border:1px dashed #999999;"></ul>        </td>
       <td width="71%" valign="top"><p><strong>Frase</strong></p>
         <p><a href="javascript:void(0);" onClick="Sortable.create('thelist2',{containment:['thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){ document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2'); },
        onChange:function(element){ document.seleccion_simbolos.mi_seleccion.value=Sortable.serialize('thelist2');  }}); return false;">Ordenar Selección</a> | 
<a href="javascript:void(0);" onClick="Sortable.destroy('thelist2');return false;">Dejar de Ordenar</a></p>
<ul id="thelist2" style="height:300px; overflow:scroll; border:1px dashed #CCCCCC; font-size:22px;">
<input name="mi_seleccion" type="hidden" id="mi_seleccion"/>
</ul>
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
  </script>		</td>
        </tr>
        <tr>
          <td height="22" colspan="2" align="center" valign="top"><span style="font-size:16px; color:#3366CC"><strong>Para configurar mi frase deseo utilizar:</strong></span><br /><br /> 
            <strong>Pictogramas de Color </strong>
            <input name="pictcolor" type="checkbox" id="pictcolor" value="1" checked="checked" /> 
            <strong>Pictogramas de Blanco y Negro</strong>
            <input name="pictnegro" type="checkbox" id="pictnegro" value="1" checked="checked" />
            <strong>Imágenes</strong>
            <input name="imagenes" type="checkbox" id="imagenes" value="1" checked="checked" />
             <br /><br /></td>
          </tr>
        <tr>
          <td height="22" colspan="2" align="center" valign="top"><p>Antes de ir al paso 2 ordene la frase tal y como desee</p>
            <p>
              <input name="guardar" type="submit" id="guardar" value="IR AL PASO 2" style="font-size:24px;" />
            </p></td>
        </tr>
      </table>
 </div>
</form>
</div>
</div>
</body>
</html>


<?php 
session_start();
include ('../../../classes/querys/query.php');
$query=new query();
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
        <!--<table width="100%">
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
        <hr>-->	

	<!--<script>
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
	</script>-->
	<div id="principal">
<form action="creador_frases_2.php" method="post" name="seleccion_simbolos" id="seleccion_simbolos">
<div id="mi_repositorio">
 <h4>CREADOR DE FRASES v 0.1: PASO 1</h4>
      <table width="100%" border="0">
        <tr>
          <td colspan="2" valign="top"><p>En este primer paso, debes añadir, una por una, las palabras que forman parte de la frase. Al escribir la palabra en el cuadro de búsqueda, el sistema sugiere aquellas acepciones (junto con su definición) que tienen algún pictograma o imagen en nuestra base de datos. Una vez desplegadas las sugerencias basta con pulsar en la palabra deseada para que ésta sea añadida en el cuadro inferior (FRASE). En caso de que la palabra no esté en el diccionario o que se desee añadir la palabra en modo texto (sin pictograma o imagen) debe escribirse la palabra en el cuadro y pulsar en el signo más. Los verbos deben buscarse en infinitivo. En el PASO 2, será posible conjugar el verbo.</p>
            <p>Para borrar una palabra u ordenar las palabras añadidas, debe pulsarse en &quot;Ordenador Selección&quot;. A continuación, si desea borrar alguna palabra, arrástrela la cuadro de la izquierda (papelera). En caso de querere reordenarlas, tras haber pulsado en &quot;Ordenar Selección&quot;, arrastrelas a su posición. </p></td>
        </tr>
        <tr>
          <td colspan="2" align="center" valign="top"><strong>Palabra:
            </strong>
            <input type="text" name="s" id="s" size="95" style="font-size:14px;"/>
            <a href="javascript:void(0);" onClick="var buscar=document.getElementById('s').value; var mi_seleccion=document.getElementById('mi_seleccion').value; cargar_div2('paso2.php',''+mi_seleccion+'&amp;palabra='+buscar+'','thelist2'); document.seleccion_simbolos.s.value='';"><strong>Añadir</strong></a>
            <input name="id_palabra" type="hidden" id="id_palabra" />
            <img src="../../../images/add.png" alt="Añadir" width="16" height="16" onClick="var buscar=document.getElementById('s').value; var mi_seleccion=document.getElementById('mi_seleccion').value; cargar_div2('paso2.php',''+mi_seleccion+'&palabra='+buscar+'','thelist2'); document.seleccion_simbolos.s.value=''; " />
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
<?php 
if (isset($_POST['mi_seleccion'])) {
	
	$seleccion=explode('&',$_POST['mi_seleccion']);

	foreach ($seleccion as $indice=>$valor){ 

			$elemento=explode('thelist2[]=',$valor);
	
			if ($elemento[1] !='') {
			
				$frase.='thelist2[]='.$elemento[1].'&';
					
					if ($elemento[1] > 0) {
						$dp=$query->datos_palabra($elemento[1]);
						$li.="<li id=\"thelist2_".$elemento[1]."\">".$dp['palabra']."</li>";
					} else {
						$li.="<li id=\"thelist2_".$elemento[1]."\">".$elemento[1]."</li>";
					}
		
			}

	}
}
echo $li."<input name=\"mi_seleccion\" type=\"hidden\" id=\"mi_seleccion\" value=\"".$frase."\"/>";
?>
</ul>
	</td>
        </tr>
        <tr>
          <td height="22" colspan="2" align="center" valign="top"><span style="font-size:16px; color:#3366CC"><strong>Para configurar mi frase deseo utilizar:</strong></span><br /><br /> 
            <strong>Pictogramas de Color </strong>
            <input name="pictcolor" type="checkbox" id="pictcolor" value="1" checked="checked" /> 
            <strong>Pictogramas de Blanco y Negro</strong>
            <input name="pictnegro" type="checkbox" id="pictnegro" value="1" checked="checked" />
            <strong>Imágenes</strong>
            <input name="with_imagenes" type="checkbox" id="with_imagenes" value="1" checked="checked" />
              <strong>Cliparts</strong>
              <input name="with_cliparts" type="checkbox" id="with_cliparts" value="1" checked="checked" />
<br />
<br /></td>
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
<div align="center" class="footer">
      <p><!--<a href="../../../index.php">Qu&eacute; es Arasaac</a> | <a href="../../../index.php?ref=condiciones_uso_h">Condiciones de Uso</a> | <a href="../../../index.php?ref=mapa_web_h">Mapa Web</a><br />-->
&copy; Herramientas ARASAAC, CATEDU <?php echo date("Y"); ?> | Departamento de Educaci&oacute;n Cultura y Deporte<br />
<a href="http://www.aragob.es" target="_blank"><img src="../../../images/minilogo_aragob.gif" alt="Gobierno de Aragón" border="0" tittle="Gobierno de Aragón"/></a></p>
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


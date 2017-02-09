<?php
session_start(); 
require_once('../../configuration/key.inc');
include ('../../classes/querys/query.php');
$query=new query();

if ($_SESSION['AUTHORIZED']==true) {
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
}

require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);
?>

<table width="100%" border="0">
  <tr>
    <td valign="top">
<a href="javascript:void(0);" onclick="treemenu.start(); Effect.BlindDown('derecha');; return false;">Mostrar &aacute;rbol de categor&iacute;as</a>
<div id="ultimos_simbolos">
	<ul id="thelist2">
			<?php 
			$num=25;
			$last_simbols=$query->ultimos_simbolos_predefinidos($num,$_SESSION['AUTHORIZED'],$permisos);
			
			while ($entrada=mysql_fetch_array($last_simbols)) {
			
				if ($entrada['registrado']==2) {
					$ruta='img=../../repositorio/specials_smbl/'.$entrada['id_simbolo'].'_150.'.$entrada['ext'].'&id_simbolo='.$entrada['id_simbolo'];
					$ruta_img='size=80&ruta=../../repositorio/specials_smbl/'.$entrada['id_simbolo']."_150.".$entrada['ext'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					$encript->encriptar($ruta,1);
				} else {
				
					$ruta='img=../../repositorio/simbolos/'.$entrada['id_simbolo'].'_150.'.$entrada['ext'].'&id_simbolo='.$entrada['id_simbolo'];
					$ruta_img='size=80&ruta=../../repositorio/simbolos/'.$entrada['id_simbolo']."_150.".$entrada['ext'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					$encript->encriptar($ruta,1);
				}
			?>
			<li>
				<p><a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/ficha_simbolo.php?i=<?php echo $ruta ?>', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:450, height:350}, okLabel: 'Cerrar'});"><img src="classes/img/thumbnail.php?i=<?php echo $ruta_img; ?>" alt="Image" border="0" class="image" title="<?php echo utf8_encode($entrada['palabra']); ?>: <?php if (strlen($entrada['definicion']) > 100) { echo substr (utf8_encode($entrada['definicion']), 0, 100)."..."; } else { echo utf8_encode($entrada['definicion']); } ?>" /></a><b>
				
	  <?php /*echo '<div id="products"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td><a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/simbolos/").'/'.$entrada['id_simbolo'].'_o.'.$entrada['ext'].'\');"><img src=\'images/image_20x20.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: Tama&ntilde;o original"><br><img src=\'images/cesto.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: Tama&ntilde;o original"></a></td>
								<td><a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/simbolos/").'/'.$entrada['id_simbolo'].'_150.'.$entrada['ext'].'\');"><img src=\'images/image_20x20.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: 150x150"><br><img src=\'images/cesto.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: 150x150"></a></td>
								<td><a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/simbolos/").'/'.$entrada['id_simbolo'].'.'.$entrada['ext'].'\');"><img src=\'images/image_20x20.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: 75x75"><br><img src=\'images/cesto.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto: 75x75"></a></td>
							  </tr>
							</table>
						</div>';*/ ?>	  </li>
			<?php } ?>
	  </p>
</ul>
  </div>
  </td>
    <td valign="top">
    <div id="derecha" style="display:none; width:150px;">
    <div style="float:right;"><a href="javascript:void(0);" onclick="Effect.BlindUp('derecha');; return false;"><img src="images/close.gif" alt="Cerrar categorias"  border="0"/></a></div><br /><br />
    
    <?php

		$query=new query();
		
		print '<div id="menu" class="menu"><br /><br /><br />
	 	 <ul>';
		
		$num_categ=$query->listado_temas();
		$numrows = mysql_num_rows($num_categ);
					
		while ($row=mysql_fetch_array($num_categ)) {
					
			$tema[]=$row['id_tema'];
			$tema['tema'][]=$row['tema'];
					
		}
		
		for ($i=0;$i<$numrows;$i++) {
			
			print("<li><a href='javascript:void(".$tema[$i].");' title=\"". utf8_encode($tema['tema'][$i])."\">". utf8_encode($tema['tema'][$i])."</a><ul>");
			
				$subtemas=$query->listado_subtemas($tema[$i],50); 
				$num_rows2=mysql_num_rows($subtemas);
							
					if ($num_rows2 > 0) {
						while ($row2=mysql_fetch_array($subtemas)) {
							print("<li><a href='javascript:void(".$row2['id_subtema'].");' title=\"". utf8_encode($row2['subtema'])."\" >". utf8_encode($row2['subtema'])."</a></li>");
						}
					}	
								
								
			print("</ul></li>");
				
		}	
		
		print '</ul>';
		
		?>

<!--   MODELO DE ARBOL 

	<div id="menu" class="menu"><br /><br /><br />
	 	 <ul>
        	<li><a href="javascript:;" title="Information">info</a>
        		<ul>
                    <li><a href="../../info/features.html" title="Features">features</a></li>
                    <li><a href="../../info/functions.html" title="Functions">functions</a></li>
                    <li><a href="../../info/quick-start.html">quick-start</a></li>
                    <li><a href="javascript:;" title="Usage">usage</a>
                        <ul>
                            <li><a href="../../info/usage/how-to.html" title="How to use Nornix TreeMenu">how-to</a></li>
                            <li><a href="../../info/usage/html.html" title="HTML structure">HTML</a></li>
                            <li><a href="../../info/usage/css.html" title="CSS classes">CSS</a></li>
                            <li><a href="../../info/usage/js.html" title="JS behavior">JS</a></li>
                            <li><a href="../../info/usage/images.html" title="Images">images</a></li>
                      </ul>
                  </li>
                     <li><a href="../../info/compatibility.html" title="Compatibility">compatibility</a></li>
                     <li><a href="../../info/flavours.html" title="Flavours">flavours</a></li>
                     <li><a href="../../info/skins.html" title="Skins">skins</a></li>
                     <li><a href="../../info/layers.html" title="Layers">layers</a></li>
                     <li><a href="../../info/advanced.html" title="Advanced">advanced</a></li>
              </ul>
          </li>
              <li><a href="../../license.html">license</a></li>
              <li><a href="javascript:;">folder one</a>
              	  <ul>
                  	 <li><a href="../../folder1/doc1.html">document one</a></li>
                     <li><a href="../../folder1/doc2.html">document two</a></li>
                  </ul>
			  </li>
      </ul>
</div>-->
</div></td>
  </tr>
</table>

</div>



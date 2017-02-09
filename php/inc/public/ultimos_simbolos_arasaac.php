<?php
session_start(); 
//header('Content-Type: text/html; charset=UTF-8');
require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);

include ('../../classes/querys/query.php');
$query=new query();

$letra="";
$orden="desc";
$filtrado="1";
$id_subtema=99999;
$busqueda="";
$minusculas=0;
$mayusculas=0;

$condicionantes=explode('||',$_POST['checkboxes']);

$castellano=0;
$ruso=0;
$rumano=0;
$arabe=0;
$chino=0;
$bulgaro=0;
$polaco=0;
$ingles=0;
$frances=0;
$catalan=0;

foreach ($condicionantes as $nombre_campo => $valor) {

	if ($valor != '') {
		$val=explode('=',$valor);
		$asignacion = "$" . $val[0] . "='" . $val[1] . "';";
		eval($asignacion);
	}
	
}

if (!isset($_POST['tipo_letra'])) {
	$tipo_letra=99; 
} else { $tipo_letra=$_POST['tipo_letra']; }

if (!isset($_POST['id_tipo'])) {
	$id_tipo=99; 
	$seleccionado_tipo_palabra='selected="selected"';
} else { $id_tipo=$_POST['id_tipo']; $seleccionado_tipo_palabra=''; }

if (!isset($_POST['tipo_simbolo'])) {
	$id_tipo_simbolo=99; 
	$seleccionado_tipo_pictograma='selected="selected"';
} else { $id_tipo_simbolo=$_POST['tipo_simbolo']; $seleccionado_tipo_pictograma=''; }

if (!isset($_POST['marco'])) {
	$marco=99; 
} else { $marco=$_POST['marco']; }

if (!isset($_POST['contraste'])) {
	$contraste=99; 
} else { $contraste=$_POST['contraste']; }

if (!isset($_POST['id_subtema'])) {
	$id_subtema=99999; 
	$busqueda_subtema="";
} else { 
	$id_subtema=$_POST['id_subtema']; 
	$subtema=$query->datos_subtema($id_subtema);
	if ($_POST['id_subtema'] != 99999) { $busqueda_subtema="<h4>Resultados para: ".utf8_encode($subtema['tema'])."/".utf8_encode($subtema['subtema'])."</h4>"; }
}

if (!isset($_POST['letra'])) {
	$letra=''; 
	$busqueda="";
} else { 
	$letra=$_POST['letra']; 
	if ($_POST['letra'] != "") { $busqueda="<h4>Resultados para: ''".utf8_encode($_POST['letra'])."''</h4>"; }
}			

if (!isset($_POST['filtrado'])) {
	$filtrado=1; 
} else { $filtrado=$_POST['filtrado']; }	

if (!isset($_POST['orden'])) {
	$orden="desc"; 
} else { $orden=$_POST['orden']; }	

if ($_POST['avanzada']==0) {
	 $mostrar_avanzada='display:none;'; 
} else { $mostrar_avanzada=''; }	

?>
<table width="100%" height="470" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="284" valign="top">
      <h4>Cat&aacute;logo de S&iacute;mbolos:</h4>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" align="left">En este cat&aacute;logo pueden encontrarse una variedad de s&iacute;mbolos ya predefinidos y listos para ser usados en los que se combinan todas tipos de pictogramas que ofrecemos,traducciones a 8 idiomas y configuraciones diversas del d&iacute;mbolo en cuanto a tipo de letra, marco, contraste, etc. </td>
          <td width="8%" align="center" valign="bottom" style="font-size:9px;"><!--<a href="javascript:void(0);" onclick="treemenu.start(); Effect.BlindDown('derecha');; return false;"><img src="images/view_tree.gif" alt="Mostrar &aacute;rbol de categor&iacute;as" border="0" title="Mostrar &aacute;rbol de categor&iacute;as" /></a><br/>
            <a href="javascript:void(0);" onclick="treemenu.start(); Effect.BlindDown('derecha');; return false;">--><?php //echo utf8_encode("&Aacute;rbol de Categor&iacute;as"); ?><!--</a>--></td>
          <td width="8%" align="center" valign="bottom" style="font-size:9px;"><a class="grey" href="javascript:void(0);" onclick="Effect.BlindDown('filtrar_simbolos');; return false;"><img src="images/kappfinder.gif" alt="B&uacute;squeda avanzada" title="B&uacute;squeda avanzada" border="0" /></a><br/>
            <a href="javascript:void(0);" onclick="Effect.BlindDown('avanzada_imagenes');; return false;"><?php echo utf8_encode("Filtrado de Símbolos"); ?></a></td>
          <td width="5%" align="center" valign="middle" style="font-size:9px;"><div id="n_cesto2" style="background: url(images/cart.gif) no-repeat bottom; height: 50px; width:50px; padding-left:9px; float:right; cursor:pointer; font-size:18px;" onclick="cargar_div('inc/cesta.php','i=','principal');"><b>
              <?php $n=0;
		if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") { foreach ($_SESSION['cart'] as $key => $value) { $n=$n+1; } }  echo $n; ?>
          </b></div></td>
        </tr>
      </table>
      <?php echo $busqueda; ?> <?php echo $busqueda_subtema; ?>                
      <div class="tabla_ultimas_imagenes" id="ultimas_imagenes">
        <ul id="thelist2">
<?php  
				if (!isset($_POST['pg'])) {
				$pg = 0; // $pg es la pagina actual
				} else { $pg=$_POST['pg']; }
				
				require('../../funciones/n_items_resolucion.php');	

				$inicial = $pg * $cantidad;
				
				$limite_inferior="5"; //resultados por debajo de la pagina actual
				$page_limit = $limite_inferior;
				
				$limitpages = $page_limit;
				$page_limit = $pg + $limitpages;

				$contar=$query->listar_simbolos_arasaac($id_tipo,$letra,$id_tipo_simbolo,$_SESSION['AUTHORIZED'],$marco,$contraste,$tipo_letra,$mayusculas,$minusculas,$castellano,$ruso,$rumano,$arabe,$chino,$bulgaro,$polaco,$ingles,$frances,$catalan); 
				$resultados=$query->listar_simbolos_arasaac_limit($id_tipo,$letra,$id_tipo_simbolo,$inicial,$cantidad,$_SESSION['AUTHORIZED'],$marco,$contraste,$tipo_letra,$mayusculas,$minusculas,$castellano,$ruso,$rumano,$arabe,$chino,$bulgaro,$polaco,$ingles,$frances,$catalan);
				
				$total_records = mysql_num_rows($contar);
				$total_pages = intval($total_records / $cantidad);
				
				if ($total_records > 0 ) {
				
				while ($row=mysql_fetch_array($resultados)) {
				
					$folder=$row['id_tipo_simbolo'].$row['marco'].$row['contraste'].$row['sup_con_texto'].$row['sup_idioma'].$row['sup_mayusculas'].$row['sup_font'].$row['inf_con_texto'].$row['inf_idioma'].$row['inf_mayusculas'].$row['inf_font'];
				
					$ruta='img=../../repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_simbolo='.$row['id_simbolo'];
					$encript->encriptar($ruta,1);
					
					$ruta_img='size=50&ruta=../../repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'];
					$encript->encriptar($ruta_cesto,1);
					
			?>
          <li> <a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/simbolo.php?i=<?php echo $ruta; ?>', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});"><img src="classes/img/thumbnail.php?i=<?php echo $ruta_img; ?>" alt="Image" border="0" class="image" title="<?php echo $row['palabra']; ?>: <?php if (strlen($row['definicion']) > 100) { echo substr (utf8_encode($row['definicion']), 0, 100)."..."; } else { echo utf8_encode($row['definicion']); } ?>" /></a>
              <?php 	
			  echo '<div id="products">';
			  if (strlen($row['palabra']) > 15) { echo substr($row['palabra'],0,15).".."; } else {  echo $row['palabra'];  }
			  
			 /* ALTERNATIVA CUANDO SE TRASLADE A HERRAMIENTAS*/
			 
			  $ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
			  $encript->encriptar($ruta_creador,1); 
				
			  echo '<br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto" title="a&ntilde;adir imagen a mi cesto">&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar Símbolo" title="Descargar Símbolo"></a></div>';
				?>
          </li>
          <?php } } ?>
	    </ul>
      </div>
      </td>
    <td rowspan="2" valign="top">
    <div id="filtrar_simbolos" style="font-size: 10px; margin-bottom:10px; margin-top:50px; margin-left: 20px; float:right; padding-left:5px; border:1px solid #CCCCCC; width: 250px; height:580px;">
	    <div style="text-align:right; margin-bottom:-25px;"><a href="javascript:void(0);" onclick="Effect.BlindUp('filtrar_simbolos');; return false;"><img src="images/close.gif" alt="Cerrar b&uacute;squeda avanzada"  border="0"/></a></div>
                    <form action="" method="post" name="busqueda_avanzada" id="busqueda_avanzada">
                    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr valign="middle">
                      <td><p><strong>FILTRADO DE S&Iacute;MBOLOS</strong></p>
                      <br />
                        <p><strong>Tipo de palabra:
                          </strong>
                          <?php $categ3=$query->listar_categorias_palabras(); ?>
                          <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">
                            <option value="99" <?php echo $seleccionado_tipo_palabra; ?>>Todas</option>
                            <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
                            <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>" <?php if ($id_tipo==$row_rsCategorias3['id_tipo_palabra']) { echo 'selected="selected"'; } ?>><?php echo $row_rsCategorias3['tipo_palabra']; ?></option>
                            <?php }  ?>
                            </select>
                          </p>
                        <p><strong>comienza por</strong>
                          <input name="letra" type="text" id="letra" onkeypress="return handleEnter(this, event)" value="<?php echo $letra; ?>" size="20"/>
                          </p>
                        <p><strong>Tipo de Pictograma</strong>
                          <label>
                          <select name="tipo_simbolo" id="tipo_simbolo">
                            <option value="99" <?php echo $seleccionado_tipo_pictograma; ?>>Cualquiera</option>
                            <option value="5 <?php if ($id_tipo_simbolo==5) { echo 'selected="selected"'; } ?>">Pictogramas ByN</option>
                            <option value="10" <?php if ($id_tipo_simbolo==10) { echo 'selected="selected"'; } ?>>Pictogramas Color</option>
                            <option value="2" <?php if ($id_tipo_simbolo==2) { echo 'selected="selected"'; } ?>>Fotograf&iacute;a</option>
                          </select>
                          </label>
</p>
                        <p><strong>Marco</strong> 
                          <label>
                          <select name="marco" id="marco">
                          	<?php 
							if ($marco==1) { echo '<option value="1" selected="selected">Con marco</option>'; } 
							elseif ($marco==0) { echo '<option value="0">Sin marco</option>'; } 
							elseif ($marco==99) { echo '<option value="99">Con y Sin Marco</option>'; } 
							?>
                            <option value="1">Con marco</option>
                            <option value="0">Sin marco</option>
                            <option value="99">Con y Sin Marco</option>
                          </select>
                          </label>
                        </p>
                        <p><strong>Contraste</strong> 
                          <label>
                          <select name="contraste" id="contraste">
                            <?php 
							if ($contraste==1) { echo '<option value="1" selected="selected">Normal</option>'; } 
							elseif ($contraste==2) { echo '<option value="2" selected="selected">Invertido</option>'; }
							elseif ($contraste==99) { echo '<option value="99" selected="selected">Cualquiera</option>'; }  
							?>
                            <option value="1">Normal</option>
                            <option value="2">Invertido</option>
                            <option value="99">Cualquiera</option>
                          </select>
                          </label>
                        </p>
                        <p><strong>Tipo de letra</strong> 
                          <label>
                          <select name="tipo_letra" id="tipo_letra">
                         	<?php 
							if ($tipo_letra==1) { echo '<option value="1" selected="selected">Arial</option>'; } 
							elseif ($tipo_letra==2) { echo '<option value="2" selected="selected">Escolar ligada</option>'; } 
							elseif ($tipo_letra==99) { echo '<option value="99" selected="selected">Cualquiera</option>'; } 
							?>
                            <option value="1">Arial</option>
                            <option value="2">Escolar ligada</option>
                            <option value="99">Cualquiera</option>
                          </select>
                          </label>
                        </p>
                        <p><strong>Min&uacute;sculas 
                            <input name="minusculas" type="checkbox" id="minusculas" value="1" <?php if ($minusculas==1) { echo 'checked="checked"'; } ?> />
                          <label></label>
                        </strong><strong>May&uacute;sculas 
                            <label>                            </label>
                          </strong>
                          <label></label>
                          <strong>
                          <input name="mayusculas" type="checkbox" id="mayusculas" value="1" <?php if ($mayusculas==1) { echo 'checked="checked"'; } ?>/>
                        </strong></p>
                        <p><strong>Idiomas: </strong></p>
                        <blockquote>
                          <p>Castellano 
                            <label>
                            <input name="castellano" type="checkbox" id="castellano" value="1" <?php if ($castellano==1) { echo 'checked="checked"'; } ?> />
                            </label>
                          </p>
                          <p>Ruso 
                            <input name="ruso" type="checkbox" id="ruso" value="1"  <?php if ($ruso==1) { echo 'checked="checked"'; } ?>/>
                          </p>
                          <p>Rumano 
                            <input name="rumano" type="checkbox" id="rumano" value="1" <?php if ($rumano==1) { echo 'checked="checked"'; } ?>/>
                          </p>
                          <p>&Aacute;rabe 
                            <input name="arabe" type="checkbox" id="arabe" value="1" <?php if ($arabe==1) { echo 'checked="checked"'; } ?>/>
                          </p>
                          <p>Chino 
                            <input name="chino" type="checkbox" id="chino" value="1" <?php if ($chino==1) { echo 'checked="checked"'; } ?>/>
                          </p>
                          <p>B&uacute;lgaro 
                            <input name="bulgaro" type="checkbox" id="bulgaro" value="1" <?php if ($bulgaro==1) { echo 'checked="checked"'; } ?>/>
                          </p>
                          <p>Polaco 
                            <input name="polaco" type="checkbox" id="polaco" value="1" <?php if ($polaco==1) { echo 'checked="checked"'; } ?>/>
                          </p>
                          <p>Ingl&eacute;s 
                            <input name="ingles" type="checkbox" id="ingles" value="1" <?php if ($ingles==1) { echo 'checked="checked"'; } ?>/>
                          </p>
                          <p>Franc&eacute;s 
                            <input name="frances" type="checkbox" id="frances" value="1" <?php if ($frances==1) { echo 'checked="checked"'; } ?>/>
                          </p>
                          <p>Catal&aacute;n 
                            <input name="catalan" type="checkbox" id="catalan" value="1" <?php if ($catalan==1) { echo 'checked="checked"'; } ?>/>
                          </p>
                        </blockquote>                        <p align="center">
                          <input type="button" name="Submit2" value="Buscar" onClick="recogercheckbox_buscador_simbolos();" />
                          <br />
                          <br />
                            </p></td>
                      <p>&nbsp;</p>
                    </tr>
                  </table>
		</form>
	  </div>
    <div id="derecha" style="display:none; width:150px;">
    <div style="float:right;"><a href="javascript:void(0);" onclick="Effect.BlindUp('derecha');; return false;"><img src="images/close.gif" alt="Cerrar categorias"  border="0"/></a></div>
    
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
							?> <li><a href="javascript:cargar_div('inc/public/ultimos_simbolos_arasaac.php','id_subtema=<?php echo $row2['id_subtema'] ?>','principal');" title="<?php echo utf8_encode($row2['subtema'])?>"><?php echo utf8_encode($row2['subtema'])?></a></li>
							<?php
						}
					}	
								
								
			print("</ul></li>");
				
		}	
		
		print '</ul>';
		
		?>
	</div>  
    </td>
  </tr>
  <tr>
    <td valign="top">
	<div align="center" class="textos"><strong>S&iacute;mbolo: </strong><?php echo $inicial ?> a <?php echo $inicial+$cantidad ?> de <?php echo $total_records ?></div> 
	<div align="center">
	  <?php 
        
            
        if ($page_limit > $total_pages ) {
        
            $page_limit = $total_pages;
        
        }
        
        $page_start = $pg;
        $page_stop = $page_start + $limitpages;
        
            if ($page_stop > $total_pages) { 
            
                $page_stop = $page_stop -$total_pages;
                $page_start = $page_start -$page_stop;
            
            }
        
        $content.= '<p><div id="pagination">';
        
        // Volver a Inicio
        if($pg > 0) {
        
        $prev_limit = ($pg - $limitpages);
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_simbolos_arasaac.php','pg=0&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','principal');\"><< </a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"><<</span>';
        
        }
        
        // Pagina anterior
        if($pg > 0) { 
        
        $prev = ($pg - 1);
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_simbolos_arasaac.php','pg=".$prev."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','principal');\"> <</a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled">< </span>';
        
        }
        
        // Paginacion
        if($total_pages >= $limitpages) {
        
            for($i = $page_start-$limite_inferior; ($i <= $total_pages & $i <=$page_limit); $i++) {
            
                if(($i) >= 0) { 	
                    if(($pg) == $i) { 
                    
                    $content.= '<span class="current">'.$i.'</span>&nbsp;';
                    
                    } else {
                    
                    $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_simbolos_arasaac.php','pg=".$i."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','principal');\">".$i."</a>&nbsp;";
                    }
                }
            
            } // Cierro el FOR
        
        } else {
        
            for($i = 0; $i <= $total_pages; $i++) {
            
                if(($pg) == $i) {
                
                $content.= '<span class="current">'.$i.'</span>&nbsp;';
                
                } else {
                
                $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_simbolos_arasaac.php','pg=".$i."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','principal');\">".$i."</a>&nbsp;";
            
            } // Cierro el FOR
            
        } // Cierro el IF
        
        }
        
        // Siguiente página
        if($pg < $total_pages) {
        
        $next = ($pg + 1);
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_simbolos_arasaac.php','pg=".$next."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','principal');\"> ></a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"> ></span>';
        
        }
        
        // Ultima página
        if($pg < $total_pages)
        {
        
        $last = $total_pages;
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_simbolos_arasaac.php','pg=".$last."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','principal');\">  >></a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"> >></span>';
        
        }
        
        
        $content.= "</p></div>";
        
        echo $content;
        ?>
    </div>
    <br />
  <div align="center">
    <p>
      <span class="little">Los pictogramas contenidos en este cat&aacute;logo se distribuyen bajo <a href="http://creativecommons.org/licenses/by-nc/2.5/es/" target="_blank" rel="license">licencia de Creative Commons</a></span><br>
      <a href="http://creativecommons.org/licenses/by-nc/2.5/es/" target="_blank" rel="license">
        <img alt="Creative Commons License" style="border-width:0" src="images/88x31.png" />
        </a>
      <br />
      </p>
  </div>
    </td>
  </tr>
</table>

<!--<div id="treeboxbox_tree"></div>    ARBOL DE CATEGORIAS --> 
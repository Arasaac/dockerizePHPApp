<?php
session_start(); 
//header('Content-Type: text/html; charset=UTF-8');
require ('../../classes/languages/language_detect.php');
require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);

include ('../../classes/querys/query.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],11); 

$id_tipo=99;
$letra="";
$orden="desc";
$filtrado="1";
$id_subtema=99999;
$busqueda="";

if (!isset($_POST['id_tipo'])) {
	$id_tipo=99; 
} else { $id_tipo=$_POST['id_tipo']; }

if (!isset($_POST['id_subtema'])) {
	$id_subtema=99999; 
	$busqueda_subtema="";
} else { 
	$id_subtema=$_POST['id_subtema']; 
	$subtema=$query->datos_subtema($id_subtema);
	if ($_POST['id_subtema'] != 99999) { $busqueda_subtema="<h4>".$translate['resultados_para'].": ".$subtema['tema']."/".$subtema['subtema']."</h4>"; }
}

if (!isset($_POST['letra'])) {
	$letra=''; 
	$busqueda="";
} else { 
	$letra=$_POST['letra']; 
	if ($_POST['letra'] != "") { $busqueda="<h4>".$translate['resultados_para'].": ''".utf8_encode($_POST['letra'])."''</h4>"; }
}			

if (!isset($_POST['filtrado'])) {
	$filtrado=1; 
} else { $filtrado=$_POST['filtrado']; }	

if (!isset($_POST['orden'])) {
	$orden="desc"; 
} else { $orden=$_POST['orden']; }	

if (!isset($_POST['avanzada']) || $_POST['avanzada']=='' || $_POST['avanzada']==0) {
	 $mostrar_avanzada='display:none;'; 
} else { $mostrar_avanzada=''; }	

?>
<h4><?php echo $translate['catalogo_pictogramas_catedu_color']; ?>:</h4>
      <div style="width:100%">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="5%" align="center" valign="middle"><a class="grey" href="rss/subscripcion.php?t=4&id_tipo=10" target="_blank"><img src="images/rss2.png" alt="<?php echo $translate['subscribirse_este_catalogo']; ?>" title="<?php echo $translate['subscribirse_este_catalogo']; ?>" border="0" /></a></td>
          <td width="72%" align="left"><?php echo $translate['explicacion_catalogo_pictogramas_color']; ?></td>
          <td width="9%" align="center" valign="bottom" style="font-size:9px;"><a class="grey" href="javascript:void(0);" onclick="Effect.BlindDown('avanzada_imagenes');; return false;"><img src="images/kappfinder.gif" alt="<?php echo $translate['busqueda_avanzada']; ?>" title="<?php echo $translate['busqueda_avanzada']; ?>" border="0" /></a><br/>
            <a href="javascript:void(0);" onclick="Effect.BlindDown('avanzada_imagenes');; return false;"><?php echo $translate['busqueda_avanzada']; ?></a></td>
          <td width="9%" align="center" valign="bottom" style="font-size:9px;"><a href="javascript:void(0);" onclick="treemenu.start(); Effect.BlindDown('derecha');; return false;"><img src="images/view_tree.gif" alt="<?php echo $translate['mostrar_arbol_categorias']; ?>" border="0" title="<?php echo $translate['mostrar_arbol_categorias']; ?>" /></a><br/>
            <a href="javascript:void(0);" onclick="treemenu.start(); Effect.BlindDown('derecha');; return false;"><?php echo $translate['arbol_categorias']; ?></a></td>
        </tr>
      </table>
      </div>
      <div style="width:100%">
<table width="100%" height="470" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="284" valign="top">
      <?php echo $busqueda; ?> <?php echo $busqueda_subtema; ?>
<div id="avanzada_imagenes" style="font-size: 10px; <?php echo $mostrar_avanzada; ?> margin-bottom:10px; margin-top:5px; float:left; padding-left:5px; border:1px solid #CCCCCC; width: 92%;">
	    <div style="text-align:right; margin-bottom:-25px;"><a href="javascript:void(0);" onclick="Effect.BlindUp('avanzada_imagenes');; return false;"><img src="images/close.gif" alt="<?php echo $translate['cerrar_busqueda_avanzada']; ?>" title="<?php echo $translate['cerrar_busqueda_avanzada']; ?>" border="0"/></a></div>
                    <form action="" method="post" name="busqueda_avanzada" id="busqueda_avanzada">
                    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr valign="middle">
                      <td><strong><?php echo $translate['tipo_de_palabra']; ?>:
                        </strong>
                        <?php $categ3=$query->listar_categorias_palabras(); ?>
                          <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">
                            <option value="99" selected="selected"><?php echo $translate['todas']; ?></option>
                            <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
                            <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra']; ?></option>
                            <?php }  ?>
                          </select>
                          <strong><?php echo $translate['comienza_por']; ?></strong>
                        <input name="letra" type="text" id="letra" size="10" onkeypress="return handleEnter(this, event)"/>
                         <strong><?php echo $translate['ordenado_por']; ?></strong>
                        <select name="filtrado" id="filtrado">
                        	<option value="1" selected><?php echo $translate['fecha_alta']; ?></option>
                            <option value="2"><?php echo $translate['palabra']; ?></option>
                        </select>
                         <select name="orden" id="orden">
                        	<option value="asc"><?php echo $translate['ascendente']; ?></option>
                            <option value="desc" selected><?php echo $translate['descendente']; ?></option>
                        </select>
                        <input type="button" name="Submit2" value="<?php echo $translate['buscar']; ?>" onClick="cargar_div('inc/public/ultimos_pictogramas_color.php','id_tipo='+document.busqueda_avanzada.tipo_palabra.value+'&letra='+document.busqueda_avanzada.letra.value+'&filtrado='+document.busqueda_avanzada.filtrado.value+'&orden='+document.busqueda_avanzada.orden.value+'&avanzada=1','principal');" /><br /><br /></td>
                        <p>&nbsp;</p>
                    </tr>
                  </table>
					</form>
	  </div>
                
      <div style="float:right;"></div>
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

				if ($_SESSION['id_language'] > 0) {
					
					$tipo_pictograma=10;
					
					$contar=$query->listar_pictogramas_idioma($_SESSION['AUTHORIZED'],$id_tipo,$letra,$filtrado,$orden,$id_subtema,$_SESSION['id_language'],$tipo_pictograma);
					$resultados=$query->listar_pictogramas_idioma_limit($_SESSION['AUTHORIZED'],$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$_SESSION['id_language'],$tipo_pictograma);
					
				} else {
					//$contar=$query->buscar_blogs($_POST['palabra_buscar']);
					$contar=$query->listar_pictogramas_color($_SESSION['AUTHORIZED'],$id_tipo,$letra,$filtrado,$orden,$id_subtema);
					$resultados=$query->listar_pictogramas_color_limit($_SESSION['AUTHORIZED'],$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema);
				}
				
				$total_records = mysql_num_rows($contar);
				$total_pages = intval($total_records / $cantidad);
				
				if ($total_records > 0 ) {
				
				while ($row=mysql_fetch_array($resultados)) {
				
					$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
					$encript->encriptar($ruta,1);
					
					$ruta_img='size=50&ruta=../../repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_cesto,1);
					
					if ($_SESSION['id_language'] > 0) {
			  
						if (strlen($row['traduccion']) > 15) { $word=substr($row['traduccion'],0,15).".."; } else {  $word=$row['traduccion'];  }
						$definition=$row['explicacion'];
				  
					} else {
				  
						if (strlen($row['palabra']) > 15) { $word=substr($row['palabra'],0,15).".."; } else { $word=$row['palabra'];  }
						$definition=$row['definicion'];
				  
					}
			?>
          <li> <a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/imagen.php?i=<?php echo $ruta; ?>', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});"><img src="classes/img/thumbnail.php?i=<?php echo $ruta_img; ?>" alt="<?php echo $word; ?>: <?php if (strlen($definition) > 100) { echo substr (utf8_encode($definition), 0, 100)."..."; } else { echo utf8_encode($definition); } ?>" border="0" class="image" title="<?php echo $word; ?>: <?php if (strlen($definition) > 100) { echo substr (utf8_encode($definition), 0, 100)."..."; } else { echo utf8_encode($definition); } ?>" /></a>
              <?php 	
			  echo '<div id="products">';
			  
			  echo $word;
			  
			 /* ALTERNATIVA CUANDO SE TRASLADE A HERRAMIENTAS*/
			 
			  $ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
			  $encript->encriptar($ruta_creador,1); 
				
			  echo '<br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="'.$translate['add_imagen_cesto'].'" title="'.$translate['add_imagen_cesto'].'"></a>&nbsp;&nbsp;&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\''.$translate['creador_de_simbolos'].'\', this.href)"><img src=\'images/paint.gif\' border="0" alt="'.$translate['utilizar_imagen_creador'].'" title="'.$translate['utilizar_imagen_creador'].'"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="'.$translate['descargar_imagen'].'" title="'.$translate['descargar_imagen'].'"></a></div>';
			  
			  /* ********************************************** */
			  
			 /* echo '<br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto" title="a&ntilde;adir imagen a mi cesto"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onClick="cargar_div(\'inc/creador_simbolos/creador_simbolos.php\',\'img='.$row['imagen'].'&id_palabra='.$row['id_palabra'].'\',\'principal\');"><img src=\'images/paint.gif\' border="0" alt="Utilizar imagen en el creador" title="Utilizar imagen en el creador"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a>
			    </div>';*/ ?>
          </li>
          <?php } } ?>
	    </ul>
      </div>
      </td>
    <td rowspan="2" valign="top">
    <div id="derecha" style="display:none; width:150px;">
    <div style="float:right;"><a href="javascript:void(0);" onclick="Effect.BlindUp('derecha');; return false;"><img src="images/close.gif" alt="<?php echo $translate['cerrar_arbol_categorias']; ?>" title="<?php echo $translate['cerrar_arbol_categorias']; ?>" border="0"/></a></div>
    <br /><br />
    <?php

		$query=new query();
		
		print '<div id="menu" class="menu"><br /><br /><br />
	 	 <ul>';
		
		$num_categ=$query->listado_temas();
		$numrows = mysql_num_rows($num_categ);
					
		while ($row=mysql_fetch_array($num_categ)) {
					
			$tema[]=$row['id_tema'];
			if ($_SESSION['language']=='es') { 
				$tema['tema'][]=$row['tema'];
			} else {
				$tema['tema'][]=$row['tema_'.$_SESSION['language'].''];
			}
					
		}
		
		for ($i=0;$i<$numrows;$i++) {
			
			print("<li><a href='javascript:void(".$tema[$i].");' title=\"". $tema['tema'][$i]."\">". $tema['tema'][$i]."</a><ul>");
			
				$subtemas=$query->listado_subtemas($tema[$i],50); 
				$num_rows2=mysql_num_rows($subtemas);
							
					if ($num_rows2 > 0) {
						while ($row2=mysql_fetch_array($subtemas)) {
							if ($_SESSION['language']=='es') { 
							?> <li><a href="javascript:cargar_div('inc/public/ultimos_pictogramas_color.php','id_subtema=<?php echo $row2['id_subtema'] ?>','principal');" title="<?php echo $row2['subtema']; ?>"><?php echo $row2['subtema']; ?></a></li>
                            <?php } else { ?>
                            <li><a href="javascript:cargar_div('inc/public/ultimos_pictogramas_color.php','id_subtema=<?php echo $row2['id_subtema'] ?>','principal');" title="<?php echo $row2['subtema_'.$_SESSION['language'].'']?>"><?php echo $row2['subtema_'.$_SESSION['language'].'']; ?></a></li>
                      <?php   
					  	   }
							
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
	<div align="center" class="textos"><strong><?php echo $translate['pictograms']; ?>: </strong><?php echo $inicial ?> a <?php echo $inicial+$cantidad ?> de <?php echo $total_records ?></div> 
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
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_pictogramas_color.php','pg=0&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\"><< </a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"><<</span>';
        
        }
        
        // Pagina anterior
        if($pg > 0) { 
        
        $prev = ($pg - 1);
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_pictogramas_color.php','pg=".$prev."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\"> <</a>&nbsp;";
        
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
                    
                    $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_pictogramas_color.php','pg=".$i."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\">".$i."</a>&nbsp;";
                    }
                }
            
            } // Cierro el FOR
        
        } else {
        
            for($i = 0; $i <= $total_pages; $i++) {
            
                if(($pg) == $i) {
                
                $content.= '<span class="current">'.$i.'</span>&nbsp;';
                
                } else {
                
                $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_pictogramas_color.php','pg=".$i."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\">".$i."</a>&nbsp;";
            
            } // Cierro el FOR
            
        } // Cierro el IF
        
        }
        
        // Siguiente página
        if($pg < $total_pages) {
        
        $next = ($pg + 1);
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_pictogramas_color.php','pg=".$next."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\"> ></a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"> ></span>';
        
        }
        
        // Ultima página
        if($pg < $total_pages)
        {
        
        $last = $total_pages;
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_pictogramas_color.php','pg=".$last."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\">  >></a>&nbsp;";
        
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
      <span class="little"><?php echo $translate['licencia_cc_pictogramas']; ?></span><br>
      <?php  $datos_licencia=$query->datos_licencia(2); 
	        
	  if ($_SESSION['id_language'] > 0) { 
	  
	  	echo '<a href="'.$datos_licencia['link_licencia_'.$_SESSION['language'].''].'" target="_blank" rel="license">';
	  
	  } else {
	  
	  	echo '<a href="'.$datos_licencia['link_licencia'].'" target="_blank" rel="license">';
	  }
	  ?>
        <img alt="Creative Commons License" title="Creative Commons License" style="border-width:0" src="images/<?php echo $datos_licencia['logo_licencia_big'] ?>" />
      <br />
      </p>
  </div>
    </td>
  </tr>
</table>
</div>
<!--<div id="treeboxbox_tree"></div>    ARBOL DE CATEGORIAS --> 
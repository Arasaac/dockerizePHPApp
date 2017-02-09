<?php
session_start(); 
//header('Content-Type: text/html; charset=UTF-8');
require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);

include ('../../classes/querys/query.php');
$query=new query();

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
	if ($_POST['id_subtema'] != 99999) { $busqueda_subtema="<br /><br /><h4>Resultados para: ".utf8_encode($subtema['tema'])."/".utf8_encode($subtema['subtema'])."</h4>"; }
}

if (!isset($_POST['letra'])) {
	$letra=''; 
	$busqueda="";
} else { 
	$letra=$_POST['letra']; 
	if ($_POST['letra'] != "") { $busqueda="<br /><br /><h4>Resultados para: ''".utf8_encode($_POST['letra'])."''</h4>"; }
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
<table width="100%" height="345" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="227" valign="top">
    <h4>Cat&aacute;logo de Cliparts:</h4> <br />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="87%" align="left"><?php echo $busqueda; ?> <?php echo $busqueda_subtema; ?> </td>
        <td width="4%" align="center"><a class="grey" href="javascript:void(0);" onclick="Effect.BlindDown('avanzada_imagenes');; return false;"><img src="images/kappfinder.gif" alt="B&uacute;squeda avanzada" title="B&uacute;squeda avanzada" border="0" /></a></td>
        <td width="4%" align="center"><a href="javascript:void(0);" onclick="treemenu.start(); Effect.BlindDown('derecha');; return false;"><img src="images/view_tree.gif" alt="Mostrar &aacute;rbol de categor&iacute;as" border="0" title="Mostrar &aacute;rbol de categor&iacute;as" /></a></td>
        <td width="5%" align="center"><div id="n_cesto2" style="background: url(images/cart.gif) no-repeat bottom; height: 50px; width:50px; padding-left:9px; float:right; cursor:pointer; font-size:18px;" onclick="cargar_div('inc/cesta.php','i=','principal');"><b>
            <?php $n=0;
		if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") { foreach ($_SESSION['cart'] as $key => $value) { $n=$n+1; } }  echo $n; ?>
        </b></div></td>
      </tr>
    </table>
    <div id="avanzada_imagenes" style="font-size: 10px; <?php echo $mostrar_avanzada; ?> margin-bottom:10px; margin-top:5px; float:left; padding-left:5px; border:1px solid #CCCCCC; width: 92%;">
	    <div style="text-align:right; margin-bottom:-25px;"><a href="javascript:void(0);" onclick="Effect.BlindUp('avanzada_imagenes');; return false;"><img src="images/close.gif" alt="Cerrar b&uacute;squeda avanzada"  border="0"/></a></div>
                    <form action="" method="post" name="busqueda_avanzada" id="busqueda_avanzada">
                    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr valign="middle">
                      <td><br /><strong>Tipo de palabra:
                        </strong>
                        <?php $categ3=$query->listar_categorias_palabras(); ?>
                          <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">
                            <option value="99" selected="selected">Todas</option>
                            <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
                            <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra']; ?></option>
                            <?php }  ?>
                          </select>
                          <strong>comienza por</strong>
                        <input name="letra" type="text" id="letra" size="10" onkeypress="return handleEnter(this, event)"/>
                         <strong>Ordenado por</strong>
                        <select name="filtrado" id="filtrado">
                        	<option value="1" selected>Fecha alta</option>
                            <option value="2">Palabra</option>
                        </select>
                         <select name="orden" id="orden">
                        	<option value="asc">Ascendente</option>
                            <option value="desc" selected>Descendente</option>
                        </select>
                        <input type="button" name="Submit2" value="Buscar" onClick="cargar_div('inc/public/ultimos_cliparts.php','id_tipo='+document.busqueda_avanzada.tipo_palabra.value+'&letra='+document.busqueda_avanzada.letra.value+'&filtrado='+document.busqueda_avanzada.filtrado.value+'&orden='+document.busqueda_avanzada.orden.value+'&avanzada=1','principal');" /><br /><br /></td>
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

				
				//$contar=$query->buscar_blogs($_POST['palabra_buscar']);
				$contar=$query->listar_cliparts($_SESSION['AUTHORIZED'],$id_tipo,$letra,$filtrado,$orden,$id_subtema);
				$resultados=$query->listar_cliparts_limit($_SESSION['AUTHORIZED'],$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema);
				
				$total_records = mysql_num_rows($contar);
				$total_pages = intval($total_records / $cantidad);
				
				if ($total_records > 0) {
				
				while ($row=mysql_fetch_array($resultados)) {
				
				$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
				$encript->encriptar($ruta,1);
				
				$ruta_img='size=50&ruta=../../repositorio/originales/'.$row['imagen'];
				$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
				
				$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
				$encript->encriptar($ruta_cesto,1);
					
			?>
          <li> <a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/imagen.php?i=<?php echo $ruta; ?>', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});"><img src="classes/img/thumbnail.php?i=<?php echo $ruta_img; ?>" alt="Image" border="0" class="image" title="<?php echo $row['palabra']; ?>: <?php if (strlen($row['definicion']) > 100) { echo substr (utf8_encode($row['definicion']), 0, 100)."..."; } else { echo utf8_encode($row['definicion']); } ?>" /></a>
              <?php 	echo '<div id="products">';
			  if (strlen($row['palabra']) > 15) { echo substr($row['palabra'],0,15).".."; } else {  echo $row['palabra'];  }
			  
			  /* ALTERNATIVA CUANDO SE TRASLADE A HERRAMIENTAS*/
			 
			  $ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
			  $encript->encriptar($ruta_creador,1); 
				
			  echo '<br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto" title="a&ntilde;adir imagen a mi cesto"></a>&nbsp;&nbsp;&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\'Creador de Simbolos\', this.href)"><img src=\'images/paint.gif\' border="0" alt="Utilizar imagen en el creador" title="Utilizar imagen en el creador"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a></div>';
			  
			  /* ********************************************** */
			  
			  /*echo '<br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto" title="a&ntilde;adir imagen a mi cesto"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onClick="cargar_div(\'inc/creador_simbolos/creador_simbolos.php\',\'img='.$row['imagen'].'&id_palabra='.$row['id_palabra'].'\',\'principal\');"><img src=\'images/paint.gif\' border="0" alt="Utilizar imagen en el creador" title="Utilizar imagen en el creador"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a>
			    </div>';*/ ?>
          </li>
          <?php } } ?>
	    </ul>
      </div>
    </td>
    <td rowspan="2" valign="top">
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
							?> <li><a href="javascript:cargar_div('inc/public/ultimos_cliparts.php','id_subtema=<?php echo $row2['id_subtema'] ?>','principal');" title="<?php echo utf8_encode($row2['subtema'])?>"><?php echo utf8_encode($row2['subtema'])?></a></li>
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
	<div align="center" class="textos"><strong>Imagen: </strong><?php echo $inicial ?> a <?php echo $inicial+$cantidad ?> de <?php echo $total_records ?></div> 
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
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_cliparts.php','pg=0&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\"><< </a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"><<</span>';
        
        }
        
        // Pagina anterior
        if($pg > 0) { 
        
        $prev = ($pg - 1);
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_cliparts.php','pg=".$prev."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\"> <</a>&nbsp;";
        
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
                    
                    $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_cliparts.php','pg=".$i."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\">".$i."</a>&nbsp;";
                    }
                }
            
            } // Cierro el FOR
        
        } else {
        
            for($i = 0; $i <= $total_pages; $i++) {
            
                if(($pg) == $i) {
                
                $content.= '<span class="current">'.$i.'</span>&nbsp;';
                
                } else {
                
                $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_cliparts.php','pg=".$i."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\">".$i."</a>&nbsp;";
            
            } // Cierro el FOR
            
        } // Cierro el IF
        
        }
        
        // Siguiente página
        if($pg < $total_pages) {
        
        $next = ($pg + 1);
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_cliparts.php','pg=".$next."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\"> ></a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"> ></span>';
        
        }
        
        // Ultima página
        if($pg < $total_pages)
        {
        
        $last = $total_pages;
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/public/ultimos_cliparts.php','pg=".$last."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."','principal');\">  >></a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"> >></span>';
        
        }
        
        
        $content.= "</p></div>";
        
        echo $content;
        ?>
    </div></td>
  </tr>
</table>

<!--<div id="treeboxbox_tree"></div>    ARBOL DE CATEGORIAS --> 
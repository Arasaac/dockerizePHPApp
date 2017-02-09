<?php  
session_start();

include ('../../classes/querys/query.php');
require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 

$encript = new E5CR($llave);
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


$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
			

echo 	'<a href="javascript:void(0);" onClick="ventana_confirmacion_listado_simbolos(\'Esta seguro que desea borrar el simbolo seleccionado?\',
			\'300\',\'100\',
			\'inc/gestion_simbolos/borrar_simbolo.php\',  
			\'informacion_simbolo\'
			);" /><img src="images/papelera.gif" alt="Borrar simbolos seleccionados" title="Borrar simbolos seleccionados" border="0" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="ChequearTodos(true,\'listado_de_simbolos\');"><img src="images/seleccionar.gif" alt="Seleccionar Todos" title="Seleccionar Todos" border="0" /></a>';
?>
<form id="listado_de_simbolos" name="listado_de_simbolos" method="post" action="">
<div class="tabla_ultimas_imagenes" id="ultimas_imagenes">
        <ul id="thelist2">
<?php  
		
/* ******************************************************************************************* */ 
/*                            LISTAR SIMBOLOS 												   */
/* ******************************************************************************************* */ 

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
				
					if ($permisos['borrar_simbolos']==1) {
						$borrar='<input name="'.$row['id_simbolo'].'" type="checkbox" id="'.$row['id_simbolo'].'" value="1" />';
										
							
					} else { 
							
						$borrar='';
							
					}
							
					$folder=$row['id_tipo_simbolo'].$row['marco'].$row['contraste'].$row['sup_con_texto'].$row['sup_idioma'].$row['sup_mayusculas'].$row['sup_font'].$row['inf_con_texto'].$row['inf_idioma'].$row['inf_mayusculas'].$row['inf_font'];
				
					$ruta='img=../../repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_simbolo='.$row['id_simbolo'];
					$encript->encriptar($ruta,1);
					
					$ruta_img='size=50&ruta=../../repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'];
					$encript->encriptar($ruta_cesto,1);
					
			?>
          <li> <?php echo $borrar.'&nbsp;-&nbsp;'.$row['id_simbolo']; ?><br /><a href="javascript:void(0);" onclick="cargar_div('inc/gestion_simbolos/informacion_simbolo.php','id=<?php echo $row['id_simbolo']; ?>','informacion_simbolo');"><img src="classes/img/thumbnail_no_cache.php?i=<?php echo $ruta_img; ?>" alt="Image" border="0" class="image" title="<?php echo utf8_encode($row['palabra']); ?>: <?php if (strlen($row['definicion']) > 100) { echo substr (utf8_encode($row['definicion']), 0, 100)."..."; } else { echo utf8_encode($row['definicion']); } ?>" /></a>
              <?php 	
			  echo '<div id="products">';
			  if (strlen($row['palabra']) > 15) { echo substr(utf8_encode($row['palabra']),0,15).".."; } else {  echo utf8_encode($row['palabra']);  }
			  
			 /* ALTERNATIVA CUANDO SE TRASLADE A HERRAMIENTAS*/
			 
			  $ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
			  $encript->encriptar($ruta_creador,1); 
				
			  echo '</div>';
				?>
          </li>
          <?php } } ?>
	    </ul>
</div>
</div>
</form>
<br /><br />
<div align="center"><span class="textos"><strong>S&iacute;mbolo: </strong><?php echo $inicial ?> a <?php echo $inicial+$cantidad ?> de <?php echo $total_records ?></span>
</div>
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
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/gestion_simbolos/listar_simbolos.php','pg=0&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','tabla_simbolos');\"><< </a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"><<</span>';
        
        }
        
        // Pagina anterior
        if($pg > 0) { 
        
        $prev = ($pg - 1);
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/gestion_simbolos/listar_simbolos.php','pg=".$prev."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','tabla_simbolos');\"> <</a>&nbsp;";
        
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
                    
                    $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/gestion_simbolos/listar_simbolos.php','pg=".$i."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','tabla_simbolos');\">".$i."</a>&nbsp;";
                    }
                }
            
            } // Cierro el FOR
        
        } else {
        
            for($i = 0; $i <= $total_pages; $i++) {
            
                if(($pg) == $i) {
                
                $content.= '<span class="current">'.$i.'</span>&nbsp;';
                
                } else {
                
                $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/gestion_simbolos/listar_simbolos.php','pg=".$i."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','tabla_simbolos');\">".$i."</a>&nbsp;";
            
            } // Cierro el FOR
            
        } // Cierro el IF
        
        }
        
        // Siguiente p&aacute;gina
        if($pg < $total_pages) {
        
        $next = ($pg + 1);
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/gestion_simbolos/listar_simbolos.php','pg=".$next."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','tabla_simbolos');\"> ></a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"> ></span>';
        
        }
        
        // Ultima p&aacute;gina
        if($pg < $total_pages)
        {
        
        $last = $total_pages;
        $content.= "<a href=\"javascript:void(0);\" onclick=\"cargar_div('inc/gestion_simbolos/listar_simbolos.php','pg=".$last."&id_tipo=".$id_tipo."&letra=".$letra."&filtrado=".$filtrado."&orden=".$orden."&avanzada=".$_POST['avanzada']."&id_subtema=".$id_subtema."&marco=".$marco."&contraste=".$contraste."&tipo_letra=".$tipo_letra."&tipo_simbolo=".$id_tipo_simbolo."&checkboxes=".$_POST['checkboxes']."','tabla_simbolos');\">  >></a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"> >></span>';
        
        }
        
        
        $content.= "</p></div>";
        
        echo $content;
        ?>
</div>

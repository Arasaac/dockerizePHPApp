<?php 
session_start();  // INICIO LA SESION
header('Content-Type: text/html; charset=UTF-8');
require ('../../classes/languages/language_detect.php');
include ('../../classes/querys/query.php');
require ("../../classes/date/date_operations.php");
require ('../../classes/date/Date.class.php'); 
require ('../../funciones/funciones.php'); 

$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],12); 

$hoy=date("d-m-Y");
$hace_dias=5; //Valor en días para mostrar la imagen de Novedad

$cantidad= 5;

if (!isset($_POST['pg'])) {
	$pg = 0; // $pg es la pagina actual
} else { $pg=$_POST['pg']; }
				
	$inicial = $pg * $cantidad;
				
	$limite_inferior="5"; //resultados por debajo de la pagina actual
	$page_limit = $limite_inferior;
				
	$limitpages = $page_limit;
	$page_limit = $pg + $limitpages;

	$contar=$query->ultimas_fichas_software();
	$resultados=$query->ultimas_fichas_software_limit($inicial,$cantidad);
	
	$edicion="<a href=\"plugins/javapostlet/index_software.php\" onclick=\"return GB_showCenter('Subir archivos', this.href, 550, 780)\"><img src=\"images/page_white_get.png\" alt=\"Subir archivos\" border=\"0\" /></a> &nbsp;<a href=\"inc/gestion_software/gestionar_software.php?i=<?php echo rand(1000000,9999999); ?>\" onclick=\"return GB_showCenter('Añadir nueva ficha de Software', this.href, 550, 1024)\"><img src=\"images/page_white_add.png\" alt=\"Añadir nueva ficha de Software\" border=\"0\" /></a>";

	$total_records = $contar;
	$total_pages = intval($total_records / $cantidad);
	
$licencias=$query->listar_licencias();
$autores=$query->listar_autores();

$ac=$query->listar_areas_curriculares();
$ac_avanzado=$query->listar_areas_curriculares();

$dirigido=$query->listar_dirigido();
$dirigido_avanzado=$query->listar_dirigido();

//$edad=$query->listar_edad();

$nivel=$query->listar_nivel();
$nivel_avanzado=$query->listar_nivel();

$saa=$query->listar_saa();
$saa_avanzado=$query->listar_saa();

$tm=$query->listar_tipo_material();
$tm_avanzado=$query->listar_tipo_material();

$idiomas=$query->listar_idiomas();
$idiomas_avanzado=$query->listar_idiomas()
?>
<h4>Software <?php echo $edicion; ?> 
  <input id="hiddenStatusMenu" type="hidden" value="1" />
  <input id="hiddenStatusMenu_avanzado" type="hidden" value="0" />
</h4>
<form id="search_materiales" name="search_materiales" action="javascript:void(0);">
<?php 

while ($row=mysql_fetch_array($resultados)) {  

	$date_sin_hora=explode(" ",$row['fecha_alta']);
	$date=explode("-",$date_sin_hora[0]);
	$fecha_publicacion=$date[2].'-'.$date[1].'-'.$date[0];
	$publicado_hace=intval(compara_fechas($hoy,$fecha_publicacion)/86400);
?>
<div class="material" style="padding:10px; border:1px solid #CCCCCC; margin-bottom:15px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <?php if ($publicado_hace <= $hace_dias) { echo '<td width="1%" valign="top"><img src="images/b_novedad_.gif" border="0" alt="'.$translate['material_publicado_hace'].' '.$publicado_hace.' '.$translate['dia_s'].'" title="'.$translate['material_publicado_hace'].' '.$publicado_hace.' '.$translate['dia_s'].'" />&nbsp;</td>'; } 
	  else { echo '<td width="1%" valign="top">&nbsp;</td>'; } ?>
      <td width="35%" height="45" valign="top"><b><?php echo utf8_encode($row['software_titulo']); ?></b>
          <?php 
	   	  $mid=str_replace('}{',',',$row['software_idiomas']);
		  $mid=str_replace('{','',$mid);
		  $mid=str_replace('}','',$mid);
		  $mid=explode(',',$mid);
		  
		  for ($i=0;$i<count($mid);$i++) { 
			if ($mid[$i]!='') {
				if ($mid[$i]=='es') {
					echo '<img src="images/spain-flag-icon.png" border="0" alt="'.$translate['spanish'].'" title="'.$translate['spanish'].'">&nbsp;';
				} else {
			 		$data_idioma=$query->datos_idioma_por_abreviatura($mid[$i]);
						if ($_SESSION['language']=='es') { 
			 				echo '<img src="images/'.$data_idioma['img_flag'].'" border="0" alt="'.$data_idioma['idioma'].'" title="'.$data_idioma['idioma'].'">&nbsp;';
						} else {
							echo '<img src="images/'.$data_idioma['img_flag'].'" border="0" alt="'.$data_idioma['idioma_'.$_SESSION['language'].''].'" title="'.$data_idioma['idioma_'.$_SESSION['language'].''].'">&nbsp;';
						}
				} 
			}
		  }
		?></td>
      <td width="31%" valign="top"><?php 
	   $mau=str_replace('}{',',',$row['software_autor']);
		  $mau=str_replace('{','',$mau);
		  $mau=str_replace('}','',$mau);
		  $mau=explode(',',$mau);
		  
		  for ($i=0;$i<count($mau);$i++) { 
			if ($mau[$i]!='') {
			 $data_autor=$query->datos_autor($mau[$i]);
			 echo utf8_encode($data_autor['autor']).'<br />'; 
			}
		  }
		?></td>
      <td width="14%" valign="top"><?php echo $row['fecha_alta']; ?></td>
      <td width="15%" align="right" valign="top"><?php 	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { echo '<a href="inc/gestion_software/gestionar_software.php?id='.$row['id_software'].'&i='.rand(1000000,9999999).'" onclick="return GB_showCenter(\'Editar ficha Software\', this.href, 550, 1024)"><img src="images/page_edit.png" alt="Editar ficha software" title="Editar ficha software" border="0" /></a>&nbsp;';
	  
				if ($row['software_estado']==0) { echo '<img src="images/no_visible.gif" alt="Ficha no visible" title="Ficha no visible"border="0">';  }
				elseif ($row['software_estado']==1) { echo '<img src="images/visible.gif" alt="Ficha visible" title="Ficha visible" border="0">'; }
				elseif ($row['software_estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="Ficha pendiente de revisi&oacute;n" title="Ficha pendiente de revisi&oacute;n" border="0">'; 	}
			
			
if ($row['logo_licencia'] != '') { echo '&nbsp;<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'" border="0" /></a>';  } else {  echo utf8_encode($row['licencia']); } ?>      </td>
    </tr>
    <tr>
      <td colspan="5" valign="top"><?php echo $row['software_descripcion']; ?></td>
    </tr>
    <tr>
      <td height="19" colspan="4"><?php 
	      $ma=str_replace('}{',',',$row['software_archivos']);
		  $ma=str_replace('{','',$ma);
		  $ma=str_replace('}','',$ma);
		  $ma=explode(',',$ma); 
		  
			  for ($i=0;$i<count($ma);$i++) { 
				if ($ma[$i]!='') {
				 echo '<a href="zona_descargas/software/'.$row['id_software'].'/'.$ma[$i].'" target="_blank"><img src=\'images/download1.png\' border="0" alt="Descargar archivo" title="Descargar archivo"><a/><a href="zona_descargas/software/'.$row['id_software'].'/'.$ma[$i].'" target="_blank">'.$ma[$i].'</a><br />'; 
				}
			  }
		  

	  ?></td>
      <td width="5%" align="right" valign="bottom">&nbsp;</td>
    </tr>
  </table>
</div>
<?php } } // Cierro el While 
?>
<div align="center" class="textos"><strong><?php echo $translate['material']; ?>: </strong><?php echo $inicial ?> <?php echo $translate['a']; ?> <?php echo $inicial+$cantidad ?> <?php echo $translate['de']; ?> <?php echo $total_records ?></div> 
	<div align="center">
	  <?php 
	  	$content= '';
		
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
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/gestion_software/software.php','pg=0','principal');\"><< </a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"><<</span>';
        
        }
        
        // Pagina anterior
        if($pg > 0) { 
        
        $prev = ($pg - 1);
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/gestion_software/software.php','pg=".$prev."','principal');\"> <</a>&nbsp;";
        
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
                    
                    $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/gestion_software/software.php','pg=".$i."','principal');\">".$i."</a>&nbsp;";
                    }
                }
            
            } // Cierro el FOR
        
        } else {
        
            for($i = 0; $i <= $total_pages; $i++) {
            
                if(($pg) == $i) {
                
                $content.= '<span class="current">'.$i.'</span>&nbsp;';
                
                } else {
                
                $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/gestion_software/software.php','pg=".$i."','principal');\">".$i."</a>&nbsp;";
            
            } // Cierro el FOR
            
        } // Cierro el IF
        
        }
        
        // Siguiente página
        if($pg < $total_pages) {
        
        $next = ($pg + 1);
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/gestion_software/software.php','pg=".$next."','principal');\"> ></a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"> ></span>';
        
        }
        
        // Ultima página
        if($pg < $total_pages)
        {
        
        $last = $total_pages;
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/gestion_software/software.php','pg=".$last."','principal');\">  >></a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"> >></span>';
        
        }
        
        
        $content.= "</p></div>";
        
        echo $content;
        ?>
    </div>
</div>
</form>

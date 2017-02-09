<?php 
session_start();
include ('../../classes/querys/query.php');
require ('../../classes/languages/language_detect.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],12); 
$cantidad= 5;

if (!isset($_POST['pg'])) {
	$pg = 0; // $pg es la pagina actual
} else { $pg=$_POST['pg']; }
				
	$inicial = $pg * $cantidad;
				
	$limite_inferior="5"; //resultados por debajo de la pagina actual
	$page_limit = $limite_inferior;
				
	$limitpages = $page_limit;
	$page_limit = $pg + $limitpages;
	
$texto_buscar=utf8_decode($_POST['titulo_descripcion']);
$licencia=2;

if (isset($_POST['area_curricular']) && $_POST['area_curricular'] > 0) {  $sql.="AND material_area_curricular LIKE '%{".$_POST['area_curricular']."}%' ";  }
if (isset($_POST['subarea_curricular']) && $_POST['subarea_curricular'] > 0) {  $sql.="AND material_subarea_curricular LIKE '%{".$_POST['subarea_curricular']."}%' ";  }
if (isset($_POST['tipo']) && $_POST['tipo'] > 0) {  $sql.="AND material_tipo LIKE '%{".$_POST['tipo']."}%' ";  }
if (isset($_POST['dirigido']) && $_POST['dirigido'] > 0) {  $sql.="AND material_dirigido LIKE '%{".$_POST['dirigido']."}%' ";  }
if (isset($_POST['nivel']) && $_POST['nivel'] > 0) {  $sql.="AND material_nivel LIKE '%{".$_POST['nivel']."}%' ";  }
if (isset($_POST['saa']) && $_POST['saa'] > 0) {  $sql.="AND material_saa LIKE '%{".$_POST['saa']."}%' ";  }
if (isset($_POST['idiomas']) && $_POST['idiomas'] !='') {  $sql.="AND material_idiomas LIKE '%{".$_POST['idiomas']."}%' "; }

if (isset($_POST['autor']) && $_POST['autor'] !='') {
	$autores=$query->buscar_autores_nombre(utf8_decode($_POST['autor']));
	
		while ($row_autor=mysql_fetch_array($autores)) {
		
			$sql.="AND material_autor LIKE '%{".$row_autor['id_autor']."}%' "; 
		
		}
}

$contar=$query->buscar_materiales($_SESSION['AUTHORIZED'],$texto_buscar,$licencia,$sql);

	
if ($contar==false) { 

echo '<br /><br />
<h4>'.$translate['resultados_busqueda_materiales'].':</h4>
<br /><br />';
echo '<div align="center" style="color:#FF0000"><img src="images/error.gif" alt="'.$translate['no_resultados_criterios'].'" title="'.$translate['no_resultados_criterios'].'"><br />'.$translate['no_resultados_criterios'].'.</div>';

} else {

$resultados=$query->buscar_materiales_limit($_SESSION['AUTHORIZED'],$texto_buscar,$licencia,$sql,$inicial,$cantidad);

$total_records = mysql_num_rows($contar);
$total_pages = intval($total_records / $cantidad);

$n_resultados=mysql_num_rows($contar);

echo '
<h4>'.$translate['resultados_busqueda_materiales'].' ('.$n_resultados.'):</h4><br />
<p align="right"><a href="rss/subscripcion.php?t=1&titulo_descripcion='.$_POST['titulo_descripcion'].'&area_curricular='.$_POST['area_curricular'].'&subarea_curricular='.$_POST['subarea_curricular'].'&tipo='.$_POST['tipo'].'&dirigido='.$_POST['dirigido'].'&nivel='.$_POST['nivel'].'&saa='.$_POST['saa'].'&autor='.$_POST['autor'].'" target="_blank">   '.$translate['subscribirse_resultados_busqueda'].'</a>&nbsp;<a href="rss/subscripcion.php?t=1&titulo_descripcion='.$_POST['titulo_descripcion'].'&area_curricular='.$_POST['area_curricular'].'&subarea_curricular='.$_POST['subarea_curricular'].'&tipo='.$_POST['tipo'].'&dirigido='.$_POST['dirigido'].'&nivel='.$_POST['nivel'].'&saa='.$_POST['saa'].'&autor='.$_POST['autor'].'" target="_blank"><img src="images/feed.png" alt="'.$translate['subscribirse_resultados_busqueda'].'" title="'.$translate['subscribirse_resultados_busqueda'].'" border="0"></a></p><br />';

while ($row=mysql_fetch_array($resultados)) { ?>

<div class="material" style="padding:10px; border:1px solid #CCCCCC; margin-bottom:10px;">
<div style="width:100%;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%"><b><?php echo utf8_encode($row['material_titulo']); ?></b>
      <?php 
	   	  $mid=str_replace('}{',',',$row['material_idiomas']);
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
		?>      &nbsp; <a  href="javascript:void();" onclick="Effect.BlindDown('material_<?php echo $row['id_material'] ?>');; return false;" ></a></td>
    <td width="40%"><?php 
	   $mau=str_replace('}{',',',$row['material_autor']);
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
    <td width="10%"><div align="right"><b><a href="?id_material=<?php echo $row['id_material']; ?>"><img src="images/world_link.png" alt="<?php echo $translate['enlace_permanente']; ?>" width="16" height="16" border="0" title="<?php echo $translate['enlace_permanente']; ?>" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/descargar_material_zip.php?id_material=<?php echo $row['id_material']; ?>', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:300, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: '<?php echo $translate['cerrar']; ?>'});"><img src="images/compress.png" alt="<?php echo $translate['descargar_materiales_zip']; ?>" border="0" title="<?php echo $translate['descargar_materiales_zip']; ?>" /></a>&nbsp;
      <?php 	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { ?>
      <a href="inc/gestion_materiales/gestionar_material.php?id=<?php echo $row['id_material']; ?>&i=<?php echo rand(1000000,9999999); ?>" onclick="return GB_showCenter('Editar Material', this.href, 550, 780)"><img src="images/page_edit.png" alt="Editar Material" title="Editar Material" border="0" /></a>
          <?php 
				if ($row['material_estado']==0) { echo '<img src="images/no_visible.gif" alt="Material no visible" title="Material no visible"border="0">';  }
				elseif ($row['material_estado']==1) { echo '<img src="images/visible.gif" alt="Material visible" title="Material visible" border="0">'; }
				elseif ($row['material_estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="Material pendiente de revisi&oacute;n" title="Material pendiente de revisi&oacute;n" border="0">'; 	}
						
			} ?>
      </b>
          <?php if ($row['logo_licencia'] != '') { echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.$row['licencia'].'" title="'.$row['licencia'].'" border="0" /></a>';  } else {  echo $row['licencia']; } ?>
    </div></td>
  </tr>
  <tr>
    <td colspan="3"><br />
      <?php 
	    $ma=str_replace('}{',',',$row['material_archivos']);
		  $ma=str_replace('{','',$ma);
		  $ma=str_replace('}','',$ma);
		  $ma=explode(',',$ma);
		  
		  if (count($ma)<4 || count($ma)==4) { 
		  
			  for ($i=0;$i<count($ma);$i++) { 
				if ($ma[$i]!='') {
				 echo '<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank"><img src=\'images/download1.png\' border="0" alt="'.$translate['descargar_material'].'" title="'.$translate['descargar_material'].'"><a/><a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank">'.$ma[$i].'</a><br />'; 
				}
			  }
		  
		  } elseif (count($ma)>4) {
			  
			  for ($i=0;$i<4;$i++) { 
				if ($ma[$i]!='') {
				 echo '<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank"><img src=\'images/download1.png\' border="0" alt="'.$translate['descargar_material'].'" title="'.$translate['descargar_material'].'"><a/><a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank">'.$ma[$i].'</a><br />'; 
				}
			  }
			  
			  echo "<br /><a  href=\"javascript:void();\" onclick=\"Effect.BlindDown('archivos_".$row['id_material']."');; return false;\" >".$translate['ver_listado_completo_archivos']." (+)</a><br /><div id=\"archivos_".$row['id_material']."\" style=\"display:none;\"><div style=\"text-align:right;\"><a href=\"javascript:void(0);\" onclick=\"Effect.BlindUp('archivos_".$row['id_material']."');; return false;\"><img src=\"images/close.gif\" alt=\"".$translate['cerrar_datos_clasificacion']."\" title=\"".$translate['cerrar_datos_clasificacion']."\" border=\"0\"/>&nbsp;".$translate['cerrar']."</a></div>";
			  
			for ($i=4;$i<count($ma);$i++) { 
				if ($ma[$i]!='') {
				 echo '<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank"><img src=\'images/download1.png\' border="0" alt="'.$translate['descargar_material'].'" title="'.$translate['descargar_material'].'"><a/><a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank">'.$ma[$i].'</a><br />'; 
				}
			  }
			  
			  echo "</div>";
			  
			  
		  }
		  
	  ?></td>
    </tr>
  <tr>
    <td colspan="3"><div align="right"><a  href="javascript:void();" onclick="Effect.BlindDown('material_<?php echo $row['id_material'] ?>');; return false;" >(+&nbsp;<?php echo $translate['informacion']; ?>)</a></div></td>
  </tr>
</table>
</div>
 <div id="material_<?php echo $row['id_material'] ?>" style="display:none;"> 
 <hr style="border: 1px solid #CCCCCC;" />
 <div style="text-align:right;"><a href="javascript:void(0);" onclick="Effect.BlindUp('material_<?php echo $row['id_material'] ?>');; return false;">
        <img src="images/close.gif" alt="<?php echo $translate['cerrar_datos_clasificacion']; ?>" title="<?php echo $translate['cerrar_datos_clasificacion']; ?>" border="0"/>&nbsp;<?php echo $translate['cerrar']; ?></a></div>
<div style="width:100%;">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="99%" valign="top"><strong><?php echo $translate['descripcion']; ?>:</strong> <br />
      <?php echo utf8_encode($row['material_descripcion']); ?><br />      <br />      </td>
    <td width="1%" valign="top"><strong>
      <?php 


	  if (substr_count($row['material_archivos'],'.swf') == 1) {
	  		
		  echo $translate['previsualizacion']."<br/>";
		  
	  	  $ma=str_replace('}{',',',$row['material_archivos']);
		  $ma=str_replace('{','',$ma);
		  $ma=str_replace('}','',$ma);
		  $ma=explode(',',$ma);
		  
		  for ($i=0;$i<count($ma);$i++) { 
			if ($ma[$i]!='') {
			 	
			 	$split_archivo=explode('.',$ma[$i]);
				
				if ($split_archivo[1] == 'swf') {
					
					echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="200" height="200">
				  <param name="movie" value="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" />
				  <param name="quality" value="high" />
				  <embed src="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="200" height="200"></embed>
				</object><br/>';
				}
			 
			}
		  }
	  	
		
	  }
	  ?>
    </strong></td>
  </tr>
</table>
</div>
  <br /><strong><?php echo $translate['datos_clasificacion']; ?></strong><br />
<div style="width:100%;">
<table width="100%" border="0" cellpadding="4" cellspacing="4">
  <tr>
    <td valign="top" bgcolor="#D8FE9E"><strong><?php echo $translate['tipo']; ?>:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong><?php echo $translate['saac']; ?>:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong><?php echo $translate['nivel']; ?>:</strong></td>
    </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFCC"><?php 
	      $mt=str_replace('}{',',',$row['material_tipo']);
		  $mt=str_replace('{','',$mt);
		  $mt=str_replace('}','',$mt);
		  $mt=explode(',',$mt);
		  
		  for ($i=0;$i<count($mt);$i++) { 
			if ($mt[$i]!='') {
			 $data_tipo=$query->datos_material_tipo($mt[$i]);
			 	if ($_SESSION['id_language'] > 0) {
					echo $data_tipo['tipo_material_'.$_SESSION['language'].''].'<br />'; 
				} else {
			 		echo $data_tipo['tipo_material'].'<br />'; 
			 	}
			}
		  }
 	  ?></td>
    <td valign="top" bgcolor="#FFFFCC"><?php 
	  	  $msaa=str_replace('}{',',',$row['material_saa']);
		  $msaa=str_replace('{','',$msaa);
		  $msaa=str_replace('}','',$msaa);
		  $msaa=explode(',',$msaa);
		  
		  for ($i=0;$i<count($msaa);$i++) { 
			if ($msaa[$i]!='') {
			 $data_saa=$query->datos_material_saa($msaa[$i]);
			 	if ($_SESSION['id_language'] > 0) {
					echo  $data_saa['saa_material_'.$_SESSION['language'].''].'<br />';
				} else {
				 	echo  $data_saa['saa_material'].'<br />'; 
				}
			}
		  }
		?></td>
    <td valign="top" bgcolor="#FFFFCC"><?php 
	   	  $mn=str_replace('}{',',',$row['material_nivel']);
		  $mn=str_replace('{','',$mn);
		  $mn=str_replace('}','',$mn);
		  $mn=explode(',',$mn);
		  
		  for ($i=0;$i<count($mn);$i++) { 
			if ($mn[$i]!='') {
			 $data_nivel=$query->datos_material_nivel($mn[$i]);
			 	if ($_SESSION['id_language'] > 0) {
					echo $data_nivel['nivel_material_'.$_SESSION['language'].''].'<br />';
				} else {
					echo $data_nivel['nivel_material'].'<br />';
				} 
			}
		  }
	  ?></td>
    </tr>
  <tr>
    <td valign="top" bgcolor="#D8FE9E"><strong><?php echo $translate['dirigido']; ?>:</strong></td>
    <td colspan="2" valign="top" bgcolor="#D8FE9E"><strong><?php echo $translate['areas_subareas']; ?>:</strong></td>
    </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFCC"><?php
	 	 $md=str_replace('}{',',',$row['material_dirigido']);
		  $md=str_replace('{','',$md);
		  $md=str_replace('}','',$md);
		  $md=explode(',',$md);
		  
		  for ($i=0;$i<count($md);$i++) { 
			if ($md[$i]!='') {
			 $data_dirigido=$query->datos_material_dirigido($md[$i]);
			 	if ($_SESSION['id_language'] > 0) {
					echo  $data_dirigido['dirigido_material_'.$_SESSION['language'].''].'<br />';
				} else {
			 		echo  $data_dirigido['dirigido_material'].'<br />'; 
				}
			}
		  }
		?></td>
    <td colspan="2" valign="top" bgcolor="#FFFFCC"><?php 
	   $mac=str_replace('}{',',',$row['material_area_curricular']);
		  $mac=str_replace('{','',$mac);
		  $mac=str_replace('}','',$mac);
		  $mac=explode(',',$mac);
		  
		  for ($i=0;$i<count($mac);$i++) { 
			if ($mac[$i]!='') {
			 $data_ac=$query->datos_material_ac($mac[$i]);
			 	if ($_SESSION['id_language'] > 0) {
					echo  $data_ac['ac_material_'.$_SESSION['language'].''].'<br />';
				} else {
			  		echo  $data_ac['ac_material'].'<br />';
				} 
			 
			  $msubac=str_replace('}{',',',$row['material_subarea_curricular']);
			  $msubac=str_replace('{','',$msubac);
			  $msubac=str_replace('}','',$msubac);
			  $msubac=explode(',',$msubac);
			  
			  for ($j=0;$j<count($msubac);$j++) { 
					if ($msubac[$j]!='') {
					  $subareas=$query->datos_subarea($msubac[$j]);
					  if ($subareas['id_ac_material']==$mac[$i]) { 
					  		echo '<blockquote><img src="images/line2.gif" border="0">&nbsp;';
								if ($_SESSION['id_language'] > 0) {
									echo $subareas['subac_material_'.$_SESSION['language'].''];
								} else {
									echo $subareas['subac_material'];
								}
							echo '</blockquote>';  }
					}
			   }
	
			}
		  }
		?></td>
    </tr>
</table>
</div>
  </div>  
</div>
<p>
  <?php }  } ?>
<div align="center" class="textos"><strong><?php echo $translate['material']; ?>: </strong><?php echo $inicial ?> <?php echo $translate['a']; ?> <?php echo $inicial+$cantidad ?> <?php echo $translate['de']; ?> <?php echo $total_records ?></div> 
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
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/buscar_materiales_basico.php','pg=0&titulo_descripcion=".$_POST['titulo_descripcion']."&area_curricular=".$_POST['area_curricular']."&tipo=".$_POST['tipo']."&dirigido=".$_POST['dirigido']."&nivel=".$_POST['nivel']."&saa=".$_POST['saa']."&autor=".$_POST['autor']."&subarea_curricular=".$_POST['subarea_curricular']."','materiales');\"><< </a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"><<</span>';
        
        }
        
        // Pagina anterior
        if($pg > 0) { 
        
        $prev = ($pg - 1);
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/buscar_materiales_basico.php','pg=".$prev."&titulo_descripcion=".$_POST['titulo_descripcion']."&area_curricular=".$_POST['area_curricular']."&tipo=".$_POST['tipo']."&dirigido=".$_POST['dirigido']."&nivel=".$_POST['nivel']."&saa=".$_POST['saa']."&autor=".$_POST['autor']."&subarea_curricular=".$_POST['subarea_curricular']."','materiales');\"> <</a>&nbsp;";
        
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
                    
                    $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/buscar_materiales_basico.php','pg=".$i."&titulo_descripcion=".$_POST['titulo_descripcion']."&area_curricular=".$_POST['area_curricular']."&tipo=".$_POST['tipo']."&dirigido=".$_POST['dirigido']."&nivel=".$_POST['nivel']."&saa=".$_POST['saa']."&autor=".$_POST['autor']."&subarea_curricular=".$_POST['subarea_curricular']."','materiales');\">".$i."</a>&nbsp;";
                    }
                }
            
            } // Cierro el FOR
        
        } else {
        
            for($i = 0; $i <= $total_pages; $i++) {
            
                if(($pg) == $i) {
                
                $content.= '<span class="current">'.$i.'</span>&nbsp;';
                
                } else {
                
                $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/buscar_materiales_basico.php','pg=".$i."&titulo_descripcion=".$_POST['titulo_descripcion']."&area_curricular=".$_POST['area_curricular']."&tipo=".$_POST['tipo']."&dirigido=".$_POST['dirigido']."&nivel=".$_POST['nivel']."&saa=".$_POST['saa']."&autor=".$_POST['autor']."&subarea_curricular=".$_POST['subarea_curricular']."','materiales');\">".$i."</a>&nbsp;";
            
            } // Cierro el FOR
            
        } // Cierro el IF
        
        }
        
        // Siguiente p&aacute;gina
        if($pg < $total_pages) {
        
        $next = ($pg + 1);
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/buscar_materiales_basico.php','pg=".$next."&titulo_descripcion=".$_POST['titulo_descripcion']."&area_curricular=".$_POST['area_curricular']."&tipo=".$_POST['tipo']."&dirigido=".$_POST['dirigido']."&nivel=".$_POST['nivel']."&saa=".$_POST['saa']."&autor=".$_POST['autor']."&subarea_curricular=".$_POST['subarea_curricular']."','materiales');\"> ></a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"> ></span>';
        
        }
        
        // Ultima p&aacute;gina
        if($pg < $total_pages)
        {
        
        $last = $total_pages;
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/buscar_materiales_basico.php','pg=".$last."&titulo_descripcion=".$_POST['titulo_descripcion']."&area_curricular=".$_POST['area_curricular']."&tipo=".$_POST['tipo']."&dirigido=".$_POST['dirigido']."&nivel=".$_POST['nivel']."&saa=".$_POST['saa']."&autor=".$_POST['autor']."&subarea_curricular=".$_POST['subarea_curricular']."','materiales');\">  >></a>&nbsp;";
        
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
      <?php echo $translate['explicacion_licencia_materiales']; ?><br>
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

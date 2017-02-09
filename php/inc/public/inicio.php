<?php
session_start();  // INICIO LA SESION
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],23);

$id_tipo=99;
$letra="";
$orden="desc";
$filtrado="1";
$id_subtema=99999;
$busqueda="";
$inicial=0;
$cantidad=0;				
?>
<h4><?php echo $translate['bienvenidos_arasaac']; ?></h4>
<?php echo $translate['explicacion_que_es_arasaac']; ?>
<br /><br />
<div class="left_40">

<!-- *************************************************************************************************************************************************  -->
<h6><?php echo $translate['ultimos_pictogramas_color']; ?>&nbsp;&nbsp;<a class="grey" href="rss/subscripcion.php?t=4&id_tipo=10" target="_blank"><img src="images/rss.png" alt="<?php 		echo $translate['subscribirse_este_catalogo']; ?>" title="<?php echo $translate['subscribirse_este_catalogo']; ?>" border="0" /></a></h6>
        <ul id="thelist7">
		<?php  	
				if ($_SESSION['id_language'] > 0) {
					
					$tipo_pictograma=10;
					$resultados=$query->listar_pictogramas_idioma_limit($_SESSION['AUTHORIZED'],0,10,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$_SESSION['id_language'],$tipo_pictograma);
					
				} else {
					$resultados=$query->listar_pictogramas_color_limit($_SESSION['AUTHORIZED'],0,10,$id_tipo,$letra,$filtrado,$orden,$id_subtema);
				}
				
				$total_records = mysql_num_rows($resultados);
				
				if ($total_records > 0 ) {
				
				while ($row=mysql_fetch_array($resultados)) {
				
					$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
					$encript->encriptar($ruta,1);
					
					$ruta_img='size=40&ruta=../../repositorio/originales/'.$row['imagen'];
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
          </li>
          <?php } } ?>
          <li><?php echo '<a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ultimos_pictogramas_color.php","i=","principal");\'><small>'.$translate['ver_mas'].'</small></a>'; ?></li>
	    </ul>
        
 <!-- *************************************************************************************************************************************************  -->     
 
 
<!-- *************************************************************************************************************************************************  -->
<h6><?php echo $translate['ultimos_pictogramas_byn']; ?>&nbsp;&nbsp;<a class="grey" href="rss/subscripcion.php?t=4&id_tipo=5" target="_blank"><img src="images/rss.png" alt="<?php 		echo $translate['subscribirse_este_catalogo']; ?>" title="<?php echo $translate['subscribirse_este_catalogo']; ?>" border="0" /></a></h6>
	<div>
        <ul id="thelist7">
		<?php  	
				if ($_SESSION['id_language'] > 0) {
					
					$tipo_pictograma=5;
					$resultados=$query->listar_pictogramas_idioma_limit($_SESSION['AUTHORIZED'],0,10,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$_SESSION['id_language'],$tipo_pictograma);

				} else {
					$resultados=$query->listar_pictogramas_byn_limit($_SESSION['AUTHORIZED'],0,10,$id_tipo,$letra,$filtrado,$orden,$id_subtema);
				}
				
				$total_records = mysql_num_rows($resultados);
				
				if ($total_records > 0 ) {
				
				while ($row=mysql_fetch_array($resultados)) {
				
					$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
					$encript->encriptar($ruta,1);
					
					$ruta_img='size=40&ruta=../../repositorio/originales/'.$row['imagen'];
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
          </li>
          <?php } } ?>
          <li><?php echo '<a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ultimos_pictogramas_byn.php","i=","principal");\'><small>'.$translate['ver_mas'].'</small></a>'; ?></li>
	    </ul>
     </div>
  
 <!-- *************************************************************************************************************************************************  -->  
 
<!-- *************************************************************************************************************************************************  -->
<h6><?php echo $translate['ultimas_imagenes']; ?>&nbsp;&nbsp;<a class="grey" href="rss/subscripcion.php?t=4&id_tipo=2" target="_blank"><img src="images/rss.png" alt="<?php 		echo $translate['subscribirse_este_catalogo']; ?>" title="<?php echo $translate['subscribirse_este_catalogo']; ?>" border="0" /></a></h6>
	<div>
        <ul id="thelist7">
		<?php  	
				if ($_SESSION['id_language'] > 0) {
					
					$tipo_pictograma=2;
					$resultados=$query->listar_pictogramas_idioma_limit($_SESSION['AUTHORIZED'],0,10,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$_SESSION['id_language'],$tipo_pictograma);
				} else {
					$resultados=$query->listar_imagenes_limit($_SESSION['AUTHORIZED'],0,10,$id_tipo,$letra,$filtrado,$orden,$id_subtema);		
				}
				
				$total_records = mysql_num_rows($resultados);
				
				if ($total_records > 0 ) {
				
				while ($row=mysql_fetch_array($resultados)) {
				
					$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
					$encript->encriptar($ruta,1);
					
					$ruta_img='size=40&ruta=../../repositorio/originales/'.$row['imagen'];
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
          </li>
          <?php } } ?>
          <li><?php echo '<a href="javascript:void(0);" onClick=\'cargar_div("inc/public/ultimas_imagenes.php","i=","principal");\'><small>'.$translate['ver_mas'].'</small></a>'; ?></li>
	    </ul>
     </div>
  
 <!-- *************************************************************************************************************************************************  -->
 
 <!-- *************************************************************************************************************************************************  -->
   <h6><?php echo $translate['ultimos_materiales']; ?>&nbsp;&nbsp;<a class="grey" href="rss/subscripcion.php?t=3" target="_blank"><img src="images/rss.png" alt="<?php echo $translate['subscribirse_catalogo_materiales']; ?>" title="<?php echo $translate['subscribirse_catalogo_materiales']; ?>" border="0" /></a></h6><br />
   
   <?php 
   $resultados=$query->ultimos_materiales_publicados_limit(0,10);
   $total_records = mysql_num_rows($resultados);
   if ($total_records > 0 ) {
				
		while ($row=mysql_fetch_array($resultados)) {
		?>
  <div class="material" style="padding:10px; border:1px solid #CCCCCC; margin-bottom:15px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="35%" height="45" valign="top"><b><?php echo utf8_encode($row['material_titulo']); ?></b>
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
				?></td>
	    <td width="31%" valign="top"><?php 
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
	    <td width="15%" align="right" valign="top"><a href="?id_material=<?php echo $row['id_material']; ?>"><img src="images/world_link.png" alt="<?php echo $translate['enlace_permanente']; ?>" width="16" height="16" border="0" title="<?php echo $translate['enlace_permanente']; ?>" /></a> <a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/descargar_material_zip.php?id_material=<?php echo $row['id_material']; ?>', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:300, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});"><img src="images/compress.png" alt="<?php echo $translate['descargar_materiales_zip']; ?>" border="0" title="<?php echo $translate['descargar_materiales_zip']; ?>" /></a>
		    <?php 	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { echo '<a href="inc/gestion_materiales/gestionar_material.php?id='.$row['id_material'].'&i='.rand(1000000,9999999).'" onclick="return GB_showCenter(\'Editar Material\', this.href, 550, 780)"><img src="images/page_edit.png" alt="Editar Material" title="Editar Material" border="0" /></a>&nbsp;';
			  
						if ($row['material_estado']==0) { echo '<img src="images/no_visible.gif" alt="Material no visible" title="Material no visible"border="0">';  }
						elseif ($row['material_estado']==1) { echo '<img src="images/visible.gif" alt="Material visible" title="Material visible" border="0">'; }
						elseif ($row['material_estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="Material pendiente de revisi&oacute;n" title="Material pendiente de revisi&oacute;n" border="0">'; 	}
					
					
		}  ?></td>
	  </tr>
    </table>
		  <div id="material_<?php echo $row['id_material'] ?>" style="display:none;"> 
		 <hr style="border: 1px solid #CCCCCC;" />
		 <div style="text-align:right;"><a href="javascript:void(0);" onclick="Effect.BlindUp('material_<?php echo $row['id_material'] ?>');; return false;">
				<img src="images/close.gif" alt="<?php echo $translate['cerrar_datos_clasificacion']; ?>" title="<?php echo $translate['cerrar_datos_clasificacion']; ?>" border="0"/>&nbsp;<?php echo $translate['cerrar']; ?></a></div>
		 <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="75%" height="110" valign="top"><strong><?php echo $translate['descripcion']; ?>:</strong> <br />
			  <?php echo utf8_encode($row['material_descripcion']); ?><br />      <br />      </td>
			<td width="200" valign="top"><strong>
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
		  <br /><strong><?php echo $translate['datos_clasificacion']; ?></strong><br />
		 <table width="100%%" border="0" cellpadding="4" cellspacing="4">
		  <tr>
			<td valign="top" bgcolor="#D8FE9E"><strong><?php echo $translate['tipo']; ?>:</strong></td>
			<td valign="top" bgcolor="#D8FE9E"><strong><?php echo $translate['saac']; ?>:</strong></td>
			<td valign="top" bgcolor="#D8FE9E"><strong><?php echo $translate['nivel']; ?>:</strong></td>
			<td valign="top" bgcolor="#D8FE9E"><strong><?php echo $translate['dirigido']; ?>:</strong></td>
			<td valign="top" bgcolor="#D8FE9E"><strong><?php echo $translate['areas_subareas']; ?>:</strong></td>
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
							echo utf8_encode($data_tipo['tipo_material_'.$_SESSION['language'].'']).'<br />'; 
						} else {
							echo utf8_encode($data_tipo['tipo_material']).'<br />'; 
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
							echo  utf8_encode($data_saa['saa_material_'.$_SESSION['language'].'']).'<br />';
						} else {
							echo  utf8_encode($data_saa['saa_material']).'<br />'; 
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
							echo  utf8_encode($data_nivel['nivel_material_'.$_SESSION['language'].'']).'<br />';
						} else {
							echo  utf8_encode($data_nivel['nivel_material']).'<br />';
						} 
					}
				  }
			  ?></td>
			<td valign="top" bgcolor="#FFFFCC"><?php
				 $md=str_replace('}{',',',$row['material_dirigido']);
				  $md=str_replace('{','',$md);
				  $md=str_replace('}','',$md);
				  $md=explode(',',$md);
				  
				  for ($i=0;$i<count($md);$i++) { 
					if ($md[$i]!='') {
					 $data_dirigido=$query->datos_material_dirigido($md[$i]);
						if ($_SESSION['id_language'] > 0) {
							echo  utf8_encode($data_dirigido['dirigido_material_'.$_SESSION['language'].'']).'<br />';
						} else {
							echo  utf8_encode($data_dirigido['dirigido_material']).'<br />'; 
						}
					}
				  }
				?></td>
			<td valign="top" bgcolor="#FFFFCC"><?php 
			   $mac=str_replace('}{',',',$row['material_area_curricular']);
				  $mac=str_replace('{','',$mac);
				  $mac=str_replace('}','',$mac);
				  $mac=explode(',',$mac);
				  
				  for ($i=0;$i<count($mac);$i++) { 
					if ($mac[$i]!='') {
					 $data_ac=$query->datos_material_ac($mac[$i]);
						if ($_SESSION['id_language'] > 0) {
							echo  utf8_encode($data_ac['ac_material_'.$_SESSION['language'].'']).'<br />';
						} else {
							echo  utf8_encode($data_ac['ac_material']).'<br />';
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
											echo utf8_encode($subareas['subac_material_'.$_SESSION['language'].'']);
										} else {
											echo utf8_encode($subareas['subac_material']);
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
		<?php 
		}
		
	}				
	echo '<br /><div align="right"><a href="javascript:void(0);" onClick=\'cargar_div("inc/public/materiales.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");\'>'.$translate['ver_mas'].'</a></div>'; 		
   ?>
    <!-- *************************************************************************************************************************************************  -->
    
    
    
	</div>

	<div class="right_60">
			<?php 
			$limit=4;
			
			if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { 
			
				$ultimas_noticias=$query->ultimas_noticias_publicadas($limit);
				echo '<h6>'.$translate['ultimas_noticias'].'</h6>';
			
			 } else { 
			 ?>

			<?php 
			echo '<h6>'.$translate['ultimas_noticias'].':</h6><br /><a href="inc/noticias/nueva_noticia.php" onclick="return GB_showCenter(\''.$translate['nueva_noticia'].'\', this.href)"><img src="images/mas.gif" alt="'.$translate['nueva_noticia'].'" title="'.$translate['nueva_noticia'].'" border="0" /></a>  <a href="inc/noticias/nueva_noticia.php" onclick="return GB_showCenter(\''.$translate['nueva_noticia'].'\', this.href)">'.$translate['nueva_noticia'].'</a><br />';
			
				$ultimas_noticias=$query->ultimas_noticias($limit);
				
				} ?>
			<br />
            <p align="right"><a href="rss/subscripcion.php?t=2" target="_blank"><?php echo $translate['subcribirse_canal_noticias']; ?></a>&nbsp;&nbsp;<a href="rss/subscripcion.php?t=2" target="_blank"><img src="images/feed.png" alt="<?php echo $translate['subcribirse_canal_noticias']; ?>" title="<?php echo $translate['subcribirse_canal_noticias']; ?>" width="16" height="16" border="0" /></a></p> 
			<?php 
			
			while ($noticias=mysql_fetch_array($ultimas_noticias)) { 
			
			if ($_SESSION['language']=='es') {
			?>
            
          <!-- Start Main Content -->
		  <div style="border:1px solid #CCCCCC; padding:20px; margin-bottom:20px;">			 		            
		    <div style="background-color:#FF9900; margin-bottom:10px; color:#FFFFFF; font-size:14px; padding:3px; font-weight:bold;"><?php echo $noticias['titulo']; ?></div>			 
		       <div style=" font-size:10px; border-bottom: 1px solid #CCCCCC; margin-bottom:10px;"><b><?php echo $translate['escrito_por']; ?>:</b> <em><?php echo utf8_encode($noticias['nombre']).'&nbsp;'.utf8_encode($noticias['primer_apellido']).'&nbsp;'.utf8_encode($noticias['segundo_apellido']); ?></em><b><?php echo $translate['el']; ?></b>&nbsp;<em><?php echo utf8_encode($noticias['fecha_modificacion']); ?></em> 
		         &nbsp;&nbsp;
		         <?php if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { ?>
                 <?php } else { ?>
                 <a href="inc/noticias/editar_noticia.php?id_noticia=<?php echo $noticias['id_noticia']; ?>&amp;i=<?php echo rand(1000000,9999999); ?>" onclick="return GB_showCenter('<?php echo $translate['editar_noticia']; ?>', this.href)"><img src="images/edit.gif" alt="<?php echo $translate['editar_noticia']; ?>" title="<?php echo $translate['editar_noticia']; ?>" border="0" /></a>
                 <?php 
				if ($noticias[7]==0) { echo '<img src="images/no_visible.gif" alt="'.$translate['noticia_no_visible'].'" title="'.$translate['noticia_no_visible'].'" border="0">';  }
				elseif ($noticias[7]==1) { echo '<img src="images/visible.gif" alt="'.$translate['noticia_visible'].'" title="'.$translate['noticia_visible'].'" border="0">'; }
				elseif ($noticias[7]==2) { echo '<img src="images/pendiente_revision.gif" alt="'.$translate['noticia_pendiente_revision'].'" title="'.$translate['noticia_pendiente_revision'].'" border="0">'; }
			
	 		} ?>
		</div>
			<p><?php echo $noticias['noticia']; ?></p>

			</div>
		  <!-- End Main Content -->

<?php } else {  

		if ($noticias['titulo_'.$_SESSION['language'].''] !='' && $noticias['noticia_'.$_SESSION['language'].''] !='') {
?>

          <!-- Start Main Content -->
		  <div style="border:1px solid #CCCCCC; padding:20px; margin-bottom:20px;">			 		            
		    <div style="background-color:#FF9900; margin-bottom:10px; color:#FFFFFF; font-size:14px; padding:3px; font-weight:bold;"><?php echo utf8_encode($noticias['titulo_'.$_SESSION['language'].'']); ?></div>			 
		       <div style=" font-size:10px; border-bottom: 1px solid #CCCCCC; margin-bottom:10px;"><b><?php echo $translate['escrito_por']; ?>:</b> <em><?php echo utf8_encode($noticias['nombre']).'&nbsp;'.utf8_encode($noticias['primer_apellido']).'&nbsp;'.utf8_encode($noticias['segundo_apellido']); ?></em><b><?php echo $translate['el']; ?></b>&nbsp;<em><?php echo utf8_encode($noticias['fecha_modificacion']); ?></em> 
		         &nbsp;&nbsp;
		         <?php if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { ?>
                 <?php } else { ?>
                 <a href="inc/noticias/editar_noticia.php?id_noticia=<?php echo $noticias['id_noticia']; ?>&amp;i=<?php echo rand(1000000,9999999); ?>" onclick="return GB_showCenter('<?php echo $translate['editar_noticia']; ?>', this.href)"><img src="images/edit.gif" alt="<?php echo $translate['editar_noticia']; ?>" title="<?php echo $translate['editar_noticia']; ?>" border="0" /></a>
                 <?php 
				if ($noticias[7]==0) { echo '<img src="images/no_visible.gif" alt="'.$translate['noticia_no_visible'].'" title="'.$translate['noticia_no_visible'].'" border="0">';  }
				elseif ($noticias[7]==1) { echo '<img src="images/visible.gif" alt="'.$translate['noticia_visible'].'" title="'.$translate['noticia_visible'].'" border="0">'; }
				elseif ($noticias[7]==2) { echo '<img src="images/pendiente_revision.gif" alt="'.$translate['noticia_pendiente_revision'].'" title="'.$translate['noticia_pendiente_revision'].'" border="0">'; }
			
	 		} ?>
		</div>
			<p><?php echo utf8_encode($noticias['noticia_'.$_SESSION['language'].'']); ?></p>

			</div>
		  <!-- End Main Content -->

<?php  } // Cierro el IF de comprobación de si la noticia tiene contenido

	} // Cierro el IF de comprobación de si el idioma es castellano

}  // Cierro el While de las Noticias?>	

</div>
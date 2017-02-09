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

if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { 

	$contar=$query->ultimos_materiales_publicados();
	$resultados=$query->ultimos_materiales_publicados_limit($inicial,$cantidad);

} else {

	$contar=$query->ultimos_materiales();
	$resultados=$query->ultimos_materiales_limit($inicial,$cantidad);
	
	$edicion="<a href=\"plugins/javapostlet/index.php\" onclick=\"return GB_showCenter('Subir materiales a la carpeta temporal', this.href, 550, 1024)\"><img src=\"images/page_white_get.png\" alt=\"Subir materiales a la carpeta temporal\" border=\"0\" /></a> &nbsp;<a href=\"inc/gestion_materiales/gestionar_material.php?i=<?php echo rand(1000000,9999999); ?>\" onclick=\"return GB_showCenter('Añadir nuevo material', this.href, 550, 1024)\"><img src=\"images/page_white_add.png\" alt=\"Añadir Material\" border=\"0\" /></a>";
	
}

	$total_records = mysql_num_rows($contar);
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
<h4><?php echo $translate['materiales']; ?><?php echo $edicion; ?> 
  <input id="hiddenStatusMenu" type="hidden" value="1" />
  <input id="hiddenStatusMenu_avanzado" type="hidden" value="0" />
</h4>
<div style="float:right; text-align:center; margin-right:15px;"><a href="javascript:void(0);" onclick="javascript:showMenu();"><img src="images/busqueda_basica.jpg" alt="<?php echo $translate['busqueda_basica']; ?>" title="<?php echo $translate['busqueda_basica']; ?>" border="0" /><br/><?php echo $translate['busqueda_basica']; ?></a></div> 
  <div style="float:right; text-align:center; margin-right:15px;"><a href="javascript:void(0);" onclick="javascript:showMenu_avanzado();"><img src="images/busqueda_avanzada.jpg" alt="<?php echo $translate['busqueda_avanzada']; ?>" title="<?php echo $translate['busqueda_avanzada']; ?>" border="0" /><br/><?php echo $translate['busqueda_avanzada']; ?></a><div></div></div>
    <div style="float:left; text-align:center; margin:10px;"><a href="rss/subscripcion.php?t=3" target="_blank"><img src="images/rss2.png" alt="<?php echo $translate['subscribirse_catalogo_materiales']; ?>" title="<?php echo $translate['subscribirse_catalogo_materiales']; ?>" border="0" /><br/></a><div></div></div>
<?php echo $translate['explicacion_seccion_materiales']; ?>
<form id="search_materiales" name="search_materiales" action="javascript:void(0);">
<br />
<div id="busqueda_materiales" style="float:right; width:40%;">
<div class="searchoption" id="searchmenu" style="display:block;margin-left:5px; margin-bottom:25px; float:right;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" valign="top"><a href="javascript:void(0);" onclick="hideMenu()"><?php echo $translate['cerrar']; ?></a></td>
  </tr>
  <tr>
    <td valign="top"><div style="border-bottom:1px dashed #CCCCCC; font-size:14px; font-weight:bold; color:#0066FF;"><?php echo $translate['buscador_basico_materiales']; ?></div></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" valign="top">

<label><strong><?php echo $translate['titulo_descripcion_objetivos']; ?></strong></label>
<div class="suboption" id="so1"><input name="titulo_descripcion_basico" type="text" id="titulo_descripcion_basico" size="40"/>
</div>
<label><strong><?php echo $translate['autor']; ?></strong></label>
<div class="suboption" id="so3">
  <input name="autor_basico" type="text" id="autor_basico" size="40"/>
</div>
<label><strong><?php echo $translate['area']; ?></strong></label>
    <div class="suboption" id="so1">
    <select name="area_curricular_basico" id="area_curricular_basico" realname="Area" onchange="cargar_div('inc/public/listar_subareas.php','id_area='+document.search_materiales.area_curricular_basico.value+'','subareas');">
     <option value="0" selected="selected"><?php echo $translate['seleccionar']; ?></option>
     <?php while ($row_ac=mysql_fetch_array($ac)) {  
	 		if ($_SESSION['id_language'] > 0) {
			
				echo '<option value="'.$row_ac['id_ac_material'].'">'.$row_ac['ac_material_'.$_SESSION['language'].''].'</option>';
				
			} else {
			
	 			echo '<option value="'.$row_ac['id_ac_material'].'">'.$row_ac['ac_material'].'</option>';
			}
	 } ?>
    </select>
    </div>
    <div id="subareas"><input name="subarea_curricular_basico" type="hidden" value="0" /></div>
<label><strong><?php echo $translate['tipo']; ?></strong></label>
	<div class="suboption" id="so1">
        <select name="tipo_basico" id="tipo_basico" realname="Tipo de Material">
          <option value="0" selected="selected"><?php echo $translate['seleccionar']; ?></option>
          <?php while ($row_tm=mysql_fetch_array($tm)) {  
		  		if ($_SESSION['id_language'] > 0) {
					echo '<option value="'.$row_tm['id_tipo_material'].'">'.$row_tm['tipo_material_'.$_SESSION['language'] .''].'</option>';	
				} else {
					echo '<option value="'.$row_tm['id_tipo_material'].'">'.$row_tm['tipo_material'].'</option>';
				}
		 } ?>
         </select>
      </div>
        <label><strong><?php echo $translate['dirigido']; ?></strong></label>
	  <div class="suboption" id="so2">
      <select name="dirigido_basico" id="dirigido_basico" realname="Dirigido a">
         <option value="0" selected="selected"><?php echo $translate['seleccionar']; ?></option>
        <?php while ($row_dirigido=mysql_fetch_array($dirigido)) { 
				if ($_SESSION['id_language'] > 0) {
					echo '<option value="'.$row_dirigido['id_dirigido_material'].'">'.$row_dirigido['dirigido_material_'.$_SESSION['language'].''].'</option>'; 
				} else {
		    		echo '<option value="'.$row_dirigido['id_dirigido_material'].'">'.$row_dirigido['dirigido_material'].'</option>'; 
				}
	 } ?>
       </select>
      </div>
	  <label><strong><?php echo $translate['nivel']; ?></strong></label>
      <div class="suboption" id="so2">
        <select name="nivel_basico" id="nivel_basico" required="1" realname="Nivel">
          <option value="0" selected="selected"><?php echo $translate['seleccionar']; ?></option>
          <?php while ($row_nivel=mysql_fetch_array($nivel)) {  
		  		if ($_SESSION['id_language'] > 0) {
					echo '<option value="'.$row_nivel['id_nivel_material'].'">'.$row_nivel['nivel_material_'.$_SESSION['language'].''].'</option>';
				} else {
	 				echo '<option value="'.$row_nivel['id_nivel_material'].'">'.$row_nivel['nivel_material'].'</option>';
				}
	 } ?>
        </select>
      </div>
      <label><strong><?php echo $translate['saac']; ?></strong></label>
      
      <div class="suboption" id="so2">
      <select name="saa_basico" id="saa_basico" required="1" realname="SAA">
        <option value="0" selected="selected"><?php echo $translate['seleccionar']; ?></option>
        <?php while ($row_saa=mysql_fetch_array($saa)) {  
		
				if ($_SESSION['id_language'] > 0) {
					echo '<option value="'.$row_saa['id_saa_material'].'">'.$row_saa['saa_material_'.$_SESSION['language'].''].'</option>';
				} else {
		    		echo '<option value="'.$row_saa['id_saa_material'].'">'.$row_saa['saa_material'].'</option>';
				}
	    } ?>
      </select>
      </div>
      <label><strong><?php echo $translate['idiomas']; ?></strong></label>
      <div class="suboption" id="so2">
      <select name="idioma" id="idioma">
        <option value="" selected="selected"><?php echo $translate['cualquiera']; ?></option>
        <option value="es"><?php echo $translate['spanish']; ?></option>
        <?php while ($row_idiomas=mysql_fetch_array($idiomas)) {  
		
				if ($_SESSION['id_language'] > 0) {
					echo '<option value="'.$row_idiomas['idioma_abrev'].'">'.$row_idiomas['idioma_'.$_SESSION['language'].''].'</option>';
				} else {
		    		echo '<option value="'.$row_idiomas['idioma_abrev'].'">'.$row_idiomas['idioma'].'</option>';
				}
	    } ?>
      </select>
      </div>
      <p align="center">
        <input type="button" name="button" id="button" value="<?php echo $translate['buscar']; ?>" onclick="cargar_div('inc/public/buscar_materiales_basico.php','titulo_descripcion='+document.search_materiales.titulo_descripcion_basico.value+'&area_curricular='+document.search_materiales.area_curricular_basico.value+'&tipo='+document.search_materiales.tipo_basico.value+'&dirigido='+document.search_materiales.dirigido_basico.value+'&nivel='+document.search_materiales.nivel_basico.value+'&saa='+document.search_materiales.saa_basico.value+'&autor='+document.search_materiales.autor_basico.value+'&subarea_curricular='+document.search_materiales.subarea_curricular_basico.value+'&idiomas='+document.search_materiales.idioma.value+'','materiales');" />
</p>
</td></tr></table></div>

<div id="busqueda_materiales" style="float:right;">
<div class="searchoption" id="searchmenu_avanzado" style="display:none; margin-left:5px; margin-bottom:25px; float:right;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="right" valign="top"><a href="javascript:void(0);" onclick="hideMenu_avanzado()"><?php echo $translate['cerrar']; ?></a></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><div style="border-bottom:1px dashed #CCCCCC; font-size:14px; font-weight:bold; color:#0066FF;"><?php echo $translate['buscador_avanzado_materiales']; ?></div></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><input name="textfield" type="text" id="textfield" size="40"/></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><label><strong><?php echo $translate['titulo_descripcion_objetivos']; ?></strong></label>
    <br />
<label><strong><?php echo $translate['area_subarea']; ?></strong></label>
    <div class="suboption" id="so1">
     <?php while ($row_ac_avanzado=mysql_fetch_array($ac_avanzado)) {  
	 		$listado_subareas=$query->listar_subareas_curriculares($row_ac_avanzado['id_ac_material']);
			if (mysql_num_rows($listado_subareas) > 0 ) {
			   echo '<a href="javascript:void();" onClick="Effect.BlindDown(\'ac_'.$row_ac_avanzado['id_ac_material'].'\');; return false;"><img src="images/plus3.gif" border="0"></a>&nbsp;';
			} else {
				echo '<img src="images/line3.gif" border="0">&nbsp;';
			}
			echo '<input type="checkbox" name="area_curricular" id="area_curricular" value="'.$row_ac_avanzado['id_ac_material'].'"/><label>';
			
				if ($_SESSION['id_language'] > 0) {
					echo $row_ac_avanzado['ac_material_'.$_SESSION['language'].''];
				} else {
					echo $row_ac_avanzado['ac_material'];
				}
			
			echo '</label><br/>';
			if (mysql_num_rows($listado_subareas) > 0 ) {
				echo '<div id="ac_'.$row_ac_avanzado['id_ac_material'].'" style="display:none; padding-left:25px;"><a href="javascript:void();" onClick="Effect.BlindUp(\'ac_'.$row_ac_avanzado['id_ac_material'].'\');; return false;"><img src="images/minus3.gif" border="0"></a><br />';
				while ($row=mysql_fetch_array($listado_subareas)) {			
					echo '<img src="images/line2.gif" border="0">&nbsp;<input type="checkbox" name="subarea_curricular" id="subarea_curricular" value="'.$row['id_subac_material'].'"/><label>';
					
						if ($_SESSION['id_language'] > 0) {
							echo $row['subac_material_'.$_SESSION['language'].''];
						} else {
							echo $row['subac_material'];
						}
						
					echo '<br />'; 
				}
				echo '</div>';
			}
	 } ?>
    </div>	</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" valign="top">
<label></label><label><strong><?php echo $translate['tipo']; ?></strong></label>
	<div class="suboption" id="so1">
		<?php while ($row_tm_avanzado=mysql_fetch_array($tm_avanzado)) {  
				
			echo '<input type="checkbox" name="tipo" id="tipo" value="'.$row_tm_avanzado['id_tipo_material'].'"/><label>';
			
				if ($_SESSION['id_language'] > 0) {
					echo $row_tm_avanzado['tipo_material_'.$_SESSION['language'].''];
				} else {
					echo $row_tm_avanzado['tipo_material'];
				}
			
			echo '</label><br/>';
	
		 } ?>
    </div> 
    
    <label><strong><?php echo $translate['saac']; ?></strong></label>
    <div class="suboption" id="so4">
      <?php while ($row_saa_avanzado=mysql_fetch_array($saa_avanzado)) {  
	 		echo '<input type="checkbox" name="saa" id="saa" value="'.$row_saa_avanzado['id_saa_material'].'"/><label>';
			
				if ($_SESSION['id_language'] > 0) {
					echo $row_saa_avanzado['saa_material_'.$_SESSION['language'].''];
				} else {
					echo $row_saa_avanzado['saa_material'];
				}
			
			echo '</label><br/>';
	 } ?>
    </div>
    <label><strong><?php echo $translate['idiomas']; ?>: </strong></label>
    <div class="suboption" id="so5">
      <?php 
	  	echo '<input type="checkbox" name="idiomas" id="idiomas" value="es"/><label>'.$translate['spanish'].'</label><br/>';
		
	  	while ($row_idiomas_avanzado=mysql_fetch_array($idiomas_avanzado)) {  
	 		echo '<input type="checkbox" name="idiomas" id="idiomas" value="'.$row_idiomas_avanzado['idioma_abrev'].'"/><label>';
			
				if ($_SESSION['id_language'] > 0) {
					echo $row_idiomas_avanzado['idioma_'.$_SESSION['language'].''];
				} else {
					echo $row_idiomas_avanzado['idioma'];
				}
			
			echo '</label><br/>';
	 } ?>
    </div>
    <label><strong><?php echo $translate['licencia']; ?>: </strong></label>
    <div class="suboption" id="so1">
          <select name="licencia" id="licencia" required="1" realname="Categoría" disabled="disabled">
           <?php while ($row_rsLicencia=mysql_fetch_array($licencias)) {  ?>
            <option value="<?php echo $row_rsLicencia['id_licencia']?>" <?php if ($row_rsLicencia['id_licencia']=='2') { echo 'selected'; } ?>>
				<?php 	if ($_SESSION['id_language'] > 0) { 
							echo $row_rsLicencia['licencia_'.$_SESSION['language'].'']; 
						} else {
							echo $row_rsLicencia['licencia']; 
						} 
				  ?>
            </option>
            <?php }  ?>
          </select>
      </div> 
	<br /></td>
    <td width="50%" valign="top">
    <label><strong><?php echo $translate['dirigido']; ?></strong></label>
    <div class="suboption" id="so1">
     <?php while ($row_dirigido_avanzado=mysql_fetch_array($dirigido_avanzado)) {  
	 		echo '<input type="checkbox" name="dirigido" id="dirigido" value="'.$row_dirigido_avanzado['id_dirigido_material'].'"/><label>';
			
				if ($_SESSION['id_language'] > 0) { 
					echo $row_dirigido_avanzado['dirigido_material_'.$_SESSION['language'].''];
				} else {
					echo $row_dirigido_avanzado['dirigido_material'];
				}
				
			echo '</label><br/>';
	 } ?>
    </div>
    <label><strong><?php echo $translate['nivel']; ?></strong></label>
    <div class="suboption" id="so1">
     <?php while ($row_nivel_avanzado=mysql_fetch_array($nivel_avanzado)) {  
	 		echo '<input type="checkbox" name="nivel" id="nivel" value="'.$row_nivel_avanzado['id_nivel_material'].'"/><label>';
			
				if ($_SESSION['id_language'] > 0) { 
					echo $row_nivel_avanzado['nivel_material_'.$_SESSION['language'].''];
				} else {
					echo $row_nivel_avanzado['nivel_material'];
				}
				
			echo '</label><br/>';
	 } ?>
    </div>
    <label></label><div class="suboption" id="so1"></div>    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top"><input type="button" name="button2" id="button2" value="<?php echo $translate['buscar']; ?>" onclick="recogercheckbox();" style="font-size:18px"; /></td>
    </tr>
</table>
<br  /><a href="javascript:void(0);" onclick="ChequearTodos(true,'search_materiales');"><?php echo $translate['seleccionar_todos']; ?></a> | <a href="javascript:void(0);" onclick="ChequearTodos(false,'search_materiales');"><?php echo $translate['limpiar_todos']; ?></a></div>
</div></td>
  </tr>
</table>
</div>

<div id="materiales" style="float:left; width:52%;">
<?php if (isset($_POST['i']) && $_POST['i'] > 0) {  

	$row=$query->ficha_material($_POST['i']);
?>
<br  />
<div class="material" style="padding:10px; border:1px solid #CCCCCC; margin-bottom:15px;">
<h3><?php echo utf8_encode($row['material_titulo']); ?></h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="49%" height="110" valign="top"><p><strong><?php echo $translate['descripcion']; ?>:</strong> <br />
        <?php echo utf8_encode($row['material_descripcion']); ?><br />
      <br />
        <strong><?php echo $translate['licencia']; ?>:</strong> <br />
        <?php if ($row['logo_licencia'] != '') { echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'" border="0" /></a>';  } else {  echo utf8_encode($row['licencia']); } ?>
    </p>
      <p><strong><?php echo $translate['idiomas']; ?>:</strong>
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
		?>
</p></td>
    <td width="51%" valign="top"><strong>Autor/es:</strong> <br />
      <?php 
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
		?>
      <br />
      <strong>
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
      </strong><strong><?php echo $translate['archivo_s']; ?>:</strong> <br />
      <br />
      <?php 
	    $ma=str_replace('}{',',',$row['material_archivos']);
		  $ma=str_replace('{','',$ma);
		  $ma=str_replace('}','',$ma);
		  $ma=explode(',',$ma);
		  
		  for ($i=0;$i<count($ma);$i++) { 
			if ($ma[$i]!='') {
			 echo '<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank"><img src=\'images/download1.png\' border="0" alt="'.$translate['descargar_material'].'" title="'.$translate['descargar_material'].'"><a/>&nbsp;&nbsp;<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank">'.$ma[$i].'<a/><br /><br />'; 
			}
		  }
		  
	  ?><br />      </td>
  </tr>
</table>
<br />
<b><a  href="javascript:void();" onClick="Effect.BlindDown('material_<?php echo $row['id_material'] ?>');; return false;" ><img src="images/u.gif" alt="<?php echo $translate['datos_clasificacion']; ?>" title="<?php echo $translate['datos_clasificacion']; ?>" name="imagen15" width="9" height="9" border="0" >&nbsp;<?php echo $translate['datos_clasificacion']; ?></a></b>

 <div id="material_<?php echo $row['id_material'] ?>" style="display:none;"> 
 <div style="text-align:right;"><a href="javascript:void(0);" onclick="Effect.BlindUp('material_<?php echo $row['id_material'] ?>');; return false;">
        <img src="images/close.gif" alt="<?php echo $translate['cerrar_datos_clasificacion']; ?>" title="<?php echo $translate['cerrar_datos_clasificacion']; ?>" border="0"/></a></div>
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
					echo  $data_nivel['nivel_material_'.$_SESSION['language'].''].'<br />'; 
				} else {
					 echo  $data_nivel['nivel_material'].'<br />'; 
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
					 echo  $data_dirigido['dirigido_material_'.$_SESSION['language'].''].'<br />'; 
				} else {
					 echo  $data_dirigido['dirigido_material'].'<br />'; 
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
							echo '</blockquote>';  
						}
					}
			   }
	
			}
		  }
		?></td>
    </tr>
</table>
 </div>
 <br /><br />
<div class="informacion"><a href="?id_material=<?php echo $row['id_material']; ?>"><img src="images/world_link.png" alt="<?php echo $translate['enlace_permanente']; ?>" width="16" height="16" border="0" title="<?php echo $translate['enlace_permanente']; ?>" /></a>&nbsp;<a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/descargar_material_zip.php?id_material=<?php echo $row['id_material']; ?>', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:300, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});"><img src="images/compress.png" alt="<?php echo $translate['descargar_materiales_zip']; ?>" border="0" title="<?php echo $translate['descargar_materiales_zip']; ?>" /></a>&nbsp;<?php echo $translate['actualizado_dia']; ?>&nbsp;<?php echo $row['fecha_alta']; ?>
  <?php 	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { ?>
			  <a href="inc/gestion_materiales/gestionar_material.php?id=<?php echo $row['id_material']; ?>&i=<?php echo rand(1000000,9999999); ?>" onclick="return GB_showCenter('<?php echo $translate['editar_material']; ?>', this.href, 550, 780)"><img src="images/page_edit.png" alt="<?php echo $translate['editar_material']; ?>" title="<?php echo $translate['editar_material']; ?>" border="0" /></a>
			<?php 
				if ($row['material_estado']==0) { echo '<img src="images/no_visible.gif" alt="Material no visible" title="Material no visible"border="0">';  }
				elseif ($row['material_estado']==1) { echo '<img src="images/visible.gif" alt="Material visible" title="Material visible" border="0">'; }
				elseif ($row['material_estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="Material pendiente de revisión" title="Material pendiente de revisión" border="0">'; 	}
			
			
} ?>
  </div>  
</div>

<?php } else {  echo '<h4>'.$translate['ultimos_materiales_catalogo'].'</h4><br />';  
	
	if ($total_records > 0 ) {

	while ($row=mysql_fetch_array($resultados)) {  

	$i++;
	
	if ($pg == 0 && $i==1) { ?>
		
     <div class="material" style="padding:8px; border:1px solid #CCCCCC; margin-bottom:10px;">
     <div style="float:right;"><img src="images/novedad.gif" border="0" alt="<?php echo $translate['novedad']; ?>" title="<?php echo $translate['novedad']; ?>" /></div>
<h3><?php echo utf8_encode($row['material_titulo']); ?></h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="49%" height="110" valign="top"><p><strong><?php echo $translate['descripcion']; ?>:</strong> <br />
        <?php echo utf8_encode($row['material_descripcion']); ?><br />
        <br />
        <strong><?php echo $translate['licencia']; ?>:</strong> <br />
        <?php if ($row['logo_licencia'] != '') { echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'" border="0" /></a>';  } else {  echo utf8_encode($row['licencia']); } ?>
    </p>
      <p><strong><?php echo $translate['idiomas']; ?>:</strong>
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
		?>
</p>
      </td>
    <td width="51%" valign="top"><strong><?php echo $translate['autor_es']; ?>:</strong> <br />
      <?php 
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
		?>
      <br />
      <strong>
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
      <?php echo $translate['archivo_s']; ?>:</strong> <br />
      <br />
      <?php 
	    $ma=str_replace('}{',',',$row['material_archivos']);
		  $ma=str_replace('{','',$ma);
		  $ma=str_replace('}','',$ma);
		  $ma=explode(',',$ma);
		  
		  for ($i=0;$i<count($ma);$i++) { 
			if ($ma[$i]!='') {
			 echo '<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank"><img src=\'images/download1.png\' border="0" alt="'.$translate['descargar_material'].'" title="'.$translate['descargar_material'].'"><a/>&nbsp;&nbsp;<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank">'.$ma[$i].'<a/><br /><br />'; 
			}
		  }
		  
	  ?><br />      </td>
  </tr>
</table>
<br />
<b><a  href="javascript:void();" onClick="Effect.BlindDown('material_<?php echo $row['id_material'] ?>');; return false;" ><img src="images/u.gif" alt="<?php echo $translate['desplegar_opciones_clasificacion']; ?>" title="<?php echo $translate['desplegar_opciones_clasificacion']; ?>" name="imagen15" width="9" height="9" border="0" >&nbsp;<?php echo $translate['datos_clasificacion']; ?></a></b>

 <div id="material_<?php echo $row['id_material'] ?>" style="display:none;"> 
 <div style="text-align:right;"><a href="javascript:void(0);" onclick="Effect.BlindUp('material_<?php echo $row['id_material'] ?>');; return false;">
        <img src="images/close.gif" alt="<?php echo $translate['cerrar_datos_clasificacion']; ?>" title="<?php echo $translate['cerrar_datos_clasificacion']; ?>" border="0"/></a></div>
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
			 		echo $data_saa['saa_material_'.$_SESSION['language'].''].'<br />'; 
				} else {
					echo $data_saa['saa_material'].'<br />'; 
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
    <td valign="top" bgcolor="#FFFFCC">
	   <?php 
	   $mac=str_replace('}{',',',$row['material_area_curricular']);
		  $mac=str_replace('{','',$mac);
		  $mac=str_replace('}','',$mac);
		  $mac=explode(',',$mac);
		  
		  for ($i=0;$i<count($mac);$i++) { 
			if ($mac[$i]!='') {
			 $data_ac=$query->datos_material_ac($mac[$i]);
			 
			 	if ($_SESSION['id_language'] > 0) {
					echo $data_ac['ac_material_'.$_SESSION['language'].''].'<br />';
				} else {
			   		echo $data_ac['ac_material'].'<br />'; 
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
							echo '</blockquote>';  
						}
					}
			   }
	
			}
		  }
		?></td>
    </tr>
</table>
 </div>
 <br /><br />
<div class="informacion"><a href="?id_material=<?php echo $row['id_material']; ?>"><img src="images/world_link.png" alt="<?php echo $translate['enlace_permanente']; ?>" width="16" height="16" border="0" title="<?php echo $translate['enlace_permanente']; ?>"  /></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/descargar_material_zip.php?id_material=<?php echo $row['id_material']; ?>', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:300, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: '<?php echo $translate['cerrar']; ?>'});"><img src="images/compress.png" alt="<?php echo $translate['descargar_materiales_zip']; ?>" border="0" title="<?php echo $translate['descargar_materiales_zip']; ?>" /></a><?php echo $translate['actualizado_dia']; ?>&nbsp;<?php echo $row['fecha_alta']; ?>
  <?php 	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) {   ?>
			  <a href="inc/gestion_materiales/gestionar_material.php?id=<?php echo $row['id_material']; ?>&i=<?php echo rand(1000000,9999999); ?>" onclick="return GB_showCenter('<?php echo $translate['editar_material']; ?>', this.href, 550, 780)"><img src="images/page_edit.png" alt="<?php echo $translate['editar_material']; ?>" title="<?php echo $translate['editar_material']; ?>" border="0" /></a>
			<?php 
				if ($row['material_estado']==0) { echo '<img src="images/no_visible.gif" alt="Material no visible" title="Material no visible"border="0">';  }
				elseif ($row['material_estado']==1) { echo '<img src="images/visible.gif" alt="Material visible" title="Material visible" border="0">'; }
				elseif ($row['material_estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="Material pendiente de revisión" title="Material pendiente de revisión" border="0">'; 	}
			
			
} ?>
  </div>
     </div>   
     
<?php } else {
$date_sin_hora=split(" ",$row['fecha_alta']);
$date=split("-",$date_sin_hora[0]);
$fecha_publicacion=$date[2].'-'.$date[1].'-'.$date[0];
$publicado_hace=intval(compara_fechas($hoy,$fecha_publicacion)/86400);
?>
<div class="material" style="padding:10px; border:1px solid #CCCCCC; margin-bottom:15px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <?php if ($publicado_hace <= $hace_dias) { echo '<td width="1%" valign="top"><img src="images/b_novedad_.gif" border="0" alt="'.$translate['material_publicado_hace'].' '.$publicado_hace.' '.$translate['dia_s'].'" title="'.$translate['material_publicado_hace'].' '.$publicado_hace.' '.$translate['dia_s'].'" />&nbsp;</td>'; } 
	  else { echo '<td width="1%" valign="top">&nbsp;</td>'; } ?>
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
      <td width="14%" valign="top"><?php echo $row['fecha_alta']; ?></td>
      <td width="15%" align="right" valign="top"><a href="?id_material=<?php echo $row['id_material']; ?>"><img src="images/world_link.png" alt="<?php echo $translate['enlace_permanente']; ?>" width="16" height="16" border="0" title="<?php echo $translate['enlace_permanente']; ?>" /></a> <a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/descargar_material_zip.php?id_material=<?php echo $row['id_material']; ?>', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:300, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});"><img src="images/compress.png" alt="<?php echo $translate['descargar_materiales_zip']; ?>" border="0" title="<?php echo $translate['descargar_materiales_zip']; ?>" /></a>
          <?php 	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { echo '<a href="inc/gestion_materiales/gestionar_material.php?id='.$row['id_material'].'&i='.rand(1000000,9999999).'" onclick="return GB_showCenter(\'Editar Material\', this.href, 550, 780)"><img src="images/page_edit.png" alt="Editar Material" title="Editar Material" border="0" /></a>&nbsp;';
	  
				if ($row['material_estado']==0) { echo '<img src="images/no_visible.gif" alt="Material no visible" title="Material no visible"border="0">';  }
				elseif ($row['material_estado']==1) { echo '<img src="images/visible.gif" alt="Material visible" title="Material visible" border="0">'; }
				elseif ($row['material_estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="Material pendiente de revisi&oacute;n" title="Material pendiente de revisi&oacute;n" border="0">'; 	}
			
			
} 
if ($row['logo_licencia'] != '') { echo '&nbsp;<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'" border="0" /></a>';  } else {  echo utf8_encode($row['licencia']); } ?>      </td>
    </tr>
    <tr>
      <td colspan="5" valign="top">
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
		  
	  ?>
      </td>
    </tr>
    <tr>
      <td height="19" colspan="4">&nbsp;</td>
      <td width="5%" align="right" valign="bottom"><a  href="javascript:void();" onclick="Effect.BlindDown('material_<?php echo $row['id_material'] ?>');; return false;" >(+&nbsp;<?php echo $translate['informacion']; ?>)</a></td>
    </tr>
  </table>
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
					echo  $data_nivel['nivel_material_'.$_SESSION['language'].''].'<br />';
				} else {
					echo  $data_nivel['nivel_material'].'<br />';
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
					echo $data_ac['ac_material_'.$_SESSION['language'].''].'<br />';
				} else {
			  		echo $data_ac['ac_material'].'<br />';
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
<?php } } } // Cierro el While y el IF ?>
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
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/materiales.php','pg=0','principal');\"><< </a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"><<</span>';
        
        }
        
        // Pagina anterior
        if($pg > 0) { 
        
        $prev = ($pg - 1);
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/materiales.php','pg=".$prev."','principal');\"> <</a>&nbsp;";
        
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
                    
                    $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/materiales.php','pg=".$i."','principal');\">".$i."</a>&nbsp;";
                    }
                }
            
            } // Cierro el FOR
        
        } else {
        
            for($i = 0; $i <= $total_pages; $i++) {
            
                if(($pg) == $i) {
                
                $content.= '<span class="current">'.$i.'</span>&nbsp;';
                
                } else {
                
                $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/materiales.php','pg=".$i."','principal');\">".$i."</a>&nbsp;";
            
            } // Cierro el FOR
            
        } // Cierro el IF
        
        }
        
        // Siguiente página
        if($pg < $total_pages) {
        
        $next = ($pg + 1);
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/materiales.php','pg=".$next."','principal');\"> ></a>&nbsp;";
        
        } else {
        
        $content.= '<span class="disabled"> ></span>';
        
        }
        
        // Ultima página
        if($pg < $total_pages)
        {
        
        $last = $total_pages;
        $content.= "<a href=\"javascript:void();\" onclick=\"cargar_div('inc/public/materiales.php','pg=".$last."','principal');\">  >></a>&nbsp;";
        
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
<?php } // Cierro el IF de comprobacion de si esta establecido $_POST['i'] ?>
</div>
</form>

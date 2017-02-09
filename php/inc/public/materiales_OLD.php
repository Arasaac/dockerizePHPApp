<?php 
session_start();  // INICIO LA SESION
header('Content-Type: text/html; charset=UTF-8');
include ('../../classes/querys/query.php');
require ("../../classes/date/date_operations.php");
require ('../../classes/date/Date.class.php'); 
require ('../../funciones/funciones.php'); 

$query=new query();

$hoy=date("d-m-Y");
$hace_dias=5; //Valor en días para mostrar la imagen de Novedad

$cantidad= 10;

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
	
	$edicion="<a href=\"js/lightloader/upload_materiales.php?i=<?php echo rand(1000000,9999999); ?>\" onclick=\"return GB_showCenter('Subir materiales a la carpeta temporal', this.href, 550, 780)\"><img src=\"images/page_white_get.png\" alt=\"Subir materiales a la carpeta temporal\" border=\"0\" /></a> &nbsp;<a href=\"inc/gestion_materiales/gestionar_material.php?i=<?php echo rand(1000000,9999999); ?>\" onclick=\"return GB_showCenter('Añadir nuevo material', this.href, 550, 780)\"><img src=\"images/page_white_add.png\" alt=\"Añadir Material\" border=\"0\" /></a>";
	
}

	$total_records = mysql_num_rows($contar);
	$total_pages = intval($total_records / $cantidad);
	
$licencias=$query->listar_licencias();
$autores=$query->listar_autores();
$ac=$query->listar_areas_curriculares();
$dirigido=$query->listar_dirigido();
$edad=$query->listar_edad();
$nivel=$query->listar_nivel();
$saa=$query->listar_saa();
$tm=$query->listar_tipo_material();

?>
<h4><a href="rss/materiales.xml" target="_blank"><img src="images/feed.png" alt="Canal Materiales" width="16" height="16" border="0" /></a>&nbsp; Materiales <?php echo $edicion; ?> 
</h4>
  En esta secci&oacute;n pod&eacute;is encontrar una serie de materiales creados a partir de los pictogramas e im&aacute;genes de este cat&aacute;logo y que se distribuyen, en su mayor parte, bajo licencia Creative Commons. Adem&aacute;s del listado con todos los materiales publicados hasta el momento, pod&eacute;is utilizar el buscador simple y avanzado del que dispon&eacute;is a la derecha de este texto. Para utilizar el buscador simple basta con escribir el texto que deseamos filtrar y pulsar en el bot&oacute;n &quot;Buscar&quot;. El texto que introduzcamos ser&aacute; buscado en el t&iacute;tulo y la descripci&oacute;n del material. Si deseamos realizar una b&uacute;squeda avanzado por los criterios de clasificaci&oacute;n establecidos, pulsaremos en primer lugar en &quot;Avanzada&quot;, posteriormente seleccionaremos los criterios deseados para filtrar y, opcionalmente, podemos escribir tambi&eacute;n texto (en el mismo cuadro de antes). Por ultimo volveremos a pulsar en &quot;Buscar&quot;.<br />
<br />
  <div align="right">
  <input name="textfield" type="text" id="textfield" size="40"/>
  <input type="button" name="button" id="button" value="Buscar" onclick="recogercheckbox();" />
  <input id="hiddenStatusMenu" type="hidden" value="0" />
  <a href="javascript:void(0);" onclick="javascript:showMenu()">Avanzada</a>
  <br  />
  </div>
<form id="search_materiales" name="search_materiales" action="javascript:void(0);">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="99%" valign="top">

<div id="materiales">
<?php if (isset($_POST['i']) && $_POST['i'] > 0) {  

		$row=$query->ficha_material($_POST['i']);
?>
<br  />
<div class="material" style="padding:10px; border:1px solid #CCCCCC; margin-bottom:15px;">
<h3><?php echo utf8_encode($row['material_titulo']); ?></h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="49%" height="110" valign="top"><strong>Descripcion:</strong> <br />
      <?php echo utf8_encode($row['material_descripcion']); ?><br /><br />
      <strong>Objetivos:</strong> <br />
      <?php echo utf8_encode($row['material_objetivos']); ?><br /><br />
      <strong>Licencia:</strong> <br />
      <?php if ($row['logo_licencia'] != '') { echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'" border="0" /></a>';  } else {  echo utf8_encode($row['licencia']); } ?></td>
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
      <strong>Archivo/s:</strong> <br /><br />
      <?php 
	    $ma=str_replace('}{',',',$row['material_archivos']);
		  $ma=str_replace('{','',$ma);
		  $ma=str_replace('}','',$ma);
		  $ma=explode(',',$ma);
		  
		  for ($i=0;$i<count($ma);$i++) { 
			if ($ma[$i]!='') {
			 echo '<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank"><img src=\'images/download1.png\' border="0" alt="Descargar material" title="Descargar material"><a/>&nbsp;&nbsp;<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank">'.$ma[$i].'<a/><br /><br />'; 
			}
		  }
		  
	  ?><br />
      </td>
  </tr>
</table>
<br />
<b><a  href="javascript:void();" onClick="Effect.BlindDown('material_<?php echo $row['id_material'] ?>');; return false;" ><img src="images/u.gif" alt="Desplegar opciones de clasificacion" name="imagen15" width="9" height="9" border="0" >&nbsp;Datos de Clasificaci&oacute;n</a></b>

 <div id="material_<?php echo $row['id_material'] ?>" style="display:none;"> 
 <div style="text-align:right;"><a href="javascript:void(0);" onclick="Effect.BlindUp('material_<?php echo $row['id_material'] ?>');; return false;">
        <img src="images/close.gif" alt="Cerrar datos de clasificaci&oacute;n" title="Cerrar datos de clasificaci&oacute;n" border="0"/></a></div>
 <table width="100%%" border="0" cellpadding="4" cellspacing="4">
  <tr>
    <td valign="top" bgcolor="#D8FE9E"><strong>Tipo:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>SAAC:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>Nivel:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>Edad:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>Dirigido:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>&Aacute;rea curricular:</strong></td>
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
			 echo utf8_encode($data_tipo['tipo_material']).'<br />'; 
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
			 echo  utf8_encode($data_saa['saa_material']).'<br />'; 
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
			 echo  utf8_encode($data_nivel['nivel_material']).'<br />'; 
			}
		  }
	  ?></td>
    <td valign="top" bgcolor="#FFFFCC"><?php 
	 	 $me=str_replace('}{',',', $row['material_edad']);
		  $me=str_replace('{','',$me);
		  $me=str_replace('}','',$me);
		  $me=explode(',',$me);
		  
		  for ($i=0;$i<count($me);$i++) { 
			if ($me[$i]!='') {
			 $data_edad=$query->datos_material_edad($me[$i]);
			 echo  utf8_encode($data_edad['edad_material']).'<br />'; 
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
			 echo  utf8_encode($data_dirigido['dirigido_material']).'<br />'; 
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
			 echo  utf8_encode($data_ac['ac_material']).'<br />'; 
			}
		  }
		?></td>
    </tr>
</table>

 </div>
 <br /><br />
<div class="informacion"><a href="?id_material=<?php echo $row['id_material']; ?>"><img src="images/world_link.png" alt="Enlace permanente"width="16" height="16" border="0" title="Enlace permanente" /></a>&nbsp;&nbsp; Actualizado el d&iacute;a &nbsp;<?php echo $row['fecha_alta']; ?>
  <?php 	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { ?>
			  <a href="inc/gestion_materiales/gestionar_material.php?id=<?php echo $row['id_material']; ?>&i=<?php echo rand(1000000,9999999); ?>" onclick="return GB_showCenter('Editar Material', this.href, 550, 780)"><img src="images/page_edit.png" alt="Editar Material" title="Editar Material" border="0" /></a>
			<?php 
				if ($row['material_estado']==0) { echo '<img src="images/no_visible.gif" alt="Material no visible" title="Material no visible"border="0">';  }
				elseif ($row['material_estado']==1) { echo '<img src="images/visible.gif" alt="Material visible" title="Material visible" border="0">'; }
				elseif ($row['material_estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="Material pendiente de revisión" title="Material pendiente de revisión" border="0">'; 	}
			
			
} ?>
  </div>  
</div>

<?php } else {  echo '<h4>Ultimos materiales a&ntilde;adidos al cat&aacute;logo</h4><br />';  
	
	if ($total_records > 0 ) {

	while ($row=mysql_fetch_array($resultados)) {  

	$i++;
	
	if ($pg == 0 && $i==1) { ?>
		
     <div class="material" style="padding:8px; border:1px solid #CCCCCC; margin-bottom:10px;">
     <div style="float:right;"><img src="images/novedad.gif" border="0" alt="Novedad" title="Novedad" /></div>
<h3><?php echo utf8_encode($row['material_titulo']); ?></h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="49%" height="110" valign="top"><strong>Descripcion:</strong> <br />
      <?php echo utf8_encode($row['material_descripcion']); ?><br /><br />
      <strong>Objetivos:</strong> <br />
      <?php echo utf8_encode($row['material_objetivos']); ?><br /><br />
      <strong>Licencia:</strong> <br />
      <?php if ($row['logo_licencia'] != '') { echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'" border="0" /></a>';  } else {  echo utf8_encode($row['licencia']); } ?></td>
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
      <strong>Archivo/s:</strong> <br /><br />
      <?php 
	    $ma=str_replace('}{',',',$row['material_archivos']);
		  $ma=str_replace('{','',$ma);
		  $ma=str_replace('}','',$ma);
		  $ma=explode(',',$ma);
		  
		  for ($i=0;$i<count($ma);$i++) { 
			if ($ma[$i]!='') {
			 echo '<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank"><img src=\'images/download1.png\' border="0" alt="Descargar material" title="Descargar material"><a/>&nbsp;&nbsp;<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank">'.$ma[$i].'<a/><br /><br />'; 
			}
		  }
		  
	  ?><br />
      </td>
  </tr>
</table>
<br />
<b><a  href="javascript:void();" onClick="Effect.BlindDown('material_<?php echo $row['id_material'] ?>');; return false;" ><img src="images/u.gif" alt="Desplegar opciones de clasificacion" name="imagen15" width="9" height="9" border="0" >&nbsp;Datos de Clasificaci&oacute;n</a></b>

 <div id="material_<?php echo $row['id_material'] ?>" style="display:none;"> 
 <div style="text-align:right;"><a href="javascript:void(0);" onclick="Effect.BlindUp('material_<?php echo $row['id_material'] ?>');; return false;">
        <img src="images/close.gif" alt="Cerrar datos de clasificaci&oacute;n" title="Cerrar datos de clasificaci&oacute;n" border="0"/></a></div>
 <table width="100%%" border="0" cellpadding="4" cellspacing="4">
  <tr>
    <td valign="top" bgcolor="#D8FE9E"><strong>Tipo:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>SAAC:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>Nivel:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>Edad:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>Dirigido:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>&Aacute;rea curricular:</strong></td>
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
			 echo utf8_encode($data_tipo['tipo_material']).'<br />'; 
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
			 echo  utf8_encode($data_saa['saa_material']).'<br />'; 
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
			 echo  utf8_encode($data_nivel['nivel_material']).'<br />'; 
			}
		  }
	  ?></td>
    <td valign="top" bgcolor="#FFFFCC"><?php 
	 	 $me=str_replace('}{',',', $row['material_edad']);
		  $me=str_replace('{','',$me);
		  $me=str_replace('}','',$me);
		  $me=explode(',',$me);
		  
		  for ($i=0;$i<count($me);$i++) { 
			if ($me[$i]!='') {
			 $data_edad=$query->datos_material_edad($me[$i]);
			 echo  utf8_encode($data_edad['edad_material']).'<br />'; 
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
			 echo  utf8_encode($data_dirigido['dirigido_material']).'<br />'; 
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
			 echo  utf8_encode($data_ac['ac_material']).'<br />'; 
			}
		  }
		?></td>
    </tr>
</table>

 </div>
 <br /><br />
<div class="informacion"><a href="?id_material=<?php echo $row['id_material']; ?>"><img src="images/world_link.png" alt="Enlace permanente"width="16" height="16" border="0" title="Enlace permanente" /></a>&nbsp;&nbsp; Actualizado el d&iacute;a &nbsp;<?php echo $row['fecha_alta']; ?>
  <?php 	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { ?>
			  <a href="inc/gestion_materiales/gestionar_material.php?id=<?php echo $row['id_material']; ?>&i=<?php echo rand(1000000,9999999); ?>" onclick="return GB_showCenter('Editar Material', this.href, 550, 780)"><img src="images/page_edit.png" alt="Editar Material" title="Editar Material" border="0" /></a>
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
    <td width="35%"><?php if ($publicado_hace <= $hace_dias) { echo '<img src="images/b_novedad_.gif" border="0" alt="Material publicado hace '.$publicado_hace.' d&iacute;a/s" title="Material publicado hace '.$publicado_hace.' d&iacute;a/s" />'; } ?><b><?php echo utf8_encode($row['material_titulo']); ?></b>&nbsp;</td>
    <td width="30%"><?php 
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
    <td width="20%"><?php echo $row['fecha_alta']; ?></td>
    <td width="15%" align="right"><b><a href="?id_material=<?php echo $row['id_material']; ?>"><img src="images/world_link.png" alt="Enlace permanente" width="16" height="16" border="0" title="Enlace permanente" /></a><a  href="javascript:void();" onclick="Effect.BlindDown('material_<?php echo $row['id_material'] ?>');; return false;" >
      <?php 	if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { ?>
      <a href="inc/gestion_materiales/gestionar_material.php?id=<?php echo $row['id_material']; ?>&i=<?php echo rand(1000000,9999999); ?>" onclick="return GB_showCenter('Editar Material', this.href, 550, 780)"><img src="images/page_edit.png" alt="Editar Material" title="Editar Material" border="0" /></a>
      <?php 
				if ($row['material_estado']==0) { echo '<img src="images/no_visible.gif" alt="Material no visible" title="Material no visible"border="0">';  }
				elseif ($row['material_estado']==1) { echo '<img src="images/visible.gif" alt="Material visible" title="Material visible" border="0">'; }
				elseif ($row['material_estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="Material pendiente de revisi&oacute;n" title="Material pendiente de revisi&oacute;n" border="0">'; 	}
			
			
} ?>
</b><?php if ($row['logo_licencia'] != '') { echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'" border="0" /></a>';  } else {  echo utf8_encode($row['licencia']); } ?></td>
  </tr>
  <tr>
    <td colspan="3"><br />
		<?php 
	    $ma=str_replace('}{',',',$row['material_archivos']);
		  $ma=str_replace('{','',$ma);
		  $ma=str_replace('}','',$ma);
		  $ma=explode(',',$ma);
		  
		  for ($i=0;$i<count($ma);$i++) { 
			if ($ma[$i]!='') {
			 echo '<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank"><img src=\'images/download1.png\' border="0" alt="Descargar material" title="Descargar material"><a/>&nbsp;&nbsp;<a href="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" target="_blank">'.$ma[$i].'<a/>&nbsp;&nbsp;'; 
			}
		  }
		  
	  ?></td>
    <td align="right"><a  href="javascript:void();" onclick="Effect.BlindDown('material_<?php echo $row['id_material'] ?>');; return false;" >(+&nbsp;Informaci&oacute;n)</a></td>
  </tr>
</table>
 <div id="material_<?php echo $row['id_material'] ?>" style="display:none;"> 
 <hr style="border: 1px solid #CCCCCC;" />
 <div style="text-align:right;"><a href="javascript:void(0);" onclick="Effect.BlindUp('material_<?php echo $row['id_material'] ?>');; return false;">
        <img src="images/close.gif" alt="Cerrar datos de clasificaci&oacute;n" title="Cerrar datos de clasificaci&oacute;n" border="0"/>&nbsp;CERRAR</a></div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="49%" height="110" valign="top"><strong>Descripcion:</strong> <br />
      <?php echo utf8_encode($row['material_descripcion']); ?><br /><br />
      <strong>Objetivos:</strong> <br />
      <?php echo utf8_encode($row['material_objetivos']); ?><br /><br />
      </td>
    </tr>
</table>
  <br /><strong>Datos de Clasificaci&oacute;n </strong><br />
 <table width="100%%" border="0" cellpadding="4" cellspacing="4">
  <tr>
    <td valign="top" bgcolor="#D8FE9E"><strong>Tipo:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>SAAC:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>Nivel:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>Edad:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>Dirigido:</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>&Aacute;rea curricular:</strong></td>
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
			 echo utf8_encode($data_tipo['tipo_material']).'<br />'; 
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
			 echo  utf8_encode($data_saa['saa_material']).'<br />'; 
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
			 echo  utf8_encode($data_nivel['nivel_material']).'<br />'; 
			}
		  }
	  ?></td>
    <td valign="top" bgcolor="#FFFFCC"><?php 
	 	 $me=str_replace('}{',',', $row['material_edad']);
		  $me=str_replace('{','',$me);
		  $me=str_replace('}','',$me);
		  $me=explode(',',$me);
		  
		  for ($i=0;$i<count($me);$i++) { 
			if ($me[$i]!='') {
			 $data_edad=$query->datos_material_edad($me[$i]);
			 echo  utf8_encode($data_edad['edad_material']).'<br />'; 
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
			 echo  utf8_encode($data_dirigido['dirigido_material']).'<br />'; 
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
			 echo  utf8_encode($data_ac['ac_material']).'<br />'; 
			}
		  }
		?></td>
    </tr>
</table>

 </div>
</div>
<?php } } } // Cierro el While y el IF ?>
<div align="center" class="textos"><strong>Material: </strong><?php echo $inicial ?> a <?php echo $inicial+$cantidad ?> de <?php echo $total_records ?></div> 
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
      Los materiales contenidos en este cat&aacute;logo se distribuyen bajo <a href="http://creativecommons.org/licenses/by-nc/2.5/es/" target="_blank" rel="license">licencia de Creative Commons</a><br>
      <a href="http://creativecommons.org/licenses/by-nc/2.5/es/" target="_blank" rel="license">
        <img alt="Creative Commons License" style="border-width:0" src="images/88x31.png" />
        </a>
      <br />
      </p>
  </div>
<?php } // Cierro el IF de comprobacion de si esta establecido $_POST['i'] ?>
</div>
<br /><br />
</td>
    <td width="1%" valign="top">
<div id="busqueda_materiales">
<br /><br />
<div class="searchoption" id="searchmenu" style="display:none; width: 350px; margin-left:15px; margin-bottom:25px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" valign="top">
<label><strong>Licencia: </strong></label>
          <select name="licencia" id="licencia" required="1" realname="Categoría" disabled="disabled">
           <?php while ($row_rsLicencia=mysql_fetch_array($licencias)) {  ?>
            <option value="<?php echo $row_rsLicencia['id_licencia']?>" <?php if ($row_rsLicencia['id_licencia']=='2') { echo 'selected'; } ?>><?php echo utf8_encode($row_rsLicencia['licencia']); ?></option>
            <?php }  ?>
          </select>
<br /><br />
<label><strong>Area Curricular</strong></label>
    <div class="suboption" id="so1">
     <?php while ($row_ac=mysql_fetch_array($ac)) {  
	 		echo '<input type="checkbox" name="area_curricular" id="area_curricular" value="'.$row_ac['id_ac_material'].'"/><label>'.utf8_encode($row_ac['ac_material']).'</label><br/>';
	 } ?>
    </div>
<label><strong>Edad</strong></label>
	<div class="suboption" id="so1">
		<?php while ($row_edad=mysql_fetch_array($edad)) {  

			echo '<input type="checkbox" name="edad" id="edad" value="'.$row_edad['id_edad_material'].'"/><label>'.utf8_encode($row_edad['edad_material']).'</label><br/>';
	
		 } ?>
    </div>  
<label><strong>Tipo</strong></label>
	<div class="suboption" id="so1">
		<?php while ($row_tm=mysql_fetch_array($tm)) {  

			echo '<input type="checkbox" name="tipo" id="tipo" value="'.$row_tm['id_tipo_material'].'"/><label>'.utf8_encode($row_tm['tipo_material']).'</label><br/>';
	
		 } ?>
    </div>       
</a></td>
    <td width="50%" valign="top">
    <label><strong>Dirigido</strong></label>
    <div class="suboption" id="so1">
     <?php while ($row_dirigido=mysql_fetch_array($dirigido)) {  
	 		echo '<input type="checkbox" name="dirigido" id="dirigido" value="'.$row_dirigido['id_dirigido_material'].'"/><label>'.utf8_encode($row_dirigido['dirigido_material']).'</label><br/>';
	 } ?>
    </div>
    <label><strong>Nivel</strong></label>
    <div class="suboption" id="so1">
     <?php while ($row_nivel=mysql_fetch_array($nivel)) {  
	 		echo '<input type="checkbox" name="nivel" id="nivel" value="'.$row_nivel['id_nivel_material'].'"/><label>'.utf8_encode($row_nivel['nivel_material']).'</label><br/>';
	 } ?>
    </div>
    <label><strong>SAA</strong></label>
    <div class="suboption" id="so1">
     <?php while ($row_saa=mysql_fetch_array($saa)) {  
	 		echo '<input type="checkbox" name="saa" id="saa" value="'.$row_saa['id_saa_material'].'"/><label>'.utf8_encode($row_saa['saa_material']).'</label><br/>';
	 } ?>
    </div>    </td>
  </tr>
</table>
<br  /><a href="javascript:void(0);" onclick="hideMenu()">Cerrar</a> | <a href="javascript:void(0);" onclick="ChequearTodos(true,'search_materiales');">Seleccionar todos</a> | <a href="javascript:void(0);" onclick="ChequearTodos(false,'search_materiales');">Limpiar todos</a></div>

</div></td>
  </tr>
</table>
</form>



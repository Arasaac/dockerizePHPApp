<?php 
require('languages/makeSecure.php');

$query=new query();
$datos_traductor=$query->datos_traductor($_SESSION['userName']);
$listado_paginas=$query->listado_paginas_internacionalizacion();
$traducir_desde=str_replace('{','',$datos_traductor['traducir_desde']);
$traducir_desde=str_replace('}','',$traducir_desde);
$translate=$query->get_internacionalizacion_page_content($traducir_desde,1);
$aux='';

if (isset($_POST['accion']) && $_POST['accion'] =='add') {

	$add_tabla=$_POST['tabla'];
	
	switch ($add_tabla) {
	
		case 'internacionalizacion':
		if ($_POST['key'] !='' && $_POST['id_pagina'] > 0 && $_POST['v1'] !='') {
			$add_key=$_POST['key'];
			$add_id_pagina=$_POST['id_pagina'];
			$add_valor=$_POST['v1'];
			$add_campo=$query->add_campo_internacionalizacion($add_key,$add_id_pagina,$add_valor);
			if ($add_campo > 0) { $mensaje='Campo insertado'; } elseif ($add_campo==false) { $mensaje='ERROR'; }
		} else { 
			$mensaje='Rellene todos los campos';
		}
		break;

	}
	
}


if (isset($_SESSION['idioma_a_traducir']) && $_SESSION['idioma_a_traducir'] !='') { 

	$idioma=$_SESSION['idioma_a_traducir'];
	
	$id=str_replace('}{',',',$datos_traductor['idiomas']);
	$id=str_replace('{','',$id);
	$id=str_replace('}','',$id);
	$id=explode(',',$id);
	
	if (count($id)>1) { 
		
		$seleccion_de_idiomas='<div style="float:left;"><b>Idioma a traducir:</b> ';
		
		for ($i=0;$i<count($id);$i++) { 
		
			$seleccion_de_idiomas.='<a href="languages/seleccionar_idioma.php?lang='.$id[$i].'">'.$id[$i].'</a> | ';
			
		}
		
		$seleccion_de_idiomas.='</div><br />';
			  
	}
	

} else { 
	$id=str_replace('}{',',',$datos_traductor['idiomas']);
	$id=str_replace('{','',$id);
	$id=str_replace('}','',$id);
	$id=explode(',',$id);
	
	if (count($id)==1) {
	
		$idioma=$id[0];
	
	} elseif (count($id)>1) { 
		
		$seleccion_de_idiomas='<div style="float:left;"><b>Idioma a traducir:</b> ';
		$idioma=$id[0];
		
		for ($i=0;$i<count($id);$i++) { 
		
			$seleccion_de_idiomas.='<a href="languages/seleccionar_idioma.php?lang='.$id[$i].'">'.$id[$i].'</a> | ';
			
		}
		
		$seleccion_de_idiomas.='</div><br />';
			  
	}
	
}
					
					
if (isset($_GET['tabla']) && $_GET['tabla'] !='') {
	$tabla=$_GET['tabla'];
} else {
	$tabla='internacionalizacion';
}

switch ($tabla) {

case 'internacionalizacion':
$listado=$query->datos_internacionalizacion();
break;

case 'definiciones':
if (!isset($_GET['pg'])) {
	$pg = 0; // $pg es la pagina actual
} else { $pg=$_GET['pg']; }

$cantidad=50;
$inicial = $pg * $cantidad;
						
$limite_inferior="10"; //resultados por debajo de la pagina actual
$page_limit = $limite_inferior;
						
$limitpages = $page_limit;
$page_limit = $pg + $limitpages;
$datos_idioma=$query->datos_idioma_por_abreviatura($idioma);
$contar=$query->listar_traducciones_por_idioma_con_info_es($datos_idioma['id_idioma']);
$listado=$query->listar_traducciones_por_idioma_con_info_es_limit($datos_idioma['id_idioma'],$inicial,$cantidad);
$total_records = mysql_num_rows($contar);
$total_pages = intval($total_records / $cantidad);
break;

case 'idiomas':
$listado=$query->listar_idiomas();
break;

case 'categorias_enlaces':
$listado=$query->listar_categorias_enlaces();
break;

case 'enlaces':
$listado=$query->listar_enlaces();
break;

case 'descripcion_enlaces':
$listado=$query->listar_enlaces();
break;

case 'temas':
$listado=$query->listado_temas();
break;

case 'subtemas':
$listado=$query->listado_subtemas_completo();
break;

case 'temas_tmp':
$listado=$query->listado_temas_tmp();
break;

case 'subtemas_tmp':
$listado=$query->listado_subtemas_completo_tmp();
break;

case 'noticias':
$listado=$query->listar_noticias();
break;

case 'material_area_curricular':
$listado=$query->listar_areas_curriculares();
break;

case 'material_dirigido':
$listado=$query->listar_dirigido();
break;

case 'material_edad':
$listado=$query->listar_edad();
break;

case 'material_nivel':
$listado=$query->listar_nivel();
break;

case 'material_saa':
$listado=$query->listar_saa();
break;

case 'material_subarea':
$listado=$query->listar_subareas();
break;

case 'material_tipo':
$listado=$query->listar_tipo_material();
break;

case 'ejemplos_uso':
$listado=$query-> listar_ejemplos_uso();
break;

case 'software_descripcion':
$tabla_a_listar='software_descripcion';
$order_by=' id_software asc';
$listado=$query->listar_tabla($tabla_a_listar,$order_by);
break;

case 'software_objetivo':
$tabla_a_listar='software_objetivo';
$order_by=' id_software asc';
$listado=$query->listar_tabla($tabla_a_listar,$order_by);
break;

case 'software_informacion_adicional':
$tabla_a_listar='software_informacion_adicional';
$order_by=' id_software asc';
$listado=$query->listar_tabla($tabla_a_listar,$order_by);
break;

case 'software_tipo':
$listado=$query->listar_tipo_software();
break;

case 'eu_titulo':
$tabla_a_listar='eu';
$order_by=' id_eu asc';
$listado=$query->listar_tabla($tabla_a_listar,$order_by);
break;

case 'eu_descripcion':
$tabla_a_listar='eu_descripcion';
$order_by=' id_eu asc';
$listado=$query->listar_tabla($tabla_a_listar,$order_by);
break;

case 'eu_tipo':
$listado=$query->listar_tipo_eu();
break;

default:
$listado=$query->datos_internacionalizacion();
break;
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Gestionar internacionalizacion ARASAAC</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <script src="js/InPlaceRichEditor_1.3.1/lib/prototype.js" type="text/javascript"></script>
    <script src="js/InPlaceRichEditor_1.3.1/lib/effects.js" type="text/javascript"></script>
    <script src="js/InPlaceRichEditor_1.3.1/lib/controls.js" type="text/javascript"></script>
    <script src="js/InPlaceRichEditor_1.3.1/lib/patch_inplaceeditor_1-8-2.js" type="text/javascript"></script>
    <script src="js/InPlaceRichEditor_1.3.1/lib/patch_inplaceeditor_editonblank_1-8-2.js" type="text/javascript"></script>
    <script src="js/InPlaceRichEditor_1.3.1/lib/tiny_mce/tiny_mce.js" type="text/javascript"></script>
    <script src="js/InPlaceRichEditor_1.3.1/lib/tiny_mce_init.js" type="text/javascript"></script>
    <script src="js/InPlaceRichEditor_1.3.1/src/inplacericheditor.js" type="text/javascript"></script>
    <script src="inc/herramientas/js/ajax_herramientas.js" type="text/javascript"></script>
    <style type="text/css" media="screen">
      .inplacericheditor-saving { background: url(wait.gif) bottom right no-repeat; }
      </style>
  </head>
<body>
<a name="seleccionar_tabla" id="seleccionar_tabla"></a> <?php echo $seleccion_de_idiomas; ?>
<div style="float:right"><a href="languages/logout.php"><?php echo $translate['desconectar']; ?></a></div>
<h3 style="text-transform:uppercase;"><?php echo $translate['idioma_seleccionado']; ?>: <?php echo $idioma; ?></h3>
<p><strong><?php echo $translate['tablas_a_traducir']; ?>:</strong> <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=internacionalizacion"><?php echo $translate['internacionalizacion']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=idiomas"><?php echo $translate['idiomas']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=categorias_enlaces"><?php echo $translate['categorias_enlaces']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=enlaces"><?php echo $translate['enlaces']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=descripcion_enlaces"><?php echo $translate['descripcion_enlaces']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=temas"><?php echo $translate['temas']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=subtemas"><?php echo $translate['subtemas']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=temas_tmp"><?php echo $translate['temas'].' TEMP'; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=subtemas_tmp"><?php echo $translate['subtemas'].' TEMP'; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=noticias"><?php echo $translate['noticias_mayuscula']; ?></a> <?php if ($idioma !='es') { ?>| <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=definiciones"><?php echo $translate['definiciones']; ?></a><?php } ?></p>
<p><strong><?php echo $translate['materiales']; ?></strong>:<a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=material_area_curricular"><?php echo $translate['area_curricular']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=material_subarea"><?php echo $translate['subareas']; ?></a>| <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=material_dirigido"><?php echo $translate['dirigido']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=material_edad"><?php echo $translate['edad']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=material_nivel"><?php echo $translate['nivel']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=material_saa"><?php echo $translate['SAA']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=material_tipo"><?php echo $translate['tipo']; ?></a></p>
<p><strong><?php echo $translate['SOFTWARE']; ?></strong>: <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=software_descripcion"><?php echo $translate['descripcion']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=software_informacion_adicional"><?php echo $translate['informacion_adicional']; ?></a>| <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=software_objetivo"><?php echo $translate['software_objetivo']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=software_tipo"><?php echo $translate['tipo_software']; ?></a></p>
<p><strong><?php echo $translate['ejemplos_de_uso']; ?></strong>: <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=eu_titulo"><?php echo $translate['nombre']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=eu_descripcion"><?php echo $translate['descripcion']; ?></a> | <a href="<?php echo $_SERVER['PHP_SELF'] ?>?tabla=eu_tipo"><?php echo $translate['tipo']; ?></a></p>
<?php if ($datos_traductor['is_admin']==1 && $tabla=='internacionalizacion') {  ?>
<div style="padding:10px; border:1px solid #CCC; margin-bottom:10px;">
<div style="color:#F00;"><?php echo $mensaje; ?></div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  <strong>Añadir nuevo campo: </strong><br />
  Página: 
  <label>
    <select name="id_pagina" id="id_pagina">
    <?php 
		while ($row_pages=mysql_fetch_array($listado_paginas)) {
			echo '<option value="'.$row_pages['id_page'].'">'.$row_pages['page'].'</option>';
		}
	?>
    </select>
  </label>
  <br />
   Key: <input name="key" type="text" id="key" size="50" maxlength="50"/>
  <br />
  Campo ES: 
    <input name="v1" type="text" id="v1" size="100"/>
  <br />
  <br /><input name="enviar" type="submit" value="Añadir" />
  <input name="tabla" type="hidden" id="tabla" value="<?php echo $tabla; ?>" />
  <input name="accion" type="hidden" id="accion" value="add" />
</form>
</div>
<?php } ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr style="color:#FFF;">
      <td height="29" align="center" bgcolor="#66CC33"><strong>ID</strong></td>
        <td align="center" bgcolor="#66CC33"><strong><?php if ($tabla=='definiciones') { echo 'PALABRA'; } else { echo 'KEY'; } ?></strong></td>
        <?php if ($idioma!='es') {  ?>
        <td align="center" bgcolor="#66CC33">&nbsp;</td>
        <?php  } ?>
        <td align="center" bgcolor="#66CC33" style="text-transform:uppercase;"><strong><?php echo $translate['origen']; ?></strong></td>
        <?php if ($tabla=='definiciones') { echo '<td align="center" bgcolor="#66CC33" style="text-transform:uppercase;"><strong>PALABRA TRADUCIDA</strong></td>'; } ?>
        <?php if ($idioma!='es') {  ?>
        <td align="center" bgcolor="#66CC33" style="text-transform:uppercase;"><strong><?php echo $translate['traduccion']; ?></strong></td>
        <?php  } ?>
        <td bgcolor="#66CC33">&nbsp;</td>
    </tr>
<?php 
while ($row=mysql_fetch_array($listado)) {
	
	switch ($tabla) {

		case 'internacionalizacion':
		$id=$row['id_key'];
		if ($traducir_desde=='es') {
			$castellano=$row['es'];
		} else {
			$castellano=$row[''.$traducir_desde.''];
		}
		$traduccion=$row[''.$idioma.''];
		$aux=$row['key'];
		break;
		
		case 'definiciones':
		$id=$row['id_traduccion'];
		if ($traducir_desde=='es') {
			$castellano=utf8_encode($row['definicion']);
		} else {
			$castellano=$row[''.$traducir_desde.''];
		}
		
		if ($row['definicion_traduccion'] !='') { 
			$traduccion=utf8_decode($row['definicion_traduccion']);
		} else {

			$traduccion=utf8_encode($row['definicion']);
		}
		
		$palabra_traducida=$row['traduccion'];
		$aux=$row['palabra'];
		$estado_definicion_traduccion=$row['estado_definicion_traduccion'];
		break;
		
		case 'idiomas':
		$id=$row['id_idioma'];
		if ($traducir_desde=='es') {
			$castellano=$row['idioma'];
		} else {
			$castellano=$row['idioma_'.$traducir_desde.''];
		}
		$traduccion=$row['idioma_'.$idioma.''];
		break;
		
		case 'categorias_enlaces':
		$id=$row['id_categoria_enlace'];
		if ($traducir_desde=='es') {
			$castellano=$row['categoria'];
		} else {
			$castellano=$row['categoria_'.$traducir_desde.''];
		}
		$traduccion=$row['categoria_'.$idioma.''];
		break;
		
		case 'enlaces':
		$id=$row['id_enlace'];
		if ($traducir_desde=='es') {
			$castellano=$row['enlace'];
		} else {
			$castellano=$row['enlace_'.$traducir_desde.''];
		}
		$traduccion=$row['enlace_'.$idioma.''];
		break;
		
		case 'descripcion_enlaces':
		$id=$row['id_enlace'];
		if ($traducir_desde=='es') {
			$castellano=$row['descripcion_enlace'];
		} else {
			$castellano=$row['descripcion_enlace_'.$traducir_desde.''];
		}
		$traduccion=$row['descripcion_enlace_'.$idioma.''];
		if ($idioma=='es') { $aux=$row['enlace']; } else {$aux=$row['enlace_'.$idioma.'']; }
		break;
		
		case 'temas':
		$id=$row['id_tema'];
		if ($traducir_desde=='es') {
			$castellano=$row['tema'];
		} else {
			$castellano=$row['tema_'.$traducir_desde.''];
		}
		$traduccion=$row['tema_'.$idioma.''];
		break;
		
		case 'subtemas':
		$id=$row['id_subtema'];
		if ($traducir_desde=='es') {
			$castellano=$row['subtema'];
		} else {
			$castellano=$row['subtema_'.$traducir_desde.''];
		}
		$traduccion=$row['subtema_'.$idioma.''];
		break;
		
		case 'temas_tmp':
		$id=$row['id_tema'];
		if ($traducir_desde=='es') {
			$castellano=$row['tema'];
		} else {
			$castellano=$row['tema_'.$traducir_desde.''];
		}
		$traduccion=$row['tema_'.$idioma.''];
		break;
		
		case 'subtemas_tmp':
		$id=$row['id_subtema'];
		if ($traducir_desde=='es') {
			$castellano=$row['subtema'];
		} else {
			$castellano=$row['subtema_'.$traducir_desde.''];
		}
		$traduccion=$row['subtema_'.$idioma.''];
		break;
		
		case 'noticias':
		$id=$row['id_noticia'];
		if ($traducir_desde=='es') {
			$castellano=$row['noticia'];
			$castellano_2=$row['titulo'];
		} else {
			$castellano=$row['noticia_'.$traducir_desde.''];
			$castellano_2=$row['titulo_'.$traducir_desde.''];
		}
		$traduccion=$row['noticia_'.$idioma.''];
		$traduccion_2=$row['titulo_'.$idioma.''];
		break;
		
		case 'material_area_curricular':
		$id=$row['id_ac_material'];
		if ($traducir_desde=='es') {
			$castellano=$row['ac_material'];
		} else {
			$castellano=$row['ac_material_'.$traducir_desde.''];
		}
		$traduccion=$row['ac_material_'.$idioma.''];
		break;
		
		case 'material_dirigido':
		$id=$row['id_dirigido_material'];
		if ($traducir_desde=='es') {
			$castellano=$row['dirigido_material'];
		} else {
			$castellano=$row['dirigido_material_'.$traducir_desde.''];
		}
		$traduccion=$row['dirigido_material_'.$idioma.''];
		break;
		
		case 'material_edad':
		$id=$row['id_edad_material'];
		if ($traducir_desde=='es') {
			$castellano=$row['edad_material'];
		} else {
			$castellano=$row['edad_material_'.$traducir_desde.''];
		}
		$traduccion=$row['edad_material_'.$idioma.''];
		break;
		
		case 'material_nivel':
		$id=$row['id_nivel_material'];
		if ($traducir_desde=='es') {
			$castellano=$row['nivel_material'];
		} else {
			$castellano=$row['nivel_material_'.$traducir_desde.''];
		}
		$traduccion=$row['nivel_material_'.$idioma.''];
		break;
		
		case 'material_saa':
		$id=$row['id_saa_material'];
		if ($traducir_desde=='es') {
			$castellano=$row['saa_material'];
		} else {
			$castellano=$row['saa_material_'.$traducir_desde.''];
		}
		$traduccion=$row['saa_material_'.$idioma.''];
		break;
		
		case 'material_subarea':
		$id=$row['id_subac_material'];
		if ($traducir_desde=='es') {
			$castellano=$row['subac_material'];
		} else {
			$castellano=$row['subac_material_'.$traducir_desde.''];
		}
		$traduccion=$row['subac_material_'.$idioma.''];
		break;
		
		case 'material_tipo':
		$id=$row['id_tipo_material'];
		if ($traducir_desde=='es') {
			$castellano=$row['tipo_material'];
		} else {
			$castellano=$row['tipo_material_'.$traducir_desde.''];
		}
		$traduccion=$row['tipo_material_'.$idioma.''];
		break;
		
		case 'ejemplos_uso':
		$id=$row['id_eu'];
		if ($traducir_desde=='es') {
			$castellano=$row['descripcion_eu'];
			$castellano_2=$row['titulo_eu'];
		} else {
			$castellano=$row['descripcion_eu_'.$traducir_desde.''];
			$castellano_2=$row['titulo_eu_'.$traducir_desde.''];
		}
		$traduccion=$row['descripcion_eu_'.$idioma.''];
		$traduccion_2=$row['titulo_eu_'.$idioma.''];
		break;
		
		case 'software_descripcion':
		$id=$row['id_software'];
		if ($traducir_desde=='es') {
			$castellano=$row['software_descripcion'];
		} else {
			$castellano=$row['software_descripcion_'.$traducir_desde.''];
		}
		$traduccion=$row['software_descripcion_'.$idioma.''];
		break;
		
		case 'software_informacion_adicional':
		$id=$row['id_software'];
		if ($traducir_desde=='es') {
			$castellano=$row['software_informacion_adicional'];
		} else {
			$castellano=$row['software_informacion_adicional_'.$traducir_desde.''];
		}
		$traduccion=$row['software_informacion_adicional_'.$idioma.''];
		break;
		
		case 'software_objetivo':
		$id=$row['id_software'];
		if ($traducir_desde=='es') {
			$castellano=$row['software_objetivo'];
		} else {
			$castellano=$row['software_objetivo_'.$traducir_desde.''];
		}
		$traduccion=$row['software_objetivo_'.$idioma.''];
		break;
		
		case 'software_tipo':
		$id=$row['id_tipo_software'];
		if ($traducir_desde=='es') {
			$castellano=$row['tipo_software'];
		} else {
			$castellano=$row['tipo_software_'.$traducir_desde.''];
		}
		$traduccion=$row['tipo_software_'.$idioma.''];
		break;
		
		case 'eu_titulo':
		$id=$row['id_eu'];
		if ($traducir_desde=='es') {
			$castellano=$row['eu_titulo'];
		} else {
			$castellano=$row['eu_titulo_'.$traducir_desde.''];
		}
		$traduccion=$row['eu_titulo_'.$idioma.''];
		break;
		
		case 'eu_descripcion':
		$id=$row['id_eu'];
		if ($traducir_desde=='es') {
			$castellano=$row['eu_descripcion'];
		} else {
			$castellano=$row['eu_descripcion_'.$traducir_desde.''];
		}
		$traduccion=$row['eu_descripcion_'.$idioma.''];
		break;

		case 'eu_tipo':
		$id=$row['id_tipo_eu'];
		if ($traducir_desde=='es') {
			$castellano=$row['tipo_eu'];
		} else {
			$castellano=$row['tipo_eu_'.$traducir_desde.''];
		}
		$traduccion=$row['tipo_eu_'.$idioma.''];
		break;
		
		default:
		$id=$row['id_key'];
		if ($traducir_desde=='es') {
			$castellano=$row['es'];
		} else {
			$castellano=$row[''.$traducir_desde.''];
		}
		$traduccion=$row[''.$idioma.''];
		break;
		
	}
	
if (strlen($castellano) < 50) { $filas=1; } 																																																										elseif (strlen($castellano) > 49 && strlen($castellano) < 100) { $filas=2; } 																																																										elseif (strlen($castellano) > 99 && strlen($castellano) < 150) { $filas=3; } 
elseif (strlen($castellano) > 149 && strlen($castellano) < 200) { $filas=4; }
elseif (strlen($castellano) > 199 && strlen($castellano) < 250) { $filas=5; } 
else { $filas=10; } 

if (strlen($castellano) < 50) { $columnas=strlen($castellano); } else { $columnas=55; }
?>
  <tr>
  	<td width="3%" align="center" style="padding-bottom:20px; border-bottom: 2px solid #6C3;"><?php echo $id; ?></td>
    <td width="3%" align="left" style="padding-bottom:20px; border-bottom: 2px solid #6C3; border-left:1px solid #F90; padding-left:10px;"><?php echo $aux; ?></td>
    <?php if ($idioma!='es') {  ?>
  	<td width="3%" style="padding-bottom:20px; border-bottom: 2px solid #6C3; border-left:1px solid #F90; padding:10px;" align="center"><div id="estado_definicion_traduccion_<?php echo $id; ?>">
	<?php 
	if ($tabla=='definiciones') {;
		if ($traduccion==NULL || $traduccion==''|| $traduccion==$castellano) { echo '<a href="javascript:void();" onclick="javascript:cargar_div2(\'languages/procesar_internacionalizacion.php\',\'estado=1&item='.$id.'&tabla=estado_definicion_traduccion&idioma='.$idioma.'\',\'estado_definicion_traduccion_'.$id.'\')"><img src="images/error.gif" alt="Sin traducir" title="Sin traducir" border="0"></a>'; } elseif ($traduccion !='' && $estado_definicion_traduccion==0) { echo '<a href="javascript:void();" onclick="javascript:cargar_div2(\'languages/procesar_internacionalizacion.php\',\'estado=1&item='.$id.'&tabla=estado_definicion_traduccion&idioma='.$idioma.'\',\'estado_definicion_traduccion_'.$id.'\')"><img src="images/question-mark.gif" alt="Traducida pero no publicada" title="Traducida pero no publicada" border="0"></a>'; } elseif ($traduccion !='' && $estado_definicion_traduccion==1) { echo '<a href="javascript:void();" onclick="javascript:cargar_div2(\'languages/procesar_internacionalizacion.php\',\'estado=0&item='.$id.'&tabla=estado_definicion_traduccion&idioma='.$idioma.'\',\'estado_definicion_traduccion_'.$id.'\')"><img src="images/check.jpg" alt="Traducida y publicada" title="Traducida y publicada" border="0"></a>';  }
	} else { 
		if ($traduccion==NULL || $traduccion=='') { echo '<img src="images/error.gif" border="0">'; }
	}
	?></div></td>
    <td width="47%" style="padding-bottom:20px; border-bottom: 2px solid #6C3; border-left:1px solid #F90; padding-left:10px;"><?php if ($tabla=='noticias' || $tabla=='ejemplos_uso') { echo $castellano_2.'<br /><br />'.$castellano; } else { echo $castellano;  }  ?></td>
   <?php if ($tabla=='definiciones') { echo '<td width="10%" style="padding-bottom:20px; border-bottom: 2px solid #6C3; border-left:1px solid #F90; padding-left:10px;">'.$palabra_traducida.'</td>'; } ?>
    <?php } ?>
    <td width="38%" style="padding-bottom:20px; border-bottom: 2px solid #6C3; border-left:1px solid #F90; padding-left:10px;">
    <?php if ($tabla=='noticias' || $tabla=='ejemplos_uso') { ?>
    	<div id="titulo_<?php echo $id; ?>"><?php if ($traduccion_2==NULL || $traduccion_2=='') { echo $castellano_2; } else { echo $traduccion_2;} ?></div>
        <script type="text/javascript">
         new Ajax.InPlaceEditor('titulo_<?php echo $id; ?>', 'languages/procesar_internacionalizacion.php?idioma=<?php echo $idioma; ?>&item=<?php echo $id; ?>&tabla=titulo_<?php echo $tabla; ?>', {paramName: 'titulo_<?php echo $id; ?>', rows:<?php echo $filas; ?>, cols: <?php echo $columnas; ?>,																																																																								   ajaxOptions: {method: 'post'}});
        </script>
    <?php } ?>    
    <div id="contenido_<?php echo $id; ?>"><?php if ($traduccion==NULL || $traduccion=='') { echo $castellano; } else { echo $traduccion;} ?></div></td>
    <?php if (ereg("([<]{1})([>]{1})?", $castellano)) { ?>
	<script>
    // <![CDATA[
      new Ajax.InPlaceRichEditor($('contenido_<?php echo $id; ?>'), 'languages/procesar_internacionalizacion.php?idioma=<?php echo $idioma; ?>&item=<?php echo $id; ?>&tabla=<?php echo $tabla; ?>', {
		paramName: 'contenido_<?php echo $id; ?>', paramCols: 100, paramRows: 20,
        ajaxOptions: {method: 'post'}, //override so we can use a static for the result
        tinymceSave: true}, 
        tinymce_advanced_with_save_options
      );
    // ]]>
    </script> 
	<?php } else { ?>
	<script type="text/javascript">
     new Ajax.InPlaceEditor('contenido_<?php echo $id; ?>', 'languages/procesar_internacionalizacion.php?idioma=<?php echo $idioma; ?>&item=<?php echo $id; ?>&tabla=<?php echo $tabla; ?>', {paramName: 'contenido_<?php echo $id; ?>', rows:<?php echo $filas; ?>, cols: <?php echo $columnas; ?>,																																																																								   ajaxOptions: {method: 'post'}});
    </script>
    <?php } ?>
    <td width="3%" style="padding-bottom:20px; border-bottom: 2px solid #6C3;"><a href="#seleccionar_tabla" target="_self"><?php if ($tabla=='definiciones') { echo '<a href="javascript:void();" onclick="javascript:cargar_div2(\'languages/procesar_internacionalizacion.php\',\'origen='.$castellano.'&idioma_destino='.$idioma.'&traducir_desde=es&tabla=traducir_definicion_traduccion&item='.$id.'\',\''.$id.'\'); javascript:cargar_div2(\'languages/procesar_internacionalizacion.php\',\'estado=0&item='.$id.'&tabla=estado_definicion_traduccion\',\'estado_definicion_traduccion_'.$id.'\');">Traducir</a>'; } else { echo $translate['arriba'];   } ?></a></td> 
  </tr>
  <?php } ?>  
</table>
<?php if ($tabla=='definiciones') {  ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center"></td>
    </tr>
    <tr>
      <td align="center">
      <form id="form1" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Página: 
        <input name="pg" type="text" id="pg" value="<?php echo $pg; ?>" size="5" maxlength="5" /><input name="tabla" type="hidden" id="tabla" value="<?php echo $tabla; ?>" size="5" maxlength="5" />
        </form>
      </td>
    </tr>
    <tr>
      <td align="center"><?php 
	if ($total_pages > 0) {
				
					
                    if ($page_limit > $total_pages ) {
                    
                        $page_limit = $total_pages;
                    
                    }
                    
                    $page_start = $pg;
                    $page_stop = $page_start + $limitpages;
                    
                        if ($page_stop > $total_pages) { 
                        
                            $page_stop = $page_stop -$total_pages;
                            $page_start = $page_start -$page_stop;
                        
                        }
                    
                    $content= '<p><div id="pagination">';
                    
                    // Volver a Inicio
                    if($pg > 0) {
                    
                    $prev_limit = ($pg - $limitpages);

                    $content.= "<a href=\"".$_SERVER['PHP_SELF']."?tabla=definiciones&pg=0\"><< </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled"><<</span>';
                    
                    }
                    
                    // Pagina anterior
                    if($pg > 0) { 
                    
                    $prev = ($pg - 1);
                    $content.= "<a href=\"".$_SERVER['PHP_SELF']."?tabla=definiciones&pg=".$prev."\"> <</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled">< </span>';
                    
                    }
                    
                    // Paginacion
                    if($total_pages >= $limitpages) {
                    
                        for($i = $page_start-$limite_inferior; ($i <= $total_pages & $i <=$page_limit); $i++) {
                        
                            if(($i) >= 0) { 	
                                if(($pg) == $i) { 
                                
                                $content.= '<span class="current">'.$i.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                
                                } else {
                                
                                $content.= "<a href=\"".$_SERVER['PHP_SELF']."?tabla=definiciones&pg=".$i."\">".$i."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                }
                            }
                        
                        } // Cierro el FOR
                    
                    } else {
                    
                        for($i = 0; $i <= $total_pages; $i++) {
                        
                            if(($pg) == $i) {
                            
                            $content.= '<span class="current">'.$i.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            
                            } else {
                            
                            $content.= "<a href=\"".$_SERVER['PHP_SELF']."?tabla=definiciones&pg=".$i."\">".$i."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        
                        } // Cierro el FOR
                        
                    } // Cierro el IF
                    
                    }
                    
                    // Siguiente página
                    if($pg < $total_pages) {
                    
                    $next = ($pg + 1);
                    $content.= "<a href=\"".$_SERVER['PHP_SELF']."?tabla=definiciones&pg=".$next."\"> ></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled"> ></span>';
                    
                    }
                    
                    // Ultima página
                    if($pg < $total_pages)
                    {
                    
                    $last = $total_pages;
                    $content.= "<a href=\"".$_SERVER['PHP_SELF']."?tabla=definiciones&pg=".$last."\">  >></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled"> >></span>';
                    
                    }
                    
                    
                    $content.= "</p></div>";
                    
                    
                    $content.= "</p></div>";
              
	}
	echo $content;
?></td>
      </tr>
  </table>
<?php  } //Cierro el IF que comprueba si es la tabla de definiciones ?>
</body>
</html>

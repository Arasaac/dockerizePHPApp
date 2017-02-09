<?php 
session_start();  // INICIO LA SESION
include ('../classes/querys/query.php');
$query=new query();

define('BING_API', '3E63618F2CFAA279EC05F2DCBEAD178879F0AAC9');
 
function loadData($url, $ref = false) {
	$chImg = curl_init($url);
	curl_setopt($chImg, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($chImg, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0) Gecko/20100101 Firefox/4.0");
	if ($ref) {
		curl_setopt($chImg, CURLOPT_REFERER, $ref);
	}
	$curl_scraped_data = curl_exec($chImg);
	curl_close($chImg);
	return $curl_scraped_data;
}
 
function translate($text, $from = 'en', $to = 'fr') {
	$data = loadData('http://api.bing.net/json.aspx?AppId=' . BING_API . '&Sources=Translation&Version=2.2&Translation.SourceLanguage=' . $from . '&Translation.TargetLanguage=' . $to . '&Query=' . urlencode($text));
	$translated = json_decode($data);
	if (sizeof($translated) > 0) {
		if (isset($translated->SearchResponse->Translation->Results[0]->TranslatedTerm)) {
			return $translated->SearchResponse->Translation->Results[0]->TranslatedTerm;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

$idioma=$_REQUEST['idioma'];
$item=$_REQUEST['item'];
$tabla=$_REQUEST['tabla'];
$estado=$_REQUEST['estado'];

switch ($idioma) {

	case 'ru':
	$id_idioma=1;
	break;
	
	case 'ro':
	$id_idioma=1;
	break;
	
	case 'ar':
	$id_idioma=3;
	break;
	
	case 'zh':
	$id_idioma=4;
	break;
	
	case 'bg':
	$id_idioma=5;
	break;
	
	case 'pl':
	$id_idioma=6;
	break;
		
	case 'en':
	$id_idioma=7;
	break;
	
	case 'fr':
	$id_idioma=8;
	break;
	
	case 'ca':
	$id_idioma=9;
	break;
	
	case 'eu':
	$id_idioma=10;
	break;
	
	case 'de':
	$id_idioma=11;
	break;
	
	case 'it':
	$id_idioma=12;
	break;
	
	case 'pt':
	$id_idioma=13;
	break;
	
	case 'ga':
	$id_idioma=14;
	break;
	
	case 'br':
	$id_idioma=15;
	break;

}

switch ($tabla) {
	
		case 'internacionalizacion':
		$contenido=htmlentities($_POST['contenido_'.$item.'']);
		$actualizar=$query->actualizar_item_internacionalizacion($item,html_entity_decode($contenido),$idioma);
		$datos_item=$query->datos_item_internacionalizacion($item);
		echo $datos_item[''.$idioma.''];
		break;
		
		case 'definiciones':
		$contenido=$_POST['contenido_'.$item.''];
		$actualizar=$query->actualizar_definicion_traduccion($item,utf8_encode($contenido),$id_idioma);
		$datos_item=$query->datos_traduccion($item,$id_idioma);
		echo utf8_decode($datos_item['definicion_traduccion']);
		break;
		
		case 'traducir_definicion_traduccion':
		$origen=$_POST['origen'];
		
		  if ($_POST['idioma_destino']=='br') {
				$idioma_destino='pt-br';
			} else {
				$idioma_destino=$_POST['idioma_destino'];
		  }
			
		$traduccion=translate($origen,$_POST['traducir_desde'],$idioma_destino);
		$traduccion=addslashes($traduccion);
		$traduccion=utf8_encode($traduccion);
		if ($traduccion !='' || $traduccion !=NULL) {
		$actualizar=$query->actualizar_definicion_traduccion($item,$traduccion,$id_idioma);
		echo stripslashes(utf8_decode($traduccion));
		} else {
		echo $_POST['origen'];	
		}
		break;
		
		case 'estado_definicion_traduccion':
		$actualizar=$query->actualizar_estado_definicion_traduccion($item,$estado,$id_idioma);
		$datos_item=$query->datos_traduccion($item,$id_idioma);
		
			if ($datos_item['estado_definicion_traduccion']==0) { echo '<a href="javascript:void();" onclick="javascript:cargar_div2(\'languages/procesar_internacionalizacion.php\',\'estado=1&item='.$item.'&tabla=estado_definicion_traduccion\',\'estado_definicion_traduccion_'.$item.'\')"><img src="images/question-mark.gif" alt="Traducida pero no publicada" title="Traducida pero no publicada" border="0"></a>'; } 
			elseif ($datos_item['estado_definicion_traduccion']==1) { echo '<a href="javascript:void();" onclick="javascript:cargar_div2(\'languages/procesar_internacionalizacion.php\',\'estado=0&item='.$item.'&tabla=estado_definicion_traduccion\',\'estado_definicion_traduccion_'.$item.'\')"><img src="images/check.jpg" alt="Traducida y publicada" title="Traducida y publicada" border="0"></a>';  }
				
		break;
		
		case 'idiomas':
		$contenido=$_POST['contenido_'.$item.''];
		$actualizar=$query->actualizar_item_tabla_idiomas($item,$contenido,$idioma);
		$datos_item=$query->datos_idioma_completo($item);
		echo $datos_item['idioma_'.$idioma.''];
		break;
		
		case 'categorias_enlaces':
		$contenido=$_POST['contenido_'.$item.''];
		$actualizar=$query->actualizar_item_tabla_categorias_enlaces($item,$contenido,$idioma);
		$datos_item=$query->datos_categoria_enlace($item);
		if ($idioma=='es') { echo $datos_item['categoria']; } else {  echo $datos_item['categoria_'.$idioma.'']; }
		break;
		
		case 'enlaces':
		$contenido=$_POSTT['contenido_'.$item.''];
		$actualizar=$query->actualizar_item_tabla_enlaces($item,$contenido,$idioma);
		$datos_item=$query->datos_enlace($item);
		if ($idioma=='es') { echo $datos_item['enlace']; } else {  echo $datos_item['enlace_'.$idioma.'']; }
		break;
		
		case 'descripcion_enlaces':
		$contenido=$_POST['contenido_'.$item.''];
		$actualizar=$query->actualizar_descripcion_item_tabla_enlaces($item,$contenido,$idioma);
		$datos_item=$query->datos_enlace($item);
		if ($idioma=='es') { echo $datos_item['descripcion_enlace']; } else {  echo $datos_item['descripcion_enlace_'.$idioma.'']; }
		break;
		
		case 'temas':
		$contenido=$_POST['contenido_'.$item.''];
		$actualizar=$query->actualizar_item_tabla_temas($item,$contenido,$idioma);
		$datos_item=$query->datos_tema($item);
		if ($idioma=='es') { echo $datos_item['tema']; } else {  echo $datos_item['tema_'.$idioma.'']; }
		break;
		
		case 'subtemas':
		$contenido=$_POST['contenido_'.$item.''];
		$actualizar=$query->actualizar_item_tabla_subtemas($item,$contenido,$idioma);
		$datos_item=$query->datos_subtema($item);
		if ($idioma=='es') { echo $datos_item['subtema']; } else {  echo $datos_item['subtema_'.$idioma.'']; }
		break;
		
		case 'temas_tmp':
		$contenido=$_POST['contenido_'.$item.''];
		$actualizar=$query->actualizar_item_tabla_temas_tmp($item,$contenido,$idioma);
		$datos_item=$query->datos_tema_tmp($item);
		if ($idioma=='es') { echo $datos_item['tema']; } else {  echo $datos_item['tema_'.$idioma.'']; }
		break;
		
		case 'subtemas_tmp':
		$contenido=$_POST['contenido_'.$item.''];
		$actualizar=$query->actualizar_item_tabla_subtemas_tmp($item,$contenido,$idioma);
		$datos_item=$query->datos_subtema_tmp($item);
		if ($idioma=='es') { echo $datos_item['subtema']; } else {  echo $datos_item['subtema_'.$idioma.'']; }
		break;
		
		case 'noticias':
		$contenido=$_POST['contenido_'.$item.''];
		$campo='noticia';
		$actualizar=$query->actualizar_item_noticia($item,$campo,$contenido,$idioma);
		$datos_item=$query->datos_noticia($item);
		if ($idioma=='es') { echo $datos_item['noticia']; } else {  echo $datos_item['noticia_'.$idioma.'']; }
		break;
		
		case 'titulo_noticias':
		$contenido=$_POST['titulo_'.$item.''];
		$campo='titulo';
		$actualizar=$query->actualizar_item_noticia($item,$campo,$contenido,$idioma);
		$datos_item=$query->datos_noticia($item);
		if ($idioma=='es') { echo $datos_item['titulo']; } else {  echo $datos_item['titulo_'.$idioma.'']; }
		break;
		
		case 'material_area_curricular':
		$contenido=$_POST['contenido_'.$item.''];
		$tabla='material_area_curricular';
		$campo='ac_material';
		$id='id_ac_material';
		$actualizar=$query->actualizar_item_tabla_material($item,$contenido,$idioma,$tabla,$campo,$id);
		$datos_item=$query->datos_tabla_material($item,$tabla,$id);
		if ($idioma=='es') { echo $datos_item['ac_material']; } else {  echo $datos_item['ac_material_'.$idioma.'']; }
		break;
		
		case 'material_dirigido':
		$contenido=$_POST['contenido_'.$item.''];
		$tabla='material_dirigido';
		$campo='dirigido_material';
		$id='id_dirigido_material';
		$actualizar=$query->actualizar_item_tabla_material($item,$contenido,$idioma,$tabla,$campo,$id);
		$datos_item=$query->datos_tabla_material($item,$tabla,$id);
		if ($idioma=='es') { echo $datos_item['dirigido_material']; } else {  echo $datos_item['dirigido_material_'.$idioma.'']; }
		break;
		
		case 'material_edad':
		$contenido=$_POST['contenido_'.$item.''];
		$tabla='material_edad';
		$campo='edad_material';
		$id='id_edad_material';
		$actualizar=$query->actualizar_item_tabla_material($item,$contenido,$idioma,$tabla,$campo,$id);
		$datos_item=$query->datos_tabla_material($item,$tabla,$id);
		if ($idioma=='es') { echo $datos_item['edad_material']; } else {  echo $datos_item['edad_material_'.$idioma.'']; }
		break;
		
		case 'material_nivel':
		$contenido=$_POST['contenido_'.$item.''];
		$tabla='material_nivel';
		$campo='nivel_material';
		$id='id_nivel_material';
		$actualizar=$query->actualizar_item_tabla_material($item,$contenido,$idioma,$tabla,$campo,$id);
		$datos_item=$query->datos_tabla_material($item,$tabla,$id);
		if ($idioma=='es') { echo $datos_item['nivel_material']; } else {  echo $datos_item['nivel_material_'.$idioma.'']; }
		break;
		
		case 'material_saa':
		$contenido=$_POST['contenido_'.$item.''];
		$tabla='material_saa';
		$campo='saa_material';
		$id='id_saa_material';
		$actualizar=$query->actualizar_item_tabla_material($item,$contenido,$idioma,$tabla,$campo,$id);
		$datos_item=$query->datos_tabla_material($item,$tabla,$id);
		if ($idioma=='es') { echo $datos_item['saa_material']; } else {  echo $datos_item['saa_material_'.$idioma.'']; }
		break;
		
		case 'material_subarea':
		$contenido=$_POST['contenido_'.$item.''];
		$tabla='material_subarea';
		$campo='subac_material';
		$id='id_subac_material';
		$actualizar=$query->actualizar_item_tabla_material($item,$contenido,$idioma,$tabla,$campo,$id);
		$datos_item=$query->datos_tabla_material($item,$tabla,$id);
		if ($idioma=='es') { echo $datos_item['subac_material']; } else {  echo $datos_item['subac_material_'.$idioma.'']; }
		break;
		
		case 'material_tipo':
		$contenido=$_POST['contenido_'.$item.''];
		$tabla='material_tipo';
		$campo='tipo_material';
		$id='id_tipo_material';
		$actualizar=$query->actualizar_item_tabla_material($item,$contenido,$idioma,$tabla,$campo,$id);
		$datos_item=$query->datos_tabla_material($item,$tabla,$id);
		if ($idioma=='es') { echo $datos_item['tipo_material']; } else {  echo $datos_item['tipo_material_'.$idioma.'']; }
		break;
		
		case 'ejemplos_uso':
		$contenido=$_POST['contenido_'.$item.''];
		$campo='descripcion_eu';
		$actualizar=$query->actualizar_item_eu($item,$campo,$contenido,$idioma);
		$datos_item=$query->datos_eu($item);
		if ($idioma=='es') { echo $datos_item['descripcion_eu']; } else {  echo $datos_item['descripcion_eu_'.$idioma.'']; }
		break;
		
		case 'titulo_ejemplos_uso':
		$contenido=$_POST['titulo_'.$item.''];
		$campo='titulo_eu';
		$actualizar=$query->actualizar_item_eu($item,$campo,$contenido,$idioma);
		$datos_item=$query->datos_eu($item);
		if ($idioma=='es') { echo $datos_item['titulo_eu']; } else {  echo $datos_item['titulo_eu_'.$idioma.'']; }
		break;
		
		case 'software_descripcion':
		$tabla='software_descripcion';
		$campo_indice='id_software';
		$contenido=$_POST['contenido_'.$item.''];
		$campo='software_descripcion';
		$actualizar=$query->actualizar_item_tabla($tabla,$campo_indice,$item,$campo,$contenido,$idioma);
		$datos_item=$query->datos_tabla($tabla,$campo_indice,$item);
		if ($idioma=='es') { echo $datos_item['software_descripcion']; } else {  echo $datos_item['software_descripcion_'.$idioma.'']; }
		break;
		
		case 'software_informacion_adicional':
		$tabla='software_informacion_adicional';
		$campo_indice='id_software';
		$contenido=$_POST['contenido_'.$item.''];
		$campo='software_informacion_adicional';
		$actualizar=$query->actualizar_item_tabla($tabla,$campo_indice,$item,$campo,$contenido,$idioma);
		$datos_item=$query->datos_tabla($tabla,$campo_indice,$item);
		if ($idioma=='es') { echo $datos_item['software_informacion_adicional']; } else {  echo $datos_item['software_informacion_adicional_'.$idioma.'']; }
		break;
		
		case 'software_objetivo':
		$tabla='software_objetivo';
		$campo_indice='id_software';
		$contenido=$_POST['contenido_'.$item.''];
		$campo='software_objetivo';
		$actualizar=$query->actualizar_item_tabla($tabla,$campo_indice,$item,$campo,$contenido,$idioma);
		$datos_item=$query->datos_tabla($tabla,$campo_indice,$item);
		if ($idioma=='es') { echo $datos_item['software_objetivo']; } else {  echo $datos_item['software_objetivo_'.$idioma.'']; }
		break;
		
		case 'software_tipo':
		$tabla='software_tipo';
		$campo_indice='id_tipo_software';
		$contenido=$_POST['contenido_'.$item.''];
		$campo='tipo_software';
		$actualizar=$query->actualizar_item_tabla($tabla,$campo_indice,$item,$campo,$contenido,$idioma);
		$datos_item=$query->datos_tabla($tabla,$campo_indice,$item);
		if ($idioma=='es') { echo $datos_item['tipo_software']; } else {  echo $datos_item['tipo_software_'.$idioma.'']; }
		break;
	
		case 'eu_titulo':
		$tabla='eu';
		$campo_indice='id_eu';
		$contenido=$_POST['contenido_'.$item.''];
		$campo='eu_titulo';
		$actualizar=$query->actualizar_item_tabla($tabla,$campo_indice,$item,$campo,$contenido,$idioma);
		$datos_item=$query->datos_tabla($tabla,$campo_indice,$item);
		if ($idioma=='es') { echo $datos_item['eu_titulo']; } else {  echo $datos_item['eu_titulo_'.$idioma.'']; }
		break;
			
		case 'eu_descripcion':
		$tabla='eu_descripcion';
		$campo_indice='id_eu';
		$contenido=$_POST['contenido_'.$item.''];
		$campo='eu_descripcion';
		$actualizar=$query->actualizar_item_tabla($tabla,$campo_indice,$item,$campo,$contenido,$idioma);
		$datos_item=$query->datos_tabla($tabla,$campo_indice,$item);
		if ($idioma=='es') { echo $datos_item['eu_descripcion']; } else {  echo $datos_item['eu_descripcion_'.$idioma.'']; }
		break;
		
		case 'eu_tipo':
		$tabla='eu_tipo';
		$campo_indice='id_tipo_eu';
		$contenido=$_POST['contenido_'.$item.''];
		$campo='tipo_eu';
		$actualizar=$query->actualizar_item_tabla($tabla,$campo_indice,$item,$campo,$contenido,$idioma);
		$datos_item=$query->datos_tabla($tabla,$campo_indice,$item);
		if ($idioma=='es') { echo $datos_item['tipo_eu']; } else {  echo $datos_item['tipo_eu_'.$idioma.'']; }
		break;
		
}
?>
<?php 
include ('../funciones/funciones.php');
include ('../classes/querys/query.php');
include('../classes/feedgenerator/FeedGenerator.php');
include ('../classes/date/Date.class.php');
require_once('../classes/crypt/5CR.php');
require_once('../configuration/key.inc');

$encript = new E5CR($llave); 
$query=new query();

$t=$_GET['t'];

switch ($t) {

case 1: // Búsqueda de materiales

$texto_buscar=$_GET['titulo_descripcion'];
$id_licencia=2;
		
if (isset($_GET['area_curricular']) && $_GET['area_curricular'] > 0) {  $sql.="AND material_area_curricular LIKE '%{".$_GET['area_curricular']."}%' ";  }
if (isset($_GET['subarea_curricular']) && $_GET['subarea_curricular'] > 0) {  $sql.="AND material_subarea_curricular LIKE '%{".$_GET['subarea_curricular']."}%' ";  }
if (isset($_GET['tipo']) && $_GET['tipo'] > 0) {  $sql.="AND material_tipo LIKE '%{".$_GET['tipo']."}%' ";  }
if (isset($_GET['dirigido']) && $_GET['dirigido'] > 0) {  $sql.="AND material_dirigido LIKE '%{".$_GET['dirigido']."}%' ";  }
if (isset($_GET['nivel']) && $_GET['nivel'] > 0) {  $sql.="AND material_nivel LIKE '%{".$_GET['nivel']."}%' ";  }
if (isset($_GET['saa']) && $_GET['saa'] > 0) {  $sql.="AND material_saa LIKE '%{".$_GET['saa']."}%' ";  }

if (isset($_GET['autor']) && $_GET['autor'] !='') {
	$autores=$query->buscar_autores_nombre($_GET['autor']);
	
		while ($row_autor=mysql_fetch_array($autores)) {
		
			$sql.="AND material_autor LIKE '%{".$row_autor['id_autor']."}%' "; 
		
		}
}

$feeds=new FeedGenerator;
$feeds->setGenerator(new RSSGenerator); # or AtomGenerator
$feeds->setAuthor('CATEDU');
$feeds->setTitle(utf8_encode('ARASAAC: Buscador de Materiales Simple (RSS)'));
$feeds->setChannelLink('http://catedu.es/arasaac/');
$feeds->setLink('http://catedu.es/arasaac/');
$feeds->setDescription(utf8_encode('Resultados del buscador simple de materiales del Portal Aragonés de la Comunicación Aumentativa y Alternativa de Aragón'));
$feeds->setID(rand(100000,100000000000000000));

$resultados=$query->buscar_materiales($_SESSION['AUTHORIZED'],$texto_buscar,$id_licencia,$sql);

	while ($datos=mysql_fetch_array($resultados)) {
	
			$autores='';
			$archivos='';
			$mau='';
			$ma='';
			$mau1='';
			$ma1='';
			
			$datos_licencia=$query->datos_licencia($id_licencia);
			
			if ($datos_licencia['logo_licencia'] != '') { $licencia1='<a href="'.$datos_licencia['link_licencia'].'" target="_blank"><img src="../images/'.$datos_licencia['logo_licencia'].'" alt="'.utf8_encode($datos_licencia['licencia']).'" title="'.utf8_encode($datos_licencia['licencia']).'" border="0" /></a>';  } else {  $licencia1=utf8_encode($datos_licencia['licencia']); }
				
				
			  $mau=str_replace('}{',',',$datos['material_autor']);
			  $mau=str_replace('{','',$mau);
			  $mau=str_replace('}','',$mau);
			  $mau1=explode(',',$mau);
			  
			  for ($i=0;$i<count($mau1);$i++) { 
				if ($mau1[$i]!='') {
				 $data_autor=$query->datos_autor($mau1[$i]);
				 $autores.=$data_autor['autor'].'<br />'; 
				}
			  }
			  
			  $ma=str_replace('}{',',',$datos['material_archivos']);
			  $ma=str_replace('{','',$ma);
			  $ma=str_replace('}','',$ma);
			  $ma1=explode(',',$ma);
			  
			  for ($i=0;$i<count($ma1);$i++) { 
				if ($ma1[$i]!='') {
				 $archivos.='<a href="http://catedu.es/arasaac/zona_descargas/materiales/'.$datos['id_material'].'/'.$ma1[$i].'" target="_blank"><img src=\'http://catedu.es/arasaac/images/download1.png\' border="0" alt="Descargar material" title="Descargar material"><a/>&nbsp;&nbsp;<a href="http://catedu.es/arasaac/zona_descargas/materiales/'.$datos['id_material'].'/'.$ma1[$i].'" target="_blank">'.$ma1[$i].'<a/><br /><br />'; 
				}
			  }
	
		//$feeds->addItem(new FeedItem('http://example.com/news/1', 'Example news', 'http://example.com/news/1', '<p>Description of news</p>'));
		
		$feeds->addItem(new FeedItem('http://' . $_SERVER['HTTP_HOST'] . '/arasaac/?id_material='.$datos['id_material'].'', utf8_encode($datos['material_titulo']), 'http://' . $_SERVER['HTTP_HOST'] . '/arasaac/?id_material='.$datos['id_material'].'', '<p>'.utf8_encode($datos['material_descripcion']).'<br /><br /><b>Licencia:</b><br /><br />'.$licencia1.'<br /><br /><b>Autores:</b><br /><br />'.utf8_encode($autores).'<br /><br /><b>Archivos:</b><br /><br />'.utf8_encode($archivos).'</p>'));
	}



$feeds->display();

break;

case 2: //Ultimas Noticias

$feeds=new FeedGenerator;
$feeds->setGenerator(new RSSGenerator);
$feeds->setAuthor('CATEDU');
$feeds->setTitle(utf8_encode('ARASAAC: Últimas noticias'));
$feeds->setChannelLink('http://catedu.es/arasaac/');
$feeds->setLink('http://catedu.es/arasaac/');
$feeds->setDescription(utf8_encode('Este canal da a conocer las ultimas noticias y novedades del Portal Aragonés de la Comunicación Aumentativa y Alternativa de Aragón y relacionadas con el mundo de los SAAC'));
$feeds->setID('http://catedu.es/arasaac/');

$limit = 10; //noticias a mostrar 
$res=$query->ultimas_noticias_publicadas($limit);
		
		while ($datos = mysql_fetch_array($res)) {
		
			$feeds->addItem(new FeedItem('http://' . $_SERVER['HTTP_HOST'] . '/arasaac/noticias.php?id_noticia='.$datos['id_noticia'].'', $datos['titulo'], 'http://' . $_SERVER['HTTP_HOST'] . '/arasaac/noticias.php?id_noticia='.$datos['id_noticia'].'', '<p>'.$datos['noticia'].'</p>'));
		
		} 
		
$feeds->display();
		
break;

case 3: //Ultimos materiales

$feeds=new FeedGenerator;
$feeds->setGenerator(new RSSGenerator);
$feeds->setAuthor('CATEDU');
$feeds->setTitle(utf8_encode('ARASAAC: Últimos materiales'));
$feeds->setChannelLink('http://catedu.es/arasaac/');
$feeds->setLink('http://catedu.es/arasaac/');
$feeds->setDescription(utf8_encode('Este canal da a conocer los ultimos materiales elaborados por colaboradores del Portal Aragonés de Sistemas de Comunicación Aumentativa y Alternativa con las imágenes y pictogramas distribuídas en el Portal.'));
$feeds->setID('http://catedu.es/arasaac/');

$limit = 10; //noticias a mostrar 
		$inicial=0;
		$res=$query->ultimos_materiales_publicados_limit($inicial,$limit);
		
		while ($datos = mysql_fetch_array($res)) {
			
			$autores='';
			$archivos='';
			$mau='';
			$ma='';
			$mau1='';
			$ma1='';
			
			if ($datos['logo_licencia'] != '') { $licencia='<a href="'.$datos['link_licencia'].'" target="_blank"><img src="http://'.$_SERVER['HTTP_HOST'].'/arasaac/images/'.$datos['logo_licencia'].'" alt="'.utf8_encode($datos['licencia']).'" title="'.utf8_encode($datos['licencia']).'" border="0" /></a>';  } else {  $licencia=utf8_encode($datos['licencia']); }
				
				
			  $mau=str_replace('}{',',',$datos['material_autor']);
			  $mau=str_replace('{','',$mau);
			  $mau=str_replace('}','',$mau);
			  $mau1=explode(',',$mau);
			  
			  for ($i=0;$i<count($mau1);$i++) { 
				if ($mau1[$i]!='') {
				 $data_autor=$query->datos_autor($mau1[$i]);
				 $autores.=$data_autor['autor'].'<br />'; 
				}
			  }
			  
			  $ma=str_replace('}{',',',$datos['material_archivos']);
			  $ma=str_replace('{','',$ma);
			  $ma=str_replace('}','',$ma);
			  $ma1=explode(',',$ma);
			  
			  for ($i=0;$i<count($ma1);$i++) { 
				if ($ma1[$i]!='') {
				 $archivos.='<a href="http://'.$_SERVER['HTTP_HOST'].'/arasaac/zona_descargas/materiales/'.$datos['id_material'].'/'.$ma1[$i].'" target="_blank"><img src=\'../images/download1.png\' border="0" alt="Descargar material" title="Descargar material"><a/>&nbsp;&nbsp;<a href="http://'.$_SERVER['HTTP_HOST'].'/arasaac/zona_descargas/materiales/'.$datos['id_material'].'/'.$ma1[$i].'" target="_blank">'.$ma1[$i].'<a/><br /><br />'; 
				}
			  }
	
			
			$feeds->addItem(new FeedItem('http://'.$_SERVER['HTTP_HOST'].'/arasaac/?id_material='.$datos['id_material'].'', utf8_encode($datos['material_titulo']), 'http://'.$_SERVER['HTTP_HOST'].'/arasaac/?id_material='.$datos['id_material'].'', utf8_encode($datos['material_descripcion'].'<br /><br /><b>Licencia:</b><br /><br />'.$licencia.'<br /><br /><b>Autores:</b><br /><br />'.$autores.'<br /><br /><b>Archivos:</b><br /><br />'.$archivos)));
			
		} 
$feeds->display();
break;


case 4: //Catalogos de Imagenes Originales 

$id_tipo=$_GET['id_tipo'];
$datos_tipo_imagen=$query->datos_tipo_imagen($id_tipo);

$feeds=new FeedGenerator;
$feeds->setGenerator(new RSSGenerator);
$feeds->setAuthor('CATEDU');
$feeds->setTitle(utf8_encode('ARASAAC: '.$datos_tipo_imagen['tipo_imagen'].''));
$feeds->setChannelLink('http://catedu.es/arasaac/');
$feeds->setLink('http://catedu.es/arasaac/');
$feeds->setDescription(utf8_encode($datos_tipo_imagen['tipo_imagen'].': Últimas incorporaciones al catálogo de ARASAAC'));
$feeds->setID('http://catedu.es/arasaac/');

$limite=50;
$res2=$query->imagenes_disponibles_solo_por_tipo($id_tipo,$limite);
		
		while ($datos = mysql_fetch_array($res2)) {
		
			$descript='';
			
			if ($id_tipo==11) {
	
				$descript='<object id="'.$datos['id_imagen'].'" width="110" height="125" data="http://catedu.es/arasaac/plugins/flowplayer/flowplayer-3.1.1.swf"  
					type="application/x-shockwave-flash"> 
					 <param name="wmode" value="transparent">
					<param name="movie" value="http://catedu.es/arasaac/plugins/flowplayer/flowplayer-3.1.1.swf" />  
					<param name="allowfullscreen" value="true" /> 
					 
					<param name="flashvars"  
						value=\'config={"clip": { "url": "http://catedu.es/arasaac/repositorio/LSE_acepciones/'.$datos['imagen'].'", "bufferLength": 2, "autoBuffering": true,
							"autoPlay": false, "scaling": "fit"}, "play": {"replayLabel": "Repetir" }, "plugins": { "controls": {"volume": false, "mute": false, "time":false, "height":15, "backgroundColor": "#FFFFFF", "progressColor": "#000000", "bufferColor": "#CCCCCC" } }  }\' /> 
				</object><br />';
					
				$result_lse=$query->buscar_acepcion_lse($datos['id_palabra']);
				$numrows_lse=mysql_num_rows($result_lse);
				
					if ($numrows_lse>0) {  
						$r=1;
							while ($row_lse=mysql_fetch_array($result_lse)) { 
								
								$descript.=utf8_encode('<a href="http://catedu.es/arasaac/inc/public/ver_acepcion.php?i='.$row_lse['id_imagen'].'" target="_blank"><img src="http://catedu.es/arasaac/images/acepcion_'.$r.'.jpg" alt="Ver traducci&oacute;n nº '.$r.' en LSE" title="Ver traducci&oacute;n nº '.$r.' en LSE" border=0" /></a>&nbsp;');
							$r++;
							
							}  
					}
					
				$descript.='<b>'.utf8_decode($datos['palabra']).': </b><em>'.$datos['definicion'].'</em>';
				
				if (file_exists('../repositorio/LSE_definiciones/'.$datos['id_palabra'].'.flv')) {
					$descript.='&nbsp;<a href="http://catedu.es/arasaac/inc/public/ver_definicion.php?i='.$datos['id_palabra'].'" target="_blank"><img src="http://catedu.es/arasaac/images/icono_lse_16x16.jpg" alt="Ver definici&oacute;n en LSE" title="Ver definici&oacute;n en LSE" border=0" /></a>';
				} 
						
				$descript.='<br /><br />';
				
				
				$descript.="<b>Autor: </b>&nbsp;".$datos['autor'];
				if ($datos['web_autor'] != '') { $descript.='&nbsp;<a href="'.$datos['web_autor'].'" target="_blank"><img src="http://'.$_SERVER['HTTP_HOST'].'/arasaac/images/webexport.png" alt="Visitar p&aacute;gina web" border=0" /></a>'; } 
				if ($datos['email_autor'] != '') { $descript.='&nbsp;<a href="mailto:'.$datos['email_autor'].'"><img src="http://'.$_SERVER['HTTP_HOST'].'/arasaac/images/mail_new.png" alt="Enviar email" border=0" /></a>'; } 
				
				$descript.='<br /><br /><b>Licencia:</b>&nbsp;';
				
				if ($datos['logo_licencia'] != '') { $descript.='<a href="'.$datos['link_licencia'].'" target="_blank"><img src="http://'.$_SERVER['HTTP_HOST'].'/arasaac/images/'.$datos['logo_licencia'].'" alt="'.utf8_encode($datos['licencia']).'" title="'.utf8_encode($datos['licencia']).'" border="0" /></a>';  } 
		  
				 $descript.='<br /><br /><b>Palabras clave: </b>';
				 
				  $tags=str_replace('}{',',',$datos['tags_imagen']);
				  $tags=str_replace('{','',$tags);
				  $tags=str_replace('}','',$tags);
				  $tags=explode(',',$tags);
				  
				  for ($i=0;$i<count($tags);$i++) { 
					if ($tags[$i]!='') {
					 $descript.=utf8_decode($tags[$i]).','; 
					}
				  }
	  
	
				$ruta='img=../../repositorio/LSE_acepciones/'.$datos['imagen'].'&id_imagen='.$datos['id_imagen'].'&id_palabra='.$datos['id_palabra'];
				$encript->encriptar($ruta,1);	
	
				$descript.='<br /><br /><a href="http://' . $_SERVER['HTTP_HOST'] . '/arasaac/inc/public/descargar.php?i='.$ruta.'"><img src=\'http://'.$_SERVER['HTTP_HOST'].'/arasaac/images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen">&nbsp;Descargar video</a>'; 
				
				$url='http://'.$_SERVER['HTTP_HOST'].'/arasaac/?img='.rawurlencode('id_imagen='.$datos['id_imagen'].'&id_palabra='.$datos['id_palabra']);
				
				$feeds->addItem(new FeedItem($url,$datos['palabra'],$url, utf8_encode($descript)));
			
			} else {
			
				$ruta_img='size=200&ruta=../../repositorio/originales/'.$datos['imagen'];
				$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL		
				$descript='<img src="http://' . $_SERVER['HTTP_HOST'] . '/arasaac/classes/img/thumbnail.php?i='.$ruta_img.'" border="0" title="'.utf8_encode($datos['palabra']).'" align="left">';
				$descript.='<b>'.utf8_decode($datos['palabra']).': </b><em>'.$datos['definicion'].'</em><br /><br />';
				
				
				$descript.="<b>Autor: </b>&nbsp;".$datos['autor'];
				if ($datos['web_autor'] != '') { $descript.='&nbsp;<a href="'.$datos['web_autor'].'" target="_blank"><img src="http://'.$_SERVER['HTTP_HOST'].'/arasaac/images/webexport.png" alt="Visitar p&aacute;gina web" border=0" /></a>'; } 
				if ($datos['email_autor'] != '') { $descript.='&nbsp;<a href="mailto:'.$datos['email_autor'].'"><img src="http://'.$_SERVER['HTTP_HOST'].'/arasaac/images/mail_new.png" alt="Enviar email" border=0" /></a>'; } 
				
				$descript.='<br /><br /><b>Licencia:</b>&nbsp;';
				
				if ($datos['logo_licencia'] != '') { $descript.='<a href="'.$datos['link_licencia'].'" target="_blank"><img src="http://'.$_SERVER['HTTP_HOST'].'/arasaac/images/'.$datos['logo_licencia'].'" alt="'.utf8_encode($datos['licencia']).'" title="'.utf8_encode($datos['licencia']).'" border="0" /></a>';  } 
		  
				 $descript.='<br /><br /><b>Palabras clave: </b>';
				 
				  $tags=str_replace('}{',',',$datos['tags_imagen']);
				  $tags=str_replace('{','',$tags);
				  $tags=str_replace('}','',$tags);
				  $tags=explode(',',$tags);
				  
				  for ($i=0;$i<count($tags);$i++) { 
					if ($tags[$i]!='') {
					 $descript.=utf8_decode($tags[$i]).','; 
					}
				  }
	  
	
				$ruta='img=../../repositorio/originales/'.$datos['imagen'].'&id_imagen='.$datos['id_imagen'].'&id_palabra='.$datos['id_palabra'];
				$encript->encriptar($ruta,1);	
	
				$descript.='<br /><br /><a href="http://' . $_SERVER['HTTP_HOST'] . '/arasaac/inc/public/descargar.php?i='.$ruta.'"><img src=\'http://'.$_SERVER['HTTP_HOST'].'/arasaac/images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen">&nbsp;Descargar imagen</a>'; 
				
				$url='http://'.$_SERVER['HTTP_HOST'].'/arasaac/?img='.rawurlencode('id_imagen='.$datos['id_imagen'].'&id_palabra='.$datos['id_palabra']);
				
				$feeds->addItem(new FeedItem($url,$datos['palabra'],$url, utf8_encode($descript)));
			}
		
		} 
$feeds->display();
break;

case 5: //busqueda por tag

$pictogramas_color=0;
$pictogramas_byn=0;
$fotografia=0;
$simbolos=0;
$videos_lse=0;
$lse_color=0;
$lse_byn=0;

$tag=$_GET['tag'];
$pictogramas_color=$_GET['pc'];
$pictogramas_byn=$_GET['pbyn'];
$fotografia=$_GET['img'];
$simbolos=$_GET['smb'];
$videos_lse=$_GET['vlse'];
$lse_color=$_GET['lsec'];
$lse_byn=$_GET['lsebyn'];

$feeds=new FeedGenerator;
$feeds->setGenerator(new RSSGenerator);
$feeds->setAuthor('CATEDU');
$feeds->setTitle(utf8_encode('ARASAAC: Resultados para el TAG "'.$tag.'"'));
$feeds->setChannelLink('http://catedu.es/arasaac/');
$feeds->setLink('http://catedu.es/arasaac/');
$feeds->setDescription(utf8_encode('Pictogramas asociados al TAG "'.$tag.'"'));
$feeds->setID('http://catedu.es/arasaac/');

$tipos_imagen=$query->listar_tipos_imagen_seleccionados($pictogramas_color,$pictogramas_byn,$fotografia,$videos_lse,$lse_color,$lse_byn);

	while ($salida=mysql_fetch_array($tipos_imagen)) {
	
	$img_disponibles=$query->imagenes_disponibles_tipo_por_tag($tag,$salida['id_tipo']);
	$num_resultados=mysql_num_rows($img_disponibles);
	
		if ($num_resultados > 0) {
		
		$resultados='';
		
			while ($row=mysql_fetch_array($img_disponibles)) {
			
				if ($salida['id_tipo']==11) { //Si el tipo de original es Video de Acepciones en LSE
					
					$resultados=''; 
					
					$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
					$encript->encriptar($ruta_cesto,1);
					
					$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
					$encript->encriptar($ruta,1);
								
						$descript.='<object id="'.$row['id_imagen'].'" width="110" height="125" data="http://' . $_SERVER['HTTP_HOST'] . '/arasaac/plugins/flowplayer/flowplayer-3.1.1.swf"  
						type="application/x-shockwave-flash"> 
						<param name="wmode" value="transparent">
						<param name="movie" value="http://' . $_SERVER['HTTP_HOST'] . '/arasaac/plugins/flowplayer/flowplayer-3.1.1.swf" />  
						<param name="allowfullscreen" value="true" /> 
						 
						<param name="flashvars"  
							value=\'config={"clip": { "url": "http://' . $_SERVER['HTTP_HOST'] . '/arasaac/repositorio/LSE_acepciones/'.$row['imagen'].'", "bufferLength": 2, "autoBuffering": true,
								"autoPlay": false, "scaling": "fit"}, "play": {"replayLabel": "Repetir" }, "plugins": { "controls": {"volume": false, "mute": false, "time":false, "height":15, "backgroundColor": "#FFFFFF", "progressColor": "#000000", "bufferColor": "#CCCCCC" } }  }\' /> 
					   </object>';
					   
					   $descript.='<b>'.utf8_decode($row['palabra']).': </b><em>'.$row['definicion'].'</em><br /><br />';
						
						
						$datos_autor=$query->datos_autor($row['id_autor']);
						
						$descript.="<b>Autor: </b>&nbsp;".$datos_autor['autor'];
						if ($datos_autor['web_autor'] != '') { $descript.='&nbsp;<a href="'.$datos_autor['web_autor'].'" target="_blank"><img src="../images/webexport.png" alt="Visitar p&aacute;gina web" border=0" /></a>'; } 
						if ($datos_autor['email_autor'] != '') { $descript.='&nbsp;<a href="mailto:'.$datos_autor['email_autor'].'"><img src="../images/mail_new.png" alt="Enviar email" border=0" /></a>'; } 
						
						$datos_licencia=$query->datos_licencia($row['id_licencia']);
						
						if ($datos_licencia['logo_licencia'] != '') { $descript.='<br /><br /><b>Licencia:</b><br /><a href="'.$datos_licencia['link_licencia'].'" target="_blank"><img src="../images/'.$datos_licencia['logo_licencia'].'" alt="'.utf8_encode($datos_licencia['licencia']).'" title="'.utf8_encode($datos_licencia['licencia']).'" border="0" /></a>';  } else {  $descript.='<br /><br /><b>Licencia:</b><br />'.utf8_encode($datos_licencia['licencia']); }
				  
						 $descript.='<br /><br /><b>Palabras clave: </b>';
						 
						  $tags=str_replace('}{',',',$row['tags_imagen']);
						  $tags=str_replace('{','',$tags);
						  $tags=str_replace('}','',$tags);
						  $tags=explode(',',$tags);
						  
						  for ($i=0;$i<count($tags);$i++) { 
							if ($tags[$i]!='') {
							 $descript.=utf8_decode($tags[$i]).','; 
							}
						  }
						  
						$descript.='<a href="http://' . $_SERVER['HTTP_HOST'] . '/arasaac/inc/public/descargar.php?i='.$ruta.'"><img src=\'../images/download1.png\' border="0" alt="Descargar imagen" title="Descargar video"></a>';
						
						$url='http://'.$_SERVER['HTTP_HOST'].'/arasaac/?img='.rawurlencode('id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra']);
						
						$feeds->addItem(new FeedItem($url,'TAG: '.$tag,$url,utf8_encode($descript)));
				
				} else { //Para el resto de tipos de Originales
							
						$descript='';
						
						$ruta_img='size=200&ruta=../../repositorio/originales/'.$row['imagen'];
						$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL		
						$descript='<img src="http://' . $_SERVER['HTTP_HOST'] . '/arasaac/classes/img/thumbnail.php?i='.$ruta_img.'" border="0" title="'.utf8_encode($row['palabra']).'" align="left">';
						$descript.='<b>'.utf8_decode($row['palabra']).': </b><em>'.$row['definicion'].'</em><br /><br />';
						
						
						$datos_autor=$query->datos_autor($row['id_autor']);
						
						$descript.="<b>Autor: </b>&nbsp;".$datos_autor['autor'];
						if ($datos_autor['web_autor'] != '') { $descript.='&nbsp;<a href="'.$datos_autor['web_autor'].'" target="_blank"><img src="../images/webexport.png" alt="Visitar p&aacute;gina web" border=0" /></a>'; } 
						if ($datos_autor['email_autor'] != '') { $descript.='&nbsp;<a href="mailto:'.$datos_autor['email_autor'].'"><img src="../images/mail_new.png" alt="Enviar email" border=0" /></a>'; } 
						
						$datos_licencia=$query->datos_licencia($row['id_licencia']);
						
						if ($datos_licencia['logo_licencia'] != '') { $descript.='<br /><br /><b>Licencia:</b><br /><a href="'.$datos_licencia['link_licencia'].'" target="_blank"><img src="../images/'.$datos_licencia['logo_licencia'].'" alt="'.utf8_encode($datos_licencia['licencia']).'" title="'.utf8_encode($datos_licencia['licencia']).'" border="0" /></a>';  } else {  $descript.='<br /><br /><b>Licencia:</b><br />'.utf8_encode($datos_licencia['licencia']); }
				  
						 $descript.='<br /><br /><b>Palabras clave: </b>';
						 
						  $tags=str_replace('}{',',',$row['tags_imagen']);
						  $tags=str_replace('{','',$tags);
						  $tags=str_replace('}','',$tags);
						  $tags=explode(',',$tags);
						  
						  for ($i=0;$i<count($tags);$i++) { 
							if ($tags[$i]!='') {
							 $descript.=utf8_decode($tags[$i]).','; 
							}
						  }
			  
			
						$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
						$encript->encriptar($ruta,1);	
			
						$descript.='<br /><br /><a href="http://' . $_SERVER['HTTP_HOST'] . '/arasaac/inc/public/descargar.php?i='.$ruta.'"><img src=\'../images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen">&nbsp;Descargar imagen</a>'; 
						 
						$url='http://'.$_SERVER['HTTP_HOST'].'/arasaac/?img='.rawurlencode('id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra']);
						
						$feeds->addItem(new FeedItem($url,'TAG: '.$tag,$url,utf8_encode($descript)));
							
				}		
			
			}
		
		
		}
	
	}


$feeds->display();
break;

case 7: // Búsqueda Catálogo ejemplos de uso

$texto_buscar=$_GET['titulo_descripcion'];
$sql='';
		
if (isset($_GET['id_tipo_eu']) && $_GET['id_tipo_eu'] > 0) {  $sql.="AND eu_tipo LIKE '%{".$_GET['id_tipo_eu']."}%' 
			";  }

if (isset($_GET['idiomas']) && $_GET['idiomas'] !='') {  $sql.="AND eu_idiomas LIKE '%{".$_GET['idiomas']."}%' 
			"; }
			
if (isset($_GET['autor']) && $_GET['autor'] !='') {
	$autores=$query->buscar_autores_nombre(utf8_decode($_GET['autor']));
				
		while ($row_autor=mysql_fetch_array($autores)) {
					
			$sql.="AND eu_autor LIKE '%{".$row_autor['id_autor']."}%' 
			"; 
					
		}
}


$feeds=new FeedGenerator;
$feeds->setGenerator(new RSSGenerator); # or AtomGenerator
$feeds->setAuthor('CATEDU');
$feeds->setTitle(utf8_encode('ARASAAC: Buscador de Ejemplos de Uso (RSS)'));
$feeds->setChannelLink('http://arasaac.org/');
$feeds->setLink('http://arasaac.org/');
$feeds->setDescription(utf8_encode('Este canal permite subscribirse a los resultados de una determinada búsqueda realizada en el Catálogo de Ejemplos de Uso'));
$feeds->setID(rand(100000,100000000000000000));

	$resultados=$query->buscar_eu_completo($texto_buscar,$sql);

		while ($datos = mysql_fetch_array($resultados)) {
			
			$autores='';
			$archivos='';
			$mau='';
			$ma='';
			$mau1='';
			$ma1='';
				
			$capturas=''; 
			
			if ($datos['eu_capturas'] != '') {
				
				$capturas='<b>Capturas de Pantalla:</b><br /><br />';
				
					$mcp=str_replace('}{',',',$datos['eu_capturas']);
					$mcp=str_replace('{','',$mcp);
					$mcp=str_replace('}','',$mcp);
					$mcp=explode(',',$mcp);
								  
						for ($i=0;$i<count($mcp);$i++) { 
							if ($mcp[$i]!='') {
								$capturas.="<img src=\"http://arasaac.org/zona_descargas/ejemplos_uso/".$datos['id_eu']."/screenshot/".$mcp[$i]."\"><br />"; 
							}
						}
								  
			}
			
			if ($datos['eu_autor'] != '') { 	
		
			  $autores='<b>Autores:</b><br /><br />';	
			  $mau=str_replace('}{',',',$datos['eu_autor']);
			  $mau=str_replace('{','',$mau);
			  $mau=str_replace('}','',$mau);
			  $mau1=explode(',',$mau);
			  
				  for ($i=0;$i<count($mau1);$i++) { 
					if ($mau1[$i]!='') {
					 $data_autor=$query->datos_autor($mau1[$i]);
					 $autores.=$data_autor['autor'].'<br />'; 
					}
				  }
			  }
			  
			if ($datos['eu_archivos'] != '') { 
		 
		 	$archivos='<b>Archivos:</b><br /><br />';
			  
			  $ma=str_replace('}{',',',$datos['eu_archivos']);
			  $ma=str_replace('{','',$ma);
			  $ma=str_replace('}','',$ma);
			  $ma1=explode(',',$ma);
			  
				  for ($i=0;$i<count($ma1);$i++) { 
					if ($ma1[$i]!='') {
					 $archivos.='<a href="http://catedu.es/arasaac/zona_descargas/ejemplos_uso/'.$datos['id_eu'].'/'.$ma1[$i].'" target="_blank"><img src=\'http://arasaac.org/images/download1.png\' border="0" alt="Descargar archivo" title="Descargar archivo"><a/>&nbsp;&nbsp;<a href="http://catedu.es/arasaac/zona_descargas/ejemplos_uso/'.$datos['id_eu'].'/'.$ma1[$i].'" target="_blank">'.$ma1[$i].'<a/><br /><br />'; 
					}
				  }
			  }
			
			$feeds->addItem(new FeedItem('http://catedu.es/arasaac/ejemplos_uso.php?id_eu='.$datos['id_eu'].'', utf8_encode(utf8_decode($datos['eu_titulo'])), 'http://catedu.es/arasaac/ejemplos_uso.php?id_eu='.$datos['id_eu'].'', utf8_encode(utf8_decode($datos['eu_descripcion']).'<br /><br />'.$autores.'<br /><br />'.$archivos.'<br /><br />'.$capturas.'<br /><br />'.$web)));
	
	}

$feeds->display();
break;

case 8: //Ultimas fichas Software

$feeds=new FeedGenerator;
$feeds->setGenerator(new RSSGenerator);
$feeds->setAuthor('CATEDU');
$feeds->setTitle(utf8_encode('ARASAAC: Últimas fichas de Software'));
$feeds->setChannelLink('http://catedu.es/arasaac/');
$feeds->setLink('http://catedu.es/arasaac/');
$feeds->setDescription(utf8_encode('Este canal da a conocer las últimas fichas añadidas al catálogo de Software que utiliza recursos de ARASAAC.'));
$feeds->setID('http://catedu.es/arasaac/');

		$limit = 10; //noticias a mostrar 
		$inicial=0;
		$res=$query->ultimas_fichas_software_limit($inicial,$limit);
		
		while ($datos = mysql_fetch_array($res)) {
			
			$autores='';
			$archivos='';
			$mau='';
			$ma='';
			$mau1='';
			$ma1='';
			
		if ($datos['software_url1'] != NULL || $datos['software_url2'] != NULL || $datos['software_url1'] != NULL) { 
                 
				 $web='<b>Páginas Web:</b><br />'; 

				  if ($datos['software_url1'] != NULL) { 
				  $web.="<a href=\"".$datos['software_url1']."\" target=\"_blank\"><img src=\"http://arasaac.org/images/weblink_icon.jpg\" alt=\"Visitar página web: ".$datos['software_url1']."\" title=\"Visitar página web: ".$datos['software_url1']."\"></a> <a href=\"".$datos['software_url1']."\" target=\"_blank\">".$datos['software_url1']."</a><br />";
				  }

				  if ($datos['software_url2'] != NULL) { 
				  $web.="<a href=\"".$datos['software_url2']."\" target=\"_blank\"><img src=\"http://arasaac.org/images/weblink_icon.jpg\" alt=\"Visitar página web: ".$datos['software_url2']."\" title=\"Visitar página web: ".$datos['software_url2']."\"></a> <a href=\"".$datos['software_url2']."\" target=\"_blank\">".$datos['software_url2']."</a><br />";
				  }

				  if ($datos['software_url3'] != NULL) { 
				  $web.="<a href=\"".$datos['software_url3']."\" target=\"_blank\"><img src=\"http://arasaac.org/images/weblink_icon.jpg\" alt=\"Visitar página web: ".$datos['software_url3']."\" title=\"Visitar página web: ".$datos['software_url3']."\"></a> <a href=\"".$datos['software_url3']."\" target=\"_blank\">".$datos['software_url3']."</a><br />";
				  }

                 
             }  			
		
			$capturas=''; 
			
			if ($datos['software_capturas'] != '') {
				
				$capturas='<b>Capturas de Pantalla:</b><br /><br />';
				
					$mcp=str_replace('}{',',',$datos['software_capturas']);
					$mcp=str_replace('{','',$mcp);
					$mcp=str_replace('}','',$mcp);
					$mcp=explode(',',$mcp);
								  
								  for ($i=0;$i<count($mcp);$i++) { 
									if ($mcp[$i]!='') {
									 $capturas.="<img src=\"http://arasaac.org/zona_descargas/software/".$datos['id_software']."/screenshot/".$mcp[$i]."\"><br />"; 
									}
								  }
								  
			}
		
		if ($datos['software_autor'] != '') { 	
		
			$autores='<b>Autores:</b><br /><br />';
				
			  $mau=str_replace('}{',',',$datos['software_autor']);
			  $mau=str_replace('{','',$mau);
			  $mau=str_replace('}','',$mau);
			  $mau1=explode(',',$mau);
			  
			  for ($i=0;$i<count($mau1);$i++) { 
				if ($mau1[$i]!='') {
				 $data_autor=$query->datos_autor($mau1[$i]);
				 $autores.=$data_autor['autor'].'<br />'; 
				}
			  }
			  
		  } //Cierro el IF de comprobar si hay autores
		  
	     if ($datos['software_archivos'] != '') { 
		 
		 	$archivos='<b>Archivos:</b><br /><br />'; 
			
			  $ma=str_replace('}{',',',$datos['software_archivos']);
			  $ma=str_replace('{','',$ma);
			  $ma=str_replace('}','',$ma);
			  $ma1=explode(',',$ma);
			  
			  for ($i=0;$i<count($ma1);$i++) { 
				if ($ma1[$i]!='') {
				 $archivos.='<a href="http://catedu.es/arasaac/zona_descargas/softwareo/'.$datos['id_software'].'/'.$ma1[$i].'" target="_blank"><img src=\'http://arasaac.org/images/download1.png\' border="0" alt="Descargar software" title="Descargar software"><a/>&nbsp;&nbsp;<a href="http://catedu.es/arasaac/zona_descargas/software/'.$datos['id_software'].'/'.$ma1[$i].'" target="_blank">'.$ma1[$i].'<a/><br /><br />'; 
				}
			  }
			  
			} //Cierro el IF de comprobar si hay archivos
			
			$feeds->addItem(new FeedItem('http://catedu.es/arasaac/software.php?id_software='.$datos['id_software'].'', utf8_encode(utf8_decode($datos['software_titulo'])), 'http://catedu.es/arasaac/software.php?id_software='.$datos['id_software'].'', utf8_encode(utf8_decode($datos['software_descripcion']).'<br /><br />'.$autores.'<br /><br />'.$archivos.'<br /><br />'.$capturas.'<br /><br />'.$web)));
			
		} 
$feeds->display();
break;	


case 9: //Ultimos ejemplos de uso

$feeds=new FeedGenerator;
$feeds->setGenerator(new RSSGenerator);
$feeds->setAuthor('CATEDU');
$feeds->setTitle(utf8_encode('ARASAAC: Últimos Ejemplos de Uso'));
$feeds->setChannelLink('http://catedu.es/arasaac/');
$feeds->setLink('http://catedu.es/arasaac/');
$feeds->setDescription(utf8_encode('Este canal da a conocer los ultimos ejemplos de uso de los pictogramas e imágenes de ARASAAC en diversos ámbitos.'));
$feeds->setID('http://catedu.es/arasaac/');

		$limit = 10; //noticias a mostrar 
		$inicial=0;
		$res=$query->ultimos_eu_publicados_limit($inicial,$limit);
		
		while ($datos = mysql_fetch_array($res)) {
			
			$autores='';
			$archivos='';
			$mau='';
			$ma='';
			$mau1='';
			$ma1='';
				
			$capturas=''; 
			
			if ($datos['eu_capturas'] != '') {
				
				$capturas='<b>Capturas de Pantalla:</b><br /><br />';
				
					$mcp=str_replace('}{',',',$datos['eu_capturas']);
					$mcp=str_replace('{','',$mcp);
					$mcp=str_replace('}','',$mcp);
					$mcp=explode(',',$mcp);
								  
						for ($i=0;$i<count($mcp);$i++) { 
							if ($mcp[$i]!='') {
								$capturas.="<img src=\"http://arasaac.org/zona_descargas/ejemplos_uso/".$datos['id_eu']."/screenshot/".$mcp[$i]."\"><br />"; 
							}
						}
								  
			}
			
			if ($datos['eu_autor'] != '') { 	
		
			  $autores='<b>Autores:</b><br /><br />';	
			  $mau=str_replace('}{',',',$datos['eu_autor']);
			  $mau=str_replace('{','',$mau);
			  $mau=str_replace('}','',$mau);
			  $mau1=explode(',',$mau);
			  
				  for ($i=0;$i<count($mau1);$i++) { 
					if ($mau1[$i]!='') {
					 $data_autor=$query->datos_autor($mau1[$i]);
					 $autores.=$data_autor['autor'].'<br />'; 
					}
				  }
			  }
			  
			if ($datos['eu_archivos'] != '') { 
		 
		 	$archivos='<b>Archivos:</b><br /><br />';
			  
			  $ma=str_replace('}{',',',$datos['eu_archivos']);
			  $ma=str_replace('{','',$ma);
			  $ma=str_replace('}','',$ma);
			  $ma1=explode(',',$ma);
			  
				  for ($i=0;$i<count($ma1);$i++) { 
					if ($ma1[$i]!='') {
					 $archivos.='<a href="http://catedu.es/arasaac/zona_descargas/ejemplos_uso/'.$datos['id_eu'].'/'.$ma1[$i].'" target="_blank"><img src=\'http://arasaac.org/images/download1.png\' border="0" alt="Descargar archivo" title="Descargar archivo"><a/>&nbsp;&nbsp;<a href="http://catedu.es/arasaac/zona_descargas/ejemplos_uso/'.$datos['id_eu'].'/'.$ma1[$i].'" target="_blank">'.$ma1[$i].'<a/><br /><br />'; 
					}
				  }
			  }
			
			$feeds->addItem(new FeedItem('http://catedu.es/arasaac/ejemplos_uso.php?id_eu='.$datos['id_eu'].'', utf8_encode(utf8_decode($datos['eu_titulo'])), 'http://catedu.es/arasaac/ejemplos_uso.php?id_eu='.$datos['id_eu'].'', utf8_encode(utf8_decode($datos['eu_descripcion']).'<br /><br />'.$autores.'<br /><br />'.$archivos.'<br /><br />'.$capturas.'<br /><br />'.$web)));
			
		} 
$feeds->display();
break;	

case 10: // Búsqueda Catálogo Software

$texto_buscar=$_GET['titulo_descripcion'];
$sql='';
			
	if (isset($_GET['id_tipo_software']) && $_GET['id_tipo_software'] > 0) {  $sql.="AND software_tipo LIKE '%{".$_GET['id_tipo_software']."}%' ";  }
	
	if (isset($_GET['id_so']) && $_GET['id_so'] > 0) {  $sql.="AND software_so LIKE '%{".$_GET['id_so']."}%' ";  }
	
	if (isset($_GET['id_licencia']) && $_GET['id_licencia'] > 0) {  $sql.="AND software_licencia LIKE '%{".$_GET['id_licencia']."}%' ";  }
	
	if (isset($_GET['idiomas']) && $_GET['idiomas'] !='') {  $sql.="AND software_idiomas LIKE '%{".$_GET['idiomas']."}%' "; }
			
	if (isset($_GET['autor']) && $_GET['autor'] !='') {
		$autores=$query->buscar_autores_nombre(utf8_decode($_GET['autor']));
				
			while ($row_autor=mysql_fetch_array($autores)) {
					
				$sql.="AND software_autor LIKE '%{".$row_autor['id_autor']."}%' "; 
					
			}
	}


$feeds=new FeedGenerator;
$feeds->setGenerator(new RSSGenerator); # or AtomGenerator
$feeds->setAuthor('CATEDU');
$feeds->setTitle(utf8_encode('ARASAAC: Buscador de Ejemplos de Uso (RSS)'));
$feeds->setChannelLink('http://arasaac.org/');
$feeds->setLink('http://arasaac.org/');
$feeds->setDescription(utf8_encode('Este canal permite subscribirse a los resultados de una determinada búsqueda realizada en el Catálogo de Ejemplos de Uso'));
$feeds->setID(rand(100000,100000000000000000));

		$limit = 10; //noticias a mostrar 
		$inicial=0;
		
		$resultados=$query->buscar_software_limit(false,$texto_buscar,$sql,$inicial,$limit,'es');

		while ($datos = mysql_fetch_array($resultados)) {
			
			$autores='';
			$archivos='';
			$mau='';
			$ma='';
			$mau1='';
			$ma1='';
			
		if ($datos['software_url1'] != NULL || $datos['software_url2'] != NULL || $datos['software_url1'] != NULL) { 
                 
				 $web='<b>Páginas Web:</b><br />'; 

				  if ($datos['software_url1'] != NULL) { 
				  $web.="<a href=\"".$datos['software_url1']."\" target=\"_blank\"><img src=\"http://arasaac.org/images/weblink_icon.jpg\" alt=\"Visitar página web: ".$datos['software_url1']."\" title=\"Visitar página web: ".$datos['software_url1']."\"></a> <a href=\"".$datos['software_url1']."\" target=\"_blank\">".$datos['software_url1']."</a><br />";
				  }

				  if ($datos['software_url2'] != NULL) { 
				  $web.="<a href=\"".$datos['software_url2']."\" target=\"_blank\"><img src=\"http://arasaac.org/images/weblink_icon.jpg\" alt=\"Visitar página web: ".$datos['software_url2']."\" title=\"Visitar página web: ".$datos['software_url2']."\"></a> <a href=\"".$datos['software_url2']."\" target=\"_blank\">".$datos['software_url2']."</a><br />";
				  }

				  if ($datos['software_url3'] != NULL) { 
				  $web.="<a href=\"".$datos['software_url3']."\" target=\"_blank\"><img src=\"http://arasaac.org/images/weblink_icon.jpg\" alt=\"Visitar página web: ".$datos['software_url3']."\" title=\"Visitar página web: ".$datos['software_url3']."\"></a> <a href=\"".$datos['software_url3']."\" target=\"_blank\">".$datos['software_url3']."</a><br />";
				  }

                 
             }  			
		
			$capturas=''; 
			
			if ($datos['software_capturas'] != '') {
				
				$capturas='<b>Capturas de Pantalla:</b><br /><br />';
				
					$mcp=str_replace('}{',',',$datos['software_capturas']);
					$mcp=str_replace('{','',$mcp);
					$mcp=str_replace('}','',$mcp);
					$mcp=explode(',',$mcp);
								  
								  for ($i=0;$i<count($mcp);$i++) { 
									if ($mcp[$i]!='') {
									 $capturas.="<img src=\"http://arasaac.org/zona_descargas/software/".$datos['id_software']."/screenshot/".$mcp[$i]."\"><br />"; 
									}
								  }
								  
			}
		
		if ($datos['software_autor'] != '') { 	
		
			$autores='<b>Autores:</b><br /><br />';
				
			  $mau=str_replace('}{',',',$datos['software_autor']);
			  $mau=str_replace('{','',$mau);
			  $mau=str_replace('}','',$mau);
			  $mau1=explode(',',$mau);
			  
			  for ($i=0;$i<count($mau1);$i++) { 
				if ($mau1[$i]!='') {
				 $data_autor=$query->datos_autor($mau1[$i]);
				 $autores.=$data_autor['autor'].'<br />'; 
				}
			  }
			  
		  } //Cierro el IF de comprobar si hay autores
		  
	     if ($datos['software_archivos'] != '') { 
		 
		 	$archivos='<b>Archivos:</b><br /><br />'; 
			
			  $ma=str_replace('}{',',',$datos['software_archivos']);
			  $ma=str_replace('{','',$ma);
			  $ma=str_replace('}','',$ma);
			  $ma1=explode(',',$ma);
			  
			  for ($i=0;$i<count($ma1);$i++) { 
				if ($ma1[$i]!='') {
				 $archivos.='<a href="http://catedu.es/arasaac/zona_descargas/softwareo/'.$datos['id_software'].'/'.$ma1[$i].'" target="_blank"><img src=\'http://arasaac.org/images/download1.png\' border="0" alt="Descargar software" title="Descargar software"><a/>&nbsp;&nbsp;<a href="http://catedu.es/arasaac/zona_descargas/software/'.$datos['id_software'].'/'.$ma1[$i].'" target="_blank">'.$ma1[$i].'<a/><br /><br />'; 
				}
			  }
			  
			} //Cierro el IF de comprobar si hay archivos
			
			$feeds->addItem(new FeedItem('http://catedu.es/arasaac/software.php?id_software='.$datos['id_software'].'', utf8_encode(utf8_decode($datos['software_titulo'])), 'http://catedu.es/arasaac/software.php?id_software='.$datos['id_software'].'', utf8_encode(utf8_decode($datos['software_descripcion']).'<br /><br />'.$autores.'<br /><br />'.$archivos.'<br /><br />'.$capturas.'<br /><br />'.$web)));
			
		} 
$feeds->display();
break;



} //Cierro el Switch
?>
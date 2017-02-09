<?php 	
		
		/*   CREO EL CANAL DE SINDICACIÓN DE LOS ULTIMAS NOTICIAS   */
		/* *******************************************/
		$rss = new UniversalFeedCreator();
		$rss->useCached();
		$rss->title = "ARASAAC: Últimas noticias";
		$rss->description = "Este canal da a conocer las ultimas noticias y novedades del Portal Aragonés de la Comunicación Aumentativa y Alternativa de Aragón y relacionadas con el mundo de los SAAC";
		$rss->link = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/";
		$rss->syndicationURL = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/rss/novedades.xml";
		
/*		$image = new FeedImage();
		$image->title = "Ultimos Arablogs creados";
		$image->url = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$blog['imagen_blog'];
		$image->link = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog;
		$image->description = $blog['acerca'];
		$rss->image = $image;*/
		
		$limit = 10; //noticias a mostrar 
		$res=$query->ultimas_noticias_publicadas($limit);
		
		while ($datos = mysql_fetch_array($res)) {
		
		
			$item = new FeedItem();
			$item->title = $datos['titulo'];
			$item->link = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/";
			$item->description = $datos['noticia'];
			//$item->descriptionTruncSize = 3000;
			$item->date =  $gmdate;
			$item->source = $image->link = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/";
		
			
			$item->author = $noticias['nombre'].'&nbsp;'.$noticias['primer_apellido'].'&nbsp;'.$noticias['segundo_apellido'];
			
			$rss->addItem($item);
		
		} 
		
			// valid format strings are: RSS0.91, RSS1.0, RSS2.0, PIE0.1 (deprecated),
			// MBOX, OPML, ATOM, ATOM0.3, HTML, JS
		$rss->saveFeed("RSS2.0", "rss/novedades.xml");
	
	
		/*   CREO EL CANAL DE SINDICACIÓN DE LOS ULTIMOS MATERIALES   */
		/* *******************************************/
		$rss1 = new UniversalFeedCreator();
		$rss1->useCached();
		$rss1->title = "ARASAAC: Últimos materiales";
		$rss1->description = "Este canal da a conocer los ultimos materiales elaborados por colaboradores  del Portal Aragonés de Sistemas de Comunicación Aumentativa y Alternativa con las imágenes y pictogramas distribuídas en el Portal.";
		$rss1->link = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/";
		$rss1->syndicationURL = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/rss/materiales.xml";
		
/*		$image = new FeedImage();
		$image->title = "Ultimos Arablogs creados";
		$image->url = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$blog['imagen_blog'];
		$image->link = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog;
		$image->description = $blog['acerca'];
		$rss1->image = $image;*/
		
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
			
			if ($datos['logo_licencia'] != '') { $licencia='<a href="'.$datos['link_licencia'].'" target="_blank"><img src="../images/'.$datos['logo_licencia'].'" alt="'.utf8_encode($datos['licencia']).'" title="'.utf8_encode($datos['licencia']).'" border="0" /></a>';  } else {  $licencia=utf8_encode($datos['licencia']); }
				
				
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
				 $archivos.='<a href="zona_descargas/materiales/'.$datos['id_material'].'/'.$ma1[$i].'" target="_blank"><img src=\'../images/download1.png\' border="0" alt="Descargar material" title="Descargar material"><a/>&nbsp;&nbsp;<a href="../zona_descargas/materiales/'.$datos['id_material'].'/'.$ma1[$i].'" target="_blank">'.$ma1[$i].'<a/><br /><br />'; 
				}
			  }
			  
		  
		
			$item1 = new FeedItem();
			$item1->title = $datos['material_titulo'];
			$item1->link = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/?id_material=".$datos['id_material'];
			$item1->description = $datos['material_descripcion'].'<br /><br /><b>Licencia:</b><br /><br />'.$licencia.'<br /><br /><b>Autores:</b><br /><br />'.$autores.'<br /><br /><b>Archivos:</b><br /><br />'.$archivos;
			
 
			
			$item1->date =  $gmdate;
			$item1->source = $image->link = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/?id_material=".$datos['id_material'];
			
			$rss1->addItem($item1);
		} 
		
			// valid format strings are: RSS0.91, RSS1.0, RSS2.0, PIE0.1 (deprecated),
			// MBOX, OPML, ATOM, ATOM0.3, HTML, JS
		$rss1->saveFeed("RSS2.0", "rss/materiales.xml");

$pictogramas_color=1;
$pictogramas_byn=1;
$fotografia=1;
$videos_lse=1;
$lse_color=1;
$lse_byn=1;
		
$tipos_imagen=$query->listar_tipos_imagen_seleccionados($pictogramas_color,$pictogramas_byn,$fotografia,$videos_lse,$lse_color,$lse_byn);

while ($salida=mysql_fetch_array($tipos_imagen)) {

		/*   CREO EL CANAL DE SINDICACIÓN            */
		/* *******************************************/
		$rss1 = new UniversalFeedCreator();
		$rss1->useCached();
		$rss1->title = 'ARASAAC: '.$salida['tipo_imagen'];
		$rss1->description = $salida['tipo_imagen'].": Últimas incorporaciones al catálogo de ARASAAC";
		$rss1->link = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/";
		$rss1->syndicationURL = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/rss/".$salida['id_tipo'].".xml";
		
		$limite=50;
		$res2=$query->imagenes_disponibles_solo_por_tipo($salida['id_tipo'],$limite);
		
		while ($datos = mysql_fetch_array($res2)) {
		
			$descript='';
			
			$item = new FeedItem();
			$item->title = utf8_decode($datos['palabra']);
			$item->link = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/?id_imagen=".$datos['id_imagen'];
			
			$ruta_img='size=200&ruta=../../repositorio/originales/'.$datos['imagen'];
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL		
			$descript='<img src="http://' . $_SERVER['HTTP_HOST'] . '/arasaac/classes/img/thumbnail.php?i='.$ruta_img.'" border="0" title="'.utf8_encode($datos['palabra']).'" align="left">';
			$descript.='<b>'.utf8_decode($datos['palabra']).': </b><em>'.$datos['definicion'].'</em><br /><br />';
			
			
			$descript.="<b>Autor: </b>&nbsp;".$datos['autor'];
        	if ($datos['web_autor'] != '') { $descript.='&nbsp;<a href="'.$datos['web_autor'].'" target="_blank"><img src="../images/webexport.png" alt="Visitar p&aacute;gina web" border=0" /></a>'; } 
			if ($datos['email_autor'] != '') { $descript.='&nbsp;<a href="mailto:'.$datos['email_autor'].'"><img src="../images/mail_new.png" alt="Enviar email" border=0" /></a>'; } 
			
			$descript.='<br /><br /><b>Licencia:</b>&nbsp;';
			
			if ($datos['logo_licencia'] != '') { $descript.='<a href="'.$datos['link_licencia'].'" target="_blank"><img src="../images/'.$datos['logo_licencia'].'" alt="'.utf8_encode($datos['licencia']).'" title="'.utf8_encode($datos['licencia']).'" border="0" /></a>';  } 
	  
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

			$descript.='<br /><br /><a href="http://' . $_SERVER['HTTP_HOST'] . '/arasaac/inc/public/descargar.php?i='.$ruta.'"><img src=\'../images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen">&nbsp;Descargar imagen</a>'; 
			
			$item->description = $descript;
			$item->date =  $gmdate;
			//$item->source = $image->link = "http://" . $_SERVER['HTTP_HOST'] . "/arasaac/";
		
			
			$item->author = '';
			
			$rss1->addItem($item);
		
		} 
		
		
		$rss1->saveFeed("RSS2.0", "rss/".$salida['id_tipo'].".xml");


}			
?>
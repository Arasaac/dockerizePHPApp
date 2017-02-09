<?php 		
		$blog=$query->datos_blog($id_blog);
		$datos_canal=$query->datos_canal_podcast($id_blog, $n_canal);
		
		
		$canales=$query->listar_canales_podcast($id_blog);
		
		while ($row=mysql_fetch_array($canales)) {
		
		$base_data=array();
		$base_data['title']=utf8_encode($row['title']);
		$base_data['author']=utf8_encode($blog['blog']);
		$base_data['desc']=utf8_encode($row['description']);
		$base_data['link_url']="http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog;
		$base_data['lang']=$row['language'];
		$base_data['copyright']=$row['copyright'];
		$base_data['owner']=utf8_encode("CATEDU (Centro Aragonés de Tecnologías para la Educación)");
		$base_data['owner_email']="arablogs@catedu.unizar.es";
		$base_data['lastBuildDate']=$row['lastbuild'];
		$base_data['pubDate']=$row['pub'];
		$base_data['link']="http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/xml/podcast_".$row['id_channel'].".xml";
		$base_data['webmaster']=utf8_encode("CATEDU (Centro Aragonés de Tecnologías para la Educación)");
		$base_data['image_link']= "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog;
		$base_data['image_title']=utf8_encode("Podcast del Blog: ".$blog['blog']);
		$base_data['image_url']= "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$blog['imagen_blog'];
		$base_data['nombre_blog']=utf8_encode($blog['blog']);
		$base_data['category']="Education";

		/*   CREO EL CANAL DE SINDICACIÓN POR CANALES  */
		/* *******************************************/
		$podcast = new podcast();
		$header_channel = $podcast->make_xml_podcast_file($base_data);
		
		unset($items);
		$inicial=0;
		$cantidad=10;
		$items=$query->listar_podcast_canales_limit_visibles($id_blog, $row['id_channel'],$inicial,$cantidad);
		unset($item);
		unset($pod);
		unset($xml);
		
			while ($pod=mysql_fetch_array($items)) {
				
				$res=array();
				$res['title']=utf8_encode($pod['title_item']);
				$res['link']=$pod['enclosure_url'];
				$res['desc']=utf8_encode($pod['description_item']);
				$res['pubdate']=$pod['modified'];
				$res['duration']=$pod['duracion'];
				$res['length']=$pod['filesize'];
				
				$item.=$podcast->make_xml_podcast_items($res);
			
			}
		
		$footer = $podcast->make_xml_podcast_footer();
		
		$xml = $header_channel.$item.$footer;

		$t = $podcast->saveFeed("".$guardar.$id_blog."/xml/podcast_".$row['id_channel'].".xml",$xml);
		
		}
		
		
/*   CREO EL CANAL DE SINDICACIÓN PRINCIPAL CON LOS ULTIMOS PODCAST  */
/* ********************************************************************/
		unset($item);
		unset($items);
		unset($cantidad);
		unset($xml);
		unset($header_channel);
		unset($footer);
		unset($pod);
		
		$base_data=array();
		$base_data['title']=utf8_encode("Últimos Podcast del blog: ".$blog['blog']);
		$base_data['author']=utf8_encode($blog['blog']);
		$base_data['desc']=utf8_encode("En este canal se encuentran sindicados los últimos podcast añadidos en el Blog.");
		$base_data['link_url']="http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog;
		$base_data['lang']="ES";
		$base_data['copyright']=date("Y");
		$base_data['owner']=utf8_encode("CATEDU (Centro Aragonés de Tecnologías para la Educación)");
		$base_data['owner_email']="arablogs@catedu.unizar.es";
		$base_data['lastBuildDate']=date("Y-m-d H:m:s");
		$base_data['pubDate']=date("Y-m-d H:m:s");
		$base_data['link']="http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/xml/podcast_general.xml";
		$base_data['webmaster']=utf8_encode("CATEDU (Centro Aragonés de Tecnologías para la Educación)");
		$base_data['image_link']= "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog;
		$base_data['image_title']=utf8_encode("Podcast del Blog: ".$blog['blog']);
		$base_data['image_url']= "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$blog['imagen_blog'];
		$base_data['nombre_blog']=utf8_encode($blog['blog']);
		$base_data['category']="Education";

		/*   CREO EL CANAL DE SINDICACIÓN PRINCIPAL   */
		/* *******************************************/
		$podcast = new podcast();
		$header_channel = $podcast->make_xml_podcast_file($base_data);
		
		$inicial=0;
		$cantidad=10;
		$items=$query->listar_items_limit_visibles($id_blog,$inicial, $cantidad);
		$item='';
		
			while ($pod=mysql_fetch_array($items)) {
				$res=array();
				$res['title']=utf8_encode($pod['title_item']);
				$res['link']=$pod['enclosure_url'];
				$res['desc']=utf8_encode($pod['description_item']);
				$res['pubdate']=$pod['modified'];
				$res['duration']=$pod['duracion'];
				$res['length']=$pod['filesize'];
				
				$item.=$podcast->make_xml_podcast_items($res);
			
			}
			
		$footer = $podcast->make_xml_podcast_footer();
		
		$xml = $header_channel.$item.$footer;

		$t = $podcast->saveFeed("".$guardar.$id_blog."/xml/podcast_general.xml",$xml);
?>
<?php 		
		$blog=$query->datos_blog($id_blog);
		
		/*   CREO EL CANAL DE SINDICACIÓN PRINCIPAL   */
		/* *******************************************/
		$rss = new UniversalFeedCreator();
		$rss->useCached();
		$rss->title = $blog['blog'];
		$rss->description = $blog['acerca'];
		$rss->link = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog;
		$rss->syndicationURL = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/xml/ultimas_noticias.xml";
		
		$image = new FeedImage();
		$image->title = $blog['blog'];
		$image->url = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$blog['imagen_blog'];
		$image->link = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog;
		$image->description = $blog['acerca'];
		$rss->image = $image;
		
		$mostrar = $blog['rss_n_articulos']; //noticias a mostrar 
		$res=$query->ultimos_articulos_publicados($id_blog,$mostrar);
		
		while ($data = mysql_fetch_array($res)) {
		
			if ($data['imagen_1']=="blank.jpg") {
				$img1_left="";
				$img1_center="";
				$img1_right="";
			} else {
				$img1_left="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_1']."\" alt=\"".$salida['imagen_1']."\" align=\"left\">";
				$img1_center="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_1']."\" alt=\"".$salida['imagen_1']."\" align=\"center\">";
				$img1_right="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_1']."\" alt=\"".$salida['imagen_1']."\" align=\"right\">";
			}
			
			if ($data['imagen_2']=="blank.jpg") {
				$img2_left="";
				$img2_center="";
				$img2_right="";
			} else {
				$img2_left="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_2']."\" alt=\"".$salida['imagen_2']."\" align=\"left\">";
				$img2_center="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_2']."\" alt=\"".$salida['imagen_2']."\" align=\"center\">";
				$img2_right="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_2']."\" alt=\"".$salida['imagen_2']."\" align=\"right\">";
			}
	
		
			$txt=$data['parrafo_1'];
		
			$txt1=str_replace( '{{img1||left}}',$img1_left,$txt);
			$txt2=str_replace( '{{img1||center}}',$img1_center,$txt1);
			$txt3=str_replace( '{{img1||right}}',$img1_right,$txt2);
			$txt4=str_replace( '{{img2||left}}',$img2_left,$txt3);
			$txt5=str_replace( '{{img2||center}}',$img2_center,$txt4);
			$txt6=str_replace( '{{img2||right}}',$img2_right,$txt5);
		
			$fecha=$data['fecha_modificacion'];
			$date= explode ("-", $fecha);
			$date2=explode (" ", $date[2]);	
			$hora=explode (":", $date2[1]);
			$gmdate=mktime($hora[0].",".$hora[1].",".$hora[2].",".$date2[0].",".$date[1].",".$date[0]);
			
			$item = new FeedItem();
			$item->title = $data['titulo'];
			$item->link = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog."&id_artc=".$data['id'];
			$item->description = $txt6;
			//$item->descriptionTruncSize = 500;
			$item->date =  $gmdate;
			$item->source = $image->link = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog;
			$item->author = $data['nombre']." ".$data['primer_apellido']." ".$data['segundo_apellido'];
			
			$rss->addItem($item);
			} 
		
			// valid format strings are: RSS0.91, RSS1.0, RSS2.0, PIE0.1 (deprecated),
			// MBOX, OPML, ATOM, ATOM0.3, HTML, JS
			$rss->saveFeed($blog['rss_tipo'], "".$guardar.$id_blog."/xml/ultimas_noticias.xml");
			
		/*   CREO LOS CANALES DE SINDICACIÓN POR CATEGORIAS   */
		/* ****************************************************/
		
		$categ=$query->listar_categorias($id_blog);
		
			while ($row=mysql_fetch_array($categ)) {
					
				$rss = new UniversalFeedCreator();
				$rss->useCached();
				$rss->title = $blog['blog'].". Categoría: ".$row['name'];
				$rss->description = $row['description'];
				$rss->link = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog."&amp;id_categoria=".$row['cat_id'];
				$rss->syndicationURL = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/xml/rss_catg_".$row['cat_id'].".xml";
				
				$image = new FeedImage();
				$image->title = $blog['blog'];
				$image->url = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$blog['imagen_blog'];
				$image->link = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog;
				$image->description = $blog['acerca'];
				$rss->image = $image;
			
				$cat_rss=$query->listar_articulos_categorias_limit_visibles($id_blog, $row['cat_id'],0,$blog['rss_n_articulos']);
		
					while ($data = mysql_fetch_array($cat_rss)) {
					
							if ($data['imagen_1']=="blank.jpg") {
								$img1_left="";
								$img1_center="";
								$img1_right="";
							} else {
								$img1_left="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_1']."\" alt=\"".$salida['imagen_1']."\" align=\"left\">";
								$img1_center="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_1']."\" alt=\"".$salida['imagen_1']."\" align=\"center\">";
								$img1_right="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_1']."\" alt=\"".$salida['imagen_1']."\" align=\"right\">";
							}
							
							if ($data['imagen_2']=="blank.jpg") {
								$img2_left="";
								$img2_center="";
								$img2_right="";
							} else {
								$img2_left="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_2']."\" alt=\"".$salida['imagen_2']."\" align=\"left\">";
								$img2_center="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_2']."\" alt=\"".$salida['imagen_2']."\" align=\"center\">";
								$img2_right="<img src=\"http://" . $_SERVER['HTTP_HOST'] . "/arablogs/repositorio/".$id_blog."/".$data['imagen_2']."\" alt=\"".$salida['imagen_2']."\" align=\"right\">";
							}
					
		
					$txt=$data['parrafo_1'];
				
					$txt1=str_replace( '{{img1||left}}',$img1_left,$txt);
					$txt2=str_replace( '{{img1||center}}',$img1_center,$txt1);
					$txt3=str_replace( '{{img1||right}}',$img1_right,$txt2);
					$txt4=str_replace( '{{img2||left}}',$img2_left,$txt3);
					$txt5=str_replace( '{{img2||center}}',$img2_center,$txt4);
					$txt6=str_replace( '{{img2||right}}',$img2_right,$txt5);
					
					$fecha=$data['fecha_modificacion'];
					$date= explode ("-", $fecha);
					$date2=explode (" ", $date[2]);	
					$hora=explode (":", $date2[1]);
					$gmdate=mktime($hora[0].",".$hora[1].",".$hora[2].",".$date2[0].",".$date[1].",".$date[0]);
					
					$item = new FeedItem();
					$item->title = $data['titulo'];
					$item->link = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog."&id_artc=".$data['id'];
					$item->description = $txt6;
					//$item->descriptionTruncSize = 500;
					$item->date =  $gmdate;
					$item->source = $image->link = "http://" . $_SERVER['HTTP_HOST'] . "/arablogs/blog.php?id_blog=".$id_blog;
					$item->author = $data['nombre']." ".$data['primer_apellido']." ".$data['segundo_apellido'];
					
					$rss->addItem($item);
					
					}
		
			// valid format strings are: RSS0.91, RSS1.0, RSS2.0, PIE0.1 (deprecated),
			// MBOX, OPML, ATOM, ATOM0.3, HTML, JS
			$rss->saveFeed($blog['rss_tipo'], "".$guardar.$id_blog."/xml/rss_catg_".$row['cat_id'].".xml");
		
		}
?>
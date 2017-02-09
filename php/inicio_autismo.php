<?php
//session_start();  // INICIO LA SESION
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
<div id="tabla8">
	<div id="tabla8_celda1">
<div id="caja_noticias">
        	<?php 
			$limit=15;			
			$ultimas_noticias=$query->ultimas_noticias_publicadas($limit);
			echo '<div id="caja_noticias_titulo">'.$translate['ultimas_noticias'].'</div>';
			$i=0;
			?>           
            <ul>
			<?php 
			
			while ($noticias=mysql_fetch_array($ultimas_noticias)) { 
			
			if ($i < 5) {
				
				if ($_SESSION['language']=='es') {
			?>	 		            
	    	<li><a href="noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>"><?php echo $noticias['titulo']; ?></a> <span class="verde_oscuro_little">(<em><?php echo $noticias['fecha_modificacion']; ?></em>)</span> <a href="http://twitter.com/share?url=http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>&text=<?php echo $noticias['titulo']; ?>&original_referer=http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>&via=arasaac" target="_blank"><img src="images/twitter_icon.jpg" border="0"></a> | <div class="fb-like" data-href="http://arasaac.org/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>" data-send="true" data-layout="button_count" data-width="150" data-show-faces="true"></div> | <g:plusone size="small" annotation="inline" width="120" href="http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>"></g:plusone></li>

			<?php 
				$i++;
			
				} else {  
            
                   if ($noticias['titulo_'.$_SESSION['language'].''] !='' && $noticias['noticia_'.$_SESSION['language'].''] !='') {
            ?>

          <!-- Start Main Content -->		 		            
		    <li><a href="noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>"><?php echo $noticias['titulo_'.$_SESSION['language'].'']; ?></a> <span class="verde_oscuro_little">(<em><?php echo $noticias['fecha_modificacion']; ?></em>)</span> <a href="http://twitter.com/share?url=http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>&text=<?php echo $noticias['titulo_'.$_SESSION['language'].'']; ?>&original_referer=http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>&via=arasaac" target="_blank"><img src="images/twitter_icon.jpg" border="0"></a> | <div class="fb-like" data-href="http://arasaac.org/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>" data-send="true" data-layout="button_count" data-width="150" data-show-faces="true"></div> | <g:plusone size="small" annotation="inline" width="120" href="http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>"></g:plusone></li>
		  <!-- End Main Content -->

		<?php  $i++;
		
				} // Cierro el IF de comprobación de si la noticia tiene contenido
        
            } // Cierro el IF de comprobación de si el idioma es castellano
			
			} //Cierro el IF de comprobación de si sed han mostrado 5 noticias
        
        }  // Cierro el While de las Noticias ?>	
 
 		   </ul>
           
           <div id="barra_opciones_inferior"><a href="rss/subscripcion.php?t=2" target="_blank"><img src="images/rss.png" alt="<?php echo $translate['subcribirse_canal_noticias']; ?>" title="<?php echo $translate['subcribirse_canal_noticias']; ?>" width="16" height="16"  /></a> <a href="rss/subscripcion.php?t=2" target="_blank"><?php echo $translate['subcribirse_canal_noticias']; ?></a>
          </div></div>
    </div>

	<div id="tabla8_celda2">
    	<div id="caja_pictos_aleatorios">
        	<?php 			
				$tipos=array(10,5,2,11,12);
				$dia_mes=date("d");
				if(esPar($dia_mes)==true) {
					$n_tipo=0;
				} else {
					$n_tipo=1;
				}
				
				//$n_tipo=rand(0,4);
			?>
        	<div id="caja_pictos_aleatorios_titulo">
			<?php 
			
				switch ($tipos[$n_tipo]) {
					
					case 10:
					echo $translate['ultimos_pictogramas_color']; 
					$web_to_go='pictogramas_color.php';
					break;
					
					case 5:
					echo $translate['ultimos_pictogramas_byn']; 
					$web_to_go='pictogramas_byn.php';
					break;
					
				}

			?></div>
        
        <!-- *************************************************************************************************************************************************  -->
        
        <ul id="thelist7">
		<?php  				
				if ($_SESSION['id_language'] > 0) {
					
					$tipo_pictograma=$tipos[$n_tipo];
					if ($tipo_pictograma==11) { $n_resultados=10; } else { $n_resultados=20; }
					$resultados=$query->listar_pictogramas_idioma_limit_optimizada($_SESSION['AUTHORIZED'],0,$n_resultados,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$_SESSION['id_language'],$tipo_pictograma);
					
				} else {
					
					$tipo_pictograma=$tipos[$n_tipo];
					if ($tipo_pictograma==11) { $n_resultados=10; } else { $n_resultados=20; }
					$resultados=$query->ultimos_pictogramas_limit($n_resultados,$tipo_pictograma,$_SESSION['AUTHORIZED']);
				}
				
				$total_records = mysql_num_rows($resultados);
				
				if ($total_records > 0 ) {
				
				while ($row=mysql_fetch_array($resultados)) {
				
					if ($tipo_pictograma==11) {
						
					$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
					$archivo='repositorio/LSE_acepciones/'.$row['imagen'];
					$imagen='repositorio/LSE_acepciones/'.$row['imagen'];
					$extension = strtolower(substr(strrchr($imagen, "."), 1));
						
					$encript->encriptar($ruta_cesto,1);
				
					$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
					$encript->encriptar($ruta,1);
							
					echo '<li><object id="'.$row['id_imagen'].'" width="70" height="85" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
					type="application/x-shockwave-flash"> 
					 <param name="wmode" value="transparent">
					<param name="movie" value="plugins/flowplayer/flowplayer-3.1.1.swf" />  
					<param name="allowfullscreen" value="true" /> 
					 
					<param name="flashvars"  
						value=\'config={"clip": { "url": "repositorio/LSE_acepciones/'.$row['imagen'].'", "bufferLength": 2, "autoBuffering": true,
							"autoPlay": false, "scaling": "fit"}, "play": {"replayLabel": "'.$translate['repetir'].'" }, "plugins": { "controls": {"volume": false, "mute": false, "time":false, "height":15, "backgroundColor": "#FFFFFF", "progressColor": "#000000", "bufferColor": "#CCCCCC" } }  }\' /> 
				</object></li>';
					
					
					} else { 
					
					$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
					$encript->encriptar($ruta,1);
					
					$ruta_img='size='.$img_size.'&ruta=../../repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
					$encript->encriptar($ruta_cesto,1);
					
					if ($_SESSION['id_language'] > 0) {
			  
						$word=$row['traduccion'];  
						$definition=$row['explicacion'];
				  
					} else {
				  
						$word=utf8_encode($row['palabra']);  
						$definition=$row['definicion'];
				  
					}
			?>
          <li> <a href="ficha.php?id=<?php echo $row['id_imagen']; ?>&id_palabra=<?php echo $row['id_palabra']; ?>"><img src="classes/img/thumbnail.php?i=<?php echo $ruta_img; ?>" alt="<?php echo $translate['hacer_clic_para_acceder_a_la_ficha_de']; ?> <?php echo $word; ?>: <?php if (strlen($definition) > 100) { echo substr (utf8_encode($definition), 0, 100)."..."; } else { echo utf8_encode($definition); } ?>" class="image" title="<?php echo $translate['hacer_clic_para_acceder_a_la_ficha_de']; ?> <?php echo $word; ?>: <?php if (strlen($definition) > 100) { echo substr (utf8_encode($definition), 0, 100)."..."; } else { echo utf8_encode($definition); } ?>" /></a>
          </li>
          <?php } } ?>
	    </ul>
        <?php echo '<div id="barra_opciones_inferior"><a class="grey" href="rss/subscripcion.php?t=4&id_tipo='.$tipos[$n_tipo].'" target="_blank"><img src="images/rss.png" alt="'.$translate['subscribirse_este_catalogo'].'" title="'.$translate['subscribirse_este_catalogo'].'"  /></a> | <a href="'.$web_to_go.'"><small>'.$translate['ver_mas'].'</small></a></div><br />'; 
		
				}  ?>
        
 <!-- *************************************************************************************************************************************************  -->     
 

        </div>
    </div>
    
    <div id="tabla8_celda3">
    	<div id="caja_celda3">
        	<div id="caja_celda3_titulo">
        	  <?php echo $translate['dia_mundial_concienciacion_autismo']; ?>
            </div>
            <p align="center"><a href="http://www.un.org/es/events/autismday/" target="_blank"><img src="images/autismo.png" width="300" height="300" alt="<?php echo $translate['dia_mundial_concienciacion_autismo']; ?>" title="<?php echo $translate['dia_mundial_concienciacion_autismo']; ?>"/></a></p>
		</div>
    </div>

</div>

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
          </div><br />
           <?php echo '<div id="caja_noticias_titulo">'.$translate['siguenos_en'].':</div>';?>
          <br /><a href="http://www.twitter.com/arasaac" target="_blank"><img src="images/logo_twitter.png" alt="<?php echo $translate['siguenos_en']; ?> Twitter" width="75" height="75" border="0" title="<?php echo $translate['siguenos_en']; ?> Twitter"/></a>&nbsp;&nbsp;<a href="https://plus.google.com/111438581918176811433" target="_blank" rel="publisher"><img src="images/google_plus.png" alt="<?php echo $translate['siguenos_en']; ?> Google+" width="75" height="75" title="<?php echo $translate['siguenos_en']; ?> Google+" border="0"/></a>&nbsp;&nbsp;<a href="https://www.facebook.com/pages/Arasaac-Portal-Aragon%C3%A9s-de-la-Comunicaci%C3%B3n-Aumentativa-y-Alternativa/326389010786376" target="_blank"><img src="images/facebook.png" alt="<?php echo $translate['siguenos_en']; ?> Facebook" width="75" height="75" title="<?php echo $translate['siguenos_en']; ?> Facebook" border="0"/></a>&nbsp;&nbsp;<a href="http://pinterest.com/arasaac/" target="_blank"><img src="images/pinterest.jpg" alt="<?php echo $translate['siguenos_en']; ?> Pinterest" width="75" height="75" title="<?php echo $translate['siguenos_en']; ?> Pinterest" border="0"/></a></div>
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
					
					case 2:
					echo $translate['ultimas_fotografias']; 
					$web_to_go='imagenes.php';
					break;
					
					case 11:
					echo $translate['ultimos_videos_lse']; 
					$web_to_go='videos_lse.php';
					break;
					
					case 12:
					echo $translate['ultimos_lse_color']; 
					$web_to_go='signos_lse_color.php';
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
				  
						$word=$row['palabra']; 
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
        	<div id="caja_celda3_titulo"><?php echo $translate['catalogos']; ?></div>
             <ul id="thelist8">
              		<li id="thelist8"><a href="pictogramas_color.php"><img src="images/pict_c.png" alt="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['pictogramas_color']; ?>"   title="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['pictogramas_color']; ?>" /></a><br /><a href="pictogramas_color.php"><?php echo $translate['pictogramas_color']; ?></a>
                    </li>
                    <li id="thelist8"><a href="pictogramas_byn.php"><img src="images/pict_byn.png" alt="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['pictogramas_byn']; ?>"   title="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['pictogramas_byn']; ?>" /></a><br/><a href="pictogramas_byn.php"><?php echo $translate['pictogramas_byn']; ?></a>
                    </li>
                    
                   </li>
                    <li id="thelist8"><a href="software.php"><img src="images/software.png" alt="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['software_minusculas']; ?>"   title="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['software_minusculas']; ?>" /></a><br/><a href="software.php"><?php echo $translate['software_minusculas']; ?></a>
                    </li>
                    
                    <li id="thelist8"><a href="imagenes.php"><img src="images/lphoto.png" alt="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['fotografias']; ?>"  title="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['fotografias']; ?>" /></a><br /><a href="imagenes.php"><?php echo $translate['fotografias']; ?></a>
                    </li>
                                   
                    <li id="thelist8"><a href="videos_lse.php"><img src="images/lse_videos.png" alt="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['videos_lse']; ?>"  title="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['videos_lse']; ?>" /></a><br /><a href="videos_lse.php"><?php echo $translate['videos_lse']; ?></a>
                    </li>
                    
                    <li id="thelist8"><a href="signos_lse_color.php"><img src="images/lse_color.png" alt="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['lse_color']; ?>" width="128" height="128"  title="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['lse_color']; ?>" /></a><br /><a href="signos_lse_color.php"><?php echo $translate['lse_color']; ?></a>
                    </li>
                    
                    <?php if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { ?>
                    <li id="thelist8"><a href="signos_lse_byn.php"><img src="images/lse_byn.png" alt="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['lse_byn']; ?>"   title="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['lse_byn']; ?>" /></a><br /><a href="ultimos_signos_lse_byn.php"><?php echo $translate['lse_byn']; ?></a>
                    </li>
                    
                    <li id="thelist8"><a href="simbolos_arasaac.php"><img src="images/simbolos.png" alt="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['simbolos']; ?>"   title="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['simbolos']; ?>" /></a><br /><a href="ultimos_simbolos_arasaac"><?php echo $translate['simbolos']; ?></a>
                    </li>
                    
                    <li id="thelist8"><a href="cliparts.php"><img src="images/clipart.png" alt="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['cliparts']; ?>"   title="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.$translate['cliparts']; ?>" /></a><br /><a href="ultimos_cliparts.php"><?php echo $translate['cliparts']; ?></a>
                    </li>
                    
                    <?php } ?>
              </ul>
        </div>
    </div>

</div>

<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1); 

if (!isset($_GET['pg'])) {
	$pg = 0; // $pg es la pagina actual
} else { $pg=$_GET['pg']; }
					
	$cantidad=5;
	$inicial = $pg * $cantidad;
					
	$limite_inferior="5"; //resultados por debajo de la pagina actual
	$page_limit = $limite_inferior;
					
	$limitpages = $page_limit;
	$page_limit = $pg + $limitpages;
	
	if ($_SESSION['language']=='es') {
		$contar=$query->listar_noticias();
		$resultados=$query->listar_noticias_limit($inicial,$cantidad);
	} else {
		$contar=$query->listar_noticias_idioma($_SESSION['language']);
		$resultados=$query->listar_noticias_idioma_limit($_SESSION['language'],$inicial,$cantidad);
	}
	
	$total_records = mysql_num_rows($contar);
	$total_pages = intval($total_records/$cantidad);

	require('cabecera_html.php');
	
		if ($_SESSION['language']=='es') {
		$contar=$query->listar_noticias();
		$resultados=$query->listar_noticias_limit($inicial,$cantidad);
	} else {
		$contar=$query->listar_noticias_idioma($_SESSION['language']);
		$resultados=$query->listar_noticias_idioma_limit($_SESSION['language'],$inicial,$cantidad);
	}
	
	$total_records = mysql_num_rows($contar);
	$total_pages = intval($total_records/$cantidad);

	require('cabecera_html.php');

    if (isset($_GET['id_noticia']) && $_GET['id_noticia']>0) {
		$noticias=$query->datos_noticia($_GET['id_noticia']);
					
			if ($_SESSION['language']=='es') {
				echo '<title>ARASAAC - '.$translate['ultimas_noticias'].': '.$noticias['titulo'].'</title>';		
			} else {
				echo '<title>ARASAAC - '.$translate['ultimas_noticias'].': '.$noticias['titulo_'.$_SESSION['language'].''].'</title>';		
			}
	} else {
		echo '<title>ARASAAC: '.$translate['ultimas_noticias'].'</title>';
	}
?>
	<!-- Coloca esta petición de presentación donde creas oportuno. -->
	<script type="text/javascript">
      window.___gcfg = {lang: '<?php echo $_SESSION['language']; ?>'};
    
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
    <link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
     <?php require ('text_size_css.php'); ?>
</head>

<body>
<?php include_once('include_facebook.php'); ?>           
<div class="body_content"> 

	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
        <?php include ('menu_principal.php'); ?>	
        <?php echo '<br /><h4>'.$translate['noticias'].'</h4>'; ?>	
		<div id="principal">
                <br />
                <p align="right"><a href="rss/subscripcion.php?t=2" target="_blank"><?php echo $translate['subcribirse_canal_noticias']; ?></a>&nbsp;&nbsp;<a href="rss/subscripcion.php?t=2" target="_blank"><img src="images/feed.png" alt="<?php echo $translate['subcribirse_canal_noticias']; ?>" title="<?php echo $translate['subcribirse_canal_noticias']; ?>" width="16" height="16" border="0" /></a></p> 
           <?php 
              if (isset($_GET['id_noticia']) && $_GET['id_noticia']>0) {
					$noticias=$query->datos_noticia($_GET['id_noticia']);
					
					if ($_SESSION['language']=='es') {
				 ?>	
                 <!-- Start Main Content -->
				  <div style="border:1px solid #CCCCCC; padding:20px; margin-bottom:20px;">			 		            
					<div id="cabecera_noticia"><?php echo $noticias['titulo']; ?></div>			 
					   <div id="info_noticias"><b><?php echo $translate['escrito_por']; ?>:</b> <em><?php echo utf8_encode($noticias['nombre']).'&nbsp;'.utf8_encode($noticias['primer_apellido']).'&nbsp;'.utf8_encode($noticias['segundo_apellido']); ?></em><b><?php echo $translate['el']; ?></b>&nbsp;<em><?php echo utf8_encode($noticias['fecha_modificacion']); ?></em> 
						 
					</div>
					<p><?php echo $noticias['noticia']; ?></p>
                    <div style="float:left; padding:5px;">
                    	<!-- Coloca esta etiqueta donde quieras que se muestre el botón +1. -->
						<g:plusone size="tall" annotation="inline" width="120" href="http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>"></g:plusone>
                	</div>
                    <div style="float:left; padding:5px;"><a href="http://twitter.com/share" class="twitter-share-button" data-url="http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>" data-text="<?php echo $noticias['titulo']; ?>" data-count="horizontal" data-via="arasaac" data-lang="<?php $_SESSION['language']; ?>">Tweet</a>
				 <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
                 <div style="float:left; padding:5px;">
                 <div class="fb-like" data-href=http://arasaac.org/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>" data-send="true" data-layout="button_count" data-width="150" data-show-faces="true"></div></div></div><p>&nbsp;</p>
                    </div>
					<?php } else { ?>
                      <!-- Start Main Content -->
                      <div style="border:1px solid #CCCCCC; padding:20px; margin-bottom:20px;">			 		            
                        <div id="cabecera_noticia"><?php echo $noticias['titulo_'.$_SESSION['language'].'']; ?></div>			 
                           <div id="info_noticias"><b><?php echo $translate['escrito_por']; ?>:</b> <em><?php echo utf8_encode($noticias['nombre']).'&nbsp;'.utf8_encode($noticias['primer_apellido']).'&nbsp;'.utf8_encode($noticias['segundo_apellido']); ?></em><b><?php echo $translate['el']; ?></b>&nbsp;<em><?php echo utf8_encode($noticias['fecha_modificacion']); ?></em> 
                             
                        </div>
                        <p><?php echo$noticias['noticia_'.$_SESSION['language'].'']; ?></p>
                        <div style="float:left; padding:5px;">
                    	<!-- Coloca esta etiqueta donde quieras que se muestre el botón +1. -->
						<g:plusone size="tall" annotation="inline" width="120" href="http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>"></g:plusone>
                	</div>
                        <div style="float:left; padding:5px;"><a href="http://twitter.com/share" class="twitter-share-button" data-url="http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>" data-text="<?php echo $noticias['titulo_'.$_SESSION['language'].'']; ?>" data-count="horizontal" data-via="arasaac" data-lang="<?php $_SESSION['language']; ?>">Tweet</a>
				 <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
                 <div style="float:left; padding:5px;">
                 <div class="fb-like" data-href=http://arasaac.org/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>" data-send="true" data-layout="button_count" data-width="150" data-show-faces="true"></div></div></div><p>&nbsp;</p>
                    <?php } ?>
					</div>
				  <!-- End Main Content -->
				<?php	
				} else { //Si no está definida la noticia listo todas paginadas 
					while ($noticias=mysql_fetch_array($resultados)) { 
					
					if ($_SESSION['language']=='es') {
					?>
					
				  <!-- Start Main Content -->
				  <div style="border:1px solid #CCCCCC; padding:20px; margin-bottom:20px;">			 		            
					<div id="cabecera_noticia"><?php echo $noticias['titulo']; ?></div>			 
					   <div id="info_noticias"><b><?php echo $translate['escrito_por']; ?>:</b> <em><?php echo utf8_encode($noticias['nombre']).'&nbsp;'.utf8_encode($noticias['primer_apellido']).'&nbsp;'.utf8_encode($noticias['segundo_apellido']); ?></em><b><?php echo $translate['el']; ?></b>&nbsp;<em><?php echo utf8_encode($noticias['fecha_modificacion']); ?></em> 
				</div>
					<p><?php echo $noticias['noticia']; ?></p>
                    <div style="float:left; padding:5px;">
                    	<!-- Coloca esta etiqueta donde quieras que se muestre el botón +1. -->
						<g:plusone size="tall" annotation="inline" width="120" href="http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>"></g:plusone>
                	</div>
						<div style="float:left; padding:5px;"><a href="http://twitter.com/share" class="twitter-share-button" data-url="http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>" data-text="<?php echo $noticias['titulo']; ?>" data-count="horizontal" data-via="arasaac" data-lang="<?php $_SESSION['language']; ?>">Tweet</a>
				 <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
                 <div style="float:left; padding:5px;">
                 <div class="fb-like" data-href=http://arasaac.org/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>" data-send="true" data-layout="button_count" data-width="150" data-show-faces="true"></div></div></div><p>&nbsp;</p>
					</div>
				  <!-- End Main Content -->
		
				<?php } else {  
				
						if ($noticias['titulo_'.$_SESSION['language'].''] !='' && $noticias['noticia_'.$_SESSION['language'].''] !='') {
				?>
		
				  <!-- Start Main Content -->
				  <div style="border:1px solid #CCCCCC; padding:20px; margin-bottom:20px;">			 		            
					<div id="cabecera_noticia"><?php echo $noticias['titulo_'.$_SESSION['language'].'']; ?></div>			 
					   <div id="info_noticias"><b><?php echo $translate['escrito_por']; ?>:</b> <em><?php echo utf8_encode($noticias['nombre']).'&nbsp;'.utf8_encode($noticias['primer_apellido']).'&nbsp;'.utf8_encode($noticias['segundo_apellido']); ?></em><b><?php echo $translate['el']; ?></b>&nbsp;<em><?php echo utf8_encode($noticias['fecha_modificacion']); ?></em> 
				</div>
					<p><?php echo $noticias['noticia_'.$_SESSION['language'].'']; ?></p>
                    <div style="float:left; padding:5px;">
                    	<!-- Coloca esta etiqueta donde quieras que se muestre el botón +1. -->
						<g:plusone size="tall" annotation="inline" width="120" href="http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>"></g:plusone>
                	</div>
                    <div style="float:left; padding:5px;"><a href="http://twitter.com/share" class="twitter-share-button" data-url="http://catedu.es/arasaac/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>" data-text="<?php echo $noticias['titulo_'.$_SESSION['language'].'']; ?>" data-count="horizontal" data-via="arasaac" data-lang="<?php $_SESSION['language']; ?>">Tweet</a>
                             <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
                             <div style="float:left; padding:5px;">
                             <div class="fb-like" data-href=http://arasaac.org/noticias.php?id_noticia=<?php echo $noticias['id_noticia']; ?>" data-send="true" data-layout="button_count" data-width="150" data-show-faces="true"></div></div></div><p>&nbsp;</p>
					</div>
				  <!-- End Main Content -->
		
			<?php  } // Cierro el IF de comprobación de si la noticia tiene contenido
			
				} // Cierro el IF de comprobación de si el idioma es castellano
			
			}  // Cierro el While de las Noticias
			
		} //Cierro el IF de comprobación de si muestra una noticia o se listan todas
		?>	
  	  <div id="numeracion_inferior" align="center">
  	  <?php if (!isset($_GET['id_noticia'])) { 
	  		echo '<span class="verde_oscuro"><strong>'.$translate['resultados']; ?>: </strong><?php echo $inicial ?> - <?php echo $inicial+$cantidad ?> <?php echo '<strong>'.$translate['de'].'</strong>'; ?> <?php echo $total_records ?>
       </span>
	  <?php require('numeracion_inferior.php'); 
	  } //Cierro el IF de comprobación de si se quiere mostrar solo una noticia 
	  ?>
      </div>
<?php include ('footer.php'); ?>
</div>  
</div>
<?php include('google_stats.html'); ?>
</body>
</html>


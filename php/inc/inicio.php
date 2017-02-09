<?php
session_start(); 

include ('../classes/querys/query.php');
$query=new query();
?>
<div class="left_50">
<br />
<h1><a href="javascript:void(0);" onClick='cargar_div("inc/public/quienes_somos.php","i=","right");'><span class="verde_oscuro">Qu&eacute;</span> es ARASAAC ?</a></h1>
<br />
<h1><a href="javascript:void(0);" onClick='cargar_div("inc/public/condiciones_uso.php","i=","right");'><span class="verde_oscuro">Condiciones</span> uso</a></h1>
<br />
<h1><a href="javascript:void(0);" onClick='cargar_div("inc/public/ultimas_noticias.php","i=","right");'><span class="verde_oscuro">&Uacute;ltimas</span> noticias</a></h1>
<br />
<h1><a href="javascript:void(0);" onClick='cargar_div("inc/public/listado_enlaces.php","i=","right");'><span class="verde_oscuro">Otras</span> webs</a></h1>
<br />
<h1><a href="javascript:void(0);" onClick="Dialog.alert({url: 'inc/public/contacta.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:550, height:470}, okLabel: 'Cerrar'});"><span class="verde_oscuro">Contacta</span> con nosotros</a></h1>
<br /><br /><br /><br /><br /><br />
<div align="center">
<img src="images/img01.jpg" />
</div>
<br /><br />
</div>

<div class="right_50">

	<div id="right">
    
   
          
		<?php 
			$limit=5;
			
			if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { 
			
				$ultimas_noticias=$query->ultimas_noticias_publicadas($limit);
				echo '<h4><a href="rss/novedades.xml" target="_blank"><img src="images/feed.png" alt="Canal Novedades" width="16" height="16" border="0" /></a>&nbsp; Ultimas noticias:</h4>';
			
			 } else { 
			 ?>

			<?php 
			echo '<h4><a href="rss/novedades.xml" target="_blank"><img src="images/feed.png" alt="Canal Novedades" width="16" height="16" border="0" /></a>&nbsp; Ultimas noticias:</h4>			<a href="javascript:void(0);" onclick="return GB_show(\'Nueva noticia\', \'inc/noticias/nueva_noticia.php\', 480, 550)"><img src="images/mas.gif" alt="Añadir noticia" border="0" /></a>  <a href="javascript:void(0);" onclick="return GB_show(\'Nueva noticia\', \'inc/noticias/nueva_noticia.php\', 480, 550)">Nueva noticia</a>';
			
				$ultimas_noticias=$query->ultimas_noticias($limit);
				
				} ?>
			<br />
			<?php 
			
			while ($noticias=mysql_fetch_array($ultimas_noticias)) { 
			?>
            
          <!-- Start Main Content -->
		  <div class="maincontent">			 
		       <img src="images/content-top.gif" class="block" alt="" />		 
			    <div class="content-mid">
            
			    <h4><?php echo utf8_encode($noticias['titulo']); ?></h4>			 
		       
				<p><?php echo utf8_encode($noticias['noticia']); ?></p>
                 <br /> 
                <div class="informacion"><b>Escrito por:</b> <em><?php echo utf8_encode($noticias['nombre']).'&nbsp;'.utf8_encode($noticias['primer_apellido']).'&nbsp;'.utf8_encode($noticias['segundo_apellido']); ?></em><b> el</b>&nbsp;<em><?php echo utf8_encode($noticias['fecha_modificacion']); ?></em> </div>
                <br /> 

			<?php if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { ?>
			
			<?php } else { ?>
			  <a href="javascript:void(0);" onclick="return GB_show('Editar noticia', 'inc/noticias/editar_noticia.php?id_noticia=<?php echo $noticias['id_noticia']; ?>&i=<?php echo rand(1000000,9999999); ?>', 480, 550)"><img src="images/edit.gif" alt="Editar noticia" border="0" /></a>
			<?php 
				if ($noticias[6]==0) { echo '<img src="images/no_visible.gif" alt="Articulo no visible" border="0">';  }
				elseif ($noticias[6]==1) { echo '<img src="images/visible.gif" alt=Artículo visible" border="0">'; }
				elseif ($noticias[6]==2) { echo '<img src="images/pendiente_revision.gif" alt=Artículo pendiente de revisión" border="0">'; }
			
			
			} ?>
            
                </div>
                
			 	<img src="images/content-bottom.gif" class="block" alt="" />			
		    </div>
		  <!-- End Main Content -->

			<?php } ?>	
            

         
	</div>

</div>
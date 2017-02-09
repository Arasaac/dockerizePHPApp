<?php 
session_start();  // INICIO LA SESION
require ('../../classes/languages/language_detect.php');
include ('../../classes/querys/query.php');

$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],23);

			$limit=5;
			
			if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { 
			
				$ultimas_noticias=$query->ultimas_noticias_publicadas($limit,$_SESSION['language']);
				echo '<h4>Últimas noticias:</h4>';
			
			 } else { 
			 ?>

			<?php 
			echo '<h4>'.$translate['ultimas_noticias'].':</h4><br /><a href="inc/noticias/nueva_noticia.php" onclick="return GB_showCenter(\''.$translate['nueva_noticia'].'\', this.href)"><img src="images/mas.gif" alt="'.$translate['nueva_noticia'].'" title="'.$translate['nueva_noticia'].'" border="0" /></a>  <a href="inc/noticias/nueva_noticia.php" onclick="return GB_showCenter(\''.$translate['nueva_noticia'].'\', this.href)">'.$translate['nueva_noticia'].'</a><br />';
			
				$ultimas_noticias=$query->ultimas_noticias($limit,$_SESSION['language']);
				
				} ?>
			<br />
            <p align="right"><a href="rss/subscripcion.php?t=2" target="_blank"><?php echo $translate['subcribirse_canal_noticias']; ?></a>&nbsp;&nbsp;<a href="rss/subscripcion.php?t=2" target="_blank"><img src="images/feed.png" alt="<?php echo $translate['subcribirse_canal_noticias']; ?>" title="<?php echo $translate['subcribirse_canal_noticias']; ?>" width="16" height="16" border="0" /></a></p> 
			<?php 
			
			while ($noticias=mysql_fetch_array($ultimas_noticias)) { 
			?>
            
          <!-- Start Main Content -->
		  <div style="border:1px solid #CCCCCC; padding:20px; margin-bottom:20px;">			 		            
		    <div style="background-color:#FF9900; margin-bottom:10px; color:#FFFFFF; font-size:14px; padding:3px; font-weight:bold;"><?php echo utf8_encode($noticias['titulo']); ?></div>			 
		       <div style=" font-size:10px; border-bottom: 1px solid #CCCCCC; margin-bottom:10px;"><b><?php echo $translate['escrito_por']; ?>:</b> <em><?php echo utf8_encode($noticias['nombre']).'&nbsp;'.utf8_encode($noticias['primer_apellido']).'&nbsp;'.utf8_encode($noticias['segundo_apellido']); ?></em><b><?php echo $translate['el']; ?></b>&nbsp;<em><?php echo utf8_encode($noticias['fecha_modificacion']); ?></em> 
		         &nbsp;&nbsp;
		         <?php if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { ?>
                 <?php } else { ?>
                 <a href="inc/noticias/editar_noticia.php?id_noticia=<?php echo $noticias['id_noticia']; ?>&amp;i=<?php echo rand(1000000,9999999); ?>" onclick="return GB_showCenter('<?php echo $translate['editar_noticia']; ?>', this.href)"><img src="images/edit.gif" alt="<?php echo $translate['editar_noticia']; ?>" title="<?php echo $translate['editar_noticia']; ?>" border="0" /></a>
                 <?php 
				if ($noticias[7]==0) { echo '<img src="images/no_visible.gif" alt="'.$translate['noticia_no_visible'].'" title="'.$translate['noticia_no_visible'].'" border="0">';  }
				elseif ($noticias[7]==1) { echo '<img src="images/visible.gif" alt="'.$translate['noticia_visible'].'" title="'.$translate['noticia_visible'].'" border="0">'; }
				elseif ($noticias[7]==2) { echo '<img src="images/pendiente_revision.gif" alt="'.$translate['noticia_pendiente_revision'].'" title="'.$translate['noticia_pendiente_revision'].'" border="0">'; }
			
			
			} ?>
</div>
			<p><?php echo utf8_encode($noticias['noticia']); ?></p>

			</div>
		  <!-- End Main Content -->

<?php } ?>	
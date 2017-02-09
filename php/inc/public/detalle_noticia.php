<?php 
session_start();  // INICIO LA SESION
include ('../../classes/querys/query.php');
$query=new query();
$noticias=$query->datos_noticia($_POST['id_noticia']);
?>			


<div class="left_50">
<?php include ('../menu_lateral.php'); ?>
</div>

<div class="right_50">
	<div id="right">
    
        <p align="right"><a href="rss/subscripcion.php?t=2" target="_blank">Subscribirse al canal de últimas noticias</a>&nbsp;&nbsp;<a href="rss/subscripcion.php?t=2" target="_blank"><img src="images/feed.png" alt="<?php echo utf8_encode("Subscribirse al canal de noticias de ARASAAC"); ?>" title="<?php echo utf8_encode("Subscribirse al canal de noticias de ARASAAC"); ?>" width="16" height="16" border="0" /></a></p> 
                  
                
                  <div style="border:1px solid #CCCCCC; padding:20px; margin-bottom:20px;">			 		            
                    <div style="background-color:#FF9900; margin-bottom:10px; color:#FFFFFF; font-size:14px; padding:3px; font-weight:bold;"><?php echo utf8_encode($noticias['titulo']); ?></div>			 
                       <div style=" font-size:10px; border-bottom: 1px solid #CCCCCC; margin-bottom:10px;"><b>Escrito por:</b> <em><?php echo utf8_encode($noticias['nombre']).'&nbsp;'.utf8_encode($noticias['primer_apellido']).'&nbsp;'.utf8_encode($noticias['segundo_apellido']); ?></em><b> el</b>&nbsp;<em><?php echo utf8_encode($noticias['fecha_modificacion']); ?></em> 
                         &nbsp;&nbsp;
                         <?php if (!isset($_SESSION['AUTHORIZED']) || $_SESSION['AUTHORIZED']== false) { ?>
                         <?php } else { ?>
                         <a href="inc/noticias/editar_noticia.php?id_noticia=<?php echo $noticias['id_noticia']; ?>&amp;i=<?php echo rand(1000000,9999999); ?>" onclick="return GB_showCenter('Editar Noticia', this.href)"><img src="images/edit.gif" alt="Editar noticia" border="0" /></a>
                         <?php 
                        if ($noticias[6]==0) { echo '<img src="images/no_visible.gif" alt="Articulo no visible" border="0">';  }
                        elseif ($noticias[6]==1) { echo '<img src="images/visible.gif" alt=Artículo visible" border="0">'; }
                    	} ?>
       				 </div>
                    <p><?php echo utf8_encode($noticias['noticia']); ?></p>
             </div>
             
             
     </div>
</div>	
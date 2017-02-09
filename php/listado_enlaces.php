<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1); 										
$categorias_enlaces=$query->listar_categorias_enlaces();
$categorias_enlaces_menu=$query->listar_categorias_enlaces();
$destacados=$query->listar_enlaces_destacados();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <META NAME="keywords" CONTENT="saac,aac,Augmentative and alternative communication,educacion especial,catedu,aragón,educación,sistemas aumentativos y alternativos de comunicación,pictograph,pictogramas,pictograms,special education">
    <META NAME="Description" CONTENT="Portal ARASAAC.El portal Aragonés de la Comunicación Aumentativa y Alternativa reune pictogramas, imágenes, materiales y software que facilitan la comunicación de aquellos alumnos con algún tipo de necesidad educativa de comunicación.">
    <META NAME="Author" CONTENT="CATEDU">
    <META NAME="Revisit" CONTENT="8 days">
    <META NAME="Robots" CONTENT="all">
    <META NAME="Language" CONTENT="Spanish">
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <title>ARASAAC: <?php echo $translate['otras_webs']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
    <?php require ('text_size_css.php'); ?>
</head>

<body>
            
<div class="body_content"> 

	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
        <?php include ('menu_principal.php'); ?>
        <?php include ('menu_subprincipal_caa.php'); ?>
		<?php echo '<a name="select" id="select"></a><h4>'.$translate['otras_webs'].'</h4>'; ?>
		<div id="principal">
			<?php 
			echo '<span class="negrita">'.$translate['clasificacion'].':</span>&nbsp;<br /><br />';
			while ($row_categ_menu=mysql_fetch_array($categorias_enlaces_menu)) {
			
				if ($_SESSION['language']=='es') { 
					echo '<a href="#'.$row_categ_menu['id_categoria_enlace'].'" target="_self">'.$row_categ_menu['categoria'].'</a> | ';
				} else {
					echo '<a href="#'.$row_categ_menu['id_categoria_enlace'].'" target="_self">'.$row_categ_menu['categoria_'.$_SESSION['language'].''].'</a> | ';
				}
			}
			
					echo '<br /><br /><div style="border:2px solid #F2F2F2; background: url(images/highlight.gif) top right no-repeat #FFFF99;"><a name="destacados" id="destacados"></a><ul>';
						
						while ($row_destac=mysql_fetch_array($destacados)) {
						
						if ($_SESSION['language']=='es') { 
						
							echo '<li><a href="'.$row_destac['url_enlace'].'" target="_blank">'.$row_destac['enlace'].'</a>';
							if ($row_destac['descripcion_enlace'] !='') { echo ': '.$row_destac['descripcion_enlace']; }
							
						} else {
							
							echo '<li><a href="'.$row_destac['url_enlace'].'" target="_blank">'.$row_destac['enlace_'.$_SESSION['language'].''].'</a>';
							if ($row_destac['descripcion_enlace'] !='') { echo ': '.$row_destac['descripcion_enlace_'.$_SESSION['language'].'']; }
						
						}
						
						  $mid=str_replace('}{',',',$row_destac['idiomas_enlaces']);
						  $mid=str_replace('{','',$mid);
						  $mid=str_replace('}','',$mid);
						  $mid=explode(',',$mid);
						  
						  for ($x=0;$x<count($mid);$x++) { 
							if ($mid[$x]!='') {
								 if ($mid[$x]=='es') {
									echo '&nbsp;<img src="images/spain-flag-icon.png"  alt="'.$translate['spanish'].'" title="'.$translate['spanish'].'">&nbsp;';
								} else {
									$data_idioma=$query->datos_idioma_por_abreviatura($mid[$x]);
									if ($_SESSION['language']=='es') { 
										echo '&nbsp;<img src="images/'.$data_idioma['img_flag'].'" alt="'.$data_idioma['idioma'].'" title="'.$data_idioma['idioma'].'">&nbsp;';
									} else {
										echo '&nbsp;<img src="images/'.$data_idioma['img_flag'].'" alt="'.$data_idioma['idioma_'.$_SESSION['language'].''].'" title="'.$data_idioma['idioma_'.$_SESSION['language'].''].'">&nbsp;';
									}
								} 
								
							} // Cierro el IF 
						  } //Cierro el For
					  
						echo '</li>';				
			
						}
					
					echo '</ul>
					</div><br />';
					
			while ($row_categ=mysql_fetch_array($categorias_enlaces)) {
			
				$enlaces=$query->listar_enlaces_por_categoria($row_categ['id_categoria_enlace']);
			
				if (mysql_num_rows($enlaces) > 0) {
					
					if ($_SESSION['language']=='es') { $nombre_categoria=$row_categ['categoria']; } else { $nombre_categoria=$row_categ['categoria_'.$_SESSION['language'].''];  }
					
					echo '<div style="border:2px solid #F2F2F2;"><a name="'.$row_categ['id_categoria_enlace'].'" id="'.$row_categ['id_categoria_enlace'].'"></a>	
								<div class="otras_web">		 
										<h4>'.$nombre_categoria.'&nbsp;<a href="#select" target="_self"><img src="images/up.gif" alt="'.$translate['menu_webs'].'" title="'.$translate['menu_webs'].'"  /></a></h4>
											<ul>';
										
					while ($row_enlac=mysql_fetch_array($enlaces)) {
							
							if ($_SESSION['language']=='es') { 
								echo '<li><a href="'.$row_enlac['url_enlace'].'" target="_blank">'.$row_enlac['enlace'].'</a>'; 
								if ($row_enlac['descripcion_enlace'] !='') { echo ': '.$row_enlac['descripcion_enlace']; }
							} else {
								echo '<li><a href="'.$row_enlac['url_enlace'].'" target="_blank">'.$row_enlac['enlace_'.$_SESSION['language'].''].'</a>'; 
								if ($row_enlac['descripcion_enlace'] !='') { echo ': '.$row_enlac['descripcion_enlace_'.$_SESSION['language'].'']; }
							}
							
							  $mid=str_replace('}{',',',$row_enlac['idiomas_enlaces']);
							  $mid=str_replace('{','',$mid);
							  $mid=str_replace('}','',$mid);
							  $mid=explode(',',$mid);
							  
							  for ($i=0;$i<count($mid);$i++) { 
									
									if ($mid[$i]!='') {
										 if ($mid[$i]=='es') {
											echo '&nbsp;<img src="images/spain-flag-icon.png" alt="'.$translate['spanish'].'" title="'.$translate['spanish'].'">&nbsp;';
										} else {
											$data_idioma=$query->datos_idioma_por_abreviatura($mid[$i]);
											if ($_SESSION['language']=='es') { 
												echo '&nbsp;<img src="images/'.$data_idioma['img_flag'].'" alt="'.$data_idioma['idioma'].'" title="'.$data_idioma['idioma'].'">&nbsp;';
											} else {
												echo '&nbsp;<img src="images/'.$data_idioma['img_flag'].'" alt="'.$data_idioma['idioma_'.$_SESSION['language'].''].'" title="'.$data_idioma['idioma_'.$_SESSION['language'].''].'">&nbsp;';
											}
										} 
										
									} // Cierro el IF 
								  } //Cierro el For
									
							echo '</li>';				
			
					}
				
					echo '		</ul>
						</div>		
					</div><br />';
				}
			
			}

            ?>
        </div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


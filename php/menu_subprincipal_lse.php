<?php 
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],4); 
?>
<div id="subbar">
<div> 
<a href="lse.php"><?php echo '<span class="negrita">LSE</span>'; ?></a>  
> 
<a href="lse.php"><?php if ($pagina_web=='lse.php') { echo '<span class="negrita">'.$translate['presentacion'].'</span>'; } else { echo $translate['presentacion']; } ?></a>  |  
<a href="nociones_basicas.php"><?php if ($pagina_web=='nociones_basicas.php') { echo '<span class="negrita">'.$translate['nociones_basicas'].'</span>'; } else { echo $translate['nociones_basicas']; } ?></a>  |  
<a href="glosario_terminos.php"><?php if ($pagina_web=='glosario_terminos.php') { echo '<span class="negrita">'.$translate['glosario_terminos'].'</span>'; } else { echo $translate['glosario_terminos']; } ?></a> | 
<a href="consejos_comunicacion.php"><?php if ($pagina_web=='consejos_comunicacion.php') { echo '<span class="negrita">'.$translate['consejos_comunicacion'].'</span>'; } else { echo $translate['consejos_comunicacion']; } ?></a> | 
<a href="sistemas_educativos.php"><?php if ($pagina_web=='sistemas_educativos.php') { echo '<span class="negrita">'.$translate['sistemas_educativos'].'</span>'; } else { echo $translate['sistemas_educativos']; } ?></a> | 
<a href="enlaces_bibliografia_lse.php"><?php if ($pagina_web=='enlaces_bibliografia_lse.php') { echo '<span class="negrita">'.$translate['enlaces_bibliografia_lse'].'</span>'; } else { echo $translate['enlaces_bibliografia_lse']; } ?></a>
</div>
</div>
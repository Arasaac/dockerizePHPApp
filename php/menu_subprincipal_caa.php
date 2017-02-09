<?php 
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1); 
?>
<div id="subbar">
<div>
<a href="software.php"><?php if ($pagina_web=='software.php') { echo '<span class="negrita">'.$translate['SOFTWARE'].'</span>'; } else { echo $translate['SOFTWARE']; } ?></a> |  <a href="listado_enlaces.php"><?php if ($pagina_web=='listado_enlaces.php') { echo '<span class="negrita">'.$translate['otras_webs'].'</span>'; } else { echo $translate['otras_webs']; } ?></a> | 
<a href="bibliografia.php"><?php if ($pagina_web=='bibliografia.php') { echo '<span class="negrita">'.$translate['bibliografia'].'</span>'; } else { echo $translate['bibliografia']; } ?></a> | 
<a href="ejemplos_uso.php"><?php if ($pagina_web=='ejemplos_uso.php') { echo '<span class="negrita">'.$translate['ejemplos_de_uso'].'</span>'; } else { echo $translate['ejemplos_de_uso']; } ?></a> | 
<a href="lse.php"><?php if ($pagina_web=='lse.php') { echo '<span class="negrita">'.$translate['lse'].'</span>'; } else { echo $translate['lse']; } ?></a>
</div>
</div>
<?php 
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],4); 
?>
<div id="subbar">
<div>
<a href="software_comunicacion.php"><?php if ($pagina_web=='software_comunicacion.php') { echo '<span class="negrita">'.$translate['software_comunicacion'].'</span>'; } else { echo $translate['software_comunicacion']; } ?></a> | 
<a href="software_logopedia.php"><?php if ($pagina_web=='software_logopedia.php') { echo '<span class="negrita">'.$translate['logopedia'].'</span>'; } else { echo $translate['logopedia']; } ?></a> | 
<a href="software_accesibilidad_ordenador.php"><?php if ($pagina_web=='software_accesibilidad_ordenador.php') { echo '<span class="negrita">'.$translate['accesibilidad_ordenador'].'</span>'; } else { echo $translate['accesibilidad_ordenador']; } ?></a> |
</div>
</div>
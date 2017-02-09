<?php $pagina_web=strtolower(substr(strrchr($_SERVER['PHP_SELF'], "/"), 1)); ?>
	<div id="bar">
        <a href="index.php"><?php if ($pagina_web=='index.php') { echo '<span class="negrita">'.$translate['inicio'].'</span>'; } else { echo $translate['inicio']; } ?></a><span class="separador_verde">|</span>
        
        <a href="aac.php"><?php if ($pagina_web=='aac.php') { echo '<span class="negrita">'.$translate['que_son_aac'].'</span>'; } else { echo $translate['que_son_aac']; } ?></a><span class="separador_verde">|</span>
                 
        <a href="catalogos.php"><?php if ($pagina_web=='catalogos.php' || $pagina_web=='pictogramas_color.php' || $pagina_web=='pictogramas_byn.php' || $pagina_web=='imagenes.php' || $pagina_web=='videos_lse.php' || $pagina_web=='signos_lse_color.php') { echo '<span class="negrita">'.$translate['catalogos'].'</span>'; } else { echo $translate['catalogos']; } ?></a><span class="separador_verde">|</span>
                    
        <a href="materiales.php"><?php if ($pagina_web=='materiales.php') { echo '<span class="negrita">'.$translate['materiales'].'</span>'; } else { echo $translate['materiales']; } ?></a><span class="separador_verde">|</span> 
        <a href="herramientas.php"><?php if ($pagina_web=='herramientas.php' || $pagina_web=='cesta.php' || $pagina_web=='carpeta_trabajo.php') { echo '<span class="negrita">'.$translate['herramientas'].'</span>'; } else { echo $translate['herramientas']; } ?></a><span class="separador_verde">|</span>	
        <a href="descargas.php"><?php if ($pagina_web=='descargas.php') { echo '<span class="negrita">'.$translate['descargas'].'</span>'; } else { echo $translate['descargas']; } ?></a><span class="separador_verde">|</span>
        
        <a href="software.php"><?php if ($pagina_web=='software.php') { echo '<span class="negrita">'.$translate['software_minusculas'].'</span>'; } else { echo $translate['software_minusculas']; } ?></a><span class="separador_verde">|</span>
        
        <a href="ejemplos_uso.php"><?php if ($pagina_web=='ejemplos_uso.php') { echo '<span class="negrita">'.$translate['ejemplos_de_uso'].'</span>'; } else { echo $translate['ejemplos_de_uso']; } ?></a><span class="separador_verde">|</span>
                
        <a href="noticias.php"><?php if ($pagina_web=='noticias.php') { echo '<span class="negrita">'.$translate['noticias_mayuscula'].'</span>'; } else { echo $translate['noticias_mayuscula']; } ?></a><span class="separador_verde">|</span>
        
        <a href="premios.php"><?php if ($pagina_web=='premios.php') { echo '<span class="negrita">'.$translate['premios'].'</span>'; } else { echo $translate['premios']; } ?></a><span class="separador_verde">|</span><a href="condiciones_uso.php"><?php if ($pagina_web=='condiciones_uso.php') { echo '<span class="negrita">'.$translate['condiciones_uso'].'</span>'; } else { echo $translate['condiciones_uso']; } ?></a><span class="separador_verde">|</span>
		
		<a href="contacta.php"><?php if ($pagina_web=='contacta.php') { echo '<span class="negrita">'.$translate['contacta'].'</span>'; } else { echo $translate['contacta']; } ?></a>
	</div>

	<div id="superior_izquierda">
    	<a href="index.php" target="_self"><img src="images/arasaac.jpg" alt="<?php echo $translate['ir_pagina_inicio']; ?>" title="<?php echo $translate['ir_pagina_inicio']; ?>"  /></a><br /><?php echo $translate['portal_aragones_caa']; ?>
</div>
   
    <div id="superior_derecha">
    <?php 
		//Con este código elimino la variable pg que es dinamica
		$str = $_SERVER['QUERY_STRING'];
		parse_str($str, $info);
		unset($info['l']);
		$cadena_url=http_build_query($info);
		if ($cadena_url !='') { $cadena_url=http_build_query($info).'&'; }
		//************************************************************
	?>
<div id="menu_cabecera"><a href="language_set.php?lan=es">Bienvenido</a> | &nbsp;<a href="language_set.php?lan=en">Welcome</a> | &nbsp;<a href="language_set.php?lan=fr">Bienvenue</a> | &nbsp;<a href="language_set.php?lan=ro">Bun venit</a> | &nbsp;<a href="language_set.php?lan=pt">Bem vindo (PT)</a> | &nbsp;<a href="language_set.php?lan=br">Seja bem vindo (BR)</a></div> <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $cadena_url; ?>l=1"><img src="images/ico_letra_aumentar.png" alt="<?php echo $translate['hacer_clic_aumentar_letra']; ?>" title="<?php echo $translate['hacer_clic_aumentar_letra']; ?>" /></a>&nbsp;<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $cadena_url; ?>l=0"><img src="images/ico_letra_restablecer.png" alt="<?php echo $translate['hacer_clic_restablecer_letra']; ?>" title="<?php echo $translate['hacer_clic_restablecer_letra']; ?>" /></a>&nbsp;<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $cadena_url; ?>l=-1"><img src="images/ico_letra_reducir.png" alt="<?php echo $translate['hacer_clic_disminuir_letra']; ?>" title="<?php echo $translate['hacer_clic_disminuir_letra']; ?>" /></a>&nbsp;<br />
                <div id="menu_cabecera">
                <?php if ($_SESSION['language']=='es') { ?>
                <a href="nube_tags.php"><?php echo $translate['nube_tags']; ?></a>|
                <?php } ?>
                <a href="subscripciones.php"><?php echo $translate['subscripciones']; ?></a>&nbsp;|&nbsp;<a href="cesta.php"><?php echo $translate['mi_seleccion']; ?></a>&nbsp;|&nbsp;<a href="creditos.php"><?php echo $translate['creditos']; ?></a>&nbsp;|&nbsp;<a href="contacta.php"><?php echo $translate['contacta']; ?></a>&nbsp;|&nbsp;<a href="mapa_web.php"><?php echo $translate['mapa_web']; ?></a>&nbsp;|&nbsp;<a href="ayuda.php" target="_self"><?php echo $translate['ayuda']; ?></a></div>
                
    </div>
          
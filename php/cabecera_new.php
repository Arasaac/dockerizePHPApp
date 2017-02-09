<div id="superior_izquierda2">
    <?php 
		//Con este código elimino la variable pg que es dinamica
		$str = $_SERVER['QUERY_STRING'];
		parse_str($str, $info);
		unset($info['l']);
		$cadena_url=http_build_query($info);
		if ($cadena_url !='') { $cadena_url=http_build_query($info).'&'; }
		//************************************************************
	?>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $cadena_url; ?>l=1"><img src="images/ico_letra_aumentar.png" alt="<?php echo $translate['hacer_clic_aumentar_letra']; ?>" title="<?php echo $translate['hacer_clic_aumentar_letra']; ?>" /></a>&nbsp;<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $cadena_url; ?>l=0"><img src="images/ico_letra_restablecer.png" alt="<?php echo $translate['hacer_clic_restablecer_letra']; ?>" title="<?php echo $translate['hacer_clic_restablecer_letra']; ?>" /></a>&nbsp;<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $cadena_url; ?>l=-1"><img src="images/ico_letra_reducir.png" alt="<?php echo $translate['hacer_clic_disminuir_letra']; ?>" title="<?php echo $translate['hacer_clic_disminuir_letra']; ?>" /></a>&nbsp;<br />
                <div id="menu_cabecera">
                </div>
                
</div>

<div id="menu_cabecera2"><a href="language_set.php?lan=es">Bienvenido</a> | <a href="language_set.php?lan=ca">Benvingut</a> |&nbsp;<a href="language_set.php?lan=en">Welcome</a> | &nbsp;<a href="language_set.php?lan=fr">Bienvenue</a> | &nbsp;<a href="language_set.php?lan=ro">Bun venit</a> | &nbsp;<a href="language_set.php?lan=pt">Bem vindo (PT)</a> | &nbsp;<a href="language_set.php?lan=br">Seja bem vindo (BR)</a></div>

<div id="cabecera_principal">
<ul class="col3"> 
<li style="min-width:35%; max-width: 35%; padding-top:10px;"><br /><a href="http://www.aragon.es" target="_blank"><img src="images/logoAragon.jpg" alt="<?php echo $translate['ir_web_dto_educacion']; ?>" width="230" height="55"  title="<?php echo $translate['ir_web_dto_educacion']; ?>" /></a> </li> 
<li style="min-width: 40%; max-width:50%;"> <a href="index.php" target="_self"><img src="images/arasaac_titulo.png" alt="<?php echo $translate['ir_pagina_inicio']; ?>" width="323" height="72" title="<?php echo $translate['ir_pagina_inicio']; ?>"  /></a><br /><?php echo $translate['portal_aragones_caa']; ?></li> 
<li style="float:right; padding-top:10px;"><img src="images/logo_fse.jpg" alt="<?php echo $translate['fondo_social_europeo']; ?>" width="122" height="80" title="<?php echo $translate['fondo_social_europeo']; ?>" /></li> 
</ul> 
</div>      
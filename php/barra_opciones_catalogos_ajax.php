<div id="barra_opciones_superior"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $cadena_url_arbol; ?>arbol=1"><?php echo $translate['arbol_categorias']; ?></a> | <a href="		<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $cadena_url_buscador; ?>buscador=1"><?php echo $translate['busqueda_basica']; ?></a> | <a href="rss/subscripcion.php?t=4&id_tipo=10" target="_blank"><img src="images/rss.png" alt="<?php echo $translate['subscribirse_este_catalogo']; ?>" title="<?php echo $translate['subscribirse_este_catalogo']; ?>" /></a>&nbsp;
<div style="float:right;">
<span class="negrita"><?php echo $translate['mi_seleccion']; ?>:</span> <?php echo '<a href="cesta.php">'.$translate['tengo'].'&nbsp;<b><big><span id="n_cesto"><img src="images/indicator.gif"></span></big></b>&nbsp;'.$translate['elementos_en_mi_cesto'].'</a>'; ?> <span class="separador_verde_punteado">&nbsp;</span><a href="zip_cesto.php"><img src="images/zip_compress_15.png" alt="<?php echo $translate['comprimir_seleccion_zip']; ?>" title="<?php echo $translate['comprimir_seleccion_zip']; ?>" /></a> <a href="javascript:void(0);" onclick="cargar_div2('operaciones_cesto_ajax.php','clear=true','n_cesto');"><img src="images/trash_15.png" alt="<?php echo $translate['vaciar_mi_seleccion']; ?>" border="0" title="<?php echo $translate['vaciar_mi_seleccion']; ?>"/></a>
</div>
</div>
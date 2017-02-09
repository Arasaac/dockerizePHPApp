    <?php  
	$n=0; 
	$peso_total=0;
	
	if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") { 
		foreach ($_SESSION['cart'] as $key => $value) { 
			
			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
            $ruta=$key['ruta_cesto'];
			
			if (file_exists($ruta)) {
				$peso_total=$peso_total+filesize($ruta);
			}

			$n=$n+1; 
		} 
	}
?>
         
<div id="barra_opciones_superior"><a href="<?php echo $pagina; ?>?buscador=2"><?php if ((!isset($_GET['buscador']) && !isset($_GET['id_software'])) || (isset($_GET['buscador']) && $_GET['buscador']==2)) { echo '<b>'.$translate['busqueda_categorias'].'</b>'; } else {  echo $translate['busqueda_categorias'];  } ?></a> | <a href="<?php echo $pagina; ?>?buscador=1"><?php if (isset($_GET['buscador']) && $_GET['buscador']==1 ) { echo '<b>'.$translate['busqueda_basica'].'</b>'; } else { echo $translate['busqueda_basica'];  } ?></a> |<a href="rss/subscripcion.php?t=3" target="_blank"><img src="images/rss.png" alt="<?php echo $translate['subscribirse_catalogo_software']; ?>" title="<?php echo $translate['subscribirse_catalogo_software']; ?>" /></a>&nbsp;<a href="rss/subscripcion.php?t=9" target="_blank"><?php echo $translate['subscribirse']; ?></a>&nbsp;
  <div style="float:right;">
<span class="negrita"><?php echo $translate['mi_seleccion']; ?>:</span> <?php echo '<a href="cesta.php">'.$translate['tengo'].'&nbsp;<span class="negrita"><big><span id="n_cesto">'.$n.'</span></big></span>&nbsp;'.$translate['elementos_en_mi_cesto'].'</a>'; ?> <?php if ($peso_total>0) { echo '&nbsp;('.tamano_archivo($peso_total).')'; } ?> <?php if ($n>0) { ?><span class="separador_verde_punteado">&nbsp;</span><a href="zip_cesto.php"><img src="images/zip_compress_15.png" alt="<?php echo $translate['comprimir_seleccion_zip']; ?>" title="<?php echo $translate['comprimir_seleccion_zip']; ?>" /></a> <a href="<?php echo $PHP_SELF; ?>?clear=true"><img src="images/trash_15.png" alt="<?php echo $translate['vaciar_mi_seleccion']; ?>" border="0" title="<?php echo $translate['vaciar_mi_seleccion']; ?>"/></a><?php } ?>
</div>
</div>
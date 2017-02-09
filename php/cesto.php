<div id="products">	
	<div style="float:left;"><a href="cesta.php">
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

	
	if ($n==0 || $n=='') { ?>
    	<img src="images/box_2.png" alt="<?php echo $translate['ver_mi_seleccion']; ?>" title="<?php echo $translate['ver_mi_seleccion']; ?>" />
    <?php } else { ?>
    	<img src="images/box_3.png" alt="<?php echo $translate['ver_mi_seleccion']; ?>" title="<?php echo $translate['ver_mi_seleccion']; ?>" />
    <?php } ?>
    </a><br />
    </div>
      	
    <div style="float:left; text-align:left; width:55%;"><p><span class="azul_claro"><span class="negrita"><?php echo $translate['mi_seleccion']; ?></span></span></p>
	<?php echo '<a href="cesta.php">'.$translate['tengo'].'&nbsp;<span class="negrita"><big><span id="n_cesto">'.$n.'</span></big></span>&nbsp;'.$translate['elementos_en_mi_cesto'].'</a>'; ?></span> <?php if ($peso_total>0) { echo '<span class="little_10px">('.tamano_archivo($peso_total).')</span>'; } ?> 

           <div id="loading" style="float:right;">
                 <div><img src="images/indicator.gif" alt="<?php echo $translate['cargando']; ?>" title="<?php echo $translate['cargando']; ?>"/></div>
           </div>
                        
    </div>
    
    <div id="flotar_derecha">
           <a href="zip_cesto.php"><img src="images/zip_compress.png" alt="<?php echo $translate['comprimir_seleccion_zip']; ?>" title="<?php echo $translate['comprimir_seleccion_zip']; ?>" /></a> <a href="<?php echo $_SERVER['PHP_SELF']; ?>?clear=true"><img src="images/trash_2.png" alt="<?php echo $translate['vaciar_mi_seleccion']; ?>" border="0" title="<?php echo $translate['vaciar_mi_seleccion']; ?>"/></a>
   </div>

</div>
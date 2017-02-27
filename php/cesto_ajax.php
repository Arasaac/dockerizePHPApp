<div id="products">	
	<div style="float:left;"><a href="cesta.php">
    	<img src="images/box_3.png" alt="<?php echo $translate['ver_mi_seleccion']; ?>" title="<?php echo $translate['ver_mi_seleccion']; ?>" />
    </a><br />
    </div>
      	
    <div style="float:left; text-align:left; width:55%;"><p><span class="azul_claro"><span class="negrita"><?php echo $translate['mi_seleccion']; ?></span></span></p>
	<?php echo '<a href="cesta.php">'.$translate['tengo'].'&nbsp;<big><b><span id="n_cesto"><img src="images/indicator.gif"></span></b></big>&nbsp;'.$translate['elementos_en_mi_cesto'].'</a>'; ?></span>

           <div id="loading" style="float:right;">
                 <div><img src="images/indicator.gif" alt="<?php echo $translate['cargando']; ?>" title="<?php echo $translate['cargando']; ?>"/></div>
           </div>
                        
    </div>
    
    <div id="flotar_derecha">
           <a href="zip_cesto.php"><img src="images/zip_compress.png" alt="<?php echo $translate['comprimir_seleccion_zip']; ?>" title="<?php echo $translate['comprimir_seleccion_zip']; ?>" /></a> <a href="javascript:void(0);" onclick="cargar_div2('operaciones_cesto_ajax.php','clear=true','n_cesto');"><img src="images/trash_2.png" alt="<?php echo $translate['vaciar_mi_seleccion']; ?>" border="0" title="<?php echo $translate['vaciar_mi_seleccion']; ?>"/></a>
   </div>

</div>


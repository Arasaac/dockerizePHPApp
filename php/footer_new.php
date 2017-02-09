<div class="down">
	  		
	    <div class="footer">
         
        <!-- DERECHA -->
        <div style="float:right; margin: 5px; text-align:right;">
		<?php if ($_SESSION['language']=='es') { ?>
                <a href="nube_tags.php"><?php echo $translate['nube_tags']; ?></a>|
                <?php } ?>
                <a href="subscripciones.php"><?php echo $translate['subscripciones']; ?></a>&nbsp;|&nbsp;<a href="cesta.php"><?php echo $translate['mi_seleccion']; ?></a>&nbsp;|&nbsp;<a href="creditos.php"><?php echo $translate['creditos']; ?></a>&nbsp;|&nbsp;<a href="mapa_web.php"><?php echo $translate['mapa_web']; ?></a>&nbsp;|&nbsp;<a href="lse.php">LSE</a>&nbsp;|&nbsp;<a href="ayuda.php" target="_self"><?php echo $translate['ayuda']; ?></a>
        <br />
		<a href="http://catedu.es/aratools/" target="_blank"><img src="images/logo_aratools_128x128.png" alt="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.'Aratools'; ?>" width="45" height="45"  title="<?php echo $translate['hacer_clic_para_acceder_al_catalogo_de'].'&nbsp;'.'Aratools'; ?>" /></a>
        <a href="http://www.twitter.com/arasaac" target="_blank"><img src="images/logo_twitter.png" alt="<?php echo $translate['siguenos_en']; ?> Twitter" width="40" height="40" border="0" title="<?php echo $translate['siguenos_en']; ?> Twitter"/></a>&nbsp;&nbsp;<a href="https://plus.google.com/111438581918176811433" target="_blank" rel="publisher"><img src="images/google_plus.png" alt="<?php echo $translate['siguenos_en']; ?> Google+" width="40" height="40" title="<?php echo $translate['siguenos_en']; ?> Google+" border="0"/></a>&nbsp;&nbsp;<a href="https://www.facebook.com/pages/Arasaac-Portal-Aragon%C3%A9s-de-la-Comunicaci%C3%B3n-Aumentativa-y-Alternativa/326389010786376" target="_blank"><img src="images/facebook.png" alt="<?php echo $translate['siguenos_en']; ?> Facebook" width="40" height="40" title="<?php echo $translate['siguenos_en']; ?> Facebook" border="0"/></a>&nbsp;&nbsp;<a href="http://pinterest.com/arasaac/" target="_blank"><img src="images/pinterest.jpg" alt="<?php echo $translate['siguenos_en']; ?> Pinterest" width="40" height="40" title="<?php echo $translate['siguenos_en']; ?> Pinterest" border="0"/></a>
        </div>
        
        
        <!-- IZQUIERDA -->
        <div style="float:left; margin: 5px;">
          <?php  $datos_licencia=$query->datos_licencia(2); 
                
          if ($_SESSION['id_language'] > 0) { 
          
            echo '<a href="'.$datos_licencia['link_licencia_'.$_SESSION['language'].''].'" target="_blank" rel="license"><img alt="Creative Commons License" title="Creative Commons License" style="border-width:0" src="images/'.$datos_licencia['logo_licencia_big'].'" /></a>';
          
          } else {
          
            echo '<a href="'.$datos_licencia['link_licencia'].'" target="_blank" rel="license"><img alt="Creative Commons License" title="Creative Commons License" style="border-width:0" src="images/'.$datos_licencia['logo_licencia_big'].'" /></a>';
          }
         ?>          
          <img src="images/wcag1AA.gif" width="88" height="31" alt="wcag AA" />
              <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img
            src="http://jigsaw.w3.org/css-validator/images/vcss"
            alt="¡CSS Válido!" width="88" height="31" style="border:0;width:88px;height:31px" />
    	</a>
        <br />
		&copy;  ARASAAC - <?php echo $translate['gobierno_aragon']; ?>, <?php echo date("Y"); ?>
        </div>
        
       </div>
</div>


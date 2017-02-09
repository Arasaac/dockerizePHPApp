<div class="down">
	  		
	    <div class="footer">
         
        <!-- DERECHA -->
        <div style="float:right; margin: 5px; text-align:right;">
		<a href="http://www.educaragon.org" target="_blank"><img src="images/logoAragon.jpg" alt="<?php echo $translate['ir_web_dto_educacion']; ?>" width="230" height="55"  title="<?php echo $translate['ir_web_dto_educacion']; ?>" /></a> 
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
		<br />&copy;  ARASAAC - <?php echo $translate['gobierno_aragon']; ?>, <?php echo date("Y"); ?>
        </div>
        
       </div>
</div>


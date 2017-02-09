<?php echo $translate['explicacion_catalogos']; ?> <br /><br /> 
              <ul id="thelist4">
              		<li id="thelist4"><a href="pictogramas_color.php"><img src="images/pict_c.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['pictogramas_color']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['pictogramas_color']; ?>" /></a><br /><a href="pictogramas_color.php"><?php echo $translate['pictogramas_color']; ?></a>
                    </li>
                    <li id="thelist4"><a href="pictogramas_byn.php"><img src="images/pict_byn.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['pictogramas_byn']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['pictogramas_byn']; ?>" /></a><br/><a href="pictogramas_byn.php"><?php echo $translate['pictogramas_byn']; ?></a>
                    </li>
                    
                    <li id="thelist4"><a href="imagenes.php"><img src="images/lphoto.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['fotografias']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['fotografias']; ?>" /></a><br /><a href="imagenes.php"><?php echo $translate['fotografias']; ?></a>
                    </li>
                                   
                    <li id="thelist4"><a href="videos_lse.php"><img src="images/lse_videos.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['videos_lse']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['videos_lse']; ?>" /></a><br /><a href="videos_lse.php"><?php echo $translate['videos_lse']; ?></a>
                    </li>
                    
                    <li id="thelist4"><a href="signos_lse_color.php"><img src="images/lse_color.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['lse_color']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['lse_color']; ?>" /></a><br /><a href="ultimos_signos_lse_color.php"><?php echo $translate['lse_color']; ?></a>
                    </li>
                    
                    <?php if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { ?>
                    <li id="thelist4"><a href="signos_lse_byn.php"><img src="images/lse_byn.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['lse_byn']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['lse_byn']; ?>" /></a><br /><a href="ultimos_signos_lse_byn.php"><?php echo $translate['lse_byn']; ?></a>
                    </li>
                    
                    <li id="thelist4"><a href="simbolos_arasaac.php"><img src="images/simbolos.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['simbolos']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['simbolos']; ?>" /></a><br /><a href="ultimos_simbolos_arasaac"><?php echo $translate['simbolos']; ?></a>
                    </li>
                    
                    <li id="thelist4"><a href="cliparts.php"><img src="images/clipart.png" alt="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['cliparts']; ?>" width="128" height="128" border="0" title="<?php echo $translate['acceder_catalogo_de'].'&nbsp;'.$translate['cliparts']; ?>" /></a><br /><a href="ultimos_cliparts.php"><?php echo $translate['cliparts']; ?></a>
                    </li>
                    
                    <?php } ?>
              </ul>
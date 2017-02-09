<div id="subbar">
<div><a href="pictogramas_color.php"><?php if ($pagina_web=='pictogramas_color.php') { echo '<span class="negrita">'.$translate['pictogramas_color'].'</span>'; } else { echo $translate['pictogramas_color']; } ?></a>  
| <a href="pictogramas_byn.php"><?php if ($pagina_web=='pictogramas_byn.php') { echo '<span class="negrita">'.$translate['pictogramas_byn'].'</span>'; } else { echo $translate['pictogramas_byn']; } ?></a> 
| <a href="imagenes.php"><?php if ($pagina_web=='imagenes.php') { echo '<span class="negrita">'.$translate['fotografias'].'</span>'; } else { echo $translate['fotografias']; } ?></a> 
| <a href="videos_lse.php"><?php if ($pagina_web=='videos_lse.php') { echo '<span class="negrita">'.$translate['videos_lse'].'</span>'; } else {  echo $translate['videos_lse']; } ?></a>
| <a href="signos_lse_color.php"><?php if ($pagina_web=='signos_lse_color.php') { echo '<span class="negrita">'.$translate['lse_color'].'</span>'; } else { echo $translate['lse_color']; } ?></a>
<?php if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { ?>
| <a href="signos_lse_byn.php"><?php if ($pagina_web=='signos_lse_byn.php') { echo '<span class="negrita">'.$translate['lse_byn'].'</span>'; } else { echo $translate['lse_byn']; } ?></a>
| <a href="simbolos_arasaac.php"><?php if ($pagina_web=='simbolos_arasaac.php') { echo '<span class="negrita">'.$translate['simbolos'].'</span>'; } else {  echo $translate['simbolos']; } ?></a>
| <a href="cliparts.php"><?php if ($pagina_web=='cliparts.php') { echo '<span class="negrita">'.$translate['cliparts'].'</span>';  } else { echo $translate['cliparts']; } ?></a>
<?php }?>
</div>
</div>
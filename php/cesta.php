<?php 
require('requires_basico.php');
require ('funciones/funciones.php');
require ('configuration/key.inc');
require ('classes/crypt/5CR.php');
$encript = new E5CR($llave);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],18); 
require('operaciones_cesto.php');
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['mi_seleccion']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
	<link media="screen" rel="stylesheet" href="js/colorbox/example1/colorbox.css" />
	<script src="js/jQuery/jquery-latest.pack.js"></script>
	<script src="js/colorbox/colorbox/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				$(".iframe").colorbox({width:"95%", height:"99%", iframe:true});
				//Example of preserving a JavaScript event for inline calls.
			});
		</script>
    <?php require ('text_size_css.php'); ?>
</head>

<body>
            
<div class="body_content"> 

	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
      <?php include ('menu_principal.php'); ?>
      <?php include ('menu_subprincipal_herramientas.php'); ?>
      <br /><h4 style="text-transform:uppercase;"><?php echo $translate['mi_seleccion']; ?>:&nbsp;</h4>	
		<div id="principal">
		<div id="flotar_izquierda">	
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
      	
    <div style="float:left; text-align:left;"><p></p><br />
	<?php echo '<a href="cesta.php">'.$translate['tengo'].'&nbsp;<span class="negrita"><big><span id="n_cesto">'.$n.'</span></big></span>&nbsp;'.$translate['elementos_en_mi_cesto'].'</a>'; ?></span> <?php if ($peso_total>0) { echo '<span class="little_10px">('.tamano_archivo($peso_total).')</span>'; } ?> 

           <div id="loading" style="float:right;">
                 <div><img src="images/indicator.gif" alt="<?php echo $translate['cargando']; ?>" title="<?php echo $translate['cargando']; ?>"/></div>
           </div>
                        
    </div>
    
    <div id="flotar_derecha">
           <a href="zip_cesto.php"><img src="images/zip_compress.png" alt="<?php echo $translate['comprimir_seleccion_zip']; ?>" title="<?php echo $translate['comprimir_seleccion_zip']; ?>" /></a> <a href="<?php echo $PHP_SELF; ?>?clear=true"><img src="images/trash_2.png" alt="<?php echo $translate['vaciar_mi_seleccion']; ?>" border="0" title="<?php echo $translate['vaciar_mi_seleccion']; ?>"/></a>
   </div>

		</div>
        <div id="flotar_izquierda"><?php echo $translate['explicacion_mi_seleccion']; ?></div>
            <div id="cart" style="position:relative; width:96%;"> 
                <ul id="thelist1">
                    <?php 
                    if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") {
                        foreach ($_SESSION['cart'] as $key => $value) {
									
                        $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                        $ruta=$key['ruta_cesto'];
                        $ruta_img='size=50&ruta=../../'.$ruta;
                        $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
                        $ruta_cesto='ruta_cesto='.$ruta;
                        $encript->encriptar($ruta_cesto,1); 	
                        
						$extension = strtolower(substr(strrchr($ruta, "."), 1));
						$nombre_archivo=basename($ruta, ".".$extension."");
						$di=$query->datos_imagen_tipo_imagen($nombre_archivo);
						
							if ($extension=='flv') {
							   echo '<li><object id="'.$ruta_cesto.'" width="60" height="75" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
                                type="application/x-shockwave-flash"> 
                                 <param name="wmode" value="transparent">
                                <param name="movie" value="plugins/flowplayer/flowplayer-3.1.1.swf" />  
                                <param name="allowfullscreen" value="true" /> 
                                 
                                <param name="flashvars"  
                                    value=\'config={"clip": { "url": "'.$ruta.'", "bufferLength": 2, "autoBuffering": true,
                                        "autoPlay": false, "scaling": "fit"}, "play": {"replayLabel": "Repetir" }, "plugins": { "controls": {"volume": false, "mute": false, "time":false, "height":15, "backgroundColor": "#FFFFFF", "progressColor": "#000000", "bufferColor": "#CCCCCC" } }  }\' /> 
                        </object></li>';
							} elseif ($extension=='mp3') {
								echo '<li><object type="application/x-shockwave-flash" 
								data="swf/round1.swf?src='.$ruta.'" 
								height="50" width="50">
								<param name="movie"
								value="ruta_del_enlace/angular1.swf?src='.$ruta.'" />
								<param name="quality" value="high" />
								<param name="bgcolor" value="#ffffff" />
								</object><br><a href="'.$PHP_SELF.'?clearProduct=true&id='.$ruta_cesto.'"><img src="images/delete.gif" border="0" alt="'.$translate['eliminar_de_mi_seleccion'].'" title="'.$translate['eliminar_de_mi_seleccion'].'"/></a></li>';
								
							} elseif ($extension=='pdf') {
								echo "<li><img src=\"images/pdf.png\" border=\"0\"/><br><a href=\"".$PHP_SELF."?clearProduct=true&id=".$ruta_cesto."\"><img src=\"images/delete.gif\" border=\"0\" alt=\"".$translate['eliminar_de_mi_seleccion']."\" title=\"".$translate['eliminar_de_mi_seleccion']."\"/></a></li>";
								
							} elseif ($extension=='doc' || $extension=='docx') {
								echo "<li><img src=\"images/doc.png\" border=\"0\"/><br><a href=\"".$PHP_SELF."?clearProduct=true&id=".$ruta_cesto."\"><img src=\"images/delete.gif\" border=\"0\" alt=\"".$translate['eliminar_de_mi_seleccion']."\" title=\"".$translate['eliminar_de_mi_seleccion']."\"/></a></li>";
								
							} elseif ($extension=='ppt' || $extension=='pptx' || $extension=='pps' || $extension=='ppsx') {
								echo "<li><img src=\"images/ppt.png\" border=\"0\"/><br><a href=\"".$PHP_SELF."?clearProduct=true&id=".$ruta_cesto."\"><img src=\"images/delete.gif\" border=\"0\" alt=\"".$translate['eliminar_de_mi_seleccion']."\" title=\"".$translate['eliminar_de_mi_seleccion']."\"/></a></li>";
							
							} elseif ($extension=='wmv' || $extension=='avi' || $extension=='mov' || $extension=='mpg') {
								echo "<li><img src=\"images/wmv.png\" border=\"0\"/><br><a href=\"".$PHP_SELF."?clearProduct=true&id=".$ruta_cesto."\"><img src=\"images/delete.gif\" border=\"0\" alt=\"".$translate['eliminar_de_mi_seleccion']."\" title=\"".$translate['eliminar_de_mi_seleccion']."\"/></a></li>";
							
							} elseif ($extension=='odt') {
								echo "<li><img src=\"images/odt.png\" border=\"0\"/><br><a href=\"".$PHP_SELF."?clearProduct=true&id=".$ruta_cesto."\"><img src=\"images/delete.gif\" border=\"0\" alt=\"".$translate['eliminar_de_mi_seleccion']."\" title=\"".$translate['eliminar_de_mi_seleccion']."\"/></a></li>";
								
							} else {						
								echo '<li><img src="';
								
									if (file_exists('repositorio/thumbs/'.$di['id_tipo_imagen'].'/50/'.$nombre_archivo[0].'/'.$nombre_archivo.'.'.$extension)) { 
									echo 'repositorio/thumbs/'.$di['id_tipo_imagen'].'/50/'.$nombre_archivo[0].'/'.$nombre_archivo.'.'.$extension; 
									
									} else { 
									
									echo 'classes/img/thumbnail.php?i='.$ruta_img.'';
									}
									
								echo "\" border=\"0\"/><br><a href=\"".$PHP_SELF."?clearProduct=true&id=".$ruta_cesto."\"><img src=\"images/delete.gif\" border=\"0\" alt=\"".$translate['eliminar_de_mi_seleccion']."\" title=\"".$translate['eliminar_de_mi_seleccion']."\"/></a></li>";
							}
                        }
                    }
                    ?>
            </ul>
            </div>
</div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


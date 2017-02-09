<?php 
session_start();  // INICIO LA SESION
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
require ('../../../classes/languages/language_detect.php');
include ('../../../classes/querys/query.php');
$query= new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],26); 
echo $translate['explicacion_creador_animaciones'];  			    
?>
<input name="seleccion_cesto" type="hidden" id="seleccion_cesto" size="100" />
	<ul id="thelist2" style="height:280px; overflow:auto; width:100%; border:none; float:left;">
            	<?php 
						$r=0;
								
                           if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") {

                                    foreach ($_SESSION['cart'] as $key => $value) {
                                    
                                    $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                                    $ruta=$key['ruta_cesto'];
                                    $ruta_img='size=30&ruta=../../../../'.$ruta;
                                    $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
                                    $ruta_cesto='ruta_cesto='.$ruta;
                                    $encript->encriptar($ruta_cesto,1); 	
                                    
                                    echo "<li id=\"thelist2_".$r."\" style=\"cursor:pointer; background-color:#FFFFFF;\" onmousemove=\"populateHiddenVars();\"><a href=\"javascript:void(0);\"><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><input name=\"usar[".$r."]\" type=\"checkbox\" value=\"".$ruta_cesto."\" /></li>";
									$r++;
                                    }
                                }
								
						if (isset($_SESSION['carpeta_personal']) && $_SESSION['carpeta_personal'] !="") {
									
                                    foreach ($_SESSION['carpeta_personal'] as $key => $value) {
                                    
                                    $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                                    $ruta=$key['ruta_cesto'];
                                    $ruta_img='size=30&ruta=../../../../'.$ruta;
                                    $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
                                    $ruta_cesto='ruta_cesto='.$ruta;
                                    $encript->encriptar($ruta_cesto,1); 	
                                    
                                    echo "<li id=\"thelist2_".$r."\" style=\"cursor:pointer; background-color:#FFFFFF;\" onmousemove=\"populateHiddenVars();\"><a href=\"javascript:void(0);\"><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><input name=\"usar[".$r."]\" type=\"checkbox\" value=\"".$ruta_cesto."\" /></li>";
									$r++;
                                    }
                            }
					?>
            </ul>
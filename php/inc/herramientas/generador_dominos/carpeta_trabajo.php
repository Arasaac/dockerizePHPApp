<?php 
session_start();  // INICIO LA SESION
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
require ('../../../classes/languages/language_detect.php');
include ('../../../classes/querys/query.php');
$query= new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],26); 			    
?>
<?php echo $translate['explicacion_ejercicios_paso_1']; ?> 
<br /> 
<input name="seleccion_cesto" type="hidden" id="seleccion_cesto" size="100" />
                  <input name="boton_seleccionar_todos" type="button" value="<?php echo $translate['seleccionar_todos']; ?>" class="boton_mediano" onclick="selydestodos(document.seleccion_simbolos,1)"/>
            <input name="boton_seleccionar_todos" type="button" value="<?php echo $translate['deseleccionar_todos']; ?>" class="boton_mediano" onclick="selydestodos(document.seleccion_simbolos,0)"/>
            
                  <ul id="thelist2" style="height:980px; overflow:auto; width:100%; border:none; float:left;">
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
									$extension = strtolower(substr(strrchr($ruta, "."), 1));

									$filename=array_pop(explode('/',$ruta));
									$filaname1=explode('.',$filename);
									$filaname2=$filaname1[0];
									
									$palabras_asociadas=$query->buscar_palabras_asociadas_imagen($filaname2);
					
									$pa=mysql_fetch_array($palabras_asociadas);
						
									$palabra_es= $pa['palabra'];

									if ($extension=='jpg' || $extension=='png' || $extension=='gif' || $extension=='jpeg' || $extension=='JPG' || $extension=='GIF' ||$extension=='PNG') {
											echo "<li id=\"thelist2_".$r."\" style=\"cursor:pointer; background-color:#FFFFFF;\" onmousemove=\"populateHiddenVars();\"><a href=\"javascript:void(0);\"><img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><input name=\"usar[".$r."]\" type=\"checkbox\" value=\"".$ruta_cesto."\" /><input name=\"name[".$r."]\" type=\"text\" value=\"".$palabra_es."\"value=\"40\" size=\"11\" /></li>";
										$r++;
										}
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
                                    
                                    echo "<li id=\"thelist2_".$r."\" style=\"cursor:pointer; background-color:#FFFFFF;\" onmousemove=\"populateHiddenVars();\"><a href=\"javascript:void(0);\"><img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br><input name=\"usar[".$r."]\" type=\"checkbox\" value=\"".$ruta_cesto."\" /><input name=\"name[".$r."]\" type=\"text\" value=\"\"value=\"40\" size=\"11\" /></li>";
									$r++;
                                    }
                                }
                                ?>
                    </ul>
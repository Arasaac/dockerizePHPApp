<?php 
session_start();  // INICIO LA SESION
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

require ('../../../classes/languages/language_detect.php');
include ('../../../classes/querys/query.php');
$query= new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],2); 
?>
	<ul id="thelist2" style="height:280px; overflow:auto; width:100%; border:none; float:left;">
            	<?php 
					 if (isset($_SESSION['carpeta_personal']) && $_SESSION['carpeta_personal'] !="") {
							$r=99999;	
                               foreach ($_SESSION['carpeta_personal'] as $key => $value) {
                                    									
                                    $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                                    $ruta=$key['ruta_cesto'];
                                    $ruta_img='size=70&ruta=../../../../'.$ruta;
                                    $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
                                    $ruta_cesto='ruta_cesto='.$ruta;
                                    $encript->encriptar($ruta_cesto,1); 
									
									$origen=explode("/",$ruta);
									
									
									if ($origen[0]=='repositorio' && $origen[1]=='originales') {  
									
									    $n_img=explode(".",$origen[2]);
									
										$datos_img=$query->datos_imagen($n_img[0]);
									
										$ruta_usar_img="img=".$ruta."&id_palabra=".$datos_img['id_palabra'];
																			
										$encript->encriptar($ruta_usar_img,1);                             
                                   		
										echo '<li id="thelist2_'.$r.'"><a href="creador_simbolos.php?i='.$ruta_usar_img.'" target="_self"><img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="'.$translate['hacer_clic_para_creador'].'" border="0"></a></li>';
										
									} elseif ($origen[0]=='temp') {
									
									     $ruta_usar_img="img=".$ruta;
										 $encript->encriptar($ruta_usar_img,1);   
										 
										 echo '<li id="thelist2_'.$r.'"><a href="creador_simbolos.php?i='.$ruta_usar_img.'" target="_self"><img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="'.$translate['hacer_clic_para_creador'].'" title="'.$translate['hacer_clic_para_creador'].'" border="0"></a></li>';
									
									}
									
									$r++;
                               }
                          }
					?>
            </ul>
<?php 
session_start();
require_once('classes/crypt/5CR.php');
require_once('configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

require('funciones/funciones.php');
require('classes/zip/zip_min.inc.php');

include ('classes/querys/query.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],19);

$timestamp=time();
$fecha=date("d-m-Y",$timestamp);
		
$dir="temp/";
$borrar=CleanFiles($dir); //Borro los archivos temporales
$nombre_zip=basename(tempnam("temp",'tmp')); 

$file = $nombre_zip.'.zip';

$zipfile = new zipfile();
$a_descargar=$dir.$file;

$nombres_archivos=array();
$nombres_archivos_mp3=array();

if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") {
	
	foreach ($_SESSION['cart'] as $key => $value) {
	
			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
			$ruta=$key['ruta_cesto'];		
			$extension=substr(strrchr($ruta,'.'),1);
			$filename=array_pop(explode('/',$ruta));
			$filaname1=explode('.',$filename);
			$filaname2=$filaname1[0];
			$path=explode('/',$ruta);
			
			if ($extension == 'png' || $extension == 'jpg' || $extension == 'flv' || $extension == 'gif') { 
			
				if ($path[0] !='temp') { 
				
				  if ($_SESSION['id_language'] > 0) {
					
					$palabras_asociadas=$query->buscar_palabras_asociadas_imagen($filaname2);
					
					while ($pa=mysql_fetch_array($palabras_asociadas)) {
						
						$traducciones=$query->buscar_traduccion($pa['id_palabra'],$_SESSION['id_language']);
						
						if (mysql_num_rows($traducciones) > 0) { // Si hay traducciones
							while ($rowt=mysql_fetch_array($traducciones)) { 
								
								$archivo1=$rowt['traduccion'].".".$extension;
								
									if (in_array($archivo1,$nombres_archivos)) {
										
										for ($i = 1; $i <= 1000; $i++) {
											$archivo1=$rowt['traduccion']."_".$i.".".$extension;
											if (!in_array($archivo1,$nombres_archivos)) { $nombres_archivos[]=$archivo1; break; }
										}
										
									} else {
										$nombres_archivos[]=$archivo1;
									}
								
								$zipfile -> addFile(file_get_contents($ruta), iconv("UTF-8", "CP850", $archivo1));
							}
						} else { 
						
							$archivo1= $pa['palabra']."_es.".$extension;
							
							if (in_array($archivo1,$nombres_archivos)) {
										
								for ($i = 1; $i <= 1000; $i++) {
									$archivo1=$pa['palabra']."_es_".$i.".".$extension; 
									if (!in_array($archivo1,$nombres_archivos)) { $nombres_archivos[]=$archivo1; break; }
								}
										
							} else {
								$nombres_archivos[]=$archivo1;
							}

							$zipfile -> addFile(file_get_contents($ruta), iconv("UTF-8", "CP850", $archivo1));
						}
					
					}
													 
				} else {
					
					$palabras_asociadas=$query->buscar_palabras_asociadas_imagen($filaname2);
					
					while ($pa=mysql_fetch_array($palabras_asociadas)) {
						
						$archivo1= $pa['palabra'].".".$extension;
						
							if (in_array($archivo1,$nombres_archivos)) {
										
								for ($i = 1; $i <= 1000; $i++) {
									$archivo1=$pa['palabra']."_".$i.".".$extension; 
									if (!in_array($archivo1,$nombres_archivos)) { $nombres_archivos[]=$archivo1; break; }
								}
										
							} else {
								$nombres_archivos[]=$archivo1;
							}
							
						$zipfile -> addFile(file_get_contents($ruta), iconv("UTF-8", "CP850", $archivo1));
					
					}
						
				}
				
				} elseif ($path[0] =='temp') { //SI LA RUTA ES DE LA CARPETA TEMPORAL
					
					$zipfile -> addFile(file_get_contents($ruta), $filename);
				
				} else {
					
					$zipfile -> addFile(file_get_contents($ruta), $filename);
				}
				
			} elseif ($extension == 'mp3') {
			
				$cortar=explode('/',$ruta);
				$datos_idioma=$query->datos_idioma_completo($cortar[2]);
				
				if ($_SESSION['id_language'] > 0) {
					
					if ($cortar[2]==0) { // SI LA LOCUCION ES EN CASTELLANO
						
						$dt=$query->datos_traduccion($filaname2,$_SESSION['id_language']);
						
						if (!is_array($dt)) {
							$datos_palabra=$query->datos_palabra($filaname2);	
							$archivo1= $datos_palabra['palabra']."_es.".$extension;
							
							if (in_array($archivo1,$nombres_archivos_mp3)) {
										
								for ($i = 1; $i <= 1000; $i++) {
									$archivo1=$datos_palabra['palabra']."_es_".$i.".".$extension; 
									if (!in_array($archivo1,$nombres_archivos_mp3)) { $nombres_archivos_mp3[]=$archivo1; break; }
								}
										
							} else {
								$nombres_archivos_mp3[]=$archivo1;
							}
							
							$zipfile -> addFile(file_get_contents($ruta), iconv("UTF-8", "CP850", $archivo1));
						} else {
							$archivo1= $dt['traduccion']."_es.".$extension;
							$nombres_archivos_mp3[]=$archivo1;
							
							if (in_array($archivo1,$nombres_archivos_mp3)) {
										
								for ($i = 1; $i <= 1000; $i++) {
									$archivo1=$dt['traduccion']."_es_".$i.".".$extension; 
									if (!in_array($archivo1,$nombres_archivos_mp3)) { $nombres_archivos_mp3[]=$archivo1; break; }
								}
										
							} else {
								$nombres_archivos_mp3[]=$archivo1;
							}
							
							$zipfile -> addFile(file_get_contents($ruta), iconv("UTF-8", "CP850", $archivo1));
						}
					
					} else { // SI ES EN OTRO IDIOMA
						$dt=$query->datos_traduccion($filaname2,$_SESSION['id_language']);
						$bt=$query->buscar_traduccion($dt['id_palabra'],$_SESSION['id_language']);
						
						while ($row_traducciones=mysql_fetch_array($bt)) {
							if ($datos_idioma['id_idioma']==$_SESSION['id_language']) {
								$archivo1= $row_traducciones['traduccion'].".".$extension;
								
									if (in_array($archivo1,$nombres_archivos_mp3)) {
										
										for ($i = 1; $i <= 1000; $i++) {
											$archivo1=$row_traducciones['traduccion']."_".$i.".".$extension; 
											if (!in_array($archivo1,$nombres_archivos_mp3)) { $nombres_archivos_mp3[]=$archivo1; break; }
										}
												
									} else {
										$nombres_archivos_mp3[]=$archivo1;
									}
							
							} else {
								$archivo1= $row_traducciones['traduccion']."_".$datos_idioma['idioma_abrev'].".".$extension;
								
									if (in_array($archivo1,$nombres_archivos_mp3)) {
										
										for ($i = 1; $i <= 1000; $i++) {
											$archivo1=$row_traducciones['traduccion']."_".$datos_idioma['idioma_abrev']."_".$i.".".$extension; 
											if (!in_array($archivo1,$nombres_archivos_mp3)) { $nombres_archivos_mp3[]=$archivo1; break; }
										}
												
									} else {
										$nombres_archivos_mp3[]=$archivo1;
									}
									
							}
							$zipfile -> addFile(file_get_contents($ruta), iconv("UTF-8", "CP850", $archivo1));
						}
					}
					
													 
				} else {
					
					if ($cortar[2]==0) {
						
						$datos_palabra=$query->datos_palabra($filaname2);	
						$archivo1= $datos_palabra['palabra'].".".$extension;
						
							if (in_array($archivo1,$nombres_archivos_mp3)) {
										
								for ($i = 1; $i <= 1000; $i++) {
									$archivo1=$datos_palabra['palabra']."_".$i.".".$extension; 
									if (!in_array($archivo1,$nombres_archivos_mp3)) { $nombres_archivos_mp3[]=$archivo1; break; }
								}
												
							} else {
								$nombres_archivos_mp3[]=$archivo1;
							}
						
						$zipfile -> addFile(file_get_contents($ruta), iconv("UTF-8", "CP850", $archivo1));
					
					} else {
						
						$dt=$query->datos_traduccion($filaname2,$_SESSION['id_language']);
						$dp=$query->datos_palabra($dt['id_palabra']);
						$archivo1= $dp['palabra']."_".$datos_idioma['idioma_abrev'].".".$extension;
						
							if (in_array($archivo1,$nombres_archivos_mp3)) {
										
								for ($i = 1; $i <= 1000; $i++) {
									$archivo1=$dp['palabra']."_".$datos_idioma['idioma_abrev']."_".$i.".".$extension; 
									if (!in_array($archivo1,$nombres_archivos_mp3)) { $nombres_archivos_mp3[]=$archivo1; break; }
								}
												
							} else {
								$nombres_archivos_mp3[]=$archivo1;
							}
						
						$zipfile -> addFile(file_get_contents($ruta), iconv("UTF-8", "CP850", $archivo1));
						
					}
					
						
				}
			
			
			} else { //PARA MATERIALES Y OTRO TIPO DE ARCHIVOS

				$zipfile -> addFile(file_get_contents($ruta), $filename);
				
			}
	


	}

}
						  
    // Set headers
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$a_descargar");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");
	
	echo $zipfile->file();
?>
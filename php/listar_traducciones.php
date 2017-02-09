<?php
//VARIABLES
//id_idioma
//filtrado: 0->Sin Filtrado 1->Con locución 2->Sin locución

set_time_limit(45000); 
require('requires_basico.php');

$id_idioma=$_GET['id_idioma'];
$filtrado=$_GET['filtrado'];

define("MAP_DIR","classes/utf8/MAPPING");
define("CP1250",MAP_DIR . "/CP1250.MAP");
define("CP1251",MAP_DIR . "/CP1251.MAP");
define("CP1252",MAP_DIR . "/CP1252.MAP");
define("CP1253",MAP_DIR . "/CP1253.MAP");
define("CP1254",MAP_DIR . "/CP1254.MAP");
define("CP1255",MAP_DIR . "/CP1255.MAP");
define("CP1256",MAP_DIR . "/CP1256.MAP");
define("CP1257",MAP_DIR . "/CP1257.MAP");
define("CP1258",MAP_DIR . "/CP1258.MAP");
define("CP874", MAP_DIR . "/CP874.MAP");
define("CP932", MAP_DIR . "/CP932.MAP");
define("CP936", MAP_DIR . "/CP936.MAP");
define("CP949", MAP_DIR . "/CP949.MAP");
define("CP950", MAP_DIR . "/CP950.MAP");
define("GB2312", MAP_DIR . "/GB2312.MAP");
define("BIG5", MAP_DIR . "/BIG5.MAP");

include_once('classes/utf8/utf8.class.php');
$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

if ($id_idioma==0) {
	$idiomas='<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:18px; border: 1px solid #000000;">
	  <tr>
	    <td bgcolor="#999999" align="center">Contador</td>
		<td bgcolor="#999999" align="center">ID Palabra</td>
		<td bgcolor="#999999" align="center">Palabra</td>
		<td bgcolor="#999999">Definicion</td>
	  </tr>';	
} else { 
	$idiomas='<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:18px; border: 1px solid #000000;">
	  <tr>
	    <td bgcolor="#999999" align="center">Contador</td>
		<td bgcolor="#999999" align="center">ID Traduccion</td>
		<td bgcolor="#999999" align="center">Traduccion</td>
		<td bgcolor="#999999" align="center">ID Palabra</td>
		<td bgcolor="#999999" align="center">Palabra</td>
		<td bgcolor="#999999">Definicion</td>
	  </tr>';
}
			switch ($id_idioma) {
				
				case 0:
					$castellano=$query->listar_palabras();
						$c=0;
						while ($row_castellano=mysql_fetch_array($castellano)) {
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/0/'.$row_castellano['id_palabra'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/0/'.$row_castellano['id_palabra'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_castellano['estado']==1 && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_castellano['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_castellano['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_castellano['definicion']).'</td></tr>'; }
					}
				break;
				
				case 4: //Chino
					$chino=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma);
					if (mysql_num_rows($chino) > 0) {
						$c=0;
						while ($row_chino=mysql_fetch_array($chino)) {
							$row_palabra=$query->datos_palabra($row_chino['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/4/'.$row_chino['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/4/'.$row_chino['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_chino['estado']==1 && $row_chino['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_chino['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_chino['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_chino['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 2: //Rumano
					$rumano=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma);
					if (mysql_num_rows($rumano) > 0) {
						$c=0;
						$row_palabra=$query->datos_palabra($row_rumano['id_palabra']);
							
						while ($row_rumano=mysql_fetch_array($rumano)) {
							$row_palabra=$query->datos_palabra($row_rumano['id_palabra']);							
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/2/'.$row_rumano['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/2/'.$row_rumano['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_rumano['estado']==1 && $row_rumano['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_rumano['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_rumano['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_rumano['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 6: //Polaco
					$polaco=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma);
					if (mysql_num_rows($polaco) > 0) {
						$c=0;
						while ($row_polaco=mysql_fetch_array($polaco)) {
							$row_palabra=$query->datos_palabra($row_polaco['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/6/'.$row_polaco['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/6/'.$row_polaco['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_polaco['estado']==1 && $row_polaco['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_polaco['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_polaco['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_polaco['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 1: //Ruso
					$ruso=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma);
					if (mysql_num_rows($ruso) > 0) {
						$c=0;
						while ($row_ruso=mysql_fetch_array($ruso)) {
							$row_palabra=$query->datos_palabra($row_ruso['id_palabra']);
							$res_ru = $utfConverter_ru->strToUtf8($row_ruso['traduccion']);						
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/1/'.$row_ruso['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/1/'.$row_ruso['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_ruso['estado']==1 && $row_ruso['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_ruso['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$res_ru.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_ruso['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 5: //Bulgaro
					$bulgaro=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma); 
					if (mysql_num_rows($bulgaro) > 0) {
						$c=0;
						while ($row_bulgaro=mysql_fetch_array($bulgaro)) {
							$row_palabra=$query->datos_palabra($row_bulgaro['id_palabra']);
							$res_bulg = $utfConverter_ru->strToUtf8($row_bulgaro['traduccion']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/5/'.$row_bulgaro['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/5/'.$row_bulgaro['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_bulgaro['estado']==1 && $row_bulgaro['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_bulgaro['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$res_bulg.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_bulgaro['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 3: //Arabe
					$arabe=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma);
					if (mysql_num_rows($arabe) > 0) {
						$c=0;
						while ($row_arabe=mysql_fetch_array($arabe)) {
							$res_ar = $utfConverter->strToUtf8($row_arabe['traduccion']);
							$row_palabra=$query->datos_palabra($row_arabe['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/3/'.$row_arabe['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/3/'.$row_arabe['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_arabe['estado']==1 && $row_arabe['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_arabe['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$res_ar.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_arabe['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 7: //Ingles
					$ingles=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma);
					if (mysql_num_rows($ingles) > 0) {
						$c=0;
						while ($row_ingles=mysql_fetch_array($ingles)) {
							$row_palabra=$query->datos_palabra($row_ingles['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/7/'.$row_ingles['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/7/'.$row_ingles['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_ingles['estado']==1 && $row_ingles['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_ingles['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_ingles['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_ingles['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 8: //Frances
					$frances=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma); 
					if (mysql_num_rows($frances) > 0) {
						$c=0;
						while ($row_frances=mysql_fetch_array($frances)) {
							$row_palabra=$query->datos_palabra($row_frances['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/8/'.$row_frances['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/8/'.$row_frances['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_frances['estado']==1 && $row_frances['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_frances['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_frances['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_frances['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 9: //Catalán
					$catalan=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma);
					if (mysql_num_rows($catalan) > 0) {
						$c=0;
						while ($row_catalan=mysql_fetch_array($catalan)) {
							$row_palabra=$query->datos_palabra($row_catalan['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/9/'.$row_catalan['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/9/'.$row_catalan['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_catalan['estado']==1 && $row_catalan['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_catalan['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_catalan['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_catalan['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 10: //Euskera
					$euskera=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma);
					if (mysql_num_rows($euskera) > 0) {
						$c=0;
						while ($row_euskera=mysql_fetch_array($euskera)) {
							$row_palabra=$query->datos_palabra($row_euskera['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/10/'.$row_euskera['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/10/'.$row_euskera['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_euskera['estado']==1 && $row_euskera['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_euskera['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_euskera['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_euskera['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 11: //Alemán
					$aleman=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma);
					if (mysql_num_rows($aleman) > 0) {
						$c=0;
						while ($row_aleman=mysql_fetch_array($aleman)) {
							$row_palabra=$query->datos_palabra($row_aleman['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/11/'.$row_aleman['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/11/'.$row_aleman['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_aleman['estado']==1 && $row_aleman['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_aleman['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_aleman['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_aleman['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 12: //Italiano
					$italiano=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma); 
					if (mysql_num_rows($italiano) > 0) {
						$c=0;
						while ($row_italiano=mysql_fetch_array($italiano)) {
							$row_palabra=$query->datos_palabra($row_italiano['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/12/'.$row_italiano['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/12/'.$row_italiano['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_italiano['estado']==1 && $row_italiano['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_italiano['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_italiano['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_italiano['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 13: //Portugués
					$portugues=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma); 
					if (mysql_num_rows($portugues) > 0) {
						$c=0;
						while ($row_portugues=mysql_fetch_array($portugues)) {
							$row_palabra=$query->datos_palabra($row_portugues['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/13/'.$row_portugues['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/13/'.$row_portugues['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_portugues['estado']==1 && $row_portugues['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_portugues['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_portugues['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_portugues['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td>'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 15: //Portugués de Brasil
					$portugues_br=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma); 
					if (mysql_num_rows($portugues_br) > 0) {
						$c=0;
						while ($row_portugues_br=mysql_fetch_array($portugues_br)) {
							$row_palabra=$query->datos_palabra($row_portugues_br['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/15/'.$row_portugues_br['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/15/'.$row_portugues_br['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_portugues_br['estado']==1 && $row_portugues_br['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_portugues_br['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_portugues_br['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_portugues_br['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td>'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
					case 14: //Gallego
					$gallego=$query->buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma); 
					if (mysql_num_rows($gallego) > 0) {
						$c=0;
						while ($row_gallego=mysql_fetch_array($gallego)) {
							$row_palabra=$query->datos_palabra($row_gallego['id_palabra']);
							
							if ($filtrado==0) { 
								$mostrar=1; 
							} elseif ($filtrado==1) { //CON LOCUCION
								if (file_exists('repositorio/locuciones/14/'.$row_gallego['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							} elseif ($filtrado==2) { //SIN LOCUCION
								if (!file_exists('repositorio/locuciones/14/'.$row_gallego['id_traduccion'].'.mp3')) {
									$mostrar=1;
								} else {
									$mostrar=0;
								}
							}
							
							if ($row_gallego['estado']==1 && $row_gallego['traduccion'] != NULL && $mostrar==1) { $c++; $idiomas.='<tr><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$c.'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_gallego['id_traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_gallego['traduccion'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_gallego['id_palabra'].'</td><td align="center" style="border-bottom: 1px solid #000000; padding-top:10px; padding-bottom:10px;">'.$row_palabra['palabra'].'</td><td>'.utf8_encode($row_palabra['definicion']).'</td></tr>'; }
						}
					}
					break;
					
			}


$idiomas.='</table>';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado Traducciones</title>
</head>
<body>
<?php echo $idiomas; ?>
</body>
</html>
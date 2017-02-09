<?php
require('classes/querys/query.php');
require('funciones/funciones.php');
require ('classes/languages/language_detect.php');
require('classes/utf8/utf8.class.php');
/***************************************************/
/*    CODIFICACION DIFERENTES IDIOMAS           */
/***************************************************/

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


$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

$db=new query();	
$translate=$db->get_internacionalizacion_page_content($_SESSION['language'],2); 

	$id_tipo=99;
	$inicial=0;
	$limit = 10;
	
	$pictogramas_color=0;
	$pictogramas_byn=0;
	$fotografia=0;
	$simbolos=0;
	$videos_lse=0;
	$lse_color=0;
	$lse_byn=0;

		$condicionantes=explode('||',$_POST['checkboxes']);
		
		foreach ($condicionantes as $nombre_campo => $valor) {
		
			if ($valor != '') {
				$val=explode('=',$valor);
				$asignacion = "$" . $val[0] . "='" . $val[1] . "';";
				eval($asignacion);
			}
			
		}

		$sql='AND (imagenes.id_tipo_imagen=999';
		
		if ($pictogramas_color==1) { $sql.=' OR imagenes.id_tipo_imagen=10 '; } 
		if ($pictogramas_byn==1) { $sql.=' OR imagenes.id_tipo_imagen=5 '; }
		if ($fotografia==1) { $sql.=' OR imagenes.id_tipo_imagen=2 '; } 
		if ($videos_lse==1) { $sql.=' OR imagenes.id_tipo_imagen=11 '; } 
		if ($lse_color==1) { $sql.=' OR imagenes.id_tipo_imagen=12 '; } 
		if ($lse_byn==1) { $sql.=' OR imagenes.id_tipo_imagen=13 '; } 
		
		$sql.=')';
		
		// Is there a posted query string?
		if(isset($_POST['queryString'])) {
			/*$queryString = $db->real_escape_string($_POST['queryString']);*/
			$queryString = $_POST['queryString'];
			// Is the string length greater than 0?
			
			if(strlen($queryString) >0) {
				// Run the query: We use LIKE '$queryString%'
				// The percentage sign is a wild-card, in my example of countries it works like this...
				// $queryString = 'Uni';
				// Returned data = 'United States, United Kindom';
				
				// YOU NEED TO ALTER THE QUERY TO MATCH YOUR DATABASE.
				// eg: SELECT yourColumnName FROM yourTable WHERE yourColumnName LIKE '$queryString%' LIMIT 10
				
					if ($_POST['language']==0) { 
					
					$query = $db->listar_diccionario_palabras_por_tipos_con_imagenes_limit($sql,$queryString,$inicial,$limit);
					if($query) {
						$num_rows=mysql_num_rows($query);
						
						if ($num_rows > 0) {
						// While there are results loop through them - fetching an Object (i like PHP5 btw!).
							while ($row=mysql_fetch_array($query)) {
								// Format the results, im using <li> for the list, you can change it.
								// The onClick function fills the textbox with the result.
								
								// YOU MUST CHANGE: $result->value to $result->your_colum
								echo '<li onClick="fill(\''.$row['id_palabra'].'\');">';
								
								$result_lse=$db->buscar_acepcion_lse($row['id_palabra']);
								$numrows_lse=mysql_num_rows($result_lse);
								
									if ($numrows_lse>0) { 
									
										echo '<img src="images/icono_lse_13x13.jpg" alt="'.$translate['dispone_traduccion_lse'].'" title="'.$translate['dispone_traduccion_lse'].'" border=0" />&nbsp;';
									
									} 
		
								echo '<b>'.CheckSentence(utf8_encode($row['palabra']),$queryString,"color:#61ade7;").': '.substr(utf8_encode($row['definicion']), 0, 100).'...</b></li>';
								
							}
							
						} else {
							echo '<li>'.$translate['no_hay_palabras_busqueda'].'</li>';
						}
					} else {
						echo $translate['error_problemas_consulta'];
					}
					
				} elseif ($_POST['language'] > 0) { //Cierro el If de comprobación de si es en castellano
				
					$id_idioma=$_POST['language'];
					
					switch ($id_idioma) {
						case 1: //Ruso
						$queryString=$utfConverter_ru->utf8ToStr($_POST['queryString']);
						break;
						
						case 5: //Bulgaro
						$queryString=$utfConverter_ru->utf8ToStr($_POST['queryString']);
						break;
						
						case 3: //Arabe
						$queryString=$utfConverter->utf8ToStr($_POST['queryString']);
						break;
						
						default:
						$queryString=$_POST['queryString'];
						break;
						
					}
					
					$query = $db->listar_diccionario_idiomas_palabras_por_tipos_con_imagenes_limit($sql,$queryString,$inicial,$limit,$id_idioma);
					if($query) {
						$num_rows=mysql_num_rows($query);
						
						if ($num_rows > 0) {
						// While there are results loop through them - fetching an Object (i like PHP5 btw!).
							while ($row=mysql_fetch_array($query)) {
								
								if ($row['estado_definicion_traduccion']==1) { $definicion_traduccion=$row['definicion_traduccion'];} else { $definicion_traduccion=''; }
								// Format the results, im using <li> for the list, you can change it.
								// The onClick function fills the textbox with the result.
								
								// YOU MUST CHANGE: $result->value to $result->your_colum
								echo '<li onClick="fill(\''.$row['id_traduccion'].'\',\''.$id_idioma.'\');">';
								
								$result_lse=$db->buscar_acepcion_lse($row['id_palabra']);
								$numrows_lse=mysql_num_rows($result_lse);
								
									if ($numrows_lse>0) { 
									
										echo '<img src="images/icono_lse_13x13.jpg" alt="'.$translate['dispone_traduccion_lse'].'" title="'.$translate['dispone_traduccion_lse'].'" border=0" />&nbsp;';
									
									} 
		
								switch ($id_idioma) {
									
									case 1:
									echo '<b>'.$utfConverter_ru->strToUtf8($row['traduccion']).': '.substr(utf8_decode($definicion_traduccion), 0, 100).'...</b></li>';
									break;
									
									case 5:
									echo '<b>'.$utfConverter_ru->strToUtf8($row['traduccion']).': '.substr(utf8_decode($definicion_traduccion), 0, 100).'...</b></li>';
									break;
									
									case 3:
									echo '<b>'.$utfConverter->strToUtf8($row['traduccion']).': '.substr(utf8_decode($definicion_traduccion), 0, 100).'...</b></li>';
									break;
									
									case 4:
									echo '<b>'.$row['traduccion'].': '.substr(utf8_decode($definicion_traduccion), 0, 100).'...</b></li>';
									break;
									
									default:
									echo '<b>'.CheckSentence($row['traduccion'],$queryString, "color:#61ade7;").': '.substr(utf8_decode($definicion_traduccion), 0, 100).'...</b></li>';
									break;
									
								}
								
								
							}
							
						} else {
							echo '<li>'.$translate['no_hay_palabras_busqueda'].'</li>';
						}
					} else {
						echo $translate['error_problemas_consulta'];
					}
				
				
				}
				
			} else {
				// Dont do anything.
			} // There is a queryString.
		} else {
			echo 'There should be no direct access to this script!';
		}

?>
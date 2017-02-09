<?php
require('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require ('../../../classes/languages/language_detect.php');

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
	
	
		$condicionantes=explode('||',$_POST['checks']);
		
		foreach ($condicionantes as $nombre_campo => $valor) {
		
			if ($valor != '') {
				$val=explode('=',$valor);
				$asignacion = "$" . $val[0] . "=1;";
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
								
								echo '<b>'.CheckSentence(utf8_encode($row['palabra']),$queryString,"color:#61ade7;").': '.substr(utf8_encode($row['definicion']), 0, 100).'...</b></li>';
								
							}
							
						} else {
							echo '<li>'.$translate['no_hay_palabras_busqueda'].'</li>';
						}
					} else {
						echo $translate['error_problemas_consulta'];
					}
					
				} elseif ($_POST['language'] > 0) { //Cierro el If de comprobación de si es en castellano
					
					$query = $db->listar_diccionario_idiomas_palabras_por_tipos_con_imagenes_limit($sql,$queryString,$inicial,$limit,$_POST['language']);
					if($query) {
						$num_rows=mysql_num_rows($query);
						
						if ($num_rows > 0) {
						// While there are results loop through them - fetching an Object (i like PHP5 btw!).
							while ($row=mysql_fetch_array($query)) {
								// Format the results, im using <li> for the list, you can change it.
								// The onClick function fills the textbox with the result.
								
								// YOU MUST CHANGE: $result->value to $result->your_colum
								echo '<li onClick="fill(\''.$row['id_traduccion'].'\');">';
		
								echo '<b>'.CheckSentence($row['traduccion'],$queryString, "color:#61ade7;").': '.substr(utf8_encode($row['explicacion']), 0, 100).'...</b></li>';
								
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
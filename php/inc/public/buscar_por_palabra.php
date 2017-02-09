<?php 
session_start();
require ('../../classes/languages/language_detect.php');
include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');

$query= new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],2); 

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

if ($_POST['buscar_por']==1) {

	if (isset($_POST['id_palabra'])) { 
		$imagenes_disponibles=imagenes_simbolos_disponibes_por_palabra_exacta($query,$_POST['id_palabra'],$pictogramas_color,$pictogramas_byn,$fotografia,$simbolos,$videos_lse,$lse_color,$lse_byn);
		
		if ($_SESSION['language']=='es') {
			$datos_palabra=$query->datos_palabra($_POST['id_palabra']);
			$palabra=$datos_palabra['palabra'];
		} elseif ($_SESSION['language']!='es') {
			$traduccion=$query->buscar_traduccion_por_id($_POST['id_palabra']);
			$datos_traduccion=mysql_fetch_array($traduccion);
			$palabra=$datos_traduccion['traduccion'];
		}	
		
		echo '<h4>'.$translate['resultados_para'].': "'.$palabra.'"</h4><br />';
		
	} elseif (isset($_POST['palabra'])) {
		$imagenes_disponibles=imagenes_simbolos_disponibes_por_palabra($query,$_POST['palabra'],$pictogramas_color,$pictogramas_byn,$fotografia,$simbolos,$videos_lse,$lse_color,$lse_byn);
		echo '<h4>'.$translate['resultados_para'].': "'.$_POST['palabra'].'"</h4><br />';
	}
	
	
} elseif ($_POST['buscar_por']==2) {

	if (isset($_POST['id_palabra'])) { 
	
			
		$datos_palabra=$query->datos_palabra($_POST['id_palabra']);
		$imagenes_disponibles=imagenes_simbolos_disponibes_por_tag($query,$datos_palabra['palabra'],$pictogramas_color,$pictogramas_byn,$fotografia,$simbolos,$videos_lse,$lse_color,$lse_byn);
		echo '<h4>'.$translate['resultados_tag'].': "'.$datos_palabra['palabra'].'"</h4><br /><p align="right"><a href="rss/subscripcion.php?t=5&tag='.$datos_palabra['palabra'].'&pc='.$pictogramas_color.'&pbyn='.$pictogramas_byn.'&img='.$fotografia.'&smb='.$simbolos.'&vlse='.$videos_lse.'&lsec='.$lse_color.'&lsebyn='.$lse_byn.'" target="_blank">'.$translate['subscribirse_resultados_tag'].'</a>&nbsp;<a href="rss/subscripcion.php?t=5&tag='.$_POST['palabra'].'" target="_blank"><img src="images/feed.png" alt="'.$translate['subscribirse_resultados_tag'].'" title="'.$translate['subscribirse_resultados_tag'].'"></a></p>';
	} elseif (isset($_POST['palabra'])) {
		$imagenes_disponibles=imagenes_simbolos_disponibes_por_tag($query,$_POST['palabra'],$pictogramas_color,$pictogramas_byn,$fotografia,$simbolos,$videos_lse,$lse_color,$lse_byn);
		echo '<h4>'.$translate['resultados_tag'].': "'.$_POST['palabra'].'"</h4><br /><p align="right"><a href="rss/subscripcion.php?t=5&tag='.$_POST['palabra'].'&pc='.$pictogramas_color.'&pbyn='.$pictogramas_byn.'&img='.$fotografia.'&smb='.$simbolos.'&vlse='.$videos_lse.'&lsec='.$lse_color.'&lsebyn='.$lse_byn.'" target="_blank">'.$translate['subscribirse_resultados_tag'].'</a>&nbsp;<a href="rss/subscripcion.php?t=5&tag='.$_POST['palabra'].'" target="_blank"><img src="images/feed.png" alt="'.$translate['subscribirse_resultados_tag'].'" title="'.$translate['subscribirse_resultados_tag'].'"></a></p>';
	}
	


}
echo $imagenes_disponibles;
?>
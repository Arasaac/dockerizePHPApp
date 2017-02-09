<?php 
session_start();
require ('../../classes/languages/language_detect.php');
include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
include('../../configuration/tags.inc');

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

//obtenemos el valor mas Alto y a partir de ahi 
//obtenemos los rangos de Porcentaje para comparar
$max_qty = max(array_values($tags));
$per10 = round(($max_qty *.1));
$per20 = round(($max_qty *.2));
$per30 = round(($max_qty *.3));
$per40 = round(($max_qty *.4));
$per50 = round(($max_qty *.5));
$per60 = round(($max_qty *.6));
$per70 = round(($max_qty *.7));
$per80 = round(($max_qty *.8));
$per90 = round(($max_qty *.9));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><?php 
	$imagenes_disponibles=imagenes_simbolos_disponibes_por_tag($query,$_POST['palabra'],$pictogramas_color,$pictogramas_byn,$fotografia,$simbolos,$videos_lse,$lse_color,$lse_byn);
	echo '<h4>'.$translate['resultados_tag'].': "'.$_POST['palabra'].'"</h4><br />
	<p align="right"><a href="rss/subscripcion.php?t=5&tag='.$_POST['palabra'].'" target="_blank">'.$translate['subscribirse_resultados_tag'].'</a>&nbsp;<a href="rss/subscripcion.php?t=5&tag='.$_POST['palabra'].'" target="_blank"><img src="images/feed.png" alt="'.$translate['subscribirse_resultados_tag'].'" title="'.$translate['subscribirse_resultados_tag'].'"></a></p><br />';
	echo $imagenes_disponibles;
	?></td>
    <td style="padding-left:20px; width: 350px;"> 
	<div>
      <?php 
	   //Ahora si hacemos otro Ciclo para recorrer el 
		//Array comparar los Valores vs Porcentajes e Imprimimos el Tag
		foreach ($tags as $key => $value) {
		 
			//Reinicializar Variables
			$porcentaje=0;
			$estilo=0;
		 
			//Calcular el Porcentaje Real
			$porcentaje=round(($value/$max_qty)*100);
		 
		if ($value>=$per90 ){
			   $estilo=10;
		   }else if($value>=$per80 ){
			   $estilo=9;
		   }else if($value>=$per70 ){
			   $estilo=8;
		   }else if($value>=$per60 ){
			   $estilo=7;
		   }else if($value>=$per50 ){
			   $estilo=6;
		   }else if($value>=$per40 ){
			   $estilo=5;
		   }else if($value>=$per30 ){
			   $estilo=4;
		   }else if($value>=$per20 ){
			   $estilo=3;
		   }else if($value>=$per10 ){
			   $estilo=2;
		   }else{
			   $estilo=1;
		   }
	    //Imprmimos el Tag
		  echo '<a href="javascript:void(0);" onclick="recogercheckbox_buscador_principal_para_tags(\''.$key.'\');"';
		  echo ' title="'.$value.' veces que se encontro este tag '.$key.'"';
		  echo '  class="tagcloud_'.$estilo.'">'.$key.'</a> &nbsp; ';

	 } ?> </div>
	</td>
  </tr>
</table>

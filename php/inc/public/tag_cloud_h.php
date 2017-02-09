<?php
include('configuration/tags.inc');

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
<h4>Nube de etiquetas:</h4>
<br /><br />
<div align="center">
    <div style="width:70%;">
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
		  echo '<a href="javascript:void(0);" onclick="cargar_div2(\'inc/public/buscar_por_tags.php\',\'palabra='.$key.'\',\'principal\');"';
		  echo ' title="'.$value.' veces que se encontro este tag '.$key.'"';
		  echo '  class="tagcloud_'.$estilo.'">'.$key.'</a> &nbsp; ';

	 } ?> </div>
</div>
<br /><br />
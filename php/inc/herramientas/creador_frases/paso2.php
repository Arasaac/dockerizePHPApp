<?php 
session_start();
include ('../../../classes/querys/query.php');
$query=new query();

$palabra=$_POST['palabra'];
$idioma=$_POST['language'];
$tipo=$_POST['tipo'];
$frase='';
$li='';
					
if (isset($_POST['thelist2'])) {
	foreach ($_POST['thelist2'] as $indice=>$valor){ 
		$frase.='thelist2[]='.$valor.'&';
			
			$v=explode('||',rawurldecode($valor));
						
			if ($v[2]==1) { 
			
				if ($v[0] >0 ) {
					if ($v[1]==0) {
						$dp=$query->datos_palabra($v[0]);
						$dp_palabra=utf8_encode($dp['palabra']);
					} elseif ($v[1] > 0) {
						$dp=$query->buscar_traduccion_por_id($v[0]);
						$row_dp=mysql_fetch_array($dp);
						$dp_palabra=$row_dp['traduccion'];
					}
					
					$li.="<li id=\"thelist2_".rawurldecode($valor)."\">".$dp_palabra."</li>";
				} else {
					$li.="<li id=\"thelist2_".rawurldecode($valor)."\">".$v[0]."</li>";
				}
			
			} elseif ($v[2] == 2 ) {
				
				$li.="<li id=\"thelist2_".rawurldecode($valor)."\">".$v[0]."</li>";
				
			}
		 
	}
	
}
if ($tipo==1) {
	
	if ($palabra>0) {
		
		if ($idioma==0) {
			$dp2=$query->datos_palabra($palabra);
			$palabra_mostrar=utf8_encode($dp2['palabra']);
		} elseif ($idioma > 0 ) {
			$dp2=$query-> buscar_traduccion_por_id($palabra);
			$row_dp2=mysql_fetch_array($dp2);
			$palabra_mostrar=$row_dp2['traduccion'];
		}
		
		$item=rawurlencode($palabra.'||'.$idioma.'||'.$tipo);
		$frase.='thelist2[]='.$item;
		print $li."<li id=\"thelist2_".$item."\">".$palabra_mostrar."</li><input name=\"mi_seleccion\" type=\"hidden\" id=\"mi_seleccion\" value=\"".$frase."\"/>";
	
	} else {
		
		$item=rawurlencode($palabra.'||'.$idioma.'||'.$tipo);
		$frase.='thelist2[]='.$item;
		print $li."<li id=\"thelist2_".$item."\">".$palabra."</li><input name=\"mi_seleccion\" type=\"hidden\" id=\"mi_seleccion\" value=\"".$frase."\"/>";
	
	}
	
} elseif ($tipo==2) {
	
		$item=rawurlencode($palabra.'||'.$idioma.'||'.$tipo);
		$frase.='thelist2[]='.$item;
		print $li."<li id=\"thelist2_".$item."\">".$palabra."</li><input name=\"mi_seleccion\" type=\"hidden\" id=\"mi_seleccion\" value=\"".$frase."\"/>";
		
}
?>
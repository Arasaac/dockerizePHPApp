<?php 
session_start();

include ('../../classes/querys/query.php');
$query=new query();

$id_palabra=$_POST['id_palabra'];
$mostrar=$_POST['mostrar'];


switch ($mostrar) {

	case 'imagenes':
	
		$result=$query->imagenes_por_palabra($id_palabra,$_SESSION['AUTHORIZED']);
		$content="";
		$simbol=array();
		
		while ($row=mysql_fetch_array($result)) { 
				
			$simbol[]='<td>
			<div id="img_'.$row['id_imagen'].'">
			<img src="classes/img/thumbnail.php?size=50&ruta='.md5("../../").'/'.md5("repositorio/originales/").'/'.$row['imagen'].'" border="0"" alt="Mostrar informacion de la imagen"/><br><div id="products"><a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/originales/").'/'.$row['imagen'].'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto"></a>&nbsp;<a href="javascript:void(0);" onClick="cargar_div(\'inc/creador_simbolos/creador_simbolos.php\',\'img='.$row['imagen'].'&id_palabra='.$row['id_palabra'].'\',\'principal\');"><img src=\'images/paint.gif\' border="0" alt="Utilizar imagen en el creador"></a>
			    </div>
			</div>
		</td>';
		} 
		
		$o=0;
		$content.='<table style="text-align:left;">';
			for ($i=1; $i<=20; $i++){ // FILAS
				$content.="<tr>"; 
					for ($e=1; $e<=3; $e++){ //COLUMNAS 
						$file=$simbol[$o];
							if ($file=="") { break; }
							$content.=$file;  
							$o++;
					} 
				$content.="</tr>"; 
			} 
		$content.='</table>';
		
	break;
	
	case 'simbolos':
	
		$result=$query->simbolos_por_palabra($id_palabra,$_SESSION['AUTHORIZED']);
		$content="";
		$simbol=array();
		
		while ($row=mysql_fetch_array($result)) { 
				
			$simbol[]='<td>
			<div id="img_'.$row['id_simbolo'].'">
			<img src="classes/img/thumbnail.php?size=50&ruta='.md5("../../").'/'.md5("repositorio/simbolos/").'/'.$row['id_simbolo'].'_150.'.$row['ext'].'" border="0"" alt="Mostrar informacion del símbolo"/><br><div id="products"><a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/simbolos/").'/'.$row['id_simbolo'].'_150.'.$row['ext'].'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto"></a>
			    </div>
			</div>
		</td>';
		} 
		
		$o=0;
		$content.='<table style="text-align:left;">';
			for ($i=1; $i<=20; $i++){ // FILAS
				$content.="<tr>"; 
					for ($e=1; $e<=3; $e++){ //COLUMNAS 
						$file=$simbol[$o];
							if ($file=="") { break; }
							$content.=$file;  
							$o++;
					} 
				$content.="</tr>"; 
			} 
		$content.='</table>';
		
	break;
	
	
	case '':
	break;

}
	

echo  '<div class="right">
		<h3>Informaci&oacute;n:</h3>
		<div class="right_articles">'; 
echo utf8_encode($content);
echo '</div></div>';

 ?>
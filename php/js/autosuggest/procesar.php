<?php
require('../../classes/querys/query.php');

$query=new query();

$id_tipo=99;
$inicial=0;

$input = $_REQUEST['input'];
$limit = isset($_REQUEST['limit']) ? (int) $_REQUEST['limit'] : 0;
$qr=$query->listar_diccionario_palabras_con_imagenes_limit($id_tipo,$input,$inicial,$limit);


while($row=mysql_fetch_array($qr))  {	

//$aResults[] = array( "id"=>($row['palabra']) ,"value"=>htmlspecialchars($row['palabra']), "info"=>htmlspecialchars($row['palabra']) );

$aResults[] = array( "id"=>($row['id_palabra']) ,"value"=>htmlspecialchars($row['palabra'].': '.substr(utf8_encode($row['definicion']), 0, 100).'...'), "info"=>htmlspecialchars($row['palabra']) );
	
}

//while($row1=mysql_fetch_array($qr1))  {	
//
//$aResults[] = array( "id"=>($row1['link']) ,"value"=>htmlspecialchars(utf8_encode($row1['titulo'])), "info"=>htmlspecialchars(utf8_encode($row1['titulo'])) );
//}

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");	
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 						
header ("Cache-Control: no-cache, must-revalidate"); 	
header ("Pragma: no-cache");

if (isset($_REQUEST['json']))
	{
		header("Content-Type: application/json");	
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<$limit;$i++)
		{
			$arr[] = "{\"id\": \"".$aResults[$i]['id']."\", \"value\": \"".$aResults[$i]['value']."\", \"info\": \"\"}";
		}
		echo implode(", ", $arr);
		echo "]}";
	}
	else
	{
		header("Content-Type: text/xml");
		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		for ($i=0;$i<$limit;$i++)
		{
			echo "<rs id=\"".$aResults[$i]['id']."\" info=\"".$aResults[$i]['info']."\">".$aResults[$i]['value']."</rs>";
		}
		echo "</results>";
	}



?>
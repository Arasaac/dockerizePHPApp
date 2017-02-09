<?php 
	header("Content-type:text/xml");
	include ('../../classes/querys/query.php');
	print("<?xml version=\"1.0\"?>");
?>
<tree id="0">
<?php

$query=new query();

$num_categ=$query->listado_temas();
$numrows = mysql_num_rows($num_categ);
			
while ($row=mysql_fetch_array($num_categ)) {
			
	$tema[]=$row['id_tema'];
	$tema['tema'][]=$row['tema'];
			
}

for ($i=0;$i<$numrows;$i++) {
	
	print("<item id='".$tema[$i]."' text=\"". utf8_encode($tema['tema'][$i])."\">");
	
		$subtemas=$query->listado_subtemas($tema[$i],50); 
		$num_rows2=mysql_num_rows($subtemas);
					
			if ($num_rows2 > 0) {
				while ($row2=mysql_fetch_array($subtemas)) {
					print("<item id='".$row2['id_subtema']."' text=\"". utf8_encode($row2['subtema'])."\" ></item>");
				}
			}	
						
						
	print("</item>");
		
}	

?>
</tree>
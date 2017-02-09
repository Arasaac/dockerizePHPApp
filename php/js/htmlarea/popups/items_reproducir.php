<?php
include ("../../../classes/query_class.php");

header('Content-type: text') ; // on déclare ce qui va être afficher
 
// test des POST emis
if(isset($_POST['id']) && !empty($_POST['id']) ){
	
	$query=new query();
	$item=$query->datos_item_podcast($_GET['id_blog'],$_POST['id']);
	
	echo '<p align="center"><object type="application/x-shockwave-flash" data="../../../../swf/emff_lila.swf?src='.$item['enclosure_url'].'" width="200" height="55">
 <param name="movie" value="../../../../swf/emff_lila.swf?src='.$item['enclosure_url'].'" />
 <param name="quality" value="high" />
 <param name="wmode" value="transparent" />
</object> <input type="hidden" name="rows" id="f_rows" title="Number of rows" value="'.$item['id_item'].'" /></p>';
}

?>
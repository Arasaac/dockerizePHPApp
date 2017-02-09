<?php
include ("../../../classes/query_class.php");

header('Content-type: text') ; // on déclare ce qui va être afficher
 
// test des POST emis
if(isset($_POST['id']) && !empty($_POST['id']) ){
	
	$query=new query();
	$id_blog=$_GET['id_blog'];
	$contar=$query->listar_items_canales($id_blog,$_POST['id']);
	$total_records = mysql_num_rows($contar);
	
    $i=0;
	if ($total_records >0)
	{
	  echo "<select size='1' name='souscat' OnChange=\"sendDataitem('id='+this.value,'items_reproducir.php?id_blog=".$id_blog."&')\" onKeyUp=\"sendDataitem('id='+this.value,'items_reproducir.php?id_blog=".$id_blog."&')\"><option value='' selected>Seleccione podcast</option>";
	}
	else
	{
	  echo utf8_encode("No hay items disponibles para mostrar");	
	}
	
    while ($dt=mysql_fetch_array($contar))
    { 	
	 echo "<option value=".utf8_encode($dt['id_item']).">".$dt['modified']."-".utf8_encode($dt['title_item'])."</option><br>";
    }    
	echo "</select>";
}

?>
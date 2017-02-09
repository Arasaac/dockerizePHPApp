<?php  
session_start();

include ('../../classes/querys/query.php');

$query=new query();

$id_tema="";
$id_tema=$_POST['id_tema'];
$limit='';

if ($id_tema=='') { 

	echo '<b>Subcategor&iacute;as:<input name="id_subtema" type="hidden" id="id_subtema" /></b>';

} else {

	$subtemas=$query->listado_subtemas($id_tema,$limit);
	$num_row=mysql_num_rows($subtemas);
	
	if ($num_row > 0) {
	
		echo '<b>Subcategor&iacute;as:&nbsp;<select name="id_subtema" id="id_subtema"></b>
			<option value="">Todas</option>'; 
		
			while ($row=mysql_fetch_array($subtemas)) { 
			
			echo '<option value="'.$row['id_subtema'].'">'.$row['subtema'].'</option>';
			
			}
		
		echo '</select>';
	} else {
	
		echo '<b>Subcategor&iacute;as:<input name="id_subtema" type="hidden" id="id_subtema" /></b>';
		
	}
}
?>
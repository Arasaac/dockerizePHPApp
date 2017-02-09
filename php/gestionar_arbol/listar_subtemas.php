<?php  
include ('../classes/querys/query.php');

$query=new query();

//$subtemas=$query->listado_subtemas($_POST['tema'],100);
$subtemas=$query->listado_subtemas_tmp($_POST['tema'],100);

echo '<select id=SelectList style="WIDTH: 280px" multiple size=8 name=SelectList>';

while ($row=mysql_fetch_array($subtemas)) {

echo '<option value="'.$row['id_subtema'].'">'.$row['tema']."-".$row['subtema'].'</option>';

}

echo ' </select>';
?>

                       
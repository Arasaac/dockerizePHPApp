<?php  
include ('../classes/querys/query.php');

$query=new query();

$subtemas=$query->listado_subtemas($_POST['tema'],100);

echo '<select id=SelectList style="width: 280px; height:180px;" multiple size=5 name=SelectList>';

while ($row=mysql_fetch_array($subtemas)) {

echo '<option value="'.$row['id_subtema'].'">'.$row['tema']."-".$row['subtema'].'</option>';

}

echo ' </select>';
?>

                       
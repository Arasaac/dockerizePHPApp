<?php 
include ('../../classes/querys/query.php');
$query=new query();
$row=$query->datos_palabra($_POST['id']);
?>

	   <p><strong>Palabra:</strong>
	     <em><strong><?php echo utf8_encode($row['palabra']); ?>,</strong></em>&nbsp;&nbsp;<?php echo $row['definicion']; ?>
	     <input name="id_palabra" type="hidden" id="id_palabra" value="<?php echo $row['id_palabra']?>" />
         <a href="javascript:void(0);" onclick="ventana_modal('','inc/gestion_simbolos/seleccionar_palabra.php');"><img src="images/mas.gif" alt="Seleccionar palabra" border="0" /></a>
		 </p>
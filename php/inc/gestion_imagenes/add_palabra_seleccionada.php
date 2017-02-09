<?php 
include ('../../classes/querys/query.php');

$query=new query();

$id_palabra=$_POST['id_palabra'];
$id_imagen=$_POST['id_imagen'];
$add_adscripcion_palabra=$query->add_adscripcion_palabra($id_imagen,$id_palabra);
$palabras=$query->buscar_palabras_asociadas_imagen($id_imagen); 
				
while ($row_palabras=mysql_fetch_array($palabras)) {  ?>
                  
                  <em><strong><?php echo $row_palabras['palabra']; ?>,</strong></em>&nbsp;&nbsp;<?php echo utf8_encode($row_palabras['definicion']); ?><a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/gestion_simbolos/seleccionar_palabra.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:450}, okLabel: 'Cerrar'});"></a> &nbsp; <?php echo '<a href="javascript:void(0);" 
				onClick="ventana_confirmacion(\'¿Esta seguro que desea borrar la palabra adscrita?\',
				\'300\',\'100\',
				\'inc/gestion_imagenes/borrar_adscripcion_palabra.php\', \'id_palabra='.$row_palabras['id_palabra'].'&id_imagen='.$id_imagen.'\',
				\'\', \'\', \'\'
				);" /><img src="images/papelera.png" alt="Borrar imagen" border="0" /></a>'; ?> <br/>
<?php } ?>

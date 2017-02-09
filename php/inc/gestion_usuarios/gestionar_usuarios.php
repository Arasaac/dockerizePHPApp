<?php 

include ('../../classes/querys/query.php');

$query=new query();

?>
<div align="center"><?php echo $mensaje1 ?></div>
<div class="left">
	<h4>Usuarios</h4>
    <br /><br />
	 <div id="listado_usuarios">
		
		<?php include ('tabla_usuarios.php'); ?>
			
	</div>
</div>

<div class="right">
	
  <div id="usuario">
  
	<?php include ('nuevo_usuario.php'); ?>
			
	</div>

</div>


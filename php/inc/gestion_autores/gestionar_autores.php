<?php 

include ('../../classes/querys/query.php');

$query=new query();

?>
<div align="center"><?php echo $mensaje1 ?></div>
<div class="left" style="width:82%">
	<h4>Autores</h4>
    <br /><br />
	 <div id="listado_usuarios">
		
		<?php include ('tabla_autores.php'); ?>
			
	</div>
</div>

<div class="right" style="width:15%">
	
  <div id="usuario">
  
	<?php include ('nuevo_autor.php'); ?>
			
	</div>

</div>


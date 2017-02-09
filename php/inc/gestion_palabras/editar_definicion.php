<?php 
include ('../../classes/querys/query.php');

$query=new query();

$datos_palabra=$query->datos_palabra($_GET['id_palabra']);

?>

<div align="center" id="actualizar_definicion" style="width:200px;">
<div id="mensaje_actualizacion" align="center" style="color:#CC0033;"></div>
<br><strong>Acepci&oacute;n:</strong><br>
<form action="" method="post" name="actualizar_definicion" id="actualizar_definicion">
  <p>
    <textarea name="definicion" rows="2" id="definicion"><?php echo utf8_encode($datos_palabra['definicion']); ?></textarea>
    <br>
    </p>
  <p><br>
    <input type="button" name="Submit" value="Actualizar" onClick="data('id_palabra=<?php echo $_GET['id_palabra'] ?>&definicion='+document.actualizar_definicion.definicion.value+'','inc/gestion_palabras/modificar_definicion.php','mensaje_actualizacion','palabra_<?php echo $_GET['id_palabra'] ?>', document.actualizar_definicion.definicion.value); Dialog.closeInfo();">
    </p>
</form>
</div>
<?php 
session_start();
$id_usuario=$_GET['id_usuario'];
include ('../../../classes/querys/query.php');
$query=new query();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Abrir directorio</title>
	<link rel="stylesheet" href="../../css/style.css" type="text/css" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<div id="cuerpo">
<?php 
 	$mis_selecciones=$query->listar_mis_selecciones($id_usuario);
	
	while ($row=mysql_fetch_array($mis_selecciones)) {
	
		echo "<a href=\"javascript:window.parent.location='nuevo_panel.php?mi_seleccion=".$row['id_seleccion']."&id_panel=".$_GET['id_panel']."'\">".$row['seleccion']."</a><br />";
	
	}

 ?>
</div>
</body>
</html>
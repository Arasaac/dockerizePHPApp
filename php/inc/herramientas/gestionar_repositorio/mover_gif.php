<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
$query=new query();

$id_directorio=$_POST['destino'];
$id_usuario=$_POST['id_usuario'];
$imagen=$_POST['img'];

$dir=$query->datos_directorio($id_directorio,$id_usuario);
		
if ($dir['parent']==0) { $directorio=$id_usuario; } else { $directorio=$dir['ruta_dir']; }
		
$add_repositorio=$query->add_temp_repositorio($imagen,$id_directorio,$directorio,$id_usuario);
	
?>
<?php 
include ('../../../classes/querys/query.php');

$directorio=$_POST['nombre_carpeta'];
$id_usuario=$_POST['id_usuario'];
$parent=$_POST['parent'];
$ruta=$_POST['ruta'];

$query=new query();

$nuevo_directorio=$query->crear_directorio($directorio,$id_usuario,$parent,$ruta);

echo "Carpeta creada";

?>
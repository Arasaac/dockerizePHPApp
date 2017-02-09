<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$query=new query();
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

if (isset($_POST['thelist3']) && $_POST['thelist3'] !='') { 

  foreach ($_POST['thelist3'] as $indice=>$valor){ 
  
  
		$id_file=$valor;
		$datos_archivo=$query->datos_archivo_repositorio($id_file);
		
		if ($datos_archivo['id_imagen']==0 && $datos_archivo['id_simbolo']==0) { 
		
			$ruta=$datos_archivo['ruta_file'].'/'.$datos_archivo['file_name']; 
			$borrar=$query->borrar_archivo($id_file,1,$ruta);
			
			
		} elseif ($datos_archivo['id_imagen'] > 0 || $datos_archivo['id_simbolo'] > 0) {  
		
			$borrar=$query->borrar_archivo($id_file,0,'');
		
		} 

	}

}

?>
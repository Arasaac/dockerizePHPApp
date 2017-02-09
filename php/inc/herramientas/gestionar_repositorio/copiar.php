<?php 
session_start();

include ('../../../classes/querys/query.php');
$query=new query();

$origen=$_POST['origen'];
$destino=$_POST['destino'];
$id_usuario=$_POST['id_usuario'];

if (isset($_POST['thelist3']) && $_POST['thelist3'] !='') { 

  foreach ($_POST['thelist3'] as $indice=>$valor){ 
  
		$row=$query->datos_archivo_repositorio($valor);
		
		if ($row['id_imagen']==0 && $row['id_simbolo']==0) { 
		
			$copiar=$query->copiar_archivo(1,$valor,$origen,$destino,$id_usuario);
		
		} elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  
		
			$copiar=$query->copiar_archivo(0,$valor,$origen,$destino,$id_usuario);
		
		} 
	}

}

?>
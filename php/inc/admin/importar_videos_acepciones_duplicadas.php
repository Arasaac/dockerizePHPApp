<?php 
include ('../../classes/querys/query.php');

$query=new query();

$path = "../../importar/videos/acepciones/duplicadas/";
$dir = opendir($path);
while ($elemento = readdir($dir))
{
	if($elemento != "." && $elemento != ".."){ 
	   $parte=explode('.',$elemento);
	   $parte1=explode('_',$parte[0]);
	   
	   //$num_videos=$query->comprobar_si_existe_ya_video_lse_acepcion($parte[0]);
	   
	   $img_disponibles=$query->imagenes_disponibles_tipo($parte1[0],10);
	   $num_resultados=mysql_num_rows($img_disponibles);
	   if ($num_resultados > 0) { 
	   		$row=mysql_fetch_array($img_disponibles);
			$tags_imagen=$row['tags_imagen'];
	   } else { $tags_imagen=''; }
	   
	   //if ($num_videos==0) {
	   		$id_usuario=1;
			$id_tipo_imagen=11;
			$imagen=$elemento;
			$id_palabra=$parte1[0];
			$estado=1;
			$registrado=0;
			$id_autor=43;
			$id_licencia=2;
			$tags='{lse}{lengua de signos}'.$tags_imagen;		
			
	   		$nueva_imagen=$query->add_new_picture($id_usuario,$id_tipo_imagen,$imagen,$id_palabra,$estado,$registrado,$id_autor,$id_licencia,$tags);
			copy ("../../importar/videos/acepciones/duplicadas/".$elemento."","../../repositorio/LSE_acepciones/".$nueva_imagen."");
			unlink ("../../importar/videos/acepciones/duplicadas/".$elemento."");
			
	   //} 
		
	}

}
?>
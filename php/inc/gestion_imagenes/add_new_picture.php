<?php 
session_start();

include ('../../classes/querys/query.php');
$query=new query();

if (!isset($_SESSION['ID_USER']) || $_SESSION['ID_USER']=='') { $id_usuario=1; } else { $id_usuario=$_SESSION['ID_USER']; }
$id_tipo_imagen=$_POST['tipo_imagen'];
$imagen=$_POST['imagen'];
$id_palabra=$_POST['id_palabra'];
$tipo_pictograma=$_POST['tipo_picto'];
$estado=$_POST['estado'];
$id_licencia=$_POST['licencia'];
$id_autor=$_POST['autor'];
$tags=$_POST['tags'];
$original_filename=$_POST['original_filename'];
$tags=explode(',',$tags);

for ($i=0;$i<count($tags);$i++) { 
  	if ($tags[$i]!='') {
		$tags_convertidos.='{'.$tags[$i].'}';
	}
}

if ($_POST['registrado']=="false") { $registrado=0; } elseif ($_POST['registrado']=="true") { $registrado=1;}
if ($_POST['validos_senyalectica']=="false") { $validos_senyalectica=0; } elseif ($_POST['validos_senyalectica']=="true") { $validos_senyalectica=1;}

$nueva_imagen=$query->add_new_picture($id_usuario,$id_tipo_imagen,$imagen,$id_palabra,$estado,$registrado,$id_autor,$id_licencia,$tags_convertidos,$tipo_pictograma,$validos_senyalectica,$original_filename);
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);

if ($id_tipo_imagen==11) {
	copy ("../../temp/".$_POST['imagen']."","../../repositorio/LSE_acepciones/".$nueva_imagen."");
} else { 
	copy ("../../temp/".$_POST['imagen']."","../../repositorio/originales/".$nueva_imagen."");
}

echo '<div  align="center"><div class="mensaje">'.utf8_encode("Imagen añadida").'</div></div><br>';

$nube_tags=$query->construir_nube_tags(200);

include("busquedas.php");

?>
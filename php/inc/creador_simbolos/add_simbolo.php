<?php 
include ('../../classes/querys/query.php');
require_once ('../../classes/img/Image_Toolbox.class.php');
include("../../classes/img/ImageEditor.php");

$query=new query();

$id_palabra=$_POST['id_palabra'];
$tipo_simbolo=$_POST['tipo_simbolo'];
$idioma=$_POST['idioma'];
$estado=$_POST['estado'];
$imagen=$_POST['img'];
$marco=$_POST['marco'];
$contraste=$_POST['contraste'];

if ($_POST['castellano']=="false") { $castellano=0; } elseif ($_POST['castellano']=="true") { $castellano=1;}
if ($_POST['registrado']=="false") { $registrado=0; } elseif ($_POST['registrado']=="true") { $registrado=1;}
if ($_POST['mayusculas']=="false") { $mayusculas=0; } elseif ($_POST['mayusculas']=="true") { $mayusculas=1;}

$ext=$query->datos_tipo_simbolo($tipo_simbolo);

$extension = strtolower(substr(strrchr($imagen, "."), 1));

$link = "../../temp/"; /* ESTABLEZCO CUAL ES LA RUTA DE DESTINO */
$upfile = $link.$imagen;

$d_conf['calidad_75_jpg']=95;
$d_conf['calidad_150_jpg']=95;
$d_conf['calidad_75_png']=100;
$d_conf['calidad_150_png']=100;

/*echo '$_POST[\'img\']:'.$imagen;
echo '$_POST[\'id_simbolo\']:'.$id_simbolo;
echo '$_POST[\'id_palabra\']:'.$id_palabra;
echo '$_POST[\'tipo_simbolo\']:'.$tipo_simbolo;
echo '$_POST[\'idioma\']:'.$idioma;
echo '$_POST[\'estado\']:'.$estado;
echo '$_POST[\'castellano\']:'.$castellano;
echo '$_POST[\'registrado\']:'.$registrado;
echo '$_POST[\'mayusculas\']:'.$mayusculas;*/


if ($extension == "gif" || $extension == "png" || $extension == "GIF" || $extension == "PNG" || $extension == "x-png" || $extension == "X-PNG") { 

		$id_simbolo=$query->add_nuevo_simbolo($id_palabra,$tipo_simbolo,$idioma,$estado,$castellano,$registrado,$mayusculas,$contraste,$marco);
		  
		  if ($ext['ext']=='jpg') {
		  
		  	$img = new Image_Toolbox($upfile);
		 	$img->newOutputSize(75, 0);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'.jpg', 'jpg', $d_conf['calidad_75_jpg']);  
			
			$img = new Image_Toolbox($upfile);
		  	$img->newOutputSize(150, 0);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_150.jpg', 'jpg', $d_conf['calidad_150_jpg']);  
			
			$img = new Image_Toolbox($upfile);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_o.jpg', 'jpg', $d_conf['calidad_150_jpg']);
			
		  } elseif ($ext['ext']=='png') {
		  
		 	$img = new Image_Toolbox($upfile);
		 	$img->newOutputSize(75, 0);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'.png', 'png8', $d_conf['calidad_75_png']);  
			
			$img = new Image_Toolbox($upfile);
		  	$img->newOutputSize(150, 0);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_150.png', 'png8', $d_conf['calidad_150_png']);  
			
			$img = new Image_Toolbox($upfile);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_o.png', 'png8', $d_conf['calidad_150_png']);
			
		  }
		  
		  $mensaje= "Símbolo almacenado correctamente";		 
	
		
} elseif ($extension == "jpg" || $extension == "JPG" || $extension == "pjpeg" || $extension == "PJPEG")  {
			 
		  $id_simbolo=$query->add_nuevo_simbolo($id_palabra,$tipo_simbolo,$idioma,$estado,$castellano,$registrado,$mayusculas,$contraste,$marco);
			
		  if ($ext['ext']=='jpg') {
		  
		  	$img = new Image_Toolbox($upfile);
		 	$img->newOutputSize(75, 0);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'.jpg','jpg', $d_conf['calidad_75_jpg']);   
	  
			$img = new Image_Toolbox($upfile);
		  	$img->newOutputSize(150, 0);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_150.jpg','jpg', $d_conf['calidad_150_jpg']); 
						
			$img = new Image_Toolbox($upfile);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_o.jpg', 'jpg', $d_conf['calidad_150_jpg']);
		  
		  } elseif ($ext['ext']=='png') {
		  
		 	$img = new Image_Toolbox($upfile);
		 	$img->newOutputSize(75, 0);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'.png', 'png8', $d_conf['calidad_75_png']);  
			
			$img = new Image_Toolbox($upfile);
		  	$img->newOutputSize(150, 0);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_150.png', 'png8', $d_conf['calidad_150_png']); 
			
			$img = new Image_Toolbox($upfile);
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_o.png', 'png8', $d_conf['calidad_150_png']);
			
		  }
		  $mensaje= "Símbolo almacenado correctamente";	
	}
echo $mensaje;
?>
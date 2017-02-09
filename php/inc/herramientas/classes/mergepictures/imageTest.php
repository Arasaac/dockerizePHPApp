<?
include("mergePictures.php");

$f1 = "im1.jpg";
$f2 = "im2.jpg";


$imagem = new mergePictures($f1,$f2);


$imagem->merge("up");
$imagem->save("imgs","foto3","jpg");

$imagem->merge("down");
$imagem->save("imgs","foto2","bmp");

$imagem->over();
$imagem->save("imgs","foto1","gif");

echo "works!!";
?>
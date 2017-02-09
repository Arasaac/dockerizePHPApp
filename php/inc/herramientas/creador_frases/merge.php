<?php
// config --
$src = array ("image1.jpg", "image2.jpg");   
$under = 0;    // 0 - Lo añade a la Derecha ; 1 - Lo añade debajo
// -- end of config

$imgBuf = array ();
$maxW=0; $maxH=0;
foreach ($src as $link)
{
    switch(substr ($link,strrpos ($link,".")+1))
    {
        case 'png':
            $iTmp = imagecreatefrompng($link);
            break;
        case 'gif':
            $iTmp = imagecreatefromgif($link);
            break;               
        case 'jpeg':           
        case 'jpg':
            $iTmp = imagecreatefromjpeg($link);
            break;               
    }

    if ($under)
    {
        $maxW=(imagesx($iTmp)>$maxW)?imagesx($iTmp):$maxW;
        $maxH+=imagesy($iTmp);
    }
    else
    {
        $maxW+=imagesx($iTmp);
        $maxH=(imagesy($iTmp)>$maxH)?imagesy($iTmp):$maxH;
    }

    array_push ($imgBuf,$iTmp);
}

$iOut = imagecreatetruecolor($maxW,$maxH) ;

$pos=0;
foreach ($imgBuf as $img)
{
    if ($under)
        imagecopy ($iOut,$img,0,$pos,0,0,imagesx($img),imagesy($img));
    else
        imagecopy ($iOut,$img,$pos,0,0,0,imagesx($img),imagesy($img));   
    $pos+= $under ? imagesy($img) : imagesx($img);
    imagedestroy ($img);
}

imagejpeg($iOut,'out.jpg'); 
?>
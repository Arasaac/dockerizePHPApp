<?
function imagegreyscale($img)
{
if(imageistruecolor($img))
 {

  for($y=0;$y<imagesy($img);$y++)
   for($x=0;$x<imagesx($img);$x++)
    {
     $color=imagecolorsforindex($img,imagecolorat($img,$x,$y));
     $grey=$color["red"]*0.3+$color["green"]*0.59+$color["blue"]*0.11;
     imagesetpixel($img,$x,$y,imagethisgrey($img,$grey));
    };
 }
 else
 {
  for($p=0;$p<imagecolorstotal($img);$p++)
   {
     $color=imagecolorsforindex($img,$p);
     $grey=$color["red"]*0.3+$color["green"]*0.59+$color["blue"]*0.11;
     imagecolorset($img,$p,imagecolorallocate($img,$grey,$grey,$grey));
   };
 };
};



define("NORMAL",0);
define("FLOID",1);
define("STUCKI",2);
define("BURKES",3);
define("BAYER",3);

/*
*------------------------------------------------------------
*                    ImageBW
*------------------------------------------------------------
*            - Converts image to black and white image
*           Parameters: $img - Target image
*                      $Type - Conversion type:
*                               NORMAL - Nearest color
*                                FLOYD - Floyd/Steinenberg
*                               STUCKI
*                               BURKES
*                                BAYER
*/

function imagebw($img,$Type)
{
$pattern=Array(
               Array(0,32,8,40,2,34,10,42),
               Array(48,16,56,24,50,18,58,26),
               Array(12,44,4,36,14,46,6,38),
               Array(60,28,52,20,62,30,54,22),
               Array(3,35,11,43,1,33,9,41),
               Array(51,19,59,27,49,17,57,25),
               Array(14,47,7,39,13,45,5,37),
               Array(63,31,55,23,61,29,53,21),
              );

 $black=0;
 $white=255;
 imagegreyscale($img);
 $pblack=imagethiscolor($img,0,0,0);
 $pwhite=imagethiscolor($img,255,255,255);

 for($y=0;$y<imagesy($img);$y++)
  {
   for($x=imagesx($img)-1;$x>=0;$x--)
    {
     $n=imagegetgreyvalue($img,$x,$y);

     if($Type==BAYER)
     {
      $n=floor($n/4);
      if(($n>>2)>$pattern[$x & 7][$y & 7])
       {
       imagesetpixel($img,$x,$y,$pwhite);
       }
       else
       {
       imagesetpixel($img,$x,$y,$pblack);
       };
     }
     else
     {
     if($n>($black+$white)/2)
      {
       imagesetpixel($img,$x,$y,$pwhite);
       $err=$n-$white;
      }
     else
      {
       imagesetpixel($img,$x,$y,$pblack);
       $err=$n-$black;
      };
     };

if($Type==FLOID)
 {
  if($y & 1)
  {
  imagesetpixel($img,$x+1,$y,imagethisgrey($img,imagegetgreyvalue($img,$x+1,$y)+ (7*$err/16)   ));
  imagesetpixel($img,$x-1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x-1,$y+1)+ (3*$err/16)   ));
  imagesetpixel($img,$x,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x,$y+1)+ (5*$err/16)   ));
  imagesetpixel($img,$x+1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x+1,$y+1)+ ($err/16)   ));
  }
  else
  {
  imagesetpixel($img,$x-1,$y,imagethisgrey($img,imagegetgreyvalue($img,$x-1,$y)+ (7*$err/16)   ));
  imagesetpixel($img,$x+1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x+1,$y+1)+ (3*$err/16)   ));
  imagesetpixel($img,$x,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x,$y+1)+ (5*$err/16)   ));
  imagesetpixel($img,$x-1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x-1,$y+1)+ ($err/16)   ));
  };
 };

if($Type==STUCKI)
 {
  if($y & 1)
  {
  imagesetpixel($img,$x+2,$y,imagethisgrey($img,imagegetgreyvalue($img,$x+2,$y)+ (8*$err/42)   ));
  imagesetpixel($img,$x+1,$y,imagethisgrey($img,imagegetgreyvalue($img,$x+1,$y)+ (4*$err/42)   ));
  imagesetpixel($img,$x-2,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x-2,$y+1)+ (2*$err/42)   ));
  imagesetpixel($img,$x-1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x-1,$y+1)+ (4*$err/42)   ));
  imagesetpixel($img,$x,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x,$y+1)+ (8*$err/42)   ));
  imagesetpixel($img,$x+1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x+1,$y+1)+ (4*$err/42)   ));
  imagesetpixel($img,$x+2,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x+2,$y+1)+ (2*$err/42)   ));

  imagesetpixel($img,$x-2,$y+2,imagethisgrey($img,imagegetgreyvalue($img,$x-2,$y+2)+ (1*$err/42)   ));
  imagesetpixel($img,$x-1,$y+2,imagethisgrey($img,imagegetgreyvalue($img,$x-1,$y+2)+ (2*$err/42)   ));
  imagesetpixel($img,$x,$y+2,imagethisgrey($img,imagegetgreyvalue($img,$x,$y+2)+ (4*$err/42)   ));
  imagesetpixel($img,$x+1,$y+2,imagethisgrey($img,imagegetgreyvalue($img,$x+1,$y+2)+ (2*$err/42)   ));
  imagesetpixel($img,$x+2,$y+2,imagethisgrey($img,imagegetgreyvalue($img,$x+2,$y+2)+ (1*$err/42)   ));

  }
  else
  {
  imagesetpixel($img,$x-2,$y,imagethisgrey($img,imagegetgreyvalue($img,$x-2,$y)+ (8*$err/42)   ));
  imagesetpixel($img,$x-1,$y,imagethisgrey($img,imagegetgreyvalue($img,$x-1,$y)+ (4*$err/42)   ));

  imagesetpixel($img,$x+2,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x+2,$y+1)+ (2*$err/42)   ));
  imagesetpixel($img,$x+1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x+1,$y+1)+ (4*$err/42)   ));
  imagesetpixel($img,$x,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x,$y+1)+ (8*$err/42)   ));
  imagesetpixel($img,$x-1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x-1,$y+1)+ (4*$err/42)   ));
  imagesetpixel($img,$x-2,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x-2,$y+1)+ (2*$err/42)   ));

  imagesetpixel($img,$x+2,$y+2,imagethisgrey($img,imagegetgreyvalue($img,$x+2,$y+2)+ (1*$err/42)   ));
  imagesetpixel($img,$x+1,$y+2,imagethisgrey($img,imagegetgreyvalue($img,$x+1,$y+2)+ (2*$err/42)   ));
  imagesetpixel($img,$x,$y+2,imagethisgrey($img,imagegetgreyvalue($img,$x,$y+2)+ (4*$err/42)   ));
  imagesetpixel($img,$x-1,$y+2,imagethisgrey($img,imagegetgreyvalue($img,$x-1,$y+2)+ (2*$err/42)   ));
  imagesetpixel($img,$x-2,$y+2,imagethisgrey($img,imagegetgreyvalue($img,$x-2,$y+2)+ (1*$err/42)   ));
  };
 };

if($Type==BURKES)
 {
  if($y & 1)
  {
  imagesetpixel($img,$x+2,$y,imagethisgrey($img,imagegetgreyvalue($img,$x+2,$y)+ (8*$err/32)   ));
  imagesetpixel($img,$x+1,$y,imagethisgrey($img,imagegetgreyvalue($img,$x+1,$y)+ (4*$err/32)   ));

  imagesetpixel($img,$x-2,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x-2,$y+1)+ (2*$err/32)   ));
  imagesetpixel($img,$x-1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x-1,$y+1)+ (4*$err/32)   ));
  imagesetpixel($img,$x,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x,$y+1)+ (8*$err/32)   ));
  imagesetpixel($img,$x+1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x+1,$y+1)+ (4*$err/32)   ));
  imagesetpixel($img,$x+2,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x+2,$y+1)+ (2*$err/32)   ));

  }
  else
  {
  imagesetpixel($img,$x-2,$y,imagethisgrey($img,imagegetgreyvalue($img,$x-2,$y)+ (8*$err/32)   ));
  imagesetpixel($img,$x-1,$y,imagethisgrey($img,imagegetgreyvalue($img,$x-1,$y)+ (4*$err/32)   ));

  imagesetpixel($img,$x+2,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x+2,$y+1)+ (2*$err/32)   ));
  imagesetpixel($img,$x+1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x+1,$y+1)+ (4*$err/32)   ));
  imagesetpixel($img,$x,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x,$y+1)+ (8*$err/32)   ));
  imagesetpixel($img,$x-1,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x-1,$y+1)+ (4*$err/32)   ));
  imagesetpixel($img,$x-2,$y+1,imagethisgrey($img,imagegetgreyvalue($img,$x-2,$y+1)+ (2*$err/32)   ));

  };
 };




    };
  };

};





/*

Helping functions:

*/

function imagethiscolor($img,$r,$g,$b)
{
 $color=imagecolorexact($img,$r,$g,$b);
 if($color==-1) $color=imagecolorallocate($img,$r,$g,$b);
 return $color;
};

function imagethisgrey($img,$g)
{
 $color=imagecolorexact($img,$g,$g,$g);
 if($color==-1) $color=imagecolorallocate($img,$g,$g,$g);
 return $color;
};

function imagegetgreyvalue($img,$x,$y)
{
 $color=imagecolorsforindex($img,imagecolorat($img,$x,$y));
 $grey=$color["red"];
 return $grey;
};



?>
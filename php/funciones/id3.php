<?php 

function getDir($mp3Dir) {	

	$dirArray = array();
	$diskdir = "./$mp3Dir/";
	if (is_dir($diskdir)) {
		$dh = opendir($diskdir);
		while (($file = readdir($dh)) != false ) {
			if (filetype($diskdir . $file) == "file" && $file[0]  != ".") {
				if (strrchr(strtolower($file), ".") == ".mp3") {
					$ftime = filemtime($mp3Dir."/".$file); 
					$dirArray[$file] = $ftime;
				}
			}
		}
		closedir($dh);
	}
	asort($dirArray);
	$dirArray = array_reverse($dirArray);
	return $dirArray;
}

$genres = Array('Blues','Classic Rock','Country','Dance','Disco','Funk','Grunge','Hip-Hop','Jazz',
'Metal','New Age','Oldies','Other','Pop','R&B','Rap','Reggae','Rock','Techno','Industrial','Alternative',
'Ska','Death Metal','Pranks','Soundtrack','Euro-Techno','Ambient','Trip-Hop','Vocal','Jazz+Funk','Fusion',
'Trance','Classical','Instrumental','Acid','House','Game','Sound Clip','Gospel','Noise','AlternRock',
'Bass','Soul','Punk','Space','Meditative','Instrumental Pop','Instrumental Rock','Ethnic','Gothic',
'Darkwave','Techno-Industrial','Electronic','Pop-Folk','Eurodance','Dream','Southern Rock','Comedy',
'Cult','Gangsta','Top 40','Christian Rap','Pop/Funk','Jungle','Native American','Cabaret','New Wave',
'Psychadelic','Rave','Showtunes','Trailer','Lo-Fi','Tribal','Acid Punk','Acid Jazz','Polka','Retro',
'Musical','Rock & Roll','Hard Rock','Folk','Folk-Rock','National Folk','Swing','Fast Fusion','Bebob',
'Latin','Revival','Celtic','Bluegrass','Avantgarde','Gothic Rock','Progressive Rock','Psychedelic Rock',
'Symphonic Rock','Slow Rock','Big Band','Chorus','Easy Listening','Acoustic','Humour','Speech','Chanson',
'Opera','Chamber Music','Sonata','Symphony','Booty Bass','Primus','Porn Groove','Satire','Slow Jam','Club',
'Tango','Samba','Folklore','Ballad','Power Ballad','Rhythmic Soul','Freestyle','Duet','Punk Rock','Drum Solo',
'Acapella','Euro-House','Dance Hall'
);

$genreids = Array(
"Blues" => 0,"Classic Rock" => 1,"Country" => 2,"Dance" => 3,"Disco" => 4,"Funk" => 5,"Grunge" => 6,"Hip-Hop" => 7,
"Jazz" => 8,"Metal" => 9,"New Age" => 10,"Oldies" => 11,"Other" => 12,"Pop" => 13,"R&B" => 14,"Rap" => 15,"Reggae" => 16,
"Rock" => 17,"Techno" => 18,"Industrial" => 19,"Alternative" => 20,"Ska" => 21,"Death Metal" => 22,"Pranks" => 23,
"Soundtrack" => 24,"Euro-Techno" => 25,"Ambient" => 26,"Trip-Hop" => 27,"Vocal" => 28,"Jazz+Funk" => 29,"Fusion" => 30,
"Trance" => 31,"Classical" => 32,"Instrumental" => 33,"Acid" => 34,"House" => 35,"Game" => 36,"Sound Clip" => 37,"Gospel" => 38,
"Noise" => 39,"AlternRock" => 40,"Bass" => 41,"Soul" => 42,"Punk" => 43,"Space" => 44,"Meditative" => 45,"Instrumental Pop" => 46,
"Instrumental Rock" => 47,"Ethnic" => 48,"Gothic" => 49,"Darkwave" => 50,"Techno-Industrial" => 51,"Electronic" => 52,
"Pop-Folk" => 53,"Eurodance" => 54,"Dream" => 55,"Southern Rock" => 56,"Comedy" => 57,"Cult" => 58,"Gangsta" => 59,
"Top 40" => 60,"Christian Rap" => 61,"Pop/Funk" => 62,"Jungle" => 63,"Native American" => 64,"Cabaret" => 65,"New Wave" => 66,
"Psychadelic" => 67,"Rave" => 68,"Showtunes" => 69,"Trailer" => 70,"Lo-Fi" => 71,"Tribal" => 72,"Acid Punk" => 73,
"Acid Jazz" => 74,"Polka" => 75,"Retro" => 76,"Musical" => 77,"Rock & Roll" => 78,"Hard Rock" => 79,"Folk" => 80,
"Folk-Rock" => 81,"National Folk" => 82,"Swing" => 83,"Fast Fusion" => 84,"Bebob" => 85,"Latin" => 86,"Revival" => 87,
"Celtic" => 88,"Bluegrass" => 89,"Avantgarde" => 90,"Gothic Rock" => 91,"Progressive Rock" => 92,"Psychedelic Rock" => 93,
"Symphonic Rock" => 94,"Slow Rock" => 95,"Big Band" => 96,"Chorus" => 97,"Easy Listening" => 98,"Acoustic" => 99,
"Humour" => 100,"Speech" => 101,"Chanson" => 102,"Opera" => 103,"Chamber Music" => 104,"Sonata" => 105,"Symphony" => 106,
"Booty Bass" => 107,"Primus" => 108,"Porn Groove" => 109,"Satire" => 110,"Slow Jam" => 111,"Club" => 112,"Tango" => 113,
"Samba" => 114,"Folklore" => 115,"Ballad" => 116,"Power Ballad" => 117,"Rhythmic Soul" => 118,"Freestyle" => 119,
"Duet" => 120,"Punk Rock" => 121,"Drum Solo" => 122,"Acapella" => 123,"Euro-House" => 124,"Dance Hall" => 125
);

 $version=Array("00"=>2.5, "10"=>2, "11"=>1);
 $layer  =Array("01"=>3, "10"=>2, "11"=>1);
 $crc=Array("Yes", "No");
 $bitrate["0001"]=Array(32,32,32,32,8,8);
 $bitrate["0010"]=Array(64,48,40,48,16,16);
 $bitrate["0011"]=Array(96,56,48,56,24,24);
 $bitrate["0100"]=Array(128,64,56,64,32,32);
 $bitrate["0101"]=Array(160,80,64,80,40,40);
 $bitrate["0110"]=Array(192,96,80,96,48,48);
 $bitrate["0111"]=Array(224,112,96,112,56,56);
 $bitrate["1000"]=Array(256,128,112,128,64,64);
 $bitrate["1001"]=Array(288,160,128,144,80,80);
 $bitrate["1010"]=Array(320,192,160,160,96,96);
 $bitrate["1011"]=Array(352,224,192,176,112,112);
 $bitrate["1100"]=Array(384,256,224,192,128,128);
 $bitrate["1101"]=Array(416,320,256,224,144,144);
 $bitrate["1110"]=Array(448,384,320,256,160,160);
 $bitindex=Array("1111"=>"0","1110"=>"1","1101"=>"2","1011"=>"3","1010"=>"4","1001"=>"5","0011"=>"3","0010"=>4,"0001"=>"5");
 $freq["00"]=Array("11"=>44100,"10"=>22050,"00"=>11025);
 $freq["01"]=Array("11"=>48000,"10"=>24000,"00"=>12000);
 $freq["10"]=Array("11"=>32000,"10"=>16000,"00"=>8000);
 $mode=Array("00"=>"Stereo","01"=>"Joint stereo","10"=>"Dual channel","11"=>"Mono");
 $copy=Array("No","Yes");

 function strip_nulls( $str ) {
   $res = explode( chr(0), $str );
   return chop( $res[0] );
 }

 function mp3_id($file) {
   global $version, $layer, $crc, $bitrate, $bitindex, $freq, $mode, $copy, $genres;
   if(!$f=@fopen($file, "r")) { return -1; break; } else {

     $tmp=fread($f,4);
     if($tmp=="RIFF") {
       $idtag["ftype"]="Wave";
       fseek($f, 0);
       $tmp=fread($f,128);
       $x=StrPos($tmp, "data");
       fseek($f, $x+8);
       $tmp=fread($f,4);
     }

     for($y=0;$y<4;$y++) {
       $x=decbin(ord($tmp[$y]));
       for($i=0;$i<(8-StrLen($x));$i++) {$x.="0";}
       $bajt.=$x;
     }


     if(substr($bajt,1,11)!="11111111111") {
       fseek($f, 4);
       $tmp=fread($f,2048);
         for($i=0;$i<2048;$i++){
           if(ord($tmp[$i])==255 && substr(decbin(ord($tmp[$i+1])),0,3)=="111") {
              $tmp=substr($tmp, $i,4);
              $bajt="";
              for($y=0;$y<4;$y++) {
                $x=decbin(ord($tmp[$y]));
                for($i=0;$i<(8-StrLen($x));$i++) {$x.="0";}
                $bajt.=$x;
              }
              break;
            }
          }
     }
     if($bajt=="") {
        return -1;
        break;
     }

     $len=filesize($file);
     $idtag["version"]=$version[substr($bajt,11,2)];
     $idtag["layer"]=$layer[substr($bajt,13,2)];
     $idtag["crc"]=$crc[$bajt[15]];
     $idtag["bitrate"]=$bitrate[substr($bajt,16,4)][$bitindex[substr($bajt,11,4)]];
     $idtag["frequency"]=$freq[substr($bajt,20,2)][substr($bajt,11,2)];
     $idtag["padding"]=$copy[$bajt[22]];
     $idtag["mode"]=$mode[substr($bajt,24,2)];
     $idtag["copyright"]=$copy[$bajt[28]];
     $idtag["original"]=$copy[$bajt[29]];

     if($idtag["layer"]==1) {
       $fsize=(12*($idtag["bitrate"]*1000)/$idtag["frequency"]+$idtag["padding"])*4; }
     else {
     $fsize=144*(($idtag["bitrate"]*1000)/$idtag["frequency"]+$idtag["padding"]);}
     $idtag["lenght_sec"]=round($len/Round($fsize)/38.37);
     $idtag["lenght"]=date("i:s",round($len/Round($fsize)/38.37));

     if(!$len) $len=filesize($file);
     fseek($f, $len-128);
     $tag = fread($f, 128);
     if(Substr($tag,0,3)=="TAG") {
       $idtag["file"]=$file;
       $idtag["tag"]=-1;

       $idtag["title"]=strip_nulls( Substr($tag,3,30) );
       $idtag["artist"]=strip_nulls( Substr($tag,33,30) );
       $idtag["album"]=strip_nulls( Substr($tag,63,30) );
       $idtag["year"]=strip_nulls( Substr($tag,93,4) );
       $idtag["comment"]=strip_nulls( Substr($tag,97,30) );

       if ( strlen( $idtag["comment"] ) < 29 ) {
         if ( Ord(Substr($tag,125,1)) == chr(0) ) 
           $idtag["track"]=Ord(Substr($tag,126,1));
         else 
           $idtag["track"]=0;
       } else { 
         $idtag["track"]=0;
       }

       $idtag["genreid"]=Ord(Substr($tag,127,1));
       $idtag["genre"]=$genres[$idtag["genreid"]];
       $idtag["filesize"]=$len;
     } else {
       $idtag["tag"]=0;
     }


   if(!$idtag["title"]) {
     $idtag["title"]=Str_replace("\\","/", $file);
     $idtag["title"]=substr($idtag["title"],strrpos($idtag["title"],"/")+1, 255);
   }
   fclose($f);
   return $idtag;
   }
 }

 function str_padtrunc( $str, $len, $with = " " ) {
   $l = strlen( $str );
   if ( $len < $l ) {
     return substr( $str, 0, $len );
   } elseif ( $len > $l ) {
     $s = "";
     for ( $i = 0; $i < ($len - $l); $i++) {
       $s .= $with;
     }
     return $str . $s;
   } else
     return $str;
 }


?>

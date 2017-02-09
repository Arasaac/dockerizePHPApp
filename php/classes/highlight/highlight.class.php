<?php
class Highlighter
{
	function normaliza($cadena){
		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
	ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
		$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
	bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$cadena = utf8_decode($cadena);
		$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
		//$cadena = strtolower($cadena);
		return utf8_encode($cadena);
	}

    //$sentence is the sentence that you are looking for
    //$rech is the word you searching in the sentence
	function CheckSentence($sentence,$rech)
	{	
		$sentence_original=$sentence;
		$rech_original=$rech;
		
		$sentence=$this->normaliza($sentence);
		$rech=$this->normaliza($rech);
		
		$len = strlen($rech);
		
		if ($len != 0) 
		{
			$find = $sentence;
		
			while ($find = stristr($find, $rech)) // find $search text - case insensitiv
			{	
				$txt = substr($find, 0, $len);	// get new search text 
				$find = substr($find, $len);
				
				$len_original = strlen($rech_original);
				$txt_original = substr($sentence_original,0,$len_original+1);	// get new search text 
				
				if (strtolower($rech_original)==strtolower($rech)) {
				
				$subject1 = str_replace($txt,$txt,$sentence);
					
					if ($sentence_original==$subject1) {
						$subject = str_replace($txt, "<font style='color:black; background-color:yellow;'>" . $rech_original ."</font>", $sentence);
					} else {
						$subject = str_replace($txt, "<font style='color:black; background-color:yellow;'>" . $txt_original ."</font>", $sentence);
						
					}
				} elseif (strtolower($rech_original)!=strtolower($rech)) {
					
					$subject1 = str_replace($txt,$rech_original,$sentence);
					
					if ($sentence_original==$subject1) {
						$subject = str_replace($txt, "<font style='color:black; background-color:yellow;'>" . $rech_original ."</font>", $sentence);
					} else {
						$subject = str_replace($txt, "<font style='color:black; background-color:yellow;'>" . $txt ."</font>", $sentence);
						
					}
					
				}
				
			}
		}			
		// depend what you need. i used a return just for the demo page
        return @$subject ;
        //echo $subject ;
	}
}

?>
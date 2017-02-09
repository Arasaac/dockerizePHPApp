<?php 
$dl = new detect_language;
   //si no he recibido el idioma que desea el usuario en la página, miro si hay una cookie creada
   if (isset($_COOKIE["selected_language"])){
   
      //es que tengo la cookie
      $_SESSION['language'] = $_COOKIE["selected_language"];
	  
	  	 switch ($_COOKIE["selected_language"]) {
   
			case 'es':
			$_SESSION['id_language']=0;
			break;
			
			case 'en':
			$_SESSION['id_language']=7;
			break;
			
			case 'fr':
			$_SESSION['id_language']=8;
			break;
			
			case 'ca':
			$_SESSION['id_language']=9;
			break;	
			
			case 'pt':
			$_SESSION['id_language']=13;
			break;
			
			case 'br':
			$_SESSION['id_language']=15;
			break;
			
			case 'ro':
			$_SESSION['id_language']=2;
			break;
			
			case 'ar':
			$_SESSION['id_language']=3;
			break;
			
			case 'eu':
			$_SESSION['id_language']=10;
			break;
			
			case 'val':
			$_SESSION['id_language']=17;
			break;
  		 }
	  
   } else { //si no hay coookie muestro el idioma del navegador 
   
   		if ($dl->detected_language != ''){
			if ($dl->detected_language == "es"){$_SESSION['language'] = "es"; $_SESSION['id_language']=0; }
			elseif ($dl->detected_language == "en"){$_SESSION['language'] = "en"; $_SESSION['id_language']=7; }
			elseif ($dl->detected_language == "fr"){$_SESSION['language'] = "fr"; $_SESSION['id_language']=8; }
			elseif ($dl->detected_language == "ca"){$_SESSION['language'] = "ca"; $_SESSION['id_language']=9; }
			elseif ($dl->detected_language == "pt"){$_SESSION['language'] = "pt"; $_SESSION['id_language']=13; }
			elseif ($dl->detected_language == "pt-br"){$_SESSION['language'] = "br"; $_SESSION['id_language']=15; }
			elseif ($dl->detected_language == "ro"){$_SESSION['language'] = "ro"; $_SESSION['id_language']=2; }
			elseif ($dl->detected_language == "ar"){$_SESSION['language'] = "ar"; $_SESSION['id_language']=3; }
			elseif ($dl->detected_language == "eu"){$_SESSION['language'] = "eu"; $_SESSION['id_language']=10; }
			elseif ($dl->detected_language == "val"){$_SESSION['language'] = "val"; $_SESSION['id_language']=17; }
			else { $_SESSION['language'] = "es"; $_SESSION['id_language']=0; } 
			//$idioma_pruebas=$dl->detected_language;
			
		} else {
			$_SESSION['language'] = "es"; $_SESSION['id_language']=0;
		}
   
		
   }

class detect_language {
	var $available_languages, $accepted_language, $detected_language;

	// Constructor
	function detect_language() {
	  $this->available_languages = array(
		'bg'         => array('bg|bulgarian', 'bulgarian-win1251'),
		'ca'         => array('ca|catalan', 'catala'),
		'cs-iso'     => array('cs|czech', 'czech-iso'),
		'cs-win1250' => array('cs|czech', 'czech-win1250'),
		'da'         => array('da|danish', 'danish'),
		'de'         => array('de([-_][[:alpha:]]{2})?|german', 'german'),
		'en'         => array('en([-_][[:alpha:]]{2})?|english', 'english'),
		'es'         => array('es([-_][[:alpha:]]{2})?|spanish', 'spanish'),
		'fr'         => array('fr([-_][[:alpha:]]{2})?|french', 'french'),
		'it'         => array('it|italian', 'italian'),
		'ja'         => array('ja|japanese', 'japanese'),
		'ko'         => array('ko|korean', 'korean'),
		'nl'         => array('nl([-_][[:alpha:]]{2})?|dutch', 'dutch'),
		'no'         => array('no|norwegian', 'norwegian'),
		'pl'         => array('pl|polish', 'polish'),
		'pt-br'      => array('pt[-_]br|brazilian portuguese', 'brazilian_portuguese'),
		'pt'         => array('pt([-_][[:alpha:]]{2})?|portuguese', 'portuguese'),
		'ru-koi8r'   => array('ru|russian', 'russian-koi8'),
		'ru-win1251' => array('ru|russian', 'russian-win1251'),
		'ro'         => array('ro|romanian', 'romanian'),
		'se'         => array('se|swedish', 'swedish'),
		'sk'         => array('sk|slovak', 'slovak-iso'),
		'th'         => array('th|thai', 'thai'),
		'zh-tw'      => array('zh[-_]tw|chinese traditional', 'chinese_big5'),
		'zh'         => array('zh|chinese simplified', 'chinese_gb'),
		//'eu-utf-8'   => array('eu|basque', 'basque-utf-8'),
		//'eu-iso-8859-1' => array('eu|basque', 'basque-iso-8859-1')
	  );

	  $this->accepted_language = explode(',', getenv('HTTP_ACCEPT_LANGUAGE'));

	  $this->detected_language = $this->getLanguage();
	}

	/*
	  getLanguage
	  -----------
	  function that look for prefered language by browser.

	  Input: -
	  Output: language detected or default language (en).
	*/
	function getLanguage() {
	  if (empty($this->detected_language)) {
		$this->detected_language = 'en';
		$cnt = 0;

		while ($cnt < sizeof($this->accepted_language)) {
		  reset($this->available_languages);

		  while (list($key, $value) = each($this->available_languages)) {
			if ((preg_match('/^(' . $value[0] . ')(;q=[0-9]\\.[0-9])?$/i', $this->accepted_language[$cnt]))) {
			  $this->detected_language = $key;
			  break 2;
			}
		  }
		  $cnt++;
		}
	  }

	  return $this->detected_language;
	}
  }
  
  
//$_SESSION['language']='en';
//$_SESSION['id_language']=7;
?>
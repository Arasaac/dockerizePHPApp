<?php
// PHP Proxy
// Responds to both HTTP GET and POST requests
//
// Author: Abdul Qabiz
// March 31st, 2006
//

/*
cURL / special chars / returned audio issue:

header:							header('Content-Type: text/html; charset=utf-8');
query sent:						p%C3%A9lda
decoded data without header:	pÃ©lda	(cURL returns this)
decoded data with header:		példa	(correct)

cURL returns raw data only, so while returned text can be decoded after the cURL execution along with the above header, audio cannot.
i've also tried sending this header via CURLOPT_HTTPHEADER as seen below with no luck.
*/

header('Content-Type: text/html; charset=utf-8');
// Get the url of to be proxied
// Is it a POST or a GET?
//$url0 = "http://translate.google.com/translate_tts?tl=hu&q=p%C3%A9lda";
//$url0 = "http://translate.google.com/translate_tts?tl=hu&q=példa";
//$url0 = "http://translate.google.com/translate_tts?tl=hu&q=pÃ©lda";
$url0 = ($_POST['url']) ? $_POST['url'] : $_GET['url'];
$url = urldecode($url0);
//$url = header('Location: '.$url0);
//$headers = ($_POST['headers']) ? $_POST['headers'] : $_GET['headers'];
//$mimeType =($_POST['mimeType']) ? $_POST['mimeType'] : $_GET['mimeType'];
//$mimeType = "audio/mpeg";
//$mimeType = "text/html; charset=utf-8";

//Start the Curl session
$session = curl_init($url);

// If it's a POST, put the POST data in the body
if ($_POST['url']) {
	$postvars = '';
	while ($element = current($_POST)) {
		$postvars .= key($_POST).'='.$element.'&';
		next($_POST);
	}
	curl_setopt ($session, CURLOPT_POST, true);
	curl_setopt ($session, CURLOPT_POSTFIELDS, $postvars);
}

// Don't return HTTP headers. Do return the contents of the call
//curl_setopt($session, CURLOPT_HEADER, true);
//curl_setopt($session, CURLOPT_BINARYTRANSFER, true);
//curl_setopt($session, CURLOPT_HEADER, ($headers == "true") ? true : false);
curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: text/html; charset=utf-8"));
curl_setopt($session, CURLOPT_FOLLOWLOCATION, true);
//curl_setopt($ch, CURLOPT_TIMEOUT, 4);
//curl_setopt($session, CURLOPT_ENCODING, '');
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// Make the call
//$response = curl_exec($session);
$response = curl_exec($session);

if ($mimeType != "") {
	// The web service returns XML. Set the Content-Type appropriately
	header("Content-Type: ".$mimeType);
	//header("Content-Type: text/html; charset=utf-8");
}

echo $response;
//echo $url;
//header('Location: '.$url);

curl_close($session);
?>
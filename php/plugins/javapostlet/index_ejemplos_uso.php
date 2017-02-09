<?php 
session_start();  // INICIO LA SESION
if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { 

echo '<html>
	<head>
		<title>Subida de Archivos</title>
	</head>
	
	<body>
		<applet name="postlet" code="Main.class" archive="postlet.jar" width="100%" height="95%" mayscript>
			<param name = "maxthreads"		value = "3" />
			<param name = "language"		value = "es" />
			<param name = "type"			value = "application/x-java-applet;version=1.3.1" />
			<param name = "destination"		value = "http://arasaac.org/plugins/javapostlet/upload_ejemplos_uso.php" />
			<param name = "backgroundcolour" value = "16777215" />
			<param name = "tableheaderbackgroundcolour" value = "14079989" />
			<param name = "tableheadercolour" value = "0" />
			<param name = "warnmessage" value = "false" />
			<param name = "autoupload" value = "false" />
			<param name = "helpbutton" value = "false" />
			<param name = "fileextensions" value = "Archivos,zip,rar,gif,exe,jpg,png" />
			<param name = "endpage" value = "http://arasaac.org/plugins/javapostlet/index_ejemplos_uso.php" />
			<param name = "helppage" value = "http://www.postlet.com/help/?thisIsTheDefaultAnyway" />
		</applet>
	</body>
</html>';

}

?>


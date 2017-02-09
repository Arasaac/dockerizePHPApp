<? 
$id_panel=$_GET['id_panel'];
$id_usuario=$_GET['id_usuario'];

$id=rand(1,100000);

header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"panel_".$id_panel."_".$id_usuario.".pdf\"");
//session_destroy();
passthru("htmldoc --format pdf --left 2.5cm --right 1.5cm --top 1.5cm --bottom 1.5cm " .
    "--headfootsize 9 --header '  l' --footer '/ t' " .
	"--logoimage http://catedu.es/arablogs/images/arablogs_logo.png --linkcolor '#666666' " .
    "--size 'a4' --fontsize 10 --charset 8859-15 --color --links --bodyfont {helvetica} --textfont {helvetica} " .
    "--webpage http://catedu.es/arasaac/inc/herramientas/creador_paneles/exportar_panel.php?i=$id_panel-$id_usuario"); 	
?>

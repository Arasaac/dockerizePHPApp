<?php
include('../funciones/funciones.php');
$dir="../temp/";
$borrar=CleanFiles($dir); //Borro los archivos temporales
$nombre_img=basename(tempnam("../../temp",'tmp')); 
$ext= explode (".", $_FILES['image']['name']);

$ftmp = $_FILES['image']['tmp_name'];
$ofname = $_FILES['image']['name'];
$oname = $nombre_img.".".$ext[1];
$fname = '../temp/'.$nombre_img.".".$ext[1];

if ($ext[1]=='flv') { 
	if(move_uploaded_file($ftmp, $fname)){
		?>
		<html><head><script>
		var par = window.parent.document;
		var images = par.getElementById('simbolo');
		images.innerHTML="<form id=\"img_subida\" name=\"img_subida\" method=\"post\" action=\"\"><input name=\"imagen_subida\" type=\"hidden\" id=\"imagen_subida\" value=\"<?php echo $oname; ?>\"/><input name=\"original_filename\" type=\"hidden\" id=\"original_filename\" value=\"<?php echo $ofname; ?>\"/></form>";
		</script></head>
		</html>
		<?php
		exit();
	}
} else { 
	if(move_uploaded_file($ftmp, $fname)){
		?>
		<html><head><script>
		var par = window.parent.document;
		var images = par.getElementById('simbolo');
		images.innerHTML="<img src=\"temp/<?php echo $oname; ?>\"><form id=\"img_subida\" name=\"img_subida\" method=\"post\" action=\"\"><input name=\"imagen_subida\" type=\"hidden\" id=\"imagen_subida\" value=\"<?php echo $oname; ?>\"/><input name=\"original_filename\" type=\"hidden\" id=\"original_filename\" value=\"<?php echo $ofname; ?>\"/></form>";
		</script></head>
		</html>
		<?php
		exit();
	}
}
?><html><head>
<script language="javascript">
function upload(){
	// hide old iframe
	var par = window.parent.document;
	var num = par.getElementsByTagName('iframe').length - 1;
	var iframe = par.getElementsByTagName('iframe')[num];
	iframe.className = 'hidden';
	
	// create new iframe
	var new_iframe = par.createElement('iframe');
	new_iframe.src = 'inc/upload.php';
	new_iframe.frameBorder = '0';
	par.getElementById('iframe').appendChild(new_iframe);
	
	// send
	//var imgnum = images.getElementsByTagName('div').length - 1;
	document.iform.imgnum.value = 0;
	document.iform.submit();
}
</script>
<style>
#file {
	width: 200px;
}

input, select    { border: 1px solid #000; font-size:10px; }
input.error, select.error {padding-right: 16px; border: 1px solid red; background-color: #FFFCE2; background-image: url(../../images/warning_obj.gif); background-position: right; background-repeat: no-repeat;}
input:focus, select:focus {border: 1px solid red; background-color:#EFEFEF;}
</style>
<head><body><center>
<form name="iform" action="" method="post" enctype="multipart/form-data">
<input id="file" type="file" name="image" onChange="upload()" />
<input type="hidden" name="imgnum" />
</form>
</center></html>
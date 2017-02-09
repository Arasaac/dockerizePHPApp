<?php session_start();  // INICIO LA SESION ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script type="text/javascript" src="js/ajax2.js"></script>
</head>
<body style="overflow:hidden;">
   <div align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;"><a href="javascript:void(0);" onclick="sintetiza('<?php echo utf8_decode($_GET['palabra']); ?>','Jorge');"/><img src="images/altavoz.png" border="0" alt="Pulsar para escuchar locución" title="Pulsar para escuchar locución" /><br />Pulsar para escuchar</a></div>
     <?php if ($_SESSION['language']=='es') {  ?>
	<div style="visibility:hidden; width:40px;">
	<?php include ('applet_vivoreco.html'); ?>
    </div>
   <?php }  ?>
</body>
</html>
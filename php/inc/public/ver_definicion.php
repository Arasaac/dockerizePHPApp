<?php 
include ('../../classes/querys/query.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');
include ('../../funciones/funciones.php');

$id_palabra=$_GET['i'];
$query=new query();
$datos_palabra=$query->datos_palabra($id_palabra);
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="../../plugins/flowplayer/flowplayer-3.1.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../plugins/flowplayer/style.css">
<title>Ver definicion de <?php echo $datos_palabra['palabra']; ?></title>
</head><body>
	<a id="<?php echo $id_palabra; ?>"
		href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/<?php if ($_SERVER['SERVER_NAME']=='localhost') { echo 'saac'; } elseif ($_SERVER['SERVER_NAME']=='arasaac.org') { echo ''; } elseif ($_SERVER['SERVER_NAME']=='catedu.es') { echo 'arasaac'; } ?>/repositorio/LSE_definiciones/<?php echo $id_palabra; ?>.flv"
		class="player"> 
	</a> 
	<script>
		flowplayer("<?php echo $id_palabra; ?>", "../../plugins/flowplayer/flowplayer-3.1.1.swf",{
			clip: {
			    autoBuffering: true,
				autoPlay: false,
				bufferLength: 2,
				scaling: "fit"
			  },
			 
			play: { 
            label: 'Reproducir', 
            replayLabel: 'Repetir' 
        	}
		});
	</script>
</body></html>
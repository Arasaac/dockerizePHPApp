<?php 
include ('../../classes/querys/query.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');
include ('../../funciones/funciones.php');

$id_imagen=$_GET['i'];
$query=new query();
$datos_imagen=$query->datos_imagen($id_imagen);
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="../../plugins/flowplayer/flowplayer-3.1.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../plugins/flowplayer/style.css">
<title>Ver traduccion a LSE de la palabra: <?php echo $datos_imagen['palabra']; ?></title>
</head><body>
	<a id="<?php echo $id_imagen; ?>"
		href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/<?php if ($_SERVER['SERVER_NAME']=='localhost') { echo 'saac'; } elseif ($_SERVER['SERVER_NAME']=='arasaac.org') { echo ''; } elseif ($_SERVER['SERVER_NAME']=='catedu.es') { echo 'arasaac'; } ?>/repositorio/LSE_acepciones/<?php echo $id_imagen; ?>.flv"
		class="player">  
	</a> 
    <?php /* <img src="../../plugins/flowplayer/play-catedu.jpg" alt="Traduccion a LSE de la palabra: <?php echo $datos_imagen['palabra']; ?>"/><?php */?>
	<script>
		flowplayer("<?php echo $id_imagen; ?>", "../../plugins/flowplayer/flowplayer-3.1.1.swf",{
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
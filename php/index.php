<?php 
require('requires_basico_sin_sesion.php');
require('operaciones_cesto.php');
require('funciones/funciones.php');

require ('configuration/key.inc');
require ('classes/crypt/5CR.php');
$encript = new E5CR($llave);

$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],2); 

//Con este código elimino la variable pg que es dinamica
$str = $_SERVER['QUERY_STRING'];
parse_str($str, $info);
unset($info['pg']);
$cadena_url=http_build_query($info);
if ($cadena_url !='') { $cadena_url=http_build_query($info).'&'; }
//************************************************************
/*$permisos=$query->permisos_usuario($_SESSION['ID_USER']);*/
require('buscar_por_palabra.php');

require('cabecera_html.php');
?>	
    <title>ARASAAC: <?php echo $translate['portal_aragones_caa_txt']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
    <link rel="stylesheet" href="js/autoComplete/autoComplete_css2.css" type="text/css" media="screen" charset="utf-8" />
	<script type="text/javascript" src="js/autoComplete/jquery-1.2.1.pack.js"></script>
	<script type="text/javascript" src="js/ajax2.js"></script>
    <script type="text/javascript" src="js/prototype/prototype.js"> </script>
    <script type="text/javascript">
        var GB_ROOT_DIR = "js/greybox_v5/";
    </script>
    <script type="text/javascript" src="js/greybox_v5/AJS.js"></script>
    <script type="text/javascript" src="js/greybox_v5/AJS_fx.js"></script>
    <script type="text/javascript" src="js/greybox_v5/gb_scripts.js"></script>
    <script type="text/javascript">
      window.___gcfg = {lang: '<?php echo $_SESSION['language']; ?>'};
    
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
    <link href="js/greybox_v5/gb_styles.css" rel="stylesheet" type="text/css" media="all" /> 
    <?php require ('text_size_css.php'); ?>
	<?php 
    //Averiguar resolucion en pantalla
    //********************************************
    $siteurl = $_SERVER['REQUEST_URI'];
    $GLOBALS['siteurl'] = $siteurl;
    require('funciones/getres.php');
    ?>
</head>
<body>
<?php include_once('include_facebook.php'); ?>
<div class="body_content"> 

	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
        <?php include ('menu_principal.php'); ?>
        <br /><h4><?php echo $translate['bienvenidos_arasaac']; ?></h4><br />
        <div id="clearcarpeta_trabajo"><?php echo $translate['descripcion_arasaac_breve_3']; ?></div>
        <?php include ('buscador.php'); ?>
        <?php include ('cesto_ajax.php'); ?>               
		<div id="principal">
			<?php  if (isset($resultados) && $resultados !='') { ?>
           	 <form action="<?php echo $PHP_SELF; ?>" method="POST" name="descarga_pictogramas" id="descarga_pictogramas">  
				<?php echo $resultados; ?>
             </form>
             <?php 
			} else {
				include ('inicio.php'); 
			}
			?>
       	</div>
	    <?php include ('footer_new.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
	<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function(event) { 
	  //your code
	  cargar_div2('n_elementos_cesto.php','i=','n_cesto');
	});
	</script>
</html>
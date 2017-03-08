<?php 
require('requires_basico.php');
require ('funciones/funciones.php');
require ('operaciones_cesto.php');
require ('configuration/key.inc');
require ('classes/crypt/5CR.php');
require ('classes/highlight/highlight.class.php'); 
require ('classes/highlight/highlight_idiomas.class.php');
$resaltar_idiomas = new Highlighter_idiomas();
$resaltar = new Highlighter();
$encript = new E5CR($llave);

//require ('classes/zip/pclzip.lib.php');
/*require ('classes/inputfilter/class.inputfilter.php');*/
/* INICIALIZO LA CLASE FILTER QUE PREVIENE ATAQUES XSS de INYECCION DE CODIGO HTML */
//$ifilter = new InputFilter();


$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],8); 
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
include ('inc/menu_administracion.php');

//Con este código elimino la variable pg que es dinamica
$str = $_SERVER['QUERY_STRING'];
parse_str($str, $info);
unset($info['product_id']);
$cadena_url=http_build_query($info);
if ($cadena_url !='') { $cadena_url=http_build_query($info).'&'; }
//************************************************************

require('buscar_por_palabra.php');
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['portal_aragones_caa_txt']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
    <link rel="stylesheet" href="js/autoComplete/autoComplete_css.css" type="text/css" media="screen" charset="utf-8" />
	<script type="text/javascript" src="js/ajax2.js"></script>
    <script type="text/javascript" src="js/prototype/prototype.js"> </script>
    <script type="text/javascript">
        var GB_ROOT_DIR = "js/greybox_v5/";
    </script>
    <script type="text/javascript" src="js/greybox_v5/AJS.js"></script>
    <script type="text/javascript" src="js/greybox_v5/AJS_fx.js"></script>
    <script type="text/javascript" src="js/greybox_v5/gb_scripts.js"></script>
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
            
<div class="body_content"> 
	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
        <?php include ('menu_principal.php'); ?>
        <?php include ('menu_subprincipal_catalogos.php'); ?>
        <?php include ('buscador.php'); ?>
        <?php include ('cesto_ajax.php'); ?>  
		<div id="principal">
        <?php  if (isset($resultados) && $resultados !='') { ?>
           	 <form action="<?php echo $PHP_SELF; ?>" method="POST" name="descarga_pictogramas" id="descarga_pictogramas">  
				<?php echo $resultados; ?>
             </form>
         <?php 
		} 
		?>
       <?php if ($_SESSION['language']=='es') {  ?>
       <div class="alineacion_derecha" style="visibility:hidden;">
			<?php //include ('applet_vivoreco.html'); ?>
        </div>
        <?php }  ?>
        </div><br />
	    <?php include ('footer.php'); ?>
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


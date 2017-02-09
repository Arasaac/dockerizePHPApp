<?php 
require('requires_basico.php');
require('operaciones_cesto.php');
require ('funciones/funciones.php');

require ('classes/highlight/highlight.class.php'); 
$resaltar = new Highlighter();

require ('configuration/key.inc');
require ('classes/crypt/5CR.php');
$encript = new E5CR($llave);

require_once('classes/phptreemenu/layersmenu-common.inc.php');
require_once('classes/phptreemenu/layersmenu.inc.php');
require_once('classes/phptreemenu/phptreemenu.inc.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],11); 

//Con este código elimino la variable pg que es dinamica
$str = $_SERVER['QUERY_STRING'];
parse_str($str, $info);

$str1 = $_SERVER['QUERY_STRING'];
parse_str($str1, $info1);

$str2 = $_SERVER['QUERY_STRING'];
parse_str($str2, $info2);

$str3 = $_SERVER['QUERY_STRING'];
parse_str($str3, $info3);
//************************************************************

//************************************************************

//INICIALIZO VARIABLES
//************************************************************
$array_subcategorias='';
$array_subcategorias=array();
$array_categorias='';
$array_categorias=array();
$sql='';
//************************************************************

if (isset($_GET['busqueda'])) {
	
	if (isset($_GET['busqueda']) && $_GET['busqueda']=='basico') {
		
		if (!isset($_GET['TXTlocate'])) {
			$txt_locate=1; 
		} else { $txt_locate=$_GET['TXTlocate']; }
		
		if (!isset($_GET['tipo_palabra'])) {
			$id_tipo=99; 
		} else { $id_tipo=$_GET['tipo_palabra']; }
		
		if (!isset($_GET['id_subtema'])) {
			$id_subtema=99999; 
			$busqueda_subtema="";
		} else { 
			$id_subtema=$_GET['id_subtema']; 
			$subtema=$query->datos_subtema($id_subtema);
			if ($_GET['id_subtema'] != 99999) { $busqueda_subtema="<h4>".$translate['resultados_para'].": ".$subtema['tema']."/".$subtema['subtema']."</h4>"; }
		}
		
		if (isset($_GET['id_tema']) && $_GET['id_tema'] > 0) {
			$sql.="AND palabra_subtema.tema_id=".$_GET['id_tema']."
					";
		}
		
		if (!isset($_GET['letra'])) {
			$letra=''; 
			$busqueda="";
		} else { 
			$letra=$_GET['letra']; 
			if ($_GET['letra'] != "") { $busqueda="<h4>".$translate['resultados_para'].": ''".utf8_encode($_GET['letra'])."''</h4>"; }
		}			
		
		if (!isset($_GET['filtrado'])) {
			$filtrado=1; 
		} else { $filtrado=$_GET['filtrado']; }	
		
		if (!isset($_GET['orden'])) {
			$orden="desc"; 
		} else { $orden=$_GET['orden']; }	
				
		if (isset($_GET['subcategoria']) && $_GET['subcategoria'] !='') {
			foreach( $_GET['subcategoria'] as $nombre_campo => $valor) {
				if ($valor != '') {
					$sql.="AND palabra_subtema.id_subtema=".$valor."
					";
					$array_subcategorias[]=$valor;
				}
			}
		}
		
		if (isset($_GET['categoria']) && $_GET['categoria'] !='') {
			foreach( $_GET['categoria'] as $nombre_campo => $valor) {
				if ($valor != '') {
					$sql.="AND palabra_subtema.tema_id=".$valor."
					";
					$array_categorias[]=$valor;
				}
			}
		}
	
	
	}
	
} else { 
	$id_tipo=99;
	$letra="";
	$orden="desc";
	$filtrado="1";
	$id_subtema=99999;
	$busqueda="";
	$txt_locate=1;
}
	
if (!isset($_GET['pg'])) {
	$pg = 0; // $pg es la pagina actual
} else { $pg=$_GET['pg']; }
					
	//require('funciones/n_items_resolucion.php');	
	$cantidad=18;
	$inicial = $pg * $cantidad;
					
	$limite_inferior="5"; //resultados por debajo de la pagina actual
	$page_limit = $limite_inferior;
					
	$limitpages = $page_limit;
	$page_limit = $pg + $limitpages;
		
	$tipo_pictograma=2; 
		
		if ($_SESSION['id_language'] > 0) {
		
			$contar=$query->listar_originales_idioma($_SESSION['AUTHORIZED'],$id_tipo,$letra,$filtrado,$orden,$id_subtema,$_SESSION['id_language'],$tipo_pictograma,$txt_locate,$sql);
			$resultados=$query->listar_originales_idioma_limit($_SESSION['AUTHORIZED'],$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$_SESSION['id_language'],$tipo_pictograma,$txt_locate,$sql);
						
		} else {
			
			$contar=$query->listar_originales($_SESSION['AUTHORIZED'],$id_tipo,$letra,$filtrado,$orden,$id_subtema,$tipo_pictograma,$sql,$txt_locate);
			$resultados=$query->listar_originales_limit($_SESSION['AUTHORIZED'],$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$tipo_pictograma,$sql,$txt_locate);
			
		}
					
	$total_records = $contar;
	$total_pages = intval($total_records / $cantidad);

require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['fotografias']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
    <script type="text/javascript" src="js/js_catalogos.js"></script>
    <script type="text/javascript">
        var GB_ROOT_DIR = "js/greybox_v5/";
    </script>
    <script type="text/javascript" src="js/greybox_v5/AJS.js"></script>
    <script type="text/javascript" src="js/greybox_v5/AJS_fx.js"></script>
    <script type="text/javascript" src="js/greybox_v5/gb_scripts.js"></script>
    <link href="js/greybox_v5/gb_styles.css" rel="stylesheet" type="text/css" media="all" />
    <?php require ('text_size_css.php'); ?>
</head>

<body>
            
<div class="body_content"> 

  <div class="header">
  	<?php include('cabecera.php'); ?>  
  </div>
    <?php include ('menu_principal.php'); ?>
    <?php include ('menu_subprincipal_catalogos.php'); ?>
  <h4><?php echo $translate['fotografias']; ?>:</h4>
  <div id="principal">
  	<form action="<?php echo $PHP_SELF; ?>" method="get" name="busqueda_avanzada" id="busqueda_avanzada">
  		<?php unset($info1['buscador']); $cadena_url_buscador=http_build_query($info1); if ($cadena_url_buscador !='') { $cadena_url_buscador=http_build_query($info1).'&'; } ?>
        <?php unset($info2['arbol']); $cadena_url_arbol=http_build_query($info2); if ($cadena_url_arbol !='') { $cadena_url_arbol=http_build_query($info2).'&'; } ?>
        <?php require('barra_opciones_catalogos.php'); ?>
		<?php include('arbol_de_categorias.php'); ?>
		<?php include('buscador_simple_catalogos.php'); ?> 
    </form>
    <form action="<?php echo $PHP_SELF; ?>?<?php echo $cadena_url_buscador; ?>" method="POST" name="descarga_pictogramas" id="descarga_pictogramas">  
      	<?php if (isset($_GET['id']) && $_GET['id'] !='') { 
				require('ver_ficha.php'); 
			  } elseif (!isset($_GET['id']) || $_GET['id'] =='') { 
			  	require('resultados_catalogos.php'); 
			  } 
		?>
    </form>
  </div>
  <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


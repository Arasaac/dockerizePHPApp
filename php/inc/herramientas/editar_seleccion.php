<?php 
session_start();
include ('../../classes/querys/conexion.php');

$conexion=new config_db();

$host=$conexion->HOST;
$username=$conexion->USERNAME;
$password=$conexion->PASSWORD;
$dbname=$conexion->DBNAME;


$id_usuario=$_SESSION['ID_USER'];

	include ("js/phpMyDataGrid/phpmydatagrid.class.php");
	
	$objGrid = new datagrid;
	
	$objGrid -> friendlyHTML();

	$objGrid -> pathtoimages("js/phpMyDataGrid/images/");

	$objGrid -> closeTags(true);  
	
	$objGrid -> form('mis_selecciones', true);
	
	$objGrid -> methodForm("post"); 
	
	$objGrid -> searchby("id_seleccion,seleccion,tags");
	
	$objGrid -> linkparam("sess=".$_REQUEST["sess"]."&username=".$_REQUEST["username"]);	 
	
	$objGrid -> decimalDigits(2);
	
	$objGrid -> decimalPoint(",");
	
	$objGrid -> conectadb($host,$username,$password,$dbname);
	
	$objGrid -> tabla ("seleccion");

	$objGrid -> buttons(false,false,false,false); //1-Añadir 2-Editar  3-Borrar 4-Ver
	
	$objGrid -> keyfield("id_seleccion");

	$objGrid -> salt("");

	$objGrid -> TituloGrid("Mis Selecciones");

	$objGrid -> FooterGrid("");

	$objGrid -> datarows(10);
	
	$objGrid -> paginationmode('links');

	$objGrid -> orderby("id_seleccion", "DESC");
	
	$objGrid -> FormatColumn("id_seleccion", utf8_decode("ID Selección"), 5, 5, 1, "50", "center", "integer");
	$objGrid -> FormatColumn("seleccion", utf8_decode("Nombre Selección"), 30, 30, 0, "150", "left");
	$objGrid -> FormatColumn("fecha_creacion", utf8_decode("Fecha Creación"), 10, 10, 1, "100", "center", "date:dmy:/");
	$objGrid -> FormatColumn("fecha_modificacion", utf8_decode("Fecha Modificación"), 10, 10, 1, "100", "center", "date:dmy:/");
	$objGrid -> FormatColumn("tags", "Tags", 30, 30, 0, "150", "left");
	/* Dynamic image: Displaying an image link with a value stored in a field */
    /* Note: The %s in the image name will be replaced by the selected field, in this example by photo field */
    $objGrid -> FormatColumn("editar","Editar", "25", "0", "3","20","center","imagelink:../../images/edit.gif:goto(%s%s%s),id_seleccion,seleccion,fecha_modificacion");   

	$objGrid -> where ("id_usuario = '".$id_usuario."'");

if (!isset($_REQUEST["DG_ajaxid"])){ // If we intercept an AJAX request from page 
                                     // then do not display data below    
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.
         '<html xmlns="http://www.w3.org/1999/xhtml">'.
         '<head>'.
         '<meta http-equiv="Content-Type" content="text/html; charset=iso-8851" />'.
         '<meta name="description" content="Site description" />'.
         '<meta name="revisit-after" content="8 days" />'.
         '<meta name="keywords" content="keywords for site" />'.
         '<meta http-equiv="Pragma" content="no-cache" />'.
         '<meta name="robots" content="all" />'.
         '<meta http-equiv="Content-Script-Type" content="type" />'.
         '<title>ARASAAC Herramientas - Mis Selecciones</title>';

$objGrid -> setHeader();

?> 
<script src="js/scriptaculous/prototype.js" type="text/javascript"></script>
  <script src="js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
  <script src="js/scriptaculous/unittest.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/ajax_herramientas.js"></script>
  <link rel="stylesheet" href="../../css/style.css" type="text/css" />
<body>
<div class="body_content" id="content">
	<link rel="STYLESHEET" type="text/css" href="js/dhtmlxMenu/css/dhtmlXMenu.css">
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXProtobar.js"></script>
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXMenuBar.js"></script>
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXCommon.js"></script>
    <table width="100%">
	  <tr>
			<td width="78%">
			  <div id="menu_zone" style="width:600;background-color:#f5f5f5;border :1px solid Silver;"/>
			</td>
     <td width="22%">
<table width="100%" border="0">
              <tr>
                <td width="54%" align="right"> <a href="javascript:location.reload();"><img src="../../images/refresh.png" alt="Refrescar página" width="48" height="48" border="0" /></a></td>
        </tr>
            </table>
        </td>
		</tr>
	</table>
	<hr>
	<script>
	
		function onButtonClick(itemId,itemValue)
		{};
		aMenuBar=new dhtmlXMenuBarObject(document.getElementById('menu_zone'),'100%',16,"");
		aMenuBar.setOnClickHandler(onButtonClick);
		aMenuBar.setGfxPath("js/dhtmlxMenu/img/");
		aMenuBar.loadXML("js/dhtmlxMenu/_menu.xml");
		aMenuBar.showBar();
	</script>
		<?php 
		}
		
		
        /* AJAX inline edition comes in two flawors */
        /*	silent: To save record, just enter or double click */
        /*	default: To save record, must click icon */
        /* try yourself and see which one likes more (My preferred is silent) */
        $objGrid -> ajax("silent");
    
        $objGrid -> grid();
        
        $objGrid -> desconectar();
    	?>
</div>
</body>
</html>

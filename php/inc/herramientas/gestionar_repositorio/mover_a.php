<?php 
session_start();
$id_usuario=$_GET['id_usuario'];

include ('../../../classes/querys/query.php');
$query=new query();

include("../js/dhtmlgoodies-tree/dhtmlgoodies_tree_ventanas.class.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Copiar a....</title>
	<link rel="stylesheet" href="../../css/style.css" type="text/css" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script type="text/javascript">
 function procesar(page,param,div){
		
		cargar_div(page,param,div);
		setTimeout("parent.GB_hide();",1000);

 }
	  
	  
function cargar_div(page,param,div){

		if(document.all)
		{
			//Internet Explorer
			var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
		}//fin if
		else
		{
		    //Mozilla
			var XhrObj = new XMLHttpRequest();
		}//fin else

		//définition de l'endroit d'affichage:
		var content = document.getElementById(""+div+"");

		
		XhrObj.open("POST", page);
		//Ok pour la page cible
		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200)
				content.innerHTML = XhrObj.responseText ;
				
		}

		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(param)
}

</script>
</head>
<body>
<div id="cuerpo">
<?   
if (isset($_GET['thelist3']) && $_GET['thelist3'] !='') { 

  foreach ($_GET['thelist3'] as $indice=>$valor){ 
  	$amover.='thelist3[]='.$valor.'&';
  }
} 

        
    $tree1 = new dhtmlgoodies_tree();	// Creating new tree object
            
    $folders=$query->listado_directorios_usuario($id_usuario);
                                
    while ($inf1=mysql_fetch_array($folders)) {
            
            $tree1->addToArray($inf1["id"],
                $inf1["name"],
                $inf1["parent"],
                "javascript:procesar('mover.php','".$amover."&origen=".$_GET['origen']."&destino=".$inf1["id"]."&id_usuario=".$_GET['id_usuario']."','cuerpo');",
                "_self");
            
            }
                                
    $tree1->writeCSS();
    $tree1->writeJavascript();
    $tree1->drawTree();     
 ?> 
</div>
</body>
</html>
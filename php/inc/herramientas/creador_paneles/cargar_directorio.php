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
  <title>Abrir directorio</title>
	<link rel="stylesheet" href="../../css/style.css" type="text/css" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<div id="cuerpo">
<?        
    $tree1 = new dhtmlgoodies_tree();	// Creating new tree object
            
    $folders=$query->listado_directorios_usuario($id_usuario);
                                
    while ($inf1=mysql_fetch_array($folders)) {
            
            $tree1->addToArray($inf1["id"],
                $inf1["name"],
                $inf1["parent"],
                "javascript:window.parent.location='nuevo_panel.php?id_dir=".$inf1['id']."&id_panel=".$_GET['id_panel']."';",
                "_self");
            
            }
                                
    $tree1->writeCSS();
    $tree1->writeJavascript();
    $tree1->drawTree();     
 ?> 
</div>
</body>
</html>
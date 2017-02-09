<?php 
session_start();

if ($_SESSION['ID_USER'] == '' || $_SESSION['ID_USER']==0) {
?>
<script>
alert('La sesión ha caducado, vuelva a autentificarse para poder seguir trabajando');
window.close();
</script>
<?php 
}

include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
require_once('classes/crypt/5CR.php');
require_once('../../configuration/key.inc');
include("js/dhtmlgoodies-tree/dhtmlgoodies_tree.class.php");
include('classes/zip/pclzip.lib.php');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);

$id_usuario=$_SESSION['ID_USER'];

 if (isset($_GET['idd']) && $_GET['idd'] > 0) {
					
	$dir=$query->datos_directorio($_GET['idd'],$_SESSION['ID_USER']);
	$ruta=$dir['ruta_dir'];
	$id_dir=$_GET['idd'];
					  
  } else {
	$id_dir=$query->directorio_raiz($_SESSION['ID_USER']);
	$ruta=$id_usuario;		
  }
		
//vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
//   You may change maxsize, and allowable upload file types.
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//Mmaximum file size. You may increase or decrease.
$MAX_SIZE = 2000000;
                            
//Allowable file ext. names. you may add more extension names.            
$FILE_EXTS  = array('.zip','.jpg','.png','.gif');                     

/************************************************************
 *     Setup variables
 ************************************************************/
/*$site_name = $_SERVER['HTTP_HOST'];
$url_dir = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
$url_this =  "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];*/

$upload_dir = "../../usuarios/".$ruta.'/';
$upload_url = "../../usuarios/".$ruta.'/';
$message ="";

/************************************************************
 *     Process User's Request
 ************************************************************/
if ($_FILES['userfile']) {

  $file_type = $_FILES['userfile']['type']; 
  $file_name = $_FILES['userfile']['name'];
  $file_ext = strtolower(substr($file_name,strrpos($file_name,".")));

  //File Size Check
  if ( $_FILES['userfile']['size'] > $MAX_SIZE) { 
     $message = "El archivo sobrepasa los 2MB permitidos.";
  //File Extension Check
  } else if (!in_array($file_ext, $FILE_EXTS)) { 
     $message = "Lo sentimos, $file_name($file_type) no es un formato de archivo permitido.";
  } else {
  
  	 if ($file_ext==".zip") {
	 
	 	$temp_name = $_FILES['userfile']['tmp_name'];
		$file_name = $_FILES['userfile']['name']; 
		$file_name = str_replace("\\","",$file_name);
		$file_name = str_replace("'","",$file_name);
		  
	 	$upload_temp = "../../temp/";
		$name_folder=basename(tempnam("temp",'tmp'));
		$dir="../../temp/".$name_folder;
		$file_path = $upload_temp.$file_name;
		$result  =  move_uploaded_file($temp_name,$file_path);
		mkdir($dir,0777);

		$archive = new PclZip($file_path);
		if ($archive->extract(PCLZIP_OPT_PATH, $dir) == 0) {
			//$message="Error : ".$archive->errorInfo(true);
		} else { unlink($file_path); }
		
		//Recorro el directorio para añadir las imagenes que contenga a la BBDD
		$llistat=recursive_dirlist($dir);
		$num_files= count($llistat[files]);
		
		for ($i=0; $i<$num_files; $i++)
		{
		 $extension = strtolower(substr(strrchr($llistat[files][$i], "."), 1)); 
		 
			 if ($extension=='jpg' || $extension=='JPG' ||$extension=='JPEG' ||$extension=='jpeg' ||$extension=='gif' ||$extension=='png') {
			 
			    $add=$query->add_zip_repositorio($id_dir,$_SESSION['ID_USER'],$llistat[files][$i]);
			 }
		
		}

		//Borro la carpeta la carpeta temporal utilizada y todo su contenido
		//************************************************************************
		
			$folder_delete=rm_recursive($dir);
  
  		//************************************************************************
		
	 } else {
    	 $message = $query->do_upload($upload_dir, $upload_url,$query,$id_dir,$ruta);
	 }
  }
  
  /*print "<script>window.location.href='$url_this?message=$message'</script>";*/
}
else if (!$_FILES['userfile']) { } else  { $message = "Invalid File Specified."; }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Herramientas ARASAAC: GESTION REPOSITORIO</title>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <!--********NO ALTERAR EL ORDEN DE CARGA ********* -->  
      <!--********************************************** -->  
	  <script type="text/javascript" src="js/greybox/AmiJS.js"></script>
	  <script type="text/javascript" src="js/greybox/greybox.js"></script>
      <link href="js/greybox/greybox.css" rel="stylesheet" type="text/css" media="all" />
      <!--********************************************** -->
      <script type="text/javascript" src="js/ajax_herramientas.js"></script>
      <!--********************************************** -->   
      <script src="js/scriptaculous/prototype.js" type="text/javascript"></script>
      <script src="js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
      <script src="js/scriptaculous/unittest.js" type="text/javascript"></script>
      <!--********************************************** -->
      <script type="text/javascript" src="js/dtree/dtree.js"></script>
      <!--********************************************** -->
      <script type="text/javascript" src="js/windows_js_0.96.2/javascripts/effects.js"> </script>
      <script type="text/javascript" src="js/windows_js_0.96.2/javascripts/window.js"> </script>
      <script type="text/javascript" src="js/windows_js_0.96.2/javascripts/debug.js"> </script> 
      <!--********************************************** -->
      <link href="js/windows_js_0.96.2/themes/default.css" rel="stylesheet" type="text/css" >	 </link>
      <link href="js/windows_js_0.96.2/themes/alphacube.css" rel="stylesheet" type="text/css" >	 </link>
      <link href="js/windows_js_0.96.2/themes/alert.css" rel="stylesheet" type="text/css" >	 </link>
      <link href="js/windows_js_0.96.2/themes/alert_lite.css" rel="stylesheet" type="text/css" >	 </link>
      <link href="js/windows_js_0.96.2/themes/debug.css" rel="stylesheet" type="text/css" >	 </link>
      <link rel="StyleSheet" href="js/dtree/dtree.css" type="text/css" />
      <link rel="stylesheet" href="../../css/style.css" type="text/css" />
</head>
<body>
<div class="body_content">
<link rel="STYLESHEET" type="text/css" href="js/dhtmlxMenu/css/dhtmlXMenu.css">
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXProtobar.js"></script>
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXMenuBar.js"></script>
	<script language="JavaScript" src="js/dhtmlxMenu/js/dhtmlXCommon.js"></script>	
    	<table width="100%">
	  <tr>
			<td width="78%">
			  <div id="menu_zone" style="width:600;background-color:#f5f5f5;border :1px solid Silver;"/>
			</td>
     <td width="22%"><table width="100%" border="0">
       <tr>
         <td width="27%" align="right"><b><?php echo utf8_encode(saludo()); ?></b>&nbsp;<?php echo $_SESSION['USERNAME']; ?>&nbsp;| <a href="javascript:void(0);" onClick="desconectar();">Desconectar</a></td>
         <td width="13%" align="right"><table border="0">
           <tr>
             <td width="90"><table border="0">
                   <tr>
                     <td width="30"><a href="cesta.php"><img src="../../images/carrito_compra_b.gif" alt="Ver mi cesto de símbolos" width="21" height="18" border="0"  title="Ver mi cesto de símbolos" /></a></td>
                     <td width="22"><div id="n_cesto">
                         <?php $n=0; if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") { foreach ($_SESSION['cart'] as $key => $value) { $n=$n+1; } }  echo $n; ?>
                     </div></td>
                     <td width="90"><div id="clearCart" onClick="clearCart();"><img src="../../images/papelera.png" alt="Vaciar mi cesto de símbolos" /></div>
                         <div id="loading"><img src="../../images/indicator.gif" alt="Cargando..." /></div></td>
                   </tr>
               </table></td>
           </tr>
         </table></td>
         <td width="14%" align="right"><img src="../../images/refresh.png" alt="Refrescar página" width="48" height="48" onClick="javascript:window.location.reload();" /></td>
       </tr>
     </table></td>
		</tr>
	</table>
       
  <hr>
<script>
		function onButtonClick(itemId,itemValue)
		{};
		aMenuBar=new dhtmlXMenuBarObject(document.getElementById('menu_zone'),'100%',16,"");
		aMenuBar.setOnClickHandler(onButtonClick);
		aMenuBar.setGfxPath("js/dhtmlxMenu/img/");
		<?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {  ?>
		aMenuBar.loadXML("js/dhtmlxMenu/_menu.xml");
		<?php } else {  ?>
		aMenuBar.loadXML("js/dhtmlxMenu/_menu_invitado.xml");
		<?php } ?>
		aMenuBar.showBar();
	</script>

  <div id="mensaje"></div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="2%">&nbsp;</td>
      <td width="4%"><a href="javascript:void(0);" onClick="Dialog.alert({url: 'gestionar_repositorio/zip.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:400, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});"><img src="../../images/zip.png" title="Descargar TODO mi repositorio a un archivo ZIP" alt="Descargar TODO mi repositorio a un archivo ZIP" border="0" /></a></td>
      <td width="2%"><a href="javascript:void(0);" onClick="Dialog.alert({url: 'gestionar_repositorio/zip.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:400, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});"><?php echo '<a href="javascript:void(0);" onclick="guardar_repositorio();"><img src="../../images/save_f2.png" alt="Guardar" title="Guardar" border="0" /> </a>'; ?></a></td>
      <td width="66%" align="left">&nbsp;</td>
      <td width="26%" align="right"><strong>Añadir archivos desde:</strong> <a href="javascript:void(0);" onClick="Effect.BlindDown('avanzada_imagenes');; return false;">Carrito de la Compra</a> | <a href="javascript:void(0);" onClick="Effect.BlindDown('subir_archivo');; return false;">Subir Archivos</a></td>
    </tr>
  </table>
  <div id="principal">
<form action="gestionar_repositorio/upload_archivos.php" method="post" name="gestionar_repositorio" id="gestionar_repositorio" ENCTYPE="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
    <div id="mi_repositorio">
      <table width="100%" border="0">
        <tr>
          <td width="177" valign="top">
        
        <div class="dtree" style="border:1px dashed #999999; height:410px;">

            <p><a href="javascript: d.openAll();">Desplegar</a> | <a href="javascript: d.closeAll();">Contraer</a></p>
        
            <script type="text/javascript">
                <!--
        
                d = new dTree('d');
        
                <?php  
                $folders=$query->listado_directorios_usuario($id_usuario);
                                        
                    while ($inf=mysql_fetch_array($folders)) {
                    
                         if ($inf["parent"]==0) {
                         
                             print "d.add(".$inf["id"].",-1,'Raiz','".$PHP_SELF.'?idd='.$inf['id']."');
                                ";
                      
                         } else {
                                
                            print "d.add(".$inf["id"].",".$inf["parent"].",'".$inf["name"]."','".$PHP_SELF.'?idd='.$inf['id']."');
                                ";
                    
                        }
                    
                    }
                ?>
        
                document.write(d);
        
                //-->
            </script>

		</div>  
        </td>
       <td width="774" valign="top">
       <div id="directorio_actual" style="border-bottom:1px solid #999999;">
       <p><strong>Estamos en: 
	   <?php 
 
 		if (isset($_GET['idd']) && $_GET['idd'] > 0) {
					
			$dir=$query->datos_directorio($_GET['idd'],$_SESSION['ID_USER']);
			$ruta=$dir['ruta_dir'];
			$id_dir=$_GET['idd'];
					  
		} else {
			$id_dir=$query->directorio_raiz($_SESSION['ID_USER']);
			$dir=$query->datos_directorio($id_dir,$_SESSION['ID_USER']);
			$ruta=$id_usuario;		
		}	
		?>
			
       </strong><strong> <?php echo str_replace($_SESSION['ID_USER'],'Raiz',$dir['ruta_dir']); ?></strong>&nbsp;&nbsp;&nbsp;
       <label><a href="javascript:void(0);" onClick="Effect.BlindDown('crear_directorio');; return false;"><img src="../../images/folder_add.png" alt="Crear Carpeta" title="Crear Carpeta" border="0" /></a> </label>
       <?php 
	   if ($dir['parent'] !=0) {
		  
		   echo  '<a href="javascript:void(0);" 
					onClick="borrar_carpeta(\'Esta seguro que desea borrar la carpeta seleccionada? Esta acción borrará todos los archivos y carpetas contenidos dentro de ésta. Opere con precaución.\',
					\'300\',\'150\',
					\'gestionar_repositorio/borrar_carpeta.php\', \'idd='.$_GET['idd'].'\', \'mensaje\');" /><img src="../../images/folder_delete.png" alt="Borrar carpeta" title="Borrar carpeta" width="16" height="16" border="0" /></a>'; 
		
		 }
		 
			echo '<a href="javascript:void(0);" onclick="guardar_repositorio();"><img src="../../images/filesave.png" alt="Guardar" title="Guardar" width="16" height="16" border="0" /> </a>&nbsp;<a href="javascript:void(0);" onclick="Dialog.alert({url: \'gestionar_repositorio/zip.php?iddir='.$id_dir.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:400, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src="../../images/compress.png" alt="Comprimir esta carpeta (y subcarpetas) en un archivo ZIP" title="Comprimir esta carpeta (y subcarpetas) en un archivo ZIP" border="0" /></a> '; 
		?>
       <label>
       <input name="parent" type="hidden" id="parent" value="<?php echo $id_dir; ?>" />
       <input name="id_directorio" type="hidden" id="id_directorio" value="<?php echo $_GET['idd']; ?>" />
       <input name="id_usuario" type="hidden" id="id_usuario" value="<?php echo $_SESSION['ID_USER']; ?>" />
       <input name="ruta" type="hidden" id="ruta" value="<?php echo $ruta; ?>" />
       </label>
		</p>

         
             <div id="crear_directorio" style="font-size: 10px; margin-bottom:10px; margin-top:5px; padding-left:5px; border:1px solid #CCCCCC; width: 99%; text-align:left; display:none;">
        <div style="text-align:right;"><a href="javascript:void(0);" onClick="Effect.BlindUp('crear_directorio');; return false;"><img src="../../images/close.gif" alt="Subida desde archivo"  border="0"/></a></div>
				 <p>Nueva carpeta: 
                   <label>
                   <input type="text" name="nombre_carpeta" id="nombre_carpeta" />
                   </label>
                   <label>
                   <input type="button" name="button" id="button" value="Crear Carpeta" onClick="cargar_div3('gestionar_repositorio/crear_directorio.php','nombre_carpeta='+document.gestionar_repositorio.nombre_carpeta.value+'&id_usuario='+document.gestionar_repositorio.id_usuario.value+'&parent='+document.gestionar_repositorio.parent.value+'&ruta='+document.gestionar_repositorio.ruta.value+'','mensaje');" />
                   </label>
				 </p>
            </div>
    
         </div>
        <br/>
        
		<ul id="thelist2" style="height:350px; margin-right:10px; overflow:scroll; border:1px dashed #999999;">
        
         <?php 
		 
		 if (isset($_GET['idd']) && $_GET['idd'] > 0) {
					
			$contenido_directorio=$query->contenido_directorio($_GET['idd']);
			$id_directorio=$_GET['idd'];
					  
		} else {
					
			$contenido_directorio=$query->contenido_directorio($id_dir);
			$id_directorio=$directorio_raiz;
		}
					
		 
		 
		 while ($row=mysql_fetch_array($contenido_directorio)) {
			
			if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
			elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
			
			
			$ruta_img='size=30&ruta=../../../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 	
			
			$miruta='img='.$ruta.'&file_id='.$row['file_id'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
			$encript->encriptar($miruta,1);
			
			echo "<li id=\"thelist2_".$row['file_id']."\" style=\"width:70px; height:70px;\"><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/><br /><a href=\"javascript:void(0);\" onclick=\"Dialog.alert({url: 'imagen.php?i=".$miruta."', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:400, height:500, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});\"><img src=\"../../images/viewmag.png\" border=\"0\" alt=\"Ampliar información de la imagen\" title=\"Ampliar información de la imagen\"/></a>";
			
			// Compruebo si la imagen es un GIF animado
			$filetype = substr($row['file_name'],-3);
			$filetype = strtolower($filetype);
						
			if ($filetype == "gif") {
			echo "<img src=\"../../images/gif_animado.gif\" border=\"0\" alt=\"Esta imagen es un GIF Animado\" title=\"Esta imagen es un GIF Animado\"/>";
			}
			
			//Compruebo si tiene o no asociada palabra
			if ($row['id_palabra']==0 || $row['id_palabra']=='' || $row['id_palabra']==NULL) {
			echo "<a href=\"javascript:void(0);\" onclick=\"Dialog.alert({url: 'gestionar_repositorio/seleccionar_palabra.php?file_id=".$row['file_id']."', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:700}, okLabel: 'Cerrar', ok:function(win){ window.location.reload()} });\"><img src=\"../../images/pendiente_revision.gif\" border=\"0\" alt=\"Falta de asociar palabra\" title=\"Falta de asociar palabra\"/></a>";
			}			
			
			$miruta_download='img=../../'.$ruta.'&id_palabra='.$row['id_palabra'];
			$encript->encriptar($miruta_download,1);
			echo '<a href="../public/descargar.php?i='.$miruta_download.'"><img src=\'../../images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a>';
			
			if ($row['id_palabra'] !=0 && $row['id_palabra'] > 0 && $filetype != "gif") {
				$ruta_creador='img='.$ruta.'&id_palabra='.$row['id_palabra'];
				$encript->encriptar($ruta_creador,1); 
				echo '<a href="creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'"><img src=\'../../images/paint.gif\' border="0" alt="Utilizar imagen en el creador" title="Utilizar imagen en el creador"></a>';
			}	
				
			echo "</li>";
			}
		 ?>

        </ul>
		
        </td>
        </tr>
      </table>
 </div>
 <?php echo "<b>ACCIONES: </b>&nbsp;"; 
 echo "<a href=\"javascript:void(0);\" 
				onClick=\"borrar_archivos('Esta seguro que desea borrar los archivos seleccionados? Opere con precaución.',
				'300','100',
				'gestionar_repositorio/borrar_archivo.php',''+document.gestionar_repositorio.accion.value+'', 'thelist2', '".$id_dir."');\" /><img src=\"../../images/fileclose.png\" alt=\"Borrar archivo/s\" title=\"Borrar archivo/s\" width=\"16\" height=\"16\" border=\"0\" /></a>";
 echo "&nbsp;<a href=\"javascript:void(0);\" onclick=\"return GB_show('Copiar a....', 'gestionar_repositorio/copiar_a.php?'+document.gestionar_repositorio.accion.value+'&origen=".$id_directorio."&id_usuario=".$id_usuario."', 300, 550)\"><img src=\"../../images/page_white_stack.png\" alt=\"Copiar Archivo\" title=\"Copiar a...\" border=\"0\"/></a>&nbsp;<a href=\"javascript:void(0);\" onclick=\"return GB_show('Mover a....', 'gestionar_repositorio/mover_a.php?'+document.gestionar_repositorio.accion.value+'&origen=".$id_directorio."&id_usuario=".$id_usuario."', 300, 550)\"><img src=\"../../images/cut_red.png\" alt=\"Mover a...\" title=\"Mover a...\" border=\"0\"/></a>"; 
 
 echo '&nbsp;<a href="javascript:void(0);" onclick="Dialog.alert({url: \'gestionar_repositorio/zip_seleccion.php?\'+document.gestionar_repositorio.accion.value+\'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:400, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src="../../images/compress.png" alt="Comprimir seleccion en un archivo ZIP" title="Comprimir selección en un archivo ZIP" border="0" /></a> ';
 ?>
 <ul id="thelist3" style="height:240px; margin-right:10px; background:url(../../images/package_settings.png) no-repeat bottom left; border:1px dashed #999999;">
 
 </ul>
 
 	</td>
    <td align="right" valign="top">
    <div id="subir_archivo" style="font-size: 10px; margin-bottom:10px; margin-top:5px; padding-left:5px; border:1px solid #CCCCCC; width: 100%; text-align:left;">
<div style="text-align:right;"><a href="javascript:void(0);" onClick="Effect.BlindUp('subir_archivo');; return false;"><img src="../../images/close.gif" alt="Subida desde archivo"  border="0"/></a></div>
     <p align="center"><?php echo $message; ?></p>
       <input type="file" id="userfile" name="userfile">
          <br />
       Para la subida masiva de archivos a un <br /> 
       directorio, seleccionar el directorio de <br />
       destino, comprimir las imágenes en un ZIP <br />
       (sin carpetas) y subir el archivo.<br /><br />
       <p align="center"><input type="submit" name="upload" value="Subir Archivo"></p>
    </div>    
    <div id="avanzada_imagenes" style="font-size: 10px; margin-bottom:10px; margin-top:5px; padding-left:5px; border:1px solid #CCCCCC; width: 100%; background:url(../../images/carrito.jpg) no-repeat bottom right; height:auto;">
<div style="text-align:right;"><a href="javascript:void(0);" onClick="Effect.BlindUp('avanzada_imagenes');; return false;"><img src="../../images/close.gif" alt="Cerrar b&uacute;squeda avanzada"  border="0"/></a></div>
<ul id="thelist1" style="width:200px; height:500px; border:none;">
<?php 
if (isset($_SESSION['cart'])) { 
	foreach ($_SESSION['cart'] as $key => $value) {

			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
			$ruta=$key['ruta_cesto'];
			$ruta_img='size=30&ruta=../../../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 
			
			print "<li id=\"thelist1_".$ruta_cesto."\" style=\"width:70px; height:70px;\"><a href=\"javascript:void(0);\"><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a></li>";
} } else { echo "El cesto se encuentra vacio";   }?>
</ul></div>

</td>
  </tr>
</table>
<div align="center">
  <p>
    <input name="guardar" type="button" id="guardar" value="GUARDAR CAMBIOS" onClick="guardar_repositorio();"  style="font-size:22px;"/>
  </p>
  <p>
    <input name="cesto" type="hidden" id="cesto" value="" size="100" />
    <input name="mi_seleccion" type="hidden" id="mi_seleccion" value="" size="100"/>
    <input name="accion" type="hidden" id="accion" value="" size="100" />
    </p>
</div>

</form>
<script type="text/javascript" language="javascript" charset="utf-8">
// <![CDATA[
		Sortable.create('thelist1',{containment:['thelist1','thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){document.gestionar_repositorio.cesto.value=Sortable.serialize('thelist1'); document.gestionar_repositorio.mi_seleccion.value=Sortable.serialize('thelist2');  },
        onChange:function(element){document.gestionar_repositorio.cesto.value=Sortable.serialize('thelist1'); document.gestionar_repositorio.mi_seleccion.value=Sortable.serialize('thelist2'); }});
		
		
		Sortable.create('thelist2',{containment:['thelist1','thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){document.gestionar_repositorio.cesto.value=Sortable.serialize('thelist1'); document.gestionar_repositorio.mi_seleccion.value=Sortable.serialize('thelist2'); },
        onChange:function(element){document.gestionar_repositorio.cesto.value=Sortable.serialize('thelist1'); document.gestionar_repositorio.mi_seleccion.value=Sortable.serialize('thelist2');  }});
		
		Sortable.create('thelist3',{containment:['thelist3','thelist2'], ghosting:true, constraint:false, dropOnEmpty:true, 
		onUpdate:function(sortable){document.gestionar_repositorio.mi_seleccion.value=Sortable.serialize('thelist2'); document.gestionar_repositorio.accion.value=Sortable.serialize('thelist3'); },
        onChange:function(element){document.gestionar_repositorio.mi_seleccion.value=Sortable.serialize('thelist2'); document.gestionar_repositorio.accion.value=Sortable.serialize('thelist3'); }});
					  
		Droppables.add('thelist2', {onDrop:function(element){ 
		document.gestionar_repositorio.mi_seleccion.value=Sortable.serialize('thelist2');
		document.gestionar_repositorio.cesto.value=Sortable.serialize('thelist1'); 
			}});  
		Droppables.add('thelist1', {onDrop:function(element){ 
		document.gestionar_repositorio.mi_seleccion.value=Sortable.serialize('thelist2');
		document.gestionar_repositorio.cesto.value=Sortable.serialize('thelist1'); 
			}});
		Droppables.add('thelist3', {onDrop:function(element){ 
		document.gestionar_repositorio.accion.value=Sortable.serialize('thelist3');
		document.gestionar_repositorio.mi_seleccion.value=Sortable.serialize('thelist2'); 
			}});
	// ]]>
  </script>
</div>
    <div align="center" class="footer">
      <p><a href="../../index.php">Qu&eacute; es Arasaac</a> | <a href="../../index.php?ref=condiciones_uso_h">Condiciones de Uso</a> | <a href="../../index.php?ref=mapa_web_h">Mapa Web</a><br />
&copy; Herramientas ARASAAC, CATEDU <?php echo date("Y"); ?> | Departamento de Educaci&oacute;n Cultura y Deporte<br />
<a href="http://www.aragob.es" target="_blank"><img src="../../images/minilogo_aragob.gif" alt="Gobierno de Aragón" border="0" tittle="Gobierno de Aragón"/></a></p>
  </div>
</div>
</body>
</html>


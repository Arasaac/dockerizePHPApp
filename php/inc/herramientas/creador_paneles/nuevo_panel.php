<?php 
session_start();
$id_usuario=$_SESSION['ID_USER'];

require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
$query=new query();

if (isset($_GET['id_plantilla']) && $_GET['id_plantilla'] > 0) {

	$panel=$query->datos_plantilla($_GET['id_plantilla']);
	
	$n_items=$panel['n_items'];
	$principal=$panel['simbolo_principal'];
	$panel_width=$panel['panel_width'];
	$simbolos_width=$panel['simbolos_width'];
	$principal_width=$panel['principal_width'];
	$borde_panel=$panel['borde_panel'];
	$grosor_borde_panel=$panel['grosor_borde_panel'];
	$color_borde_panel=$panel['color_borde_panel'];
	$panel_color_fondo=$panel['panel_color_fondo'];
	
	$borde_simbolos=$panel['borde_simbolos'];
	$grosor_borde_simbolos=$panel['grosor_borde_simbolos'];
	$color_borde_simbolos=$panel['color_borde_simbolos'];
	$espacio_entre_simbolos=$panel['espacio_entre_simbolos'];
	
	$borde_simbolo_principal=$panel['borde_simbolo_principal'];
	$grosor_borde_simbolo_principal=$panel['grosor_borde_simbolo_principal'];
	$color_borde_simbolo_principal=$panel['color_borde_simbolo_principal'];
	
	if (isset($_GET['id_panel']) && $_GET['id_panel'] > 0 && $_GET['id_panel'] != '') {
	
		$mi_panel=$query->datos_panel($_GET['id_panel'],$id_usuario);
		$txt_inferior=$panel['txt_inferior'];
		$txt_superior=$panel['txt_superior'];
		$id_panel=$_GET['id_panel'];
		$txt_inferior=$mi_panel['txt_inferior'];
		$txt_superior=$mi_panel['txt_superior'];
		
		$contenido_panel=$mi_panel['contenido_panel'];
		$nombre_panel=$mi_panel['nombre_panel'];
		$tags_panel=$mi_panel['tags_panel'];
		
		$text_smb=explode(";",$contenido_panel); 	
			$text_n_simb=count($text_smb);
						
				for ($h=0; $h<=$text_n_simb; $h++){
						if (!empty($text_smb[$h])) {
							$text_simbolo=explode("|", $text_smb[$h]);
							
								if ($text_simbolo[0] != 'allItems') {
									
									if (substr_count($text_simbolo[1],'node') > 0) { $item=explode('node',$text_simbolo[1]); }
									elseif (substr_count($text_simbolo[1],'txt') > 0) { $item=explode('txt',$text_simbolo[1]); }
									$item_box=explode('box',$text_simbolo[0]);
									$box[$item_box[1]]=$item[1];
								} 
						}
				}	
			
	} else { 
	$id_panel='';
	}	
	
} else { // ELSE DE COMPROBACION DE SI SE QUIERE CARGAR UNA PLANTILLA

	if (isset($_POST['id_panel'])) { $id_panel=$_POST['id_panel']; } 
	elseif (isset($_GET['id_panel'])) { $id_panel=$_GET['id_panel']; }
	
	if ($id_panel=='' && isset($_POST['accion'])=='previsualizar') {
	
		$n_items=$_POST['n_items'];
		$principal=$_POST['principal'];
		$panel_width=$_POST['panel_width'];
		$simbolos_width=$_POST['simbolos_width'];
		$principal_width=$_POST['principal_width'];
		$borde_panel=$_POST['borde_panel'];
		$grosor_borde_panel=$_POST['grosor_borde_panel'];
		$color_borde_panel=$_POST['color_borde_panel'];
		$panel_color_fondo=$_POST['panel_color_fondo'];
		
		$borde_simbolos=$_POST['borde_simbolos'];
		$grosor_borde_simbolos=$_POST['grosor_borde_simbolos'];
		$color_borde_simbolos=$_POST['color_borde_simbolos'];
		$espacio_entre_simbolos=$_POST['espacio_entre_simbolos'];
		
		$borde_simbolo_principal=$_POST['borde_simbolo_principal'];
		$grosor_borde_simbolo_principal=$_POST['grosor_borde_simbolo_principal'];
		$color_borde_simbolo_principal=$_POST['color_borde_simbolo_principal'];
		
		$contenido_panel=$_POST['contenido_panel'];
		$nombre_panel=$_POST['nombre_panel'];
		$tags_panel=$_POST['tags_panel'];
		
		$id_panel=$_POST['id_panel'];
		
		$txt_inferior=$_POST['txt_inferior'];
		$txt_superior=$_POST['txt_superior'];
		
		
		$text_smb=explode(";",$contenido_panel); 	
		$text_n_simb=count($text_smb);
					
			for ($h=0; $h<=$text_n_simb; $h++){
					if (!empty($text_smb[$h])) {
						$text_simbolo=explode("|", $text_smb[$h]);
						
							if ($text_simbolo[0] != 'allItems') {
								
								if (substr_count($text_simbolo[1],'node') > 0) { $item=explode('node',$text_simbolo[1]); }
								elseif (substr_count($text_simbolo[1],'txt') > 0) { $item=explode('txt',$text_simbolo[1]); }
								$item_box=explode('box',$text_simbolo[0]);
								$box[$item_box[1]]=$item[1];
							} 
					}
			}
	} elseif ($id_panel > 0 && isset($_POST['accion'])=='previsualizar') {
	
		$n_items=$_POST['n_items'];
		$principal=$_POST['principal'];
		$panel_width=$_POST['panel_width'];
		$simbolos_width=$_POST['simbolos_width'];
		$principal_width=$_POST['principal_width'];
		$borde_panel=$_POST['borde_panel'];
		$grosor_borde_panel=$_POST['grosor_borde_panel'];
		$color_borde_panel=$_POST['color_borde_panel'];
		$panel_color_fondo=$_POST['panel_color_fondo'];
		
		$borde_simbolos=$_POST['borde_simbolos'];
		$grosor_borde_simbolos=$_POST['grosor_borde_simbolos'];
		$color_borde_simbolos=$_POST['color_borde_simbolos'];
		$espacio_entre_simbolos=$_POST['espacio_entre_simbolos'];
		
		$borde_simbolo_principal=$_POST['borde_simbolo_principal'];
		$grosor_borde_simbolo_principal=$_POST['grosor_borde_simbolo_principal'];
		$color_borde_simbolo_principal=$_POST['color_borde_simbolo_principal'];
		
		$contenido_panel=$_POST['contenido_panel'];
		$nombre_panel=$_POST['nombre_panel'];
		$tags_panel=$_POST['tags_panel'];
		
		$txt_inferior=$_POST['txt_inferior'];
		$txt_superior=$_POST['txt_superior'];
		
		$id_panel=$_POST['id_panel'];
		
		$text_smb=explode(";",$contenido_panel); 	
		$text_n_simb=count($text_smb);
					
			for ($h=0; $h<=$text_n_simb; $h++){
					if (!empty($text_smb[$h])) {
						$text_simbolo=explode("|", $text_smb[$h]);
						
							if ($text_simbolo[0] != 'allItems') {
								
								if (substr_count($text_simbolo[1],'node') > 0) { $item=explode('node',$text_simbolo[1]); }
								elseif (substr_count($text_simbolo[1],'txt') > 0) { $item=explode('txt',$text_simbolo[1]); }
								$item_box=explode('box',$text_simbolo[0]);
								$box[$item_box[1]]=$item[1];
							} 
					}
			}
				
	} elseif ($id_panel > 0) {
	
		$panel=$query->datos_panel($id_panel,$id_usuario);
		
		$n_items=$panel['n_items'];
		$principal=$panel['simbolo_principal'];
		$panel_width=$panel['panel_width'];
		$simbolos_width=$panel['simbolos_width'];
		$principal_width=$panel['principal_width'];
		$borde_panel=$panel['borde_panel'];
		$grosor_borde_panel=$panel['grosor_borde_panel'];
		$color_borde_panel=$panel['color_borde_panel'];
		$panel_color_fondo=$panel['panel_color_fondo'];
		
		$borde_simbolos=$panel['borde_simbolos'];
		$grosor_borde_simbolos=$panel['grosor_borde_simbolos'];
		$color_borde_simbolos=$panel['color_borde_simbolos'];
		$espacio_entre_simbolos=$panel['espacio_entre_simbolos'];
		
		$borde_simbolo_principal=$panel['borde_simbolo_principal'];
		$grosor_borde_simbolo_principal=$panel['grosor_borde_simbolo_principal'];
		$color_borde_simbolo_principal=$panel['color_borde_simbolo_principal'];
		
		$contenido_panel=$panel['contenido_panel'];
		$nombre_panel=$panel['nombre_panel'];
		$tags_panel=$panel['tags_panel'];
		
		$txt_inferior=$panel['txt_inferior'];
		$txt_superior=$panel['txt_superior'];
		
		$id_panel=$panel['id_panel'];
		
		$text_smb=explode(";",$contenido_panel); 	
		$text_n_simb=count($text_smb);
					
			for ($h=0; $h<=$text_n_simb; $h++){
					if (!empty($text_smb[$h])) {
						$text_simbolo=explode("|", $text_smb[$h]);
						
							if ($text_simbolo[0] != 'allItems') {
								
								if (substr_count($text_simbolo[1],'node') > 0) { $item=explode('node',$text_simbolo[1]); }
								elseif (substr_count($text_simbolo[1],'txt') > 0) { $item=explode('txt',$text_simbolo[1]); }
								$item_box=explode('box',$text_simbolo[0]);
								$box[$item_box[1]]=$item[1];
							} 
					}
			}
				
	} 
	
} // CIERRO EL IF DE COMPROBACION DE SI CARGA UNA PLANTILLA
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
<head> 
<?php require ('template_css.php'); ?>
<link rel="stylesheet" href="../../../css/style.css" type="text/css" />	
<script type="text/javascript" src="../js/ajax_herramientas.js"></script>
<script type="text/javascript">
	/* VARIABLES YOU COULD MODIFY */
	var boxSizeArray = [<?php for($i = 1; $i <= $n_items; $i++) { echo '1,'; } ?>];	// Array indicating how many items there is rooom for in the right column ULs
	
	var arrow_offsetX = -5;	// Offset X - position of small arrow
	var arrow_offsetY = 0;	// Offset Y - position of small arrow
	
	var arrow_offsetX_firefox = -6;	// Firefox - offset X small arrow
	var arrow_offsetY_firefox = -13; // Firefox - offset Y small arrow
	
	var verticalSpaceBetweenListItems = 3;	// Pixels space between one <li> and next	
											// Same value or higher as margin bottom in CSS for #dhtmlgoodies_dragDropContainer ul li,#dragContent li									
	var indicateDestionationByUseOfArrow = false;	// Display arrow to indicate where object will be dropped(false = use rectangle)

	var cloneSourceItems = true;	// Items picked from main container will be cloned(i.e. "copy" instead of "cut").	
	var cloneAllowDuplicates = false;	// Allow multiple instances of an item inside a small box(example: drag Student 1 to team A twice
	</script>
<script type="text/javascript" src="codigo.js"> </script>
<script type="text/javascript" src="../js/greybox/AmiJS.js"></script>
<script type="text/javascript" src="../js/greybox/greybox.js"></script>
<link href="../js/greybox/greybox.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../js/prototype/prototype.js"> </script> 
<script type="text/javascript" src="../js/windows_js_0.96.2/javascripts/effects.js"> </script>
<script type="text/javascript" src="../js/windows_js_0.96.2/javascripts/window.js"> </script>
<script type="text/javascript" src="../js/windows_js_0.96.2/javascripts/debug.js"> </script>
<script type="text/javascript" src="../js/windows_js_0.96.2/javascripts/window_effects.js"> </script> 
    
<link href="../js/windows_js_0.96.2/themes/default.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../js/windows_js_0.96.2/themes/alphacube.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../js/windows_js_0.96.2/themes/alert.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../js/windows_js_0.96.2/themes/alert_lite.css" rel="stylesheet" type="text/css" >	 </link>
<link href=".../js/windows_js_0.96.2/themes/spread.css" rel="stylesheet" type="text/css" ></link> 
<link href="../js/windows_js_0.96.2/themes/debug.css" rel="stylesheet" type="text/css" ></link>

<link rel="STYLESHEET" type="text/css" href="../js/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
<script  src="../js/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
<script  src="../js/dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
<script  src="../js/dhtmlxTabbar/codebase/dhtmlxtabbar_start.js"></script>
<title>Herramientas ARASAAC: Creador de Paneles</title>
</head> 
<body> 
<div class="body_content" style="height:1470px;">
<link rel="STYLESHEET" type="text/css" href="../js/dhtmlxMenu/css/dhtmlXMenu.css">
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXProtobar.js"></script>
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXMenuBar.js"></script>
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXCommon.js"></script>
<script type="text/javascript" src="../js/color/picker.js"></script>
	
	<table width="100%">
	  <tr>
			<td width="78%">
			  <div id="menu_zone" style="width:600;background-color:#f5f5f5;border :1px solid Silver;"/>
			</td>
     <td width="22%">
<table width="100%" border="0">
              <tr>
                <td width="27%" align="right"> <b><?php echo saludo(); ?></b>&nbsp;<?php echo $_SESSION['USERNAME']; ?>&nbsp;| <a href="javascript:void(0);" onClick="desconectar();">
                  <?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {  echo '<a href="javascript:void(0);" onClick="desconectar();">Desconectar</a>'; } ?>
                </a></td>
                <td width="27%" align="right"><img src="../../../images/refresh.png" alt="Refrescar p&aacute;gina" width="48" height="48" /></td>
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
		aMenuBar.setGfxPath("../js/dhtmlxMenu/img/");
		<?php if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) {  ?>
		aMenuBar.loadXML("../js/dhtmlxMenu/_menu1.xml");
		<?php } else {  ?>
		aMenuBar.loadXML("../js/dhtmlxMenu/_menu1_invitado.xml");
		<?php } ?>
		aMenuBar.showBar();
	</script>
  <div id="principal">
    <h4>NUEVO PANEL:&nbsp;</h4>
    <br>
<form action="../../../plugins/html2ps_v2042/public_html/demo/html2ps.php" method="POST" name="form1" id="form1">
<div id="dhtmlgoodies_dragDropContainer">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="85%"><div id="mensaje" style="border:1px solid #CC0000; margin:10px; color:#FF0000; height:20px; text-align:center;">
          <?php if ($id_panel=='' || $id_panel==0 || !isset($id_panel)) { echo 'SU PANEL NO HA SIDO GUARDADO TODAV&Iacute;A'; } ?>
          <input name="id_panel" type="hidden" id="id_panel" value="<?php echo $id_panel; ?>">
        </div></td>
        <td width="2%" align="center"> <?php if ($id_panel > 0) { echo  '<a href="javascript:void(0);" 
				onClick="ventana_confirmacion(\'¿Esta seguro que desea borrar este panel de comunicación?.\',
				\'300\',\'150\',
				\'borrar_panel.php\', \'idd='.$_GET['id_panel'].'\', \'mensaje\');" /><img src="../../../images/trashcan_empty.png" alt="Borrar Panel" border="0" /></a>'; } ?></td>
        <td width="3%" align="center"><a href="nuevo_panel.php" target="_self"><img src="../../../images/new_f2.png" alt="Nuevo Panel" width="32" height="32" border="0"></a></td>
        <td width="4%" align="center"><a href="javascript:void(0);" onclick="Dialog.alert({url: 'abrir_panel.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:700}, okLabel: 'Cerrar'});"><img src="../../../images/kappfinder.png" alt="Abrir Panel" width="50" height="50" border="0"></a></td>
        <td width="2%" align="center"><a href="javascript:void(0);" onclick="Dialog.alert({url: 'abrir_plantilla.php?id_panel=<?php echo $_GET['id_panel']; ?>', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:700}, okLabel: 'Cerrar'});"><img src="../../../images/themes_f2.png" alt="Abrir Plantilla" width="32" height="32" border="0"></a></td>
        <td width="3%" align="center"><img src="../../../images/save_f2.png" alt="Guardar Panel" width="32" height="32" border="0" onClick="procesar('guardar_panel.php','id_panel='+document.form1.id_panel.value+'&contenido_panel='+document.form1.contenido_panel.value+'&id_usuario='+document.form1.id_usuario.value+'&nombre_panel='+document.form1.nombre_panel.value+'&tags_panel='+document.form1.tags_panel.value+'&n_items='+document.form1.n_items.value+'&panel_width='+document.form1.panel_width.value+'&borde_panel='+document.form1.borde_panel.value+'&grosor_borde_panel='+document.form1.grosor_borde_panel.value+'&color_borde_panel='+document.form1.color_borde_panel.value+'&simbolos_width='+document.form1.simbolos_width.value+'&borde_simbolos='+document.form1.borde_simbolos.value+'&grosor_borde_simbolos='+document.form1.grosor_borde_simbolos.value+'&color_borde_simbolos='+document.form1.color_borde_simbolos.value+'&principal='+document.form1.principal.value+'&principal_width='+document.form1.principal_width.value+'&borde_simbolo_principal='+document.form1.borde_simbolo_principal.value+'&grosor_borde_simbolo_principal='+document.form1.grosor_borde_simbolo_principal.value+'&color_borde_simbolo_principal='+document.form1.color_borde_simbolo_principal.value+'&txt_inferior='+document.form1.txt_inferior.value+'&txt_superior='+document.form1.txt_superior.value+'&panel_color_fondo='+document.form1.panel_color_fondo.value+'&espacio_entre_simbolos='+document.form1.espacio_entre_simbolos.value+'','mensaje');"></td>
        <td width="1%" align="center"><?php  if ($id_panel=='' || $id_panel==0 || !isset($id_panel)) { echo '<input type="image" name="button" id="button" value="PREVISUALIZAR" src="../../../images/apply_f2.png" style="border:none;" onclick="this.form.action = \'nuevo_panel.php?id_panel=\'+document.form1.id_panel.value+\'\'"><input name="accion" type="hidden" id="accion" size="80" value="previsualizar">'; } 
	  else { echo '<input type="image" name="button" id="button" value="PREVISUALIZAR" src="../../../images/apply_f2.png" style="border:none;" onclick="this.form.action = \'nuevo_panel.php?id_panel=\'+document.form1.id_panel.value+\'\'"><input name="accion" type="hidden" id="accion" size="80" value="previsualizar">';
	   } 
	  ?>      </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:10px;">
      <tr>
        <td width="80%" valign="top">          </td>
        <td width="20%" rowspan="2" valign="top">
        
  
   <div id="a_tabbar" class="dhtmlxTabBar" imgpath="../js/dhtmlxTabbar/codebase/imgs/" style="width:280px; height:720px; margin-left:10px;" skinColors="#FCFBFC,#F4F3EE" mode="right">
    
      <!-- PESTAÑA 1 -->
    <div id="a1" name="D" style="padding-left:10px;">
      <p>&nbsp;</p>
      <p><strong>Nombre del Panel:
        </strong></p>
      <p><strong>
        <input name="nombre_panel" type="text" id="nombre_panel" size="35" value="<?php echo $nombre_panel ?>">
      </strong></p>
      <p><strong>Tags:</strong></p>
      <p><strong>
        <input name="tags_panel" type="text" id="tags_panel" size="35" value="<?php echo $tags_panel ?>">
        </strong></p>
      <p><strong>Texto Superior</strong></p>
      <p>
        <textarea name="txt_superior" cols="26" rows="5" id="txt_superior"><?php echo $txt_superior; ?></textarea>
      </p>
      <p><strong>Texto Inferior</strong></p>
      <p>
        <textarea name="txt_inferior" cols="26" rows="5" id="txt_inferior"><?php echo $txt_inferior; ?></textarea>
      </p>
      <p>
        <input name="contenido_panel" type="hidden" id="contenido_panel" value="<?php echo $contenido_panel; ?>" size="30">
      </p>
    </div>
    
     <!-- **********************************************************************************************  -->
     
     <!-- PESTAÑA 2 -->
    <div id="a2" name="C" style="padding-left:10px;">
      <p>&nbsp;</p>
      <p><strong>N&ordm; Items</strong>
        <input name="n_items" type="text" id="n_items" value="<?php echo $n_items; ?>" size="3" maxlength="2">
      </p>
      <p>&nbsp;</p>
      <p><strong>Panel:</strong></p>
      <p> Anchura del Panel
        <input name="panel_width" type="text" id="panel_width" value="<?php if ($panel_width != 590) { echo $panel_width; } else { echo '590'; } ?>" size="4" maxlength="3">
        </p>
      <p>Borde
        <input name="borde_panel" type="checkbox" id="borde_panel" value="1" <?php if ($borde_panel==1) { echo 'checked'; } ?>>
        </p>
      <p>Grosor
        <input name="grosor_borde_panel" type="text" id="grosor_borde_panel" value="<?php if ($grosor_borde_panel != 2) { echo $grosor_borde_panel; } else { echo '2'; } ?>" size="3" maxlength="2">
        </p>
      <p>Color Borde
        <input name="color_borde_panel" type="text" id="color_borde_panel" value="<?php if ($color_borde_panel != '#000000') { echo $color_borde_panel; } else { echo '#000000'; } ?>" size="7" maxlength="7" readonly>
            <a href="javascript:TCP.popup(document.forms['form1'].elements['color_borde_panel'])"><img width="30" height="21" border="0" alt="Seleccione el color" src="../../../images/gama_colores.gif" /></a></p>
      <p>Color Fondo
        <input name="panel_color_fondo" type="text" id="panel_color_fondo" value="<?php if ($panel_color_fondo != '#FFFFFF') { echo $panel_color_fondo; } else { echo '#FFFFFF'; } ?>" size="7" maxlength="7" readonly>
        <a href="javascript:TCP.popup(document.forms['form1'].elements['panel_color_fondo'])"><img width="30" height="21" border="0" alt="Seleccione el color" src="../../../images/gama_colores.gif" /></a></p>
      <p>&nbsp;</p>
      <p><strong>S&iacute;mbolos:</strong> </p>
      <p>Tama&ntilde;o
        <input name="simbolos_width" type="text" id="simbolos_width" value="<?php if ($simbolos_width != 50) { echo $simbolos_width; } else { echo '50'; } ?>" size="4" maxlength="3">
      </p>
      <p>
        Borde
        <input name="borde_simbolos" type="checkbox" id="borde_simbolos" value="1" <?php if ($borde_simbolos==1) { echo 'checked'; } ?>>
        </p>
      <p>Grosor
        <input name="grosor_borde_simbolos" type="text" id="grosor_borde_simbolos" value="<?php if ($grosor_borde_simbolos != 1) { echo $grosor_borde_simbolos; } else { echo '1'; } ?>" size="3" maxlength="2">
        </p>
      <p>Color
        <input name="color_borde_simbolos" type="text" id="color_borde_simbolos" value="<?php if ($color_borde_simbolos != '#CCCCCC') { echo $color_borde_simbolos; } else { echo '#CCCCCC'; } ?>" size="7" maxlength="7" readonly>
            <a href="javascript:TCP.popup(document.forms['form1'].elements['color_borde_simbolos'])"><img width="30" height="21" border="0" alt="Seleccione el color" src="../../../images/gama_colores.gif" /></a> </p>
      <p><a href="javascript:TCP.popup(document.forms['form1'].elements['color_sup'])"></a>Espacio entre s&iacute;mbolos 
        <select name="espacio_entre_simbolos" id="espacio_entre_simbolos">
          <option value="1" <?php if ($espacio_entre_simbolos==1) { echo 'selected'; } ?>>1 px</option>
          <option value="2" <?php if ($espacio_entre_simbolos==2) { echo 'selected'; } ?>>2 px</option>
          <option value="3" <?php if ($espacio_entre_simbolos==3) { echo 'selected'; } ?>>3 px</option>
          <option value="4" <?php if ($espacio_entre_simbolos==4) { echo 'selected'; } ?>>4 px</option>
          <option value="5" <?php if ($espacio_entre_simbolos==5) { echo 'selected'; } ?>>5 px</option>
          <option value="6" <?php if ($espacio_entre_simbolos==6) { echo 'selected'; } ?>>6 px</option>
          <option value="7" <?php if ($espacio_entre_simbolos==7) { echo 'selected'; } ?>>7 px</option>
        </select>
      </p>
      <p>&nbsp;</p>
      <p><strong>S&iacute;mbolo Principal:</strong></p>
      <p> Con Simbolo Principal
        <input name="principal" type="checkbox" id="principal2" value="1" <?php if ($principal==1) { echo 'checked'; } ?>>
        </p>
      <p>Tama&ntilde;o
        <input name="principal_width" type="text" id="principal_width" value="<?php if ($principal_width != 225) { echo $principal_width; } else { echo '225'; } ?>" size="4" maxlength="3">
        </p>
      <p>Borde
        <input name="borde_simbolo_principal" type="checkbox" id="borde_simbolo_principal" value="1" <?php if ($borde_simbolo_principal==1) { echo 'checked'; } ?>>
        </p>
      <p>Grosor
        <input name="grosor_borde_simbolo_principal" type="text" id="grosor_borde_simbolo_principal" value="<?php if ($grosor_borde_simbolo_principal != 1) { echo $grosor_borde_simbolo_principal; } else { echo '1'; } ?>" size="3" maxlength="2">
        </p>
      <p>Color
        <input name="color_borde_simbolo_principal" type="text" id="color_borde_simbolo_principal" value="<?php if ($color_borde_simbolo_principal != '#CCCCCC') { echo $color_borde_simbolo_principal; } else { echo '#CCCCCC'; } ?>" size="7" maxlength="7" readonly>
            <a href="javascript:TCP.popup(document.forms['form1'].elements['color_borde_simbolo_principal'])"><img width="30" height="21" border="0" alt="Seleccione el color" src="../../../images/gama_colores.gif" /></a> <a href="javascript:TCP.popup(document.forms['form1'].elements['color_sup'])"></a></p>
      <p>&nbsp;</p>
    </div>
     <!-- *******************************************************************  -->
     
    <!-- PESTAÑA 3 -->
    <div id="a3" name="S" style="padding-left:10px;">
        <p>&nbsp;</p>
        <p><strong>Cargar S&iacute;mbolos desde: </strong></p>
        <p><?php echo "&nbsp;<a href=\"javascript:void(0);\" onclick=\"return GB_show('Abrir Selección', 'cargar_seleccion.php?id_usuario=".$id_usuario."&id_panel=".$id_panel."', 300, 550)\">Mis Selecciones</a>&nbsp;"; ?> 
          <input name="id_usuario" type="hidden" id="id_usuario" size="80" value="<?php echo $id_usuario; ?>">
          <?php echo "&nbsp;<a href=\"javascript:void(0);\" onclick=\"return GB_show('Abrir directorio', 'cargar_directorio.php?id_usuario=".$id_usuario."&id_panel=".$id_panel."', 300, 550)\">Mi repositorio</a>";?></p>
        <div id="dhtmlgoodies_listOfItems"> 
		<div style="width:100%; height:600px;"> 	
		<ul id="allItems"> 
        <?php 
		if (isset($_SESSION['cart'])) { 
			foreach ($_SESSION['cart'] as $key => $value) {

			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
			$ruta=$key['ruta_cesto'];
			$ruta_img='size=30&ruta=../../../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 
			
			print "<li id=\"node".$ruta_cesto."\" style=\"width:70px; height:70px;\"><img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></li>";
			} 
			
		} else { echo "El cesto se encuentra vacio";   }

		if (isset($_GET['id_dir']) && $_GET['id_dir'] > 0 && $_GET['id_dir'] !='' && !isset($_GET['mi_seleccion'])) {
			
			$contenido_directorio=$query->contenido_directorio($_GET['id_dir']);
		 
				 while ($row=mysql_fetch_array($contenido_directorio)) {
					
					if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
					elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
					
						$ruta_img='size=30&ruta=../../../../'.$ruta;
						$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
						$ruta_cesto='ruta_cesto='.$ruta;
						$encript->encriptar($ruta_cesto,1); 	
						
						$miruta='img='.$ruta.'&file_id='.$row['file_id'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
						$encript->encriptar($miruta,1);
						
						print "<li id=\"node".$row['file_id']."\"><img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></li>";
					}
			
		} else {
		
			$simbolos_seleccion=$query->datos_simbolos_seleccion($_GET['mi_seleccion'],$id_usuario);
			while ($row=mysql_fetch_array($simbolos_seleccion)) {
				
				if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
				elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
					
					$ruta_img='size=30&ruta=../../../../'.$ruta;
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
					$ruta_cesto='ruta_cesto='.$ruta;
					$encript->encriptar($ruta_cesto,1); 
				
				print "<li id=\"node".$row['file_id']."\"><img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></li>";
			 
			} 
		
		}
		?>
		</ul> 
	 </div>
     </div>
     </div>
     <!-- *******************************************************************  -->
     
    <!-- PESTAÑA 4 -->
    <div id="a4" name="E" style="padding-left:10px;">
    <b>EXPORTAR PDF / PNG</b>
    <fieldset>
        <legend>&nbsp;Formato</legend>
        <div class="form-row">
        <label class="hand" for="pixel">
        <span class="labl">PIXELS de la P&aacute;gina</a></span></label>
        <span class="formw">
        <select name="pixels" id="pixel">
        <option value="640">640</option>
        <option value="800">800</option>
        <option value="1024" selected="selected">1024</option>
        <option value="1280">1280</option>
        </select>
        <input name="process_mode" type="hidden" id="process_mode" value="single" />
        <input type="hidden" tabindex="1" id="ur" name="URL" size="30" value="http://195.55.130.137/arasaac/inc/herramientas/creador_paneles/exportar_panel.php?id_panel=<?php echo $id_panel ?>&id_usuario=<?php echo $id_usuario; ?>"/>
        </span></div>
        
        <div class="form-row">
        <label class="hand" for="scalepoint"><span class="labl">Mantener proporcionalidad</a></span></label>
        <span class="formw">
        <input class="nulinp" type="checkbox" name="scalepoints" value="1" checked="checked" id="scalepoint"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="renderi"><span class="labl">Renderizar im&aacute;genes</span></label>
        <span class="formw">
         <input class="nulinp" type="checkbox" name="renderimages" value="1" checked="checked" id="renderi"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="renderi"><span class="labl">Procesar hipervinculos</a></span></label>
        <span class="formw">
         <input class="nulinp" type="checkbox" name="renderlinks" value="1" checked="checked" id="renderl"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="renderf"><span class="labl">Formularios Interactivos</span></label>
        <span class="formw">
        <input class="nulinp" type="checkbox" name="renderforms" value="1" id="renderl"/><sup style="color: red">FPDF/PDFLIB <em>1.6</em> output only!</sup>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="renderi"><span class="labl">Substitute special fields</span></label>
        <span class="formw">
         <input class="nulinp" type="checkbox" name="renderfields" value="1" checked="checked" id="renderl" disabled="disabled"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="medi"><span class="labl">Formato de impresi&oacute;n</span></label>
        <span class="formw">
        <select name="media" id="medi">
        <!--Can use php here to obtain predefined media types OR leave as is-->
        <option value="Letter">Letter</option>
        <option value="Legal">Legal</option>
        <option value="Executive">Executive</option>
        <option value="A0Oversize">A0Oversize</option>
        <option value="A0">A0</option>
        <option value="A1">A1</option>
        <option value="A2">A2</option>
        <option value="A3">A3</option>
        <option value="A4" selected="selected">A4</option>
        <option value="A5">A5</option>
        <option value="B5">B5</option>
        <option value="Folio">Folio</option>
        <option value="A6">A6</option>
        <option value="A7">A7</option>
        <option value="A8">A8</option>
        <option value="A9">A9</option>
        <option value="A10">A10</option>
        <option value="Screenshot640">Image 640&times;480</option>
        <option value="Screenshot800">Image 800&times;600</option>
        <option value="Screenshot1024">Image 1024&times;768</option>
        <!--end php predefined media options if used-->
        </select>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="cssmedia"><span class="labl">CSS</span></label>
        <span class="formw">
        <select name="cssmedia" id="cssmedia" disabled="disabled">
        <option value="handheld">Handheld</option>
        <option value="print">Print</option>
        <option value="projection">Projection</option>
        <option value="Screen" selected="selected">Screen</option>
        <option value="tty">TTY</option>
        <option value="tv">TV</option>
        </select>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="lm"><span class="labl">Margen izquierdo:mm</span></label>
        <span class="formw">
        <input id="lm" type="text" size="3" name="leftmargin" value="30" disabled="disabled"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="rm"><span class="labl">Margen derecho:mm</span></label>
        <span class="formw">
        <input id="rm" type="text" size="3" name="rightmargin" value="15" disabled="disabled"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="tm"><span class="labl">Margen Superior:mm</span></label>
        <span class="formw">
        <input id="tm" type="text" size="3" name="topmargin" value="15" disabled="disabled"/>
        </span>
        </div>
        <div class="form-row">
        <label class="hand" for="bm"><span class="labl">Margen inferior:mm</span></label>
        <span class="formw">
        <input id="bm" type="text" size="3" name="bottommargin" value="15" disabled="disabled"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="automargins"><span class="labl">Auto-size vertical margins</span></label>
        <span class="formw">
        <input id="automargins" class="nulinp" type="checkbox" name="automargins" value="1" disabled="disabled"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="landsc"><span class="labl">Apaisado</span></label>
        <span class="formw">
        <input id="landsc" class="nulinp" type="checkbox" name="landscape" value="1"/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="encod"><span class="labl">Codificaci&oacute;n</span></label>
        <span class="formw">
        <select id="encod" name="encoding">
        <option value="" selected="selected">Autodetect</option>
        <option value="utf-8">utf-8</option>
        <option value="iso-8859-1">iso-8859-1</option>
        <option value="iso-8859-2">iso-8859-2</option>
        <option value="iso-8859-3">iso-8859-3</option>
        <option value="iso-8859-4">iso-8859-4</option>
        <option value="iso-8859-5">iso-8859-5</option>
        <option value="iso-8859-6">iso-8859-6</option>
        <option value="iso-8859-7">iso-8859-7</option>
        <option value="iso-8859-9">iso-8859-9</option>
        <option value="iso-8859-10">iso-8859-10</option>
        <option value="iso-8859-11">iso-8859-11</option>
        <option value="iso-8859-13">iso-8859-13</option>
        <option value="iso-8859-14">iso-8859-14</option>
        <option value="iso-8859-15">iso-8859-15</option>
        <option value="windows-1250">windows-1250</option>
        <option value="windows-1251">windows-1251</option>
        <option value="windows-1252">windows-1252</option>
        <option value="koi8-r">koi8-r</option>
        </select>
        </span>
        </div>
        <div class="spacer"></div><br />
        </fieldset>
        
        <fieldset>
        <legend>&nbsp;Formato Archivo&nbsp;</legend>
        <div class="form-row">
        <label class="hand" for="ps"><span class="labl">Salida</span></label>
        <span class="formw">
        <input class="nulinp" type="radio" id="pdf" name="method" value="fpdf" checked="checked"/>PDF (FPDF)
        <br /><input class="nulinp" type="radio" id="png" name="method" value="png"/>Image (PNG) <span style="color: red; vertical-align: super; font-size: smaller;">beta</span>
        <!--<br /><input class="nulinp" type="radio" id="png" name="method" value="pcl"/>PCL <span style="color: red; vertical-align: super; font-size: smaller;">alpha</span>-->
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="ps"><span class="labl">Compatibilidad PDF:</span></label>
        <span class="formw">
        <select name="pdfversion">
        <option value="1.2">PDF 1.2 (NOT supported by PDFLIB!)</b></option>
        <option value="1.3" selected="selected">PDF 1.3 (Acrobat Reader 4)</option>
        <option value="1.4">PDF 1.4 (Acrobat Reader 5)</option>
        <option value="1.5">PDF 1.5 (Acrobat Reader 6)</option>
        </select>
        <br/>
        </span>
        </div>
        
        <div class="form-row">
        <label class="hand" for="towher"><span class="labl">Destino</span></label>
        <span class="formw">
        <label for="towher1">&nbsp;</label>
        <input name="output" type="radio" class="nulinp" id="towher1" value="1" checked="checked" /> 
        Descargar
        <br /><br />
        </span></div>
        
        <div class="form-row">
        &nbsp;
        <span class="formw">
        <!-- <input class="submit" type="submit" value="Download File (debugging only)" /> -->
        <input class="submit" type="reset"  name="reset"  value="RESETEAR" />
        &nbsp;
        <input class="submit" type="submit" name="convert" value="CONVERTIR" />
        </span>
        </div>
        <div class="spacer"></div><br />
	</fieldset>
    </div>
     <!-- *******************************************************************  -->
</div>		</td>
      </tr>
      <tr>
        <td valign="top">
        
        <div id="dhtmlgoodies_mainContainer" align="center">
	  <?php for($i = 1; $i <= $n_items; $i++) { 
			if ($i==1) {
			    echo '<div'; if ($principal==1) { echo ' id="big"'; } echo'><ul id="box'.$i.'">';
				if (isset($box) && array_key_exists($i, $box)) {  
				
					$row=$query->datos_archivo_repositorio($box[$i]);
					if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
					elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
					
					$ruta_img='size='.$simbolos_width.'&ruta=../../../../'.$ruta;
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
					
					print "<li id=\"node".$box[$i]."\"><img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></li>";  
					
				}
				echo '</ul></div>';
			} else {
				echo '<div><ul id="box'.$i.'">';
				
				if (isset($box) && array_key_exists($i,$box)) {  
				
					$row=$query->datos_archivo_repositorio($box[$i]);
					if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
					elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
					
					$ruta_img='size='.$simbolos_width.'&ruta=../../../../'.$ruta;
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
					
					print "<li id=\"node".$box[$i]."\"><img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></li>";  
				
				}
				echo '</ul></div>';
			}
		
		
		} ?>
	</div>        
    	</td>
      </tr>
    </table>   
    </p>

    </div>
    </form> 
  </div>
</div>
<ul id="dragContent"></ul> 
<div id="dragDropIndicator"><img src="../../images/insert.gif"></div> 
</body> 
</html>
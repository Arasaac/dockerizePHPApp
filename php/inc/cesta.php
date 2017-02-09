<?php 
session_start();  // INICIO LA SESION
require_once('../classes/crypt/5CR.php');
require_once('../configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

require ('../classes/languages/language_detect.php');
include ('../classes/querys/query.php');
$query= new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],18); 
?>
<h4><?php echo $translate['mi_cesto']; ?>:&nbsp;</h4><br/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5%" align="center" valign="middle">
      <div id="clearCart" onclick="clearCart();"><img src="images/trashcan_empty.gif" alt="<?php echo $translate['vaciar_mi_cesto']; ?>" title="<?php echo $translate['vaciar_mi_cesto']; ?>"/></div>
    <div id="loading"><img src="images/indicator.gif" alt="<?php echo $translate['cargando']; ?>..." /></div>      </p></td>
    <td width="6%" align="center" valign="middle"><a href="javascript:void(0);" onclick="Dialog.alert({url: 'zip.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:300, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: '<?php echo $translate['cerrar']; ?>'});"><img src="images/zip.gif" alt="<?php echo $translate['comprimir_cesto_zip']; ?>" title="<?php echo $translate['comprimir_cesto_zip']; ?>" border="0" /></a></td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
<p><div id="cart" style="position:relative; width:90%;"> 

	  <ul id="thelist1">
		<?php 
		if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") {
			foreach ($_SESSION['cart'] as $key => $value) {
			
			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
			$ruta=$key['ruta_cesto'];
			$ruta_img='size=50&ruta=../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 	
			
				echo "<li><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/><br><a href=\"javascript:void(0);\" onclick=\"clearProduct('$ruta_cesto');\"><img src=\"images/papelera.png\" border=\"0\" alt=\"Eliminar de mi cesto\" title=\"Eliminar de mi cesto\"/></a></li>";
			}
		}
		?>
</ul>
</div>

<?php 
session_start();  // INICIO LA SESION

?>
<h4>Mi cesto de s&iacute;mbolos:&nbsp; <a href="javascript:void(0);" onClick="Dialog.alert({url: 'zip.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:400, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: 'Cerrar'});"><img src="images/zip-icon.gif" alt="Comprimir mi cesto en un archivo ZIP" border="0" /></a> </h4>
<div id="cart" style="position:relative; width:90%;"> 

	  <ul id="thelist1">
		<?php 
		if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") {
			foreach ($_SESSION['cart'] as $key => $value) {
			
				print "<li><a href=\"javascript:ventana_modal('img=../../$key&enc=0','inc/imagen.php')\"><img src=\"classes/img/thumbnail.php?size=30&ruta=".md5('../../')."/$key\" border=\"0\"/></a><br><span onclick=\"clearProduct('$key');\"><img src=\"images/papelera.png\" border=\"0\"/></span>$key</li>";
			}
		}
		?>
</ul>
</div>


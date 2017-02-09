<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');

$id_usuario=$_SESSION['ID_USER'];

require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$query=new query();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Herramientas ARASAAC: Creador de Animaciones</title>
<script type="text/javascript" src="../js/ajax_herramientas.js"></script>
</head>
<body>
<div id="principal" style="height:350px;">
<div id="menu_superior" style="text-align:center;"><a href="javascript:void(0);" onclick="showDIV('cesto'); hideDIV('palabras');" >Cesto</a> | <a href="javascript:void(0);" onclick="showDIV('palabras'); hideDIV('cesto');" >Diccionario</a></div>

<!-- CAPA DE BUSQUEDA EN EL CESTO -->
<div id="cesto" style="display:none;">
<ul id="thelist5" style="height:280px; overflow:auto; width:100%; border:none; float:left;">
<?php 
                       if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") {
								
							$r=0;
									
                               foreach ($_SESSION['cart'] as $key => $value) {
                                    									
                                    $encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
                                    $ruta=$key['ruta_cesto'];
                                    $ruta_img='ruta=../../../../'.$ruta.'size=30';
                                    $encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
                                    $ruta_cesto='ruta_cesto='.$ruta;
                                    $encript->encriptar($ruta_cesto,1); 
									
									$origen=explode("/",$ruta);
									
									
									if ($origen[0]=='repositorio' && $origen[1]=='originales') {  
									
									    $n_img=explode(".",$origen[2]);
									
										$datos_img=$query->datos_imagen($n_img[0]);
									
										$ruta_usar_img="img=".$ruta."&id_palabra=".$datos_img['id_palabra'];
																			
										$encript->encriptar($ruta_usar_img,1);                             
                                   		
										echo '<li id="thelist5_'.$r.'"><a href="javascript:void(0);" onclick="seleccionar_pictograma_paneles(\''.$_GET['panel'].'\',\''.$_GET['fila'].'\',\''.$_GET['columna'].'\',\''.$ruta_img.'\');" target="_self"><img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="Utilizar imagen en el Generador de Paneles" border="0"></a></li>';
										
									} elseif ($origen[0]=='temp') {
									
									     $ruta_usar_img="img=".$ruta;
										 $encript->encriptar($ruta_usar_img,1);  
										 
										 echo '<li id="thelist5_'.$r.'"><a href="javascript:void(0);" onclick="seleccionar_pictograma_paneles(\''.$_GET['panel'].'\',\''.$_GET['fila'].'\',\''.$_GET['columna'].'\',\''.$ruta_img.'\');" target="_self"><img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="Utilizar imagen en el Creador" border="0"></a></li>';
									
									}
									
									$r++;
                               }
                          }
?>
</ul>
</div>
<!-- FIN DE LA CAPA DE BUSQUEDA EN EL CESTO -->

<!-- CAPA DE BUSQUEDA POR PALABRAS -->
<div id="palabras" style="display:none; text-align:left;">
<form action="" method="post" name="vm_diccionario">
              <strong>Diccionario:
              </strong></strong>
              <?php $categ3=$query->listar_categorias_palabras(); ?>
              <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">
                <option value="99">Todas</option>
                <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) { ?>
                <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra']; ?></option>
                <?php }  ?>
              </select> <br/>
              <strong>comienza por</strong>
              <input name="letra" type="text" id="letra" size="30" onkeypress="return handleEnter(this, event)"/>
<input type="button" name="Submit2" value="Buscar" onclick="procesar('listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'&panel=<?php echo $_GET['panel']; ?>&fila=<?php echo $_GET['fila']; ?>&columna=<?php echo $_GET['columna']; ?>','tabla_palabras');" />
<hr />
</form>
<div id="tabla_palabras" style="height:280px; overflow:auto"></div>
</div>
<!-- FIN DE LA CAPA DE BUSQUEDA POR PALABRAS -->


</div>
</body>
</html>
<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');

$id_usuario=$_SESSION['ID_USER'];

require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1);

$panel=$_GET['panel'];
$fila=$_GET['fila'];
$columna=$_GET['columna'];

$borde=$_GET['bc_'.$panel.'_'.$fila.'_'.$columna.''];
$ancho_borde=$_GET['abc_'.$panel.'_'.$fila.'_'.$columna.''];
$color_borde=$_GET['cbc_'.$panel.'_'.$fila.'_'.$columna.''];
$tipo_borde=$_GET['tbc_'.$panel.'_'.$fila.'_'.$columna.''];

$posic_texto_celda=$_GET['ptc_'.$panel.'_'.$fila.'_'.$columna.''];
$fuente_texto_celda=$_GET['ftc_'.$panel.'_'.$fila.'_'.$columna.''];
$size_font_texto_celda=$_GET['sftc_'.$panel.'_'.$fila.'_'.$columna.''];
$may_texto_celda=$_GET['mtc_'.$panel.'_'.$fila.'_'.$columna.''];
$color_texto_celda=$_GET['ctc_'.$panel.'_'.$fila.'_'.$columna.''];

$tist=$_GET['tist_'.$panel.'_'.$fila.'_'.$columna.''];
$tict=$_GET['tict_'.$panel.'_'.$fila.'_'.$columna.''];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $translate['herramientas_arasaac_catedu']; ?>: <?php echo $translate['configurador_celdas']; ?></title>
<script type="text/javascript" src="../js/ajax_herramientas.js"></script>
</head>
<body>
<div id="principal" style="text-align:left;">
  <form id="celda" name="celda" method="post" action="">
    <p><strong><?php echo $translate['borde']; ?>:</strong></p>
    <p><?php echo $translate['borde_celda']; ?>:
      <select name="borde" id="borde">
      	<option value="<?php echo $borde; ?>" selected="selected"><?php if ($borde==1) { echo $translate['con_borde']; } elseif ($borde==0) { echo $translate['sin_borde']; } ?></option>
        <option value="1"><?php echo $translate['con_borde']; ?></option>
        <option value="0"><?php echo $translate['sin_borde']; ?></option>
        </select>
      <select name="tipo_borde" id="tipo_borde">
        <option value="<?php echo $tipo_borde; ?>" selected="selected"><?php echo $tipo_borde; ?></option>
        <option value="single"><?php echo $translate['simple']; ?></option>
        <option value="dot"><?php echo $translate['punteado']; ?></option>
        <option value="dash"><?php echo $translate['linea_discontinua']; ?></option>
        <option value="dotdash"><?php echo $translate['alternando_puntos_guiones']; ?></option>
      </select>
    </p>
    <p><?php echo $translate['ancho_borde']; ?>:
      <label>
      <select name="ancho_borde" id="ancho_borde">
      	<option value="<?php echo $ancho_borde; ?>" selected="selected"><?php echo $ancho_borde; ?></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select>
      </label></p>
    <p><strong><?php echo $translate['texto']; ?>:</strong></p>
    <p><?php echo $translate['posicion']; ?>:
      <select name="posic_texto_celda" size="1" id="posic_texto_celda">
        <option value="<?php echo $posic_texto_celda; ?>" selected="selected"><?php if ($posic_texto_celda==0) { echo "Sin texto"; } elseif ($posic_texto_celda==1) { echo $translate['superior']; } elseif ($posic_texto_celda==2) { echo $translate['inferior']; }?></option>
        <option value="0"><?php echo $translate['sin_texto']; ?></option>
        <option value="1"><?php echo $translate['superior']; ?></option>
        <option value="2"><?php echo $translate['inferior']; ?></option>
                  </select>
</p>
    <p><?php echo $translate['fuente']; ?>:
      <select name="fuente_texto_celda" size="1" id="fuente_texto_celda" class="fonty">
          <option value="<?php echo $fuente_texto_celda; ?>" selected="selected"><?php echo $fuente_texto_celda; ?></option>
          <option value="Arial">Arial</option>
          <option value="Times">Times</option>
          <option value="Georgia">Georgia</option>
          <option value="Verdana">Verdana</option>
          <option value="Memima">Memima</option>
        </select>
      <select name="transform_texto_celda" size="1" id="transform_texto_celda" class="fonty">
        <option value="<?php echo transform_texto_celda; ?>" selected="selected">
          <?php if (transform_texto_celda==0) { echo $translate['normal']; } elseif (transform_texto_celda==1) { echo $translate['negrita']; } elseif (transform_texto_celda==2) { echo $translate['cursiva']; } elseif (transform_texto_celda==3) { echo $translate['negrita_y_cursiva']; }  ?>
        </option>
        <option value="0"><?php echo $translate['normal']; ?></option>
        <option value="1"><?php echo $translate['negrita']; ?></option>
        <option value="2"><?php echo $translate['cursiva']; ?></option>
        <option value="3"><?php echo $translate['negrita_y_cursiva']; ?></option>
      </select>
    </p>
    <p><?php echo $translate['size']; ?>:
      <select name="size_font_texto_celda" size="1" id="size_font_texto_celda" class="fonty">
          <option value="<?php echo $size_font_texto_celda; ?>"selected="selected"><?php echo $size_font_texto_celda; ?></option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="12">12</option>
          <option value="14">14</option>
          <option value="16">16</option>
          <option value="18">18</option>
          <option value="20">20</option>
          <option value="24">24</option>
          <option value="28">28</option>
          <option value="30">30</option>
          <option value="32">32</option>
          <option value="34">34</option>
          <option value="36">36</option>
          <option value="40">40</option>
          <option value="42">42</option>
          <option value="44">44</option>
          <option value="44">46</option>
          <option value="48">48</option>
          <option value="52">52</option>
          <option value="56">56</option>
          <option value="58">58</option>
      <option value="60">60</option>
          <option value="62">62</option>
          <option value="66">66</option>
          <option value="70">70</option>
        </select>
        <select name="may_texto_celda" size="1" id="may_texto_celda" class="fonty">
          <option value="<?php echo $may_texto_celda; ?>" selected="selected"><?php if ($may_texto_celda==0) { echo 'Min&uacute;sculas'; } elseif ($may_texto_celda==1) { echo 'May&uacute;sculas'; } ?></option>
          <option value="0">Min&uacute;sculas</option>
          <option value="1">May&uacute;sculas</option>
        </select>
    </p>
    <?php if ($fila != 'txt') { ?>
    <p><strong><?php echo $translate['imagen']; ?>:</strong></p>
    <p><?php echo $translate['size_sin_texto']; ?>: 
      <select name="tist" size="1" id="tist" class="fonty">
        <option value="<?php echo $tist; ?>"selected="selected"><?php echo $tist; ?></option>
        <option value="1">1</option>
        <option value="1.5">1.5</option>
        <option value="2">2</option>
        <option value="2.5">2.5</option>
        <option value="2.8">2.8</option>
        <option value="3">3</option>
        <option value="3.3">3.3</option>
        <option value="3.6">3.6</option>
        <option value="3.9">3.9</option>
        <option value="4">4</option>
        <option value="4.3">4.3</option>
        <option value="4.6">4.6</option>
        <option value="4.9">4.9</option>
        <option value="5">5</option>
        <option value="5.3">5.3</option>
        <option value="5.6">5.6</option>
        <option value="5.9">5.9</option>
        <option value="48">48</option>
        <option value="6">6</option>
        <option value="6.5">6.5</option>
        <option value="7">7</option>
        <option value="7.5">7.5</option>
        <option value="8">8</option>
        <option value="8.5">8.5</option>
        <option value="9">9</option>
      </select>
    </p>
    <p><?php echo $translate['size_con_texto']; ?>: 
      <select name="tict" size="1" id="tict" class="fonty">
        <option value="<?php echo $tict; ?>"selected="selected"><?php echo $tict; ?></option>
        <option value="1">1</option>
        <option value="1.5">1.5</option>
        <option value="2">2</option>
        <option value="2.5">2.5</option>
        <option value="2.8">2.8</option>
        <option value="3">3</option>
        <option value="3.3">3.3</option>
        <option value="3.6">3.6</option>
        <option value="3.9">3.9</option>
        <option value="4">4</option>
        <option value="4.3">4.3</option>
        <option value="4.6">4.6</option>
        <option value="4.9">4.9</option>
        <option value="5">5</option>
        <option value="5.3">5.3</option>
        <option value="5.6">5.6</option>
        <option value="5.9">5.9</option>
        <option value="48">48</option>
        <option value="6">6</option>
        <option value="6.5">6.5</option>
        <option value="7">7</option>
        <option value="7.5">7.5</option>
        <option value="8">8</option>
        <option value="8.5">8.5</option>
        <option value="9">9</option>
      </select>
    </p>
    <?php } else { 
	
		echo '<input name="tist" type="hidden" value="'.$tist.'" /><input name="tict" type="hidden" value="'.$tict.'" />';
	
	}?>
    <p>&nbsp;</p>
    <div align="center">
      <input type="button" value="<?php echo strtoupper($translate['guardar']); ?>" style="font-size:16px;" onclick="configurar_celda('<?php echo $panel; ?>','<?php echo $fila; ?>','<?php echo $columna; ?>',''+document.celda.borde.value+'',''+document.celda.ancho_borde.value+'',''+document.celda.posic_texto_celda.value+'',''+document.celda.fuente_texto_celda.value+'',''+document.celda.size_font_texto_celda.value+'',''+document.celda.may_texto_celda.value+'',''+document.celda.tist.value+'',''+document.celda.tict.value+'',''+document.celda.tipo_borde.value+'');" />
      <label></label>
    </div>
  </form>
</div>
</body>
</html>
<?php 
include ('../../classes/querys/query.php');

$query=new query();
$row=$query->datos_palabra($_GET['id_palabra']);
?>
<div align="center" id="add_simbolo" style="width:400px; height:300px; background-color:#FFFFFF;">
<form action="" method="post" name="add_simbolos">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          
          <tr valign="middle">
            <td width="21%"><div align="center"><img src="classes/img/thumbnail.php?size=150&ruta=../../temp/<?php echo $_GET['img']; ?>&enc=0" alt="Image" border="0" class="image" title="<?php echo utf8_encode($row['palabra']); ?>" /></div></td>
            <td width="79%"><p align="left"><strong>Palabra:</strong> <em><strong><?php echo utf8_encode($row['palabra']); ?>,</strong></em>&nbsp;&nbsp;<?php echo utf8_encode($row['definicion']); ?>
                <input name="id_palabra" type="hidden" id="id_palabra" value="<?php echo $row['id_palabra']?>" />
            </p>
              <p align="left"><strong>Tipo S&iacute;mbolo:</strong>
                    <?php $categ3=$query->listar_categorias_simbolos(); ?>
                    <select name="tipo_simbolo" class="textos" id="tipo_simbolo" required="1" realname="Categor&iacute;a">
                      <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
                      <option value="<?php echo $row_rsCategorias3['id_tipo']?>"><?php echo $row_rsCategorias3['tipo_simbolo']; ?></option>
                      <?php }  ?>
                </select>
              </p>
              <p align="left"><strong>Idioma:</strong>
                  <?php 
				  if ($_GET['id_idioma']==0) {
				 	 echo 'Sin idioma';
				  } else {
				  	echo $query->datos_idioma($_GET['id_idioma']); 
				  }
				  ?>
                  <input name="idioma" type="hidden" id="idioma" value="<?php echo $_GET['id_idioma']; ?>" />
              </p>
              <p align="left">
                <input name="castellano" type="checkbox" id="castellano" value="1"/>
  &nbsp;Texto en Castellano </p>
              <p align="left">
                <input name="mayusculas" type="checkbox" id="mayusculas" value="1"/>
&nbsp;May&uacute;sculas</p>
              <p align="left"><strong>Marco:</strong>
                <?php if ($_GET['marco']==0) { echo 'Sin marco'; } elseif ($_GET['marco']==1){ echo 'Con marco'; } ?>
                <input name="marco" type="hidden" id="marco" value="<?php echo $_GET['marco']; ?>" />
              </p>
              <p align="left"><strong>Constraste:</strong>
                <?php if ($_GET['contraste']=='normal') { echo 'Normal'; $contraste=0; } elseif ($_GET['contraste']==='invertir'){ echo 'Invertido'; $contraste=1;} elseif ($_GET['contraste']==='alto_contraste'){ echo 'Alto contraste'; $contraste=2;} ?>
                <input name="contraste" type="hidden" id="contraste" value="<?php echo $contraste; ?>" />
</p>
              <p align="left"><strong>Estado:</strong>
                  <select name="estado" id="estado">
                    <option value="2" selected="selected">Pendiente revisi&oacute;n</option>
                    <option value="1">Visible</option>
                    <option value="0">No Visible</option>
                </select>
              </p>
              <p align="left">
                <input name="registrado" type="checkbox" id="registrado" value="1"/>
  &nbsp;Registrado
  <input name="imagen" type="hidden" id="imagen" value="<?php echo $_GET['img']; ?>" />
              </p>            </td>
          </tr>
          <tr valign="middle">
            <td height="62" colspan="2"><div align="center">
              <input type="button" name="Submit" value="A&ntilde;adir" onclick="cargar_div('inc/creador_simbolos/add_simbolo.php','img='+document.add_simbolos.imagen.value+'&id_palabra='+document.add_simbolos.id_palabra.value+'&tipo_simbolo='+document.add_simbolos.tipo_simbolo.value+'&idioma='+document.add_simbolos.idioma.value+'&castellano='+document.add_simbolos.castellano.checked+'&estado='+document.add_simbolos.estado.value+'&registrado='+document.add_simbolos.registrado.checked+'&mayusculas='+document.add_simbolos.mayusculas.checked+'&marco='+document.add_simbolos.marco.value+'&contraste='+document.add_simbolos.contraste.value+'','add_simbolo');" />
            </div></td>
          </tr>
        </table>
</form>
</div>

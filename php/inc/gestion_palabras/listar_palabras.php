<?php 
session_start();
 
include ('../../classes/querys/query.php');

$query=new query();

$permisos=$query->permisos_usuario($_SESSION['ID_USER']);


$id_tipo="";
$letra="";

$id_tipo=$_POST['id_tipo'];
$letra=$_POST['letra'];
		
/* ******************************************************************************************* */ 
/*                            LISTAR PALABRAS 												   */
/* ******************************************************************************************* */ 

	
		if(!isset($_POST['pg'])){ 
		  $pg = "0"; 
		} else {
		  $pg = $_POST['pg'];
		}
		$cantidad=10; // cantidad de resultados por p&aacute;gina 
		$inicial = $pg * $cantidad;
		
		$contar=$query->listar_diccionario_palabras($id_tipo,$letra);
		$pegar=$query->listar_diccionario_palabras_limit($id_tipo,$letra,$inicial,$cantidad);
		
		$total_records = mysql_num_rows($contar);
		$pages = intval($total_records / $cantidad);
?>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>

 <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <thead>
      <tr>
        <th width="73" field="Id" dataType="Number"><div align="left"></div></th>
        <th width="33" align="center" field="Id" dataType="Number"><strong>Id</strong></th>
        <th width="196" field="Name" dataType="String"><div align="left"><strong>Palabra</strong></div></th>
        <th width="110" field="DateAdded" dataType="Date" sort="asc"><div align="center"><strong>A&ntilde;adida</strong></div></th>
        <th width="112" field="DateModified" dataType="Date" format="%b %d, %Y"><div align="center"><strong>Modificada</strong></div></th>
        <th colspan="2" dataType="html"><div align="left"><strong>Acepcion</strong> </div></th>
        <th width="19" dataType="html"><div align="left"><img src="images/china.gif" alt="Traducci&oacute;n al Chino" title="Traducci&oacute;n al Chino" width="18" height="12" class="Estilo1" /></div></th>
        <th width="19" dataType="html"><div align="left"><img src="images/idioma_arabe.gif" alt="Traducci&oacute;n al &Aacute;rabe" title="Traducci&oacute;n al &Aacute;rabe" width="18" height="12" /></div></th>
        <th width="19" dataType="html"><div align="left"><img src="images/ruso.gif" alt="Traducci&oacute;n al Ruso" title="Traducci&oacute;n al Ruso" width="18" height="12" /></div></th>
        <th width="18" dataType="html"><img src="images/polonia.jpg" alt="Traducci&oacute;n al Polaco" title="Traducci&oacute;n al Polaco" width="18" height="12" /></th>
        <th width="19" dataType="html"><div align="left"><img src="images/rumania.gif" alt="Traducci&oacute;n al Rumano" title="Traducci&oacute;n al Rumano" width="18" height="12" /></div></th>
        <th width="19" dataType="html"><div align="left"><img src="images/bulgaria.jpg" alt="Traducci&oacute;n al Bulgaro" title="Traducci&oacute;n al Bulgaro" width="18" height="12" /></div></th>
        <th width="17" dataType="html"><img src="images/english_flag.jpg" alt="Traducci&oacute;n al Ingl&eacute;s" title="Traducci&oacute;n al Ingl&eacute;s" width="18" height="12" /></th>
        <th width="17" dataType="html"><img src="images/france_flag.jpg" alt="Traducci&oacute;n al Franc&eacute;s" title="Traducci&oacute;n al Franc&eacute;s" width="18" height="12" /></th>
        <th width="17" dataType="html"><img src="images/bandera_catalan.gif" alt="Traducci&oacute;n al Catal&aacute;n" title="Traducci&oacute;n al Catal&aacute;n" width="18" height="12" /></th>
      </tr>
    </thead>
   <tbody>
      <?php
	  $color = 'tablaAlterno1';

		while ($entrada = mysql_fetch_array($pegar)) {
		
		$color = ($color == 'tablaAlterno1') ? 'tablaAlterno2' : 'tablaAlterno1';
		$id_palabra=$entrada['id_palabra'];
		?>
      <tr class="<?php echo $color; ?>">
        <td>
			<?php if ($permisos['gestion_palabras']==1) { ?>
			<a href="inc/gestion_palabras/editar_palabra.php?id=<?php echo $entrada['id_palabra']; ?>" onclick="return GB_showCenter('Editar palabra: <?php echo utf8_encode($entrada['palabra']); ?>', this.href, 550, 800)" target="_self"><img src="images/edit.gif" alt="Editar acepcion de: <?php echo utf8_encode($entrada['palabra']); ?>" title="Editar acepcion de: <?php echo utf8_encode($entrada['palabra']); ?>" border="0" /></a>
			<?php } ?>		</td>
        <td align="center"><?php echo $entrada['id_palabra']; ?></td>
        <td align="left"><?php echo utf8_encode($entrada['palabra']); ?></td>
        <td align="center"><?php echo $entrada['fecha_creacion']; ?></td>
        <td align="center"><?php echo $entrada['ultima_modificacion']; ?></td>
        <td width="32">
		<?php if ($permisos['definicion_palabras']==1) { ?>
		<a href="javascript:void(0);" onclick="cambia('palabra_<?php echo $entrada['id_palabra']?>','<?php echo $entrada['id_palabra']?>');"><img src="images/editar.gif" alt="Editar acepcion de: <?php echo utf8_encode($entrada['palabra']); ?>" border="0" /></a>
		<?php } ?>		</td>
        <td width="606"><div align="left"><span id="palabra_<?php echo $entrada['id_palabra']?>"><?php echo utf8_encode($entrada['definicion']); ?></span></div></td>
        <td>
		<?php 
		if ($permisos['traduccion_chino']==1) {
			 echo '<a href="inc/traduccion/traduccion.php?id_palabra='.$entrada['id_palabra'].'&id_idioma=4" onclick="return GB_showCenter(\''.'Palabra en chino: '.utf8_encode($entrada['palabra']).'\', this.href, 500, 750)" target="_self">';
			 
			 $chino=$query->buscar_traduccion($entrada['id_palabra'],4);
			 $row_chino=mysql_fetch_array($chino);
			 $num_rows_chino=mysql_num_rows($chino);
			  
			  if ($num_rows_chino == 1) {
			  
					 if ($row_chino['estado']==0) { echo '<img src="images/no_visible.gif" alt="'.utf8_encode("Traducción en chino no visible").'" border="0">';  }
					 elseif ($row_chino['estado']==1) { echo '<img src="images/visible.gif" alt="'.utf8_encode("Traducción en chino visible").'" border="0">'; }
					 elseif ($row_chino['estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="'.utf8_encode("Traducción en chino pendiente de revisión").'" border="0">'; } 
			
			  } elseif ($num_rows_chino > 1) {
					 echo '<img src="images/copiar.gif" alt="'.utf8_encode("Varias traducciones en chino").'" border="0">';
			  } else {
			  	echo '<img src="images/newsppr_no.gif" alt="'.utf8_encode("No hay traducción en chino").'" border="0">';
			  }

			 echo '</a>';
		}
		?>		</td>
        <td>
		<?php 
		if ($permisos['traduccion_arabe']==1) {
		echo '<a href="inc/traduccion/traduccion.php?id_palabra='.$entrada['id_palabra'].'&id_idioma=3" onclick="return GB_showCenter(\''.'Palabra en &aacute;rabe: '.utf8_encode($entrada['palabra']).'\', this.href, 500, 750)" target="_self">';
		
			 $arabe=$query->buscar_traduccion($entrada['id_palabra'],3);
			 $row_arabe=mysql_fetch_array($arabe);
			 $num_rows_arabe=mysql_num_rows($arabe);
			  
			  if ($num_rows_arabe == 1) {
			  
					 if ($row_arabe['estado']==0) { echo '<img src="images/no_visible.gif" alt="'.utf8_encode("Traducción en arabe no visible").'" border="0">';  }
					 elseif ($row_arabe['estado']==1) { echo '<img src="images/visible.gif" alt="'.utf8_encode("Traducción en arabe visible").'" border="0">'; }
					 elseif ($row_arabe['estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="'.utf8_encode("Traducción en arabe pendiente de revisión").'" border="0">'; } 
					 
			  } elseif ($num_rows_arabe > 1) {
				echo '<img src="images/copiar.gif" alt="'.utf8_encode("Varias traducciones en Árabe").'" border="0">'; 
			  } else {
			  	echo '<img src="images/newsppr_no.gif" alt="'.utf8_encode("No hay traducción en arabe").'" border="0">';
			  }
			  
		echo '</a>';
		}
		?>		</td>
        <td>
		<?php 		
		if ($permisos['traduccion_ruso']==1) {
		     echo '<a href="inc/traduccion/traduccion.php?id_palabra='.$entrada['id_palabra'].'&id_idioma=1" onclick="return GB_showCenter(\''.'Palabra en ruso: '.utf8_encode($entrada['palabra']).'\', this.href, 500, 750)" target="_self">';
			
			  $ruso=$query->buscar_traduccion($entrada['id_palabra'],1);
			 $row_ruso=mysql_fetch_array($ruso);
			 $num_rows_ruso=mysql_num_rows($ruso);
			  
			  if ($num_rows_ruso == 1) {
			  
					 if ($row_ruso['estado']==0) { echo '<img src="images/no_visible.gif" alt="'.utf8_encode("Traducción en ruso no visible").'" border="0">';  }
					 elseif ($row_ruso['estado']==1) { echo '<img src="images/visible.gif" alt="'.utf8_encode("Traducción en ruso visible").'" border="0">'; }
					 elseif ($row_ruso['estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="'.utf8_encode("Traducción en ruso pendiente de revisión").'" border="0">'; 
			  } 
			  
			  } elseif ($num_rows_ruso > 1) {
				echo '<img src="images/copiar.gif" alt="'.utf8_encode("Varias traducciones en Ruso").'" border="0">';	 
			  } else {
			  	echo '<img src="images/newsppr_no.gif" alt="'.utf8_encode("No hay traducción en ruso").'" border="0">';
			  }
			
			 echo '</a>';
		}?>		</td>
        <td><?php 
		if ($permisos['traduccion_rumano']==1) {
			 echo '<a href="inc/traduccion/traduccion.php?id_palabra='.$entrada['id_palabra'].'&id_idioma=6" onclick="return GB_showCenter(\''.'Palabra en polaco: '.utf8_encode($entrada['palabra']).'\', this.href, 500, 750)" target="_self">';
			 
			 $polaco=$query->buscar_traduccion($entrada['id_palabra'],6);
			 $row_polaco=mysql_fetch_array($polaco);
			 $num_rows_polaco=mysql_num_rows($polaco);
			  
			  if ($num_rows_polaco == 1) {
			  
					 if ($row_polaco['estado']==0) { echo '<img src="images/no_visible.gif" alt="'.utf8_encode("Traducci&oacute;n en polaco no visible").'" border="0">';  }
					 elseif ($row_polaco['estado']==1) { echo '<img src="images/visible.gif" alt="'.utf8_encode("Traducci&oacute;n en polaco visible").'" border="0">'; }
					 elseif ($row_polaco['estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="'.utf8_encode("Traducci&oacute;n en polaco pendiente de revisi&oacute;n").'" border="0">'; 
			  
			  } 
			  
			  } elseif ($num_rows_polaco > 1) {
				echo '<img src="images/copiar.gif" alt="'.utf8_encode("Varias traducciones en Polaco").'" border="0">'; 
			  } else {
			  	echo '<img src="images/newsppr_no.gif" alt="'.utf8_encode("No hay traducci&oacute;n en polaco").'" border="0">';
			  }
			
			 echo '</a>';
			 
			 echo '</a>';
		}
		?></td>
        <td>
		<?php 
		if ($permisos['traduccion_rumano']==1) {
			 echo '<a href="inc/traduccion/traduccion.php?id_palabra='.$entrada['id_palabra'].'&id_idioma=2" onclick="return GB_showCenter(\''.'Palabra en rumano: '.utf8_encode($entrada['palabra']).'\', this.href, 500, 750)" target="_self">';
			 
			 $rumano=$query->buscar_traduccion($entrada['id_palabra'],2);
			 $row_rumano=mysql_fetch_array($rumano);
			 $num_rows_rumano=mysql_num_rows($rumano);
			  
			  if ($num_rows_rumano == 1) {
			  
					 if ($row_rumano['estado']==0) { echo '<img src="images/no_visible.gif" alt="'.utf8_encode("Traducción en rumano no visible").'" border="0">';  }
					 elseif ($row_rumano['estado']==1) { echo '<img src="images/visible.gif" alt="'.utf8_encode("Traducción en rumano visible").'" border="0">'; }
					 elseif ($row_rumano['estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="'.utf8_encode("Traducción en rumano pendiente de revisión").'" border="0">'; 
			  } 
			  
			  } elseif ($num_rows_rumano > 1) {
				 echo '<img src="images/copiar.gif" alt="'.utf8_encode("Varias traducciones en Rumano").'" border="0">';	 
			  } else {
			  	echo '<img src="images/newsppr_no.gif" alt="'.utf8_encode("No hay traducción en Rumano").'" border="0">';
			  }
			
			 echo '</a>';
			 
			 echo '</a>';
		}
		?>		</td>
        <td><?php 
		if ($permisos['traduccion_bulgaro']==1) {
			 echo '<a href="inc/traduccion/traduccion.php?id_palabra='.$entrada['id_palabra'].'&id_idioma=5" onclick="return GB_showCenter(\''.'Palabra en b&uacute;lgaro: '.utf8_encode($entrada['palabra']).'\', this.href, 500, 750)" target="_self">';
			 
			 $bulgaro=$query->buscar_traduccion($entrada['id_palabra'],5);
			 $row_bulgaro=mysql_fetch_array($bulgaro);
			 $num_rows_bulgaro=mysql_num_rows($bulgaro);
			  
			  if ($num_rows_bulgaro == 1) {
			  
					 if ($row_bulgaro['estado']==0) { echo '<img src="images/no_visible.gif" alt="'.utf8_encode("Traducción en búlgaro no visible").'" border="0">';  }
					 elseif ($row_bulgaro['estado']==1) { echo '<img src="images/visible.gif" alt="'.utf8_encode("Traducción en búlgaro visible").'" border="0">'; }
					 elseif ($row_bulgaro['estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="'.utf8_encode("Traducción en búlgaro pendiente de revisión").'" border="0">'; 
			  } 
			  
			  } elseif ($num_rows_bulgaro > 1) {
				 echo '<img src="images/copiar.gif" alt="'.utf8_encode("Varias traducciones en Búlgaro").'" border="0">';	 
			  } else {
			  	echo '<img src="images/newsppr_no.gif" alt="'.utf8_encode("No hay traducción en búlgaro").'" border="0">';
			  }
			
			 echo '</a>';
			 
			 echo '</a>';
		}
		?></td>
        <td><?php 
		if ($permisos['traduccion_ingles']==1) {
			 echo '<a href="inc/traduccion/traduccion.php?id_palabra='.$entrada['id_palabra'].'&id_idioma=7" onclick="return GB_showCenter(\''.'Palabra en Ingl&eacute;s: '.utf8_encode($entrada['palabra']).'\', this.href, 500, 750)" target="_self">';
			 
			 $ingles=$query->buscar_traduccion($entrada['id_palabra'],7);
			 $row_ingles=mysql_fetch_array($ingles);
			 $num_rows_ingles=mysql_num_rows($ingles);
			  
			  if ($num_rows_ingles == 1) {
			  
					 if ($row_ingles['estado']==0) { echo '<img src="images/no_visible.gif" alt="'.utf8_encode("Traducci&oacute;n en b&uacute;lgaro no visible").'" border="0">';  }
					 elseif ($row_ingles['estado']==1) { echo '<img src="images/visible.gif" alt="'.utf8_encode("Traducci&oacute;n en b&uacute;lgaro visible").'" border="0">'; }
					 elseif ($row_ingles['estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="'.utf8_encode("Traducci&oacute;n en b&uacute;lgaro pendiente de revisi&oacute;n").'" border="0">'; 
					 
			  } 
			  
			  } elseif ($num_rows_ingles > 1) {
				echo '<img src="images/copiar.gif" alt="'.utf8_encode("Varias traducciones en Inglés").'" border="0">';	 
			  } else {
			  	echo '<img src="images/newsppr_no.gif" alt="'.utf8_encode("No hay traducci&oacute;n en Inglés").'" border="0">';
			  }
			
			 echo '</a>';
			 
			 echo '</a>';
		}
		?></td>
        <td><?php 
		if ($permisos['traduccion_frances']==1) {
			 echo '<a href="inc/traduccion/traduccion.php?id_palabra='.$entrada['id_palabra'].'&id_idioma=8" onclick="return GB_showCenter(\''.'Palabra en Franc&eacute;s: '.utf8_encode($entrada['palabra']).'\', this.href, 500, 750)" target="_self">';
			 
			 $frances=$query->buscar_traduccion($entrada['id_palabra'],8);
			 $row_frances=mysql_fetch_array($frances);
			 $num_rows_frances=mysql_num_rows($frances);
			  
			  if ($num_rows_frances == 1) {
			  
					 if ($row_frances['estado']==0) { echo '<img src="images/no_visible.gif" alt="'.utf8_encode("Traducci&oacute;n en Franc&eacute;s no visible").'" border="0">';  }
					 elseif ($row_frances['estado']==1) { echo '<img src="images/visible.gif" alt="'.utf8_encode("Traducci&oacute;n en Franc&eacute;s visible").'" border="0">'; }
					 elseif ($row_frances['estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="'.utf8_encode("Traducci&oacute;n en Franc&eacute;s pendiente de revisi&oacute;n").'" border="0">'; 
			
			  }
			  
			  } elseif ($num_rows_frances > 1) {
				echo '<img src="images/copiar.gif" alt="'.utf8_encode("Varias traducciones en Francés").'" border="0">';	 
			  } else {
			  	echo '<img src="images/newsppr_no.gif" alt="'.utf8_encode("No hay traducci&oacute;n en Francés").'" border="0">';
			  }
			
			 echo '</a>';
			 
			 echo '</a>';
		}
		?></td>
        <td><?php 
		if ($permisos['traduccion_catalan']==1) {
			 echo '<a href="inc/traduccion/traduccion.php?id_palabra='.$entrada['id_palabra'].'&id_idioma=9" onclick="return GB_showCenter(\''.'Palabra en Catal&aacute;n: '.utf8_encode($entrada['palabra']).'\', this.href, 500, 750)" target="_self">';
			 
			 $catalan=$query->buscar_traduccion($entrada['id_palabra'],9);
			 $row_catalan=mysql_fetch_array($catalan);
			 $num_rows_catalan=mysql_num_rows($catalan);
			  
			  if ($num_rows_catalan == 1) {
			  
					 if ($row_catalan['estado']==0) { echo '<img src="images/no_visible.gif" alt="'.utf8_encode("Traducci&oacute;n en Catal&aacute;n no visible").'" border="0">';  }
					 elseif ($row_catalan['estado']==1) { echo '<img src="images/visible.gif" alt="'.utf8_encode("Traducci&oacute;n en Catal&aacute;n visible").'" border="0">'; }
					 elseif ($row_catalan['estado']==2) { echo '<img src="images/pendiente_revision.gif" alt="'.utf8_encode("Traducci&oacute;n en Catal&aacute;n pendiente de revisi&oacute;n").'" border="0">'; 
			  } 
			  
			  } elseif ($num_rows_catalan > 1) {
				echo '<img src="images/copiar.gif" alt="'.utf8_encode("Varias traducciones en Catalán").'" border="0">';	 
			  } else {
			  	echo '<img src="images/newsppr_no.gif" alt="'.utf8_encode("No hay traducci&oacute;n en Catal&aacute;n").'" border="0">';
			  }
			
			 echo '</a>';
			 
			 echo '</a>';
		}
		?></td>
      </tr>
      <?php } ?>
   </tbody>
</table>
</div>
   <p>&nbsp;</p>
<table width="30%" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr class="textos">
                <td width="9%" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">
                  <input type="button" name="Submit" value="&lt;&lt;" onclick='cargar_div("inc/gestion_palabras/listar_palabras.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=0","tabla_admin_palabras");'>              </td>
                <td width="37%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
                  <input type="button" name="Submit" value="< Anterior" onclick='cargar_div("inc/gestion_palabras/listar_palabras.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=<?php echo $url ?>","tabla_admin_palabras");'>
              </div></td>
              <td width="10%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">&nbsp;</td>
        <td width="35%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
                  <input type="button" name="Submit" value="Siguiente >" onclick='cargar_div("inc/gestion_palabras/listar_palabras.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=<?php echo $url ?>","tabla_admin_palabras");'>
              </div></td>
              <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="button" value="&gt;&gt;" onclick='cargar_div("inc/gestion_palabras/listar_palabras.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=<?php echo $pages; ?>","tabla_admin_palabras");'></td>
            </tr>
</table>      
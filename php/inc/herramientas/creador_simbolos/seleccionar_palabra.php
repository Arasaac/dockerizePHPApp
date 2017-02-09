<?php 

session_start();

include ('../../../classes/querys/query.php');

require ('../../../classes/languages/language_detect.php');

$query=new query();

$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],27);

?>

<div align="center" id="actualizar_definicion" style="width:650px; height:500px; background:#FFFFFF url(images/find.gif) no-repeat bottom right;">

<form action="" method="post" name="vm_diccionario">

        <table width="100%"  border="0" cellspacing="0" cellpadding="0">

          <tr valign="middle">

            <td width="94%"><div align="left"><a href="javascript:void(0);" onclick=""></a></div></td>

          </tr>

          <tr valign="middle">

            <td><strong><?php echo $translate['diccionario']; ?>:

              </strong>

              <?php $categ3=$query->listar_categorias_palabras(); ?>

              <select name="tipo_palabra" class="textos" id="tipo_palabra" required="1" realname="Categor&iacute;a">

                <option value="99"><?php echo $translate['todas']; ?></option>

                <?php

							while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  

		 					 ?>

                <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra_'.$_SESSION['language'].'']; ?></option>

                <?php }  ?>

              </select> 

              <strong><?php echo $translate['comienza_por']; ?></strong>

              <input name="letra" type="text" id="letra" size="30" onkeypress="return handleEnter(this, event)"/>

              <select name="idiomabusqueda" id="idiomabusqueda">

                <option value="0" <?php if ($_SESSION['language']=='es') { echo 'selected="selected"'; } ?>><?php echo $translate['spanish']; ?></option>

                <option value="7" <?php if ($_SESSION['language']=='en') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(7); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>

                <option value="9" <?php if ($_SESSION['language']=='ca') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(9); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>

                <option value="14" <?php if ($_SESSION['language']=='ga') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(14); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>

                <option value="8" <?php if ($_SESSION['language']=='fr') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(8); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>

                <option value="11" <?php if ($_SESSION['language']=='de') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(11); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>

                <option value="12" <?php if ($_SESSION['language']=='it') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(12); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>

                <option value="13" <?php if ($_SESSION['language']=='pt') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(13); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>

                <option value="15" <?php if ($_SESSION['language']=='br') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(15); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>

                <option value="10" <?php if ($_SESSION['language']=='eu') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(10); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>

                <option value="2" <?php if ($_SESSION['language']=='ru') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(2); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>

                <option value="6" <?php if ($_SESSION['language']=='po') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(6); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>
                
                <option value="16" <?php if ($_SESSION['language']=='cr') { echo 'selected="selected"'; } ?>>

                  <?php $datos_idioma=$query->datos_idioma_completo(16); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>

                </option>
                

              </select>

            <input type="button" name="Submit2" value="<?php echo $translate['buscar']; ?>" onclick="cargar_div('listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'&id_idioma='+document.vm_diccionario.idiomabusqueda.value+'','tabla_palabras');" /></td>

          </tr>

        </table>

<hr />

</form>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

   <tr>

     <td width="80%" valign="top"><div id="tabla_palabras"></div></td>

     <td width="20%"><br />

      <br />

      <div id="clearCart"></div><div id="loading" align="center"><img src="../../../images/loading11.gif" alt="<?php echo $translate['cargando']; ?>..." title="<?php echo $translate['cargando']; ?>..." /></div></td>

   </tr>

 </table>

</div>


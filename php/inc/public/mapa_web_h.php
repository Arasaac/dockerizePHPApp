<?php 
include ('../../classes/querys/query.php');
require ('../../classes/languages/language_detect.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],7); 
?>
<div class="left_50">
<?php include ('../menu_lateral.php'); ?>
</div>

<div class="right_50">

	<div id="right">
       <h4><?php echo $translate['mapa_web']; ?></h4><br /><br />
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td width="50%" valign="top"><ul>
             <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/quienes_somos.php","i=","right"); cargar_div("inc/blanco.php","i=","submenu");'>&iquest;<?php echo $translate['que_arasaac']; ?>?</a></li><br />
             <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/condiciones_uso.php","i=","right"); cargar_div("inc/blanco.php","i=","submenu");'><?php echo $translate['condiciones_uso']; ?></a></li><br />
              <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/ultimas_noticias.php","i=","right"); cargar_div("inc/blanco.php","i=","submenu");'><?php echo $translate['ultimas_noticias']; ?></a></li><br />
              <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/listado_enlaces.php","i=","right"); cargar_div("inc/blanco.php","i=","submenu");'><?php echo $translate['otras_webs']; ?></a></li>
               <br />
              <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/subscripciones.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");'><?php echo $translate['subscripciones']; ?></a></li><br />
              <li><a href="javascript:void(0);" onClick="Dialog.alert({url: 'inc/public/contacta.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:550, height:470}, okLabel: 'Cerrar'});"><?php echo $translate['contacta']; ?></a></li><br />
            </ul>
           </td>
           <td width="50%" align="left" valign="top"><ul>
             <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/catalogos.php","i=","principal"); cargar_div("inc/menu_subprincipal.php","i=","submenu");'><?php echo $translate['catalogos']; ?></a>
               <ul>
                 <li><a href="javascript:void(0);" onClick="cargar_div('inc/public/ultimos_pictogramas_color.php','i=','principal');"><?php echo $translate['pictogramas_color']; ?></a></li>
                  <li><a href="javascript:void(0);" onClick="cargar_div('inc/public/ultimos_pictogramas_byn.php','i=','principal');"><?php echo $translate['pictogramas_byn']; ?></a></li>
                  <li><a href="javascript:void(0);" onClick="cargar_div('inc/public/ultimas_imagenes.php','i=','principal');"><?php echo $translate['imagenes']; ?></a></li>
                  <br />
               </ul>
              </li>
              <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/materiales.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");'><?php echo $translate['materiales']; ?></a></li><br />
              <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/descargas.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");'><?php echo $translate['descargas']; ?></a></li><br />
             <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/herramientas.php","i=","principal"); cargar_div("inc/blanco.php","i=","submenu");'><?php echo $translate['herramientas']; ?></a></li>
           </ul>    </td>
         </tr>
        </table>
    
    </div>
    
</div>
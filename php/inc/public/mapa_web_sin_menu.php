<?php 
include ('../../classes/querys/query.php');
require ('../../classes/languages/language_detect.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],7); 
?>
	<div id="right">
       <h4><?php echo $translate['mapa_web']; ?></h4><br /><br />
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td width="50%" valign="top"><ul>
           <li><a href="index.php"><?php echo $translate['inicio']; ?></a></li><br />
             <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/condiciones_uso.php","i=","right"); cargar_div("inc/blanco.php","i=","submenu");'><?php echo $translate['condiciones_uso']; ?></a></li><br />
             <li><a href="javascript:void(0);" onclick='cargar_div(&quot;inc/public/catalogos.php&quot;,&quot;i=&quot;,&quot;principal&quot;); cargar_div(&quot;inc/menu_subprincipal.php&quot;,&quot;i=&quot;,&quot;submenu&quot;);'><?php echo $translate['catalogos']; ?></a>
               <ul>
                 <li><a href="javascript:void(0);" onclick="cargar_div('inc/public/ultimos_pictogramas_color.php','i=','principal');"><?php echo $translate['pictogramas_color']; ?></a></li>
                 <li><a href="javascript:void(0);" onclick="cargar_div('inc/public/ultimos_pictogramas_byn.php','i=','principal');"><?php echo $translate['pictogramas_byn']; ?></a></li>
                 <li><a href="javascript:void(0);" onclick="cargar_div('inc/public/ultimas_imagenes.php','i=','principal');"><?php echo $translate['imagenes']; ?></a></li>
               </ul>
             </li><br />
             <li><a href="javascript:void(0);" onclick='cargar_div(&quot;inc/public/descargas.php&quot;,&quot;i=&quot;,&quot;principal&quot;); cargar_div(&quot;inc/blanco.php&quot;,&quot;i=&quot;,&quot;submenu&quot;);'><?php echo $translate['descargas']; ?></a></li><br />
            </ul>
           </td>
           <td width="50%" align="left" valign="top"><ul>
             <li><a href="javascript:void(0);" onclick="cargar_div('inc/public/caa.php','i=','principal'); cargar_div('inc/blanco.php','i=','submenu'); cargar_div('inc/menu_subprincipal_caa.php','i=','submenu');"><?php echo $translate['caa']; ?></a>
               <ul>
                 <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/software_caa.php","i=","principal");'><?php echo $translate['software_caa']; ?></a></li>
                 <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/listado_enlaces.php","i=","principal");'><?php echo $translate['otras_webs']; ?></a></li>
                 <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/bibliografia.php","i=","principal");'><?php echo $translate['bibliografia']; ?></a></li>
                 <li><a href="javascript:void(0);" onClick='cargar_div("inc/public/ejemplos_uso.php","i=","principal");'><?php echo $translate['ejemplos_de_uso']; ?></a></li>
               </ul>
             </li>
             <br />
             <li><a href="javascript:void(0);" onclick='cargar_div(&quot;inc/public/materiales.php&quot;,&quot;i=&quot;,&quot;principal&quot;); cargar_div(&quot;inc/blanco.php&quot;,&quot;i=&quot;,&quot;submenu&quot;);'><?php echo $translate['materiales']; ?></a></li>
             <br />
             <li><a href="javascript:void(0);" onclick='cargar_div(&quot;inc/public/herramientas.php&quot;,&quot;i=&quot;,&quot;principal&quot;); cargar_div(&quot;inc/blanco.php&quot;,&quot;i=&quot;,&quot;submenu&quot;);'><?php echo $translate['herramientas']; ?></a></li>
             <br />
             <li><a href="javascript:void(0);" onclick="cargar_div('inc/cesta.php','i=','principal');"><?php echo $translate['mi_cesto']; ?></a></li>
             <br />
             <li><a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/contacta.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:550, height:470}, okLabel: 'Cerrar'});"><?php echo $translate['contacta']; ?></a></li>
             <br />
             <li><a href="javascript:void(0);" onclick='cargar_div(&quot;inc/public/subscripciones.php&quot;,&quot;i=&quot;,&quot;principal&quot;); cargar_div(&quot;inc/blanco.php&quot;,&quot;i=&quot;,&quot;submenu&quot;);'><?php echo $translate['subscripciones']; ?></a></li>
           </ul>    </td>
         </tr>
        </table>
    
    </div>
   
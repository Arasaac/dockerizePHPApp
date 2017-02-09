<?php
require('requires_basico.php');
require('funciones/funciones.php');
require('configuration/key.inc');
require('classes/crypt/5CR.php');
$encript = new E5CR($llave);

$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],2);
$resultados='';

//Con este código elimino la variable pg que es dinamica
	$str = $_SERVER['QUERY_STRING'];
	parse_str($str, $info);
	unset($info['product_id']);
	$cadena_url=http_build_query($info);
	if ($cadena_url !='') { $cadena_url=http_build_query($info).'&'; }
//************************************************************

if (isset($_GET['palabra']) && $_GET['palabra'] !='') {
	$tag=$_GET['palabra'];
	$pictogramas_color=1;
	$pictogramas_byn=1;
	$fotografia=1;
	$simbolos=0;
	$videos_lse=1;
	$lse_color=0;
	$lse_byn=0;
	
	$inicial=0;
	$cantidad=10;
	
	$tipos_imagen=$query->listar_tipos_imagen_seleccionados($pictogramas_color,$pictogramas_byn,$fotografia,$videos_lse,$lse_color,$lse_byn);

	while ($salida=mysql_fetch_array($tipos_imagen)) {
	
	if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
		$img_disponibles=$query->imagenes_disponibles_tipo_por_tag_limit($tag,$salida['id_tipo'],$inicial,$cantidad);
	} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
		$img_disponibles=$query->imagenes_disponibles_idioma_tipo_por_tag($tag,$salida['id_tipo'],$_SESSION['id_language']);
	}
	
	$num_resultados=mysql_num_rows($img_disponibles);
	
	// Inicializo las variables
	$o=0;
	$img=array();
	$file='';
	
	// Si el numero de resultados es mayor de 0 muestro los resultados
	if ($num_resultados > 0) {
	
		if ($salida['ext']=='flv') { 
			$resultados.='<h5>'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' video/s)</h5>';
		} else { 
			$resultados.='<h5>'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' imagen/es)</h5>';
		}
		
		$resultados.='<ul id="thelist3">';
		
			while ($row=mysql_fetch_array($img_disponibles)) {
	
				if ($salida['id_tipo']==11) { //Si el tipo de original es Video de Acepciones en LSE
					
					$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
					$encript->encriptar($ruta_cesto,1);
					
					$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
					$encript->encriptar($ruta,1);
								
					$resultados.='<li><object id="'.$row['id_imagen'].'" width="'.$video_width.'" height="'.$video_height.'" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
						type="application/x-shockwave-flash"> 
						<param name="wmode" value="transparent">
						<param name="movie" value="plugins/flowplayer/flowplayer-3.1.1.swf" />  
						<param name="allowfullscreen" value="true" /> 
						 
						<param name="flashvars"  
							value=\'config={"clip": { "url": "repositorio/LSE_acepciones/'.$row['imagen'].'", "bufferLength": 2, "autoBuffering": true,
								"autoPlay": false, "scaling": "fit"}, "play": {"replayLabel": "Repetir" }, "plugins": { "controls": {"volume": false, "mute": false, "time":false, "height":15, "backgroundColor": "#FFFFFF", "progressColor": "#000000", "bufferColor": "#CCCCCC" } }  }\' /> 
					   </object>
							<br /><a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
						
						if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
							$resultados.=utf8_encode($row['palabra']);
						} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
							$resultados.=$row['traduccion'];
						}
						
						$archivo='repositorio/LSE_acepciones/'.$row['imagen'].'';
						
						if (file_exists($archivo)) {
						 		$peso_archivo = filesize($archivo);
								$info=''.tamano_archivo($peso_archivo).'&nbsp;-&nbsp;FLV';
						 }
						 
					$resultados.='</a><br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma">';
					 
					    if (file_exists('repositorio/LSE_definiciones/'.$row['id_palabra'].'.flv')) {
                        $resultados.='<a href="inc/public/ver_definicion.php?i='.$row['id_palabra'].'" target="_blank"><img src="images/icono_lse_13x13.jpg" alt="'.$translate['ver_definicion_lengua_signos'].'" title="'.$translate['ver_definicion_lengua_signos'].'" border=0" /></a> <a href="inc/public/ver_definicion.php?i='.$row['id_palabra'].'" target="_blank">'.$translate['ver_definicion_lse'].'</a><br />';
                        } 
						
					 $resultados.='<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' border="0" alt="'.$translate['descargar_video'].'" title="'.$translate['descargar_video'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_video'].'</a></div>';
					 
				
				} else { //Para el resto de tipos de Originales
												
								$ruta_img='size='.$img_size.'&ruta=../../repositorio/originales/'.$row['imagen'];
								$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
								
								$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
								$encript->encriptar($ruta,1);
								
								$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
								$encript->encriptar($ruta_cesto,1);
								
								$ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
								$encript->encriptar($ruta_creador,1); 
							
							$resultados.='<li>
							<a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'"><img src="classes/img/thumbnail.php?i='.$ruta_img.'" alt="Imagen: '.$file.'" border="0"/></a><br /><a href="ficha.php?id='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'">';
						
							if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
								$resultados.=utf8_encode($row['palabra']);
							} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
								$resultados.=$row['traduccion'];
							}
						
						$archivo='repositorio/originales/'.$row['imagen'].'';
						 
						$imagen='repositorio/originales/'.$row['imagen'];

						$extension = strtolower(substr(strrchr($imagen, "."), 1));
							
						switch ($extension) {
						
							case "gif":
							$source = imagecreatefromgif($imagen); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
							$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
							$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
							break;
							
							case "png":
							$source = imagecreatefrompng($imagen); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
							$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
							$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
							break;
							
							case "jpg":
							$source = imagecreatefromjpeg($imagen); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
							$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
							$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
							break;
						
						}	
						
						 if (file_exists($archivo)) {
						 		$peso_archivo = filesize($archivo);
								$info=$imageX.'X'.$imageY.'&nbsp;-&nbsp;'.tamano_archivo($peso_archivo).'&nbsp;-&nbsp;'.$extension;
						 }
						 
						$resultados.='</a><br /><div id="informacion_archivo">'.$info.'</div><br /><div id="informacion_pictograma"><a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'"><img src=\'images/add_4.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a>&nbsp;<a href="'.$PHP_SELF.'?'.$cadena_url.'product_id='.$ruta_cesto.'">'.$translate['add_seleccion'].'</a><br /><a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'"><img src=\'images/paint.gif\' border="0" alt="'.$translate['creador_de_simbolos'].'" title="'.$translate['creador_de_simbolos'].'"></a>&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'">'.$translate['creador_de_simbolos'].'</a><br /><a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download_5.png\' border="0" alt="'.$translate['descargar_imagen'].'" title="'.$translate['descargar_imagen'].'"></a>&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'">'.$translate['descargar_imagen'].'</a></div>'; 
							
				}		
	
			}
			
	
		} 
	
	$resultados.='</ul>';
		
	} // Cierro el While 
	
} else {

	include('configuration/tags.inc');

	$resultados='<br /><br /><div id="nube_de_tags">';
	//obtenemos el valor mas Alto y a partir de ahi 
	//obtenemos los rangos de Porcentaje para comparar
	$max_qty = max(array_values($tags));
	$per10 = round(($max_qty *.1));
	$per20 = round(($max_qty *.2));
	$per30 = round(($max_qty *.3));
	$per40 = round(($max_qty *.4));
	$per50 = round(($max_qty *.5));
	$per60 = round(($max_qty *.6));
	$per70 = round(($max_qty *.7));
	$per80 = round(($max_qty *.8));
	$per90 = round(($max_qty *.9));
	
				//Ahora si hacemos otro Ciclo para recorrer el 
                //Array comparar los Valores vs Porcentajes e Imprimimos el Tag
                foreach ($tags as $key => $value) {
                         
                    //Reinicializar Variables
                     $porcentaje=0;
                     $estilo=0;
                         
                    //Calcular el Porcentaje Real
                    $porcentaje=round(($value/$max_qty)*100);
                         
                        if ($value>=$per90 ){
                               $estilo=10;
                           }else if($value>=$per80 ){
                               $estilo=9;
                           }else if($value>=$per70 ){
                               $estilo=8;
                           }else if($value>=$per60 ){
                               $estilo=7;
                           }else if($value>=$per50 ){
                               $estilo=6;
                           }else if($value>=$per40 ){
                               $estilo=5;
                           }else if($value>=$per30 ){
                               $estilo=4;
                           }else if($value>=$per20 ){
                               $estilo=3;
                           }else if($value>=$per10 ){
                               $estilo=2;
                           }else{
                               $estilo=1;
                           }
                   //Imprmimos el Tag
                   $resultados.='<a href="'.$PHP_SELF.'?palabra='.$key.'" ';
                   $resultados.=' title="'.$value.' veces que se encontro este tag '.$key.'"';
                   $resultados.='  class="tagcloud_'.$estilo.'">'.$key.'</a> &nbsp; ';
                
              }
			
			$resultados.='</div><br /><br />';

}

require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['nube_tags']; ?></title>
    <script type="text/javascript" src="js/ajax2.js"></script>
    <script type="text/javascript" src="js/prototype/prototype.js"> </script>
    <link rel="stylesheet" href="js/autoComplete/autoComplete_css2.css" type="text/css" media="screen" charset="utf-8" />
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
     <?php require ('text_size_css.php'); ?>
</head>

<body>
            
<div class="body_content"> 

	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
        <?php include ('menu_principal.php'); ?>
        <?php include ('buscador.php'); ?>
        <?php include ('cesto.php'); ?>  
     <br /><h4><?php echo $translate['nube_tags']; ?>:</h4>	
		<div id="principal">
                
            <?php  echo $resultados; ?>
               
        </div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


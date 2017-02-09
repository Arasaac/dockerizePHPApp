<?php 
require('requires_basico.php');
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],29); 
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['bibliografia']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
	<?php require ('text_size_css.php'); ?>
    <?php 
    //Averiguar resolucion en pantalla
    //********************************************
    $siteurl = $_SERVER['REQUEST_URI'];
    $GLOBALS['siteurl'] = $siteurl;
    require('funciones/getres.php');
    ?>
</head>

<body>
            
<div class="body_content"> 

	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
        <?php include ('menu_principal.php'); ?>
        <?php include ('menu_subprincipal_caa.php'); ?>
		<?php echo '<a name="select" id="select"></a><h4>'.$translate['bibliografia'].'</h4>'; ?>
		<div id="principal">
            <div class="izquierda_50">
                  <p><strong>Alonso,P.,D&iacute;az-Est&eacute;banez,E, Madruga,B., Valmaseda,M.</strong>: <em>&quot;Introducci&oacute;n a la comunicaci&oacute;n bimodal.&quot;</em> MEC, CNREE (Centro Nacional de Recursos para la Educaci&oacute;n Especial), Madrid.</p>
                  <p><strong>Basil, C. y Puig, R.   (1988): </strong><em>&quot;Comunicaci&oacute;n aumentativa&quot;. </em>Ed. INSERSO. Madrid. </p>
                  <p><strong>Basil, C., Soro, E.   (1996):</strong> <em>&quot;Discapacidad motora, interacci&oacute;n y   adquisici&oacute;n del lenguaje: Sistemas   aumentativos y alternativos de   comunicaci&oacute;n.&quot; </em>(Guia y v&iacute;deos 1, 2, 3, 4) MEC-CDC.   Madrid. </p>
                  <p><strong>Basil, C.; Soro, E., y   Rosell, C. (2004):</strong> <em>&ldquo;Sistemas de signos y ayudas t&eacute;cnicas para la   comunicaci&oacute;n aumentativa y la escritura: principios te&oacute;ricos y   aplicaciones&rdquo;.</em>&nbsp; Ed. ELSEVIER-MASSON . Barcelona (1&ordm; Edici&oacute;n: MASSON 1998)</p>
                  <p><strong>Baumgart, Diane, Jonson, Jeanne y Helmstetter, Edwin, 1996</strong><em> &quot;Sistemas alternativos de comunicaci&oacute;n para personas con discapacidad&quot;</em> Alianza Psicolog&iacute;a.</p>
                  <p><strong>Beukelman, D. R., Mirenda, P., (2005)</strong> <em>&quot;Augmentative and Alternative Communication Supporting Children and Adults with Complex Communication&quot; </em></p>
                  <p><strong>Cornago, Anabel (2010)</strong> <em>&quot;El libro del juego.Del cucutr&aacute;s al juego simb&oacute;lico:                  c&oacute;mo conformar una conducta de juego paso a paso.&quot;</em></p>
                  <p><a href="http://catedu.es/arasaac/zona_descargas/materiales/297/Conformar%20la%20conducta%20de%20juego.pdf" target="_blank">Descargar documento pdf. </a></p>
      <p><strong>Guido Guevara, S.P., Obando, L., Toro, I., Rodriguez de Salazar, N., Lara, G., (2000)</strong> <em>&quot;Comunicaci&oacute;n Aumentativa y Alternativa&rdquo; Colombia, Ed. Recursos Educativos Universidad Pedag&oacute;gica&quot; </em></p>
                  <p><strong>Mayer, R.</strong> <em>&ldquo;SPC. S&iacute;mbolos pictogr&aacute;ficos para la comunicaci&oacute;n no vocal&rdquo;.</em> M&ordm; Educaci&oacute;n y Ciencia. Direc. Gral. De Ed. B&aacute;sica. 1986.</p>
                  <p><strong>Reichle, J., Beukelman, D.R., y Light, J.C. (2002)</strong> <em>&ldquo;Exemplary Practices for Beginning Communicators Implications for AAC&rdquo;</em> MD: Baltimore Paul H. Brookes Publishing Co.</p>
                  <p><strong>Rojo,A., Ju&aacute;rez,A.</strong>: <em>&quot;Programa elemental de comunicaci&oacute;n bimodal&quot;.</em> Cepe, Madrid, 1982.</p>
                  <p><strong>Schaeffer,   B., Raphael, A.,&nbsp; Kollinzas. G. (2005):</strong> &quot;<em>Habla signada para alumnos no   verbales&quot;</em>  Alianza Editoria. Madrid.</p>
                  <p><strong>Schlosser, R. (2001).</strong><em> &quot;The efficacy of augmentative and alternative communication: Toward evidence-based practice.&quot;</em> Academic Press. </p>
                  <p><strong>Soro-Camats, E. y&nbsp; Basil, C. (2006):</strong> <em>&quot;Desarrollo de la comunicaci&oacute;n y el lenguaje en ni&ntilde;os con discapacidad motora y   plurideficiencia.&quot;</em> En M.J. del R&iacute;o y V. Torrens (Coords.) <em>Lenguaje y   comunicaci&oacute;n en trastornos del desarrollo</em>.&nbsp; Pearson, 79-104. Madrid.</p>
                  <p><strong>Soto, G., &amp; Zangari, C. (2009)</strong> <em>&ldquo;Practically Speaking&rdquo; Language, Literacy, and Academic Development for Students with AAC Needs.</em> MD: Baltimore: Paul H. Brookes Publishing Co. </p>
                  <p><strong>Sotillo, M. (Ed.) (1993).</strong><em> &quot;Sistemas alternativos de comunicaci&oacute;n&quot;.</em> Madrid: Trotta.  </p>
                  <p><strong>Tamarit J. (1998): </strong><em>&quot;Sistemas Alternativos de   Comunicaci&oacute;n en autismo: algo m&aacute;s que una alternativa&quot;.</em> Alternativas para la   Comunicaci&oacute;n, 6, (pp.3-5)</p>
                  <p><strong>Tetzchner, S. von, Basil, C., Martinsen, H., (1993), </strong><em>&ldquo;Introducci&oacute;n a la ense&ntilde;anza de signos y al uso de ayudas t&eacute;cnicas para la comunicaci&oacute;n&rdquo; </em>Madrid, Ed. Antonio Machado Libros S.A.</p>
                 <p><strong>Torres, S. (2001): </strong><em>&quot;Sistemas alternativos de   comunicaci&oacute;n. Manual de comunicaci&oacute;n aumentativa y alternativa: sistemas y   estrategias.&quot;</em> Ed. Aljibe, M&aacute;laga</p>
                  <p> <strong>VON TETZCHNER, S., MARTINSEN, H (1993): </strong><em>&quot;Introducci&oacute;n a la   ense&ntilde;anza de signos y al uso de ayudas   t&eacute;cnicas para la comunicaci&oacute;n.&quot; </em>Antonio Machado Libros. Madrid</p>
                     <p> 
                    <strong>WARRICK,   Anne (1998) : </strong><em>&ldquo;Comunicaci&oacute;n sin habla. Comunicaci&oacute;n Aumentativa y Alternativa   alrededor del mundo&rdquo;
                    </em><br />
                    Serie   ISAAC: Volumen 1
                    <br />Original   en ingl&eacute;s editado por la International Society of Aumentative and Alternative   Communication (ISAAC), 1998
                    <br />Traducci&oacute;n del CEAPAT (2002) y revisi&oacute;n de Ana S&aacute;nchez y Cristina Larra   (CEAPAT).
                    <br />
                    <a href="http://www.ceapat.org/docs/ficheros/200706280020_4_4_0.pdf" target="_blank">Descargar documento pdf. </a>  </p>
                </div>
                
                
                <div class="derecha_50">
                  <p>
                  La  revista<strong> &quot;Comunicaci&oacute;n y Pedagog&iacute;a&quot;, n&ordm; 205 (2005)</strong>, N&uacute;mero monogr&aacute;fico sobre necesidades educativas especiales. Se recogen art&iacute;culos sobre CAA y sistemas de acceso al ordenador:</p>
                <ul>
                    <li>Pag. 29-35. <strong>J. Boix i C. Basil:</strong> <em>Comunicaci&oacute;n aumentativa y alternativa en atenci&oacute;n temprana.</em></li>
                    <li>Pag. 36-37.<strong> C. Imbern&oacute;n:</strong> <em>Creaci&oacute;n de materiales para el parendizaje y la comunicaci&oacute;n: El teclado de conceptos Intellikeys</em>.</li>
                    <li>Pag. 38-42. <strong>M. Lloria, I. Sevilla, S. Millet, I. Reyes i M. Fernandez de Arriba:</strong> <em>SICLA 2.0: Sistema de comunicaci&oacute;n de lenguajes aumentativos.</em></li>
                    <li>Pag. 43-45. <strong>Mayer-Johnson, LLC</strong>: <em>Materiales multimedia para el desarrollo del S.P.C.: Boardmaker y Speaking Dinamically Pro.</em></li>
                    <li>Pag. 46-49. <strong>T. Detheridge:</strong> <em>S&iacute;mbolos y futuras tecnolog&iacute;as: el proyecto Widgit Rebus.</em></li>
                    <li>Pag. 50-53. <strong>J. Lagares: </strong><em>Projecte Fressa 2005.</em></li>
                    <li>Pag. 54-58. <strong>M. D. Su&aacute;rez: </strong><em>Adquisici&oacute;n de la lectura y la escritura en alumnos con graves dificultades de habla y motricidad. Estudio de caso.</em></li>
                    <li>Pag. 59-64.<strong> F. Alcantud, I. Dolz, C. Gaya i M. Mart&iacute;n: </strong><em>Los sistemas de reconocimiento de voz como sistemas de acceso al ordenador en personas con discapacidad motriz: eficacia y satisfacci&oacute;n.</em></li>
                    <li>Pag. 65-70. <strong>M. G&oacute;mez i F.J. Soto:</strong> <em>Tecnolog&iacute;a y comunicaci&oacute;n aumentativa en alumnos con S&iacute;ndrome X Fr&agrave;gil.</em></li>
                    <li>Pag. 71- 75.<strong> A. Aguilar y C. Basil:</strong> <em>Acceso a Internet para usuarios de comunicaci&oacute;n aumentativa: el proyecto WWAAC.</em><br />
                </ul>
                      La revista <strong>&quot;Augmentative and Alternative Communication (AAC)&quot; </strong>, divulgada por la Societat Internacional de Comunicaci&oacute; Augmentativa i Alternativa (ISAAC) , publica art&iacute;culos de investigaci&oacute;n, reflexi&oacute;n te&oacute;rica y  de pr&aacute;ctica aplicada.<br />
                      <br />
                      Se puede encontrar m&aacute;s bibliograf&iacute;a sobre Comunicaci&oacute;n Aumentativa en las p&aacute;ginas: 
                      </ul>
                         <li><a href="http://aac.unl.edu/reference/aacinref.html" target="_blank">http://aac.unl.edu/reference/aacinref.html    </a></li>
                <li><a href="http://sapiens.ya.com/eninteredvisual/rincon_de_la_ca.htm" target="_blank">http://sapiens.ya.com/eninteredvisual/rincon_de_la_ca.htm</a></li>
                     </ul>
                    <br />
                    <img src="images/biblioteca.png" alt="<?php echo $translate['bibliografia']; ?>" title="<?php echo $translate['bibliografia']; ?>"/>
                 
                </div>
        </div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>


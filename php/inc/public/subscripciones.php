<?php 
session_start(); 
require ('../../classes/languages/language_detect.php');
include ('../../classes/querys/query.php');
$query= new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],15); 
?>
<h4><?php echo $translate['subscripciones_arasaac']; ?></h4><br />
<img src="images/rss2.png" alt="<?php echo $translate['subscribirse_catalogo']; ?>" title="<?php echo $translate['subscribirse_catalogo']; ?>" border="0" align="left" hspace="20" vspace="20" />
<h2><?php echo $translate ['recibe_novedades_arasaac']; ?></h2>
<p><?php echo $translate['explicacion_rss']; ?></p><br />
<div style="background-color:#CCCCCC; color:#333333; padding:5px; font-size:14px;"><strong><?php echo $translate['catalogos']; ?></strong></div>
<div style="border:1px solid #CCCCCC;">
  <ul style=" list-style:none; line-height:30px;">
    <li><img src="images/rss-icono.gif" border="0" alt="<?php echo $translate['canal']; ?>: <?php echo $translate['pictogramas_color']; ?>" title="<?php echo $translate['canal']; ?> <?php echo $translate['pictogramas_color']; ?>">&nbsp;&nbsp;<strong><?php echo $translate['pictogramas_color']; ?>:&nbsp;&nbsp;</strong> <a title="<?php echo $translate['url_otros_lectores']; ?>:" href="http://catedu.es/arasaac/rss/subscripcion.php?t=4&id_tipo=10" target="_blank"><img src="images/feed.png" border="0" alt="RSS" title="RSS"></a> | <a title="<?php echo $translate['google_personalizado']; ?>" href="http://www.google.com/ig/add?feedurl=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=10'); ?>" target="_blank"><img src="images/google.jpg" border="0" alt="<?php echo $translate['google_personalizado']; ?>" title="<?php echo $translate['google_personalizado']; ?>"></a> | <a title="BlogLines" href="http://www.bloglines.com/sub/http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=10'); ?>" target="_blank"><img src="images/bloglines.gif" border="0" alt="Bloglines" title="Bloglines"></a> | <a title="Netvibes" href="http://www.netvibes.com/subscribe.php?url=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=10'); ?>" target="_blank"><img src="images/netvibes.png" border="0" alt="Netvibes" title="Netvibes"></a> | <a title="Windows Live" href="http://www.live.com/Default.aspx?add=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=10'); ?>" target="_blank"><img src="images/windows-live.gif" border="0" alt="Windows Live" title="Windows Live"></a> | <a title="Yahoo" href="http://add.my.yahoo.com/content?url=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=10'); ?>" target="_blank"><img src="images/mi_yahoo.gif" border="0" alt="Yahoo" title="Yahoo"></a> </li>
    <li><strong><img src="images/rss-icono.gif" border="0" alt="<?php echo $translate['canal']; ?>: <?php echo $translate['pictogramas_byn']; ?>" title="<?php echo $translate['canal']; ?>: <?php echo $translate['pictogramas_byn']; ?>">&nbsp;&nbsp;<?php echo $translate['pictogramas_byn']; ?>:&nbsp;&nbsp;</strong><a title="<?php echo $translate['url_otros_lectores']; ?>:" href="http://catedu.es/arasaac/rss/subscripcion.php?t=4&id_tipo=5" target="_blank"><img src="images/feed.png" border="0" alt="RSS" title="RSS"></a> | <a title="<?php echo $translate['google_personalizado']; ?>" href="http://www.google.com/ig/add?feedurl=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=5'); ?>" target="_blank"><img src="images/google.jpg" border="0" alt="<?php echo $translate['google_personalizado']; ?>" title="<?php echo $translate['google_personalizado']; ?>"></a> | <a title="BlogLines" href="http://www.bloglines.com/sub/http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=5'); ?>" target="_blank"><img src="images/bloglines.gif" border="0" alt="Bloglines" title="Bloglines"></a> | <a title="Netvibes" href="http://www.netvibes.com/subscribe.php?url=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=5'); ?>" target="_blank"><img src="images/netvibes.png" border="0" alt="Netvibes" title="Netvibes"></a> | <a title="Windows Live" href="http://www.live.com/Default.aspx?add=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=5'); ?>" target="_blank"><img src="images/windows-live.gif" border="0" alt="Windows Live" title="Windows Live"></a> | <a title="Yahoo" href="http://add.my.yahoo.com/content?url=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=5'); ?>" target="_blank"><img src="images/mi_yahoo.gif" border="0" alt="Yahoo" title="Yahoo"></a> </li>
    <li><strong><img src="images/rss-icono.gif" border="0" alt="<?php echo $translate['canal']; ?>: <?php echo $translate['imagenes']; ?>" title="<?php echo $translate['canal']; ?>: <?php echo $translate['imagenes']; ?>">&nbsp;&nbsp;<?php echo $translate['imagenes']; ?>:&nbsp;&nbsp;</strong><a title="<?php echo $translate['url_otros_lectores']; ?>:" href="http://catedu.es/arasaac/rss/subscripcion.php?t=4&id_tipo=2" target="_blank"><img src="images/feed.png" border="0" alt="RSS" title="RSS"></a> | <a title="<?php echo $translate['google_personalizado']; ?>" href="http://www.google.com/ig/add?feedurl=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=2'); ?>" target="_blank"><img src="images/google.jpg" border="0" alt="<?php echo $translate['google_personalizado']; ?>" title="<?php echo $translate['google_personalizado']; ?>"></a> | <a title="BlogLines" href="http://www.bloglines.com/sub/http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=2'); ?>" target="_blank"><img src="images/bloglines.gif" border="0" alt="Bloglines" title="Bloglines"></a> | <a title="Netvibes" href="http://www.netvibes.com/subscribe.php?url=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=2'); ?>" target="_blank"><img src="images/netvibes.png" border="0" alt="Netvibes" title="Netvibes"></a> | <a title="Windows Live" href="http://www.live.com/Default.aspx?add=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=2'); ?>" target="_blank"><img src="images/windows-live.gif" border="0" alt="Windows Live" title="Windows Live"></a> | <a title="Yahoo" href="http://add.my.yahoo.com/content?url=http://catedu.es/arasaac/rss/subscripcion.php?<?php echo rawurlencode('t=4&id_tipo=2'); ?>" target="_blank"><img src="images/mi_yahoo.gif" border="0" alt="Yahoo" title="Yahoo"></a> </li>
  </ul>
</div>
<p>&nbsp;</p>
<div style="background-color:#CCCCCC; color:#333333; padding:5px; font-size:14px;"><strong><?php echo $translate['materiales']; ?></strong></div>
<div style="border:1px solid #CCCCCC;">
  <ul style=" list-style:none; line-height:30px;">
    <li><img src="images/rss-icono.gif" border="0" alt="<?php echo $translate['canal']; ?>: <?php echo $translate['ultimos_materiales_catalogo']; ?>" title="<?php echo $translate['canal']; ?>: <?php echo $translate['ultimos_materiales_catalogo']; ?>">&nbsp;&nbsp;<strong><?php echo $translate['ultimos_materiales_catalogo']; ?>:&nbsp;&nbsp;</strong> <a title="<?php echo $translate['url_otros_lectores']; ?>:" href="http://catedu.es/arasaac/rss/subscripcion.php?t=3" target="_blank"><img src="images/feed.png" border="0" alt="RSS" title="RSS"></a> | <a title="<?php echo $translate['google_personalizado']; ?>" href="http://www.google.com/ig/add?feedurl=http://catedu.es/arasaac/rss/subscripcion.php?t=3" target="_blank"><img src="images/google.jpg" border="0" alt="<?php echo $translate['google_personalizado']; ?>" title="<?php echo $translate['google_personalizado']; ?>"></a> | <a title="BlogLines" href="http://www.bloglines.com/sub/http://catedu.es/arasaac/rss/subscripcion.php?t=3" target="_blank"><img src="images/bloglines.gif" border="0" alt="Bloglines" title="Bloglines"></a> | <a title="Netvibes" href="http://www.netvibes.com/subscribe.php?url=http://catedu.es/arasaac/rss/subscripcion.php?t=3" target="_blank"><img src="images/netvibes.png" border="0" alt="Netvibes" title="Netvibes"></a> | <a title="Windows Live" href="http://www.live.com/Default.aspx?add=http://catedu.es/arasaac/rss/subscripcion.php?t=3" target="_blank"><img src="images/windows-live.gif" border="0" alt="Windows Live" title="Windows Live"></a> | <a title="Yahoo" href="http://add.my.yahoo.com/content?url=http://catedu.es/arasaac/rss/subscripcion.php?t=3" target="_blank"><img src="images/mi_yahoo.gif" border="0" alt="Yahoo" title="Yahoo"></a> </li>
    <li></li>
  </ul>
</div>
<p>&nbsp;</p>
<div style="background-color:#CCCCCC; color:#333333; padding:5px; font-size:14px;"><strong><?php echo $translate['noticias']; ?></strong></div>
<div style="border:1px solid #CCCCCC;">
  <ul style=" list-style:none; line-height:30px;">
    <li><img src="images/rss-icono.gif" border="0" alt="<?php echo $translate['canal']; ?>: <?php echo $translate['ultimas_noticias']; ?> ARASAAC" title="<?php echo $translate['canal']; ?>: <?php echo $translate['ultimas_noticias']; ?> ARASAAC">&nbsp;&nbsp;<strong><?php echo $translate['ultimas_noticias']; ?>:&nbsp;&nbsp;</strong> <a title="<?php echo $translate['url_otros_lectores']; ?>:" href="http://catedu.es/arasaac/rss/subscripcion.php?t=2" target="_blank"><img src="images/feed.png" border="0" alt="RSS" title="RSS"></a> | <a title="<?php echo $translate['google_personalizado']; ?>" href="http://www.google.com/ig/add?feedurl=http://catedu.es/arasaac/rss/subscripcion.php?t=2" target="_blank"><img src="images/google.jpg" border="0" alt="<?php echo $translate['google_personalizado']; ?>" title="<?php echo $translate['google_personalizado']; ?>"></a> | <a title="BlogLines" href="http://www.bloglines.com/sub/http://catedu.es/arasaac/rss/subscripcion.php?t=2" target="_blank"><img src="images/bloglines.gif" border="0" alt="Bloglines" title="Bloglines"></a> | <a title="Netvibes" href="http://www.netvibes.com/subscribe.php?url=http://catedu.es/arasaac/rss/subscripcion.php?t=2" target="_blank"><img src="images/netvibes.png" border="0" alt="Netvibes" title="Netvibes"></a> | <a title="Windows Live" href="http://www.live.com/Default.aspx?add=http://catedu.es/arasaac/rss/subscripcion.php?t=2" target="_blank"><img src="images/windows-live.gif" border="0" alt="Windows Live" title="Windows Live"></a> | <a title="Yahoo" href="http://add.my.yahoo.com/content?url=http://catedu.es/arasaac/rss/subscripcion.php?t=2" target="_blank"><img src="images/mi_yahoo.gif" border="0" alt="Yahoo" title="Yahoo"></a> </li>
    <li></li>
  </ul>
</div>
<p>&nbsp;</p>
<div style="background-color:#CCCCCC; color:#333333; padding:5px; font-size:14px;"><strong><?php echo $translate['busquedas']; ?></strong></div>
<div style="border:1px solid #CCCCCC;">
  <ul style=" list-style:none;">
    <li><?php echo $translate['explicacion_canal_busquedas']; ?></li>
    <li></li>
  </ul>
</div>
<p><br />
<div style="border:1px solid #CCCCCC; padding:10px;">
  <strong><?php echo $translate['que_es_rss']; ?></strong></p>
<p><?php echo $translate['explicacion_que_es_rss']; ?></p>
<blockquote>
  <p><strong><?php echo $translate['servicios']; ?>:</strong></p>
  <ul>
    <li><a target="_blank" title="<?php echo $translate['google_personalizado']; ?>" href="http://www.google.com/reader"><?php echo $translate['google_personalizado']; ?></a></li>
    <li><a target="_blank" title="BlogLines" href="http://www.bloglines.com">BlogLines</a></li>
    <li><a target="_blank" title="Netvibes" href="http://www.netvibes.com">Netvibes</a></li>
    <li><a target="_blank" title="Windows Live" href="http://www.live.com/">Windows Live</a></li>
    <li><a target="_blank" title="My Yahoo" href="http://my.yahoo.com">My Yahoo</a></li>
  </ul>
  <p><strong><?php echo $translate['aplicaciones']; ?>:</strong></p>
  <ul>
    <li><a href="http://www.feedreader.com/" title="FeedReader" target="_blank">FeedReader</a></li>
    <li><a href="http://www.rssreader.com" title="RssReader" target="_blank">RssReader</a></li>
    <li><a href="http://www.sharpreader.net" title="SharpReader" target="_blank">SharpReader</a></li>
    <li><a href="http://bradsoft.com/feeddemon/" title="FeedDemon " target="_blank">FeedDemon </a></li>
  </ul>
</blockquote>
<p><?php echo $translate['explicacion_lector_navegador']; ?></p>
</div>
<p>&nbsp;</p>

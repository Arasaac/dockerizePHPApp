<?PHP
class podcast
{

function make_xml_podcast_file($base_data)
	{
	unset($r);
	$r = '<?xml version="1.0" encoding="UTF-8"?>
	<!-- must include xmlns:itunes tag -->
	<rss xmlns:itunes="http://www.itunes.com/DTDs/Podcast-1.0.dtd" version="2.0">
	
	<channel>
	<title>'.$base_data['title'].'</title>
	<itunes:author>'.$base_data['author'].'</itunes:author>
	<description>'.$base_data['desc'].'</description>
	<link>'.$base_data['link_url'].'</link>
	<language>'.$base_data['lang'].'</language>
	<copyright>'.$base_data['copyright'].'</copyright>
	<itunes:owner>
	<itunes:name>'.$base_data['owner'].'</itunes:name>
	<itunes:email>'.$base_data['owner_email'].'</itunes:email>
	</itunes:owner>
	
	<lastBuildDate>'.$base_data['lastBuildDate'].'</lastBuildDate>
	<pubDate>'.$base_data['pubDate'].'</pubDate>
	<docs>'.$base_data['link'].'</docs>
	<webMaster>'.$base_data['webmaster'].'</webMaster>
	<image>
	<url>'.$base_data['image_url'].'</url>
	<title>'.$base_data['image_title'].'</title>
	<link>'.$base_data['image_link'].'</link>
	</image>
	<itunes:link rel="image" type="video/png" href="'.$base_data['image_img'].'">'.$base_data['nombre_blog'].'</itunes:link> 
	<category>'.$base_data['category'].'</category>
	<itunes:category text="'.$base_data['category'].'"></itunes:category>';
	return $r;
	}
	
function make_xml_podcast_items($res) {

		$r = '<item>
		<title>'.$res['title'].'</title>
		<link>'.$res['link'].'</link>
		<description>'.$res['desc'].'</description>
		<enclosure url="'.$res['link'].'" length="'.$res['length'].'" type="audio/mpeg"/>
		<category>Education</category>
		<pubDate>'.$res['pubdate'].'</pubDate>
		<itunes:duration>'.$res['duration'].'</itunes:duration>
		</item>';
return $r;
}
function make_xml_podcast_footer () {

	$r = '</channel>
	</rss>';
	
return $r;
}

function saveFeed($filename="", $xml) {
		if ($filename=="") {
			$filename = $this->_generateFilename();
		}
		$feedFile = fopen($filename, "w+");
		if ($feedFile) {
			fputs($feedFile,$xml);
			fclose($feedFile);
			if ($displayContents) {
				$this->_redirect($filename);
			}
		} else {
			echo "<br /><b>Error creando el Podcast. Revise los permisos de la carpeta.</b><br />";
		}
		
}

}
?>
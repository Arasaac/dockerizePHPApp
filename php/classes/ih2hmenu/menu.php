<?

Class iH2HMenu
{
	var $links;
	var $urls;
	
	function setMainLink($link,$url='#'){
		$this->links[$link] = $link;
		$this->urls[$link] = $url;
	}
	function setSubLink($link,$sublink,$url='#'){
		if($this->links[$link])
		{
			$sub = $this->links[$link];
			if(!is_array($sub))
				$sub = "";
			$sub[$sublink] = $url;
			$this->links[$link] = $sub;
		}
		else
		{
			print("no mainlinks exist ");
			exit();
		}
	}
	function files($style,$js){
		?>
		<link href="<?=$style?>" rel="stylesheet" type="text/css">
		<script src="<?=$js?>" type="text/javascript"></script>
		<?
	}
	function makeDivs(){
		//print_r($this->links);
		$links = $this->links;
		foreach($links as $key=> $value)
		{
			if(is_array($value)) 
			{ ?>
					<div id="<?=$key?>DIV" class="linkDIV" onMouseOver="MM_showHideLayers('<?=$key?>DIV','','show')" onMouseOut="MM_showHideLayers('<?=$key?>DIV','','hide')">
					<ul> <?
			
				foreach($value as $k => $val)
				{
				?>
					<li><a href="<?=$val?>"><?=ucwords($k)?></a></li><? } ?>
					</ul>
					</div>
				<?
				}
			}
	
	}
	function makeLinks(){
	$links = $this->links;
	foreach($links as $key=> $value)
	{
		if(is_array($value)){
			?><div class="links2" id="<?=$key?>" onMouseOver="setLyr(this,'<?=$key?>DIV');MM_showHideLayers('<?=$key?>DIV','','show')" onMouseOut="MM_showHideLayers('<?=$key?>DIV','','hide')"><a href="<?=$this->urls[$key]?>"><?=ucwords($key)?></a></div>
			<?
		}
		else
		{
			?><div class="links2" id="<?=$key?>"><a href="<?=$this->urls[$key]?>"><?=ucwords($key)?></a></div>
			<?
		}
	}
	}
}
?>
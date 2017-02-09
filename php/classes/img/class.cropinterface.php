<?php
require_once dirname(__FILE__) . '/class.cropcanvas.php';
	
class cropInterface extends canvasCrop
{
	var $file;
	var $img;
	var $crop;
	var $useFilter;


	/**
	* @return cropInterface
	* @param bool $debug
	* @desc Class initializer
	*/
	function cropInterface($debug = false)
	{
		parent::canvasCrop($debug);
		
		$this->img  = array();
		$this->crop = array();
		$this->useFilter = false;

		$agent = trim($_SERVER['HTTP_USER_AGENT']);
		if ((stristr($agent, 'wind') || stristr($agent, 'winnt')) && (preg_match('|MSIE ([0-9.]+)|', $agent) || preg_match('|Internet Explorer/([0-9.]+)|', $agent)))
		{
			$this->useFilter = true;
		}
		else
		{
			$this->useFilter = false;
		}
		$this->setResizing();
		$this->setCropMinSize();
	}

	
	/**
	* @return void
	* @param unknown $do
	* @desc Sets whether you want resizing options for the cropping area.
	* This is handy to use in conjunction with the setCropSize function if you want a set cropping size.
	*/
	function setResizing($do = true)
	{
		$this->crop['resize'] = ($do) ? true : false;
	}
	
	
	/**
	* @return void
	* @param int $w
	* @param int $h
	* @desc Sets the initial size of the cropping area.
	* If this is not specifically set, then the cropping size will be a fifth of the image size.
	*/
	function setCropDefaultSize($w, $h)
	{
		$this->crop['width']  = ($w < 5) ? 5 : $w;
		$this->crop['height'] = ($h < 5) ? 5 : $h;
	}
	
	
	/**
	* @return void
	* @param int $w
	* @param int $h
	* @desc Sets the minimum size the crop area can be
	*/
	function setCropMinSize($w = 25, $h = 25)
	{
		$this->crop['min-width']  = ($w < 5) ? 5 : $w;
		$this->crop['min-height'] = ($h < 5) ? 5 : $h;
	}
	

	/**
	* @return void
	* @param string $filename
	* @desc Load the cropping interface
	*/
	function loadInterface($filename)
	{
		if (!file_exists($filename))
		{
			die("El archivo '$filename' no pudo ser encoentrado.");
		}
		else
		{
			$this->file = $filename;
			$this->img['sizes'] = getimagesize($filename);
			if (!$this->crop['width'] || !$this->crop['height'])
			{
				$this->setCropDefaultSize(($this->img['sizes'][0] / 5), ($this->img['sizes'][1] / 5));
			}
		}
		echo '<script type="text/javascript" src="../../../js/img/wz_dragdrop.js"></script>', "\n";
		echo '<div id="theCrop" style="position:absolute;background-color:transparent;border:1px solid yellow;width:', $this->crop['width'], 'px;height:', $this->crop['height'], 'px;';
		if ($this->useFilter)
		{
			echo 'filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'transbg.png\',sizingMethod=\'scale\');';
		}
		else
		{
			echo 'background-image:url(transbg.png);';
		}
		echo "\"></div>\n";
		echo '<table border="1" style="border-collapse:collapse; border:1px solid black; width:100%;" align="center">';
		echo '<tr><td align="center" style="padding:5px;"><h6 align="center">', basename($this->file), ' (', $this->img['sizes'][0] + 20, ' x ', $this->img['sizes'][1]+20, ')';
		if ($this->crop['resize'])
		{
			echo '<br>Pulsar el botón \'Mayúsculas\' o \'Control\' y arrastrar con el ratón para establecer el área a recortar</h6>';
		}
		echo "</td></tr>\n";
		echo '<tr><td align="center"><h6 align="center"><img src="', $this->file, '" ', $this->img['sizes'][3], ' alt="crop this image" name="theImage"></h6></td></tr>', "\n";
		if ($this->crop['resize'])
		{
			echo '<tr><td style="font-size:11px;vertical-align:middle;padding:5px;"><h6 align="center"><input type="radio" id="resizeAny" name="resize" onClick="my_SetResizingType(0);" checked> <label for="resizeAny">Cualquier dimensión</label> &nbsp; <input type="radio" name="resize" id="resizeProp" onClick="my_SetResizingType(1);"> <label for="resizeProp">Proporcional</label></h6></td></tr>', "\n";
		}
		echo '<tr><td><h6 align="center"><input type="submit" value="Recortar imagen" id="submit" onClick="my_Submit();"></h6><input name="do" type="hidden" id="do" value="crop_dhtml"></td></tr>';
		echo "\n</table>\n";
	}
	
	
	/**
	* @return void
	* @desc Load the javascript required for a functional interface.
	* This MUST be called at the very end of all your HTML, just before the closing body tag.
	*/
	function loadJavaScript()
	{
		$params = '"theCrop"+MAXOFFLEFT+0+MAXOFFRIGHT+' . $this->img['sizes'][0] . '+MAXOFFTOP+0+MAXOFFBOTTOM+' . $this->img['sizes'][1] . ($this->crop['resize'] ? '+RESIZABLE' : '') . '+MAXWIDTH+' . $this->img['sizes'][0] . '+MAXHEIGHT+' . $this->img['sizes'][1] . '+MINHEIGHT+' . $this->crop['min-height'] . '+MINWIDTH+' . $this->crop['min-width'] . ',"theImage"+NO_DRAG';
		echo <<< EOT
<script type="text/javascript">
<!--

	SET_DHTML($params);

	dd.elements.theCrop.moveTo(dd.elements.theImage.x, dd.elements.theImage.y);
	dd.elements.theCrop.setZ(dd.elements.theImage.z+1);
	dd.elements.theImage.addChild("theCrop");
	dd.elements.theCrop.defx = dd.elements.theImage.x;

	function my_DragFunc()
	{
		dd.elements.theCrop.maxoffr = dd.elements.theImage.w - dd.elements.theCrop.w;
		dd.elements.theCrop.maxoffb = dd.elements.theImage.h - dd.elements.theCrop.h;
		dd.elements.theCrop.maxw    = {$this->img['sizes'][0]};
		dd.elements.theCrop.maxh    = {$this->img['sizes'][1]};
	}

	function my_ResizeFunc()
	{
		dd.elements.theCrop.maxw = (dd.elements.theImage.w + dd.elements.theImage.x) - dd.elements.theCrop.x;
		dd.elements.theCrop.maxh = (dd.elements.theImage.h + dd.elements.theImage.y) - dd.elements.theCrop.y;
	}
	
	function my_Submit()
	{
		self.location.href = 'do.php?do=crop_dhtml&file={$this->file}&sx=' + 
			(dd.elements.theCrop.x - dd.elements.theImage.x) + '&sy=' + 
			(dd.elements.theCrop.y - dd.elements.theImage.y) + '&ex=' +
			((dd.elements.theCrop.x - dd.elements.theImage.x) + dd.elements.theCrop.w) + '&ey=' +
			((dd.elements.theCrop.y - dd.elements.theImage.y) + dd.elements.theCrop.h);
	}
	
	function my_SetResizingType(proportional)
	{
		if (proportional)
		{
			dd.elements.theCrop.scalable  = 1;
			dd.elements.theCrop.resizable = 0;
		}
		else
		{
			dd.elements.theCrop.scalable  = 0;
			dd.elements.theCrop.resizable = 1;
		}
	}
	
//-->
</script>
EOT;
		}
}

?>

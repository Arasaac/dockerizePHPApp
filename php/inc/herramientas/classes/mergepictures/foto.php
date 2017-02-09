<?
/**
 * Foto class, 
 * take the image attributes
 * 
 * 
 * @author Germano Carvalho
 * @since 02/06/2007
 * @name foto.php
 * @version 1.0
 * @package Pitures
 * @subpackage Foto
 * 
 * @access public
 */


class foto{
	public $alt;
	public $tam;
	public $img;
	public $name;
	function foto($name){
		$dim = getimagesize($name);
		$this->tam = $dim[0];
		$this->alt = $dim[1];
		$this->img = imagecreatefromjpeg($name);
		$this->name = $name;
	}
}
class fotoPng{
	public $alt;
	public $tam;
	public $img;
	public $name;
	function fotoPng($name){
		$dim = getimagesize($name);
		$this->tam = $dim[0];
		$this->alt = $dim[1];
		$this->img = imagecreatefrompng($name);
		$this->name = $name;
	}
}
?>
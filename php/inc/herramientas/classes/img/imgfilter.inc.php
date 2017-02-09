<?php
/*
 * --------------------------------------------------------------------------
 *     E Y E F I                                         http://www.eyefi.nl/
 * --------------------------------------------------------------------------
 *     O P E N  S O U R C E                       http://opensource.eyefi.nl/
 * --------------------------------------------------------------------------
 *
 * Project: ImageModifier
 *
 * Version: 0.1
 * Release date: November 24, 2005
 *
 * Library homepage:
 * http://opensource.eyefi.nl/eyefi-imgfilter/
 *
 * Source available at:
 * http://www.sourceforge.net/projects/eyefi-imgfilter
 *
 * Copyright 2003, 2004, 2005 by Eyefi Interactive,
 * http://www.eyefi.nl
 *
 * Author:
 *   Arjan Scherpenisse <arjan@eyefi.nl>
 *
 * Contributors:
 *   Toon Toetenel <tny@eyefi.nl>
 *   Mikan Huppertz <mikan@eyefi.nl>
 *   Gijs Kunze <gijs@eyefi.nl>
 *
 * --------------------------------------------------------------------------
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 * --------------------------------------------------------------------------
 */

// SITE_ROOT not defined only if not in ECML.
if(!defined("SITE_ROOT")) define("SITE_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");

// The global image filter cache
// IMPORTANT: If you want to alter this path, copy the line below and put it in the sitewide config.inc.php.
// That way it dont get overwritten on a new version.
define("IMGCACHE_PATH", "saac/temp/");
define("IMAGEMODIFIER_CACHEPATH", SITE_ROOT.IMGCACHE_PATH);

// The chain definitions.
// IMPORTANT: If you want to add new filter chains, add them to the config.inc.php and not to this file.
$GLOBALS["IMAGEMODIFIER_CHAINS"]["thumb60x60"] = array( array("resize", array("width"=>60, "height"=>60)) );
$GLOBALS["IMAGEMODIFIER_CHAINS"]["thumb100x100"] = array( array("resize", array("width"=>100, "height"=>100)) );
$GLOBALS["IMAGEMODIFIER_CHAINS"]["thumb60x60b"] = array( array("resize", array("width"=>60, "height"=>60)), array("border") );
$GLOBALS["IMAGEMODIFIER_CHAINS"]["thumb100x100b"] = array( array("resize", array("width"=>100, "height"=>100)), array("border") );


function safe_imagecreatetruecolor($w, $h) {
    $fun = (function_exists("imagecreatetruecolor"))?"imagecreatetruecolor":"imagecreate";
    if (!function_exists($fun)) 
        trigger_error("ImageModifier: GD library not properly installed?", E_USER_ERROR);
    
    return $fun($w, $h);
}


class ImageModifier {

    var $_executed = array();

    var $_inres = false;
    var $_outres = false;

    var $_caching = true;

    var $_loadfrom = false;

    // cache magic: this ensures that we get an unique image each time for every distinct call to load().
    var $_loadmagic = false;

    var $_outputformat = "png"; // function imagecreatefromXXX must exist!

    var $_errorstring = false;

    var $_extraparams;

    // Chain is an array of modifier chains:
    // every entry is an (ChainName, parameters) tuple.
    // for instance:
    // 0 => ("resize", ("width"=>100, "height"=>100))
    // 1 => ("border")
    // This creates an 100x100 modifier with a border
    function ImageModifier($chain, $extraparams=false) {
        if (!is_array($chain)) {
            if (is_array($GLOBALS["IMAGEMODIFIER_CHAINS"][$chain])) {
                $chain = $GLOBALS["IMAGEMODIFIER_CHAINS"][$chain];
            } else {
                // This is just a programming error. 
                // Dont trigger an error, but echo and die, because otherwise smarty+soap probs.
                // trigger_error ("ImageModifier: Unknown chain: $chain", E_USER_ERROR);
                $fun = function_exists("dbg")?"dbg":"var_dump";
                $fun("<tt>ImageModifier: Unknown chain: $chain</tt>");
                die;
            }
        }
        // if (function_exists("imagecreatefrompng")) $this->_outputformat = "png";
        
        $this->_loadfrom = false;
        $this->chain = $chain;
        $this->_extraparams = $extraparams;
        $this->_executed = false;
    }

    function loadText($text) {
        $this->_loadmagic = $text;
        assert($this->chain[0][0] == "text");
        $this->chain[0][1]["text"] = $text;
        
        if ($this->isCached()) return;

        $this->_inres = safe_imagecreatetruecolor(1, 1);
        assert(is_resource($this->_inres));
    }
    
    function _loadGD($res) {
        $this->_loadmagic = (int)$res;
        if ($this->isCached()) return;
        
        $this->_inres = $res;
        assert(is_resource($this->_inres));
    }

    function _loadFile($filename) {
        $this->_loadmagic = $filename;
        if ($this->isCached()) return;

        // First, make absolute path if not absolute and no url
        if ($filename{0} != "/" && !preg_match("/^\w+:\/\//", $filename)) {
            $filename = getcwd()."/".$filename;
        }

        // Get extension
        if (preg_match("/\.([^\.]*)$/", $filename, $m)) {
            $ext = strtolower($m[1]);
            if ($ext == "jpg") $ext = "jpeg";
        } else
            $ext = "jpeg"; // some default

        // imagecreatefrom... function check
        $fun = "imagecreatefrom".$ext;
        if (!function_exists($fun)) {
            $this->_inres = $this->_error_gd("Function $fun does not exist!!", E_USER_WARNING);
            return;
        }

        // check for file existence if it is no URL
        if (!preg_match("/^\w+:\/\//", $filename) && !file_exists($filename)) {
            $this->_inres = $this->_error_gd("File '$filename' does not exist!", E_USER_NOTICE);
            return;
        }

        // load the actual image
        $this->_inres = @$fun($filename);

        // final check: the imageloadfrom... function might fail, even if file exists
        if (!is_resource($this->_inres)) {
            
            $this->_inres = $this->_error_gd("Function '$fun' failed on '$filename'!!", E_USER_WARNING);
            return;
        }
    }

    function _loadNew($w, $h) {
        $this->_loadmagic=$w.$h;
        if ($this->isCached()) return;
        
        $this->_inres = safe_imagecreatetruecolor($w, $h);
    }

    function _realload($x) {
        if (is_resource($x)) {
            $this->_loadGD($x);
        } elseif (is_array($x)) {
            $this->_loadNew($x[0], $x[1]);
        } else 
            $this->_loadFile($x);
    }

    function load($x) {
        $this->_loadfrom = $x;
        $this->_loadmagic = $x;
    }

    function _error_gd($error = "Generic error", $level=E_USER_NOTICE) {
        $gd = safe_imagecreatetruecolor(100, 100);

        $error = "ImageModifier: ".$error;

        switch($level) {
        case false:
            $back = imagecolorallocate($gd, 200, 200, 200);
            break;
            
        case E_USER_NOTICE:
            $back = imagecolorallocate($gd, 200, 200, 200);
            // trigger_error($error, $level);
            break;
        case E_USER_WARNING:
            $back = imagecolorallocate($gd, 255, 180,0);
            // trigger_error($error, $level);
            break;
        case E_USER_ERROR:
            $back = imagecolorallocate($gd, 255, 0, 0);
            trigger_error($error, $level);
            break;
        default:
            trigger_error("Unknown error level constant in ImageModifier::_error_gd");
        }
        
        imagefill($gd, 0, 0, $back);
        $yel = imagecolorallocate($gd, 255, 255, 255);

        // draw a nice cross in the error img
        imageline($gd, 0, 0, 99, 99, $yel);
        imageline($gd, 99, 0, 0, 99, $yel);
        for ($i=1; $i <= 5; $i++) {
            imageline($gd, 0, $i, 99-$i, 99, $yel);
            imageline($gd, $i, 0, 99, 99-$i, $yel);
            imageline($gd, 99-$i, 0, 0, 99-$i, $yel);
            imageline($gd, 99, $i, $i, 99, $yel);
        }
        
        $this->_errorstring = $error;
        return $gd;
    }

    function getGD() {
        $this->assureExecuted();
        assert(is_resource($this->_outres));
        return $this->_outres;
    }

    function getJPEG() {
        $this->_outputformat = "jpg";
        $this->assureExecuted();
        return $this->getCacheFileName();
    }

    function getPNG() {
        $this->_outputformat = "png";
        $this->assureExecuted();
        return $this->getCacheFileName();
    }

    function getGIF() {
        $this->_outputformat = "gif";
        $this->assureExecuted();
        return $this->getCacheFileName();
    }

    function getRelativeFilename() {
        $this->assureExecuted();
        $id = $this->getCacheId();
        return $id.".".$this->_outputformat;
    }
    
    function getImageSize() {
        $this->assureExecuted();
        return getimagesize($this->getCacheFileName());
    }

    /**
     * Sends headers to the browser to cache the current image.
     * The cache's expiry can be set in $expiry (defaults to 1 day)
     *
     * Source: comments from http://nl2.php.net/header
     */
    function sendCacheHeaders($expires = 86400) {
        $lastmod = @filemtime($this->getCacheFileName());
        $sendbody = true;
        $etag = $this->getCacheId();
        
        // check 'If-Modified-Since' header
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && gmdate('D, d M Y H:i:s', $lastmod)." GMT" == trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            header("HTTP/1.0 304 Not Modified");
            header("ETag: {$etag}");
            header("Content-Length: 0");
            $sendbody = false;
        }

        // check 'If-None-Match' header (ETag)
        if ($sendbody && isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
            $inm = explode(",",$_SERVER['HTTP_IF_NONE_MATCH']);
            foreach ($inm as $i) {
                if (trim($i) != $etag) continue;
                header("HTTP/1.0 304 Not Modified");
                header("ETag: {$etag}");
                header("Content-Length: 0");
                $sendbody = false; break;
            }
        }

        // caching headers (enable cache for one day)
        $exp_gmt = gmdate("D, d M Y H:i:s",time()+$expires)." GMT";
        // $mod_gmt = gmdate("D, d M Y H:i:s",$lastmod)." GMT";
        $mod_gmt = gmdate("D, d M Y H:i:s",$lastmod)." GMT";
        header("Expires: {$exp_gmt}");
        header("Last-Modified: {$mod_gmt}");
        header("Cache-Control: public, max-age={$expires}");
        header("Pragma: !invalid");

        return $sendbody;

    }
    
    function passthru() {
        $o = $this->_outputformat;
        if (strtolower($o)=="jpg") $o = "jpeg";
        $this->assureExecuted();

        $sendbody = $this->sendCacheHeaders();
        
        # On error, set a (non-standard) header. Might be useful in the future.
        if ($this->_errorstring)
            header("X-Content-Notice: ".$this->_errorstring);
        if ($sendbody) {
            header("Content-Type: image/$o");
            header("Content-Length: " .filesize($this->getCacheFileName()));
            header("ETag: ".$this->getCacheId());
            readfile($this->getCacheFileName());
        } else {
            header("Content-Type: !invalid");
        }
    }

    /** Returns full-fledged <IMG> tag */
    function getTag($opts = false) {
        $this->assureExecuted();
        $file = $this->getCacheFileName();
        if (substr($file, 0, strlen(SITE_ROOT)) != SITE_ROOT)
            die ("Cache directory must reside inside site root");
        $relativepath = substr($file, strlen(SITE_ROOT));
        if ($relativepath{0}!='/') $relativepath = "/".$relativepath;
        $res = @getimagesize($file);
        list($w, $h) = $res;

        $base = (isset($opts["base"])?$opts["base"]:"");
        unset($opts["base"]);

        if ($this->_errorstring) $opts["alt"] = $this->_errorstring;
        if ($opts !== false) {
            if (is_array($opts)) {
                $s = "";
                foreach($opts as $k=>$v)
                    $s .= sprintf("%s='%s'", $k, str_replace("'", "\'", $v));
                                  
                $opts = trim($s);
            }
        }
        $tag = "<img src='${base}${relativepath}' width='$w' height='$h' style='border: 0' $opts />";

        if ($this->_errorstring)
            return $tag . "<!--- ".$this->_errorstring." -->";

        return $tag;        
    }

    /** Returns <INPUT TYPE="image"> tag */
    function getButton($opts = false) {
        $this->assureExecuted();
        $file = $this->getCacheFileName();
        if (substr($file, 0, strlen(SITE_ROOT)) != SITE_ROOT)
            die ("Cache directory must reside inside site root");
        $relativepath = substr($file, strlen(SITE_ROOT));
        if ($relativepath{0}!='/') $relativepath = "/".$relativepath;
        $res = @getimagesize($file);
        list($w, $h) = $res;

        $base = (isset($opts["base"])?$opts["base"]:"");
        unset($opts["base"]);

        if ($this->_errorstring) $opts["alt"] = $this->_errorstring;
        if ($opts !== false) {
            if (is_array($opts)) {
                $s = "";
                foreach($opts as $k=>$v)
                    $s .= sprintf("%s='%s'", $k, str_replace("'", "\'", $v));
                                  
                $opts = trim($s);
            }
        }
        $tag = "<input type='image' src='${base}${relativepath}' width='$w' height='$h' border='0' $opts/>";

        if ($this->_errorstring)
            return $tag . "<!--- ".$this->_errorstring." -->";

        return $tag;        
    }

    function execute() {
        if (!$this->isCached()) {
            if (!is_resource($this->_inres)&&!is_resource($this->_loadfrom)) {
                $this->_realload($this->_loadfrom);
            }
            
            // do actual exec
            $this->_outres = $this->_inres;
            foreach($this->chain as $row) {
                list($chainname, $params) = $row;
                $fun = "ImageChain_".$chainname;
                if (function_exists($fun)) {
                    if (is_array($this->_extraparams[$chainname])) {
                        foreach($this->_extraparams[$chainname] as $k=>$v)
                            $params[$k] = $v;
                    }
                    $this->_outres = $fun($this->_outres, $params);
                    
                } else {
                    $this->_outres = $this->_error_gd("Broken chain: unknown function '$fun'!", E_USER_WARNING);
                }
            }
            
            $outfun = "image".((strtolower($this->_outputformat)!="jpg")?$this->_outputformat:"jpeg");

            if (function_exists($outfun))
                $outfun($this->_outres, $this->getCacheFileName());
            else
                // if we have no output function, we can only die...
                trigger_error("ImageModifier: function '$outfun' does not exists. Bailing out...");
        } 
        $this->_executed[$this->_outputformat] = true;
    }

    function assureExecuted() {
        if (!$this->_executed[$this->_outputformat]) $this->execute();
    }

    function getCacheId() {
        return md5(serialize($this->chain).serialize($this->_extraparams).serialize($this->_loadmagic).$this->_errorstring.@filemtime($this->_loadmagic));
    }

    function getCacheFileName() {
        $id = $this->getCacheId();
        return IMAGEMODIFIER_CACHEPATH.$id.".".$this->_outputformat;
    }

    function isCached() {
        $cached = $this->_caching  && file_exists($this->getCacheFileName()) && filesize($this->getCacheFileName());
        return $cached;
    }
}

function ImageChain_null(&$gd, $params=false) {
    return $gd;
}

function ImageChain__getdimension($dim, $original) {
    if (preg_match("/%$/", $dim)) {
        $dim = substr($dim, 0, strlen($dim)-1);
        $dim = ($dim/100) * $original;
    }

    return $dim;
}

/**
 * Parameters:
 * width, height - specify the bounding box
 * noaspect - force image into bounding box
 *
 * expand - only reduce the smallest of width and height to specified width. Image will be larger than bouding box!
 *
 * Example: image of 400x200 'resize to 100x100' (parameters width=100, height=100)
 * 1) No extra parameters: output image will be 100x50
 * 2) noaspect = true: image will be 100x100, stretched
 * 3) expand = true: image will be 200x100
 */    
function ImageChain_resize(&$gd, $params=false) {
    $src_w = imagesx($gd); $src_h = imagesy($gd);

    if (!isset($params["height"]) && !isset($params["width"])) {
        trigger_error("ImageChain_resize: missing width and/or height parameters");
    }
    
    if (isset($params["noaspect"]) && $params["noaspect"]) {
        $w = ImageChain__getdimension($params["width"], $src_w);
        $h = ImageChain__getdimension($params["height"], $src_h);
        
    } elseif (!isset($params["height"])) {
        $w = ImageChain__getdimension($params["width"], $src_w);
        $h = round($src_h / $src_w * $w);
    } elseif (!isset($params["width"])) {
        $h = ImageChain__getdimension($params["height"], $src_h);
        $w = round($src_w / $src_h * $h);
    } else {
        if(isset($params["nogrow"]) && $params["nogrow"] && $src_w < $params["width"] && $src_h < $params["height"]) return $gd;
        $src_aspect = $src_h / $src_w;
        $width = ImageChain__getdimension($params["width"], $src_w);
        $height = ImageChain__getdimension($params["height"], $src_h);
        
        $dst_aspect = $height / $width;

        if (!isset($params["expand"]) || !$params["expand"]) {
            // fit in bounding box
            if ($src_aspect>$dst_aspect) {
                $h = $height; $w = $src_w/$src_h * $h;
            } else {
                $w = $width; $h = $src_h/$src_w * $w;
            }
        } else {
            // expanding
            if ($src_aspect>$dst_aspect) {
                $w = $width; $h = $src_h/$src_w * $w;
            } else {
                $h = $height; $w = $src_w/$src_h * $h;
            }
        }
    }

    if ($src_w == $w && $src_h == $h)
        return $gd;
    
    $out = safe_imagecreatetruecolor($w, $h);
    $resizefun = (function_exists("imagecopyresampled"))?"imagecopyresampled":"imagecopyresized";
    $resizefun($out, $gd, 0, 0, 0, 0, $w, $h, $src_w, $src_h);
    imagedestroy($gd);
    
    return $out;
}

function &ImageChain_border(&$gd, $params=false) {
    if ($params["width"])
        $t = $params["width"];
    else
        $t = 2; // default 2 px border

    $w = imagesx($gd); $h = imagesy($gd);

    if ($params["enlarge"]) {
        $im = safe_imagecreatetruecolor($w+2*$t, $h+2*$t);
        imagecopy($im, $gd, $t, $t, 0, 0, $w, $h);
        imagedestroy($gd);
        $gd =& $im;
        $w += 2*$t;
        $h += 2*$t;
    }
    
    if ($params["color"]) {
        if (is_array($params["color"]))
            list($r, $g, $b) = $params["color"];
        else
            list($r, $g, $b) = htmlcolor2rgb($params["color"]);
        $col = imagecolorallocate($gd, $r, $g, $b);
    } else
        $col = imagecolorallocate($gd, 0, 0, 0); // black border = default

    for ($i=0; $i<$t; $i++) {
        imagerectangle($gd, $i, $i, $w-1-$i, $h-1-$i, $col);
    }
    return $gd;
}

/**
 * roundcorner
 *
 * params:
 * bgcolor: color string
 * radius: int
 * transparent: boolean
 *
 * border: boolean
 * border_color: color string
 * border_width: int
 */
function &ImageChain_roundcorner(&$gd, $params=false) {

    if (!isset($params["bgcolor"])) $params["bgcolor"] = "#FFFFFF";
    if (!isset($params["radius"]) || !is_numeric($params["radius"])) $params["radius"] = 16;
    $r = $params["radius"];

    $fact = 4;
    $w = imagesx($gd); $h=imagesy($gd);
    $w2 = $fact*$w; $h2 = $fact*$h; $r2 = $fact*$r;

    // 2) create mask image for bg
    $img = safe_imagecreatetruecolor($w2, $h2);
    $black = imagecolorallocate($img, 0, 0, 0);
    $white = imagecolorallocate($img, 255, 255, 255);

    imagefilledrectangle($img, $r2, 0, $w2-$r2, $h2, $white);
    imagefilledrectangle($img, 0, $r2, $w2, $h2-$r2, $white);

    imagefilledarc($img, ($r2-1), ($r2-1), $r2*2, $r2*2, 180, 270, $white, IMG_ARC_PIE);
    imagefilledarc($img, $w2 -($r2-1), ($r2-1), $r2*2, $r2*2, 270, 360, $white, IMG_ARC_PIE);
    imagefilledarc($img, ($r2-1), $h2-($r2-1), $r2*2, $r2*2, 90, 180, $white, IMG_ARC_PIE);
    imagefilledarc($img, $w2 -($r2-1), $h2 -($r2-1), $r2*2, $r2*2, 0, 90, $white, IMG_ARC_PIE);

    $bgmask = safe_imagecreatetruecolor($w, $h);
    imagecopyresampled($bgmask, $img, 0, 0, 0, 0, $w, $h, $w2, $h2);
    imagedestroy($img);

    // ... apply mask
    ImageChain_applymask_color($gd, $bgmask, $params["bgcolor"]);
    imagedestroy($bgmask);
    
    
    // 3) create mask image for border
    if ($params["border"]) {
        $bw = isset($params["border_width"])?$params["border_width"]:6;
        $bc = isset($params["border_color"])?$params["border_color"]:"#000000";

        $offset = ($fact*$bw)/2;
        $img = safe_imagecreatetruecolor($w2, $h2);
        $white = imagecolorallocate($img, 255, 255, 255);
        $black = imagecolorallocate($img, 0, 0, 0);
        imagefilledrectangle($img, 0, 0, $w2, $h2, $white);

        imagefilledellipse( $img, ($r2-1), ($r2-1), $r2*2, $r2*2, $black);
        imagefilledellipse( $img, ($r2-1), ($r2-1), $r2*2-2*$fact*$bw, $r2*2-2*$fact*$bw, $white);
        imagefilledellipse( $img, $w2-($r2-1), ($r2-1), $r2*2, $r2*2, $black);
        imagefilledellipse( $img, $w2-($r2-1), ($r2-1), $r2*2-2*$fact*$bw, $r2*2-2*$fact*$bw, $white);
        imagefilledellipse( $img, ($r2-1), $h2-($r2-1), $r2*2, $r2*2, $black);
        imagefilledellipse( $img, ($r2-1), $h2-($r2-1), $r2*2-2*$fact*$bw, $r2*2-2*$fact*$bw, $white);
        imagefilledellipse( $img, $w2-($r2-1), $h2-($r2-1), $r2*2, $r2*2, $black);
        imagefilledellipse( $img, $w2-($r2-1), $h2-($r2-1), $r2*2-2*$fact*$bw, $r2*2-2*$fact*$bw, $white);

        imagefilledrectangle ( $img, 0, $r2, $bw*$fact, $h2-$r2, $black );
        imagefilledrectangle ( $img, $w2-$bw*$fact, $r2, $w2, $h2-$r2, $black );
        
        imagefilledrectangle ( $img, $r2, 0, $w2-$r2, $bw*$fact, $black );
        imagefilledrectangle ( $img, $r2, $h2-$bw*$fact, $w2-$r2, $h2, $black );

        imagefilledrectangle( $img, $bw*$fact, $r2, $w2-$bw*$fact, $h2-$r2, $white);
        imagefilledrectangle( $img, $r2, $bw*$fact, $w2-$r2, $h2-$bw*$fact, $white);
        
        $bordermask = safe_imagecreatetruecolor($w, $h);
        imagecopyresampled($bordermask, $img, 0, 0, 0, 0, $w, $h, $w2, $h2);
        imagedestroy($img);

        // $gd = $bordermask; // $bordermask;
        ImageChain_applymask_color($gd, $bordermask, $bc);
        imagedestroy($bordermask);
    }

    // 4)
    return $gd;
}

function &ImageChain_applymask_color(&$dest, $src, $color) {
    if (imagesx($dest) != imagesx($src) || imagesy($dest) != imagesy($src))
        return false;

    $new = safe_imagecreatetruecolor(imagesx($src), imagesy($src));
    $col = htmlcolor2rgb($color);
    $fullcolor = imagecolorallocate($dest, $col[0], $col[1], $col[2]);
    
    if (imageistruecolor($src)) {
        for ($x=0; $x<imagesx($dest); $x++) {
            for ($y=0; $y<imagesy($dest); $y++) {
                $rgb = imagecolorat($src, $x, $y);
                $val = 1-((($rgb >> 16) & 0xFF) / 255.0); // take the 'R' component as the value
                if ($val == 0.0) continue; // dont change black pixels
                if ($val == 1.0) {
                    imagesetpixel($dest, $x, $y, $fullcolor);
                } else {
                    ImageChain_roundcorner_processpixel($dest, $col, $val, $x, $y);
                }
            }
        }
    } else {
        for ($x=0; $x<imagesx($dest); $x++) {
            for ($y=0; $y<imagesy($dest); $y++) {
                $c = imagecolorsforindex($gd, imagecolorat($gd, $x, $y));
                $val = 1-($c["red"]/255.0);
                if ($val == 0.0) continue; // dont change black pixels
                if ($val == 1.0) {
                    imagesetpixel($dest, $x, $y, $fullcolor);
                } else {
                    ImageChain_roundcorner_processpixel($dest, $col, $val, $x, $y);
                }
            }
        }
    }
}

function ImageChain_roundcorner_processpixel(&$gd, $col, $val, $x, $y) {
    if (imageistruecolor($gd)) {
        $rgb = imagecolorat($gd, $x, $y);
        $r = ($rgb >> 16) & 0xFF; $g = ($rgb >> 8) & 0xFF; $b = $rgb & 0xFF;
    } else {
        $c = imagecolorsforindex($gd, imagecolorat($gd, $x, $y));
        $r = $c["red"]; $g = $c["green"]; $b = $c["blue"];
    }
    $colindex = imagecolorallocate($gd, $val*$col[0]+(1-$val)*$r,
                                   $val*$col[1]+(1-$val)*$g,
                                   $val*$col[2]+(1-$val)*$b);
    imagesetpixel($gd, $x, $y, $colindex);
}

/**
 * params: map: which map to use ('large' or 'small')
 *              which: all|bottom|top
 */
function &ImageChain_roundcorner2(&$gd, $params=false) {
    $coordmap = array( "large" => array( array(0,0, 1.0),
                                         array(1,1, 1.0),
                                         array(0,1, 1.0),
                                         array(0,2, 1.0),
                                         array(0,3, 1.0),
                                         array(1,2, 0.87),
                                         array(2,2, 0.36),
                                         array(1,3, 0.45),
                                         array(0,4, 0.73),
                                         array(1,4, 0.05),
                                         array(0,5, 0.45),
                                         array(0,6, 0.22),
                                         array(0,7, 0.06)),
                       "small" => array( array(0,0, 1.0),
                                         array(1,1, 0.48),
                                         array(1,0, 1.0),  array(0,1, 1.0),
                                         array(2,0, 0.67), array(0,2, 0.67),
                                         array(3,0, 0.17), array(0,3, 0.17)
                                         )
                       );

    if (!$params["map"]) $params["map"] = "large";
    if (!$params["which"]) $params["which"] = "all";
    
    if (!$params["bgcolor"]) $params["bgcolor"] = "#FFFFFF";
    $col = htmlcolor2rgb($params["bgcolor"]);
    $w=imagesx($gd);$h=imagesy($gd);

    $wh = $params["which"];
    $topleft = $wh=="all"||$wh=="top"||$wh=="left"||$wh=="topleft";
    $topright = $wh=="all"||$wh=="top"||$wh=="right"||$wh=="topright";
    $botleft = $wh=="all"||$wh=="bottom"||$wh=="left"||$wh=="bottomleft";
    $botright = $wh=="all"||$wh=="bottom"||$wh=="right"||$wh=="bottomright";
    //var_dump($topleft, $topright, $botleft, $botright);
    //die;

    foreach($coordmap[$params["map"]] as $row) {
        list($x, $y, $val) = $row;
	
        if ($topleft) ImageChain_roundcorner_processpixel($gd, $col, $val, $x, $y);
        if ($topright) ImageChain_roundcorner_processpixel($gd, $col, $val, $w-$x-1, $y);
        if ($botleft) ImageChain_roundcorner_processpixel($gd, $col, $val, $x, $h-$y-1);
        if ($botright) ImageChain_roundcorner_processpixel($gd, $col, $val, $w-$x-1, $h-$y-1);
	
        if ($x != $y) {
            if ($topleft) ImageChain_roundcorner_processpixel($gd, $col, $val, $y, $x);
            if ($topright) ImageChain_roundcorner_processpixel($gd, $col, $val, $w-$y-1, $x);
            if ($botleft) ImageChain_roundcorner_processpixel($gd, $col, $val, $y, $h-$x-1);
            if ($botright) ImageChain_roundcorner_processpixel($gd, $col, $val, $w-$y-1, $h-$x-1);
        }
    }

    return $gd;
}

function ImageChain_cropsquare(&$gd, $params=false) {
    $w = imagesx($gd); $h = imagesy($gd);
    if ($w == $h) return $gd;
    $t = min($w, $h);
    $out = safe_imagecreatetruecolor($t, $t);
    
    if ($w < $h) {
        // portrait -> square
        $y1 = floor($h/2-$h/2);
        imagecopy($out, $gd, 0, 0, 0, $y1, $t, $t);
    } else {
        // landscape -> square
        $x1 = floor($w/2-$t/2);
        imagecopy($out, $gd, 0, 0, $x1, 0, $t, $t);
    }

    imagedestroy($gd);
    return $out;
}

/**
 * Crops an image to specified width / height
 *
 * Parameters: width, height
 * valign = top|middle|bottom
 * halign = left|center|right
 */
function ImageChain_crop(&$gd, $params=false) {
    $w = imagesx($gd); $h = imagesy($gd);
    $max_w = min($params["width"], $w);
    $max_h = min($params["height"], $h);

    if (!isset($params["valign"])) $params["valign"]="middle";
    if ($params["valign"] == "top") {
        $y = 0;
    } else if ($params["valign"] == "bottom") {
        $y = $h-$max_h;
    } else {
        // center / middle
        $y = floor(($h-$max_h)/2);
    }

    if (!isset($params["halign"])) $params["halign"]="center";
    if ($params["halign"] == "left") {
        $x = 0;
    } else if ($params["halign"] == "right") {
        $x = $w-$max_w;
    } else {
        // center / middle
        $x = floor(($w-$max_w)/2);
    }
    
    $out = safe_imagecreatetruecolor($max_w, $max_h);
    imagecopy($out, $gd, 0, 0, $x, $y, $max_w, $max_h);

    imagedestroy($gd);
    return $out;
}

/**
 * Crops an image to specified width / height RATIO
 *
 * Parameters: width, height
 * valign = top|middle|bottom
 * halign = left|center|right
 */
function ImageChain_crop_to_ratio(&$gd, $params=false) {
    $w = imagesx($gd); $h = imagesy($gd);
	$current_ratio = $w / $h;
	$new_ratio = $params["width"] / $params["height"];
	if($new_ratio < $current_ratio){
		$max_w = $w / $current_ratio * $new_ratio;
		$max_h = $max_w  / $params["width"] * $params["height"];
	} else {
		$max_h = $h * $current_ratio / $new_ratio;
		$max_w = $max_h / $params["height"] * $params["width"];
	}

    if (!isset($params["valign"])) $params["valign"]="middle";
    if ($params["valign"] == "top") {
        $y = 0;
    } else if ($params["valign"] == "bottom") {
        $y = $h-$max_h;
    } else {
        // center / middle
        $y = floor(($h-$max_h)/2);
    }

    if (!isset($params["halign"])) $params["halign"]="center";
    if ($params["halign"] == "left") {
        $x = 0;
    } else if ($params["halign"] == "right") {
        $x = $w-$max_w;
    } else {
        // center / middle
        $x = floor(($w-$max_w)/2);
    }
    
    $out = safe_imagecreatetruecolor($max_w, $max_h);
    imagecopy($out, $gd, 0, 0, $x, $y, $max_w, $max_h);

    imagedestroy($gd);
    return $out;
}

/*
 * Blends an image with a specific color. Optionally an alpha
 * component can be given, defaults to 50%.
 */
function &ImageChain_blend(&$gd, $params=false) {
    $color = $params["background"];
    $alpha = $params["alpha"];
    if(empty($color)) {
        $color = "#646464";
    }
    if(is_null($alpha)) {
        $alpha = 50;
    }
    
    $alpha = $alpha * (127 / 100);
    $carr = htmlcolor2rgb($color);
    $w = imagesx($gd); $h = imagesy($gd);

    imagealphablending($gd, true);
    if(function_exists("imagecolorallocatealpha")) {
        $colorres = imagecolorallocatealpha($gd, $carr[0], $carr[1], $carr[2], $alpha);
    } else {
        $colorres = imagecolorallocate($gd, $carr[0], $carr[1], $carr[2]);
    }
    
    imagefilledrectangle($gd, 0, 0, $w-1, $h-1, $colorres);
    
    return $gd;
}

/*
 * Wraps text inside an image; extends the image if necesary.
 * Does this up to $params[max_width].
 * Required params:
 * - text
 * - font
 */
function ImageChain_text(&$gd, $params=false) {

    // Optionals
    if (!$params["font_size"]) $params["font_size"]=12;
    if (!$params["font_options"]) $params["font_options"]=array();
    if (!$params["h_padding"]) $params["h_padding"]=0;
    if (!$params["v_padding"]) $params["v_padding"]=0;
    if (!$params["linespacing"]) $params["linespacing"]=0;
    if (!$params["tightness"]) $params["tightness"] = 0;
    if (!$params["space"]) $params["space"] = 0;
    
    if (!$params["background_color"]) $params["background_color"]="#FFFFFF";
    if ($params["bgcolor"]) $params["background_color"]=$params["bgcolor"];
    
    if (!$params["font_color"]) $params["font_color"]="#000000";
    if ($params["color"]) $params["font_color"] = $params["color"];
    
    if (!isset($params["max_width"])) $params["max_width"]=10000;
    if (!isset($params["use_real_width"])) $params["use_real_width"]=true;
    if (!isset($params["shadow"])) $params["shadow"]=0;
    if (!isset($params["shadow_color"])) $params["shadow_color"]="#666666";

    // $antialias = 16;
    $antialias = $params["font_size"]<=20?16:4;

    $word_list = explode(" ",$params["text"]);
    $new_text = "";
    $real_width = 0;
    $sentences = array();

    $postscript = preg_match("/\.pfb$/i", $params["font"]);

    if ($postscript) {
        $font = imagepsloadfont($params["font"]);
        if ($params["encoding"]) {
            imagepsencodefont($font, $params["encoding"]);
        }
    } else
        $font = $params["font"];

    $txtheight = $params["font_size"];
    $txtoffset = 0;

    if (!$postscript) {
        $dim = imageftbbox($params["font_size"],0,$font,"ABCDEFGHIJKLMNOPQRSTUWVXYZabcdefghijklmnopqrstuvwxyz",array());
        $txtheight = max($txtheight, abs($dim[7]-$dim[1]))-1;
        $txtoffset = max($txtoffset, abs($dim[7]))-1;
    } else {
        $dim = imagepsbbox("ABCDEFGHIJKLMNOPQRSTUWVXYZabcdefghijklmnopqrstuvwxyz", $font, $params["font_size"], $params["space"], $params["tightness"], 0);
        $txtheight = max($txtheight, abs($dim[3]-$dim[1]))-1;
        $txtoffset = max($txtoffset, abs($dim[3]))-1;
    }
    
    foreach ($word_list as $word) {

        if (!$postscript) {
            $dim = imageftbbox($params["font_size"],0,$font,trim($new_text." ".$word),array());
            //$txtoffset_y = abs($dim[7]);
            //$txtoffset_x = abs($dim[6]);
            //$txtheight = max($txtheight, abs($dim[7]-$dim[1]));
            //$txtoffset = max($txtoffset, abs($dim[7]));
        }
        else {
            $dim = imagepsbbox(trim($new_text." ".$word), $font, $params["font_size"], $params["space"], $params["tightness"], 0);
            $dim[4] = $dim[2];
        }
        //dbg(($dim[4]-$dim[0]) . " " . $word);
        if (($dim[4]-$dim[0]) > ($params["max_width"] - (2*$params["h_padding"])-2)) {
            $sentences[] = $new_text;
            $new_text = $word;
        }
        else {
            $new_text = trim($new_text." ".$word);
            if (($dim[4]-$dim[0]) > $real_width) $real_width = $dim[4]-$dim[0];
            $xoffset = -$dim[0]-1;
        }
    }

    if ($postscript) {
        $xoffset += 2;
        $real_width+= 1;
    }
    
    
    $sentences[] = $new_text;


    $height = ((count($sentences) ) * ($txtheight+$params["linespacing"]))+2*$params["v_padding"];
    //$height = 200;

    $im = imagecreate(($params["use_real_width"]?($real_width+(2*$params["h_padding"])):$params["max_width"]+(2*$params["h_padding"])), $height + (2 * $params["v_padding"]));
    $backcol = htmlcolor2rgb($params["background_color"]);
    $back = imagecolorallocate ($im, $backcol[0], $backcol[1], $backcol[2]);
    $fontcol = htmlcolor2rgb($params["font_color"]);
    $front = imagecolorallocate ($im, $fontcol[0], $fontcol[1], $fontcol[2]);
    $sent_count = 0;

    $v_cursor = $params["v_padding"] + $txtoffset_y;
    if ($params["shadow"] !== 0) {
        $shadowcolor = htmlcolor2rgb($params["shadow_color"]);
        $scolor = imagecolorallocate ($im, $shadow_color[0], $shadow_color[1], $shadow_color[2]);
    }
    foreach ($sentences as $sentence) {
        if ($params["shadow"] !== 0) {
            if (!$postscript)
                ImageFtText($im, $params["font_size"], 0, $xoffset + $params["h_padding"]  + $params["shadow"] , $v_cursor + $txtoffset +$params["shadow"], $scolor, $font, $sentence, $params["font_options"]);
            else
                ImagePsText($im, $sentence, $font, $params["font_size"], $scolor, $back, $xoffset + $params["h_padding"]  + $params["shadow"] , $v_cursor + $txtoffset +$params["shadow"], $params["space"], $params["tightness"], 0, $antialias);
        }

        if (!$postscript)
            $lastdim = ImageFtText($im, $params["font_size"], 0, $xoffset + $params["h_padding"]  ,  $v_cursor + $txtoffset, $front, $font, $sentence, $params["font_options"]);
        else
            $lastdim = ImagePsText($im, $sentence, $font, $params["font_size"], $front, $back, $xoffset + $params["h_padding"], $v_cursor + $txtoffset, $params["space"], $params["tightness"], 0, $antialias);

            
        $lastheight = $lastdim[1] - $lastdim[5];
        $v_cursor = $v_cursor  + $txtheight + $params["linespacing"];
        $sent_count++;
    }

    return $im;
}

/**
 * Given an image with an alpha channel, replaces the alpha channel by
 * the bgcolor.
 *
 * Params:
 * bgcolor: color
 */
function ImageChain_bgcolor(&$gd, $params) {
    $col = htmlcolor2rgb($params["bgcolor"]?$params["bgcolor"]:"#66FF00");

    $back = safe_imagecreatetruecolor(imagesx($gd), imagesy($gd));
    $bgcol = imagecolorallocate($back, $col[0], $col[1], $col[2]);
    imagefill($back, 0,0, $bgcol);
    
    imagecopy($back, $gd, 0,0, 0,0, imagesx($gd), imagesy($gd) );
    imagedestroy($gd);

    return $back;
}


/**
 * Add margins to image
 * 
 * params:
 * - all, top, left, bottom, right: pixel values
 */
function ImageChain_margin(&$gd, $params) {
    extract($params);
    $left = $left?$left:($leftright?$leftright:($all?$all:0));
    $right = $right?$right:($leftright?$leftright:($all?$all:0));

    $top = $top?$top:($topbottom?$topbottom:($all?$all:0));
    $bottom = $bottom?$bottom:($topbottom?$topbottom:($all?$all:0));

    $new = safe_imagecreatetruecolor(imagesx($gd)+$left+$right, imagesy($gd)+$top+$bottom);
    if ($bgcolor) {
        $col = htmlcolor2rgb($bgcolor);
        $bgcol = imagecolorallocate($new, $col[0], $col[1], $col[2]);
    } else {
        // make background color equal bottom-right pixel
        $rgb = imagecolorat($gd, imagesx($gd)-1, imagesy($gd)-1);
        if (imageistruecolor($gd)) 
            $bgcol = imagecolorallocate($new, ($rgb>>16)&0xFF, ($rgb>>8)&0xFF, $rgb&0xFF);
        else {
            $col = imagecolorsforindex($gd, $rgb);
            $bgcol = imagecolorallocate($new, $col["red"], $col["green"], $col["blue"]);
        }
    }
    imagefill($new, 0,0, $bgcol);
    imagecopy($new, $gd, $left, $top, 0, 0, imagesx($gd), imagesy($gd));
    imagedestroy($gd);
    return $new;    
}


/**
 * parameters: x, y, width, height
 * overlay: file
 */
function ImageChain_overlay(&$gd, $params=false) {

    $sizex = imagesx($gd);
    $sizey = imagesy($gd);
    
    $overlay = (is_resource($params["overlay"]))?$params["overlay"]:imagecreatefrompng($params["overlay"]);
    $sx = imagesx($overlay);
    $sy = imagesy($overlay);
    
    if (!$params["x"]) $params["x"] = 0;
    if (!$params["y"]) $params["y"] = 0;
    if (!$params["width"]) $params["width"] = min($sx, $sizex - $params["x"]); // default bottom right corner
    if (!$params["height"]) $params["height"] = min($sy, $sizey - $params["y"]);
    
    imagealphablending($gd, true);
    
    imagecopyresampled($gd, $overlay, $params["x"], $params["y"], 0, 0, $params["width"], $params["height"], $sx, $sy);
    
    return $gd;
}

/**
 * Convert an image to grayscale
 */
function ImageChain_grayscale(&$gd, $params) {
    $w = imagesx($gd);
    $h = imagesy($gd);
    for($i=0; $i<$h; $i++) {
        for($j=0; $j<$w; $j++) {
            $pos = imagecolorat($gd, $j, $i);
            if (!imageistruecolor($gd)) {
                $f = imagecolorsforindex($gd, $pos);
                $gst = $f["red"]*0.15 + $f["green"]*0.5 + $f["blue"]*0.35;
                $col = imagecolorexact($gd, $gst, $gst, $gst);
                if ($col = -1) $col = imagecolorallocate($gd, $gst, $gst, $gst);
            } else {
                $gst = (($pos>>16)&0xFF)*0.15 + (($pos>>8)&0xFF)*0.5 + ($pos&0xFF)*0.35;
                $col = imagecolorallocate($gd, $gst, $gst, $gst);
            }
            imagesetpixel($gd, $j, $i, $col);
        }
    }
    return $gd;
}


function htmlcolor2rgb($htmlcol) {
    $offset = 0;
    if ($htmlcol{0}=='#') $offset = 1;
    $r = hexdec(substr($htmlcol, $offset, 2));
    $g = hexdec(substr($htmlcol, $offset+2, 2));
    $b = hexdec(substr($htmlcol, $offset+4, 2));
    return array($r, $g, $b);
}


?>

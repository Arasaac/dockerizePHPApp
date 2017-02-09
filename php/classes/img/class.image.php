<?php
class Image
{
    /**
     * Gathers the GD version information
     *
     * Sometimes a check for the GD version like this:
     *
     *     (function_exists('imagecreatetruecolor')) ? 2 : 1;
     *
     * can fail.  This method retrieves the GD information based on what PHP
     * reports to be installed.  It can return the parsed version as an array,
     * or just the major version if you want to do a simple check.
     *
     * @return int|array
     * @param  bool $justMajor
     * @access public
     */
    function getGDVersion($justMajor = true)
    {
        static $version = array();
        
        if (empty($version)) {
            ob_start();
            phpinfo();
            $buffer = ob_get_contents();
            ob_end_clean();
            if (preg_match('|<B>GD Version</B></td><TD ALIGN="left">([^<]*)</td>|i', $buffer, $matches)) {
                $version = explode('.', $matches[1]);
            } else if (preg_match('|GD Version </td><td class="v">bundled \(([^ ]*)|i', $buffer, $matches)) {
                $version = explode('.', $matches[1]);
            } else if (preg_match('|GD Version </td><td class="v">([^ ]*)|i', $buffer, $matches)) {
                $version = explode('.', $matches[1]);
            }
        }
        return ($justMajor) ? $version[0] : $version;
    }

    /**
     * Return an RGB colour value array of the pixel at given location.
     *
     * The array is returned as: array(0 => r, 1 => g, 2 => b)
     *
     * @return array
     * @param  resource &$im a reference to the image
     * @param  int $x coordinate
     * @param  int $y coordinate
     * @access public
     */
    function getPixelRGB(&$im, $x, $y)
    {
        $rgb = imagecolorat($im, $x, $y);
        return array(($rgb >> 16) & 0xFF, ($rgb >> 8) & 0xFF, $rgb & 0xFF);
    }

    /**
     * A simple metric for colour distance in RGB space
     *
     * The arrays are expected to be of the format: 
     * array(0 => r, 1 => g, 2 => b)
     * 
     * @return float
     * @param  array $rgb1
     * @param  array $rgb2
     * @access public
     */
    function colourDistance($rgb1, $rgb2)
    {
        return sqrt(3 * ($rgb2[0] - $rgb1[0]) * ($rgb2[0] - $rgb1[0]) + 4 * ($rgb2[1] - $rgb1[1]) * 
                        ($rgb2[1] - $rgb1[1]) + 2 * ($rgb2[2] - $rgb1[2]) * ($rgb2[2] - $rgb1[2]));
    }

    /**
     * Convert a hex colour string into an rgb array.
     *
     * Handles colour string in the following formats:
     *
     *     o #44FF55
     *     o 4FF55
     *     o #4F5
     *     o 4F5
     * 
     * @return array
     * @param  string $hex
     * @access public
     */
    function hex2rgb($hex)
    {
        $hex = @preg_replace('/^#/', '', $hex);
        if (strlen($hex) == 3) {
            $v = explode(':', chunk_split($hex, 1, ':'));
            return array(16 * hexdec($v[0]) + hexdec($v[0]), 16 * hexdec($v[1]) + hexdec($v[1]), 16 * hexdec($v[2]) + hexdec($v[2]));
        } else {
            $v = explode(':', chunk_split($hex, 2, ':'));
            return array(hexdec($v[0]), hexdec($v[1]), hexdec($v[2]));
        }
    }

    /**
     * Convert an rgb array into a hex colour string.
     *
     * Handles colour string in the following formats:
     *
     *     o #44FF55
     *     o 4FF55
     *     o #4F5
     *     o 4F5
     * 
     * @return array
     * @param  string $hex
     * @access public
     */
    function rgb2hex($rgb, $adHash = true)
    {
        return sprintf("%s%02X%02X%02X", ($adHash ? '#' : ''), $rgb[0], $rgb[1], $rgb[2]);
    }

    /**
     * Convert an RGB array into HLS colour space.
     *
     * Expects array(r, g, b) where r, g, b in [0,255].  The HLS array is
     * returned as array(h, l, s) where h is in [0,360], l and s in [0,1].
     *
     * Function adapted from 'Computer Graphics: Principles and Practice',
     * by Foley, van Dam, Feiner and Hughes.  Chapter 13; Achromatic and 
     * Colored Light.
     *
     * @return array
     * @param  array $rgb
     * @access public
     */
    function rgb2hls($rgb)
    {
        for ($c=0; $c<3; $c++) {
            $rgb[$c] = $rgb[$c] / 255;
        }
        
        $hls = array(0, 0, 0);
        $max = max($rgb);
        $min = min($rgb);

        $hls[1] = ($max + $min) / 2;
        if ($max == $min) {
            $hls[0] = null;
            $hls[2] = 0;
        } else {
            $delta = $max - $min;
            $hls[2] = ($hls[1] <= 0.5) ? ($delta / ($max + $min)) : ($delta / (2 - ($max + $min)));

            if ($rgb[0] == $max) {
                $hls[0] = ($rgb[1] - $rgb[2]) / $delta;
            } else if ($rgb[1] == $max) {
                $hls[0] = 2 + ($rgb[2] - $rgb[0]) / $delta;
            } else {
                $hls[0] = 4 + ($rgb[0] - $rgb[1]) / $delta;
            }

            $hls[0] *= 60;
            if ($hls[0] < 0) {
                $hls[0] += 360;
            }
            if ($hls[0] > 360) {
                $hls[0] -= 360;
            }
        }
        ksort($hls);
        return $hls;
    }

    /**
     * Convert HLS colour space array to RGB colour space.
     *
     * Expects HLS array  as array(h, l, s) where h in [0,360], l and s each
     * in [0,1].  Returns array(r, g, b) where r, g, and b each in [0, 255]
     *
     * Function adapted from 'Computer Graphics: Principles and Practice',
     * by Foley, van Dam, Feiner and Hughes.  Chapter 13; Achromatic and 
     * Colored Light.
     *
     * @return array
     * @param  array $hls
     * @access public
     */
    function hls2rgb($hls)
    {
        $rgb = array(0, 0, 0);
        
        $m2 = ($hls[1] <= 0.5) ? ($hls[1] * (1 + $hls[2])) : ($hls[1] + $hls[2] * (1 - $hls[1]));
        $m1 = 2 * $hls[1] - $m2;

        if (!$hls[2]) {
            if ($hls[0] === null) {
                $rgb[0] = $rgb[1] = $rgb[2] = $hls[1];
            } else {
                return false;
            }
        } else {
            $rgb[0] = Image::_hVal($m1, $m2, $hls[0] + 120);
            $rgb[1] = Image::_hVal($m1, $m2, $hls[0]);
            $rgb[2] = Image::_hVal($m1, $m2, $hls[0] - 120);
        }
        
        for ($c=0; $c<3; $c++) {
            $rgb[$c] = round($rgb[$c] * 255);
        }
        return $rgb;
    }

    /**
     * Hue value checker for HSL colour space routine.
     *
     * @return float
     * @param  float $n1
     * @param  float $n2
     * @param  float $h
     * @access private
     * @see    Image::hls2rgb()
     */
    function _hVal($n1, $n2, $h)
    {
        if ($h > 360) {
            $h -= 360;
        } else if ($h < 0) {
            $h += 360;
        }

        if ($h < 60) {
            return $n1 + ($n2 - $n1) * $h / 60;
        } else if ($h < 180) {
            return $n2;
        } else if ($h < 240) {
            return $n1 + ($n2 - $n1) * (240 - $h) / 60;
        } else {
            return $n1;
        }
    }

    /**
     * Convert an RGB array into HSV (aka HSB) colour space.
     *
     * Expects array(r, g, b) where r, g, b in [0,255].  The HSV array is
     * returned as array(h, s, v) where h is in [0,360], s and v in [0,1].
     *
     * Function adapted from 'Computer Graphics: Principles and Practice',
     * by Foley, van Dam, Feiner and Hughes.  Chapter 13; Achromatic and 
     * Colored Light.
     *
     * @return array
     * @param  array $rgb
     * @access public
     */
    function rgb2hsv($rgb)
    {
        for ($c=0; $c<3; $c++) {
            $rgb[$c] = $rgb[$c] / 255;
        }
        
        $hsv = array(0, 0, 0);
        $max = max($rgb);
        $min = min($rgb);

        $hsv[2] = $max;
        $hsv[1] = ($max) ? (($max - $min) / $max) : 0;

        if (!$hsv[1]) {
            $hsv[0] = null;
        } else {
            $delta = $max - $min;
            if ($rgb[0] == $max) {
                $hsv[0] = ($rgb[1] - $rgb[2]) / $delta;
            } else if ($rgb[1] == $max) {
                $hsv[0] = 2 + ($rgb[2] - $rgb[0]) / $delta;
            } else {
                $hsv[0] = 4 + ($rgb[0] - $rgb[1]) / $delta;
            }

            $hsv[0] *= 60;
            if ($hsv[0] < 0) {
                $hsv[0] += 360;
            }
        }
        ksort($hsv);
        return $hsv;
    }
    
    /**
     * Convert HSV colour space array to RGB colour space.
     *
     * Expects HLS array  as array(h, s, v) where h in [0,360], s and v each
     * in [0,1].  Returns array(r, g, b) where r, g, and b each in [0, 255]
     *
     * Function adapted from 'Computer Graphics: Principles and Practice',
     * by Foley, van Dam, Feiner and Hughes.  Chapter 13; Achromatic and 
     * Colored Light.
     *
     * @return array
     * @param  array $hsv
     * @access public
     */
    function hsv2rgb($hsv)
    {
        if (!$hsv[1]) {
            if ($hsv[0] === null) {
                $rgb[0] = $rgb[1] = $rgb[2] = $hsv[2];
            } else {
                return false;
            }
        } else {
            if ($hsv[0] == 360) {
                $hsv[0] = 0;
            }
            $hsv[0] /= 60;
            $i = floor($hsv[0]);
            $f = $hsv[0] - $i;
            $p = $hsv[2] * (1 - $hsv[1]);
            $q = $hsv[2] * (1 - ($hsv[1] * $f));
            $t = $hsv[2] * (1 - ($hsv[1] * (1 - $f)));
            switch ($i) {
                case 0:
                    $rgb[0] = $hsv[2];
                    $rgb[1] = $t;
                    $rgb[2] = $p;
                    break;
                case 1:
                    $rgb[0] = $q;
                    $rgb[1] = $hsv[2];
                    $rgb[2] = $p;
                    break;
                case 2:
                    $rgb[0] = $p;
                    $rgb[1] = $hsv[2];
                    $rgb[2] = $t;
                    break;
                case 3:
                    $rgb[0] = $p;
                    $rgb[1] = $q;
                    $rgb[2] = $hsv[2];
                    break;
                case 4:
                    $rgb[0] = $t;
                    $rgb[1] = $p;
                    $rgb[2] = $hsv[2];
                    break;
                case 5:
                    $rgb[0] = $hsv[2];
                    $rgb[1] = $p;
                    $rgb[2] = $q;
                    break;
            }
        }
        for ($c=0; $c<3; $c++) {
            $rgb[$c] = round($rgb[$c] * 255);
        }
        return $rgb;
    }

    /**
     * Converts an image resource into a grey-scale version
     *
     * @return void
     * @param  resource &$im a reference to the image
     * @access public
     */
    function greyscale(&$im)
    {
        $sx = imagesx($im);
        $sy = imagesy($im);
        for ($x = 0; $x < $sx; $x++) {
            for ($y = 0; $y < $sy; $y++) {
                $rgb = Image::getPixelRGB($im, $x, $y);
                $colour = ($rgb[0] + $rgb[1] + $rgb[2]) / 3;
                imagesetpixel($im, $x, $y, imagecolorallocate($im, $colour, $colour, $colour));
            }
        } 
    }

    /**
     * Converts an image resource into a threshold black/white version.
     *
     * The threshold level is a value from 0 to 255 (black to white), and any
     * pixel with a colour below that value will be turned black, and any
     * pixel above that value will be turned white.
     *
     * @return void
     * @param  resource &$im a reference to the image
     * @param  int $level
     * @access public
     */
    function threshold(&$im, $level = 128)
    {
        $sx = imagesx($im);
        $sy = imagesy($im);
        $black = imagecolorallocate($im, 0, 0, 0);
        $white = imagecolorallocate($im, 255, 255, 255);
        for ($x = 0; $x < $sx; $x++) {
            for ($y = 0; $y < $sy; $y++) {
                $rgb = Image::getPixelRGB($im, $x, $y);
                $intensity = ($rgb[0] + $rgb[1] + $rgb[2]) / 3;
                imagesetpixel($im, $x, $y, ($intensity < $level ? $black : $white));
            }
        }
    }

    /**
     * Colourises an image based on given colour.
     *
     * The colour to use as the shade/tint can be passed and as hex colour
     * string or as an RGB array.
     *
     * @return void
     * @param  resource &$im a reference to the image
     * @param  string|array $setColour
     * @access public
     */
    function colourise(&$im, $setColour)
    {
        if (is_string($setColour)) {
            $hls = Image::rgb2hls(Image::hex2rgb($setColour));
        } else {
            $hls = Image::rgb2hls($setColour);
        }
        
        $sx = imagesx($im);
        $sy = imagesy($im);
        for ($x = 0; $x < $sx; $x++) {
            for ($y = 0; $y < $sy; $y++) {
                $rgb = Image::getPixelRGB($im, $x, $y);
                $pxhls = Image::rgb2hls($rgb);
                $pxhls[0] = $hls[0];
                $pxhls[2] = $hls[2];
                $rgb = Image::hls2rgb($pxhls);
                imagesetpixel($im, $x, $y, imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]));
            }
        } 
    }

    /**
     * @see Image::colourise()
     */
    function colorize(&$im, $setColour)
    {
        Image::colourise($im, $setColour);
    }

    /**
     * Sepia tone an image.
     *
     * @return void
     * @param  resource &$im a reference to the image
     * @access public
     */
    function sepia(&$im)
    {
        $sx = imagesx($im);
        $sy = imagesy($im);
        for ($x = 0; $x < $sx; $x++) {
            for ($y = 0; $y < $sy; $y++) {
                $rgb = Image::getPixelRGB($im, $x, $y);
                $pxhls = Image::rgb2hls($rgb);
                $pxhls[0] = 0.30;
                $pxhls[2] = 0.25;
                $rgb = Image::hls2rgb($pxhls);
                imagesetpixel($im, $x, $y, imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]));
            }
        } 
    }

    /**
     * Get a range of colours over a certain number of steps,
     *
     * Given two different colours, this method will give you a range of
     * colours over a certain number of steps from the first colour to the
     * second.  If the two input colours are in hex format, then the array
     * returned will consist of hex values.  If the two colours are passed
     * as arrays, then the returned array will consist of arrays.  If there
     * is a mix of hex and rgb arrays then the returned array will also be
     * returned in that format.
     *
     * If the $trueSteps parameter is true, then the range will go from
     * colour one to colour two in $steps, returning $steps + 1 colours.
     * If set to false, it will just return $steps colours (as most people
     * might expect).
     *
     * @return array
     * @param  string|array $startColour
     * @param  string|array $endColour
     * @param  int          $steps
     * @param  boolean      $trueSteps
     * @access public
     */
    function colourRange($startColour, $endColour, $steps, $trueSteps = false)
    {
        $range = array();
        $saveType = 0;
        if (is_array($startColour) && is_array($endColour)) {
            $saveType = 1;
        } else if (is_string($startColour) && is_array($endColour)) {
            $saveType = 2;
        } else if (is_array($startColour) && is_string($endColour)) {
            $saveType = 3;
        }
        $s = (is_string($startColour)) ? Image::hex2rgb($startColour) : $startColour;
        $e = (is_string($endColour))   ? Image::hex2rgb($endColour)   : $endColour;
        if (!$trueSteps) {
            --$steps;
        }

        for ($i = 0; $i <= $steps; $i++) {
            $rgb = array();
            $rgb[0] = round($s[0] + ($i * ($e[0] - $s[0]) / $steps));
            $rgb[1] = round($s[1] + ($i * ($e[1] - $s[1]) / $steps));
            $rgb[2] = round($s[2] + ($i * ($e[2] - $s[2]) / $steps));
            switch($saveType) {
            case 3:
                $range[] = array($rgb, Image::rgb2hex($rgb));
                break;
            case 2:
                $range[] = array(Image::rgb2hex($rgb), $rgb);
                break;
            case 1:
                $range[] = $rgb;
                break;
            default:
                $range[] = Image::rgb2hex($rgb);
                break;
            }
        }
        return $range;
    }

    /**
     * @see Image::colourRange()
     */
    function colorRange($startColour, $endColour, $steps, $trueSteps = false)
    {
        return Image::colourRange($startColour, $endColour, $steps, $trueSteps);
    }

}

?>
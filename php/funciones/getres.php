<?
/******************************************
JavaScript to PHP Screen Resolution vBETA
by Lenn García
Date: 08-29-2004
******************************************/
?>
<script type="text/javascript">
function SetCookie() {
var width = screen.width;
var height = screen.height;
var res = width + 'x' + height;
document.cookie = 'PHPRes='+res;
location = '<?=$GLOBALS['siteurl'];?>';
}
 
function CheckResolution(width, height) {
if(width != screen.width && height != screen.height) {
SetCookie();
}
}
</script>
<?
if(isset($_COOKIE['PHPRes']) || !empty($_COOKIE['PHPRes'])) {
$res = explode("x",$_COOKIE['PHPRes']);
$width = $res[0];
$height = $res[1];
?>
<script type="text/javascript">
CheckResolution(<?=$width;?>,<?=$height;?>);
</script>
<?
} else {
?>
<script type="text/javascript">
SetCookie();
</script>
<?
}
    
$_SESSION['width'] = $width;
$_SESSION['height'] = $height;
?>
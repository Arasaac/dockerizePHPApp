<?php header("Content-type:text/xml"); print("<?xml version=\"1.0\"?>");
    sleep(2);
	$num = $_GET['num'];
	$array = array("google","yahoo"); 
?>
<content tab="b<?=$num?>">
    <![CDATA[
	<?=(isset($_GET['step'])?"<hr/>Reloaded<hr/>":"")?>
    <h3>This is a <?=$array[$num]?> link</h3>
<center>
<table border=0 cellpadding=0 cellspacing=0 width=100% height="130px">
  <tr valign=center>
	<td width=100% align=center>

     <a href="http://www.<?=$array[$num]?>.com/" border=0 onFocus="blur();">
       <img src="../images/<?=$array[$num]?>.gif" alt="<?=$array[$num]?>" border="0">
      </a>
    </td>
  
  </tr>
  <tr>
</table>

</center>
    ]]>
</content>


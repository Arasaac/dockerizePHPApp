<?php 
if (get_cfg_var('browscap'))
 $browser=get_browser(); //If available, use PHP native function
else
{
 require_once('classes/browscap/php-local-browscap.php');
 $browser=get_browser_local($user_agent=null,$return_array=false,$db='classes/browscap/browscap.ini',$cache=false);
}

?>
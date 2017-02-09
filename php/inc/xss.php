<?php
/* xss mitigation functions

   @author: Chema Cortés
   @created: 2015-07-21

*/
function xssafe($data,$encoding='UTF-8')
{
   return preg_replace("/[^\pL\pN\p{Zs}'-]/u", '', $data); // Removes special chars.
}
function xecho($data)
{
   echo xssafe($data);
}
?>

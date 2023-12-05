<!-- routes -->

<?php

include 'connect.php';
$tpl='includes/templete/';
$lang='includes/language/';
$function='includes/function/';


//include the important file

    include $lang . 'en.php';
    include $function . 'function.php';
    include $tpl . 'header.php';
  

    //include navbar on all page expect one with $nonavbar variable

    if(!isset($noNavbar)){ include $tpl . 'navbar.php';}


?>
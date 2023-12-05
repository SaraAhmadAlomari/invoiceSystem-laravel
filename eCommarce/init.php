<!-- routes -->

<?php

include 'admin/connect.php';
$tpl='includes/templete/';
$lang='includes/language/';
$function='includes/function/';
$sessionUser='';
if(isset($_SESSION['name'])){
    $sessionUser=$_SESSION['name'];
}


//include the important file

    include $lang . 'en.php';
    include $function . 'function.php';
    include $tpl . 'header.php';
  

?>
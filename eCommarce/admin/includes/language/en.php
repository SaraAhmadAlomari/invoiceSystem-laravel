<?php

function lang($phrase){
    static $lang=array(

        //navbar links
        'HOME_ADMIN'=>'Home',
        'CATEGORIES'=>'Categories',
        'ITEMS'=>'Items',
        'MEMBERS'=>'Members',
        'STATISTICS'=>'Statistecs',
        'LOGS'=>'Logs',
        'COMMENTS'=>'Comments',
        
    );
    return $lang[$phrase];
}

?>
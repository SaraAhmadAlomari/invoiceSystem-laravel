
<?php
    session_start(); //start sesstion
    session_unset();//unset the data
    session_destroy(); //destroy the session
    header('Location:index.php');
    exit();


?>

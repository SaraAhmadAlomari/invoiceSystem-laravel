<?php
//get any table from data base
function GetAllFrom($filed,$tablename,$where=NULL,$and=NULL,$orderfiled,$ordering="DESC")
{
    global $con;
    $getall=$con->prepare("SELECT $filed FROM $tablename $where $and ORDER BY $orderfiled $ordering");
    $getall->execute();
    $all=$getall->fetchAll();
    return $all;
}

//  title function that echo title page in case
//  the page has the variable $pagetitle and echo default 
//  title for other page

    function getTitle() {
        global $pagetitle;
        if(isset($pagetitle)){
            echo $pagetitle;
        }
        else{
            echo 'Default';
        }
    }
/* create home redirect function */
function RedirectHome($theMsg,$url=null,$seconds=3)
{
    if($url==null)
    {
       $url='index.php';
       $link='Home page';
    }
    else
    {
        if(isset($_SERVER['HTTP_REFERER']) && isset($_SERVER['HTTP_REFERER']) !=='')
        {
            $url=$_SERVER['HTTP_REFERER'];
            $link='Previous page';
        }
        else
        {
            $url='index.php';
            $link='Home page';
        }
    }
    echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds seconds</div>";
    echo $theMsg;

    header("refresh:$seconds;url=$url");

}

//cheack item function
function cheackItem($select,$table,$value){
    global $con;
   $statment=$con->prepare("SELECT $select FROM $table WHERE $select =?");
    $statment->execute(array($value));
    $count=$statment->rowCount();
    return $count;
}

//count number of items (function to count number of items rows)
function countItems($item,$table){
    global $con;
    $stmt=$con->prepare("SELECT COUNT($item) FROM $table");
    $stmt->execute();
    return $stmt->fetchColumn();
}

//get latest recourd functioin
function getLatest($select,$table,$order,$limit=5)
{
    global $con;
    $stmt=$con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $stmt->execute();
    $rows=$stmt->fetchAll();
    return $rows;
}

?>
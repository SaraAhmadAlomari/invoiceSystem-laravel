<?php 
$con=mysqli_connect("localhost", "root", "", "test");

function pagination($con, $table, $pno, $n){
echo "1";
$query = $con->query("SELECT COUNT(*) as `rows` FROM ".$table);
echo mysqli_error($con);
$row = mysqli_fetch_assoc($query);
//$totalRecords = 100000;
echo $pageno = $pno;
echo $numberOfRecordsPerPage = $n;



$last = ceil($row["rows"]/$numberOfRecordsPerPage);
echo "Total Page ".$last."<br/>";
$pagination="";

if($last !=1)
{
if($pageno >1){
$previous = "";
$previous = $pageno - 1;
$pagination .= "<a href='pagination.php?pageno=".$previous."' style='color:#000000;'>Previous</a>";
				}
for($i=$pageno - 5; $i< $pageno; $i++)
	{
	if($i > 0){
	
$pagination .= "<a href='pagination.php?pageno=".$i."'> ".$i." </a>";
}

	}
$pagination .= "<a href='pagination.php?pageno=".$pageno."' style='color:#333;'> $pageno</a>";
for($i=$pageno + 1; $i <= $last; $i++)
	{
$pagination .= "<a href='pagination.php?pageno=".$i."'> ".$i." </a>";
if($i > $pageno + 4)
{
break;
}
	}
if($last > $pageno){
$next = $pageno + 1;
$pagination .= "<a href='pagination.php?pageno=".$next."' syle='color:333;'> Next </a>";
	}
}

//LIMIT 0, 10
//LIMIT 20,10
$limit ="LIMIT ".($pageno - 1) * $numberOfRecordsPerPage.",".$numberOfRecordsPerPage; 


return ["pagination"=>$pagination,"limit"=>$limit];

}
if(isset($_GET["pageno"])){
$pageno = $_GET["pageno"];
//echo "<pre>";
$table ="paragraph";

$array = pagination($con,$table,$pageno,10);
$sql = "SELECT * FROM ".$table." ".$array["limit"];
$query = $con->query($sql);
while ($row = mysqli_fetch_assoc($query)){
echo "<div style='margin:0 auto;font-size:20px;'><b>".$row["pid"]."</b>".$row["p_descriptions"]."</div>";
}

echo "<div='font-size:22px;'> ".$array["pagination"];"</div>";
}else{
	$pageno = 1;
//echo "<pre>";
$table ="paragraph";

$array = pagination($con,$table,$pageno,10);
$sql = "SELECT * FROM ".$table."  ".$array["limit"];
echo $sql;
$query = $con->query($sql);
while ($row = mysqli_fetch_assoc($query)){
echo "<div style='margin:0 auto;font-size:20px;'><b>".$row["pid"]."</b>".$row["p_descriptions"]."</div>";
}

echo "<div='font-size:22px;'> ".$array["pagination"];"</div>";
}

?>
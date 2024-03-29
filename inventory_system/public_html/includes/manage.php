<?php
    class Manage
    {
        private $con;

        function __construct()
        {
            include_once ("../database/db.php");
            $db=new Database();
            $this->con=$db->connect();
        }

        public function manageRecordWithPagenation($table,$pageNum)
        {
            $a=$this->pagination($this->con,$table,$pageNum,6);
            if($table=="categories"){
               $sql= "SELECT p.category_name AS category, c.category_name AS Parent, p.status ,p.cid
                FROM categories p LEFT JOIN categories c ON p.parent_cat=c.cid ".$a["limit"];
            }
            else if($table=="brand") {
               $sql= "SELECT * FROM ".$table." ".$a["limit"];
            }
            else{
                $sql="SELECT p.pid,p.prodect_name,c.category_name,b.brand_name,
                p.prodect_price,p.prodect_stock,p.added_date,p.p_status
                 FROM prodects p,brand b, categories c
                 WHERE p.bid=b.bid AND p.cid=c.cid ".$a["limit"];

            }

            $result=$this->con->query($sql) or die ($this->con->error);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $rows[]=$row;
                }
            }
            return ["rows"=>$rows,"pagination"=>$a["pagination"]];
        }
        private function pagination($con, $table, $pno, $n){
       
        $query = $con->query("SELECT COUNT(*) as `rows` FROM ".$table);
        echo mysqli_error($con);
        $row = mysqli_fetch_assoc($query);
        //$totalRecords = 100000;
         $pageno = $pno;
         $numberOfRecordsPerPage = $n;
        $last = ceil($row["rows"]/$numberOfRecordsPerPage);
        $pagination="<ul class='pagination'> ";

        if($last !=1)
        {
        if($pageno >1){
        $previous = "";
        $previous = $pageno - 1;
        $pagination .= "<li class='page-item'> <a class='page-link'pn='".$previous."' href='#' style='color:#007bff;'>Previous</a></li>";
                        }
        for($i=$pageno - 5; $i< $pageno; $i++)
            {
            if($i > 0){
            
        $pagination .= "<li class='page-item'> <a class='page-link'pn='".$i."' href='#'> ".$i." </a></li>";
        }

            }
        $pagination .= "<li class='page-item'><a class='page-link'pn='".$pageno."' href='#' style='color:#333;'> $pageno</a></li>";
        for($i=$pageno + 1; $i <= $last; $i++)
            {
        $pagination .= "<li class='page-item'><a class='page-link' pn='".$i."' href='#'> ".$i." </a></li>";
        if($i > $pageno + 4)
        {
        break;
        }
            }
        if($last > $pageno){
        $next = $pageno + 1;
        $pagination .= "<li class='page-item'><a  class='page-link' pn='".$next."' href='#' syle='color:#333;'> Next </a></li></ul>";
            }
        }

        //LIMIT 0, 10
        //LIMIT 20,10
        $limit ="LIMIT ".($pageno - 1) * $numberOfRecordsPerPage.",".$numberOfRecordsPerPage; 


        return ["pagination"=>$pagination,"limit"=>$limit];

    }

    //Delete Record
public function DeleteRecord($table,$primaryk,$id){
    if($table=="categories")
    {
        $pre_stmt=$this->con->prepare("SELECT ".$id." FROM categories WHERE parent_cat=?");
        $pre_stmt->bind_param("i",$id);
        //print_r($pre_stmt);
        $pre_stmt->execute();
        $result=$pre_stmt->get_result() or die($this->con->error);
        if($result->num_rows>0){
            return "DEPENDENT_CATEGORY";
        }
        else
        {
           $pre_stmt=$this->con->prepare("DELETE FROM ".$table." WHERE ".$primaryk."=?");
           $pre_stmt->bind_param("i",$id);
           $result=$pre_stmt->execute() or die($this->con->error);
           if($result){
           return "CATEGORY_DELETED";
           }
        }
    }
    else
    {
        $pre_stmt=$this->con->prepare("DELETE FROM ".$table." WHERE ".$primaryk."=? ");
        $pre_stmt->bind_param("i",$id);
        $result=$pre_stmt->execute() or die($this->con->error);
        if($result){
            return "DELETED";
        }
    }
}

public function getSignleRecord($table,$primaryk,$id){
    $pre_stmt=$this->con->prepare("SELECT *FROM ".$table." WHERE ".$primaryk."=?");
    $pre_stmt->bind_param("i",$id);
    $pre_stmt->execute() or die ($this->con->error);
    $result=$pre_stmt->get_result();
    if($result->num_rows==1){
        $row=$result->fetch_assoc();
    }
return $row;
}

///updateeee
public function update_record($table,$where,$fields){

    $sql="";
    $condition="";
    foreach($where as $key=>$value){
        $condition.=$key. "='" .$value. "' AND ";
      

    }
    $condition=substr($condition,0,-5);
  

    foreach($fields as $key =>$value){

        $sql .=$key . "='".$value."', ";

    }
    $sql=substr($sql,0,-2);
    $sql="UPDATE ".$table." SET ".$sql." WHERE ".$condition;
    // echo $sql;

    if(mysqli_query($this->con,$sql)){
        return "UPDATED";
    }
}

public function storeCustomerOrderInvoice($orderdate,$customer_name,$ar_tqty,$ar_qty,
$ar_price,$ar_pro_name,$sub_total,$gst,$discount,$net_total,$paid,$due,$payment_type){
   
    
 $pre_stmt=$this->con->prepare("INSERT INTO 
 `invoice`( `customer_name`, `order_date`, `sub_total`, `gst`, `discount`, `net_total`, `paid`, `due`, `payment_type`) 
 VALUES (?,?,?,?,?,?,?,?,?)");
    $pre_stmt->bind_param("ssdddddds",$customer_name,$orderdate,$sub_total,$gst,$discount,$net_total,$paid,$due,$payment_type);
    $pre_stmt->execute() or die ($this->con->error);
    //session id:
    $invoice_no=$pre_stmt->insert_id;
    if($invoice_no!=null){
        for($i=0;$i <count($ar_price);$i++){
            $rem_qty=$ar_tqty[$i]-$ar_qty[$i];
            if($rem_qty<0){
                return "ORDER_FAIL_TO_COMPLETE";
            }
            else{
                $this->con->query("UPDATE prodects SET prodect_stock='$rem_qty' WHERE 	prodect_name='".$ar_pro_name[$i]."'");
            }

            $insert_prodect=$this->con->prepare("INSERT INTO `invoice_details`(`invoice_no`, `prodect_name`, `price`, `qty`) VALUES (?,?,?,?)");
            $insert_prodect->bind_param("isdd",$invoice_no,$ar_pro_name[$i],$ar_price[$i],$ar_qty[$i]);
            $insert_prodect->execute() or die ($this->con->error);

        }
        return "ORDER_COMPLETED";
    }
}

}


// $obj=new Manage();
// echo $obj->update_record("categories",["cid"=>1],["parent_cat"=>0,"category_name"=>"gamingupdate1111111","status"=>1]);
// print_r($obj->getSignleRecord("brand","bid",1));
// echo $obj->DeleteRecord("prodects","pid",1);
// echo "<pre>";
// print_r($obj->manageRecordWithPagenation("brand",1));
// echo "<pre>";

?>
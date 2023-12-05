<?php
class DBoperation{
    private $con;
    function __construct(){
        include_once ("../database/db.php");
        $db=new Database();
        $this->con=$db->connect();
    }

    public function AddCategory($parent,$cat){
        $pre_stmt=$this->con->prepare("INSERT INTO `categories`(`parent_cat`, `category_name`, `status`) 
        VALUES (?,?,?)");
        $status=1;
        $pre_stmt->bind_param("isi",$parent,$cat,$status);
        $result=$pre_stmt->execute() or die ($this->con->error);
        if($result)
        {
            return "CATEGORY_ADDED";
        }
        else{
            return 0;
        }
    }

    public function AddBrand($brand_name){
        $pre_stmt=$this->con->prepare("INSERT INTO `brand`(`brand_name`, `status`) VALUES (?,?)");
        $status=1;
        $pre_stmt->bind_param("si",$brand_name,$status);
        $result=$pre_stmt->execute() or die ($this->con->error);
        if($result)
        {
            return "Brand_ADDED";
        }
        else{
            return 0;
        }
    }

    public function getAllRecord($table)
    {
        $pre_stmt=$this->con->prepare("SELECT * FROM `$table` ");
        $pre_stmt->execute() or die ($this->con->error);
        $result=$pre_stmt->get_result();
        $rows=array();
        if($result->num_rows > 0){
            while($row=$result->fetch_assoc()){
                $rows[]=$row;
            }
            return $rows;
        }
        return "NO_DATA";
    }

    //add prodect
    public function AddProdect($cid,$bid,$prodect_name,$price,$stock,$date){
        $pre_stmt=$this->con->prepare
        ("INSERT INTO `prodects`( `cid`, `bid`, `prodect_name`, `prodect_price`, `prodect_stock`, `added_date`, `p_status`) 
        VALUES (?,?,?,?,?,?,?)");
        $status=1;
        $pre_stmt->bind_param("iisdisi",$cid,$bid,$prodect_name,$price,$stock,$date,$status);
        $result=$pre_stmt->execute() or die ($this->con->error);
        if($result)
        {
            return "PRODECT_ADDED";
        }
        else{
            return 0;
        }
    }

}



// $opr=new DBoperation();
// echo  "<pre>";
// print_r($opr->getAllRecord("categories"));

?>
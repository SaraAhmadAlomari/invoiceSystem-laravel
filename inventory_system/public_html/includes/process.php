<?php

include_once("../database/constants.php");
include_once("user.php");
include_once("DBoperation.php");
include_once("manage.php");
//for registration processing
if(isset($_POST["username"]) && isset($_POST["email"])){
$user=new User();
$result=$user-> createuserAccount($_POST["username"],$_POST["email"],$_POST["password1"],$_POST["usertype"]);
echo $result;
exit();
}

//for login processing
if(isset($_POST["log_email"]) && isset($_POST["log_pass"])){
    $user=new User();
    $result= $user->userLogin($_POST["log_email"],$_POST["log_pass"]);
    echo $result;
    exit();
}

//to get category 
if(isset($_POST["getCategory"])){
$obj=new DBoperation();
$rows=$obj->getAllRecord("categories");
foreach($rows as $row){
    echo "<option value='".$row["cid"]."'>" .$row["category_name"]. "</option>" ;

}
exit();
}

//to get brand
if(isset($_POST["getBrand"])){
$obj=new DBoperation();
$rows=$obj->getAllRecord("brand");
foreach($rows as $row){
    echo "<option value='".$row["bid"]."'>" .$row["brand_name"]. "</option>" ;

}
exit();
}

//add category
if(isset($_POST["cat_name"]) && isset($_POST["parent_cat"])){
$obj=new DBoperation();
$result=$obj->AddCategory($_POST["parent_cat"],$_POST["cat_name"]);
echo $result;
exit();
}

//Add  brand
if(isset($_POST["brand_name"])){
    $obj=new DBoperation();
    $result=$obj->AddBrand($_POST["brand_name"]);
    echo $result;
    exit();
}

//Add  prodect
if(isset($_POST["added_date"]) && isset($_POST["p_name"])){
    $obj=new DBoperation();
    $result=$obj->AddProdect($_POST["select_cat"],
                            $_POST["select_brand"],
                            $_POST["p_name"],
                             $_POST["p_price"],
                             $_POST["qnty"],
                             $_POST["added_date"]);
    echo $result;
    exit();
}

//manage Category
if(isset($_POST["manageCategory"])){
    $m=new Manage();
    $result=$m->manageRecordWithPagenation("categories",$_POST["pageno"]);
    $rows=$result["rows"];
    $pagination=$result["pagination"];
    if(count($rows)>0){
        $n=($_POST["pageno"]-1)*8;
        foreach($rows as $row){
            ?>
            <tr>
                <td><?php echo  ++$n; ?></td>
                <td><?php echo  $row["category"]; ?></td>
                <td><?php echo  $row["Parent"]; ?></td>
                <td><a href="#" class="btn-success btn-sm">Active</a></td>
                <td><a href="#" delete_id=" <?php echo  $row["cid"]; ?> " class="btn-danger btn-sm del_cat">Delete</a>
                    <a href="#" edit_id="<?php echo $row['cid'];?>"  class="btn-info btn-sm edit_cat"  data-toggle="modal" data-target="#update_category">Edit</a>
                </td>
            </tr>
            <?php
        }
        ?>
            <tr><td colspan='5'> <?php echo $pagination; ?> </td></tr>
        <?php
        exit();
    }
}

//manage Brand
if(isset($_POST["manageBrand"])){
    $m=new Manage();
    $result=$m->manageRecordWithPagenation("brand",$_POST["pageno"]);
    $rows=$result["rows"];
    $pagination=$result["pagination"];
    if(count($rows)>0){
        $n=($_POST["pageno"]-1)*8;
        foreach($rows as $row){
            ?>
            <tr>
                <td><?php echo  ++$n; ?></td>
                <td><?php echo  $row["brand_name"]; ?></td>
                <td><a href="#" class="btn-success btn-sm">Active</a></td>
                <td><a href="#" delete_id=" <?php echo  $row["bid"]; ?> " class="btn-danger btn-sm del_brand">Delete</a>
                    <a href="#" edit_id="<?php echo $row['bid'];?>"  class="btn-info btn-sm edit_brand"  data-toggle="modal" data-target="#update_brand">Edit</a>
                </td>
            </tr>
            <?php
        }
        ?>
            <tr><td colspan='5'> <?php echo $pagination; ?> </td></tr>
        <?php
        exit();
    }
}

//manage prodect
if(isset($_POST["manageProdect"])){
    $m=new Manage();
    $result=$m->manageRecordWithPagenation("prodects",$_POST["pageno"]);
    $rows=$result["rows"];
    $pagination=$result["pagination"];
    if(count($rows)>0){
        $n=($_POST["pageno"]-1)*8;
        foreach($rows as $row){
            ?>
            <tr>
                <td><?php echo  ++$n; ?></td>
                <td><?php echo  $row["prodect_name"]; ?></td>
                <td><?php echo  $row["category_name"]; ?></td>
                <td><?php echo  $row["brand_name"]; ?></td>
                <td><?php echo  $row["prodect_price"]; ?></td>
                <td><?php echo  $row["prodect_stock"]; ?></td>
                <td><?php echo  $row["added_date"]; ?></td>
                <td><a href="#" class="btn-success btn-sm">Active</a></td>
                <td><a href="#" delete_id=" <?php echo  $row["pid"]; ?> " class="btn-danger btn-sm del_prodect">Delete</a>
                    <a href="#" edit_id="<?php echo $row['pid'];?>"  class="btn-info btn-sm edit_prodect"  data-toggle="modal" data-target="#update_prodects">Edit</a>
                </td>
            </tr>
            <?php
        }
        ?>
            <tr><td colspan='7'> <?php echo $pagination; ?> </td></tr>
        <?php
        exit();
    }
}

//delete category
if(isset($_POST["deleteCategory"])){
    $m= new Manage();
   $result= $m->DeleteRecord("categories","cid",$_POST["id"]);
   echo $result;
   exit();
}

//delete brand
if(isset($_POST["deleteBrand"])){
    $m= new Manage();
   $result= $m->DeleteRecord("brand","bid",$_POST["id"]);
   echo $result;
   exit();
}

//delete prodect
if(isset($_POST["deleteProdect"])){
    $m= new Manage();
   $result= $m->DeleteRecord("prodects","pid",$_POST["id"]);
   echo $result;
   exit();
}

//update category
if(isset($_POST["updateCategory"])){
    $m=new Manage();
    $result=$m->getSignleRecord("categories","cid",$_POST["id"]);
    echo json_encode($result);
    exit();

}
//update brand
if(isset($_POST["updateBrand"])){
    $m=new Manage();
    $result=$m->getSignleRecord("brand","bid",$_POST["id"]);
    echo json_encode($result);
    exit();
}

//update prodect
if(isset($_POST["updateProdect"])){
    $m=new Manage();
    $result=$m->getSignleRecord("prodects","pid",$_POST["id"]);
    echo json_encode($result);
    exit();

}

//update record getting data
if(isset($_POST["update_cat"])){
    $m=new Manage();
    $id= $_POST["cid"];
    $name=$_POST["update_cat"];
    $parent_cat=$_POST["parent_cat"];
    $result= $m->update_record("categories",["cid"=>$id],["parent_cat"=>$parent_cat,"category_name"=>$name,"status"=>1]);
    echo $result;
    exit();
}

if(isset($_POST["update_brandd"])){
    $m=new Manage();
    $id= $_POST["bid"];
    $name=$_POST["update_brandd"];
    $result= $m->update_record("brand",["bid"=>$id],["brand_name"=>$name,"status"=>1]);
    echo $result;
    exit();
}

if(isset($_POST["update_prodect_name"])){
    $m=new Manage();
    $id= $_POST["pid"];
    $name=$_POST["update_prodect_name"];
    $category=$_POST["update_prodect_cat"];
    $brand=$_POST["update_prodect_brand"];
    $price=$_POST["update_prodect_price"];
    $Quntity=$_POST["update_prodect_qnty"];
    $date=$_POST["update_date"];
    $result= $m->update_record("prodects",["pid"=>$id],["cid"=>$category,"bid"=>$brand,"prodect_name"=>$name,"prodect_price"=>$price,"prodect_stock"=>$Quntity,"added_date"=>$date,"p_status"=>1]);
    echo $result;
    exit();
}
///////////////////////////New order process//////////////
if(isset($_POST["getNewOrderItem"])){
    $db=new DBoperation();
   $rows= $db->getAllRecord("prodects");
 ?>
    <tr>
        <td><b  class="number">1</b></td>
        <td>
            <select name="pid[]" class="form-control form-control-sm pid">
                <option value="">Choose Prodect</option>
                <?php
                    foreach($rows as $row){
                        ?>
                        <option value="<?php echo $row['pid'];?>"> <?php echo $row['prodect_name'] ?></option>
                        <?php
                    }
                ?>
            </select>
        </td>    
        <td><input type="text" name="tqty[]"readonly class="form-control form-control-sm tqty"></td>
        <td><input type="text" name="qty[]" class="form-control form-control-sm qty" required></td>                            
        <td><input type="text" name="price[]"readonly class="form-control form-control-sm price"></td>   
        <td><input type="hidden" name="pro_name[]" class="form-control form-control-sm pro_name"></td>   
        <td >JD.<span class="amt">0</span></td>                         
    </tr>
   <?php
   exit();
}

//get price and qty of one item
if(isset($_POST["getPriceAndQty"])){
    $m= new Manage();
    $result=$m->getSignleRecord("prodects","pid",$_POST["id"]);
    echo json_encode($result);
    exit();
}


/////New order//////////
if(isset($_POST["order_date"]) && isset($_POST["customer_name"])){
   $customer_name= $_POST["customer_name"];
   $order_date= $_POST["order_date"];
   //Getting Array from order_form
  $ar_tqty= $_POST["tqty"];
  $ar_qty=$_POST["qty"];
  $ar_price=$_POST["price"];
  $ar_pro_name=$_POST["pro_name"];

 $sub_total=$_POST["sub_total"];
 $gst= $_POST["gst"];
 $discount=$_POST["discount"];
 $net_total= $_POST["net_total"];
 $paid= $_POST["paid"];
 $due= $_POST["due"];
 $payment_type= $_POST["payment_type"];

 $m=new Manage();
 echo $result=$m->storeCustomerOrderInvoice($order_date,$customer_name,$ar_tqty,$ar_qty,
$ar_price,$ar_pro_name,$sub_total,$gst,$discount,$net_total,$paid,$due,$payment_type);

  

}
?>
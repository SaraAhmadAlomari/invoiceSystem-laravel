
<?php
session_start();
$pagetitle='Add New Item';
include 'init.php';
//print_r( $_SESSION);

if(isset($_SESSION['name'])){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $formError=array();
        $name=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $decs=filter_var($_POST['description'],FILTER_SANITIZE_STRING);
        $price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
        $country=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
        $status=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        $category=filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
        $tags=filter_var($_POST['tags'],FILTER_SANITIZE_STRING);
        // echo $name . $decs . $price . $country . $status . $category ;

        //uplode image
        $imagename=$_FILES['image1']['name'];
        $imagesize=$_FILES['image1']['size'];
        $imagetmp=$_FILES['image1']['tmp_name'];
        $imagetype=$_FILES['image1']['type'];
        //list of allowed file typed to uplode
        $imageAllowedExtention=array("jpeg","jpg","png","gif");
        //get image extention
        $extention=explode('.',$imagename);
        $extention=end($extention);
        $imageExtention=strtolower($extention);
        if(strlen($name)< 4){
            $formError[]='Item Title Must Be Larger Than 4';
        }
        if(strlen($decs)< 4){
            $formError[]='Item Description Must Be Larger Than 10';
        }
        if(strlen($country)< 3){
            $formError[]='Item Country Must Be Larger Than 3';
        }
        if(empty($price)){
            $formError[]='Item Price Must Be Not Empty';
        }
        if(empty($status)){
            $formError[]='Item Status Must Be Not Empty';
        }
        if(empty($category)){
            $formError[]='Item Category Must Be Not Empty';
        }
         if(!empty($imagename) && !in_array($imageExtention,$imageAllowedExtention)){
                         $formErrors[]='This Extintion Is Not Allowed';
                    }
                    if($imagesize >4194304){
                        $formErrors[]='Image Can\'t Be Larger Than 4MB';
                    }
        //insert operation
        if(empty($formError))
        {
                    //for uplode img
                        $image=rand(0,1000000). '_' .$imagename;
                        move_uploaded_file($imagetmp,"admin\uplodes\items\\".$image);
                    $stmt=$con->prepare('INSERT INTO `items`(`name`, `description`, `add_data`, `country_made`, `price`, `status`,`member_ID`,`cat_ID`,`tags`,`image`)
                        VALUES (:name,:description,now(),:country_made,:price,:status,:member_ID,:cat_ID,:tags,:image)');
                    $stmt->execute(array(
                        'name'=>$name,
                        'description'=>$decs,
                        'country_made'=>$country,
                        'price'=>$price.'$',
                        'status'=>$status,
                        'member_ID'=>$_SESSION['theid'],
                        'cat_ID'=>$category,
                        'tags'=>$tags,
                        'image'=>$image
                    ));

                    if($stmt){
                       $successmsg='Item Added Successfully';                     
                    }
            
        }
    }
    ?>
        <h1 class="text-center"><?php echo $pagetitle ?></h1>
     
    <div class="my-ads block">
        <div class="container">
            <div class="card card-primary">
                <div class="card-header">
                <?php echo $pagetitle ?>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-container mt-4">
                                    <form class="main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            
                                        <div class="row mb-3">
                                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                                            <div  class="col-sm-10 cont">
                                            <input type="text" class="form-control live" data-class=".live-title" id="name" name="name" required="required" placeholder="Name Of The Item">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="description" class="col-sm-2 col-form-label ">Description</label>
                                            <div  class="col-sm-10 cont">
                                            <input type="text" class="form-control live" data-class=".live-desc" id="description" name="description"  required="required" placeholder="Description Of The Item">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="price" class="col-sm-2 col-form-label">Price</label>
                                            <div  class="col-sm-10 cont">
                                            <input type="text" class="form-control live" data-class=".live-price" id="price" name="price" required="required" placeholder="Price Of The Item">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="country" class="col-sm-2 col-form-label">Country</label>
                                            <div  class="col-sm-10 cont">
                                            <input type="text" class="form-control" id="country" name="country" required="required" placeholder="Country Of Made">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label  class="col-sm-2 col-form-label">Status</label>
                                            <div  class="col-sm-10">
                                            <select name="status" class="form-select">
                                            <option value="0">...</option>
                                            <option value="1">New</option>
                                            <option value="2">Like New</option>
                                            <option value="3">Used</option>
                                            <option value="4">Old</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label  class="col-sm-2 col-form-label">Categories</label>
                                            <div  class="col-sm-10">
                                            <select name="category" class="form-select">
                                            <option value="0">...</option>
                                             <?php 
                                                $cats=GetAllFrom('*','categories','','','ID');
                                                foreach($cats as $cat)
                                                {
                                                    echo" <option value=".$cat['ID'].">".$cat['name']."</option>";
                                                }
                                             
                                             ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="image" class="col-sm-2 col-form-label">Item Image</label>
                                            <div  class="col-sm-10">
                                            <input type="file" class="form-control item-img" name="image1" >
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                                            <div  class="col-sm-10">
                                            <input type="text" class="form-control"  name="tags" placeholder="Item Tag">

                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Ad</button>
                               </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="img-thumbnail item-box live-privew">
                                <span class="price-tag" >
                                    $<span class="live-price">0</span>
                                </span>
                                <img class="uplode-image" src="default.png" alt=""/>
                                <div class="caption">
                                    <h3 class="live-title">name</h3>
                                    <p class="live-desc">descriptipn</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- start formerror -->
                    <?php
                        if(!empty($formError)){
                            foreach($formError as $error){
                                echo '<div class="alert alert-danger">'.$error.'</div>';
                            }
                        }
                        if(isset($successmsg)){
                            echo'<div class="alert alert-success mt-3">'.$successmsg.'</div>';
                        }
                    ?>
                    <!-- end  formerror -->
                </div>

            </div>                       
        </div>
    </div>
       

    <?php
}
else{
    header('Location:login.php');
}
?>


<?php include 'includes/templete/footer.php';?>


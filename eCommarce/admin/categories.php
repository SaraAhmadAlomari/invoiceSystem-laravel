<?php
    ob_start(); //output buffering start

    session_start();
    if(isset($_SESSION['username']))
    {
        $pagetitle='Categories';
        include 'init.php';
        $do=isset($_GET['do'])?$_GET['do']:'Manage';

        if($do=='Manage')
        { //manage page
            $sort='ASC';
            $sort_array=array('ASC','DESC');
            if(isset($_GET['sort'])&& in_array($_GET['sort'],$sort_array)){
                $sort=$_GET['sort'];
            }
            $stmt=$con->prepare("SELECT * FROM categories WHERE parent=0 ORDER BY ordering $sort");
            $stmt->execute();
            $cats=$stmt->fetchAll(); 
            if(!empty($cats))
            {
                ?>
                    <h1 class='text-center'>Manage Categories</h1>
                    <div class="container categories">
                        <div class="card">
                                <div class="card-header"><i class="fa fa-edit"></i>Manage Categories
                                    <div class="option pull-right">
                                        <i class="fa fa-sort"></i> [
                                        <a class="<?php if($sort=='ASC') {echo 'active';} ?>" href="?sort=ASC">Asc</a> |
                                        <a class="<?php if($sort=='DESC') {echo 'active';} ?>" href="?sort=DESC">Desc</a>]
                                        <i class="fa fa-eye"></i> [
                                        <span data-view="full">Full</span> |
                                        <span>Classic</span>]
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php 
                                        foreach($cats as $cat ){
                                            echo "<div class='cat'>";
                                            echo "<div>";
                                                echo "<div class='hidden-buttons'>
                                                        <a href='categories.php?do=Edit&catid=".$cat['ID']."' class='btn btn-sm btn-primary'> <i class='fa fa-edit'></i> Edit</a>
                                                        <a href='categories.php?do=Delete&catid=".$cat['ID']."' class='btn btn-sm btn-danger confirm'> <i class='fa fa-close'></i> Delete</a>
                                                    </div>";
                                            echo "</div>";
                                            echo "<h3>".$cat['name']."</h3>";
                                            echo "<div class='full-view'>";
                                            echo "<p>"; if($cat['description']==''){ echo 'This category has no description';}else{echo $cat['description'];} echo"</p>";
                                            if($cat['visibillity']==1){echo " <span class='visibillity'><i class='fa fa-eye'></i> Hidden</span>";}
                                            if( $cat['allow_comments']==1){echo " <span class='commenting'><i class='fa fa-close'></i> Comments Disabled</span>";}
                                            if( $cat['allow_ads']==1){echo " <span class='advertises'><i class='fa fa-close'></i> Ads Disabled</span>";}
                                              $childCat=GetAllFrom('*','categories','WHERE parent='.$cat['ID'].'','','ID','ASC');
                                                    if(!empty($childCat)){
                                                        echo '<h4 class="head-child">Child Categories</h4>';
                                                        echo '<ul class="child-cat">';
                                                         foreach($childCat as $child){
                                                            // <a href='categories.php?do=Edit&catid=".$cat['ID']."'
                                                           echo '<li  class="child-link">
                                                            <a href="categories.php?do=Edit&catid='.$child['ID'].'">'.$child['name'].'</a>
                                                            <a href="categories.php?do=Delete&catid='.$child['ID'].'" class="show-delete confirm">Delete</a>
                                                           </li>';
                                                         }
                                                           
                                                       echo' </ul>';
                                                    }
                                            echo "</div>";
                                            echo "</div>";   
                                            echo "<hr>";
                                        }
                                    ?>
                                </div>
                            </div>
                            <a href="categories.php?do=Add"class=" add-new-cat btn btn-primary"><i class="fa fa-plus"></i>Add New Category</a>
                    </div>
                <?php
            }
              else
                { 
                    echo'<div class="container text-center">';
                    echo'<div class="nice-msg">There\'s No Categories</div>';
                    echo'<a href="categories.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Category</a>';
                    echo'</div>';

                }
        }
        
        elseif($do=='Add')
        { //Add category page
            echo '
                    <h1 class="text-center mt-3">Add New Category</h1>
                    <div class="form-container mt-4">
                        <form action="?do=Insert" method="POST">
            
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required="required" placeholder="Name Of The Category">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description" placeholder="Descripe The Category">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="ordering" class="col-sm-2 col-form-label">Ordering</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="ordering" name="ordering" placeholder="Number To Arrange The Categories">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  class="col-sm-2 col-form-label">Parent Category</label>
                                <div  class="col-sm-10">
                                <select name="parent" class="form-select">
                                <option value="0">None</option>
            ';
                                $getallparent=GetAllFrom('*','categories','WHERE parent=0','','ID','ASC');
                                foreach($getallparent as $parent){
                                    echo '<option value="'.$parent['ID'].'">'.$parent['name'].'</option>';
                                }
                               
                        echo'  </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="visibile" class="col-sm-2 col-form-label">Visibile</label>
                                <div  class="col-sm-10">
                                <div>
                                    <input type="radio"id="vis-yes" name="visibile" value="0" checked>
                                    <lable for="vis-yes" class="form-label">Yes</lable>
                                </div>
                                <div>
                                    <input type="radio" id="vis-no" name="visibile" value="1">
                                    <lable for="vis-no" class="form-label">No</lable>
                                </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Commenting" class="col-sm-2 col-form-label">Allow Commenting</label>
                                <div  class="col-sm-10">
                                <div>
                                    <input type="radio"id="com-yes" name="Commenting" value="0" checked>
                                    <lable for="com-yes" class="form-label">Yes</lable>
                                </div>
                                <div>
                                    <input type="radio" id="com-no" name="Commenting" value="1">
                                    <lable for="com-no" class="form-label">No</lable>
                                </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Commenting" class="col-sm-2 col-form-label">Allow Ads</label>
                                <div  class="col-sm-10">
                                <div>
                                    <input type="radio"id="ads-yes" name="ads" value="0" checked>
                                    <lable for="ads-yes" class="form-label">Yes</lable>
                                </div>
                                <div>
                                    <input type="radio" id="ads-no" name="ads" value="1">
                                    <lable for="ads-no" class="form-label">No</lable>
                                </div>
                                </div>
                            </div>
                        
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </form>

                    </div>
                ';
        }
        elseif($do=='Insert')
        {//insert caregory page
            if($_SERVER['REQUEST_METHOD']=='POST')
                {
                    echo "<h1 class='text-center'>Insert Categories</h1>";
                    echo "<div class='container'>";
                    //get variable from the form
                    $name=$_POST['name'];
                    $description=$_POST['description'];
                    $parent=$_POST['parent'];
                    $ordering=$_POST['ordering'];
                    $visibile=$_POST['visibile'];
                    $Commenting=$_POST['Commenting'];
                    $ads=$_POST['ads'];
                   
                    //insert operation
                   
                        //cheack if name is already exist in database
                        $cheack=cheackItem("name","categories",$name);
                        if($cheack == 1){
                            $themsg= '<div class="alert alert-danger">Sorry! This Category Is Exist</div>';
                            RedirectHome($themsg,'back');
                        }
                        else
                        {
                                $stmt=$con->prepare('INSERT INTO categories (name,description,parent,ordering,visibillity,allow_comments,allow_ads)
                                values (:name,:description,:parent,:ordering,:visibile,:comments,:ads)');
                                $stmt->execute(array(
                                    'name'=>$name,
                                    'description'=>$description,
                                    'parent'=>$parent,
                                    'ordering'=>$ordering,
                                    'visibile'=>$visibile,
                                    'comments'=>$Commenting,
                                    'ads'=>$ads
                                ));

                                //success msg
                                $themsg= "<div class='alert alert-success'>"
                                . $stmt->rowCount() .'Recourd Inserted </div>';
                                RedirectHome($themsg,'back');
                        }
                    
                }
                else{
                       echo"<div class='container'>"; 
                            $errormsg= ' <div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                            RedirectHome($errormsg,'back');
                        echo "</div>";
                }
                echo "</div>";
        }
        elseif($do=='Edit')
        { //edit category page

            //check if get request catid is numeric &get the integer value of it
                $catid=isset($_GET['catid']) && is_numeric($_GET['catid'])?intval($_GET['catid']):0;
                //get data from database depends on this ID
                $stmt = $con->prepare('SELECT * from categories WHERE ID=? LIMIT 1');
                //execute query
                $stmt->execute(array($catid));
                //fetch data 
                $row=$stmt->fetch();
                //the row count
                $count=$stmt->rowCount();
                //if there's such ID show the form
            
                if($count>0)
                { ?>
                    
                    <h1 class="text-center mt-3">Edit Category</h1>
                    <div class="form-container mt-4">
                        <form action="?do=Update" method="POST">
                            <input type="hidden" name="catid" value="<?php echo $catid ?>"/>
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required="required" placeholder="Name Of The Category" value="<?php echo $row['name']; ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div  class="col-sm-10">
                                <input type="description" class="form-control" id="description" name="description" placeholder="Descripe The Category" value="<?php echo $row['description']; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  class="col-sm-2 col-form-label">Parent Category</label>
                                <div  class="col-sm-10">
                                <select name="parent" class="form-select">
                                <option value="0">None</option>
                                <?php 
                                    
                                $getallparent=GetAllFrom('*','categories','WHERE parent=0','','ID','ASC');
                                foreach($getallparent as $parent){
                                    echo '<option value="'.$parent['ID'].'"';
                                    if($row['parent']==$parent['ID']){echo 'selected ';}
                                    echo '>'.$parent['name'].'</option>';
                                }
                               
                                ?>
                                 </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="ordering" class="col-sm-2 col-form-label">Ordering</label>
                                <div  class="col-sm-10">
                                <input type="ordering" class="form-control" id="ordering" name="ordering" placeholder="Number To Arrange The Categories" value="<?php echo $row['ordering']; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="visibile" class="col-sm-2 col-form-label">Visibile</label>
                                <div  class="col-sm-10">
                                <div>
                                    <input type="radio"id="vis-yes" name="visibile" value="0" <?php if($row['visibillity']==0){ echo "checked";} ?>>
                                    <lable for="vis-yes" class="form-label">Yes</lable>
                                </div>
                                <div>
                                    <input type="radio" id="vis-no" name="visibile" value="1" <?php if($row['visibillity']==1){ echo "checked";} ?>>
                                    <lable for="vis-no" class="form-label">No</lable>
                                </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Commenting" class="col-sm-2 col-form-label">Allow Commenting</label>
                                <div  class="col-sm-10">
                                <div>
                                    <input type="radio"id="com-yes" name="Commenting" value="0" <?php if($row['allow_comments']==0){ echo "checked";} ?>>
                                    <lable for="com-yes" class="form-label">Yes</lable>
                                </div>
                                <div>
                                    <input type="radio" id="com-no" name="Commenting" value="1" <?php if($row['allow_comments']==1){ echo "checked";} ?>>
                                    <lable for="com-no" class="form-label">No</lable>
                                </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Commenting" class="col-sm-2 col-form-label">Allow Ads</label>
                                <div  class="col-sm-10">
                                <div>
                                    <input type="radio"id="ads-yes" name="ads" value="0" <?php if($row['allow_ads']==0){ echo "checked";} ?>>
                                    <lable for="ads-yes" class="form-label">Yes</lable>
                                </div>
                                <div>
                                    <input type="radio" id="ads-no" name="ads" value="1" <?php if($row['allow_ads']==1){ echo "checked";} ?>>
                                    <lable for="ads-no" class="form-label">No</lable>
                                </div>
                                </div>
                            </div>
                        
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                
               <?php }

                    //if Theres No such ID show erorr message
                else{ 
                    echo "<div class='container'>";
                    $themsg='<div class="alert alert-danger">Theres No such ID</div>';
                    RedirectHome($themsg,'back');
                    echo "</div>";
                }

        }
        elseif($do=='Update')
        { //update page
            if($_SERVER['REQUEST_METHOD']=='POST')
                {
                    echo "<h1 class='text-center'>Update Categories</h1>";
                    echo "<div class='container'>";
                    //get variable from the form
                    $catid=$_POST['catid'];
                    $name=$_POST['name'];
                    $description=$_POST['description'];
                    $parent=$_POST['parent'];
                    $ordering=$_POST['ordering'];
                    $visibile=$_POST['visibile'];
                    $Commenting=$_POST['Commenting'];
                    $ads=$_POST['ads'];
                   
                    $stmt=$con->prepare('UPDATE categories SET 
                    name=?,description=?,parent=?,ordering=?,visibillity=?,allow_comments=?,allow_ads=? WHERE ID=? ');
                    $stmt->execute(array($name,$description,$parent,$ordering,$visibile,$Commenting,$ads,$catid));

                    //success msg
                    $themsg= "<div class='alert alert-success'>"
                    . $stmt->rowCount() .'Recourd Updated </div>';
                    RedirectHome($themsg,'back');
                        
                    
                }
                else
                {
                       echo"<div class='container'>"; 
                            $errormsg= ' <div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                            RedirectHome($errormsg,'back');
                        echo "</div>";
                }
                echo "</div>";

        }
        elseif($do=='Delete')
        {
            //check if get request catid is numeric &get the integer value of it
                $catid=isset($_GET['catid']) && is_numeric($_GET['catid'])?intval($_GET['catid']):0;
                //get data from database depends on this ID
                $cheack=cheackItem('ID','categories',$catid);
            
                if($cheack>0)
                {
                    echo "<h1 class='text-center'>Delete Categories</h1>";
                    echo "<div class='container'>";
                    $stmt=$con->prepare('DELETE FROM categories WHERE ID = :id');
                    $stmt->bindparam(":id",$catid);
                    $stmt->execute();
                    //success msg
                    $themsg= "<div class='alert alert-success'>" . $stmt->rowCount() .'Recourd Deleted </div>';
                    RedirectHome($themsg,'back');
                }else{
                        $themsg='<div class="alert alert-danger">Theres No such ID</div>';
                        RedirectHome($themsg,'back');
                 }
            echo "</div>";
        }
        
    }
    
     else
    {
        header('Location:index.php');
        exit();
    }

        include 'includes/templete/footer.php';

    ?>
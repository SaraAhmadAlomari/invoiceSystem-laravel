
<?php
    ob_start(); //output buffering start

    session_start();
    if(isset($_SESSION['username']))
    {
        $pagetitle='Items';
        include 'init.php';
        $do=isset($_GET['do'])?$_GET['do']:'Manage';

        if($do=='Manage')
        { //manage page
            
            //fetch users from database expext Admin
            $stmt=$con->prepare("SELECT items.*,
            users.username AS userName,
            categories.name AS categoryName
            FROM items
            INNER JOIN 
            categories ON categories.ID = items.cat_ID
            INNER JOIN 
            users ON users.userID = items.member_ID ORDER BY item_ID DESC");
            $stmt->execute();
            $items=$stmt->fetchAll();
            $count=1;
            if(!empty($items))
            {
                ?>
                
                    <h1 class="text-center mt-3">Manage Items</h1>
                    <div class="container">
                    <table class="table manage-item">
                    <thead class="table-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Adding Date</th>
                        <th scope="col">Category</th>
                        <th scope="col">Member</th>
                        <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                        foreach($items as $item)
                        {
                            echo "<tr>";
                            echo "<td>".$count++."</td>";
                            echo "<td>";
                            if(empty($item['image'])){
                                echo 'no img';
                            }else{
                            echo"<img src='uplodes/items/".$item['image']."'alt=''>";}
                            echo"</td>";
                            echo "<td>".$item['name']."</td>";
                            echo "<td>".$item['description']."</td>";
                            echo "<td>".$item['price']."</td>";
                            echo "<td>".$item['add_data']."</td>";
                            echo "<td>".$item['categoryName']."</td>";
                            echo "<td>".$item['userName']."</td>";
                            echo "<td>
                                    <a href='items.php?do=Delete&itemid=".$item['item_ID']."' class='btn btn-danger confirm'><i class='fa fa-trash'></i> Delete</a>
                                    <a href='items.php?do=Edit&itemid=".$item['item_ID']."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a> ";
                                    if($item['approve']==0){
                                        echo" <a href='items.php?do=Approve&itemid=".$item['item_ID']."' class='btn btn-info'><i class='fa fa-check'></i> Approve</a> ";
                                    }
                                    
                             echo"</td>" ;
                            echo "</tr>";
                        }  
                    ?>
                        </tbody>
                        </table>
                        <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Item</a>
                        </div>  
                    <?php
            }   
            else
                { 
                    echo'<div class="container text-center">';
                    echo'<div class="nice-msg">There\'s No Items</div>';
                    echo'<a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Item</a>';
                    echo'</div>';

                }
        }
        elseif($do=='Add')
        { //Add page
               echo '
                    <h1 class="text-center mt-3">Add New Item</h1>
                    <div class="form-container mt-4">
                        <form action="?do=Insert" method="POST"enctype="multipart/form-data">
            
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required="required" placeholder="Name Of The Item">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description"  required="required" placeholder="Description Of The Item">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="price" class="col-sm-2 col-form-label">Price</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="price" name="price" required="required" placeholder="Price Of The Item">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="country" class="col-sm-2 col-form-label">Country</label>
                                <div  class="col-sm-10">
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
                                <label  class="col-sm-2 col-form-label">Members</label>
                                <div  class="col-sm-10">
                                <select name="member" class="form-select">
                                <option value="0">...</option>';
                                
                                    $members=GetAllFrom("*","users","","","userID");
                                    foreach($members as $member){
                                       echo" <option value=".$member['userID'].">".$member['username']."</option>";
                                    }

                              echo'  </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  class="col-sm-2 col-form-label">Categories</label>
                                <div  class="col-sm-10">
                                <select name="category" class="form-select">
                                <option value="0">...</option>
                                ';
                                   
                                    $cats=GetAllFrom("*","categories","WHERE parent=0","","ID");
                                    foreach($cats as $cat){
                                        echo" <option value=".$cat['ID'].">".$cat['name']."</option>";
                                        $allchild=GetAllFrom("*","categories","WHERE parent=".$cat['ID']."" ,"","ID");
                                        foreach($allchild as $child)
                                        echo" <option value=".$child['ID'].">---".$child['name']."</option>";
                                    }
                              echo'  </select>
                                </div>
                            </div>
                             <div class="row mb-3">
                                <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control"  name="tags" placeholder="Sepatare By ,">

                                </div>
                            </div>
                             <div class="row mb-3">
                                <label for="tags" class="col-sm-2 col-form-label">Item Image</label>
                                <div  class="col-sm-10">
                                <input type="file" class="form-control"  name="image">

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Item</button>
                               </form>

                    </div>
                ';
            
        }
        elseif($do=='Insert')
          { //insert page
            if($_SERVER['REQUEST_METHOD']=='POST')
                {
                    echo "<h1 class='text-center'>Insert Items</h1>";
                    echo "<div class='container'>";
                    //get variable from the form
                    $imagename=$_FILES['image']['name'];
                    $imagesize=$_FILES['image']['size'];
                    $imagetmp=$_FILES['image']['tmp_name'];
                    $imagetype=$_FILES['image']['type'];
                    //list of allowed file typed to uplode
                    $imageAllowedExtention=array("jpeg","jpg","png","gif");
                    //get image extention
                    $extention=explode('.',$imagename);
                    $extention=end($extention);
                    $imageExtention=strtolower($extention);

                    $name=$_POST['name'];
                    $price=$_POST['price'];
                    $country=$_POST['country'];
                    $description=$_POST['description'];
                    $status=$_POST['status'];
                    $category=$_POST['category'];
                    $member=$_POST['member'];
                    $tags=$_POST['tags'];
                    //validate the form
                    $formErrors=array();
                    if(empty($name)){
                        $formErrors[]='Name Cant be Empty';
                    }
                    if(empty($price)){
                        $formErrors[]='Price Cant be Empty';
                    }
                    if(empty($country)){
                        $formErrors[]='Country Cant be Empty';
                    }
                    if(empty($description)){
                        $formErrors[]='Description Cant be Empty';
                    }
                    if($status == 0){
                        $formErrors[]='You Should Choose Status';
                    }
                    if($category == 0){
                        $formErrors[]='You Should Choose Category';
                    }
                    if($member == 0){
                        $formErrors[]='You Should Choose Member';
                    }
                    
                    if(!empty($imagename) && !in_array($imageExtention,$imageAllowedExtention)){
                         $formErrors[]='This Extintion Is Not Allowed';
                    }
                    if($imagesize >4194304){
                        $formErrors[]='Image Can\'t Be Larger Than 4MB';
                    }
                    foreach($formErrors as $error){
                        echo '<div class="alert alert-danger">'. $error.'</div>';
                    }
                    //insert operation
                    if(empty($formErrors))
                    {
                                //for uplode img
                                $image=rand(0,1000000). '_' .$imagename;
                                move_uploaded_file($imagetmp,"uplodes\items\\".$image);

                                $stmt=$con->prepare('INSERT INTO `items`(`name`, `description`, `add_data`, `country_made`, `price`, `status`,`member_ID`,`cat_ID`,`tags`,`image`)
                                 VALUES (:name,:description,now(),:country_made,:price,:status,:member_ID,:cat_ID,:tags,:image)');
                                $stmt->execute(array(
                                    'name'=>$name,
                                    'description'=>$description,
                                    'country_made'=>$country,
                                    'price'=>$price.'$',
                                    'status'=>$status,
                                    'member_ID'=>$member,
                                    'cat_ID'=>$category,
                                    'tags'=>$tags,
                                    'image'=>$image
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
        { //Edit page
            
                //check if get request itemid is numeric && get the integer value of it
                $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
                //get data from database depends on this ID
                $stmt = $con->prepare('SELECT * from items WHERE item_ID=? LIMIT 1');
                //execute query
                $stmt->execute(array($itemid));
                //fetch data 
                $item=$stmt->fetch();
                //the row count
                $count=$stmt->rowCount();
                //if there's such ID show the form
            
                if($count>0)
                { 
                    echo '
                    <h1 class="text-center mt-3">Edit Item</h1>
                    <div class="form-container mt-4">
                        <form action="?do=Update" method="POST">
            
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required="required" placeholder="Name Of The Item" value="'; echo $item['name']; echo'">
                                <input type="hidden" name="itemid" value="'; echo $item['item_ID']; echo'">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description"  required="required" placeholder="Description Of The Item" value="'; echo $item['description']; echo'">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="price" class="col-sm-2 col-form-label">Price</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="price" name="price" required="required" placeholder="Price Of The Item" value="'; echo $item['price']; echo'">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="country" class="col-sm-2 col-form-label">Country</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="country" name="country" required="required" placeholder="Country Of Made" value="'; echo $item['country_made']; echo'">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  class="col-sm-2 col-form-label">Status</label>
                                <div  class="col-sm-10">
                                <select name="status" class="form-select" >
                                <option value="1" '; if($item['status']==1){echo 'selected';} echo'>New</option>
                                <option value="2" '; if($item['status']==2){echo 'selected';} echo'>Like New</option>
                                <option value="3" '; if($item['status']==3){echo 'selected';} echo'>Used</option>
                                <option value="4" '; if($item['status']==4){echo 'selected';} echo' >Old</option>
                                </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  class="col-sm-2 col-form-label">Members</label>
                                <div  class="col-sm-10">
                                <select name="member" class="form-select" > ';
                                    $users=GetAllFrom("*","users","","","userID");
                                    foreach($users as $user){
                                       echo "<option value='".$user['userID']."'"; 
                                       if($item['member_ID']==$user['userID']){echo 'selected';}
                                       echo ">".$user['username']."</option>";
                                    }

                              echo'  </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  class="col-sm-2 col-form-label">Categories</label>
                                <div  class="col-sm-10">
                                <select name="category" class="form-select"> ';
                                    $stmt=$con->prepare("SELECT ID ,name FROM categories");
                                    $stmt->execute();
                                    $cats=$stmt->fetchAll();
                                    foreach($cats as $cat){
                                         echo "<option value='".$cat['ID']."'"; 
                                       if($item['cat_ID']==$cat['ID']){echo 'selected';}
                                       echo ">".$cat['name']."</option>";
                                    }
                              echo'  </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="tags" name="tags" placeholder="Item Tag"value="'; echo $item['tags']; echo'">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Item</button>
                               </form>

                    </div>
                ';
                 }

                    //if Theres No such ID show erorr message
                else{ 
                    echo "<div class='container'>";
                    $themsg='<div class="alert alert-danger">Theres No such ID</div>';
                    RedirectHome($themsg,'back');
                    echo "</div>";
                }
                
            $stmt=$con->prepare("SELECT comments.*,users.username
             FROM comments 
             INNER JOIN 
             users
             ON 
             users.userID=comments.user_id
             WHERE item_id=?");
            $stmt->execute(array($itemid));
            $items=$stmt->fetchAll();
             if(!empty($items)){
         ?>
               
                <h1 class="text-center mt-3">Manage [<?php echo $item['name']; ?>] Comments</h1>
                <div class="container">
                <table class="table ">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Comment</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Comment Date</th>
                    <th scope="col">Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($items as $item)
                        {
                            echo "<tr>";
                            echo "<td>".$item['c_id']."</td>";
                            echo "<td>".$item['comment']."</td>";
                            echo "<td>".$item['username']."</td>";
                            echo "<td>".$item['comment_date']."</td>";
                          
                            echo "<td>
                                    <a href='comments.php?do=delete&comid=".$item['c_id']."' class='btn btn-danger confirm'><i class='fa fa-trash'></i> Delete</a>
                                    <a href='comments.php?do=edit&comid=".$item['c_id']."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a> ";
                                   if($item['status']==0)
                                   {
                                        echo "<a href='comments.php?do=approve&comid=".$item['c_id']."' class='btn btn-info'><i class='fa fa-check'></i> Approve</a> ";
                                   }
                                    
                             echo"</td>" ;
                            echo "</tr>";
                        }  ?>
                </tbody>
                </table>
                </div>  
                <?php
             }
        }
        elseif($do=='Update')
        { //Update page
            if($_SERVER['REQUEST_METHOD']=='POST')
                {
                    echo "<h1 class='text-center'>Update Items</h1>";
                    echo "<div class='container'>";
                    //get variable from the form
                    $id=$_POST['itemid'];
                    $name=$_POST['name'];
                    $price=$_POST['price'];
                    $country=$_POST['country'];
                    $description=$_POST['description'];
                    $status=$_POST['status'];
                    $category=$_POST['category'];
                    $member=$_POST['member'];
                    $tags=$_POST['tags'];
                        //validate the form
                    $formErrors=array();
                    if(empty($name)){
                        $formErrors[]='Name Cant be Empty';
                    }
                    if(empty($price)){
                        $formErrors[]='Price Cant be Empty';
                    }
                    if(empty($country)){
                        $formErrors[]='Country Cant be Empty';
                    }
                    if(empty($description)){
                        $formErrors[]='Description Cant be Empty';
                    }
                    if($status == 0){
                        $formErrors[]='You Should Choose Status';
                    }
                    if($category == 0){
                        $formErrors[]='You Should Choose Category';
                    }
                    if($member == 0){
                        $formErrors[]='You Should Choose Member';
                    }
                    foreach($formErrors as $error){
                        echo '<div class="alert alert-danger">'. $error.'</div>';
                    }
                    //insert operation
                    if(empty($formErrors))
                    {
                                $stmt=$con->prepare('UPDATE  items  SET 
                                name =?,
                                description =?,
                                country_made =?,
                                price =?,
                                status =?,
                                member_ID =?,
                                cat_ID =?,
                                tags=?
                                WHERE item_ID=?');
                                
                                $stmt->execute(array($name,$description,$country,$price,$status,$member,$category,$tags,$id));
                                //success msg
                                $themsg= "<div class='alert alert-success'>"
                                . $stmt->rowCount() .'Recourd Inserted </div>';
                                RedirectHome($themsg,'back');
                    }
                }
                else{
                    $themsg= '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                    RedirectHome($themsg);
                }
                echo "</div>";
        }
        elseif($do=='Delete')
        { //delete page
            //check if get request itemid is numeric &get the integer value of it
                $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
                //get data from database depends on this ID
                $cheack=cheackItem('item_ID','items',$itemid);
            
                if($cheack>0)
                {
                    echo "<h1 class='text-center'>Delete Items</h1>";
                    echo "<div class='container'>";
                    $stmt=$con->prepare('DELETE FROM items WHERE item_ID = :id');
                    $stmt->bindparam(":id",$itemid);
                    $stmt->execute();
                    //success msg
                    $themsg= "<div class='alert alert-success'>" . $stmt->rowCount() .'Recourd Deleted </div>';
                    RedirectHome($themsg,'back');
                }else{
                        echo "<div class='container'>";
                        $themsg='<div class="alert alert-danger">Theres No such ID</div>';
                        RedirectHome($themsg,'back');
                        echo "</div>";
                 }
                 echo '</div>';
        }
        elseif($do=='Approve')
        { //Aprove page
            $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
                //get data from database depends on this ID
                $cheack=cheackItem('item_ID','items',$itemid);
            
                if($cheack>0)
                {
                    echo "<h1 class='text-center'>Approve Items</h1>";
                    echo "<div class='container'>";
                    $stmt=$con->prepare('UPDATE items SET approve=1 WHERE item_ID = :iitem');
                    $stmt->bindparam(":iitem",$itemid);
                    $stmt->execute();
                    //success msg
                    $themsg= "<div class='alert alert-success'>" . $stmt->rowCount() .'Recourd Approved </div>';
                    RedirectHome($themsg,'back');
                }else{
                        $themsg='<div class="alert alert-danger">Theres No such ID</div>';
                        RedirectHome($themsg,'back');  
                 }
                echo'</div>';
        }

    }
    else
    {
        header('Location:index.php');
        exit();
    }

        include 'includes/templete/footer.php';

?>
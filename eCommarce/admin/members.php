<!-- manage members page
you can add |edit |delete members from here-->

<?php
    session_start();
    
    if(isset($_SESSION['username']))
    {
        $pagetitle='Members';
        include 'init.php';
        $do=isset($_GET['do'])?$_GET['do']:'Manage';

        //start manage page
        if($do=='Manage')   //manage page   
        {   
            $query='';
            if(isset($_GET['page']) && $_GET['page']=='pending')
            {
                $query='AND regStatus=0';
            }
            //fetch users from database expext Admin
            $stmt=$con->prepare("SELECT * FROM users WHERE groupID !=1 $query ORDER BY userID DESC ");
            $stmt->execute();
            $members=$stmt->fetchAll();
            if(!empty($members)){
                $count=1;
                ?>
                    
                    <h1 class="text-center mt-3">Manage Members</h1>
                    <div class="container">
                    <table class="table manage-member">
                    <thead class="table-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Avatar</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Registerd Date</th>
                        <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                            foreach($members as $member)
                            {
                                echo "<tr>";
                                echo "<td>".$count++."</td>";
                                echo "<td>";
                                if(empty($member['avatar'])){
                                    echo 'no img';
                                }else{
                                echo"<img src='uplodes/avatars/".$member['avatar']."'alt=''>";}
                                echo"</td>";
                                echo "<td>".$member['username']."</td>";
                                echo "<td>".$member['email']."</td>";
                                echo "<td>".$member['fullname']."</td>";
                                echo "<td>".$member['RegDate']."</td>";
                                echo "<td>
                                        <a href='members.php?do=delete&userid=".$member['userID']."' class='btn btn-danger confirm'><i class='fa fa-trash'></i> Delete</a>
                                        <a href='members.php?do=edit&userid=".$member['userID']."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a> ";
                                        if($member['regStatus']==0){
                                        echo "<a href='members.php?do=activate&userid=".$member['userID']."' class='btn btn-info'><i class='fa fa-check'></i> Activate</a> ";

                                        }
                                echo"</td>" ;
                                echo "</tr>";
                            }  
                ?>
                    </tbody>
                    </table>
                    <a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New member</a>
                    </div>             
                <?php
            }
            else
            { 
                echo'<div class="container text-center">';
                echo'<div class="nice-msg">There\'s No Members</div>';
                echo'<a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member</a>';
                echo'</div>';

            }
        }
        elseif($do=='add')  //add member page
        { 
            echo '
                     <h1 class="text-center mt-3">Add New Member</h1>
                    <div class="form-container mt-4">
                        <form action="?do=insert" method="POST" enctype="multipart/form-data">
            
                            <div class="row mb-3">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="username" name="username"autocomplete="off"  required="required" placeholder="Enter The Username">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <div  class="col-sm-10">
                                <input type="password" class="password form-control" id="password" name="password" autocomplete="new-password"  required="required" placeholder="The password must be strong">
                                <i class="show-pass fa  fa-eye"></i>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div  class="col-sm-10">
                                <input type="email" class="form-control" id="email"name="email" required="required" placeholder="Enter valid Email">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="fullname" class="col-sm-2 col-form-label">Fullname</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="fullname" name="fullname" required="required" placeholder="This name will appeare in yor profile">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="avatar" class="col-sm-2 col-form-label">User Avatar</label>
                                <div  class="col-sm-10">
                                <input type="file" class="form-control" id="avatar" name="avatar" required="required">
                                </div>
                            </div>
                        
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>

                    </div>
                ';
        }
        elseif($do=='insert') //insert page
        { 
            //echo $_POST['username'].$_POST['password'].$_POST['fullname'].$_POST['email'];
            if($_SERVER['REQUEST_METHOD']=='POST')
                {
                    echo "<h1 class='text-center'>Insert Member</h1>";
                    echo "<div class='container'>";
                    //get variable from the form
                    $avatarname=$_FILES['avatar']['name'];
                    $avatarsize=$_FILES['avatar']['size'];
                    $avatartmp=$_FILES['avatar']['tmp_name'];
                    $avatartype=$_FILES['avatar']['type'];
                    //list of allowed file typed to uplode
                    $avataAllowedExtention=array("jpeg","jpg","png","gif");
                    //get avatar extention
                    $extention=explode('.',$avatarname);
                    $extention=end($extention);
                    $avatarExtention=strtolower($extention);

                    $username=$_POST['username'];
                    $password=$_POST['password'];
                    $email=$_POST['email'];
                    $fullname=$_POST['fullname'];
                   
                    $hashpass=sha1($_POST['password']);
                    //validate the form
                    $formErrors=array();
                    if(empty($username)){
                        $formErrors[]='Username Cant be Empty';
                    }
                    if(empty($password)){
                        $formErrors[]='Password Cant be Empty';
                    }
                    if(strlen($username)<4){
                        $formErrors[]='Username Cant Be Less Than 4';
                    }
                      if(strlen($username)>20){
                        $formErrors[]='Username Cant Be Less Grater Than 20 ';
                    }
                    if(empty($fullname)){
                        $formErrors[]='fullname Cant be Empty';
                    }
                    if(empty($email)){
                        $formErrors[]='Email Cant be Empty';
                    }
                    if(empty($avatarname)){
                        $formErrors[]='Avatar Is Required';
                    }
                    if(!empty($avatarname) && !in_array($avatarExtention,$avataAllowedExtention)){
                         $formErrors[]='This Extintion Is Not Allowed';
                    }
                    if($avatarsize >4194304){
                        $formErrors[]='Avatar Can\'t Be Larger Than 4MB';
                    }
                    foreach($formErrors as $error){
                        echo '<div class="alert alert-danger">'. $error.'</div>';
                    }
                    //insert operation
                    if(empty($formErrors))
                    {
                        //for uplode img
                        $avatar=rand(0,1000000). '_' .$avatarname;
                        move_uploaded_file($avatartmp,"uplodes\avatars\\".$avatar);
                        echo $avatar;
                        //cheack if username is already exist in database
                        $cheack=cheackItem("username","users",$username);
                        if($cheack == 1){
                            $themsg= '<div class="alert alert-danger">Sorry! This User Is Exist</div>';
                            RedirectHome($themsg,'back');
                        }
                        else
                        {
                                $stmt=$con->prepare('INSERT INTO users (username,password,email,fullname,regStatus,RegDate,avatar)
                                values (:user,:password,:email,:name,1,now(),:avatar)');
                                $stmt->execute(array(
                                    'user'=>$username,
                                    'password'=>$hashpass,
                                    'email'=>$email,
                                    'name'=>$fullname,
                                    'avatar'=>$avatar
                                ));

                                //success msg
                                $themsg= "<div class='alert alert-success'>"
                                . $stmt->rowCount() .'Recourd Inserted </div>';
                                RedirectHome($themsg,'back');
                        }
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
        elseif($do=='edit')   //edit page
            { 
                
                //check if get request userid is numeric &get the integer value of it
                $userid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
                //get data from database depends on this ID
                $stmt = $con->prepare('SELECT * from users WHERE userID=? LIMIT 1');
                //execute query
                $stmt->execute(array($userid));
                //fetch data 
                $member=$stmt->fetch();
                //the row count
                $count=$stmt->rowCount();
                //if there's such ID show the form
            
                if($count>0)
                { ?>
                    <h1 class="text-center mt-3">Edit Member</h1>
                    <div class="form-container mt-4">
                        <form action="?do=update" method="POST">
                            <input type="hidden" name="userid" value="<?php echo $userid ?>"/>
                            <div class="row mb-3">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $member['username'] ?>"autocomplete="off"  required="required">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="newpassword" class="col-sm-2 col-form-label">Password</label>
                                <input type="hidden"name="oldpassword" value="<?php echo $member['password'] ?>">
                                <div  class="col-sm-10">
                                <input type="password" class="form-control" id="newpassword" name="newpassword" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div  class="col-sm-10">
                                <input type="email" class="form-control" id="email"name="email" value="<?php echo $member['email'] ?>" required="required">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="fullname" class="col-sm-2 col-form-label">Fullname</label>
                                <div  class="col-sm-10">
                                <input type="text" class="form-control" id="fullname" name="fullname"value="<?php echo $member['fullname'] ?>" required="required">
                                </div>
                            </div>
                        
                            <button type="submit" class="btn btn-primary">Save</button>
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
        elseif($do=='update') //update page
            {         
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    echo "<h1 class='text-center'>Update Member</h1>";
                    echo "<div class='container'>";
                    //get variable from the form
                    $id=$_POST['userid'];
                    $username=$_POST['username'];
                    $email=$_POST['email'];
                    $fullname=$_POST['fullname'];
                    //password trick
                    $pass=empty($_POST['newpassword'])?$_POST['oldpassword']:sha1($_POST['newpassword']);

                    //validate the form
                    $formErrors=array();
                    if(empty($username)){
                        $formErrors[]='Username Cant be Empty';
                    }
                    if(strlen($username)<4){
                        $formErrors[]='Username Cant Be Less Than 4';
                    }
                      if(strlen($username)>20){
                        $formErrors[]='Username Cant Be Less Grater Than 20 ';
                    }
                    if(empty($fullname)){
                        $formErrors[]='fullname Cant be Empty';
                    }
                    if(empty($email)){
                        $formErrors[]='Email Cant be Empty';
                    }
                    foreach($formErrors as $error){
                        echo '<div class="alert alert-danger">'. $error.'</div>';
                    }
                    //cheack if theres no error proccessed the update operation

                    if(empty($formErrors))
                    {
                        $stmt2=$con->prepare("SELECT * FROM users WHERE username=? AND userID !=?");
                        $stmt2->execute(array($username,$id));
                        $count=$stmt2->rowCount();
                        if($count ==1){
                            echo '<div class="alert alert-danger">Sorry This User is Exist</div>';
                        }
                        else{
                            $stmt=$con->prepare("UPDATE users SET username=?,email=?,fullname=?,password=? WHERE userID=?");
                            $stmt->execute(array($username,$email,$fullname,$pass,$id));

                            //success msg
                            $themsg= "<div class='alert alert-success'>" . $stmt->rowCount() .'Recourd Updated </div>';
                            RedirectHome($themsg,'back');
                        }
                    }
                 
                }
                else{
                    $themsg= '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                    RedirectHome($themsg);
                }
                echo "</div>";
            }
        elseif($do=='delete'){ //delete page
            //check if get request userid is numeric &get the integer value of it
                $userid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
                //get data from database depends on this ID
                $cheack=cheackItem('userid','users',$userid);
            
                if($cheack>0)
                {
                    echo "<h1 class='text-center'>Delete Members</h1>";
                    echo "<div class='container'>";
                    $stmt=$con->prepare('DELETE FROM users WHERE userID = :iuser');
                    $stmt->bindparam(":iuser",$userid);
                    $stmt->execute();
                    //success msg
                    $themsg= "<div class='alert alert-success'>" . $stmt->rowCount() .'Recourd Deleted </div>';
                    RedirectHome($themsg,'back');
                }else{
                        $themsg='<div class="alert alert-danger">Theres No such ID</div>';
                        RedirectHome($themsg,'back');
                 }
                 echo '</div>';
        }
        elseif($do=='activate')
        { //activate page
            $userid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
                //get data from database depends on this ID
                $cheack=cheackItem('userid','users',$userid);
            
                if($cheack>0)
                {   
                    echo "<h1 class='text-center'>Activate Members</h1>";
                    echo "<div class='container'>";
                    $stmt=$con->prepare('UPDATE users SET regStatus=1 WHERE userID = :iuser');
                    $stmt->bindparam(":iuser",$userid);
                    $stmt->execute();
                    //success msg
                    $themsg= "<div class='alert alert-success'>" . $stmt->rowCount() .'Recourd Activated </div>';
                    RedirectHome($themsg);
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
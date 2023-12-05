<!-- manage comments page
you can |edit |delete|Approve members from here-->

<?php
    session_start();
    
    if(isset($_SESSION['username']))
    {
        $pagetitle='Comments';
        include 'init.php';
        $do=isset($_GET['do'])?$_GET['do']:'Manage';

        //start manage page
        if($do=='Manage')   //manage page   
        {   
            //fetch users from database expext Admin
            $stmt=$con->prepare("SELECT comments.*,users.username,items.name
             FROM comments 
             INNER JOIN
             items
             ON 
             items.item_ID=comments.item_id
             INNER JOIN 
             users
             ON 
             users.userID=comments.user_id ORDER BY c_id DESC");
            $stmt->execute();
            $comments=$stmt->fetchAll();
            $count=1;
            if(!empty($comments)){
                ?>
                        
                        <h1 class="text-center mt-3">Manage Comments</h1>
                        <div class="container">
                        <table class="table ">
                        <thead class="table-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Comment Date</th>
                            
                            <th scope="col">Control</th>
                            </tr>
                        </thead>
                        <tbody>
                <?php
                                foreach($comments as $comment)
                                {
                                    echo "<tr>";
                                    echo "<td>".$count++."</td>";
                                    echo "<td>".$comment['comment']."</td>";
                                    echo "<td>".$comment['name']."</td>";
                                    echo "<td>".$comment['username']."</td>";
                                    echo "<td>".$comment['comment_date']."</td>";
                                
                                    echo "<td>
                                            <a href='comments.php?do=delete&comid=".$comment['c_id']."' class='btn btn-danger confirm'><i class='fa fa-trash'></i> Delete</a>
                                            <a href='comments.php?do=edit&comid=".$comment['c_id']."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a> ";
                                        if($comment['status']==0)
                                        {
                                                echo "<a href='comments.php?do=approve&comid=".$comment['c_id']."' class='btn btn-info'><i class='fa fa-check'></i> Approve</a> ";
                                        }
                                            
                                    echo"</td>" ;
                                    echo "</tr>";
                                }  
                ?>
                        </tbody>
                        </table>
                        </div>  
                <?php
            } 
            else
            {
                echo'<div class="container">';
                echo'<div class="nice-msg">There\'s No Comments</div>';
                echo'</div>';
            }
        }
        elseif($do=='edit')   //edit page
            { 
                
                //check if get request comid is numeric &get the integer value of it
                $comid=isset($_GET['comid']) && is_numeric($_GET['comid'])?intval($_GET['comid']):0;
                //get data from database depends on this ID
                $stmt = $con->prepare('SELECT * from comments WHERE c_id=? LIMIT 1');
                //execute query
                $stmt->execute(array($comid));
                //fetch data 
                $comment=$stmt->fetch();
                //the comment count
                $count=$stmt->rowCount();
                //if there's such ID show the form
            
                if($count>0)
                { ?>
                    <h1 class="text-center mt-3">Edit Comments</h1>
                    <div class="form-container mt-4">
                        <form action="?do=update" method="POST">
                            <input type="hidden" name="comid" value="<?php echo $comid ?>"/>
                            <div class="row mb-3">
                                <label for="Comment" class="col-sm-2 col-form-label">Comment</label>
                                <div  class="col-sm-10">
                                <textarea class="form-control" id="comment" name="comment"><?php echo $comment['comment']; ?></textarea>
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
                    echo "<h1 class='text-center'>Update Comments</h1>";
                    echo "<div class='container'>";
                    //get variable from the form
                    $id=$_POST['comid'];
                    $comment=$_POST['comment'];

                    $stmt=$con->prepare("UPDATE comments SET comment=? WHERE c_id=?");
                    $stmt->execute(array($comment,$id));

                    //success msg
                    $themsg= "<div class='alert alert-success'>" . $stmt->rowCount() .'Recourd Updated </div>';
                        RedirectHome($themsg,'back');
                
                 
                }
                else{
                    $themsg= '<div class="alert alert-danger">Sorry You Cant Bcommentse This Page Directly</div>';
                    RedirectHome($themsg);
                }
                echo "</div>";
            }
        elseif($do=='delete'){ //delete page
            //check if get request userid is numeric &get the integer value of it
                $comid=isset($_GET['comid']) && is_numeric($_GET['comid'])?intval($_GET['comid']):0;
                //get data from database depends on this ID
                $cheack=cheackItem('c_id','comments',$comid);
            
                if($cheack>0)
                {
                    echo "<h1 class='text-center'>Delete Comment</h1>";
                    echo "<div class='container'>";
                    $stmt=$con->prepare('DELETE FROM comments WHERE c_id = :id');
                    $stmt->bindparam(":id",$comid);
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
        elseif($do=='approve')
        { //activate page
            $comid=isset($_GET['comid']) && is_numeric($_GET['comid'])?intval($_GET['comid']):0;
                //get data from database depends on this ID
                $cheack=cheackItem('c_id','comments',$comid);
            
                if($cheack>0)
                {
                    echo "<h1 class='text-center'>Approve Comments</h1>";
                    echo "<div class='container'>";
                    $stmt=$con->prepare('UPDATE comments SET status=1 WHERE c_id = :id');
                    $stmt->bindparam(":id",$comid);
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
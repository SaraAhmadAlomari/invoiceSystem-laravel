
<?php
session_start();
$pagetitle='Item';
include 'init.php';
                //check if get request itemid is numeric && get the integer value of it
                $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
                //get data from database depends on this ID
                $stmt = $con->prepare('SELECT items.*,categories.name AS cat_name,users.username from items
                INNER JOIN categories
                on
                categories.ID=items.cat_ID
                INNER JOIN
                users 
                on
                users.userID=items.member_ID
                WHERE item_ID=?
                AND
                approve=1');
                //execute query
                $stmt->execute(array($itemid));
                $count=$stmt->rowCount();
                if($count>0){
                //fetch data 
                $item=$stmt->fetch();
    ?>
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-3">
                    <?php
                    if(empty($item['image'])){
                            echo"<img class='img-thumbnail center-block img-fluid' src='admin/uplodes/items/default.png'alt=''>";
                        }
                        else{
                        echo"<img class='img-thumbnail center-block img-fluid' src='admin/uplodes/items/".$item['image']."'alt=''>";}
                        ?>
                </div>
                <div class="col-md-9 item-info">
                    <h2><?php echo $item['name'] ?></h2>
                    <ul>
                        <li><?php echo $item['description'] ?></li>
                        <li><i class="fa fa-calendar "></i> <?php echo $item['add_data'] ?></li>
                        <li><i class="fa fa-money "></i> <span>Price:</span><?php echo $item['price'] ?></li>
                        <li><i class="fa fa-building "></i> <span>Made In: </span><?php echo $item['country_made'] ?></li>
                        <li><i class="fa fa-tags "></i> <span>Category: </span><a href="caregories.php?pageid=<?php echo $item['cat_ID']?>"><?php echo $item['cat_name'] ?></a></li>
                        <li><i class="fa fa-user "></i> <span>Added By:</span><?php echo $item['username'] ?></li>
                        <li class="tags-items"><i class="fa fa-user "></i> <span>Tags:</span>
                        <?php
                         $alltage=explode(",",$item['tags']);
                         foreach($alltage as  $tag){
                            $tag=str_replace(' ','',$tag);
                            $tag=strtolower($tag);
                            if($tag != '')
                            echo '<a href="tags.php?name='.$tag.'">'.$tag. '</a>';
                         }
                        ?>
                    </li>
                    </ul>
                </div>
            </div>
            <hr>
            <?php if(isset($_SESSION['name'])){ ?>
                <!-- start add comments -->
            <div class="row">
                <div class="col-md-9 offset-md-3">
                    <h1>Add Your Comment</h1>
                    <form action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$item['item_ID'] ?>" method="POST">
                        <textarea class="form-control " name="comment" id="" rows="5"></textarea>
                        <input type="submit" value="Add Comment" class="btn btn-primary block">
                    </form>
                    <?php 
                        if($_SERVER['REQUEST_METHOD']=='POST'){
                           $comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                            //$userid=$item['member_ID'];
                            $userid=$_SESSION['theid'];
                            $itemid=$item['item_ID'];
                           if(!empty($comment)){
                            $stmt=$con->prepare('INSERT INTO comments(comment,status,comment_date,item_id,user_id) 
                            values (:c,0,NOW(),:i,:u)');
                            $stmt->execute(array(
                                'c'=>$comment,
                                'i'=>$itemid,
                                'u'=>$userid
                            ));
                            if($stmt){
                                echo'<div class="alert alert-success mt-3">Comment Added</div>';
                            }
                           }
                        }
                    ?>
                </div>
            </div>
            <!-- end add comments -->
            <?php }else{
                echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> To Add Comments';
            }
            
            ?>
            <hr>
            <?php
                $stmt = $con->prepare('SELECT comments.*,users.username
                    AS member from comments
                INNER JOIN
                users 
                on
                users.userID=comments.user_id
                WHERE item_ID=?
                AND
                status=1
                order by c_id
                DESC');
                $stmt->execute(array($item['item_ID']));
                // get the active comments for this item from this user
                $comments=$stmt->fetchAll();
            ?>
                    <?php
                        foreach($comments as $comm){
                         echo '<div class="comment-box">';
                            echo '<div class="row">';
                            echo '<div class="col-sm-2 text-center">';
                                echo' <img class="img-thumbnail rounded-circle " src="1.png" alt=""/>';
                                echo '<div>'.$comm['member'].'</div>';
                            echo '</div>';
                            
                            echo '<div class="col-sm-10"><p class="lead">'.$comm['comment'].'</p></div>';
                            echo '</div>';
                         echo'</div>';
                         echo '<hr>';
                        }
                    ?>
                
            </div>
        
    <?php
    }
    else{

        echo '<div class="alert alert-danger">There\'s No Such ID or This Item Waiting Approval </div>';
    }


?>


<?php include 'includes/templete/footer.php';?>


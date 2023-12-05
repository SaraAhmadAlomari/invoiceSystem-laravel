
<?php
session_start();
$pagetitle='Profile';
include 'init.php';

if(isset($_SESSION['name'])){
    $getuser=$con->prepare("SELECT * FROM users WHERE username=?");
    $getuser->execute(array($sessionUser));
    $info=$getuser->fetch();

    ?>
        <h1 class="text-center">My Profile</h1>
        <div class="my-information block">
            <div class="container">
                <div class="card">
                                <div class="card-header">
                                My Information
                                </div>
                                <div class="card-body">
                                    <ul>
                                        <li>
                                            <i class="fa fa-unlock-alt fa-fw"></i>
                                            <span>Login Name:</span><?php echo $info['username'];?>
                                        </li>
                                        <li>
                                            <i class="fa fa-envelope-o fa-fw"></i>
                                            <span>Email:</span><?php   echo $info['email'] ; ?>
                                        </li>
                                        
                                        <li>
                                            <i class="fa fa-user fa-fw"></i>
                                            <span>Fullname:</span><?php  echo $info['fullname'];?>
                                        </li>
                                        
                                        <li>
                                            <i class="fa fa-calendar fa-fw"></i>
                                            <span>Date:</span><?php echo $info['RegDate']; ?>
                                        </li>
                                        
                                        <li>
                                        <i class="fa fa-tags fa-fw"></i>
                                        <span>Fav Category:</span><?php ?>
                                        </li>
                                    </ul>
                                    <a href="#" class="btn btn-primary mt-3">Edit Information</a>
                                </div>
                </div>
            </div>
        </div>
        <div class="my-ads block">
            <div class="container" id="my-ads">
                <div class="card card-primary">
                                <div class="card-header">
                                My Items
                                </div>
                                <div class="card-body">
                                    
                                        <?php 
                                        $myitem=GetAllFrom('*','items','WHERE member_id='.$info['userID'].'','','item_ID');
                                        if(!empty($myitem))
                                        {   
                                            echo '<div class="row">';
                                                foreach($myitem as $item){
                                                    echo '<div class="col-sm-6 col-md-3">';
                                                        echo '<div class="img-thumbnail item-box">';
                                                            if($item['approve']==0){
                                                                echo'<span class="approve_status">Waiting Approval</span>';
                                                            }
                                                            echo '<span class="price-tag">'.$item['price'].'</span>';
                                                            if(empty($item['image'])){
                                                                echo"<img src='admin/uplodes/items/default.png'alt=''>";
                                                            }
                                                            else{
                                                            echo"<img src='admin/uplodes/items/".$item['image']."'alt=''>";}
                                                            echo '<div class="caption">';
                                                                echo '<h3><a href="item.php?itemid='.$item['item_ID'].'">'.$item['name'].'</a></h3>';
                                                                echo '<p>'.$item['description'].'</p>';
                                                                echo '<p class="date">'.$item['add_data'].'</p>';
                                                            echo '</div>';
                                                        echo '</div>';
                                                    echo '</div>';
                                                }
                                            echo '</div>';
                                        }
                                        else{
                                            echo 'THere\'s No Ads To Show'.'<span><a href="newad.php">Add New Ad</a></span>';
                                        }
                                        ?>
                                </div>
                </div>
            </div>
        </div>
      
        <div class="my-comments block">
            <div class="container">
                <div class="card card-primary">
                                <div class="card-header">
                                My Comments
                                </div>
                                <div class="card-body">
                                <?php
                                $mycomments=GetAllFrom('comment','comments','WHERE user_id='.$info['userID'].'','','c_id');
                                   
                                    if(!empty($mycomments))
                                    {
                                        foreach($mycomments as $comment)
                                        echo '<p>'.$comment['comment'].'</p>';
                                        
                                    }
                                    else{
                                        echo '<p>There\'s No Comments To Show</p>';
                                    }
                                    
                                ?>
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


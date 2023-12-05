<?php


    session_start();
    if(isset($_SESSION['username'])){
    $pagetitle='Dashboard';
    include 'init.php';
    $numusers=5; //number of the latest users
    $Latestusers=getLatest("*","users","userID"); //latest users array
    $numitems=5; //number of the latest items
    $Latestitems=getLatest("*","items","item_ID"); //latest items   array
    $numcomments=5;

        // start dashboard body
        ?>
        <div class="container home-stats text-center">
            <div class="row">
                <h1>Dashboard</h1>
                <div class="col-md-3">
                       
                        <div  class="stat st-members">
                            <i class="fa fa-users"></i>
                             <div class="info">
                            Total Members
                            <a href="members.php"> <span><?php echo countItems("userID","users") ?></span></a> 
                            </div>
                        </div>

                    
                </div>
                 <div class="col-md-3">

                    <div class="stat st-pending">
                        <i class="fa fa-plus"></i>
                        <div class="info">
                            Pending Members
                            <a href="members.php?do=Manage&page=pending"><span><?php echo cheackItem('regStatus','users',0) ?></span></a>
                        </div>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="stat st-items">
                        <i class="fa fa-tag"></i>
                        <div class="info">
                            Total Items
                            <a href="items.php"> <span><?php echo countItems("item_ID","items") ?></span></a> 
                        </div>
                </div>
                </div>
                 <div class="col-md-3">
                    <div class="stat st-comments">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                            Total Comments
                            <a href="comments.php"> <span><?php echo countItems("c_id","comments") ?></span></a> 
                        </div>
                </div>
                </div>
            </div>
        </div>
        <div class="container latest">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-users"></i> Latest <?php echo $numusers ?> Registerd Users
                            <span class="toggle-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
                        </div>
                        <div class="card-body"> 
                            <ul class="list-unstyled latest-users">
                        <?php
                            if(!empty($Latestusers)){
                                foreach($Latestusers as $user)
                                {
                                    echo "<li>". $user['username'] .
                                    "<a href='members.php?do=edit&userid=".$user['userID']."'>";
                                        echo "<span class='btn btn-success pull-right'>";
                                                echo" <i class='fa fa-edit'>  Edit  </i>";
                                                if($user['regStatus']==0)
                                                {
                                                    echo "<a href='members.php?do=activate&userid=".$user['userID']."' class='btn btn-info pull-right'>
                                                    <i class='fa fa-check'></i>  Activate     </a> ";

                                                }
                                        echo "</span>";
                                    echo "</a>"; 
                                    echo "</li>";
                                }
                            }
                            else{
                                echo '<div class="">There\'s No Members</div>';
                            }
                        ?> 
                            </ul>
                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-tag"></i>  Latest <?php echo $numitems ?> Item
                            <span class="toggle-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
                        </div>
                        <div class="card-body">
                        <ul class="list-unstyled latest-users">
                        <?php
                            if(!empty($Latestitems)){
                                foreach($Latestitems as $item)
                                {
                                    echo "<li>". $item['name'] .
                                    "<a href='items.php?do=edit&userid=".$item['item_ID']."'>";
                                        echo "<span class='btn btn-success pull-right'>";
                                                echo" <i class='fa fa-edit'>  Edit  </i>";
                                                if($item['approve']==0)
                                                {
                                                    echo "<a href='items.php?do=Approve&itemid=".$item['item_ID']."' class='btn btn-info pull-right'>
                                                    <i class='fa fa-check'></i>  Approve     </a> ";

                                                }
                                        echo "</span>";
                                    echo "</a>"; 
                                    echo "</li>";
                                }
                            }
                            else{
                                echo '<div class="">There\'s No Items</div>';
                            }
                        ?>  
                        </ul>
                        </div>
                    </div>
                </div>
             </div>  <!-- end first row -->
            <div class="row mt-3">  
                <div class="col-sm-6">  <!-- start latest comment -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-comments-o"></i>  Latest <?php echo $numcomments ?> Comments
                            <span class="toggle-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
                        </div>
                        <div class="card-body">
                        <?php
                                $stmt=$con->prepare("SELECT comments.*,users.username AS member
                                FROM comments 
                                INNER JOIN 
                                users
                                ON 
                                users.userID=comments.user_id ORDER BY c_id DESC LIMIT $numcomments ");
                                $stmt->execute();
                                $comments=$stmt->fetchAll();
                                if(!empty($comments))
                                {
                                    foreach($comments as $comment)
                                    {
                                        echo '<div class="comment-box">';
                                        echo '<a href="comments.php?do=edit&comid='.$comment['c_id'].'"><span class="member-n">'.$comment['member'].'</span> </a>';
                                        echo '<p class="member-c">'.$comment['comment'].'</p>';
                                        echo '</div>';
                                    }
                                }
                                else
                                {
                                echo '<div class="">There\'s No Comments</div>';
                                }
                        ?>
                        </div>
                    </div>
                </div>
                <!-- End latest comment -->

            </div>  <!-- End secound row -->

        </div>
        <?php
        // end dashboard body
    }
    else{
        header('Location:index.php');
        exit();
    }
include 'includes/templete/footer.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php getTitle() ?></title>
    <link rel="stylesheet" href="layout/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="layout/css/font-awesome.min.css"/>
    <script src="layout/js/bootstrap.bundle.js"></script> 
    <link rel="stylesheet" href="layout/css/style.css"/>
   
</head>

<body class="body">
  
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class="collapse navbar-collapse" id="app-nav">
          <a href="index.php" class="navbar-brand">Home</a>
          <ul class="navbar-nav">
            <?php
            $allcats=GetAllFrom('*','categories','WHERE parent=0','','ID','ASC');
            foreach($allcats as $cat){
              echo'<li class="nav-item"><a class="nav-link " aria-current="page" href="caregories.php?pageid='.$cat['ID'].'">'.$cat['name'].'</a></li>';

            }
            ?>
          </ul>
          <div class="upper-bar ms-auto">
            <div class="container ">
              <?php
              
              if(isset($_SESSION['name']))
              {
                ?>
                  <div class="btn-group my-info">
                    <!-- <img class="rounded-circle " src="1.png" alt=""/> -->
                    <?php 
                    $avatar= GetAllFrom('*','users','WHERE userID='.$_SESSION['theid'].'','','userID'); 
                    foreach($avatar as $a){
                      $url= $a['avatar'];
                      if(empty($url)){
                        echo"<img src='admin/uplodes/avatars/profile.jpg'alt=''>";
                      }else{
                      ?>
                      <img class="rounded-circle " src="admin/uplodes/avatars/<?php echo $url; ?>" alt=""/>
                      <?php
                    }
                  }
                    ?>
                    <span class="nav-link dropdown-toggle span-name"role="button" data-bs-toggle="dropdown">
                      <?php echo $_SESSION['name'] ?>
                      <span class="caret"></span>
                    </span>
                    <ul class="dropdown-menu">
                      <li class="dropdown-item"><a href="profile.php">My Profile</a></li>
                      <li class="dropdown-item"><a href="newad.php">New Item</a></li>
                      <li class="dropdown-item"><a href="profile.php#my-ads">My Items</a></li>
                      <li class="dropdown-item"><a href="logout.php">Logout</a></li>
                    </ul>
                  </div>
                <?php
              }
              else
              {
                echo '<a href="login.php"><span class="pull-right">Login</span></a>';

              }
              ?>
            </div>
          </div>     
      </div>
  </div>
</nav>

</body>



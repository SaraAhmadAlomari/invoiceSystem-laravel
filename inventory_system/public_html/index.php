<?php
include_once("./database/constants.php");
if(isset($_SESSION["userid"])){
  header("location:".DOMAIN."/dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Managment System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./includes/style.css">
    <script src="./js/main.js"></script>
</head>
<body>
      <!-- Navbar -->
    <?php include_once("./templets/header.php");?>
    <div class="container mt-4">
      <?php
        if(isset($_REQUEST["msg"]) AND !empty($_GET["msg"])){
          ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_GET["msg"];?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <?php
        }
      ?>
      <div class="card mx-auto mt-30" style="width: 20rem;">
          <img src="./images/login.png" class="card-img-top mx-auto"style="width:50%" alt="Login Icon">
          <div class="card-body">
            <h2 class="card-title text-center">Log-In</h2>
            <form id="login_form" onsubmit="return false">
              <div class="form-group">
                <label for="log_email">Email address</label>
                <input type="email" class="form-control" id="log_email" name="log_email" palaceholder="Enter Email">
                <small id="e_error" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
              <div class="form-group">
                <label for="log_pass">Password</label>
                <input type="password" class="form-control" id="log_pass" name="log_pass">
                <small id="p_error" class="form-text text-muted"></small>
              </div>
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-lock"> &nbsp;</i>Login</button>
              <span> <a href="register.php">Register</a></span>
            </form>
          </div>
      </div>
    </div>
    
</body>
</html> 

<?php
include_once("./database/constants.php");
if(!isset($_SESSION["userid"])){
  header("location:".DOMAIN."/");
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
    <script src="./js/main.js"></script>
</head>
<body>
       <!-- Navbar -->
  <?php include_once("./templets/header.php");?>
  
<div class="container mt-5">
  <div class="row">
      <div class="col-md-4">
        <div class="card" >
          <img src="./images/user.png" class="card-img-top mx-auto"style="width:70%;" alt="Card image cap">
          <div class="card-body">
            <h4 class="card-title">Profile Information</h4>
            <p class="card-text"><i class="fa fa-user"></i> &nbsp;Sarah Alomari</p>
            <p class="card-text"><i class="fa fa-user"></i> &nbsp;Admin</p>
            <p class="card-text">Last login:xxxx-xx-xx</p>
            <a href="#"class="btn btn-primary"><i class="fa fa-edit">&nbsp;</i>Edit Profile</a>
          </div>
        </div>
      </div>
    <div class="col-md-8">
      <div class="jumbotron" style="width:100%; height:100%">
        <h1>Welcome Admin,</h1>
        <div class="row">
          <div class="col-sm-6">
            <iframe src="https://free.timeanddate.com/clock/i919wm1h/n3509/szw160/szh160/cf100/hnce1ead6"
            frameborder="0" width="160" height="160"></iframe>
          </div>
          <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">New Order</h5>
                <p class="card-text">Here  you can make invoices and create new orders</p>
                <a href="new_order.php" class="btn btn-primary">New order</a>
              </div>  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
   
<div class="container mt-3">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Categories</h5>
              <p class="card-text">Here you can manage your caregories and you can add new parent and sub categories</p>
              <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#category">Add </a>
              <a href="manage_categories.php" class="btn btn-primary">Manage </a>
            </div>  
          </div>
        </div>
        <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Brands</h5>
                <p class="card-text">Here you can manage your Brands and
                   you can add new Brands</p>
                <a href="#" class="btn btn-primary"  data-toggle="modal" data-target="#brands">Add </a>
                <a href="manage_brand.php" class="btn btn-primary">Manage </a>
              </div>  
            </div>
        </div>
       <div class="col-md-4">
          <div class="card">
               <div class="card-body">
                 <h5 class="card-title">Prodects</h5>
                 <p class="card-text">Here you can manage your
                    Prodects and you can add new Prodects</p>
                 <a href="#" class="btn btn-primary"  data-toggle="modal" data-target="#prodects">Add </a>
                 <a href="manage_prodect.php" class="btn btn-primary">Manage </a>
               </div>  
          </div>
        </div>
      </div>
</div> 
<?php
//category form
include_once("./templets/category.php");

//Brands form
include_once("./templets/brands.php");

//Prodects form
include_once("./templets/prodects.php");
?>

</body>
</html> 

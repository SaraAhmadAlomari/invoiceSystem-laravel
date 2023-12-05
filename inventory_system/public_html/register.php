
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
        <script type="text/javascript" src="./js/main.js"></script>
    </head>
    <body>
        <!-- Navbar -->
    <?php include_once("./templets/header.php");?>
    <br/> <br/>
        <div class="container">
            <div class="card mx-auto" style="width: 30rem;">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form id="register_form" onsubmit="return false" autocomplete="off">
                        <div class="form-group">
                            <label for="username">Full Name</label>
                            <input type="text" name="username" class="form-control" id="username" aria-describedby="emailHelp" 
                            placeholder="Enter username">
                            <small id="ur_error" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control"name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="e_error" class="form-text text-muted"></small>

                        </div>
                        <div class="form-group">
                            <label for="password1">Password</label>
                            <input type="password" class="form-control"name="password1" id="password1" placeholder="Enter password">
                            <small id="p1_error" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="password2">Re-enter Password</label>
                            <input type="password" class="form-control" name="password2"id="password2" placeholder="Re-enter password">
                            <small id="p2_error" class="form-text text-muted"></small>

                        </div>
                        <div class="form-group">
                            <label for="usertype">Usertype</label>
                            <select name="usertype" id="usertype"class="form-control">
                                <option value="">Choose User Type</option>
                                <option value="1">Admin</option>
                                <option value="0">Others</option>
                            </select>
                            <small id="type_error" class="form-text text-muted"></small>
                        </div>
                        <button type="submit" class="btn btn-primary"
                        name="user_register"><i class="fa fa-user">
                             &nbsp;</i>Register</button>
                             <span><a href="index.php">Login</a></span>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html> 

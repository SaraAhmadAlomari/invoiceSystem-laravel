
<?php
    session_start();
    $noNavbar='';
    $pagetitle='Login';
    if(isset($_SESSION['username'])){
    header('Location:dashboard.php');
    }
    include 'init.php';

    // cheack if user coming from http post request
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $username=$_POST['user'];
        $password=$_POST['password'];
        $hashpass=sha1($password);

        //cheack ifthe user exist in database
        $stmt =$con->prepare('SELECT userID , username , password from users WHERE username=? AND password=? AND groupID=1 LIMIT 1');
        $stmt->execute(array($username,$hashpass));
        $row=$stmt->fetch();
        $count=$stmt->rowCount();
        //ifcount >0 this database  contain record about this username
        if($count>0){
           $_SESSION['username']=$username; //register session name
           $_SESSION['ID']=$row['userID']; //register session ID
            header('Location:dashboard.php');
           exit();
        }
    }
    
?>
     <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="login">
        <h3 class="text-center">Admin Login</h3>
        <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
        <input class="form-control" type="password" name="password" id="password" placeholder="Password" autocomplete="new-password">
        <input type="submit" class="btn btn-primary btn-block" value="Login">
    </form>

<?php include 'includes/templete/footer.php'; ?>


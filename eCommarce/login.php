
<?php
 ob_start();
 session_start();
    $pagetitle='Login';
    if(isset($_SESSION['name']))
    {
    header('Location:index.php');
    }
    include 'init.php';
    if(isset($_POST['login-btn']))  //login script
    {
        // cheack if user coming from http post request
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $name=$_POST['username'];
            $password=$_POST['password'];
            $hashpass=sha1($password);

            //cheack ifthe user exist in database
            $stmt =$con->prepare('SELECT userID , username , password from users WHERE username=? AND password=?');
            $stmt->execute(array($name,$hashpass));
            $count=$stmt->rowCount();
            $get=$stmt->fetch();
            //ifcount >0 this database  contain record about this username
                if($count>0)
                {
                    $_SESSION['name']=$name; //register session name
                    $_SESSION['theid']=$get['userID'];
                    header('Location:index.php');
                    // print_r ($_SESSION);
                    exit();
                }
                else{
                   $errorLogInMsg='The Username or Password Is Incorrect';
                }
        
        }
    }
    elseif(isset($_POST['singup-btn']))
    { //sign up script
        $formError=array();
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $re_password=$_POST['re-password'];
        if(isset($username)){
            $filterduser=filter_var($username,FILTER_SANITIZE_STRING);
            if(strlen($filterduser)<4 ){
                $formError[]='The Username Must Be Larger Than 4 Characters';

            }
        }
        if(isset($email)){
            $filterdemail=filter_var($email,FILTER_SANITIZE_EMAIL);
            if(filter_var($filterdemail,FILTER_VALIDATE_EMAIL) !=TRUE ){
                $formError[]='The Email Is Not Valied';
            }
        }
        if(isset($password) && isset($re_password)){
            if(empty($password)){
                $formError[]='Password Can\'t Be Empty';
            }
            $pass1=sha1($password);
            $pass2=sha1($re_password);
            if($pass1 !==$pass2){
                $formError[]='The Password Is Not Match';

            }
        }
         //insert operation
                    if(empty($formError))
                    {
                        //cheack if username is already exist in database
                        $cheack=cheackItem("username","users",$username);
                        if($cheack == 1){
                            $formError[]='This Username Is Exist';
                        }
                        else
                        {
                                $stmt=$con->prepare('INSERT INTO users (username,password,email,regStatus,RegDate)
                                values (:user,:password,:email,0,now())');
                                $stmt->execute(array(
                                    'user'=>$username,
                                    'password'=>$pass1,
                                    'email'=>$email
                                ));

                                //success msg
                                $succesMsg = 'You Are Rregistered Now';
                        }
                    }
    }
?>

<div class="container">
    <!-- start log in form -->
    <div class="login-container mt-5">
        <h1 class="text-center pt-3">LOGIN</h1> 
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"class="login">
            <label>Username:</label>
            <input type="text" class="form-control" name="username" autocomplete="off">
            <label>Password</label>
            <input type="password" class="form-control" name="password" autocomplete="new-password">
            <input type="submit" class="btn btn-primary col-12" value="LOGIN" name="login-btn">
            <span>Dont have an account?<span class="reg-link fw-bold">Register here</span></span>
            <?php
                if(!empty($errorLogInMsg)){
                    echo '<div class="alert alert-danger mt-2">'.$errorLogInMsg.'</div>';
                }
            ?>
        </form>
      
    </div>
        <!-- end log in form -->
    <div class="signup-container mt-5">
        <!-- start register form -->
         <h1 class="text-center pt-3">SIGNUP</h1>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"class="signup">
            <label>Username:</label>
            <div class="input-container">
            <input type="text" class="form-control" name="username" autocomplete="off"  required="required">
            </div>

            <label>Email:</label>
            <div class="input-container">
            <input type="email" class="form-control" name="email"  required="required">
            </div>

            <label>Password</label>
            <div class="input-container">
            <input type="password" class="form-control" name="password" autocomplete="new-password"  required="required">
            </div>

            <label>Re-Password</label>
            <div class="input-container">
            <input type="password" class="form-control" name="re-password" autocomplete="new-password"  required="required">
            </div>

            <input type="submit" class="btn btn-success col-12" value="SIGNUP" name="singup-btn">
            <span>Already have account?<span class="login-link fw-bold">LOGIN</span></span>
        </form>
        <!-- end register form -->
    </div>
</div>

     <div class="msg-error text-center">
            <?php 
                if(!empty($formError))
                {
                    foreach($formError as $error)
                    {
                    echo '<div class="container w-50 mt-3">';
                    echo  '<div class="alert alert-danger">'.$error.'</div>';
                    echo '</div>';
                    }
                }
                if(isset($succesMsg)){
                    echo '<div class="container w-50 mt-3">';
                    echo  '<div class="alert alert-success">'.$succesMsg.'</div>';
                    echo '</div>';
                }
             ?>
        </div>

<?php include 'includes/templete/footer.php';

ob_flush();
?>


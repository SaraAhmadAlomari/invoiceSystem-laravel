<?php 
// user class for account creation and log in purpose
class User{
    private $con;
    function __construct()
    {
        include_once("../database/db.php");
        $db=new Database();
        $this->con=$db->connect();
      

    }
    //user is already registered or not
    private function emailExist($email){
      $pre_stmt=$this->con->prepare("SELECT id From user WHERE email = ?");
      $pre_stmt->bind_param("s",$email);
      $pre_stmt->execute() or die($this->con->error) ;
      $result=$pre_stmt->get_result();
      if($result->num_rows > 0){
        return 1;
      }
      else{
        return 0;
      }
    }
    public function createuserAccount($username,$email,$password,$usertype){
        //to protect your application from sql attack you can 
        //use prepares statment
        if($this->emailExist($email))
        {
            return "email_already_exists";
        }
        else
        {
            $pass_hash=password_hash($password,PASSWORD_BCRYPT,["cost"=>8]);
            $date=date("y-m-d");
            $notes="";
        $pre_stmt=$this->con->prepare("INSERT INTO `user`( `username`, `email`, `password`, `usertype`, `register_date`, `last_login`, `notes`) VALUES (?,?,?,?,?,?,?)");
        $pre_stmt->bind_param("sssssss",$username,$email,$pass_hash,$usertype,$date,$date,$notes);
        $result=$pre_stmt->execute() or die($this->con->error);
        if($result){
            return $this ->con->insert_id;
        }
        else{
            return "some_error";
        }
        }

    }
public function userLogin($email,$password)
{
    $pre_stmt=$this->con->prepare("SELECT id,username,password,last_login FROM user WHERE email = ?");
    $pre_stmt->bind_param("s",$email);
    $pre_stmt->execute() or die($this->con->error);
    $result=$pre_stmt->get_result();
    if($result->num_rows<1){
        return "Not_Registerd";
    }
    else{
        $row=$result->fetch_assoc();
        if(password_verify($password,$row["password"])){
            $_SESSION["userid"]=$row["id"];
            $_SESSION["username"]=$row["username"];
            $_SESSION["last_login"]=$row["last_login"];
            //here we are ipdating user last login time when he is performing login
            $last_login=date("Y-m-d h:m:s");
            $pre_stmt=$this->con->prepare("UPDATE user SET last_login=? WHERE email=?");
            $pre_stmt->bind_param("ss",$last_login,$email);
            $result=$pre_stmt->execute() or die($this->con->error);
            if($result){
                return 1;
                //echo $result;
            }
            else{
                return 0;
            }
        }
        else{
            return "password_not_matched";
        }
    }
}
}
// $user=new User();
// echo $user->createuserAccount("test","test99@gmail.com","bbb4444","Admin");
// echo $user->userLogin("test@gmail.com","bbb4444");
?>
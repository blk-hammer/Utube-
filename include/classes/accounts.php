<?php
require_once("include/config.php");
class Account{
    private $con;
    private $errorArray=array();

    public function __construct($con){
        $this->con=$con;
    }

    public function login($un,$ps){
        $ps=md5($ps);
        $q=mysqli_prepare($this->con,"SELECT * FROM users WHERE username=? AND password=?");
        mysqli_stmt_bind_param($q,"ss",$un,$ps);
        mysqli_stmt_execute($q);
        mysqli_stmt_store_result($q);
        if(mysqli_stmt_num_rows($q)==1)
            return true;
        else{
            array_push($this->errorArray,Message::$loginFailed);
            return false;
        }

    }

    public function register($fn,$ln,$un,$em,$p1,$p2){
        $this->validateName($fn);
        $this->validateName($ln);
        $this->validateUsername($un);
        $this->validateEmail($em);
        $this->validatePassword($p1,$p2);
        if(empty($this->errorArray)){
            return $this->insertUserDetails($fn,$ln,$un,$em,$p1);
        }
        else 
            return false;
    }

    public function insertUserDetails($fn,$ln,$un,$em,$p){
        $p=md5($p);
        $profilePic="assets/images/profilePictures/default.png";
        // $q=mysqli_stmt_init($this->con);
        $q=mysqli_prepare($this->con,"INSERT INTO users (fname,lname,username,email,password,profilePic) VALUES (?,?,?,?,?,?)");
        mysqli_stmt_bind_param($q, "ssssss" ,$fn,$ln,$un,$em,$p,$profilePic);
        return mysqli_stmt_execute($q);

    }
    private function validateName($fn){
        if(strlen($fn)>=25||strlen($fn)<=2){
            array_push($this->errorArray,Message::$fnCharacters);
        }
    }

    private function validateUsername($un){
        if(strlen($un)>=25||strlen($un)<=7){
            array_push($this->errorArray,Message::$unCharacters);
            return;
        }
        $q=mysqli_prepare($this->con,"SELECT username FROM users WHERE username=?");
        mysqli_stmt_bind_param($q, "s" ,$un);
        if(mysqli_stmt_execute($q)){
            mysqli_stmt_store_result($q);
            if(mysqli_stmt_num_rows($q)!=0){
                array_push($this->errorArray,Message::$unTaken);
            }
        }
    }

    private function validateEmail($em){
        if(!filter_var($em,FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray,Message::$emInvalid);
            return;
        }
        $q=mysqli_prepare($this->con,"SELECT email FROM users WHERE email=?");
        mysqli_stmt_bind_param($q, "s" ,$em);
        if(mysqli_stmt_execute($q)){
            mysqli_stmt_store_result($q);
            if(mysqli_stmt_num_rows($q)!=0){
                array_push($this->errorArray,Message::$emTaken);
            }
        }
    }

    private function validatePassword($p1,$p2){
        if($p1!=$p2){
            array_push($this->errorArray,Message::$pwDoNotMatch);
        }
        if(preg_match("/[^A-Za-z0-9]/", $p1)){
            array_push($this->errorArray,Message::$pwNotAlphaNumeric);
            return;
        }
        if(strlen($p1)>=25||strlen($p1)<=7){
            array_push($this->errorArray,Message::$pwLength);
            return;
        }
    }

    public function getError($error){
        if(in_array($error,$this->errorArray)){
            return "<span class='errorMessage'>$error</span>";
        }
    }
}

?>
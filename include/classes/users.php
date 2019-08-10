<?php
class User{
    private $con,$sqlData;

    public function __construct($con,$username){
        $this->con=$con;

        $q=mysqli_prepare($this->con,"SELECT * FROM users WHERE username=?");
        mysqli_stmt_bind_param($q,"s",$username);
        if(mysqli_stmt_execute($q)){
            $result=mysqli_stmt_get_result($q);
            mysqli_data_seek($result,0);
            $this->sqlData=mysqli_fetch_object($result);
        }
    }

    public function getUsername(){
        return $this->sqlData->username;
    }

    public function getName() {
        return $this->sqlData->firstName . " " . $this->sqlData->lastName;
    }

    public function getFirstName() {
        return $this->sqlData->firstName;
    }

    public function getLastName() {
        return $this->sqlData->lastName;
    }

    public function getEmail() {
        return $this->sqlData->email;
    }

    public function getProfilePic() {
        return $this->sqlData->profilePic;
    }

    public function getSignUpDate() {
        return $this->sqlData->signUpDate;
    }

    public static function isLoggedIn() {
        return isset($_SESSION["userLoggedIn"]);
    }

}
?>
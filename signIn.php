<?php 
require_once("include/config.php");
require_once("include/classes/accounts.php");
require_once("include/classes/errorMessages.php");
require_once("include/classes/formRegulator.php");

$account=new Account($conn1);

if(isset($_POST["submitButton"])){

    $username=FormRegulator::regulateUsername($_POST["username"]);
    $password=FormRegulator::regulatePassword($_POST["password"]);
    $successLogIn=$account->login($username,$password);
    if($successLogIn){
        // success
        $_SESSION["userLoggedIn"]=$username;
        header("Location:index.php");
    }
}

function retainInput($name){
    if(isset($_POST[$name])){
        echo $_POST[$name];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>VideoTube</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    
<link rel="stylesheet" type="text/css" href="assets/css/style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    
    <div class="signInContainer">
        <div class="column">
            <div class="header">
                <img src="assets/images/icons/VideoTubeLogo.png" title="logo" alt="Site logo" style="background-color:rgba(255,255,255,0.9);border-radius:5px;width:97px; height:25px">
                <h3>Sign In</h3>
                <span>to continue viewing videos on VideTube</span>
            </div>
            <div class="loginForm">
                <form action="signIn.php" method="POST">
                    <?php echo $account->getError(Message::$loginFailed)?>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username" value="<?php retainInput('username')?>"autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                    </div>
                    <button type="submit" name="submitButton" class="btn btn-danger">Submit</button>
                </form>
            </div>

            <a class="signUpMessage" href="signUp.php">New to VideoTube? Sign up here!</a>
        
        </div>

    </div>
</body>
</html>


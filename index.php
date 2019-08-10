<?php require_once("include/header.php")?>

<?php 
if(isset($_SESSION["userLoggedIn"]))
    echo "user logged in as ".$userLoggedInObj->getUsername();
else
    echo "no user log on";
?>
<?php require_once("include/footer.php")?>
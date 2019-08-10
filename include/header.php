<?php 
require_once("config.php");
require_once("classes/users.php");
require_once("classes/video.php");

$usernameLoggedIn=isset($_SESSION["userLoggedIn"])?$_SESSION["userLoggedIn"]:"";
$userLoggedInObj=new User($conn1,$usernameLoggedIn);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src="assets/js/commonActions.js"></script>
</head>

<body style="background-color:#000000;color:white">
    <nav class="navbar navbar-expand navbar-dark bg-dark">    
        <button id="sideNavButton" class="btn" style="margin-right:10px; background-color:transparent;">
            <img src="assets/images/icons/menu.png">
        </button>
        <a class="navbar-brand" href="index.php" id="logo">
            <img src="assets/images/icons/VideoTubeLogo.png" title="logo" alt="Site logo" style="width:97px; height:25px;background-color:rgba(255,255,255,0.9);border-radius:5px;">
        </a>
        <div style="margin:0 auto;">
            <form class="form-inline my-0">
                <input class="form-control mr-sm-1"id="searchBar" type="search" placeholder="Enter Text Here"  aria-label="Search">
                <button class="btn btn-danger" type="submit">Search</button>
            </form><ul class="navbar-nav mr-auto">
        </div>
        <a href="uploads.php" class="my-2 my-sm-0"><img src="assets/images/icons/upload.png" alt=""></a>
        <a href="signUp.php" class="my-2 my-sm-0"><img src="assets/images/profilepictures/default.png" style="margin-left:15px; width:30px; height:30px;"alt=""></a>
    </nav>
    <div id="sideNavContainer">
        SDgaslghsk
    </div>
    <div id="mainSectionContainer">
        <div id="mainContentContainer">

<?php
require_once("../include/config.php");
require_once("../include/classes/video.php");
require_once("../include/classes/users.php");

$username=$_SESSION["userLoggedIn"];
$videoId=$_POST["videoId"];

$userLoggedInObj=new User($conn1,$username);
$video= new Video($conn1,$videoId,$userLoggedInObj);

echo $video->like();
?>
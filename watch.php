<?php 
require_once("include/header.php"); 
require_once("include/classes/videoPlayer.php"); 
require_once("include/classes/videoInfoSection.php"); 

if(!isset($_GET["id"])) {
    echo "No url passed into page";
    exit();
}

$video = new Video($conn1, $_GET["id"], $userLoggedInObj);
$video->updateViews();
?>
<script src="assets/js/videoPlayerActions.js"></script>

<div class="watchLeftColumn">

<?php
    $videoPlayer = new VideoPlayer($video);
    echo $videoPlayer->create(true);

    $videoPlayer = new VideoInfoSection($conn1, $video, $userLoggedInObj);
    echo $videoPlayer->create();
?>


</div>

<div class="suggestions">

</div>




<?php require_once("include/footer.php"); ?>
                
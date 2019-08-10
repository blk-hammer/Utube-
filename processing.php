<?php 
require_once("include/header.php");
require_once("include/classes/videoUploadData.php");
require_once("include/classes/videoProcessor.php");

if(!isset($_POST["uploadBUtton"])){
}

$videoUploadData= new videoUploadData(
                    $_FILES["fileInput"],
                    $_POST["titleInput"],
                    $_POST["descriptionInput"],
                    $_POST["categoriesInput"],
                    $_POST["privacyInput"],
                    $userLoggedInObj->getUsername()
                );

$videoProcessor= new videoProcessor($conn1);
$success=$videoProcessor->upload($videoUploadData);

if($success){
    echo "upload succesful";
}
require_once("include/footer.php");
?>
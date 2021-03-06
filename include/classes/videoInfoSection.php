<?php
require_once("videoInfoControls.php");
class VideoInfoSection{
    private $con,$video,$userLoggedInObj;

    public function __construct($con,$video,$userLoggedInObj){
        $this->con=$con;
        $this->video=$video;
        $this->userLoggedInObj=$userLoggedInObj;
    } 

    public function create(){
        return $this->primaryInfo().$this->secondaryInfo();
    }

    private function primaryInfo(){
        $title=$this->video->getTitle();
        $views=$this->video->getViews();

        $videoInfoControls=new VideoInfoControls($this->video,$this->userLoggedInObj);
        $controls=$videoInfoControls->create();

        return "<div class='videoInfo'>
                <h1>$title</h1>
                <div class='bottomSection'>
                <span class='viewCount'>$views Views</span>
                $controls
                </div>
                </div>";
    }
    private function secondaryInfo(){
        $description=$this->video->getDescription();
        $uploadDate=$this->video->getUploadDate();
        $uploadedBy=$this->video->getUploadedBy();
        $profileButton=ButtonProvider::createUserProfileButton($this->con,$uploadedBy);

        if($uploadedBy==$this->userLoggedInObj->getUsername()){
            $actionButton=ButtonProvider::createVideoEditButton($this->video->getId());
        }
        else{
            $actionButton="";
        }

        return "<div class='secondaryInfo'>
                    <div class='topRow'>
                        $profileButton
                        <div class='uploadInfo'>
                            <span class='owner'>
                                <a href='profile.php?username=$uploadedBy'>
                                $uploadedBy
                            </span>
                            <span class='date'>
                                Published On $uploadDate
                            </span>
                        </div>
                        $actionButton
                    </div>

                </div>";
    }
}

?>
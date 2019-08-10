<?php
class Video {

    private $con, $sqlData, $userLoggedInObj;

    public function __construct($con, $input, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        if(is_array($input)) {
            $this->sqlData = $input;
        }
        else {
            $query ="SELECT * FROM videos WHERE id=$input";
            $result=mysqli_query($this->con,$query);
            $this->sqlData=mysqli_fetch_object($result);
        }
    }
    
    public function getId(){
        return $this->sqlData->id;
    }
    public function getUploadedBy(){
        return $this->sqlData->uploadedBy;
    }
    public function getTitle(){
        return $this->sqlData->title;
    }
    public function getDescription(){
        return $this->sqlData->description;
    }
    public function getPrivacy(){
        return $this->sqlData->privacy;
    }
    public function getFilePath(){
        return $this->sqlData->filePath;
    }
    public function getCategory(){
        return $this->sqlData->category;
    }
    public function getUploadDate(){
        $date=$this->sqlData->uploadDate;
        return date("M d Y",strtotime($date));
    }
    public function getViews(){
        return $this->sqlData->views;
    }
    public function getDuration(){
        return $this->sqlData->duration;
    }

    public function updateViews(){
        $id=mysqli_real_escape_string($this->con,$this->getId());
        $query="UPDATE videos SET views=views+1 WHERE id=$id";
        mysqli_query($this->con,$query);
        if(mysqli_affected_rows($this->con)==0)
            echo "views Updation failed";
        $this->sqlData->views+=1;
    }

    public function getLikes() {
        $videoId=$this->getId();
        $q="SELECT count(*) AS 'count' FROM likes WHERE videoId=$videoId";
        $result=mysqli_query($this->con,$q);
        $data=mysqli_fetch_assoc($result);
        return $data["count"];
    }

    public function getDislikes() {
        $videoId=$this->getId();
        $q="SELECT count(*) AS 'count' FROM dislikes WHERE videoId=$videoId";
        $result=mysqli_query($this->con,$q);
        $data=mysqli_fetch_assoc($result);
        return $data["count"];
    }

    public function like() {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        if($this->wasLikedBy()) {
            // User has already liked
            $q1="DELETE FROM likes WHERE username='$username' AND videoId='$id'";
            mysqli_query($this->con,$q1);

            $result = array(
                "likes" => -1,
                "dislikes" => 0
            );
            return json_encode($result);
        }
        else {
            $q1="DELETE FROM dislikes WHERE username='$username' AND videoId='$id'";
            mysqli_query($this->con,$q1);
            $count=mysqli_affected_rows($this->con);

            $q2="INSERT INTO likes(username,videoId) VALUES('$username','$id')";
            mysqli_query($this->con,$q2);

            $result = array(
                "likes" => 1,
                "dislikes" => 0 - $count
            );
            return json_encode($result);
        }
    }

    public function dislike() {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        if($this->wasDislikedBy()) {
            // User has already liked
            $q1="DELETE FROM dislikes WHERE username='$username' AND videoId='$id'";
            mysqli_query($this->con,$q1);

            $result = array(
                "likes" => 0,
                "dislikes" => -1
            );
            return json_encode($result);
        }
        else {
            $q1="DELETE FROM likes WHERE username='$username' AND videoId='$id'";
            mysqli_query($this->con,$q1);
            $count=mysqli_affected_rows($this->con);

            $q2="INSERT INTO dislikes(username,videoId) VALUES('$username','$id')";
            mysqli_query($this->con,$q2);

            $result = array(
                "likes" => 0 - $count,
                "dislikes" => 1
            );
            return json_encode($result);
        }
    }

    public function wasLikedBy() {
        $id=$this->getId();
        $username=$this->userLoggedInObj->getUsername();
        $q="SELECT * FROM likes WHERE username='$username' AND videoId='$id'";
        $result=mysqli_query($this->con,$q);
        return mysqli_num_rows($result)>0;
    }

    public function wasDislikedBy() {
        $id=$this->getId();
        $username=$this->userLoggedInObj->getUsername();
        $q="SELECT * FROM dislikes WHERE username = '$username' AND videoId = '$id'";
        $result=mysqli_query($this->con,$q);
        return mysqli_num_rows($result)>0;
    }

}
?>
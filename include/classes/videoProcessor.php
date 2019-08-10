<?php 

class videoProcessor{

    private $con;
    private $allowedType=array("mp4","flv","webm","mkv","vob","ogv","ogg","avi","wmv","mov","mpeg","mpg");
    private $sizelimit=500000000;
    private $ffmpegPath;
    private $ffprobePath;
    public function __construct($con){
        $this->con=$con;
        $this->ffmpegPath=realpath("ffmpeg/bin/ffmpeg.exe");
        $this->ffprobePath=realpath("ffmpeg/bin/ffprobe.exe");
    }

    public function upload($videoUploadData){
        $targetDir="uploads/videos/";
    // info about the file 
        $videoData=$videoUploadData->videoDataArray;
    // the temperary name  
        $tempFilePath=$targetDir.uniqid().basename($videoData["name"]);
        $tempFilePath=str_replace(" ","_",$tempFilePath);
    // checks for valid tyoe,size and any error
        $isValidData=$this->processData($videoData,$tempFilePath);
        if(!$isValidData){
            return false;
        }
    // checking if the file moved properly or not
        if(move_uploaded_file($videoData["tmp_name"],$tempFilePath)){
    // the new name of the file
            $finalFilePath=$targetDir.uniqid().".mp4";
    // inserts the data into table (phpmyadmin)
            if(!$this->insertVideoData($videoUploadData,$finalFilePath)){
                echo "insertion failed";
                return false;
            }
    // comment it if it takes lot of time for long file
            if(!$this->convertVideoToMp4($tempFilePath,$finalFilePath)){
                echo "upload failed";
                return false;
            }
    // deletes the original/temp file 
            if(!$this->deleteFile($tempFilePath)){
                return false;
            }
    // generates thumbnails and updates tables
            if(!$this->generateThumbnails($finalFilePath)){
                echo "couldnt generate thumbnails";
                return false;
            }
        }
        return true;
    }
    
    private function processData($videoData,$filePath){
        $videoType=pathinfo($filePath,PATHINFO_EXTENSION);
        
        if(!$this->isValidSize($videoData)){
            echo "file too large (".$videoData["size"]." B) Can't be more than ".$this->sizelimit ." Bytes<br>";
            return false; 
        }
        else if(!$this->isValidType($videoType)){
            echo "incorrect file type";
            return false;
        }
        else if($this->hasError($videoData)){
            echo "error code".$videoData["error"];
            return false;
        }
        return true;
    }

    private function isValidSize($data){
        return $data["size"]<= $this->sizelimit;
    }

    private function isValidType($data){
        $lowercased=strtolower($data);
        return in_array($lowercased,$this->allowedType);
    }

    private function hasError($data){
        return $data["error"]!=0;
    }

    private function insertVideoData($videoUploadData,$filePath){
    // creating the videos table
        $q1="CREATE TABLE IF NOT EXISTS videos(
            id int NOT NULL AUTO_INCREMENT,
            uploadedBy varchar(50),
            title varchar(70),
            description varchar(1000),
            privacy int,
            filePath varchar(250),
            uploadDate DATETIME DEFAULT CURRENT_TIMESTAMP,
            category int,
            views int NOT NULL DEFAULT 0,
            duration varchar(10),
            PRIMARY KEY (id),
            FOREIGN KEY (category) REFERENCES categories(id)
        )";
        if(mysqli_query($this->con,$q1)){
    // the insert query
            if($q2=mysqli_prepare($this->con, "INSERT INTO videos(title, uploadedBy, description, privacy, filePath, category) VALUES(?,?,?,?,?,?)")){
                mysqli_stmt_bind_param($q2, "sssisi" ,$videoUploadData->title,$videoUploadData->uploadedBy,$videoUploadData->description,$videoUploadData->privacy,$filePath,$videoUploadData->category);
                if(mysqli_stmt_execute($q2)){
                    $this->videoId=mysqli_insert_id($this->con);
                    return true;
                }   
                else{
                    return false;
                }
            }
            // else{
            //     echo "query not made";
            // }
        }
        // else{
        //     echo "table not created";
        // }
    }

    // converting into mp4
    public function convertVideoToMp4($tempFilePath,$filePath){
        $cmd="$this->ffmpegPath -i $tempFilePath $filePath 2>&1";
        $outputLog=array();
        exec($cmd,$outputLog,$returnCode);
        // checking the if and any errors
        if($returnCode!=0){
            foreach($outputLog as $line){
                echo $line."<br>";
            }
            return false;
        }
        return true;
    }

    private function deleteFile($filePath){
        if(!unlink($filePath)){
            echo "couldnt delete file";
            return false;
        }
        return true;
    }
    
    // creating the thumbnail table
    public function generateThumbnails($filePath){
    // creating table
        $q1="CREATE TABLE IF NOT EXISTS thumbnails(
            id int NOT NULL AUTO_INCREMENT,
            videoId int,
            filePath varchar(250),
            selected int,
        PRIMARY KEY (id),
        FOREIGN KEY (videoId) REFERENCES videos(id)
        )";

        if(mysqli_query($this->con,$q1)){
            $thumbnailSize="210x118";
            $numThumbnails=3;
            $thumbnailPath="uploads/videos/thumbnails";
    // gets duration of video
            $duration=$this->getVideoDuration($filePath);
            $duration=(int)$duration;
    // updating the table videos col[duration]
            $this->updateDuration($duration,$this->videoId);

            for($num=1;$num<=$numThumbnails;$num++){
                $imageName=uniqid().".jpg";
                $interval=($duration*0.8)/$numThumbnails*$num;
                $fullThumbnailPath="$thumbnailPath/$this->videoId-$imageName";
        // gets thumbnails at $interval of $thumbnailSize to $fullThumbnailPath
                $cmd="$this->ffmpegPath -i $filePath -an -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath 2>&1";
                $outputLog=array();
                exec($cmd,$outputLog,$returnCode);
                // checking code if and any errors
                if($returnCode!=0){
                    foreach($outputLog as $line){
                        echo $line."<br>";
                    }
                }
                $q2=mysqli_prepare($this->con,"INSERT INTO thumbnails(videoId,filePath,selected) VALUES(?,?,?)");
                mysqli_stmt_bind_param($q2,"isi",$this->videoId,$fullThumbnailPath,$selected);
                $selected= $num == 1? 1: 0;
                $success=mysqli_stmt_execute($q2);
                if(!$success){
                    echo "insertion into thumbnails table failed";
                    return false;
                }
                
            }
            return true;
        }
    }

    private function getVideoDuration($filePath){
        return shell_exec("$this->ffprobePath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");;
    }

    private function updateDuration($duration,$videoId){
        $hours=floor($duration/3600);
        $mins=floor(($duration-$hours*3600)/60);
        $secs=floor($duration % 60);

        $hours=$hours<1 ? "" : $hours.":";
        $mins=$mins<10 ? "0". $mins.":":$mins.":";
        $secs=$secs<10 ? "0". $secs.":":$secs;
        $duration=$hours.$mins.$secs;
    // updating the duration in videos table
        $q1=mysqli_prepare($this->con,"UPDATE videos SET duration=? WHERE id=?");
        mysqli_stmt_bind_param($q1, "si" ,$duration,$videoId);
        $success=mysqli_stmt_execute($q1);
        if(!$success)
            echo "update failed";
    }
}
?>
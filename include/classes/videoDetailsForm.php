<?php

class videoDetailsFormProvider{

    private $con;
    
    public function __construct($conn1){
        $this->con=$conn1;
    }
    public function createUploadForm(){
        $fileInput=$this->createFileInput();
        $titleInput=$this->createTitleInput();
        $descriptionInput=$this->createDescriptionInput();
        $categoriesInput=$this->createCategoriesInput();
        $privacyInput=$this->createPrivacyInput();
        $uploadButton=$this->createUploadButton();
        return "<form id='uploadForm' class='container' method='POST' enctype='multipart/form-data' action='processing.php' style='border-radius:10px;max-width:750px;background-color:rgba(10,10,10,0.7);padding-top:18px;padding-bottom:1px;margin-top:50px;'>
                    $fileInput
                    $titleInput
                    $descriptionInput
                    $categoriesInput
                    $privacyInput
                    $uploadButton
                </form>";
    }

    private function createFileInput(){
        return "<div class='form-group' style='padding-top:6px;'>
                    <input type='file' class='form-control' name='fileInput' style='color:rgba(255,255,255,0.7);border-color: #000000;background-color:rgba(10,10,10,0.7);' placeholder='Choose File' required>
                </div>";
    }

    private function createTitleInput(){
        return "<div class='form-group'>
                    <input type='text' class='form-control' name='titleInput' style='color:rgba(255,255,255,0.7);border-color: #000000;background-color:rgba(10,10,10,0.7);' required placeholder='Title'>
                </div>";
    }
    
    private function createDescriptionInput(){
        return "<div class='form-group'>
                    <textarea class='form-control' name='descriptionInput' rows='3' style='color:rgba(255,255,255,0.7);border-color: #000000;background-color:rgba(10,10,10,0.7);' placeholder='Description'></textarea>
                </div>";
    }

    private function createCategoriesInput(){
        echo "<div class='form-group'>";
        $query="SELECT * FROM categories";
        $html="<div class='form-group'>
                <label for='FormControlSelect2'>Type</label>
                <select class='form-control' name='categoriesInput' style='color:rgba(255,255,255,0.7);border-color: #000000;background-color:rgba(10,10,10,0.7);' id='FormControlSelect2'>";
        if($result=@mysqli_query($this->con,$query)){
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $name=$row["name"];
                    $id=$row["id"];
                    $html.="<option value='$id' style='color:rgba(255,255,255,0.7);'>$name</option>";
                }
                $html.="</select>
                </div>";    
            }
            else {
                echo "0 results";
            }
        }
        else{
            echo "couldn't retrieve values from table";
        }
        echo "</div>";
        return $html;
    }
    
    private function createPrivacyInput(){
        return "<div class='form-group' style='padding-bottom:6px;'>
                    <label for='FormControlSelect3'>Access</label>
                    <select class='form-control' name='privacyInput' style='color:rgba(255,255,255,0.7);border-color: #000000;background-color:rgba(10,10,10,0.7);'>
                        <option value='0' style='color:rgba(255,255,255,0.7);'>Private</option>
                        <option value='1' style='color:rgba(255,255,255,0.7);'>Public</option>
                    </select>
                </div>";
    }

    private function createUploadButton(){
      return  "<div class='form-group' style='padding-bottom:6px;'>
                    <button type='submit' class='btn btn-danger' name='uploadButton'>Submit</button>
                </div>";
    }
}

?>

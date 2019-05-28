<?php 

class videoDetailsFormProvider{

    public function createUploadForm(){
        $fileInput=createFileInput()
        return "<form class='container' method='POST' action='processing.php' style='max'>
                    $fileInput
                </form>";
    }

    private function createFileInput(){
        return "<div class='form-group'>
                    <input type='file' class='form-control' id='exampleFormControlSelect1' style='border:none;padding-left:0;' placeholder='Choose File' required>
                </div>";
    }

    private function createTitleInput(){
        return "<div class='form-group'>
                    <input type='text' class='form-control' id='FormControlText' placeholder='Title'>
                </div>";
    }
    
    private function createDescriptionInput(){
        return "<div class='form-group'>
                    <textarea class='form-control' id='FormControlTextarea1' rows='3' placeholder='Description'></textarea>
                </div>";
    }

    private function createTypeInput(){
        return "<div class='form-group'>
                    <label for='FormControlSelect2'>Type</label>
                    <select class='form-control' id='FormControlSelect2'>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>";
    }
    private function createAccessInput(){
        return "<div class='form-group'>
                    <label for='FormControlSelect3'>Access</label>
                    <select class='form-control' id='FormControlSelect3'>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
    }
}
?>

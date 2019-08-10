<?php
class FormRegulator{

    public static function regulateText($inputText){
        $inputText=strip_tags($inputText);
        $inputText=str_replace(" ","",$inputText);
        $inputText=strtolower($inputText);
        $inputText=ucfirst($inputText);
        return $inputText;
    }
    public static function regulateUsername($inputText){
        $inputText=strip_tags($inputText);
        $inputText=str_replace(" ","",$inputText);
        return $inputText;
    }
    public static function regulatePassword($inputText){
        $inputText=strip_tags($inputText);
        return $inputText;
    }
    public static function regulateEmail($inputText){
        $inputText=strip_tags($inputText);
        $inputText=str_replace(" ","",$inputText);
        return $inputText;
    }
}

?>
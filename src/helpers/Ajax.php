<?php

class Ajax {


    public static function checkIsAjax(){
        
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest")){
            return true;
        } else {
            echo "This request is not allowed";
            exit;
        }


    }



}

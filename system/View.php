<?php

class View {

    public function __construct(){

    }

    public function load($view, $data = array(), $returnContent=false){
        if(file_exists("src/views/".$view.".php")) {
            //extract data array of values if not empty
            if(!empty($data))
                extract($data);
            
            if(!$returnContent){
                require_once "src/views/header.php";
                require_once("src/views/".$view.".php");
                require_once "src/views/footer.php";
            } else {
                ob_start();
                include_once ("src/views/".$view.".php");
                return ob_get_clean();
            }

        }

    }



}

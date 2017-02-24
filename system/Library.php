<?php

class Library {

    public function __construct(){
        $this->model = new BaseModel;
    }

    public function load($classname){
        //load model
        $classpath = "src/libraries/".$classname.".php";

        //check if model exists
        if(file_exists($classpath)){
            require_once $classpath;
            $this->$classname = new $classname;

            return true;
        }

        return false;

    }

}

<?php

class Core {
    const DEFAULT_CONTROLLER = "home";
    const DEFAULT_METHOD = "index";

    public function __construct(){
        $url = $_SERVER['REQUEST_URI'];
        $url = rtrim($url);
        $url_data = explode("/", $url);
        if(!$url_data[1]) {
            $url_data[1] = self::DEFAULT_CONTROLLER;
            $url_data[2] = self::DEFAULT_METHOD;
        }

        $controller_path = "src/controllers/".ucfirst($url_data[1]).".php";
        if(file_exists($controller_path)){
            //controller
            require_once($controller_path);
            $controller = new $url_data[1];

            //method
            //check if method has query string
            if(strpos($url_data[2], "?") !== False)
                $method = strstr($url_data[2], "?", true);
            else
                $method = $url_data[2];

            if(method_exists($controller, $method))
                $controller->{$method}();


        } //else
            //echo "Controller does not exist!<br />";

    }




}

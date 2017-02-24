<?php

class Session {

    const SESSION_PREFIX = "dash_";

    public function __construct(){

    }

    public static function set($key, $value){
        $_SESSION[self::SESSION_PREFIX.$key] = $value;

    }

    public static function get($key){
        return (isset($_SESSION[self::SESSION_PREFIX.$key]))
                ? $_SESSION[self::SESSION_PREFIX.$key]
                : false;
    }

    public static function remove($key){
        if(isset($_SESSION[self::SESSION_PREFIX.$key]))
            unset($_SESSION[self::SESSION_PREFIX.$key]);

    }

}

<?php

spl_autoload_register(function($className){
// function __autoload($className){
	if(file_exists($className.".php")){
		require_once $className.".php";
		return true;
	}

	if(file_exists("src/controllers/".$className.".php")){
		require_once $className.".php";
		return true;
	}

	if(file_exists("src/libraries/".lcfirst($className).".php")){
		require_once "src/libraries/".lcfirst($className).".php";
		return true;
	}

	if(file_exists("src/helpers/".($className).".php")){
		require_once "src/helpers/".($className).".php";
		return true;
    }

	if(file_exists("system/".$className.".php")){
		require_once "system/".$className.".php";
		return true;
	}
});

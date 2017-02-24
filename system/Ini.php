<?php

class Ini{


	static function getConfig($string){
		$file = "SAMPLE.ini";

		$string_array = explode(".", $string);
		$parent = $string_array[0];
		$subname = $string_array[1];

		//get contents into string from file
		$content 		= file_get_contents($file, FILE_USE_INCLUDE_PATH);
		//search the parent category
		$search_start 	= strstr($content, "[".$parent."]");
		//search upto "["
		$search_last	= strstr($search_start, "[", true);

		if($search_last)
			$return_string = $search_last;
		else 
			$return_string = $search_start;

		//get subcategory
		$string_start	= strstr($return_string, $subname);
		$return_search	= strstr($string_start, "\n", true);
		$return_string = substr(strstr($return_search, "="), 1);
		
		return $return_string;
		
	}


}

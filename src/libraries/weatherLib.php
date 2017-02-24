<?php

class WeatherLib {


	public function __construct(){


	}


	public static function getWeatherData($days=false){
        $key = Ini::getConfig("home.openweather_key");

        $ch = curl_init();
        if($days)
            $url = "http://api.openweathermap.org/data/2.5/forecast?q=London,gb&units=metric&mode=json&appid=".$key;
        else
            $url = "http://api.openweathermap.org/data/2.5/weather?q=London,uk&units=metric&mode=json&appid=".$key;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
		$result = curl_exec($ch);
        curl_close($ch);
        return $result;

	}


    public static function weatherIcons(){
        return $iconTable = array (
                                '01d'=>'wi-day-sunny',
                                '02d'=>'wi-day-cloudy',
                                '03d'=>'wi-cloudy',
                                '04d'=>'wi-cloudy-windy',
                                '09d'=>'wi-showers',
                                '10d'=>'wi-rain',
                                '11d'=>'wi-thunderstorm',
                                '13d'=>'wi-snow',
                                '50d'=>'wi-fog',
                                '01n'=>'wi-night-clear',
                                '02n'=>'wi-night-cloudy',
                                '03n'=>'wi-night-cloudy',
                                '04n'=>'wi-night-cloudy',
                                '09n'=>'wi-night-showers',
                                '10n'=>'wi-night-rain',
                                '11n'=>'wi-night-thunderstorm',
                                '13n'=>'wi-night-snow',
                                '50n'=>'wi-night-alt-cloudy-windy'
                            );



    }


}

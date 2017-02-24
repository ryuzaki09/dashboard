<?php

class PlexLib extends Library {
    private $url;
    private $header_clientid;

    public function __construct(){
        parent::__construct();
        $this->url = null;
        $this->header_clientid = Ini::getConfig("homeweb.Client_id");
    } 

    public function getLatestSeries(){
        $url = "http://192.168.1.160:2020/plex/__getDetails";

        $headers = array("Content-type: application/json",
                        "Client-ID: ".$this->header_clientid);
        print_r($headers);
        $postfields = array("keyword" => "serverDetails");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
		$result = curl_exec($ch);
        curl_close($ch);
        print_r($result);

    }

    public function getRecentlyAdded(){
        $items = 10;

        $url = "http://192.168.1.201:32400/library/recentlyAdded?X-Plex-Container-Size=".$items."&X-Plex-Container-Start=0";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
		$result = curl_exec($ch);
        curl_close($ch);
        
		$xml = new SimpleXMLElement($result);
        // Logger::info("plex data: ".var_export($xml, true));
        if(!isset($xml->Directory))
            return false;

        $required = array("parentTitle", "title", "leafCount", "librarySectionTitle", "parentThumb");
        $directory = array();
        if (isset($xml->Directory))
            $directory = $this->buildData($xml->Directory, $required);

        $required = array("title", "year", "thumb");
        $video = array();
        if (isset($xml->Video))
            $video = $this->buildData($xml->Video, $required);

        return array_merge($directory, $video);
        // return $this->buildData($xml->Directory, $required);

    }


    private function buildData($xml, $required){
        
		$i=0;
		$result = array();
        foreach($xml AS $data):
            foreach($required AS $require):
                $result[$i][$require] = (string)$data->attributes()[$require];

            endforeach;
            
            $i++;

        endforeach; 

        return $result;

    }

}

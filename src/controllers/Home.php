<?php

class Home extends BaseController {

    private $calendar;
    private $client;

    const CALENDAR_ID = Ini::getConfig("email.address");

    public function __construct(){
        parent::__construct();

    }


    public function index(){
        $data = array();

        try {

            $this->memcache = new MemcacheLib;
            $data['photos'] = $this->memcache->getItem("photos");
            
            if(!$data['photos']) {
                Logger::info("no photos from memcache");
                $data['photos'] = $this->getFilesInLocation("/mnt/mediaserver/video/Dashboard/");
                $this->memcache->addItem("photos", $data['photos']);
                Logger::info("added photos to memcache: ".var_export($data['photos'], true));
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $data['gmaps_key'] = Ini::getConfig("home.google_maps_key");

        $this->view->load("dashboard", $data);

    }

    public function calendarCallback(){

        if(isset($_GET['code'])){
            Logger::info("callback called. code: ".$_GET['code']);

            $calendar = new CalendarLib;
            $client = $calendar->checkToken($_GET['code']);

            header("Location: http://dashboard.sinluong.com");
        }

    }

    public static function getIcon($key){
        $icons = weatherLib::weatherIcons();

        if(array_key_exists($key, $icons))
            return $icons[$key];
        
        return;
    }


    private function getFilesInLocation($location){

        $Files = array();
        if(is_dir($location)){
            if($dh = opendir($location)){
                while(($file = readdir($dh)) !== false)
                    $Files[] = "/photos/".$file;

                closedir($dh);
            }

        }
        array_shift($Files); //remove . file
        array_shift($Files); //remove .. file
        return $Files;
    }

    public function tester(){

        echo "this is a test";
        print_r($_GET);

    }


    public function getWeather(){
        Ajax::checkIsAjax();

        $weatherLib = WeatherLib::getWeatherData("5days");
        $data['weather'] = json_decode($weatherLib, true);

        $result['content'] = $this->view->load("data/weather", $data, true);
        echo json_encode($result);


    }

    public function getPlexRecentAdded(){
        Ajax::checkIsAjax();

        //PLEX DATA
        $this->library->load("plexLib");
        $data['plex_recent_data'] = $this->library->plexLib->getRecentlyAdded();
        // Logger::info("plex data: ".var_export($data['plex_recent_data'], true));

        $result['content'] = $this->view->load("data/plex", $data, true);
        echo json_encode($result);

    }


    public function getCalendarEvents(){
        Ajax::checkIsAjax();

        $this->memcache = new MemcacheLib;
        $result['content'] = $this->memcache->getItem("events");
        Logger::info("result: ".var_export($result, true));
        if($result['content']){
            $result['success'] = true;
            Logger::info("Got events from memcache");
            echo json_encode($result);
            exit;
        }

        $result = $this->getCalendarToken();
        
        if(!$result['token']){
            Logger::info("No token");

            $result['success'] = false;
            echo json_encode($result);

        } else {
            Logger::info("got access token");
            $calendar = new CalendarLib;
            $client = $calendar->setToken($result['token']);
 
            try {
                $service = new Google_Service_Calendar($client);
            } catch (Exception $e){
                Logger::error($e->getMessage());
            }
            $optParams = array(
                            "maxResults" => 10,
                            "orderBy" => "startTime",
                            "singleEvents" => TRUE,
                            "timeMin" => date("c"),
                            // "timeMin" => "2016-01-01T10:00:00Z",
                            "timeMax" => date("c", strtotime("+1 week")),
                            );
            Logger::info("getting events");
            $results = $service->events->listEvents(self::CALENDAR_ID, $optParams);
            $data['events'] = $results;
            // Logger::info("result: ".var_export($results, true));

            $result['content'] = $this->view->load("data/calendar", $data, true);
            $result['success'] = true;
            $this->memcache->addItem("events", $result['content']);
            echo json_encode($result);
        }

    }

    private function getCalendarToken(){

        //CALENDAR
        $this->model->load("usermodel");
        $result = $this->model->usermodel->getAccessToken();
        Logger::info("result: ".var_export($result, true));

        return $result;
    }

    public function newCalendarClient(){
        Logger::info("getting new calendar client");
        $calendar = new CalendarLib;
        $calendar->getClient();

    }

}

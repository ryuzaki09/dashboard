<?php

class CalendarLib extends Library {
    private $google;
    const REDIRECT_URI = "http://dashboard.sinluong.com/home/calendarCallback";

    public function __construct(){
        parent::__construct();
        $this->google = new Google_Client();
        $this->model->load("usermodel");

    }

    public static function getCalendarEvents(){
        $url = "https://accounts.google.com/o/oauth2/v2/auth";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPGET, true);
		$result = curl_exec($ch);
        curl_close($ch);
        return $result;

    }

    public function getClient(){
        $this->google->setApplicationName(APPLICATION_NAME);
        // $google->setScopes(SCOPES);
        // $google->setScopes(array("https://www.googleapis.com/calendar/v3/calendars/arlong2k8@gmail.com"));
        $this->google->setScopes(array("https://www.googleapis.com/auth/calendar.readonly"));
        $this->google->setAuthConfigFile(CLIENT_SECRET_PATH);
        $this->google->setRedirectUri(self::REDIRECT_URI);
        $this->google->setAccessType("offline");
        // $this->google->setApprovalPrompt("force");
        $authUrl = $this->google->createAuthUrl();
        header("Location: ".filter_var($authUrl, FILTER_SANITIZE_URL));
    }

    public function checkToken($authCode=false){
        $this->google->setApplicationName(APPLICATION_NAME);
        $this->google->setScopes(array("https://www.googleapis.com/auth/calendar.readonly"));
        $this->google->setAuthConfigFile(CLIENT_SECRET_PATH);
        $this->google->setRedirectUri(self::REDIRECT_URI);
        $this->google->setAccessType("offline");

        $accessToken = $this->google->authenticate($authCode);
        Logger::info("saving tokens");
        $this->model->usermodel->updateRefreshToken($this->google->getRefreshToken());
        // Session::set("calendar_token", $accessToken);
        $this->model->usermodel->updateAccessToken($accessToken);
            // Logger::info("refreshtoken: ".var_export($this->google->getRefreshToken(), true));
        // }
        return $this->google;
    }

    public function setToken($token){
        $this->google->setApplicationName(APPLICATION_NAME);
        $this->google->setScopes(array("https://www.googleapis.com/auth/calendar.readonly"));
        $this->google->setAuthConfigFile(CLIENT_SECRET_PATH);
        $this->google->setRedirectUri(self::REDIRECT_URI);
        $this->google->setAccessType("offline");

        $this->google->setAccessToken($token);
        
        if($this->google->isAccessTokenExpired()) {
            $result = $this->model->usermodel->getUserDetails();
            $refreshToken = false;
            if($result){
                Logger::info("result: ".var_export($result, true));
                $refreshToken = $result['token'];

            }
            $this->google->refreshToken($refreshToken);
            $this->model->usermodel->updateRefreshToken($this->google->getRefreshToken());
        }

        return $this->google;

    }

    public function checkAccessToken(){

        $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
        // error_log("credentials: ".var_export($credentialsPath, true));
        if(file_exists($credentialsPath)){
            $accessToken = file_get_contents($credentialsPath);
        } else {
            // $authUrl = $google->createAuthUrl();
            // error_log("auth: ".var_export($authUrl, true));
            // printf("open the following link in your browser:\n%s\n", $authUrl);
            // print "enter verification code: ";
            // $authCode = trim(fgets(STDIN));
            $authCode = Ini::getConfig("google.authcode");

            $accessToken = $google->authenticate($authCode);

            if(!file_exists(dirname($credentialsPath)))
                mkdir(dirname($credentialsPath), 0700, true);

            file_put_contents($credentialsPath, $accessToken);
            printf("Credentials saved to %s\n", $credentialsPath);

        }
        $google->setAccessToken($accessToken);

        if($google->isAccessTokenExpired()){
            $google->refreshToken($google->getRefreshToken());
            file_put_contents($credentialsPath, $google->getAccessToken());
        }
        return $google;
 
    }


    private function expandHomeDirectory($path){
        $homeDirectory = getenv("HOME");
        if(empty($homeDirectory))
            $homeDirectory = getenv("HOMEDRIVE").getenv("HOMEPATH");

        return str_replace("~", realpath($homeDirectory), $path);

    }

    public function getEvents($calendarId){
        
        $url = "https://www.googleapis.com/calendar/v3/calendars/".$calendarId."/events";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($this->CI->ch, CURLOPT_POSTFIELDS, http_build_query($postfields)); 
		$result = curl_exec($ch);
        curl_close($ch);
        return $result;


    }

}

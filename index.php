<?php

require_once 'vendor/autoload.php';

define("APPLICATION_NAME", "raspbian");
define("CREDENTIALS_PATH", "~/.credentials/calendar-php-quickstart.json");
define("CLIENT_SECRET_PATH", __DIR__."/client_secret.json");
define("SCOPES", implode(" ", array(Google_Service_Calendar::CALENDAR_READONLY)));


$base = new Core;


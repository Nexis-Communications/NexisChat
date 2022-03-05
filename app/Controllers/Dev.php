<?php

namespace App\Controllers;
use CodeIgniter\I18n\Time;

class Dev extends BaseController
{

    function __construct() 
    {
        $this->config = new \stdClass();
        $this->uri = service('uri');

    }
    public function index()
    {

        $tz = Time::now()->getTimezone();
        $tz = Time::now()->timezone;
        
        
        echo $tz->getName();
        //echo $tz->getOffset();

        $db = db_connect();
        echo "<pre>";

        print_r($db->query("show tables from ". $db->database));
        echo "</pre>";

        print_r(phpinfo());

    }
}

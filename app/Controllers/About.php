<?php

namespace App\Controllers;

class About extends BaseController
{

    function __construct() 
    {
        $this->config = new \stdClass();
        $this->uri = service('uri');

    }
    public function index()
    {

        $auth = service('authentication');
        $data['loggedin'] = $auth->check();

        $this->config->pageTitle = 'About';

        $data['config'] = $this->config;
        return view('pages/about',$data);
    }
}

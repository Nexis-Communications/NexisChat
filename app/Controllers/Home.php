<?php

namespace App\Controllers;

class Home extends BaseController
{

    function __construct() 
    {
        $this->config = new \stdClass();
        $this->uri = service('uri');

    }
    public function index()
    {

        //dd($this->uri->getPath());

        $auth = service('authentication');
        $data['loggedin'] = $auth->check();

        $this->config->pageTitle = '';

        $data['config'] = $this->config;
        //dd($data);
        return view('pages/home',$data);
    }
}

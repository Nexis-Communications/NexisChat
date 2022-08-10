<?php

namespace App\Controllers;

class Test extends BaseController
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

        dd("TPC: Test");

        return true;

    }
}

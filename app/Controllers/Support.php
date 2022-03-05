<?php

namespace App\Controllers;

class Support extends BaseController
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

        $this->config->pageTitle = 'Support';

        $data['config'] = $this->config;
        //dd($data);
        return view('pages/support',$data);

    }

    public function ticket($ticket)
    {

        $ticketThread = getTicket($ticket);

        $threadData = json_decode($ticketThread);

        print_r($threadData);

        if ($threadData->status == 'Success') {

            $data['count'] = count($threadData->data->tickets);

           // print_r($data);

        }

    }
}

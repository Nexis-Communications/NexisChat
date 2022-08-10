<?php

namespace App\Controllers;

class Settings extends BaseController
{

    use \Myth\Auth\AuthTrait;

    function __construct() 
    {
        $this->restrict( base_url('login') );
        $this->config = new \stdClass();
        $this->uri = service('uri');
        $this->auth = service('authentication');

    }

    public function index()
    {

        return redirect()->to('/settings/profile');
    }

    public function profile()
    {
        //d($this);

        $this->config->siteName = 'The Park Chat';
        $this->config->pageTitle = 'Settings & Privacy';
        $data['user'] = $this->auth->user();

        $data['config'] = $this->config;
        $data['theme'] = 'corona';
        $data['layout'] = 'layout/'.$data['theme'].'/layout';
        $data['sidebar'] = 'settings';
        return view('pages/settings/profile',$data);

    }

    public function privacy()
    {
        //d($this);

        $this->config->siteName = 'The Park Chat';
        $this->config->pageTitle = 'Settings & Privacy';
        $data['user'] = $this->auth->user();

        $data['config'] = $this->config;
        $data['theme'] = 'corona';
        $data['layout'] = 'layout/'.$data['theme'].'/layout';
        $data['sidebar'] = 'settings/privacy';
        return view('pages/settings/privacy',$data);

    }

    public function blocking()
    {
        //d($this);

        $this->config->siteName = 'The Park Chat';
        $this->config->pageTitle = 'Blocking';
        $data['user'] = $this->auth->user();

        $data['config'] = $this->config;
        $data['theme'] = 'corona';
        $data['layout'] = 'layout/'.$data['theme'].'/layout';
        $data['sidebar'] = 'settings/privacy';
        return view('pages/settings/blocking',$data);

    }
}

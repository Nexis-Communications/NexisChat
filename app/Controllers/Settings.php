<?php

namespace App\Controllers;

use App\Models\IgnoredModel;
use App\Models\BlockedModel;

class Settings extends BaseController
{

    use \Myth\Auth\AuthTrait;

    function __construct() 
    {
        $this->restrict( base_url('login') );
        $this->config = new \stdClass();
        $this->uri = service('uri');
        $this->auth = service('authentication');
        $this->ignoredModel = new IgnoredModel();
        $this->blockedModel = new BlockedModel();


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
        //if ( $this->request->getMethod() == 'GET') {
            //dd($this->request->getVar());
        //}

        $this->config->siteName = 'The Park Chat';
        $this->config->pageTitle = 'Blocking';
        $data['user'] = $this->auth->user();

        $data['config'] = $this->config;
        $data['theme'] = 'corona';
        $data['layout'] = 'layout/'.$data['theme'].'/layout';
        $data['sidebar'] = 'settings/privacy';

        $data['ignoredUsers'] = $this->ignoredModel->select()->where('uid',$data['user']->id)->find();
        $data['blockedUsers'] = $this->blockedModel->select()->where('uid',$data['user']->id)->find();
            //d($data);
        return view('pages/settings/blocking',$data);

    }

    public function blockingUpdate($type,$action,$id)
    {
        d($type,$action,$id);

        switch ($type) {
            case "ignored":
                    $model = $this->ignoredModel;
                break;
            case "blocked":
                    $model = $this->blockedModel;
                break;
            default:
                return redirect()->back()->with('error','invalid method');
        }

        switch ($action) {
            case "add":
                d('add');
                break;
            case "delete":
                if ($model->where('uid',$this->auth->user()->id)->delete($id)) {
                    return redirect()->back()->with('message','Successfully unignored user.');
                }
                break;
            default:
                return redirect()->back()->with('error','invalid action');
        }



        //if ( $this->request->getMethod() == 'GET') {
            //dd($this->request->getVar());
        //}

    }
}

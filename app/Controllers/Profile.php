<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use App\Models\MessagesModel;
use App\Models\User;
use App\Models\HandleModel;

class Profile extends BaseController
{

    use \Myth\Auth\AuthTrait;

    function __construct() 
    {
        $this->config = new \stdClass();
        $this->uri = service('uri');
        $this->auth = service('authentication');
        $this->messagesModel = new MessagesModel();
        $this->userModel = new User();
        $this->handleModel = new HandleModel();


    }
    public function index()
    {

        $this->restrict( base_url('login') );
        $auth = service('authentication');
        $data['loggedin'] = $auth->check();

        $this->config->pageTitle = 'Profile';

        $data['config'] = $this->config;
        $data['user'] = $this->auth->user();

        $data['tags'] = json_decode(getTags($this->auth->user()->id));

        d($data['tagsearchresults'] = ($data['tags']) ? $this->searchTags($data['tags']) :NULL);
        
        //print_r($data['tags']);

        return view('profile/index',$data);
    }

    public function update() 
    {
        $this->restrict( base_url('login') );
        $request = service('request');
        $userModel = model('App\Models\UserModel');

        if ($requestData = $request->getPost()) {

            //print_r($requestData);

            $data['user'] = $this->auth->user();

            if ($data['user']->username != $requestData['username']) {
                if(usernameLookup($requestData['username'])) {
                    return redirect()->back()->with('error', "Username in use.");
                } else {
                    
                    $updateData['username'] = $requestData['username'];
                   
                    if ($userModel->update($data['user']->id,$updateData)) {
                        //return redirect()->back()->with('message', "Username updated.");
                    } else {
                        //dd($userModel->errors());
                        //dd($userModel);
                        return redirect()->back()->with('error', "Error updating username. " . $userModel->errors()['username']);
                    }
                }
            }
            if ($data['user']->email != $requestData['email']) {
                if(emailLookup($requestData['email'])) {
                    return redirect()->back()->with('error', "Email in use.");
                } else {
                    
                    $updateData['email'] = $requestData['email'];
                   
                    if ($userModel->update($data['user']->id,$updateData)) {
                       // return redirect()->back()->with('message', "Email updated.");
                    } else {
                        //dd($userModel->errors());
                        //dd($userModel);
                        return redirect()->back()->with('error', "Error updating email. " . $userModel->errors()['email']);
                    }
                }

            }
            //echo "\n";
            //print_r($data['user']);

        }

        return redirect()->back()->with('message', "Profile updated");
    }

    public function tags()
    {

        $this->restrict( base_url('login') );
        $auth = service('authentication');
        $auth->check();
        $data['id'] = $this->auth->user()->id;

        $request = service('request');
        if ($requestData = $request->getPost()) {
            if ($requestData['tags']) {
                //d($requestData['tags']);
                foreach ($requestData['tags'] as $tag) {
                    if (strlen($tag) < 3) {
                        //dd($tag);

                        return redirect()->back()->with('error', 'Tags must be at least 3 characters long.');
                    }
                }
               // dd();
                $tagsModel = model('App\Models\TagsModel');

                $jsonTags = json_encode(array_values(array_filter($requestData['tags'])));

                $data['tags'] = $jsonTags;

                if ($tagsModel->save($data)) {
                    $message = "Tags Updated.";
                    return redirect()->back()->with('message', $message);
                }

                return redirect()->back()->with('error', 'Keywords not updated.');

            }
            //print_r($requestData);
        }
        return redirect()->back()->with('error', "no keywords updated");

    }

    private function searchTags($tags) {

        //d($tags);
        $results = null;

        $searchModels = array('messages'=>'data','user'=>array('username','email'),'handle'=>'handle');

        foreach ($searchModels as $model=>$fields) {
            switch ($model) {
                case 'messages':
                    $modelSelect = ['rcpt','data','location'];
                    $modelClass = 'messagesModel';
                    break;
                case 'user':
                    $modelSelect = ['username','email'];
                    $modelClass = 'userModel';
                    break;
                case 'handle':
                    $modelSelect = ['handle'];
                    $modelClass = 'handleModel';
                    break;
                default:
                    //dd($results);
                    break;
            }
            $builder = $this->$modelClass->builder();

            $builder->select();
            switch ($model) {
                case 'messages':
                    $builder->where('rcpt',0);
                    $builder->where('uid !=',$this->auth->user()->id);
                    break;

            }
            $builder->groupStart();
            foreach ($tags as $tag) {
                if (is_array($fields)) {
                    foreach ($fields as $field) {
                        $builder->orLike($field,$tag);
                    }
                } else {
                    $builder->orLike($fields,$tag);
                }

            }
            $builder->groupEnd();
            //d($builder->getCompiledSelect());
            $results[$model] = $builder->get()->getResultObject();
            //d($results,$builder);

        }

        return $results;

    }

}

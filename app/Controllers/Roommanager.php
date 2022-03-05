<?php

namespace App\Controllers;


class Roommanager extends BaseController
{

    use \Myth\Auth\AuthTrait;

    function __construct() 
    {

        $this->restrictToGroups('admin', site_url('login') );
        $this->auth = service('authentication');

        $this->config = new \stdClass();
        $this->uri = service('uri');

    }
    public function index()
    {
        return redirect()->to('/admin/roommanager');
    }

    public function addgroup()
    {
        if ($this->request->getMethod() == "post") {

            $groupModel = model('App\Models\RoomGroupModel');

            $data['name'] = $this->request->getVar('group');
            $data['alias'] = $this->request->getVar('alias');
            $data['active'] = 1;

            if ($data['name'] && $data['alias']) {
                if ($groupModel->save($data)) {
                    return redirect()->back()->with('message', "Successfully added group " . $data['name']);
                } else {
                    return redirect()->back()->with('error', "Error adding group. " . $groupModel->errors());
                }
            } else {
                return redirect()->back()->with('error', "Malformed Data. Data missing.");
            }
        } else {
            return redirect()->back()->with('error', "Malformed Data. Data missing.");
        }
    }

    public function addroom()
    {
        if ($this->request->getMethod() == "post") {

            $roomModel = model('App\Models\RoomModel');
            $rgxrefModel = model('App\Models\RoomGroupXrefModel');

            $data['name'] = $this->request->getVar('room');
            $data['alias'] = $this->request->getVar('alias');
            $data['group'] = $this->request->getVar('group');
            $data['active'] = 1;
            $data['private'] = 0;

            if ($data['name'] && $data['alias']) {
                if ($roomModel->save($data)) {
                    $rid = $roomModel->getInsertID();
                    if ($rgxrefModel->save(['rid'=>$rid,'gid'=>$data['group']])) {
                        return redirect()->back()->with('message', "Successfully added room " . $data['name']);
                    } else {
                        return redirect()->back()->with('error', "Error adding room to group. " . $rgxrefModel->errors());
                    }
                } else {
                    return redirect()->back()->with('error', "Error adding room. " . $roomModel->errors());
                }
            } else {
                return redirect()->back()->with('error', "Malformed Data. Data missing.");
            }
        } else {
            return redirect()->back()->with('error', "Malformed Data. Data missing.");
        }
    }

    public function edit($id) {
        $roomModel = model('App\Models\RoomModel');
        $groupModel = model('App\Models\RoomGroupModel');
        $rgxrefModel = model('App\Models\RoomGroupXrefModel');

        if ($this->request->getMethod() == "get") {

            $data['user'] = $this->auth->user();
            $data['pageTitle'] = 'Room Editor';
            $data['room'] = $roomModel->select()->find($id);
            $data['room']['groups'] = $rgxrefModel->select()->where('rid',$id)->findAll();
        
            return view('admin/room/edit',$data);
        } else {
            //print_r("update");
            //print_r($id);

            $data['name'] = $this->request->getVar('name');
            $data['alias'] = $this->request->getVar('alias');
            $data['group'] = $this->request->getVar('group');
            $data['private'] = ($this->request->getVar('private') == 'on') ? 1:0;
            $data['active'] = ($this->request->getVar('active') == 'on') ? 1:0;

            if ($roomModel->update($id,$data)) {
                //print_r("Room Updated.\n");
            } else {
                return redirect()->back()->with('error', "Error updating room. " . $roomModel->errors());
            }

            if ($currentGroups = $rgxrefModel->select()->where('rid',$id)->findAll()) {
                //print_r($currentGroups);
                foreach ($currentGroups as $currentGroup) {
                    $rgxrefModel->delete($currentGroup->id);
                }
            }
            if ($rgxrefModel->save(['rid'=>$id,'gid'=>$data['group']])) {
                //print_r("Groups Saved.\n");
            }

            return redirect()->back()->with('message', "Successfully update room.");

            //print_r($data);


        }

    }
}

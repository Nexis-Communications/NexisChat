<?php

namespace App\Controllers;

class Admin extends BaseController
{

    use \Myth\Auth\AuthTrait;


    public function __construct() 
	{
		$this->restrict( base_url('login') );
        // Restrict to Admins and Moderators..
        $this->restrictToGroups(['admin', 'ranger'], site_url('login') );
        //$this->current_user = $auth->user();
        $this->auth = service('authentication');
        
       
	}

    public function index()
    {
        //dd($this->auth->user());

        $data['user'] = $this->auth->user();
        $data['pageTitle'] = 'Administration';
        

        return view('admin/index',$data);
    }



    public function flagged()
    {

        $flaggedModel = model('App\Models\FlaggedModel');

        $data['flaggedMessages'] = $flaggedModel->select('messages_flags.id, users.username as sus_user, messages.user as sus_handle, messages.room as sus_rid, rooms.name as sus_room, messages.data as sus_message, messages_flags.uid as rpid, rpuser.username as rp_user, messages_flags.created_at as rt')->join('messages','messages.id = messages_flags.mid','left')->join('users','users.id = messages.uid','left')->join('users as rpuser','rpuser.id = messages_flags.uid','left')->join('rooms','rooms.id = messages.room','left')->find();
        
        //dd($data);
        $data['user'] = $this->auth->user();
        $data['pageTitle'] = 'Flagged Messages';

        return view('admin/flagged',$data);
    }

	public function shortcuts()
    {
        $data['user'] = $this->auth->user();
        $data['pageTitle'] = 'Shortcuts';
    
    	return view('admin/shortcuts',$data);
    
    }

	public function roommanager()
    {
        
    	$data['user'] = $this->auth->user();
        $data['pageTitle'] = 'Room Manager';
    
        $roomModel = model('App\Models\RoomModel');
        $groupModel = model('App\Models\RoomGroupModel');
        $roomusersModel = model('App\Models\RoomUsersModel');
        $rgxrefModel = model('App\Models\RoomGroupXrefModel');

		$data['rooms'] = $roomModel->asObject()->select()->findAll(); // Using asObject
        //print_r($data['rooms']);
        foreach ($data['rooms'] as $_roomKey => $room) {

            // New function getRoomUserCount(int $id, int $type = null)
            // Bool int $type 1 returns userlist, 0 returns count.
            $data['rooms'][$_roomKey]->currentusers = $roomusersModel->select('users.id , users.username')->join('users','room_users.uid = users.id','left')->where('rid',$room->id)->orderby('users.username','asc')->findAll(); // Returns userlist with id and username ( handle?). Should probably use helper function for this. 
            
            $data['rooms'][$_roomKey]->roomgroups = json_encode($rgxrefModel->select('gid')->where('rid',$room->id)->findAll());
            
        }
        //print_r($data['rooms']);

		$data['groups'] = $groupModel->select()->findAll();
        
    
    	return view('admin/roommanager',$data);
    }
    
	public function usermanager()
    {
        
    	$data['user'] = $this->auth->user();
        $data['pageTitle'] = 'User Manager';
    
            $userModel = model('App\Models\UserModel');

		$data['users'] = $userModel->select()->findAll();
    
    	return view('admin/usermanager',$data);
    }

    public function contact()
    {
        
    	$data['user'] = $this->auth->user();
        $data['pageTitle'] = 'Contact Manager';
    
            $contactModel = model('App\Models\ContactModel');

		$data['contacts'] = $contactModel->select()->findAll();
    
    	return view('admin/contacts',$data);
    }

    public function alerts()
    {
        
    	$data['user'] = $this->auth->user();
        $data['pageTitle'] = 'Alerts';
    
        $flaggedModel = model('App\Models\FlaggedModel');
        $messagesModel = model('App\Models\MessagesModel');

		$data['flagged'] = $flaggedModel->select()->findAll();
    
    	return view('admin/alerts',$data);
    }

    public function dashboard()
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'Dashboard';

        $data['user'] = $this->auth->user();

        return view('admin/dashboard/dashboard',$data);
    }

    public function dashboardrooms()
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'Rooms';

        $data['user'] = $this->auth->user();
        $data['plugins'] = ['datatable'];

        $roomModel = model('App\Models\RoomModel');
        $data['rooms'] = $roomModel->asObject()->findAll();

        return view('admin/dashboard/rooms',$data);
    }

    public function dashboardroomview($id)
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'View Room';

        $data['user'] = $this->auth->user();
        $data['plugins'] = ['datatable'];

        $roomModel = model('App\Models\RoomModel');

        $data['room'] = $roomModel->asObject()->find($id);

        //dd($data);

        return view('admin/dashboard/rooms/view',$data);
    }

    public function dashboardusers()
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'Users';

        $data['user'] = $this->auth->user();
        $data['plugins'] = ['datatable'];

        $userModel = model('App\Models\UserModel');
        $data['users'] = $userModel->asObject()->findAll();

        return view('admin/dashboard/users',$data);
    }

    public function dashboarduserview($id)
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'View User';

        $data['user'] = $this->auth->user();
        $data['plugins'] = ['datatable'];

        $userModel = model('App\Models\UserModel');

        $data['user'] = $userModel->asObject()->find($id);

        //dd($data);

        return view('admin/dashboard/users/view',$data);
    }

    public function dashboardusergroups()
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'User Groups';

        $data['user'] = $this->auth->user();
        $data['plugins'] = ['datatable'];

        $groupsModel = model('App\Models\GroupsModel');
        $data['groups'] = $groupsModel->asObject()->findAll();

        return view('admin/dashboard/usergroups',$data);
    }

    public function dashboardusergroupview($id)
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'View User Group';

        $data['user'] = $this->auth->user();
        $data['plugins'] = ['datatable'];

        $groupsModel = model('App\Models\GroupsModel');
        $xrefModel = model('App\Models\UserGroupModel');
        $userModel = model('App\Models\UserModel');


        $data['group'] = $groupsModel->asObject()->find($id);

        $data['users'] = $xrefModel->where('group_id',$id)->find();

        foreach ($data['users'] as $k=>$user) {
            //print_r($user);
            $data['users'][$k]['detail'] = $userModel->asObject()->find($user['user_id']);
        }

        $data['count'] = count($data['users']);

        //print_r($data);
        //dd($data);

        return view('admin/dashboard/users/groups/view',$data);
    }

    public function ajax($plugin = NULL)
    {

        if ($this->request->getMethod() == "get") {

            //print_r("test");

            $roomModel = model('App\Models\RoomModel');

            $rooms = $roomModel->asObject()->findAll();

            foreach ($rooms as $room) {
                $output[] = array(
                    'id'    => $room->id,
                    'Name'  => $room->name,
                    'Status'    => $room->active,
                );
            }
            header("Content-Type: application/json");
            echo json_encode($output);
        }
        //return view('admin/dashboard/plugins/jsgrid/dynamicjs');

    }

}

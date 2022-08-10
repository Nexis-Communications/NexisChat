<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use App\Models\UserGroupModel;
use App\Models\GroupsModel;
use App\Models\RoomUsersModel;
use App\Models\MessagesModel;
use App\Models\FlaggedModel;
use App\Models\MoodModel;
use App\Models\GenderModel;
use App\Models\ChatpicsKeywordsModel;

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
        
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();

        $this->userGroupModel = new UserGroupModel(); // xref
        $this->userGroupsModel = new GroupsModel(); // available user groups
        $this->userActionModel = new RoomUsersModel(); // available user groups
        $this->messagesModel = new MessagesModel(); // available user groups
        $this->flaggedModel = new FlaggedModel(); // available user groups
        $this->moodModel = new MoodModel(); // available user groups
        $this->genderModel = new GenderModel(); // available user groups
        $this->chatpicKeywordsModel = new ChatpicsKeywordsModel(); // available user groups

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

        $data['userStats'] = $this->getUserStats($id);
        //dd($data);
        $userModel = model('App\Models\UserModel');

        $data['userData'] = $userModel->asObject()->find($id);
        $data['groups'] = getUserGroups($id);
        $data['groupsHtml'] = getUserGroups($id,1);

        //dd($data);

        return view('admin/dashboard/users/view',$data);
    }

    public function dashboarduseredit($id)
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'Edit User';

        $data['user'] = $this->auth->user();
        $data['plugins'] = ['datatable'];

        $userModel = model('App\Models\UserModel');

        $data['user'] = $userModel->asObject()->find($id);
        $data['groups'] = getUserGroups($id);

        $data['groupsAvailable'] = $this->userGroupsModel->orderBy('description','ASC')->find();
        //dd($data);

        return view('admin/dashboard/users/edit',$data);
    }

    public function dashboardusersave($id)
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'Edit User';

        $data['user'] = $this->auth->user();

        if ($this->request->getMethod() == "post") {
            $groups = $this->request->getPost('groups') ?? NULL;

            if ($groups) {
            //d($this->request,$id,$this->request->getPost('groups'));

                $previousGroups = $this->userGroupModel->where('user_id',$id)->find();

                // Delete user from all groups
                $this->userGroupModel->where('user_id',$id)->delete();
                
                foreach ($groups as $group) {
                    if ($this->userGroupModel->insert(['user_id'=>$id,'group_id'=>$group])) {
                        // added user to group.
                    } else {
                        dd($previousGroups);
                    }
                    
                }
            }

            return redirect()->to('/admin/dashboard/user/view/'.$id)->with('message','Successfully updated user.');

        }

        return redirect()->back()->withInput()->with('errors','Invalid Method');

        
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

    public function removeUsersGroup($id) {

        //d($this->session);
        d($id);
        if (! is_numeric($id)) {
        }

        if ($usergroups = $this->userGroupModel->select()->where('user_id',$id)->findAll()) {
            d($usergroups);
            if (count($usergroups) <= 1 ) {
                d('user must be in at least one group');
                //return redirect()->back()->withInput()->with('errors','This user is only a member of a single group.');
            } else {
                foreach ($usergroups as $group) {
                    if ($group->id == 1) {
                        d('cannot remove user from default group');
                        next;
                    } else {
                        d('remove user from group');
                    }
                }
            }
        }

        dd();
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

    private function getUserStats($id) {

        $userActivity = $this->userActionModel->where('uid',$id)->withDeleted()->asObject()->find();
        //d($this->userActionModel->allowedFields);

        //$statsArray = ['actions',]
        foreach ($this->userActionModel->allowedFields as $column) {
            $data['actions'][$column] = NULL;
        }

        foreach ($userActivity as $action) {

            foreach ($action as $key=>$value) {
                switch ($key) {
                    default: // haha, is switch() even needed?
                        $data['actions'][$key][$value] =  ($data['actions'][$key][$value] ?? 0) + 1;
                        break;

                }
            }
           // d($action);
        

        }

        $userMessages = $this->messagesModel->where('uid',$id)->withDeleted()->asObject()->find();

        foreach ($this->messagesModel->allowedFields as $column) {
            $data['messages'][$column] = NULL;
        }

        $data['messages']['total'] = count($userMessages);

        foreach ($userMessages as $message) {
            foreach ($message as $key=>$value) {
                switch ($key) {
                    case "data":
                    case "id":
                    case "created_at":
                    case "updated_at":
                    case "deleted_at":
                    //case "location":
                            $data['messages'][$key][] = $value;
                        break;
                    case "mood":
                        if (is_numeric($value)) {
                            $value = $this->moodModel->first($value)->description;
                        }        
                    case "gender":
                        if (is_numeric($value)) {
                            $value = $this->genderModel->first($value)->description;
                        }  
                    default:
                        $data['messages'][$key][$value] =  ($data['messages'][$key][$value] ?? 0) + 1;
                        break;
                }

            }
            //d($message);
        }

        $data['roomsVisited'] = isset($data['actions']['rid']) ? count($data['actions']['rid']):0;
        $data['nicksUsed'] = isset($data['messages']['user']) ? count($data['messages']['user']):0;
        $data['messagesSent'] = isset($data['messages']['data']) ? count($data['messages']['data']):0;
        $data['messagesPrivate'] = 0;
        $data['chatpicsUsed'] = 0;

        // Private Stats
        if ($rcpts = $data['messages']['rcpt']) {
            
            unset($rcpts[0]);
            unset($rcpts[$this->auth->user()->id]);
            //dd($rcpts);
            foreach ($rcpts as $rcpt=>$count) {
                $data['messagesPrivate'] = $data['messagesPrivate'] + $count;
            }
        }

        // Chatpics Used
        if ($chtpcs = $data['messages']['chatpic']) { 
            unset($chtpcs['']);
            $data['chatpicsUsed'] = count($data['messages']['chatpic']);
        }

        //d($data);

        //d($userActivity);

        return $data;

    }

    public function messageManager($room = NULL)
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'Message Manager';

        $data['user'] = $this->auth->user();
        $data['plugins'] = ['datatable'];

        $data['room'] = $room;
        
        $builder = $this->flaggedModel;
        if ($room) {
           $builder = $builder->join('messages','messages_flags.mid = messages.id','left');
           $builder = $builder->where('messages.room',$room);
        }
        $data['flagged'] =  $builder->findAll();

        $builder = $this->messagesModel;
        $data['messages'] =  $builder->limit(10)->orderBy('id','desc')->find();

        //dd($data['flagged']);


        return view('admin/dashboard/messagemanager',$data);
    }

    public function messageview($id=NULL)
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'Message Viewer';

        $data['user'] = $this->auth->user();
        $data['plugins'] = ['datatable'];

        if ($id) {

            $data['message'] = $this->messagesModel->find($id);

            if ($data['message']) {
                return view('admin/dashboard/messageviewer',$data);
            } else {
                return redirect()->back()->withInput()->with('errors','Message Not Found.');
            }

        }

        if ($this->request->getMethod() == "post") {
            //d($this->request,$id,$this->request->getPost('mid'));

            $data['message'] = $this->messagesModel->find($this->request->getPost('mid'));

            return view('admin/dashboard/messageviewer',$data);

        }

        return redirect()->back()->withInput()->with('errors','Invalid Request Method.');
    }

    public function flagDelete($flag)
    {

        if ($flag) {
            if ($this->flaggedModel->delete($flag)) {
                return redirect()->back()->withInput()->with('message','Successfully deleted flagged message.');
            } {
                return redirect()->back()->withInput()->with('errors','Error deleting flagged message.');
            }
        }
        return redirect()->back()->withInput()->with('errors','Invalid Request');

    }
    
    public function chatpicManager()
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'Chatpic Manager';

        $data['user'] = $this->auth->user();
        $data['plugins'] = ['datatable'];


        return view('admin/dashboard/chatpicmanager',$data);
    }

    public function chatpicManagerGroups()
    {
        $data['siteName'] = 'The Park Chat';
        $data['pageTitle'] = 'Chatpic Group Manager';

        $data['user'] = $this->auth->user();
        $data['plugins'] = ['datatable'];

        $model = $this->chatpicKeywordsModel;

        $data['groups'] = $model->find();


        return view('admin/dashboard/pages/chatpics/groups',$data);
    }

    public function chatpics($type = NULL, $action = NULL, $id = NULL) {

        d($type,$action,$id);

        if (!$id)  { return redirect()->back()->withInput()->with('errors','Invalid ID'); }
        if (!is_numeric($id)) { return redirect()->back()->withInput()->with('errors','Invalid ID'); }

        switch ($type) {
            case 'group':
                $model = $this->chatpicKeywordsModel;
                break;
            default:
                $model = NULL;
                break;

        }

        if (!$model)  { return redirect()->back()->withInput()->with('errors','Invalid Request'); }

        switch ($action) {
            case 'view':
                
                break;
            case 'delete':

                break;
            case 'edit':

                break;
        }

        if (!$action) { return redirect()->back()->withInput()->with('errors','Invalid Action'); }

        return "passed";

    }

    public function messageSend($messageId = NULL) 
    {

        $data['user'] = $this->auth->user();

        if ($this->request->getMethod() == "post") {
            if ($messageData = $this->request->getPost() ?? NULL) {

                $data['uid'] = $messageData['uid'] ?? NULL;
                $data['user'] = $messageData['user'] ?? NULL;
                $data['room'] = $messageData['room'] ?? NULL;
                $data['source'] = $this->request->getIPAddress() ?? NULL;
                switch ($messageData['to']) {
                    case 1:
                        $data['rcpt'] = messageLookup($messageId)->uid ?? NULL;
                        break;
                    case 2:
                        $data['rcpt'] = 0;
                        break;
                    case 3:
                        $data['rcpt'] = 0;
                        break;

                }
                $data['rcpt_handle'] = messageLookup($messageId)->user ?? NULL;
                $data['location'] = $messageData['location'] ?? NULL;
                $data['gender'] = 0;
                $data['mood'] = 0;
                $data['data'] = $messageData['message'] ?? NULL;
                $data['chatpic'] = $messageData['chatpic'] ?? NULL;

                foreach ($data as $field) {
                    if (is_null($field)) {
                        return redirect()->back()->withInput()->with('errors','Incomplete Data');
                    }
                }

                if ($model = $this->messagesModel) {
                    //dd($messageData);
                    if ($messageData['to'] == 2) {
                        $data['data'] = $data['rcpt_handle'] . ": " . $data['data'];
                    }

                    if ($model->save($data)) {
                        return redirect()->to('/admin/dashboard/messages/')->with('message','Message successfully sent.');
                    }


                } 

            }
        } else {
            return redirect()->back()->withInput()->with('errors','Invalid Method');
        }


        dd();
    }



}

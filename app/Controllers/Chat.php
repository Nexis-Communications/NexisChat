<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use App\Models\RoomUsersModel;
use App\Models\RoomModel;
use App\Models\GenderModel;
use App\Models\MoodModel;
use App\Models\HandleModel;
use Myth\Auth\Models\UserModel;
use App\Models\MessagesModel;
use App\Models\IgnoredModel;
use App\Models\FlaggedModel;
use App\Models\SystemSettingsModel;

class Chat extends BaseController
{

    use \Myth\Auth\AuthTrait;
	
	public function __construct() 
	{
        
        // Loading Models
        $this->genderModel = new GenderModel();
        $this->moodModel = new MoodModel();
        $this->userModel = new UserModel(); 
        $this->handleModel = new HandleModel();
        $this->messagesModel = new MessagesModel();
        $this->ignoredModel = new IgnoredModel();
        $this->flaggedModel = new FlaggedModel();
        $this->actionModel = new RoomUsersModel(); 
        $this->roomModel = new RoomModel();
        $this->systemSettingsModel = new SystemSettingsModel();



		$this->restrict( base_url('login') );
        $this->auth = service('authentication');
        $this->authorize = service('authorization');
        $this->data = new \stdClass();
        $this->data->settings = $this->getSystemSettings();
        $this->data->config = new \stdClass();
        $this->data->log = new \stdClass();
        $this->data->models = new \stdClass();
        $this->data->room = new \stdClass();
        $this->data->status = new \stdClass();
        $this->data->options = new \stdClass();
        $this->data->genders = $this->getGenders();
        $this->data->moods = $this->getMoods();
        $this->data->messages = new \stdClass();

	}

    public function leave($alias) 
    {

        //$roomModel = new RoomModel();
       // $actionModel = new RoomUsersModel(); 
        
        $this->data->user = $this->auth->user();
        $this->data->room->details = $this->roomModel->where('alias',$alias)->first();
        $this->data->status->action = -1;
        if ($lastLog = $this->actionModel->where(['uid'=>$this->data->user->id,'rid'=>$this->data->room->details->id])->first()) {
            
            $this->data->messages->last = $lastLog['lastmessage'];
        }

        if ($this->data->log = $this->actionModel->where(['uid'=>$this->data->user->id,'rid'=>$this->data->room->details->id])->findAll() ) {

            if (!$this->logAction('0x4C4F','logout')) {
                throw new \Exception("Unable to remove user from chat.");
            }

            return redirect()->to('/');
        } else {
            return redirect()->back()->withInput()->with('errors','Unable to logout user');
        }

    }

    public function leaveprivate($alias) 
    {

        //$roomModel = new RoomModel();
       // $actionModel = new RoomUsersModel(); 
        
        $this->data->user = $this->auth->user();
        $this->data->room->details = $this->roomModel->where('alias',$alias)->first();
        $this->data->status->action = -1;
        if ($lastLog = $this->actionModel->where(['uid'=>$this->data->user->id,'rid'=>$this->data->room->details->id])->first()) {
            
            $this->data->messages->last = $lastLog['lastmessage'];
        } else {
            return redirect()-to('/');
        }

        if ($this->data->log = $this->actionModel->where(['uid'=>$this->data->user->id,'rid'=>$this->data->room->details->id])->findAll() ) {
            $lastRoom = getLastPublicRoom($this->data->user->id);
            //d(getRoomInfo($lastRoom['rid'])->alias);
            return redirect()->to('/chat/' . getRoomInfo($lastRoom['rid'])->alias);
        } else {
            return redirect()-to('/');
        }

    }

    public function index($alias) // $alias is the alias for the room. Calling the chat controller directly without a room specified will redirect to the home page using the router.
    {
        $session = \Config\Services::session();

        // Load System Settings
        //$this->data->settings = getSystemSettings();

        //$roomusersModel = new RoomUsersModel(); 
        //$roomModel = new RoomModel();

        $this->data->user = $this->auth->user();
        $this->data->room->details = $this->roomModel->where('alias',$alias)->first();

        // get users last logout entry to get last read message.
        if ($lastLog = $this->actionModel->where(['uid'=>$this->data->user->id,'rid'=>$this->data->room->details->id])->withDeleted()->orderBy('id','desc')->first()) {
            $this->data->messages->last = $lastLog['lastmessage'];
        }


        // Login Check
        if (!($this->data->log = $this->actionModel->where(['uid'=>$this->data->user->id,'rid'=>$this->data->room->details->id])->find())) { // Check if user doesn't an active log entry for current room.

            // Login User
            if ($this->loginUser()) { // Log the user into the room.

                return redirect()->to('chat/'.$alias)->with('data', $this->data); // Redirect user back to chat room. With an active log entry, this will not run next time.
            } else {
                throw new \Exception("Unable to login user.");
            }
        }
        // End Login
        
        $this->data->config->pageTitle = $this->data->room->details->name;
        $this->data->request = $this->request;
        $this->data->vip = $this->authorize->inGroup([2,3,4,7], $this->data->user->id); // check if user is in the 'vip' group

        // TODO: rooms and user group settings will allow system defaults to be overridden. rewrite code to allow for this.
        $messageage = (int) $this->data->settings['messages.agelimit']; // Time in hours to retreive old messages. This is set from the system default limit. 
        $maxmessages = (int) $this->data->settings['rooms.maxmessages']; // TODO: work on system that will prevent flooding and loss of messages when new message count exceeds this setting.
        // Init End
        
        // runs after user has already been logged into chat.
        //dd($this->data->log);
        $this->data->status->active = 1; // TODO: This setting will most likely be used for banning, kicking, etc.
        $this->data->status->action = 0; // The default action type. Users who use the reload button after being logged in will have this action type.

        /*
        *   Get Options
        *   This section will retrieve the users previous options set during a 'listen' or 'speak' event. 
        *   This also runs after a user first logs in but options are not set yet. May allow for user defaults for when they enter a room.
        */
        if ($handle = $this->handleModel->select()->where('uid',$this->data->user->id)->first()) {
            $this->data->options->name = $handle->handle;
          } else {
            $this->data->options->name = $this->data->user->username;
          }
        $this->data->options->maxmessages = end($this->data->log)['maxmessages'];
        //d($this->data->status,$this->data->log);
        $this->data->options->chatpic = end($this->data->log)['chatpic'];

        $this->data->options->newmessages = end($this->data->log)['newmessages'];
        $this->data->options->autorefresh = end($this->data->log)['autorefresh'];
        $this->data->options->gender = end($this->data->log)['gender'];
        $this->data->options->mood = end($this->data->log)['mood'];
        $this->data->options->location = end($this->data->log)['location'];
        $this->data->options->lastmessage = end($this->data->log)['lastmessage'];
        // END 
    
        //dd($this->data);

        // Listen, Speak, Enter Private
        if ($this->request->getMethod() != "get") {
            
            $data = $this->request->getPost();
            //dd($data);
            // validate user input
            if ($data['action'] != 4) {
                if (! $this->validate([
                    'action' => 'required|numeric',
                    'name'  =>  'required',
                    'location' => 'permit_empty|string',
                    'chatpic'   => 'permit_empty|string',
                    'gender'    =>  'permit_empty|alpha_numeric_punct',
                    'mood'      =>  'permit_empty|alpha_numeric_punct',
                    'maxmessages'   =>  'permit_empty|numeric',
                    'message'   => 'permit_empty|string',
                ])) {
                    $this->logAction('0x5645','error.form.validation');
                    return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
                }
            } else {

            }
            
            // NOTE: These are used in action log. when a user presses listen or speak. it will geneate a post (1-4) action then a get (0) action. 
            $this->data->status->action = $data['action'];
            $this->data->options->location = $data['location'] ?? NULL; 
            $this->data->options->gender = $data['gender'] ?? NULL; // TODO: validate. some users will be able to enter their own. some rooms will have additional listed.
            $this->data->options->mood = $data['mood'] ?? NULL; // TODO: validate. some users will be able to enter their own. some rooms will have additional listed.

            //dd($this->data);
            if ($this->data->vip) {
                $_chatpic = $data['chatpic'] ?? NULL; // TODO: validate
                if ($_chatpic) {
                    if (verifyChatpicPermissions($_chatpic)) {
                        $this->data->options->chatpic = $_chatpic;
                    } else {
                        return redirect()->back()->withInput()->with('errors','Chatpic Restricted!');
                    }
                } else {
                    $this->data->options->chatpic = NULL;
                }
                $this->data->options->newmessages = ($data['newmessages'] ?? NULL) ? 1:0; 
                $this->data->options->autorefresh = ($data['autorefresh'] ?? NULL) ? 1:0; 
            } else {
                $vipFeatures = ['chatpic','maxmessages','newmessages','autorefresh'];
                $e = 0;
                foreach ($vipFeatures as $feature) {
                    $error = '<ul>';
                    if (isset($data[$feature])) {
                        $error .= '<li>' . $feature . 'is a VIP feature.</li>';
                        $e++;
                    }
                    $error .= '</ul>';
                }
                if ($e) {
                    $this->logAction('0x5045','error.permission.unauth.vip');
                    return redirect()->back()->withInput()->with('errors',$error);
                }
            }

            if ($maxmessageResult = $this->validateMaxMessages($this->data)) {
                $this->data->options->maxmessages = $maxmessageResult;
            }

            //dd($data, $this->data);
        }

        //dd($this->data);

        /*
        * Generate Userlist
        * This section generates a list and counts active users in the room.
        */
        if ($users = $this->actionModel->where('rid',$this->data->room->details->id)->findAll()) { // get all users in room.
            // got room users
            $userObject = NULL;

            foreach ($users as $user) {
                $userObject[$user['uid']] = $this->userModel->find($user['uid']);
            }
            $this->data->room->users = new \stdClass();  
            $this->data->room->users->active = (array) $userObject; // list of active users
            $this->data->room->users->count = count((array) $this->data->room->users->active); // active user count
        } else {
            throw new \Exception("Unable to get userlist."); // TODO: Generate support ticket instead of throwing exception.
        }
 
        /*
        * Get User Handles
        * This part will get the handles users are temporarily using and display those instead of their actual names. 
        */
        //$this->data->room->handles = new \stdClass();
        $this->data->room->handles = array();
        //$this->data->room->users->active = array();

        //d($this->data->room->users->active);
        
        foreach ($this->data->room->users->active as $key=>$user) {
            //d($user->id);
            if ($userHandle = $this->handleModel->select('handle')->where('uid',$user->id)->first()) {
                //d($userHandle);
                //d($this->data,$user);
                $this->data->room->handles[$user->id] = $userHandle->handle;
                
                $this->data->room->users->active[$user->id]->handle = $userHandle->handle;
            } else {
                $this->data->room->handles[$user->id] = NULL;
                $this->data->room->users->active[$key]->handle = '';
            }
        }

        // Get
        if ($this->request->getMethod() == "get") {

           
            //d($this->data);

            //$this->data->messages = new \stdClass();
            $this->data->messages->maxAge = $messageage; // TODO: this should be a room setting in db instead of hardcoded in code above.
            
            // Get the users max message option or use system default. Non-Vip users will not be able to set their own option for the setting.
            if (isset($this->data->options->maxmessages)) {
                $this->data->messages->limit = (int) $this->data->options->maxmessages; 
            } else {
                $this->data->messages->limit = (int) $this->data->settings['rooms.maxmessages'];
            }

            // Get users list of ignored messages. This will be used to filter room messages using an "ignored" pseudo column.
            $this->data->messages->ignore = $this->ignoredModel->select()->where('uid',$this->data->user->id)->find(); // Ignored Messages
            $this->data->messages->ignored = new \stdClass();
            $this->data->messages->ignored->count = 0;

            // Get users list of flagged messages. 
            $this->data->messages->flag = $this->flaggedModel->where('uid',$this->data->user->id)->find();
            $this->data->messages->flagged = new \stdClass();
            $this->data->messages->flagged->count = 0;

            /*
            * Messages
            * 
            */
            // Start generating message query to get messages. Using query builder style to allow for dynamic queries. 
            $messages = $this->messagesModel; 
            //d($this->data);

            $selectStatement = '*';
            // getIgnoreQuery() will generate a MySQL conditional which creates a pseudo column we can use to filter ignored messages.
            if ($ignoreQuery = $this->getIgnoreQuery()) {
                //d($ignoreQuery);
                $selectStatement .= ', ' . $ignoreQuery;
            }
            if ($flagQuery = $this->getFlagQuery()) {
                //d($ignoreQuery);
                $selectStatement .= ',' . $flagQuery;
            }

            $messages->select($selectStatement);


            // This section uses a maxAge variable which will allow us to view past messages. 
            // TODO: consider making vip option to set age.
            if ($this->data->messages->maxAge) {
                $messages->where('created_at > \'' . Time::now()->subHours($this->data->messages->maxAge) . '\'');
            }

            //d($this->data->options);
            if ($this->data->options->newmessages) {
                $messages->where('id > ' . $this->data->options->lastmessage);
            }

            // This setting is set by the maxmessages variable above. system default is used unless user has permission to chose their own option.
            if ($this->data->messages->limit) {
                $messages->limit($this->data->messages->limit);
            }
            
            // We're looking for messages sent from or to the current user or to all users. 
            $messages->where('(uid = ' . $this->data->user->id .' OR rcpt = ' . $this->data->user->id .' OR rcpt = 0 ) ');
            $messages->where('( room = ' . $this->data->room->details->id . ' OR room = 0 OR room = NULL )'); 

            $messages->orderBy('id','desc'); // new messages on top.
            $this->data->messages->current = $messages->find(); // Run the query.
            $this->data->messagesquery = $messages->getLastQuery()->getQuery(); // Save message query string so we can debug.

            if ($this->data->messages->count = count($this->data->messages->current)) { // Count all messages. 
                $this->data->messages->last = reset($this->data->messages->current)->id; // TODO: This needs to be saved in action log for new messages only checkbox to work.
            } else {
                $this->data->messages->last = $this->data->options->lastmessage;
            }

            // d($this->data);
            /*
            * Ignored Messages
            * In this section, we'll cound the number of ignored messages. We'll also save a list of just the ignored messages. 
            * The ingored message list will be used to give the user an option to view them still or unignore the user. 
            */
            foreach ($this->data->messages->current as $message) {
                if (isset($message->ignored)) {
                    $this->data->messages->ignored->count++;
                    $this->data->messages->ignored->messages[] = $message;
                } 
            }

            if (isset($message->flagged)) {
                $this->data->messages->flagged->count++;
                $this->data->messages->flagged->messages[] = $message;
            } 

            if (!$this->logAction('0x535652','view.room')) {
                throw new \Exception("Unable to update user.");
            }

            //d($this->data);
            return view('chat/room',(array) $this->data);

        } else {

            if ($lastLog = $this->actionModel->where(['uid'=>$this->data->user->id,'rid'=>$this->data->room->details->id])->first()) {
                //$this->data->messages = new \stdClass();
                $this->data->messages->last = $lastLog['lastmessage'];

            }

            // push to listen
            // push to speak
            // create private room - VIP

            $data = $this->request->getPost();
            // (string) csrf_nexis_token
            // (int)    room
            // (int)    uid
            // (string) chatpic
            // (int)    maxmessages
            // ()    newmessages
            // (string) name
            // (string) loctaion
            // (int)    gender
            // (int)    mood
            // (int)    action_type
            // (int)    towhom
            // (string) message

            $message['uid'] = $this->data->user->id;
            $message['source'] = $this->request->getIPAddress();

            if (isset($data['maxmessages']) && $this->data->vip) {
                if (in_array($data['maxmessages'],$this->data->settings['messages.maxmessageoptions'])) {
                    $data['maxmessages'] = (int) $data['maxmessages'];
                } else {
                    
                    return redirect()->back()->withInput()->with('error','Unknown max message option. This action has been flagged.');
                }
            } else {
                //return redirect()->back()->withInput()->with('error','Max Messages is a VIP feature. This action has been flagged.');
            }
            
            d($this);
            // Message Validation
            $message['user'] = strip_tags($data['name'] ?? $this->data->options->name);
            $message['location'] = strip_tags($data['location'] ?? $this->data->options->location);
            $message['gender'] = strip_tags($data['gender'] ?? $this->data->options->gender);
            $message['mood'] = strip_tags($data['mood'] ?? $this->data->options->mood);
            $message['chatpic'] = strip_tags($data['chatpic'] ?? $this->data->options->chatpic);
            
            if ($data['action'] == 4) {

                if (!$data['private']) {
                    //dd($data);
                    return redirect()->back()->withInput()->with('error','You must enter a room name to enter a private room.');
                } else {
                    $data['private'] = trim(preg_replace('/\s/','',$data['private']));
                    if ($data['private'] == 'sandbox') {
                        return redirect()->back()->withInput()->with('error',$data['private'] . ' is a restricted room.');
                    }
                    if (getRoomByName($data['private'])) {
                        //room exists.
                        $this->logAction('0x4F3AB','private.enter');
                        return redirect()->to('chat/'.$data['private'])->with('data', $data);
                    } else {
                        //create room.
                        $this->logAction('0x4F3AC','private.create');

                        $this->roomModel->save(['name'=>$data['private'],'alias'=>$data['private'],'active'=>1,'private'=>1]);
                        return redirect()->to('chat/'.$data['private'])->with('data', $data);
                    }
                    
                    
                    //dd('Private Room',$data);

                }


            }

            
            // Nick change
            if ($data['name'] == $this->auth->user()->username ) {
                //$data['user'] = $data['name'];
                //dd($data);

                // remove users old handles
                if ($removeHandles = $this->handleModel->select()->where('uid',$this->auth->user()->id)->find()) {
                    foreach ($removeHandles as $removeHandle) {
                        if ($this->handleModel->delete($removeHandle->id) ) {
                            $this->logAction('0x535652','user.room.handle.reset');
                        }
                    }
                }
            } else { // START: nick change. This will run if user is changing nick.
                // TODO: clean up this section

                $restrictedNicks = array('AllUsers','All Users', 'all users', 'Nexis Communications', 'The Park','The-Park','NC','system','admin');
                foreach ($restrictedNicks as $restrictedNick) {
                    if (strtolower($data['name']) == strtolower($restrictedNick)) {
                        $this->logAction('0x452156','user.handle.restricted');
                        return redirect()->back()->withInput()->with('error','Nick Restricted');
                    }
                }

                if ($_registeredUsers = $this->userModel->select('id')->where('username',$data['name'])->find()) { // Check if username is currently owned by a registered user.
                    $this->logAction('0x535652','user.handle.registered');
                    return redirect()->back()->withInput()->with('error','Nick Unavailable');
                }

                $_tempUsers = $this->handleModel->select('id')->where('handle',$data['name'])->find(); // Check if username is in use temporarily by another user.

                if (count($_tempUsers)) {
                    if ($_checkUser = $this->handleModel->select()->where('handle',$data['name'])->where('uid',$this->auth->user()->id)->find()) { // user currently using handle.
                        $this->handleModel->update('id',['uid'=>$this->auth->user()->id,'handle'=>$data['name']]);
                        $data['user'] = $data['name'];
                    } else {
                        $this->logAction('0x535652','user.handle.unavailable');
                        return redirect()->back()->withInput()->with('error','Nick Unavailable');
                    }
                } else { // handle unused
                    if ($_tempHandles = $this->handleModel->select()->where('uid',$this->auth->user()->id)->findAll()) { // User has temp handles
                        foreach ($_tempHandles as $_tempHandle) {
                            $this->handleModel->delete($_tempHandle['id']);
                        }
                    }
                    if ($this->handleModel->save(['uid'=>$this->auth->user()->id,'handle'=>$data['name']])) { // save new handle
                        $data['user'] = $data['name'];
                        $this->logAction('0x535652','user.handle.change');
                    }
                }
            }
            // END: nick change


            // TODO: clean up
            if (@$data['ignore']) {
                $ignored = $data['ignore'];
                //dd($data['ignore']);
                if (is_array($ignored)) {
                    foreach ($ignored as $ignore) {
                        //d($ignore);
                    }
                } else {
                        //d($ignored);
                        if ($ignoredMessage = $this->messagesModel->select()->find($ignored)) {
                            $ignoredUID = $ignoredMessage->uid;
                            $this->ignoredModel->save(['uid'=>$this->data->user->id,'iid'=>$ignoredUID,'mid'=>$ignored]);
                        } else {
                            return redirect()->back()->withInput()->with('error','Unable to ignore user. Message not found.');
                        }
                }
                // dd();
            }

            // TODO: clean up
            if (@$data['flag']) {
                $ticket = '';
                if ($ticket = flagMessage($data['flag'],$this->data->user->id)) {
                    $returnmessage = 'Created support ticket. Ticket: ' . $ticket;
                } else {
                    $returnmessage = 'We were unable to create a support ticket. Please contact <a href="/support" target="_new">Support</a>.';
                }
                $this->messagesModel->save(['uid'=>0,'user'=>'SYSTEM','room'=>$this->data->room->details->id,'source'=>'localhost','rcpt'=>$this->data->user->id,'location'=>'the ether','gender'=>'Bot','mood'=>'','data'=>$returnmessage]);

                // This will allow us to check if the messages has already been flagged. 
                foreach ($data['flag'] as $flagged) {
                    $flaggedMessage['uid'] = $this->data->user->id;
                    $flaggedMessage['mid'] = $flagged;
                    $this->flaggedModel->save($flaggedMessage);
                }
            }
//dd($data,$this->data);
            if ($data['action'] == 2) {
                $this->logAction('0x268FA','listen');
                return redirect()->to('chat/'.$alias)->with('data', $data);

            }

            if ($data['action'] == 3) {
                if (!$data['message']) {
                    $this->logAction('0x29891','message.missing');
                    return redirect()->to('chat/'.$alias)->with('data', $data);
                } else {
                    $message['room'] = $this->data->room->details->id;
                    $message['rcpt'] = $data['towhom']; // int
                    if ($message['rcpt']) {
                        d($message);
                        $message['rcpt_handle'] = $this->data->room->handles->{$message['rcpt']} ?? $this->userModel->find($message['rcpt'])->username;
                    } else {
                        $message['rcpt_handle'] = lang('Chat.allusers');
                    }

                    //d($data['message']);
                    $message['data'] = htmlentities($data['message'], ENT_QUOTES); // TODO: allow vip to use tags for certain rooms?
                    //dd($message['data']);
                    /*if ($message['data'] != $data['message']) {
                        
                        if (!$this->logAction('0x4556','message.error.tags')) {
                            throw new \Exception("Unable to update user.");
                        } else {
                            $this->data->log = $this->actionModel->where(['uid'=>$this->data->user->id,'rid'=>$this->data->room->details->id])->findAll();
                        }

                        return redirect()->back()->withInput()->with('error','HTML Tags are not allowed.');
                    }*/

                }

                //dd($this->data,$data,$message); // TODO: room & uid fields not needed on form

                if ($this->messagesModel->save($message)) {
                    
                    if ($message['rcpt'] == $this->auth->user()->id) {
                        $this->messagesModel->save(['uid'=>0,'user'=>'SYSTEM','room'=>$message['room'],'source'=>'localhost','rcpt'=>$message['rcpt'],'rcpt_handle'=>$message['rcpt_handle'],'location'=>'the ether','gender'=>'Bot','mood'=>'Confused','data'=>"I can't make any promises, but... you may get a better response if you don't talk to yourself.\nHowever, if you are just seeking expert advice... Our apologies, Carry On."]);
                    }

                    ($message['rcpt'] != 0) ? $this->logAction('0x25FA3','message.pm'):$this->logAction('0x25FA3','message.general');
                    return redirect()->to('chat/'.$alias)->with('data', $data);
                } else {
                    return redirect()->back()->withInput()->with('error','Unable to send message');
                }
            }

            

        }

    }

    private function validateMaxMessages($data) 
    {

        $postedData = $data->request->getPost();

        //dd($data, $postedData);
        if (isset($postedData['maxmessages']) && $data->vip) {
            if (in_array($postedData['maxmessages'],$data->settings['messages.maxmessageoptions'])) {
                return (int) $postedData['maxmessages'];
            } else {
                return redirect()->back()->withInput()->with('error','Unknown max message option. This action has been flagged.');
            }
        } else {
            return NULL;
        }

    }

    private function getLastMessage() {
        if ($lastLog = $this->actionModel->where(['uid'=>$this->data->user->id,'rid'=>$this->data->room->details->id])->first()) {
            return $lastLog['lastmessage'];
        } else {
            return FALSE;
        }
    }

    /*
    * Function: loginUser()
    * Description: This just sets the action type to 1 before loggin the action.
    * Return: boolean
    */
    private function loginUser() {

        /*
        $actionModel = new RoomUsersModel();
        
        $data = [
            'uid'=>$user,
            'rid'=>$room,
            'action'=>1,
        ];
        */

        $this->data->status->action = 1;


        if ($this->logAction('0x534C','login.success') ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    private function logAction ($code = NULL, $message = NULL ) {

        $data = [
            'uid'=>$this->data->user->id,
            'rid'=>$this->data->room->details->id,
            'action'=>$this->data->status->action,
            'active'=>$this->data->status->active ?? 1,
            'chatpic'=>$this->data->options->chatpic ?? NULL,
            'maxmessages'=>$this->data->options->maxmessages ?? NULL,
            'newmessages'=>$this->data->options->newmessages ?? NULL,
            'autorefresh'=>$this->data->options->autorefresh ?? NULL,
            'refreshtime'=>$this->data->options->refreshtime ?? NULL,
            'gender'=>$this->data->options->gender ?? NULL,
            'mood'=>$this->data->options->mood ?? NULL,
            'location'=>$this->data->options->location ?? NULL,
            'lastmessage'=>$this->data->messages->last ?? NULL,
            'code'=>$code ?? NULL,
            'message'=>$message ?? NULL,
            'mid'=>NULL,
        ];

        //dd($this->data,$data);

        // TODO: figure out if the code below is still needed since we're preparing the array above.
        $actionModel = new RoomUsersModel();

        $allowedFields = $actionModel->allowedFields;
        $emptyData = array_fill_keys($allowedFields,NULL);
        $required = ['uid','rid','action'];

        if (count(array_intersect_key(array_flip($required), $data)) === count($required)) {
            
            $data = array_merge($emptyData,$data);
            $data['active'] = 1;
        }
       // d($actionModel);
       //d($data);
        // TODO: END 

        foreach ($this->data->log as $entry) {
            $actionModel->delete($entry['id']);
        }

        if ($actionModel->save( $data ) ) {
            if ($this->data->status->action < 0) {
                if (!$actionModel->delete($actionModel->insertID())) {
                    // unable to logout user.
                }
            }
            return TRUE;
        } else {
            return $actionModel->errors();
        }

    }

    private function getIgnoreQuery() {

        // d($this->data,$data);
 
         if ($this->data->messages->ignore) {
             $ignoreQuery = 'IF( ';
             foreach($this->data->messages->ignore as $ignore) {
                 $ignoreQuery .= 'uid = ' . $ignore->iid . '';
                 if (next($this->data->messages->ignore)) {
                     $ignoreQuery .= ' OR ';
                 }
             } 
 
             $ignoreQuery .= ', 1, 0 ) AS ignored';
             return $ignoreQuery;
            // $messages->select('*, ' . $ignoreQuery . ' ');
 
         }
 
         return FALSE;
     }

     private function getFlagQuery() {
 
         //d($this->data);
 
         if ($this->data->messages->flag) {
             $flagQuery = 'IF( ';
             foreach($this->data->messages->flag as $flagged) {
                 //d($flagged); model wasn't updated object yet. fixed.
                 $flagQuery .= 'id = ' . $flagged->mid . '';
                 if (next($this->data->messages->flag)) {
                     $flagQuery .= ' OR ';
                 }
             } 
 
             $flagQuery .= ', 1, 0 ) AS flagged';
             return $flagQuery;
 
         }
 
         return FALSE;
     }

    public function getMoods() {
        $model = new MoodModel();

        $moods = $model->where('active',1)->orderBy('description','ASC')->find();
        $data = NULL;

        foreach ($moods as $mood) {
            $data[$mood->id] = $mood;
        }

        if ($data) {
            return $data;
        }

        return FALSE;
    }

    public function getGenders() {
        $model = new GenderModel();

        $genders = $model->where('active',1)->orderBy('description','ASC')->find();
        $data = NULL;

        foreach ($genders as $gender) {
            $data[$gender->id] = $gender;
        }

        if ($data) {
            return $data;
        }

        return FALSE;
    }

    private function getSystemSettings($setting = NULL, $id = 0) {


            if ($setting) {
                return $this->systemSettingsModel->where('name',$setting)->first();
            }

            if ($_settings = $this->systemSettingsModel->findAll()) {

            foreach ($_settings as $_setting) {
                $jsonfields = ['messages.maxmessageoptions'];
                $settings[$_setting->name] = ($id) ? $_setting->id:((in_array($_setting->name,$jsonfields)) ? json_decode($_setting->value):$_setting->value);
            }

            return $settings;
        } else {
            throw new \Exception("Unable to get system settings. Contact Support.");
        }
    }

}
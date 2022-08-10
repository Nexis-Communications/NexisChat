<?php

if (!function_exists("getSystemSettings")) {
    function getSystemSettings($setting = NULL, $id = 0) {

        $systemSettingsModel = model('App\Models\SystemSettingsModel');

            if ($setting) {
                return $systemSettingsModel->where('name',$setting)->first();
            }

            if ($_settings = $systemSettingsModel->findAll()) {

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

if (!function_exists("getUserGroups")) {
    function getUserGroups(int $id,$html = NULL) {
        $UserGroupModel = model('App\Models\UserGroupModel');
        $GroupModel = model('App\Models\GroupModel');


        $data['user_groups'] = $UserGroupModel->select()->where('user_id',$id)->find();

        $groups = array();
        foreach ($data['user_groups'] as $group) {
            $groups[] = $GroupModel->select()->find($group['group_id']);
        }

        //dd($groups);
        
        if (!$html) {
            return ($groups);
        } else {
            //d($groups);
            foreach ($groups as $group) {
                $links[] = anchor('/admin/dashboard/groups/view/'.$group->id,$group->description);
            }
        
            $output = implode(' , ',$links);

            //dd($output);
            return ($output);

        }
    }
}

if (!function_exists("getLastLogin")) {
    function getLastLogin(int $id) {

        $UserLoginsModel = model('App\Models\UserLoginsModel');

        $lastLogin = $UserLoginsModel->select()->where('success',1)->where('user_id',$id)->orderby('date','desc')->first();

        //print_r($lastLogin);    

        return($lastLogin);
    }
}

if (!function_exists("getUserStatus")) {
    function getUserStatus(int $id) {

        $userModel = model('App\Models\UserModel');

        $userStatus = $userModel->select('status')->find($id);

        return($userStatus);
    }
}

if (!function_exists("getUserRooms")) {
    function getUserRooms(int $id) {

        $userRoomsModel = model('App\Models\RoomUsersModel');

        $rooms = $userRoomsModel->select()->where('uid',$id)->find();

        //dd($rooms);

        if (!empty($rooms)) {
            return ($rooms);
        } else {
            return ( NULL );
        }

    }
}

if (!function_exists("shortenString")) {
    function shortenString(string $string, int $length) {

        $output = substr($string,0,$length);
        if  (strlen($string) > $length) {
            $output .= '...';
        }

        return $output;
        
    }
}

if (!function_exists("getRoomInfo")) {
    function getRoomInfo(int $id) {

        $roomModel = model('App\Models\RoomModel');

        $roomData = $roomModel->select()->find($id);

        return ($roomData);
        
    }
}

if (!function_exists("getRoomByName")) {
    function getRoomByName($alias) {

        $roomModel = model('App\Models\RoomModel');

        $roomData = $roomModel->select()->where('alias',$alias)->findAll();

        return ($roomData);
        
    }
}

if (!function_exists("getLastPublicRoom")) {
    function getLastPublicRoom(int $id) {

       // d($id);

        $actionLog = model('App\Models\RoomUsersModel');
        $roomModel = model('App\Models\RoomModel');

        $publicRooms = $roomModel->where('private',0)->find();

        //d($publicRooms);

        $roomData = $actionLog->select()->where('uid',$id);
        //d($roomData->builder());
        foreach ($publicRooms as $room) {
            $publicRoomArray[] = $room->id;
        }
        $roomData->builder()->whereIn('rid',$publicRoomArray);
        //d($roomData->builder()->groupEnd());

        $roomData->onlyDeleted()->orderBy('deleted_at','DESC');
        
        $query = $roomData->first();

        //dd($query, $roomData->getLastQuery()->getQuery());

        return ($query);
        
    }
}


if (!function_exists("getRoomGroups")) {
    function getRoomGroups() {

        $groupModel = model('App\Models\RoomGroupModel');

        $groupData = $groupModel->select()->findAll();

        return ($groupData);
        
    }
}

if (!function_exists("getRoomGroup")) {
    function getRoomGroup(int $id) {

        $rgxrefModel = model('App\Models\RoomGroupXrefModel');

        $groupData = $rgxrefModel->select()->where('rid',$id)->findAll();

        return ($groupData);
        
    }
}

if (!function_exists("getRoomUserCount")) {
    function getRoomUserCount(int $id, int $type = null, int $limit = 0) {

        $roomusersModel = model('App\Models\RoomUsersModel');

        $users = $roomusersModel->select('users.id , users.username')->join('users','room_users.uid = users.id','left')->where('rid',$id)->orderby('users.username','asc')->asObject()->findAll($limit); // Returns userlist with id and username ( handle?). Should probably use helper function for this. 

        if ($type) {
            return $users;
        } else {
            return count($users);
        }
        
    }
}

if (!function_exists("getRoomFlagged")) {
    function getRoomFlagged(int $id,int $type = null) {
        //dd($id);
        $flaggedModel = model('App\Models\FlaggedModel');

        $data = $flaggedModel->select('messages_flags.id, users.username as sus_user, messages.uid as sus_id, messages.user as sus_handle, messages.source as sus_source, messages.room as sus_rid, rooms.name as sus_room, messages.data as sus_message, messages_flags.uid as rpid, rpuser.username as rp_user, messages_flags.created_at as rt')->join('messages','messages.id = messages_flags.mid','left')->join('users','users.id = messages.uid','left')->join('users as rpuser','rpuser.id = messages_flags.uid','left')->join('rooms','rooms.id = messages.room','left');
        if ($id) {
            $data = $data->where('messages.room',$id);
            //dd($id);
        }
        $data = $data->asObject()->find();

        if ($type) {
            return $data; 
        } else {
            return count($data);
        }
    }
}

if (!function_exists("getTotalFlagged")) {
    function getTotalFlagged() {

        $flaggedModel = model('App\Models\FlaggedModel');

        $data = $flaggedModel->select('messages_flags.id, users.username as sus_user, messages.uid as sus_id, messages.user as sus_handle, messages.source as sus_source, messages.room as sus_rid, rooms.name as sus_room, messages.data as sus_message, messages_flags.uid as rpid, rpuser.username as rp_user, messages_flags.created_at as rt')->join('messages','messages.id = messages_flags.mid','left')->join('users','users.id = messages.uid','left')->join('users as rpuser','rpuser.id = messages_flags.uid','left')->join('rooms','rooms.id = messages.room','left')->asObject()->find();
 
            return count($data);
    }
}

if (!function_exists("getGroup")) {
    function getGroup(int $id) {

        $groupModel = model('App\Models\RoomGroupModel');

        $groupData = $groupModel->select()->find($id);

        return ($groupData);
        
    }
}

if (!function_exists("userLookup")) {
    function userLookup(int $id) {

        $userModel = model('App\Models\UserModel');

        $user = $userModel->select()->find($id);

        return ($user);
        
    }
}

if (!function_exists("getUserbyID")) {
    function getUserbyID(int $id) {

        if ($id) {
            $userModel = model('App\Models\UserModel');

            $user = $userModel->select()->find($id);

            return ($user);
        }

        if ($id === 0) {
            $user = new StdClass();
            $user->id = 0;
            $user->username = "All Users";
            return $user;
        }

        return NULL;
        
    }
}

if (!function_exists("messageLookup")) {
    function messageLookup(int $id) {

        $messageModel = model('App\Models\MessagesModel');

        $message = $messageModel->select()->find($id);

        return ($message);
        
    }
}

if (!function_exists("getTags")) {
    function getTags(int $id) {
        $tagsModel = model('App\Models\TagsModel');
        if ($tags = $tagsModel->select()->find($id)) {
            return ($tags->tags);
        } else {
            return null;
        }
    }
}

if (!function_exists("usernameLookup")) {
    function usernameLookup($username) {

        $userModel = model('App\Models\UserModel');

        $user = $userModel->select('id')->where('username',$username)->findAll();


        return ($user);
        
    }
}

if (!function_exists("emailLookup")) {
    function emailLookup($email) {

        $userModel = model('App\Models\UserModel');

        $user = $userModel->select('id')->where('email',$email)->findAll();


        return ($user);
        
    }
}

if (!function_exists("getCopyYear")) {
    function getCopyYear() {
        $time = Time::now();
        $copyyear = $time->toLocalizedString('yy');

        return $copyyear;
    }
}

if (!function_exists("getCopyright")) {
    function getCopyright() {
        $time = new DateTime();
        //dd($time);
        $copyyear = $time->format('y');
        //print_r($copyyear);
        $copy = explode('yy',lang('Chat.copyright'));
        $copyright = $copy[0] . $copyyear . $copy[1];

        return $copyright;
    }
}

if (!function_exists("getUserLevel")) {
    function getUserLevel($id,int $type) {
        $groupModel = model('App\Models\UserGroupModel');
        $groupsModel = model('App\Models\GroupsModel');

        if ($type) {
           return $groupsModel->find($groupModel->find($id)['group_id'])['description'];
        } else {
            return $groupModel->find($id)['group_id'];
        }

    }
}

if (!function_exists("getUserTotal")) {
    function getUserTotal($group = NULL) {
        $userModel = model('App\Models\UserModel');
        $builder = $userModel->select();
        if ($group) {
            $builder = $builder->join('auth_groups_users','users.id = auth_groups_users.user_id','left');
            $builder = $builder->where('auth_groups_users.group_id',$group);

        }
        $results = $builder->findAll();
        $count = count($results);
        //if ($group)
        //dd($group,$builder->getLastQuery(),$results);

        return $count;
    }
}

if (!function_exists("getUserGroup")) {
    function getUserGroup($id) {
        $userModel = model('App\Models\UserModel');
        $xrefModel = model('App\Models\UserGroupModel');
        $xref = $xrefModel->where('user_id',$id)->first();
        //print_r($xref);
        $groupModel = model('App\Models\GroupsModel');
        $data = $groupModel->find($xref['group_id']);
        //dd($data);
        return $data;
    }
}

if (!function_exists("getGroupUsersCount")) {
    function getGroupUsersCount($id) {
        $xrefModel = model('App\Models\UserGroupModel');
        $xref = $xrefModel->where('group_id',$id)->find();
        return count($xref);
    }
}

if (!function_exists("getRoomCount")) {
    function getRoomCount($id = NULL) {
        $roomModel = model('App\Models\RoomModel');

        if ($id) {
            
        } else {
            return count($roomModel->findAll());
        }

    }
}

if (!function_exists("getStatusHTML")) {
    function getStatusHTML($input) {
        switch ($input) {
        case 0:
            $color = 'danger';
            $status = lang('Chat.inactiveStatus');
            break;
        case 1:
            $color = 'success';
            $status = lang('Chat.activeStatus');
            break;
        default:
            $color = 'danger';
            $status = lang('Chat.unknownStatus');
        }
        $output = '<span class="status text-' . $color . '">•</span> ' . $status;

        return $output;
    }
}

if (!function_exists("getJoinDate")) {
    function getJoinDate($input) {
        $time = new DateTime($input);
        //dd($time);
        $date = $time->format('m/d/Y');

        return $date;
    }
}

if (!function_exists("flagMessage")) {
    function flagMessage(array $messages,int $rp) {

        $userModel = model('App\Models\UserModel');
        $messageModel = model('App\Models\MessagesModel');
        $roomModel = model('App\Models\RoomModel');
        $user = $userModel->asObject()->find($rp);

        $report = '<html><body>';
        $report .= '<table><tr><th>Message ID</th><th>User</th><th>Room</th><th>Recipient</th><th>Message</th><th>Sent</th><th>Avatar</th></tr>';

        foreach ($messages as $messageID) {
            $messageData = $messageModel->find($messageID);
            $roomDetails = $roomModel->find($messageData->room);
            if ($messageData->rcpt != 0) {
                $recipient = $userModel->find($messageData->rcpt);
            } else {
                $recipient = 'All Users';
            }
            //d($messageData,$roomDetails, $recipient); // flagging a messages to all users was causing an error. fixed 20220212
            $report .= '<tr>';
            $report .= '<td>' . $messageData->id . '</td>';
            $report .= '<td>' . $messageData->user . '</td>';
            $report .= '<td><a href="https://www.theparkchat.com/chat/' . $roomDetails->alias . '" target="_new">' . $roomDetails->name . '</a></td>';
            $report .= '<td>' . $recipient . '</td>';
            $report .= '<td>' . $messageData->data . '</td>';
            $report .= '<td>' . $messageData->created_at . '</td>';
            $report .= '<td>' . $messageData->chatpic . '</td>';
            $report .= '</tr>';
            
        }
        $report .= '</table>';
        $report .= '</body></html>';
        

        $data = [
            'email' => ($user->email)? $user->email:'noreply@theparkchat.com',
            'name'  => $user->username,
            'subject'   =>  'Flagged Message',
            'message'   => 'data:text/html,'.$report,
            'alert'     =>  1,
            'ip'    => $_SERVER['REMOTE_ADDR'],
            'priority'  => 3, // 1 = Low, 2 = Normal, 3 = High, 4 Emergency
            'source'    => 'Web',
            'topic'   =>  12,
        ];

        //dd($data);
        return osTicket($data);
        
            

    }
}

if (!function_exists("getTicket")) {
    function getTicket(int $id) { // $id = Ticket ID
        $osConfig = [
            'url'   =>  'https://support.theparkchat.com/ost_wbs/?', // osticket-api url
        ];

        $headers = array('apikey' => '5E650E6B901E9D45A847266E35E23516'); // osTicket API Key

        $url = $osConfig['url'];
        //$url .= 'apikey=' . $osConfig['key'];
        $url .= '&query=ticket';
        $url .= '&condition=specific';
        $url .= '&parameters='. $id;

        set_time_limit(30); // Set time limit for cURL function

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $result=curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        //print_r($code);
        //dd($result);
        //print_r($curl_error);
        if ($code != 201) {
    
            //$data['error'] = 'Unable to create ticket: ' . $result;
        }

        return $result;
                 

    }
}


if (!function_exists("osTicket")) {
    function osTicket(array $data,int $type = NULL) { // $data is input array, $type is return type.
        $osConfig = [
            'url'   =>  'https://support.theparkchat.com/api/http.php/tickets.json', // /api/http.php/tickets.json url
            'key'   =>  '5E650E6B901E9D45A847266E35E23516', // osTicket API Key
        ];

        $osTicketData = array(
            'email'     =>      $data['email'],  // required Email address of the submitter
            'name'      =>      $data['name'],  // required Name of the submitter
            'subject'   =>      $data['subject'],  // required Subject of the ticket
            'message'   =>      $data['message'],  // required Initial message for the ticket thread. The message content can be specified using RFC 2397 in the JSON format. The content of the message element should be the message body. Encoding is assumed based on the encoding attributed set in the xml processing instruction.
            'alert'     =>      $data['alert'], //If unset, disable autoresponses. Default is true
            'ip'        =>      $data['ip'], // IP address of the submitter
            'priority'  =>      $data['priority'], //Priority id for the new ticket to assume
            'source'    =>      $data['source'], //Source of the ticket, default is API
            'topicId'   =>      $data['topic'], //Help topic id associated with the ticket
            //'notes'     =>      $data['notes'], // Internal notes for the client created. These notes are only visible to authenticated staff members
            'attachments' => array()
        );

        //print_r($osTicketData);
        //dd(json_encode($osTicketData));

        //function_exists('curl_version') or die('CURL support required');
        //function_exists('json_encode') or die('JSON support required');

        set_time_limit(30); // Set time limit for cURL function

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $osConfig['url']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($osTicketData));
        curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.8');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:', 'X-API-Key: '.$osConfig['key']));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $result=curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        //dd($result);
        //print_r($curl_error);
        if ($code != 201) {
    
            //$data['error'] = 'Unable to create ticket: ' . $result;
        }

        //dd($code);
        $ticket_id = (int) $result; // New ticket ID
        if(isset($ticket_id) && $ticket_id!='') {
            //echo "Ticket Created Sucessfully";
        } else {
            //echo "Ticket not created. Try again later.";
            
        }
        
        return $ticket_id;            

    }
}

if (!function_exists("getFaq")) {
    function getFaq() { // $id = Ticket ID

        return ostAPI('faq','all');

    }
}

if (!function_exists("getTopics")) {
    function getTopics($condition = 'all',$parameters = NULL) { // $id = Ticket ID

        return ostAPI('topics','all');
                
    }
}

if (!function_exists("ostAPI")) {
    function ostAPI(string $query, string $condition, string $sort = NULL, string $parameters = NULL) {

        $osConfig = [
            'url'   =>  'https://support.theparkchat.com/ost_wbs/?', // osticket-api url
            'key'   =>  '5E650E6B901E9D45A847266E35E23516', // osTicket API Key
        ];

        $url = $osConfig['url'];

        $headers = array(
            'apikey: ' . $osConfig['key'], // osTicket API Key
            'Content-Type: application/json',
            'User-Agent: theparkchat',
        ); 

        $payload = json_encode(array(
            'query' => $query,
            'condition' => $condition,
            'sort' => $sort,
            'parameters' => $parameters,
            )
        );

        $result = getQuery($url,$headers,$payload);

        switch ($result['code']) {
            case 100: $result['text'] = 'Continue'; break;
            case 101: $result['text'] = 'Switching Protocols'; break;
            case 200: 
                $result['text'] = 'OK'; 
                $data = json_decode($result['data']);
                //dd($data);
                if ($data->data == 'No items found.') {
                    $data->data = new \stdClass;
                    $data->data->total = 0;
                    return $data;
                } else {
                    return json_decode($result['data']); 
                }
                break;
            case 201: $result['text'] = 'Created'; break;
            case 202: $result['text'] = 'Accepted'; break;
            case 203: $result['text'] = 'Non-Authoritative Information'; break;
            case 204: $result['text'] = 'No Content'; break;
            case 205: $result['text'] = 'Reset Content'; break;
            case 206: $result['text'] = 'Partial Content'; break;
            case 300: $result['text'] = 'Multiple Choices'; break;
            case 301: $result['text'] = 'Moved Permanently'; break;
            case 302: $result['text'] = 'Moved Temporarily'; break;
            case 303: $result['text'] = 'See Other'; break;
            case 304: $result['text'] = 'Not Modified'; break;
            case 305: $result['text'] = 'Use Proxy'; break;
            case 400: $result['text'] = 'Bad Request'; break;
            case 401: $result['text'] = 'Unauthorized'; break;
            case 402: $result['text'] = 'Payment Required'; break;
            case 403: $result['text'] = 'Forbidden'; break;
            case 404: $result['text'] = 'Not Found'; break;
            case 405: $result['text'] = 'Method Not Allowed'; break;
            case 406: $result['text'] = 'Not Acceptable'; break;
            case 407: $result['text'] = 'Proxy Authentication Required'; break;
            case 408: $result['text'] = 'Request Time-out'; break;
            case 409: $result['text'] = 'Conflict'; break;
            case 410: $result['text'] = 'Gone'; break;
            case 411: $result['text'] = 'Length Required'; break;
            case 412: $result['text'] = 'Precondition Failed'; break;
            case 413: $result['text'] = 'Request Entity Too Large'; break;
            case 414: $result['text'] = 'Request-URI Too Large'; break;
            case 415: $result['text'] = 'Unsupported Media Type'; break;
            case 500: $result['text'] = 'Internal Server Error'; break;
            case 501: $result['text'] = 'Not Implemented'; break;
            case 502: $result['text'] = 'Bad Gateway'; break;
            case 503: $result['text'] = 'Service Unavailable'; break;
            case 504: $result['text'] = 'Gateway Time-out'; break;
            case 505: $result['text'] = 'HTTP Version not supported'; break;
            default:
                $result['text'] = 'Unknown http status code "' . htmlentities($code) . '"';
            break;
        }

    }
}

if (!function_exists("getQuery")) {
    function getQuery($url,$headers,$payload) {

        $time_start = microtime(true);
        set_time_limit(30); // Set time limit for cURL function

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $response['data'] = curl_exec($ch);
        $response['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response['error'] = curl_error($ch);
        $response['header_size'] = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $response['header'] = substr($response['data'], 0, $response['header_size']); 
        $response['body'] = substr($response['data'], $response['header_size']);
        curl_close($ch);

        $response['time'] = microtime(true) - $time_start;

        return $response;
    }
}

if (!function_exists("Pixabay")) {
    function Pixabay($query) {

        $pixabayClient = new \Pixabay\PixabayClient([
            'key' => '26944565-4e27e4c98345a494e6e7b2529'
        ]);
    
        // test it
        if ($results = $pixabayClient->get($query, true)) {
            return $results;
        }

        return NULL;
        
    }
}

if (!function_exists("getMessageCount")) {
    function getMessageCount($room = null) {

        $messageModel = model('App\Models\MessagesModel');

        $builder = $messageModel->select();
        if ($room) {
            $builder = $builder->where('room',$room);
        }
        $messages = $builder->find();

        return count($messages);

        return NULL;
        
    }
}

if (!function_exists("getChatpicCount")) {
    function getChatpicCount($private = NULL) {

        $pbmodel = model('App\Models\ChatpicsPixabayModel');
        $xxmodel = model('App\Models\ChatpicsTheparkchatModel');

        if ($private) {
            $results = $xxmodel->select()->where('private',1)->find();
            return count($results);
        } else {
            $results['pb'] = $pbmodel->select()->find();
            $results['xx'] = $pbmodel->select()->find();
            $i = 0;
            foreach ($results as $cpd) {
                $i = $i + count($cpd);
            }
            return $i;
        }

        return NULL;
        
    }
}

if (!function_exists("getChatpicGroups")) {
    function getChatpicGroups(int $count) {

        return 123;

        return NULL;
        
    }
}


if (!function_exists("getGender")) {
    function getGender($gender) {

        if (is_numeric($gender)) {
            
            $model = model('App\Models\GenderModel');

            $result = $model->find($gender);
            if ($result) {
                return $result->description;
            } else {
                return "N/A";
            }
        }

        return $gender;
        
    }
}

if (!function_exists("getMood")) {
    function getMood($mood) {

        if (is_numeric($mood)) {
            
            $model = model('App\Models\MoodModel');

            $result = $model->find($mood);
            if ($result) {
                return $result->description;
            } else {
                return "N/A";
            }
        }

        return $mood;
        
    }
}

if (!function_exists("checkFlagged")) {
    function checkFlagged($messageID) {

        $model = model('App\Models\FlaggedModel');

        if ($result = $model->where('mid',$messageID)->orderBy('created_at')->find()) {
            return $result;
        }

        return NULL;
        
    }
}

if (!function_exists("getActiveUsers")) {
    function getActiveUsers($active,$count = NULL) {

        $model = model('App\Models\UserModel');

        if ($result = $model->where('active',$active)->find()) {
            if ($count) {
                return count($result);
            } else {
                return $result;
            }
        }

        return NULL;
        
    }
}
?>
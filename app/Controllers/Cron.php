<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;


class Cron extends BaseController
{

    public function __construct() {
        $this->data = new \stdClass();
        $this->actionModel = model('App\Models\RoomUsersModel');
        $this->userGroupModel = model('App\Models\UserGroupModel');
        $this->userModel = model('App\Models\UserModel');;
    }
    public function index()
    {

        echo "I am here.";

    }

    public function inactiveUsers()
    {

        //$roomusersModel = model('App\Models\RoomUsersModel');
        //$userGroupModel = model('App\Models\UserGroupModel');
        //$userModel = model('App\Models\UserModel');

        $lastActive = $this->actionModel->select('room_users.id, room_users.uid, users.id user_id, users.username user_username')->join('users','room_users.uid = users.id','left')->orderby('users.username','asc')->findAll();
        //d($roomusersModel);
        $where = "room_users.created_at < '" . Time::now()->subMinutes(30) . "'";
        $inActive = $this->actionModel->select('room_users.id, room_users.uid,  users.id user_id, room_users.rid room, room_users.lastmessage, users.username user_username')->join('users','room_users.uid = users.id','left')->where($where)->orderby('users.username','asc')->find();
        //d($lastActive);
        //dd($inActive,$this->actionModel->getLastQuery()->getQuery());
        if ($inActive) {
            //dd($inActive);
            foreach ($inActive as $user) {
                $this->data->user = $user['user_id'];
                $this->data->room = $user['room'];
                $this->data->lastmessage = $user['lastmessage']; // This should be able to get users last viewed message. 
                $this->data->action = -2;
                //dd($this->data);
                
                if ($this->actionModel->where('id',$user['id'])->delete()) { // $user['id'] is log id. not users actual id from users table.
                    $this->logAction('0x2480','logout.timeout');            
                }
                // remove guest users. 
                if ($this->userGroupModel->select()->where('user_id',$user['id'])->where('group_id',5)->find()) {
                    if ($this->userModel->delete($user['id'])) {
                        $this->logAction('0x6813','user.delete.guest');

                    }
                }
                $this->userModel->purgeDeleted();
            }
        } else {
            return 'There are no inactive users';
        }
        //$diffActive = array_diff($lastActive,$currentActive);
    }

    private function logAction ($code, $message ) {

        $data = [
            'uid'=>$this->data->user,
            'rid'=>$this->data->room,
            'action'=>$this->data->action,
            'lastmessage'=>$this->data->lastmessage,
            'code'=>$code ?? NULL,
            'message'=>$message ?? NULL,
        ];

        //dd($this->data,$data);

         // Programatically build $data array
         $allowedFields = $this->actionModel->allowedFields;
         $emptyData = array_fill_keys($allowedFields,NULL);
         $required = ['uid','rid','action'];
 
         if (count(array_intersect_key(array_flip($required), $data)) === count($required)) {
             
             $data = array_merge($emptyData,$data);
             $data['active'] = 1;
         }
        // d($actionModel);
        //d($data);

        if ($this->actionModel->save( $data ) ) {
            $this->actionModel->getInsertID();
            $this->actionModel->delete($this->actionModel->getInsertID());
            return TRUE;
        } else {
            return $this->actionModel->errors();
        }

    }

}

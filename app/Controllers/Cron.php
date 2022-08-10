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

        $this->data->user = 'SYSTEM';
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
        //d($lastActive);

        //d($roomusersModel);
        $where = "room_users.created_at < '" . Time::now()->subMinutes(30) . "'";
        $inActive = $this->actionModel->select('room_users.id, room_users.uid,  users.id user_id, room_users.rid room, room_users.lastmessage, users.username user_username')->join('users','room_users.uid = users.id','left')->where($where)->orderby('users.username','asc')->find();
        //d($inActive,$this->actionModel->getLastQuery()->getQuery());
        if ($inActive) {
            //dd($inActive);
            foreach ($inActive as $user) {
                $this->data->user = $user['user_id'];
                $this->data->room = $user['room'];
                $this->data->lastmessage = $user['lastmessage']; // This should be able to get users last viewed message. 
                $this->data->action = -2;
                //d($this->data);
                
                // Timeout from room.
                if ($this->actionModel->where('id',$user['id'])->delete()) { // $user['id'] is log id. not users actual id from users table.
                    $this->logAction('0x2480','logout.timeout');            
                }

                //d($this->data->user,$this->userGroupModel->select()->where('user_id',$this->data->user)->where('group_id',5)->find());
                // remove guest users. 

                if ($this->userGroupModel->select()->where('user_id',$this->data->user)->where('group_id',5)->find()) {
                    if ($this->userModel->delete($this->data->user)) {
                        $this->logAction('0x6813','user.delete.guest');
                    } else {
                        $this->logAction('0x2601','error.delete.guest');
                    }
                }
                $this->userModel->purgeDeleted();

                $this->purgeGuests();
            }
        } else {

            $this->purgeGuests();

            return 'There are no inactive users';
        }

        
        //$diffActive = array_diff($lastActive,$currentActive);
    }

    public function purgeGuests () {

        $guests = array();

        $lastActive = $this->actionModel->select('room_users.id, room_users.uid, users.id user_id, users.username user_username')->join('users','room_users.uid = users.id','left')->orderby('users.username','asc')->findAll();
        $guestUsers = $this->userGroupModel->select('user_id')->where('group_id',5)->find();

        foreach ($guestUsers as $guestUser) {
            $guests[] = $guestUser['user_id'];
        }
        foreach ($lastActive as $user) {
            if ($key = array_search($user['user_id'],$guests)) {
                unset($guests[$key]);
            }
        }
        foreach ($guests as $guest) {
            //d($guest);
            $where = "users.created_at < '" . Time::now()->subMinutes(30) . "'";
            if ($inactiveGuest = $this->userModel->select()->where($where)->find($guest)){
                
                if ($this->userModel->delete($guest)) {
                    $this->logAction('0x6813','user.delete.guest');

                } else {
                    $this->logAction('0x2601','error.delete.guest');
                }
            }
            
        }
        //d($lastActive,$guests);

    }

    private function logAction ($code, $message ) {

        $data = [
            'uid'=>$this->data->user ?? NULL,
            'rid'=>$this->data->room ?? NULL,
            'action'=>$this->data->action ?? NULL,
            'lastmessage'=>$this->data->lastmessage ?? NULL,
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

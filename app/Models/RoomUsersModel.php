<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomUsersModel extends Model
{
    protected $table      = 'room_users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['uid', 'rid', 'action', 'active','location','gender','mood','chatpic','maxmessages','newmessages','lastmessage','autorefresh','refreshtime','flagged','code','message','mid'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'uid'           => 'required|numeric',
        'rid'           => 'required|numeric',
        'action'        => 'required|numeric',
        'active'        => 'required|numeric',
        'location'      => 'permit_empty|string',
        'gender'        => 'permit_empty|alpha_numeric',
        'mood'          => 'permit_empty|alpha_numeric',
        'chatpic'       => 'permit_empty|string',
        'maxmessages'   => 'permit_empty|numeric',
        'lastmessage'   => 'permit_empty|numeric',
        'refreshtime'   => 'permit_empty|numeric',
        'flagged'       => 'permit_empty|numeric',
        'code'          => 'permit_empty|string',
        'message'       => 'permit_empty|string',
        'mid'           => 'permit_empty|numeric',

    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
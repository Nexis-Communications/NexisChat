<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatpicsTheparkchatModel extends Model
{
    protected $table      = 'chatpics_tpc';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name','filename','uploader','uid','source','groups','explicit','authorized','private'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'name'   =>  'required|is_unique[chatpics_tpc.name]',
        ];
    protected $validationMessages = [
        'name'   =>  [
            'is_unique' =>  'Name must be unique.'
        ]
    ];
    protected $skipValidation     = false;
}
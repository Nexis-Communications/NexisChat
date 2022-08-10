<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatpicsKeywordsModel extends Model
{
    protected $table      = 'chatpics_keywords';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['keyword'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'keyword'   =>  'required|is_unique[chatpics_keywords.keyword]',
        ];
    protected $validationMessages = [
        'keyword'   =>  [
            'is_unique' =>  'Keyword must be unique.'
        ]
    ];
    protected $skipValidation     = false;
}
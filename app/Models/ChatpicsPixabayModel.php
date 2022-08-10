<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatpicsPixabayModel extends Model
{
    protected $table      = 'chatpics_pixabay';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['explicit','sid', 'pageURL', 'type', 'tags','previewURL','previewWidth','previewHeight','webformatURL','webformatWidth','webformatHeight','largeImageURL','imageWidth','imageHeight','imageSize','views','downloads','collections','likes','comments','user_id','user','userImageURL','imported'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'sid'   =>  'required|is_unique[chatpics_pixabay.sid]',
        ];
    protected $validationMessages = [
        'sid'   =>  [
            'is_unique' =>  'id must be unique.'
        ]
    ];
    protected $skipValidation     = false;
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class Contact extends Model
{
    protected $table      = 'contact';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'email', 'message','ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'name'      =>  'required',
        'email'     =>  'required|valid_email',
        'reCaptcha3' => 'required|reCaptcha3[contactForm,0.5]',
        'message'   =>  'required|alpha_numeric',
    ];
    protected $validationMessages = [
        'name'      =>  [
            'required'      =>  'You must enter your name.',
            ],
        'email'     =>  [
            'required'      =>  'You must enter your email.',
            'valid_email'   =>  'You must provide a valid email.',
            ],
        'message'   =>  [
            'required'      =>  'You must enter a message.',
        ],
    ];
    protected $skipValidation     = false;
}
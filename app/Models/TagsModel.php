<?php

namespace App\Models;

use CodeIgniter\Model;

class Tags extends Model
{
    protected $table      = 'user_tags';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'tags'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
 
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
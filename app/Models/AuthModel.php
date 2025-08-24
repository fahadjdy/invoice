<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id','username','password','email','status'
    ];


    // Validation
    protected $validationRules      = [
        "username" => [
            "rules" => "required|is_unique[user.username]",
            'errors' => [
                'required' => 'Username is required.',
                'is_unique' => 'Username is already registered.',
            ],
        ],
        "password" => [
            "rules" => "required",
            'errors' => [
                'required' => 'Password is required.',
            ],
        ],
        "email" => [
            "rules" => "required|is_unique[user.email]",
            'errors' => [
                'required' => 'Email is required.',
                'is_unique' => 'Email is already exist.',
            ],
        ]
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    
}

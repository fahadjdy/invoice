<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\TransactionModel;

class OrdersModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'orders_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'orders_id', 'name', 'gst_type',  'party_id', 'ref_id', 'invoice_id', 'discount', 'created_at', 'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function deletOrders($orders_id){
       $status1 = $this->set('status',0)->where('orders_id',$orders_id)->update();
        $TransactionModel = new TransactionModel();
        $status2 = $TransactionModel->set('status',0)->where('orders_id',$orders_id)->update();

        if($status1 && $status2){
            return true;
        }
        
        return false;
    }
}

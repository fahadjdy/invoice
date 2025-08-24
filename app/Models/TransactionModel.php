<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transaction';
    protected $primaryKey       = 'transaction_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'transaction_id', 'orders_id', 'party_id', 'frame_image_id' , 'location_id', 'product_id', 'extra_product','size1' , 'size2', 'price', 'invoice_id', 'qty', 'total_price', 'created_at', 'updated_at', 'status'
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
    
    // public function sumTotalPrice() {
    //     return $this->select('SUM(total_price)')->get()->getRowArray();
    // }
    
    public function sumTotalPrice($column, $value, $from, $to) {
        $data = $this->select('SUM(total_price) as total_price')->join('orders o','o.orders_id = transaction.orders_id');
        if( $column !== NULL)
        {
            $data->where('o.'.$column, $value);
        }
        // echo "<pre>"; print_r($from); echo "</pre>"; die();
        $data->where('transaction.created_at BETWEEN "'.$from.'" AND "'.$to.'"');
        $data = $data->first();
        return $data['total_price'];
    }
    
}

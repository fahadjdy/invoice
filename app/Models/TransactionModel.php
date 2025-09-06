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
        $builder = $this->builder(); // transaction table का builder

        $builder->select("
            SUM(
                CASE 
                    WHEN o.gst_type = 'With GST' 
                        THEN COALESCE(transaction.total_price,0) * 1.18 - COALESCE(o.discount,0)
                    ELSE COALESCE(transaction.total_price,0) - COALESCE(o.discount,0)
                END
            ) as total_price
        ")
        ->join('orders o','o.orders_id = transaction.orders_id');

        // ✅ ref_id filter
        if (!empty($column) && !empty($value)) {
            if ($column === 'ref_id') {
                $builder->where('o.ref_id', $value);
            } else {
                $builder->where('o.' . $column, $value);
            }
        }

        // ✅ date range filter
        if (!empty($from) && !empty($to)) {
            $builder->where('DATE(transaction.created_at) >=', $from);
            $builder->where('DATE(transaction.created_at) <=', $to);
        }
        // echo $builder->getCompiledSelect(); exit; // Debugging line to see the generated SQL query
        $data = $builder->get()->getRowArray();
        return $data['total_price'] ?? 0;
    }


    
}

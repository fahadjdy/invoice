<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PartyModel;
use App\Models\OrdersModel;
use App\Models\TransactionModel;

class Referral extends BaseController
{
    public function index()
    {
        $data['pageTitle'] = 'referral';
        return view('referral/referral', $data);
    }

    public function getReferralListAjax()
    {
       $db = \Config\Database::connect();

        $sub = $db->table('transaction t')
            ->select('t.orders_id, SUM(t.total_price) AS total_amount', false)
            ->groupBy('t.orders_id');

        $query = $db->table('orders o')
            ->select("
                o.orders_id,
                p.name AS party_name,
                CASE
                    WHEN o.ref_id IS NULL OR o.ref_id = 0 THEN NULL
                    WHEN r.party_id = p.party_id THEN NULL
                    WHEN r.name = p.name THEN NULL
                    ELSE r.name
                END AS referral_name,o.created_at,
                CASE 
                    WHEN o.gst_type = 'With GST' THEN tt.total_amount * 1.18 - o.discount
                    ELSE tt.total_amount - o.discount
                END AS total_amount
            ", false)
            ->join('party p', 'p.party_id = o.party_id', 'left')
            ->join('party r', 'r.party_id = o.ref_id', 'left')
            ->join('(' . $sub->getCompiledSelect() . ') tt', 'tt.orders_id = o.orders_id')
            ->where('o.ref_id != 0')
            ->where('o.ref_id != o.party_id');

        $result = $query->get()->getResultArray();
            foreach ($result as $key => $val) {
                $result[$key]['created_at'] = dateFormat($val['created_at']);
                $result[$key]['total_amount'] = inrFormat($val['total_amount']);
            }

        $data['data'] = $result;

        echo json_encode($data);
        exit;

    }

}

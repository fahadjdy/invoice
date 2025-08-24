<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PartyModel;
use App\Models\OrdersModel;

class Referral extends BaseController
{
    public function index()
    {
        $data['pageTitle'] = 'referral';
        
        return view('referral/referral', $data);
    }

    public function getReferralListAjax()
    {
        $OrdersModel = new OrdersModel();
        $result = $OrdersModel->select('p.name as party_name, r.name as referral_name, COUNT(DISTINCT o.orders_id) as order_count, SUM(t.total_price) as total_amount')
        ->from('orders as o')
        ->join('transaction as t', 'o.orders_id = t.orders_id', 'left')
        ->join('party as p', 'p.party_id = o.party_id', 'left')
        ->join('party as r', 'r.party_id = o.ref_id', 'left')
        ->where('o.ref_id !=', 0)
        ->groupBy('o.party_id')
        ->findAll();
        // p($OrdersModel->db->getLastQuery());
        $data['data'] = [];
        if (!empty($result)) {

            foreach ($result as $value) {


            //     $action =  '<a href="' . base_url('addOrUpdateParty/' . $value['party_id']) . '"><button   class="btn btn-light btn-sm waves-effect " ><i
            // class="mdi mdi-square-edit-outline me-1"></i> Edit</button></a>';

            //     $action .= '<button type="button" id="' . $value['party_id'] . '" class="btn btn-light btn-sm waves-effect delete mx-2"> <i
            //     class="mdi mdi-trash-can me-1"></i> Delete</button>';

            //     if (empty($action)) {
            //         $action = '--';
            //     }

                $row = $value;



                // // for status column 
                // if ($value['status'] == 1) {
                //     $row['status'] = 'Active';
                // } else {
                //     $row['status'] = 'Deactive';
                // }


                // $row['action'] = $action;
                $data['data'][] = $row;
            }
        }

        echo json_encode($data);
        exit;
    }

}

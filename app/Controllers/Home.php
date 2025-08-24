<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\PartyModel;
use App\Models\ProfileModel;
use App\Models\TransactionModel;
use App\Models\OrdersModel;

class Home extends BaseController
{


    public function index()
    {
        $PartyModel = new PartyModel();
        $data['parties'] = $PartyModel->countParty();
        
        // $party_list = $PartyModel->query('SELECT party.*, SUM(transaction.total_price) FROM `orders` JOIN transaction ON orders.orders_id = transaction.orders_id JOIN party ON party.party_id = orders.party_id GROUP BY orders.party_id HAVING SUM(transaction.total_price) !=0');
        
        $party_list = $PartyModel->select('p.name as party_name , p.party_id')
        ->from('orders')
        ->join('transaction', 'orders.orders_id = transaction.orders_id')
        ->join('party as p', 'p.party_id = orders.party_id')
        ->groupBy('orders.party_id')
        ->having('SUM(transaction.total_price) !=', 0)
        ->findAll();

        $data['party_list'] = array_column($party_list, 'party_name', 'party_id');
        
        $ref_list = $PartyModel->select('p.name as party_name , p.party_id')
        ->from('orders')
        ->join('transaction', 'orders.orders_id = transaction.orders_id')
        ->join('party as p', 'p.party_id = orders.ref_id')
        ->where('orders.ref_id !=', 0)
        ->groupBy('orders.ref_id')
        ->having('SUM(transaction.total_price) !=', 0)
        ->findAll();
        $data['ref_list'] = array_column($ref_list, 'party_name', 'party_id');
        
        $from = date("Y-m-d H:i:s", 0);
        $to = date("Y-m-d H:i:s");
        $TransactionModel = new TransactionModel();
        $data['party_transactions'] = $TransactionModel->sumTotalPrice(NULL, NULL, $from, $to);
        // p($data['party_transactions']);
        
        $data['ref_transactions'] = $TransactionModel->sumTotalPrice('ref_id !=', 0, $from, $to);
        
        $OrdersModel = new OrdersModel();
        $data['latest_orders'] = $OrdersModel
                                        ->select('orders.name as orders_name,party.name as party_name, SUM(transaction.total_price) as total_price')
                                        ->join('party','party.party_id = orders.party_id')
                                        ->join('transaction','transaction.transaction_id = orders.orders_id')
                                        ->groupBy('orders.orders_id')
                                        ->orderBy('orders.orders_id','DESC')
                                        ->limit(5)->findAll();
        // dd($data['latest_orders']);
        $data['pageTitle'] = 'Dashboard';
        return view('index', $data);
    }
    
    public function partyFilter($party_id = NULL, $from = NULL, $to = NULL)
    {
        // dd($party_id);
        // p($this->request->getPost());
        $column = ($party_id != NULL && $party_id != 0) ? 'party_id' :  NULL;
        $value = ($party_id != NULL && $party_id != 0) ? $party_id :  NULL;
        $from = empty($from) ? date('Y-m-d H:i:s', 0) : date('Y-m-d H:i:s', strtotime($from));
        // echo "<pre>"; print_r($from); echo "</pre>"; die();
        $to = empty($to) ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($to));
        $TransactionModel = new TransactionModel();
        $party_transactions = $TransactionModel->sumTotalPrice($column, $value, $from, $to);
        // dd($party_transactions , $TransactionModel->db->getLastQuery());
        echo json_encode($party_transactions);
        exit;
    }
    
    public function refFilter($ref_id = NULL, $from = NULL, $to = NULL)
    {
        // p($ref_id);
        $column = ($ref_id != NULL && $ref_id != 0) ? 'ref_id' :  'ref_id !=';
        $value = ($ref_id != NULL && $ref_id != 0) ? $ref_id :  0;
        $from = empty($from) ? date('Y-m-d H:i:s', 0) : date('Y-m-d H:i:s', strtotime($from));
        $to = empty($to) ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($to));
        $TransactionModel = new TransactionModel();
        $ref_transactions = $TransactionModel->sumTotalPrice($column, $value, $from, $to);
        // dd($ref_transactions, $TransactionModel->db->getLastQuery());
        echo json_encode($ref_transactions);
        exit;
    }

    public function profile()
    {
        $data['pageTitle'] = 'profile';
        $profileModel = new  ProfileModel();
        $data['data'] = $profileModel->getProfile();
        return view('profile', $data);
    }


    public function updateProfile()
    {
        $profileModel = new  ProfileModel();
        $profile_id = 1;
        $data = $this->request->getPost();

        $file = $this->request->getFile('logo');
        if (!empty($file->getName())) {


            $logo = '';
            if ($file) {
                $logo = $file->getRandomName();
            }
            $dbLogo = $profileModel->select('logo')->where('profile_id', 1)->first();
            $old_logo = '';
            if (!empty($dbLogo)) {
                $old_logo = $dbLogo['logo'];
            }


            $datalogo = [];
            if ($logo != '') {

                if (file_exists(FCPATH . 'assets/images/profile/' . $old_logo) && !empty($old_logo)) {
                    $deleted = unlink(FCPATH . 'assets/images/profile/' . $old_logo);
                }

                $targetfolder = "assets/images/profile/";
                $targetfolder = $targetfolder . basename($logo);
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetfolder)) {
                    $datalogo = array(
                        'logo' => $logo
                    );
                    $data = array_merge($data, $datalogo);
                }
            }
        }


        $where = [
            'profile_id' => $profile_id
        ];
        $profileModel->set($data)->where($where)->update();

        return redirect()->to('profile');
    }

    public function setting()
    {
        $data['pageTitle'] = 'setting';
        return view('setting', $data);
    }
}

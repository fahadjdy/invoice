<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Order extends BaseController
{
    public function index()
    {
        $data['pageTitle'] = 'Order Listing';
        $hassAccessOrderAdd = true;
        $data['add'] = ($hassAccessOrderAdd) ? '<div class="d-flex justify-content-end "><a href="' . base_url('addOrUpdateOrder') . '"><button class="btn btn-primary waves-effect waves-light mb-3 " > <i class="fa fa-plus"></i> Add ' . $data['pageTitle'] . '</button></a></div>' : '';

        return view('order/order', $data);
    }
}

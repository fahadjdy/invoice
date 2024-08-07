<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\PartyModel;

class Home extends BaseController
{


    public function index()
    {
        $data['pageTitle'] = 'Dashboard';
        return view('index', $data);
    }

    public function profile()
    {
        $data['pageTitle'] = 'profile';
        return view('profile', $data);
    }

    public function product()
    {
        $data['pageTitle'] = 'product';
        return view('product', $data);
    }

    public function setting()
    {
        $data['pageTitle'] = 'setting';
        return view('setting', $data);
    }
}

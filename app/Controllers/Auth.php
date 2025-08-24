<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthModel;
use App\Models\ProfileModel;

class Auth extends BaseController
{
    public function login(){

        $ProfileModel = new ProfileModel();
        $data['profile'] = $ProfileModel->where('profile_id',1)->first();
        return view('login',$data);
    }


    public function authLogin()
    {
        $validation = \Config\Services::validation();
        $rules = [
            "username" => [
                "rules" => "required",
                'errors' => [
                    'required' => 'Username is required.',
                ],
            ],
            "password" => [
                "rules" => "required",
                'errors' => [
                    'required' => 'Password is required.',
                ],
            ]
        ];

        if ($this->validate($rules)) {


            $session = session();
            $authModel = new AuthModel();
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $where = [
                'username' => $username
            ];
            $data = $authModel->where($where)->first();
            if ($data) {
                
                $psw_original = $data['password'];

                if ($password == $psw_original) {
                    $ses_data = [
                        'user_id' => $data['user_id'],
                        'username' => $data['username'],
                        'isLogin' => true
                    ];
                    $session->set($ses_data);

                    $response = [
                        'status' => true,
                        'redirect_url' => 'dashboard'
                    ];
                    // return redirect()->to('/dashboard');

                } else {
                    $response = [
                        'status' => false,
                        'error' => 'Invalid Password..!'
                    ];
                    // return redirect()->back()->withInput()->with('error', 'Invalid Password..!');
                }
            } else {
                $response = [
                    'status' => false,
                    'error' => 'Invalid Userame..!'
                ];
                // return redirect()->back()->withInput()->with('error', 'Invalid Userame..!');

            }

            echo json_encode($response);
        } else {
            $validationErrors = $validation->getErrors();
            $response = [
                'status' => false,
                'error' => $validationErrors
            ];
            echo json_encode($response);
            // return redirect()->back()->withInput()->with('error', $validationErrors);
        }

    }


    public function logout(){
        $session = session();
        $session->destroy();
       return redirect()->to('/login');
    }
}

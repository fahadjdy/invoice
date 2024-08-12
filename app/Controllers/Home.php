<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\PartyModel;
use App\Models\ProfileModel;

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

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PriceModel;

class Config extends BaseController
{
    public function price()
    {
        $data['pageTitle'] = 'Price';
        $hassAccessPriceAdd = true;
        $data['add'] = ($hassAccessPriceAdd) ? '<div class="d-flex justify-content-end "><a href="' . base_url('/config/price/addOrUpdatePrice') . '"><button class="btn btn-primary waves-effect waves-light mb-3 " > <i class="fa fa-plus"></i> Add ' . $data['pageTitle'] . '</button></a></div>' : '';

        return view('config/price', $data);
    }

    public function getPriceListAjax()
    {
        $PriceModel = new PriceModel();
        $result = $PriceModel->getAllPrice();
        $data['data'] = [];
        if (!empty($result)) {

            foreach ($result as $value) {


                $action =  '<a href="' . base_url('/config/price/addOrUpdatePrice/' . $value['price_id']) . '"><button   class="btn btn-light btn-sm waves-effect " ><i
            class="mdi mdi-square-edit-outline me-1"></i> Edit</button></a>';

                $action .= '<button type="button" id="' . $value['price_id'] . '" class="btn btn-light btn-sm waves-effect delete mx-2"> <i
                class="mdi mdi-trash-can me-1"></i> Delete</button>';

                if (empty($action)) {
                    $action = '--';
                }

                $row = $value;



                // for status column 
                if ($value['status'] == 1) {
                    $row['status'] = 'Active';
                } else {
                    $row['status'] = 'Deactive';
                }


                $row['action'] = $action;
                $data['data'][] = $row;
            }
        }

        echo json_encode($data);
        exit;
    }


    public function addOrUpdatePrice($price_id = 0)
    {
        if ($price_id != 0) {
            $PriceModel = new PriceModel();
            $data['data'] = $PriceModel->where(['price_id' => $price_id])->first();
            if (empty($data['data'])) {
                return redirect()->to('addOrUpdatePrice');
            }
            $data['edit'] = $price_id;
            $data['pageTitle'] = 'Edit Price';
        } else {
            $data['pageTitle'] = 'Add Price';
        }

        return view('config/addOrUpdatePrice', $data);
    }


    public function savePrice()
    {
        try {
            $data = $this->request->getPost();

            $PriceModel = new PriceModel();

            $PriceModel->save($data);
            $response = [
                'status' => true,
                'message' => 'Price Saved Successfully!'
            ];

            echo json_encode($response);
        } catch (\Exception $e) {

            $response = [
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ];
            echo json_encode($response);
        }
    }

    public function deletePrice()
    {
        try {
            $price_id = $this->request->getPost('price_id');
            $PriceModel = new PriceModel();

            $status = $PriceModel->set('status', 0)->where('price_id', $price_id)->update();

            if ($status) {
                echo json_encode(['msg' => 'Price Deleted Successfully..!', 'status' => true]);
            } else {
                echo json_encode(['msg' => 'Something went wrong..!', 'status' => false]);
            }
        } catch (\Exception $e) {
            echo json_encode(['msg' => $e->getMessage(), 'status' => false]);
        }
    }
}

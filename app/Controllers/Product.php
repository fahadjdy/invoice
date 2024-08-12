<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;


class Product extends BaseController
{
    public function index()
    {
        $data['pageTitle'] = 'product';
        $hassAccessProductAdd = true;
        $data['add'] = ($hassAccessProductAdd) ? '<div class="d-flex justify-content-end "><a href="' . base_url('addOrUpdateProduct') . '"><button class="btn btn-primary waves-effect waves-light mb-3 " > <i class="fa fa-plus"></i> Add ' . $data['pageTitle'] . '</button></a></div>' : '';

        return view('product/product', $data);
    }

    

    public function saveProduct()
    {
        try {
            $data = $this->request->getPost();

            $ProductModel = new ProductModel();

            $ProductModel->save($data);
            $response = [
                'status' => true,
                'message' => 'Product Saved Successfully!'
            ];

            echo json_encode($response);
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            // Check if the exception message contains "Duplicate entry"
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $response = [
                    'status' => false,
                    'message' => 'The Product already exists.'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ];
            }
            echo json_encode($response);
        } catch (\Exception $e) {

            $response = [
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ];
            echo json_encode($response);
        }
    }

    public function getProductListAjax()
    {
        $ProductModel = new ProductModel();
        $result = $ProductModel->findAll();
        $data['data'] = [];
        if (!empty($result)) {

            foreach ($result as $value) {


                $action =  '<a href="' . base_url('addOrUpdateProduct/' . $value['product_id']) . '"><button   class="btn btn-light btn-sm waves-effect " ><i
            class="mdi mdi-square-edit-outline me-1"></i> Edit</button></a>';

                $action .= '<button type="button" id="' . $value['product_id'] . '" class="btn btn-light btn-sm waves-effect delete mx-2"> <i
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


    public function deleteProduct()
    {

        $product_id = $this->request->getPost('product_id');
        $ProductModel = new ProductModel();

        $status = $ProductModel->set('status', 0)->where('product_id', $product_id)->update();

        if ($status)
            echo json_encode(['msg' => 'Product Deleted Successfully..!', 'status' => true]);
        else
            echo json_encode(['msg' => 'Something went wrong..!', 'status' => false]);
    }


    public function addOrUpdateProduct($product_id = 0)
    {

        if ($product_id != 0) {
            $ProductModel = new ProductModel();
            $data['data'] = $ProductModel->where(['product_id' => $product_id])->first();
            if(empty($data['data'])){
               return redirect()->to('addOrUpdateProduct');
            }
            $data['edit'] = $product_id;
            $data['pageTitle'] = 'Edit Product';
        } else {
            $data['pageTitle'] = 'Add Product';
        }

        return view('Product/addOrUpdateProduct', $data);
    }
}

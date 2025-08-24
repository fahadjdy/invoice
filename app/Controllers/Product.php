<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\FrameImageModel;


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

        return view('product/addOrUpdateProduct', $data);
    }


    public function frame_image(){

        $data['pageTitle'] = 'Frame Image';
        $data['add'] =  '<div class="d-flex justify-content-end "><a href="' . base_url('addOrUpdateFrameImage') . '"><button class="btn btn-primary waves-effect waves-light mb-3 " > <i class="fa fa-plus"></i> Add ' . $data['pageTitle'] . '</button></a></div>' ;

        return view('product/frame_image', $data);
    }

    
    public function getFrameImageListAjax()
    {
        $FrameImageModel = new FrameImageModel();
        $result = $FrameImageModel->findAll();
        $data['data'] = [];
        if (!empty($result)) {

            foreach ($result as $value) {


                $action =  '<a href="' . base_url('addOrUpdateFrameImage/' . $value['frame_image_id']) . '"><button   class="btn btn-light btn-sm waves-effect " ><i
            class="mdi mdi-square-edit-outline me-1"></i> Edit</button></a>';

                $action .= '<button type="button" id="' . $value['frame_image_id'] . '" class="btn btn-light btn-sm waves-effect delete mx-2"> <i
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


    
    public function deleteFrameImage()
    {

        $frame_image_id = $this->request->getPost('frame_image_id');
        $FrameImageModel = new FrameImageModel();

        $status = $FrameImageModel->where('frame_image_id', $frame_image_id)->delete();

        if ($status)
            echo json_encode(['msg' => 'Product Deleted Successfully..!', 'status' => true]);
        else
            echo json_encode(['msg' => 'Something went wrong..!', 'status' => false]);
    }


    public function addOrUpdateFrameImage($frame_image_id = 0){
        if ($frame_image_id != 0) {
            $FrameImageModel = new FrameImageModel();
            $data['data'] = $FrameImageModel->where(['frame_image_id' => $frame_image_id])->first();
            if(empty($data['data'])){
               return redirect()->to('addOrUpdateFrameImage');
            }
            $data['edit'] = $frame_image_id;
            $data['pageTitle'] = 'Edit Frame Image';
        } else {
            $data['pageTitle'] = 'Add Frame Image';
        }

        return view('product/addOrUpdateFrameImage', $data);
    }

    
    public function saveFrameImage()
    {
        try {
            $data = $this->request->getPost();

            $FrameImageModel = new FrameImageModel();

            // ---------- image [Start] -----------
            if (@$_FILES['url']) {
                $file = $this->request->getFile('url');
                $fileName = $file->getRandomName();
                $targetFolder = 'assets/images/FrameImage/';
                $targetFile = $targetFolder . basename($fileName);
                if (move_uploaded_file($_FILES['url']['tmp_name'], $targetFile)) {
                    $data['url'] = $fileName;
    
                    if (@$data['frame_image_id']) {
                        $oldData = $FrameImageModel->find(['frame_image_id' => $data['frame_image_id']]);
                        if (@$oldData['url']) {
                            unlink($targetFolder . $oldData['url']);
    
                        }
                    }
                }
    
            }
            // ---------- image [End] -----------
            $FrameImageModel->save($data);
            $response = [
                'status' => true,
                'message' => 'Frame Image Saved Successfully!'
            ];

            echo json_encode($response);
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            // Check if the exception message contains "Duplicate entry"
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $response = [
                    'status' => false,
                    'message' => 'The Frame Image already exists.'
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
}

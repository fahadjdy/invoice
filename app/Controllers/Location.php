<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LocationModel;

class Location extends BaseController
{
  
    public function index()
    {
        $data['pageTitle'] = 'location';
        $hassAccessLocationAdd = true;
        $data['add'] = ($hassAccessLocationAdd) ? '<div class="d-flex justify-content-end "><a href="' . base_url('addOrUpdateLocation') . '"><button class="btn btn-primary waves-effect waves-light mb-3 " > <i class="fa fa-plus"></i> Add ' . $data['pageTitle'] . '</button></a></div>' : '';

        return view('location/location', $data);
    }

    

    public function saveLocation()
    {
        try {
            $data = $this->request->getPost();

            $LocationModel = new LocationModel();

            $LocationModel->save($data);
            $response = [
                'status' => true,
                'message' => 'Location Saved Successfully!'
            ];

            echo json_encode($response);
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            // Check if the exception message contains "Duplicate entry"
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $response = [
                    'status' => false,
                    'message' => 'The Location already exists.'
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

    public function getLocationListAjax()
    {
        $LocationModel = new LocationModel();
        $result = $LocationModel->where('is_deleted','0')->orderBy('location_id','DESC')->findAll();
        $data['data'] = [];
        if (!empty($result)) {

            foreach ($result as $value) {


                $action =  '<a href="' . base_url('addOrUpdateLocation/' . $value['location_id']) . '"><button   class="btn btn-light btn-sm waves-effect " ><i
            class="mdi mdi-square-edit-outline me-1"></i> Edit</button></a>';

                $action .= '<button type="button" id="' . $value['location_id'] . '" class="btn btn-light btn-sm waves-effect delete mx-2"> <i
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


    public function deleteLocation()
    {
        $location_id = $this->request->getPost('location_id');
        $LocationModel = new LocationModel();

        $status = $LocationModel
            ->set('is_deleted', 1)
            ->set('deleted_at', date('Y-m-d H:i:s'))
            ->where('location_id', $location_id)
            ->update();

        if ($status) {
            echo json_encode(['msg' => 'Location Deleted Successfully..!', 'status' => true]);
        } else {
            echo json_encode(['msg' => 'Something went wrong..!', 'status' => false]);
        }
    }

    public function addOrUpdateLocation($location_id = 0)
    {

        if ($location_id != 0) {
            $LocationModel = new LocationModel();
            $data['data'] = $LocationModel->where(['location_id' => $location_id])->first();
            if(empty($data['data'])){
                return redirect()->to('addOrUpdateLocation');
             }

            $data['edit'] = $location_id;
            $data['pageTitle'] = 'Edit Location';
        } else {
            $data['pageTitle'] = 'Add Location';
        }

        return view('location/addOrUpdateLocation', $data);
    }
}

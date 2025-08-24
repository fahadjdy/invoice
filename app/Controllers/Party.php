<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PartyModel;

class Party extends BaseController
{
    public function index()
    {
        $data['pageTitle'] = 'Party';
        $hassAccessPartyAdd = true;
        $data['add'] = ($hassAccessPartyAdd) ? '<div class="d-flex justify-content-end "><a href="' . base_url('addOrUpdateParty') . '"><button class="btn btn-primary waves-effect waves-light mb-3 " > <i class="fa fa-plus"></i> Add ' . $data['pageTitle'] . '</button></a></div>' : '';

        return view('party/party', $data);
    }

    public function saveParty()
    {
        try {
            $data = $this->request->getPost();

            $PartyModel = new PartyModel();

            $PartyModel->save($data);
            $response = [
                'status' => true,
                'message' => 'Party Saved Successfully!'
            ];

            echo json_encode($response);
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            // Check if the exception message contains "Duplicate entry"
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $response = [
                    'status' => false,
                    'message' => 'The party already exists.'
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


    public function getPartyListAjax()
    {
        $PartyModel = new PartyModel();
        $result = $PartyModel->orderBy('party_id','DESC')->findAll();
        $data['data'] = [];
        if (!empty($result)) {

            foreach ($result as $value) {


                $action =  '<a href="' . base_url('addOrUpdateParty/' . $value['party_id']) . '"><button   class="btn btn-light btn-sm waves-effect " ><i
            class="mdi mdi-square-edit-outline me-1"></i> Edit</button></a>';

                $action .= '<button type="button" id="' . $value['party_id'] . '" class="btn btn-light btn-sm waves-effect delete mx-2"> <i
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


    public function deleteParty()
    {

        $party_id = $this->request->getPost('party_id');
        $PartyModel = new PartyModel();

        $status = $PartyModel->set('status', 0)->where('party_id', $party_id)->update();

        if ($status)
            echo json_encode(['msg' => 'Party Deleted Successfully..!', 'status' => true]);
        else
            echo json_encode(['msg' => 'Something went wrong..!', 'status' => false]);
    }


    public function addOrUpdateParty($party_id = 0)
    {

        if ($party_id != 0) {
            $PartyModel = new PartyModel();
            $data['data'] = $PartyModel->where(['party_id' => $party_id])->first();
            if(empty($data['data'])){
                return redirect()->to('addOrUpdateParty');
             }
            $data['edit'] = $party_id;
            $data['pageTitle'] = 'Edit Party';
        } else {
            $data['pageTitle'] = 'Add Party';
        }

        return view('party/addOrUpdateParty', $data);
    }
}

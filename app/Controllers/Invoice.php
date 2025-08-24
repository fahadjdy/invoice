<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InvoiceModel;

class Invoice extends BaseController
{
    public function index()
    {
        $data['pageTitle'] = 'Invoice Setting';
        $hassAccessInvoiceAdd = true;
        $data['add'] = ($hassAccessInvoiceAdd) ? '<div class="d-flex justify-content-end "><a href="' . base_url('/config/invoice/addOrUpdateInvoice') . '"><button class="btn btn-primary waves-effect waves-light mb-3 " > <i class="fa fa-plus"></i> Add ' . $data['pageTitle'] . '</button></a></div>' : '';
        return view('config/invoice', $data);
    }

    
    public function saveInvoice(){
        try {
            $data = $this->request->getPost();
            
            if (isset($data['password'])) { 
                $data['password'] = md5($data['password']);
            }
    
            $InvoiceModel = new InvoiceModel();
            
            $InvoiceModel->save($data);
            $response = [
                'status' => true,
                'message' => 'Invoice Saved Successfully!'
            ];
            
            echo json_encode($response);
    
        }catch(\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            // Check if the exception message contains "Duplicate entry"
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $response = [
                    'status' => false,
                    'message' => 'The Invoice already exists.'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ];
            }
            echo json_encode($response);
    
        }catch(\Exception $e) {

            $response = [
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ];
            echo json_encode($response);
        }
    }

    public function getInvoiceListAjax()
    {
        $InvoiceModel = new InvoiceModel();
        $result = $InvoiceModel->findAll();
        $data['data'] = [];
        if (!empty($result)) {

            foreach ($result as $value) {

                $hassAccessInvoiceEdit = true;

                $action = ($hassAccessInvoiceEdit) ? '<a href="' . base_url('/config/invoice/addOrUpdateInvoice/' . $value['invoice_id']) . '"><button   class="btn btn-light btn-sm waves-effect " ><i
            class="mdi mdi-square-edit-outline me-1"></i> Edit</button></a>' : '';

                // role delete access
                $hassAccessInvoiceDelete = true;
                $action .= ($hassAccessInvoiceDelete) ? '<button type="button" id="' . $value['invoice_id'] . '" class="btn btn-light btn-sm waves-effect delete mx-2"> <i
                class="mdi mdi-trash-can me-1"></i> Delete</button>' : '';

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


    public function deleteInvoice()
    {

        $invoice_id = $this->request->getPost('invoice_id');
        $InvoiceModel = new InvoiceModel();

        $status = $InvoiceModel->set('status',0)->where('invoice_id',$invoice_id)->update();
        
        if ($status)
            echo json_encode(['msg' => 'Invoice Deleted Successfully..!', 'status' => true]);
        else
            echo json_encode(['msg' => 'Something went wrong..!', 'status' => false]);
    }


    public function addOrUpdateInvoice($invoice_id = 0)
    {

        if ($invoice_id != 0) {
            $InvoiceModel = new InvoiceModel();
            $data['data'] = $InvoiceModel->where(['invoice_id' => $invoice_id])->first();
            $data['edit'] = $invoice_id;
            $data['pageTitle'] = 'Edit Invoice Management';
        } else {
            $data['pageTitle'] = 'Add Invoice Management';
        }

        return view('config/addOrUpdateInvoice', $data);
    }
}

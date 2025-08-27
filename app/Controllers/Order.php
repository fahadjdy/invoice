<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OrdersModel;
use App\Models\PartyModel;
use App\Models\InvoiceModel;
use App\Models\TransactionModel;
use App\Models\LocationModel;
use App\Models\ProductModel;
use App\Models\FrameImageModel;
use App\Models\ProfileModel;
use TCPDF;

class Order extends BaseController
{

    public function index()
    {
        $data['pageTitle'] = 'Order Listing';
        $data['add'] = '<div class="d-flex justify-content-end "><a href="' . base_url('orders/addOrUpdateOrders') . '"><button class="btn btn-primary waves-effect waves-light mb-3 " > <i class="fa fa-plus"></i> Add ' . $data['pageTitle'] . '</button></a></div>' ;
        return view('order/order', $data);
    }


    public function getOrdersListAjax()
    {
        $OrdersModel = new OrdersModel();
        $result = $OrdersModel->select('orders.*,party.name as party_name')->join('party','party.party_id = orders.party_id','left')->orderBy('orders_id','DESC')->findAll();
        $data['data'] = [];
        if (!empty($result)) {

            foreach ($result as $value) {


                $action =  '<a href="' . base_url('orders/addOrUpdateOrders/' . $value['orders_id']) . '"><button   class="btn btn-light btn-sm waves-effect " ><i
            class="mdi mdi-square-edit-outline me-1"></i> Edit</button></a>';

                $action .= '<a href="' . base_url('orders/print/' . $value['orders_id']) . '" target="_blank"><button type="button"  class="btn btn-light btn-sm waves-effect mx-2"> <i
                class="mdi mdi-printer me-1"></i> Print</button></a>';

                $action .= '<button type="button" id="' . $value['orders_id'] . '" class="btn btn-light btn-sm waves-effect delete mx-2"> <i
                class="mdi mdi-trash-can me-1"></i> Delete</button>';

                if (empty($action)) {
                    $action = '--';
                }

                $row = $value;
                $row['orders_id'] = (int) $row['orders_id']; // force numeric for proper sorting
                $row['action'] = $action;
                $data['data'][] = $row;
            }
        }
        echo json_encode($data);
        exit;
    }


    public function deleteOrders()
    {

        $orders_id = $this->request->getPost('orders_id');
        $OrdersModel = new OrdersModel();  
        $transactionModel = new TransactionModel();

        $status = $OrdersModel->where("orders_id", $orders_id)->delete();
        $status1 = $transactionModel->where("orders_id", $orders_id)->delete();
        if ($status && $status1)
            echo json_encode(['msg' => 'Orders Deleted Successfully..!', 'status' => true]);
        else
            echo json_encode(['msg' => 'Something went wrong..!', 'status' => false]);
    }


    public function addOrUpdateOrders($orders_id = 0)
    {
        // p($orders_id);
        if ($orders_id != 0) {
            
            $OrdersModel = new OrdersModel();
            $transactionModel = new TransactionModel();

            $data['data'] = $OrdersModel->where(['orders_id' => $orders_id])->first();
            $data['transactions'] = $transactionModel->where('orders_id', $orders_id)->findAll();
            // p($data['transactions']);
            if(empty($data['data'])){
               return redirect()->to('orders/addOrUpdateOrders');
            }
            $data['edit'] = $orders_id;
            $data['pageTitle'] = 'Edit Orders';
        } else {
            // $OrdersModel = new OrdersModel();
            // $data['data'] = $OrdersModel->select('MAX(orders_id) + 1 as orders_id')->get()->getRowArray();
            $data['pageTitle'] = 'Add Orders';
        }

        return view('order/addOrUpdateOrders', $data);
    }

    
    public function getPartyNameList(){
        $PartyModel = new PartyModel();
        $parties = $PartyModel->select('party.name as party_name , party_id')
                    ->where('is_deleted',0)->findAll();
        $data = [];
        foreach ($parties as $party) {
            $data[] = [
                'party_id' => $party['party_id'],
                'party_name' => $party['party_name']
            ];
        }

        return $this->response->setJSON(['status' => true, 'data' => $data]);
    }
    public function getInvoiceFormateList(){

        $InvoiceModel = new InvoiceModel();
        $invoices = $InvoiceModel->select('invoice.name as invoice_name , invoice_id')->findAll();

        $data = [];
        foreach ($invoices as $invoice) {
            $data[] = [
                'invoice_id' => $invoice['invoice_id'],
                'invoice_name' => $invoice['invoice_name']
            ];
        }

        return $this->response->setJSON(['status' => true, 'data' => $data]);
    }
    public function getLocationList(){

        $LocationModel = new LocationModel();
        $locations = $LocationModel->select('location.name as location_name , location_id')->where('is_deleted', 0)->findAll();

        $data = [];
        foreach ($locations as $location) {
            $data[] = [
                'location_id' => $location['location_id'],
                'location_name' => $location['location_name']
            ];
        }

        return $this->response->setJSON(['status' => true, 'data' => $data]);
    }

    public function getFrameImageList(){

        $FrameImageModel = new FrameImageModel();
        $FrameImages = $FrameImageModel->select('frame_image.name as frame_image_name , frame_image_id')
        ->where('is_deleted',0)
        ->findAll();

        $data = [];
        foreach ($FrameImages as $frame_image) {
            $data[] = [
                'frame_image_id' => $frame_image['frame_image_id'],
                'frame_image_name' => $frame_image['frame_image_name']
            ];
        }

        return $this->response->setJSON(['status' => true, 'data' => $data]);
    }
    public function getProductList(){

        $ProductModel = new ProductModel();
        $products = $ProductModel->select('product.name as product_name , product_id')
                                    ->where('is_deleted', 0)->findAll();

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name']
            ];
        }

        return $this->response->setJSON(['status' => true, 'data' => $data]);
    }

    public function getOrderDetails($orders_id = null)
    {
        if ($orders_id === null) {
            return $this->response->setJSON(['status' => false, 'message' => 'Order ID is required.']);
        }

        $ordersModel = new OrdersModel();
        $transactionModel = new TransactionModel();

        $order = $ordersModel->find($orders_id);
        if (!$order) {
            return $this->response->setJSON(['status' => false, 'message' => 'Order not found.']);
        }
        
        $transactions = $transactionModel->where('orders_id', $orders_id)->findAll();

        $data = [
            'order' => $order,
            'transactions' => $transactions
        ];

        return $this->response->setJSON(['status' => true, 'data' => $data]);
    }

    public function saveOrders() {
        // p('htgfhtg');
        // Get the posted data
        // echo"<pre>";
        // var_dump($_POST);die();
        $ordersId = $this->request->getPost('orders_id');
        $name = $this->request->getPost('name');
        $partyId = $this->request->getPost('party_id');
        $ref_id = $this->request->getPost('ref_id');
        $gst_type = $this->request->getPost('gst_type');
        $invoiceId = $this->request->getPost('invoice_id') ?? 1;
        $status = $this->request->getPost('status');

        
        // Save orders data
        $ordersModel = new OrdersModel();
        $ordersData = [
            'name'          => $name,
            'party_id'      => $partyId,
            'ref_id'        => $ref_id,
            'gst_type'        => $gst_type,
            'invoice_id'    => (!empty($invoiceId)) ? $invoiceId : 1,
            'status'        => $status
        ];
    
        if ($ordersId) {
            $ordersModel->update($ordersId, $ordersData);
        } else {
            $ordersId = $ordersModel->insert($ordersData);
        }
        
        // Prepare to save transaction data
        $transactionModel = new TransactionModel();
        $frame_image_ids = $this->request->getPost('frame_image_id') ?? [];
        $locations = $this->request->getPost('location_id') ?? [];
        $products = $this->request->getPost('product_id') ?? [];
        $extraProducts = $this->request->getPost('extra_product') ?? [];
        $sizes1 = !empty($this->request->getPost('size1')) ? $this->request->getPost('size1') :  [];
        $sizes2 = !empty($this->request->getPost('size2')) ? $this->request->getPost('size2') :  [];
        // $sizes2 = $this->request->getPost('size2') ?? [];
        $prices = $this->request->getPost('price') ?? [];
        $qtys = $this->request->getPost('qty') ?? [];
        $transactionIds = $this->request->getPost('transaction_id');
        // Initialize array to store multiple transaction data
        $transactionDataArray = [];
        $qtys = array_values($qtys);
        // var_dump($qtys);die();
        $locations = array_values($locations);
        $products = array_values($products);
        $sizes1 = array_values($sizes1);
        $sizes2 = array_values($sizes2);
        $prices = array_values($prices);
        // p($qtys);
        // Loop through each frame image ID
        foreach ($qtys as $index => $qty) {
            // $idx = $index + 1;
            // Skip if no location/product data exists for this index
            // if (!isset($locations[$index]) || !isset($products[$index])) {
            //     continue;
            // }
            // echo "Counter ",$index;

            // Calculate total price for this transaction including sqft
            $totalPrice = 0;
            $sqft = 0;
            if (isset($sizes1[$index]) && isset($sizes2[$index]) && isset($prices[$index]) && isset($qtys[$index])) {
                $sqftArray = array_map(function($size1, $size2) {
                    // p($size1);
                    return ((round($size1,2) * round($size2,2)) / 144); // Convert inches to sqft and multiply by qty
                }, $sizes1[$index], $sizes2[$index]);
            
                $sqft = implode(',', $sqftArray); // Store all sqft values as a comma-separated string
            
                // p($sqft);
                // Correct total price calculation: price * sqft * qty
                $totalPrice = array_sum(array_map(function($price, $sqft, $qty) {
                    // p($sqft);
                    // Check if any value is zero before performing multiplication
                    if (round($sqft,2) == 0) {
                        return (int)$price *  (int)$qty; // Return 0 if any of the values is zero
                    }
                    return $price * round($sqft,2) * $qty; // Perform multiplication if none are zero
                }, $prices[$index], $sqftArray, $qtys[$index]));
                // p($totalPrice);
            }
            
            
            // p($frame_image_ids);

            // Prepare transaction data for this frame image
            $transactionData = [
                'transaction_id' => $transactionIds[$index] ?? null,
                'orders_id' => $ordersId,
                'frame_image_id' => $frame_image_ids[$index] ?? null,
                'location_id' => isset( $locations[$index]) ? implode(',', $locations[$index]) : null,
                'product_id' =>  implode(',', $products[$index]),
                'extra_product' => $extraProducts[$index] ?? null,
                'size1' => implode(',', $sizes1[$index]),
                'size2' => implode(',', $sizes2[$index]),
                'price' => implode(',', $prices[$index]),
                // 'sqft' => $sqft, // Store sqft values
                'qty' => implode(',', $qtys[$index]),
                'total_price' => $totalPrice
            ];
// var_export($transactionData );
            $transactionDataArray[] = $transactionData;
        }
        // echo"<pre>";
        // var_dump($transactionDataArray);die();
        if (!empty($transactionIds)) {
            foreach ($transactionDataArray as $key => $val) {
                if (isset($val)) {
                    if(!empty($val['transaction_id'])){
                        $transactionModel->update($val['transaction_id'] , $val);
                    }else{
                        $transactionModel->insert($val);
                    }
                }
            }
        } else {
            $transactionModel->insertBatch($transactionDataArray);
        }
    
        return $this->response->setJSON(['status' => true, 'message' => 'Order saved successfully']);
    }
    
    public function deleteTransaction()
    {
        try {
            $transaction_id = $this->request->getPost('transaction_id');
    
            if (!$transaction_id) {
                return $this->response->setJSON(['status' => false, 'message' => 'Invalid transaction ID']);
            }
    
            $transactionModel = new TransactionModel();
    
            // Check if the transaction exists before deleting
            if ($transactionModel->where('transaction_id', $transaction_id)->first()) {
                $transactionModel->where('transaction_id', $transaction_id)->delete();
                return $this->response->setJSON(['status' => true, 'message' => 'Transaction deleted successfully']);
            } else {
                return $this->response->setJSON(['status' => false, 'message' => 'Transaction not found']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function getHeaders($invoice_id){
        $invoiceModel = new InvoiceModel();
        $invoiceHeader = $invoiceModel->select('LOWER(header) as header')->where('invoice_id',$invoice_id)->first();
        
        if(!empty($invoiceHeader)){
            switch ($invoiceHeader['header']){
                case 'image': {
                    $header = [
                       'image' => true
                    ];
                    break;
                }
                case 'location': {
                    $header = [
                        'location' => true
                    ];
                    break;
                }
                case 'image,location': {
                    $header = [
                        'image' => true ,
                        'location' => true
                    ];
                    break;
                }
                case '-': {
                    $header = [
                       'default' => true
                    ];
                    break;
                }
                default: {  
                    $header = [
                        'default' => true
                    ];
                }
            }
        }
        return $header;
    }

    public function printOrders($orders_id){
        try{    
            if(is_numeric($orders_id)){
                
                $ordersModel = new OrdersModel();
                $orders = $ordersModel->select('p.name as paty_name, p.address as paty_address , p.contact as party_contact , p.email as party_email , orders.*')->join('party p','p.party_id = orders.party_id','left')->where('orders_id',$orders_id)->first();

                $data = [];
                if(!empty($orders)){
                    $data['orders'] = $orders;   
                    $transactionModel = new TransactionModel();
                    
                    $transactions = $transactionModel->select(' transaction.transaction_id,
                            transaction.orders_id,
                            fi.url as frame_image_url,
                            transaction.location_id,
                            CONCAT(GROUP_CONCAT(DISTINCT p.name ORDER BY p.name SEPARATOR ", "),",",transaction.extra_product) AS product_names,
                            GROUP_CONCAT(DISTINCT transaction.size1 ORDER BY transaction.transaction_id) as sizes1,
                            GROUP_CONCAT(DISTINCT transaction.size2 ORDER BY transaction.transaction_id) as sizes2,
                            GROUP_CONCAT(DISTINCT transaction.price ORDER BY transaction.transaction_id) as prices,
                            GROUP_CONCAT(DISTINCT transaction.qty ORDER BY transaction.transaction_id) as quantities,
                            transaction.total_price,
                            transaction.created_at,
                            transaction.updated_at,
                            transaction.status,
                            GROUP_CONCAT(DISTINCT l.name ORDER BY transaction.transaction_id) as location_names')
                            ->join('frame_image fi','fi.frame_image_id = transaction.frame_image_id','left')
                            ->join('location l', 'FIND_IN_SET(l.location_id, transaction.location_id) > 0', 'left')
                            ->join('product p', 'FIND_IN_SET(p.product_id, transaction.product_id) > 0', 'left')
                            ->where('transaction.orders_id', $orders_id)
                            ->groupBy('
                                transaction.transaction_id, 
                                transaction.orders_id, 
                                transaction.frame_image_id,
                                transaction.total_price, 
                                transaction.created_at, 
                                transaction.updated_at, 
                                transaction.status
                            ')                            
                            ->get()
                            ->getResultArray();
                            // p($transactions);
                            if(!empty($transactions)){
                                $data['transactions'] = $transactions;
                            }
                    $data['headers'] = $this->getHeaders($orders['invoice_id']);

                    $ProfileModel = new ProfileModel();
                    $data['profile'] = $ProfileModel->where('profile_id',1)->first();
                   $this->generatePdf($data);
                }else{
                    return $this->response->setJSON(['status'=> false,'message'=> 'No Orders found']);
                }
            }else{
                return $this->response->setJSON(['status'=> false,'message'=> 'No Orders found']);
            }
        }catch(\Exception $e){
            return $this->response->setJSON(['status'=> false,'message'=> $e->getMessage()]);
        }
                
    }
    public function generatePdf($data) {
        // echo "<pre>";
        // print_r($data);
        // die();
        echo view('Invoice/invoice1',$data);
    }
    
}
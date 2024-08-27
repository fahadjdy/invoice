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


                $action .= '<a href="' . base_url('orders/print/' . $value['orders_id']) . '"><button type="button"  class="btn btn-light btn-sm waves-effect mx-2"> <i
                class="mdi mdi-printer me-1"></i> Print</button></a>';

                $action .= '<button type="button" id="' . $value['orders_id'] . '" class="btn btn-light btn-sm waves-effect delete mx-2"> <i
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


    public function deleteOrders()
    {

        $orders_id = $this->request->getPost('orders_id');
        $OrdersModel = new OrdersModel();

        $status = $OrdersModel->deletOrders($orders_id);

        if ($status)
            echo json_encode(['msg' => 'Orders Deleted Successfully..!', 'status' => true]);
        else
            echo json_encode(['msg' => 'Something went wrong..!', 'status' => false]);
    }


    public function addOrUpdateOrders($orders_id = 0)
    {
        if ($orders_id != 0) {
            
            $OrdersModel = new OrdersModel();
            $transactionModel = new TransactionModel();

            $data['data'] = $OrdersModel->where(['orders_id' => $orders_id])->first();
            $data['transactions'] = $transactionModel->where('orders_id', $orders_id)->findAll();

            if(empty($data['data'])){
               return redirect()->to('addOrUpdateOrders');
            }
            $data['edit'] = $orders_id;
            $data['pageTitle'] = 'Edit Orders';
        } else {
            $OrdersModel = new OrdersModel();
            $data['data'] = $OrdersModel->select('MAX(orders_id) + 1 as orders_id')->get()->getRowArray();
            $data['pageTitle'] = 'Add Orders';
        }

        return view('Order/addOrUpdateOrders', $data);
    }

    
    public function getPartyNameList(){
        $PartyModel = new PartyModel();
        $parties = $PartyModel->select('party.name as party_name , party_id')->findAll();
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
        $locations = $LocationModel->select('location.name as location_name , location_id')->findAll();

        $data = [];
        foreach ($locations as $location) {
            $data[] = [
                'location_id' => $location['location_id'],
                'location_name' => $location['location_name']
            ];
        }

        return $this->response->setJSON(['status' => true, 'data' => $data]);
    }
    public function getProductList(){

        $ProductModel = new ProductModel();
        $products = $ProductModel->select('product.name as product_name , product_id')->findAll();

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
        // $this->request->setMethod('post');
    
        $ordersId = $this->request->getPost('orders_id');
        $name = $this->request->getPost('name');
        $partyId = $this->request->getPost('party_id');
        $invoiceId = $this->request->getPost('invoice_id');
        $status = $this->request->getPost('status');
    
        // Save orders data
        $ordersModel = new OrdersModel();
        $ordersData = [
            'name' => $name,
            'party_id' => $partyId,
            'invoice_id' => $invoiceId,
            'status' => $status
        ];
    
        if ($ordersId) {
            $ordersModel->update($ordersId, $ordersData);
        } else {
            $ordersId = $ordersModel->insert($ordersData);
        }
    
        // Save transaction data
        $transactionModel = new TransactionModel();
        $locations = $this->request->getPost('location_id');
        $products = $this->request->getPost('product_id');
        $extraProducts = $this->request->getPost('extra_product');
        $sizes1 = $this->request->getPost('size1');
        $sizes2 = $this->request->getPost('size2');
        $prices = $this->request->getPost('price');
        $qtys = $this->request->getPost('qty');
   
        foreach ($locations as $index => $locationId) {
            $transactionData = [
                'orders_id' => $ordersId,
                'location_id' => $locationId,
                'product_id' => $products[$index],
                'extra_product' => $extraProducts[$index],
                'size1' => $sizes1[$index],
                'size2' => $sizes2[$index],
                'price' => $prices[$index],
                'qty' => $qtys[$index],
                'total_price' => $prices[$index] * $qtys[$index]
            ];
            if (isset($this->request->getPost('transaction_id')[$index])) {
                $transactionModel->update($this->request->getPost('transaction_id')[$index], $transactionData);
            } else {
                $transactionModel->insert($transactionData);
            }
        }
    
        return $this->response->setJSON(['status' => true, 'message' => 'Order saved successfully']);
    }
    

    public function deleteTransaction(){
        try{

            $transaction_id = $this->request->getPost('transaction_id');
            if(!empty($transaction_id)){
                $transactionModel = new TransactionModel();
                $transactionModel->where('transaction_id',$transaction_id)->delete();
                return $this->response->setJSON(['status'=> true,'message'=> 'Trasanction deleted']);
            }else{
                return $this->response->setJSON(['status'=> false,'message'=> 'Something went wrong!']);
            }
        }catch(\Exception $e){
            return $this->response->setJSON(['status'=> false,'message'=> $e->getMessage()]);
        }
    }

    public function getHeaders($invoice_id){
        $invoiceModel = new InvoiceModel();
        $invoiceHeader = $invoiceModel->select('LOWER(header) as header')->where('invoice_id',$invoice_id)->first();
        
        $header = [
            'SrNo.' , 'Product Description' , 'Size','Qty','Price','Amount'
        ];
        if(!empty($invoiceHeader) && !empty($invoiceHeader['header'])){
            switch ($invoiceHeader['header']){
                case 'images': {
                    $header = [
                        'SrNo.' , 'Image', 'Product Description' , 'Size','Qty','Price','Amount'
                    ];
                    break;
                }
                case 'location': {
                    $header = [
                        'SrNo.' , 'Location', 'Product Description' , 'Size','Qty','Price','Amount'
                    ];
                    break;
                }
                case 'image,location': {
                    $header = [
                        'SrNo.' ,'Image', 'Location', 'Product Description' , 'Size','Qty','Price','Amount'
                    ];
                    break;
                }
                case '-': {
                    $header = [
                        'SrNo.' ,  'Product Description' , 'Size','Qty','Price','Amount'
                    ];
                    break;
                }
                default: {  
                    $header = [
                        'SrNo.' ,  'Product Description' , 'Size','Qty','Price','Amount'
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
                    $transactions = $transactionModel->select('transaction.extra_product,transaction.size1 , transaction.size2, transaction.price ,transaction.qty , transaction.total_price, transaction.created_at , l.name as location_name,p.name as product_name')->join('location l','transaction.location_id  =  l.location_id','left')->join('product p','transaction.product_id  =  p.product_id','left')->where('orders_id',$orders['orders_id'])->findAll();
                    if(!empty($transactions)){
                        $data['transactions'] = $transactions;
                    }
                    $data['headers'] = $this->getHeaders($orders['invoice_id']);
                    p($data);
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
}


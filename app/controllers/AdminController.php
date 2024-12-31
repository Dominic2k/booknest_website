<?php

class AdminController extends DController {
    public function __construct() {
        parent::__construct();
    }

    public function loadAdmin() {
        session_start();
        if(isset($_SESSION['admin_login'])){
            $orderModel = $this->load->model('orderModel');
            $data['orders'] = $orderModel->getAllOrders('orders');
            $this->load->view('admin', $data);
        }else {
            header("Location: " . BASE_URL . "homeController/notfound");
            return;
        }

    }
    
}
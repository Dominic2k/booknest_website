<?php

class OrderController extends DController {
    public function __construct() {
        parent::__construct();
    }

    public function completeOrder() {
        session_start();
        $orderModel = $this->load->model('OrderModel');

        $order_id = $_GET['order_id'];

        // die($order_id);


        $orderStatus = $orderModel->getOrderStatus($order_id);

        if($orderStatus[0]['status'] == 'pending') {
            $condition = "orders.order_id = '$order_id'";
            $status = 'complete';
    
            $data = array(
                'status' => $status                        
            );
    
            $updateResult = $orderModel->updateOrderItemQuantity('orders', $data, $condition);
            if($updateResult) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Đã cập nhật trạng thái đơn hàng thành công!'
                ];
                header('Location: /booknest_website/AdminController/loadAdmin');
                exit();
            }else {
                // die("chưa update");
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Cập nhật trạng thái đơn hàng thất bại!'
                ];
                header('Location: /booknest_website/AdminController/loadAdmin');
                exit();
            }
        }else {
            // die('chưa lấy được status cũ');
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Đơn hành này đã thanh toán thành công rồi!'
            ];
            header('Location: /booknest_website/AdminController/loadAdmin');
            exit();
        }


    }

    public function getOrderDetails() {
        header('Content-Type: application/json');
    
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['order_id'])) {
            echo json_encode(['success' => false, 'message' => 'Không nhận được order_id.']);
            exit();
        }
    
        $order_id = intval($data['order_id']);
    
        $orderModel = $this->load->model('OrderModel');
        $orderDetails = $orderModel->getOrderDetails($order_id);
    
        if ($orderDetails) {
            echo json_encode(['success' => true, 'orderDetails' => $orderDetails]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng.']);
        }
    }

    public function getDashboardStats() {
        header('Content-Type: application/json');
        
        $orderModel = $this->load->model('OrderModel');
        $dashboardData = [
            'weeklyRevenue' => $orderModel->getWeeklyRevenue(),
            'pendingOrders' => $orderModel->getPendingOrders(),
            'totalBooksSold' => $orderModel->getTotalBooksSold(),
            'topSellingBooks' => $orderModel->getTopSellingBooks(),
        ];
    
        echo json_encode(['success' => true, 'data' => $dashboardData]);
    }
}
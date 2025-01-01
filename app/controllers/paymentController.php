<?php
require 'success_payment.php';
class paymentController extends DController
{
    public function buyNowDetail() {
        session_start();
        $orderModel = $this->load->model('orderModel');
        $userModel = $this->load->model('userModel');
        $cartModel = $this->load->model('cartModel');
        $bookModel = $this->load->model('bookModel');
        $data = [];
    
        if (!isset($_SESSION['current_user'])) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Bạn chưa đăng nhập. Vui lòng đăng nhập vào hệ thống!'
            ];
            header('Location: /booknest_website/userController/loginForm');
            exit();
        }
    
        $userId = $_SESSION['current_user']['user_id'];
        $data['user_info'] = $userModel->getUserByUserid('users', $userId);
    
        $book_id = isset($_GET['book_id']) ? $_GET['book_id'] : null; 
        $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1; 
            
        $bookPrice = $orderModel->getBookPrice('books', $book_id);
        $book_price = $bookPrice[0]['price'];
        $totalPrice = $book_price * $quantity;

        $orderData = [
            'user_id' => $userId,
            'status' => 'pending',
            'total_price' => $totalPrice,
        ];

        $orderModel->createOrder('orders', $orderData);
        $orderID = $orderModel->getOrderID('orders', $userId);
        $order_id = $orderID[0]['order_id'];

        $orderItemData = [
            'order_id' => $order_id,
            'book_id' => $book_id,
            'quantity' => $quantity
        ];
        $orderModel->addOrderItem('order_items', $orderItemData);

        $data['user_cart'] = $cartModel->getUserCartStatus($userId, 'pending');
        if (empty($data['user_cart'])) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Không có đơn hàng của order_id này!'
            ];
            header('Location: /booknest_website');
            exit();
        }

        $totalPrice = 0;
        $uniqueBooks = []; 
        foreach ($data['user_cart'] as $item) {
            if (!in_array($item['title'], $uniqueBooks)) {
                $totalPrice += $item['price'] * $item['quantity'];
                $uniqueBooks[] = $item['title']; 
            }
        }
        $data['total_price'] = $totalPrice;

        $total_Price = $totalPrice; 
        $bankTransferInfo = $orderModel->getBankTransferInfo($order_id, $total_Price);
        if (!$bankTransferInfo) {
            die("Không lấy được thông tin thanh toán.");
        }

        $data['bankTransferInfo'] = $bankTransferInfo;

    $this->load->view('Payment', $data);
    }
  
    public function buyNowCart() {
        session_start();
        $orderModel = $this->load->model('orderModel');
        $cartModel = $this->load->model('cartModel');
        $data = [];

        if (!isset($_SESSION['current_user'])) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Bạn chưa đăng nhập. Vui lòng đăng nhập vào hệ thống!'
            ];
            header('Location: /booknest_website/userController/loginForm');
            exit();
        }
        $userId = $_SESSION['current_user']['user_id'];
    
        $data['user_cart'] = $cartModel->getUserCart($userId, 'inCart');
        if (empty($data['user_cart'])) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Giỏ hàng của bạn trống!'
            ];
            header('Location: /booknest_website');
            exit();
        }
        
        $orderID = $orderModel->getOrderIdInCart('orders', $userId);
        $order_id = $orderID[0]['order_id'];

        $totalPrice = 0;
        foreach ($data['user_cart'] as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $data['total_price'] = $totalPrice;

        $total_Price = $totalPrice; 
        $bankTransferInfo = $orderModel->getBankTransferInfo($order_id, $total_Price);
        if (!$bankTransferInfo) {
            die("Không lấy được thông tin thanh toán.");
        }

        $data['bankTransferInfo'] = $bankTransferInfo;

        $this->load->view('Payment', $data);
    }

    public function order() {
        session_start();
        $orderModel = $this->load->model('orderModel');
        $userId = $_SESSION['current_user']['user_id'];
        
        $orderID = $orderModel->getOrderIdInCart('orders', $userId);
        if (!isset($orderID[0]['order_id'])) {
            $orderID = $orderModel->getOrderID('orders', $userId);
        }
        if (isset($orderID[0]['order_id'])) {
            $order_id = $orderID[0]['order_id'];
            $_SESSION['order_id'] = $order_id;
        } else {
            $order_id = null; 
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paymentMethod = $_POST['paymentMethod'];
            $addressDelivery = $_POST['inputAddress'];
            $userName = $_POST['inputName'];
            $userPhone = $_POST['inputPhone'];
            $userNote = $_POST['inputNote'];
    
            if (!$paymentMethod || !$addressDelivery || !$userName || !$userPhone || !$userNote) {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Vui lòng điền đầy đủ thông tin!'
                ];
                header('Location: /booknest_website/paymentController/order');
                exit();
            }

            $status = ($paymentMethod == 'bank_transfer') ? 'complete' : 'pending';
            $data = ['status' => $status];

            $orderModel->updateOrderStatus('orders', $data, "user_id = $userId AND order_id = $order_id");
    
            $paymentData = [
                'order_id' => $order_id,
                'payment_method' => $paymentMethod,
                'address_delivery' => $addressDelivery,
                'user_note' => $userNote
            ];
            $orderModel->insertPayment('payments', $paymentData);
        }
        $table_orders = 'orders';
        $data['bookInOrder'] = $orderModel->getBookInOrder($table_orders, $order_id);
    
        if (empty($data['bookInOrder'])) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Không có sách trong đơn hàng.'
            ];
            header('Location: /booknest_website/cartController');
            exit();
        }
    
        $bookInOrderDetails = $orderModel->getAllBookInOrderDetails($table_orders, $order_id);
        $infoCustomer = $orderModel->getInfoCustomer($table_orders, $order_id);
    
        if (!empty($infoCustomer) && isset($infoCustomer[0])) {
            $email = $infoCustomer[0]['email'];
            $userName = $infoCustomer[0]['username'];
            $totalPayment = $infoCustomer[0]['total_price'];
            $deliveryAddress = $infoCustomer[0]['address_delivery'];
    
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (sendConfirmationEmail($email, $bookInOrderDetails, $userName, $totalPayment, $deliveryAddress)) {
                    echo "Check your email!";
                } else {
                    echo "Failed to send confirmation email.";
                }
            } else {
                echo "Invalid email address.";
            }
        } else {
            echo "Không tìm thấy thông tin khách hàng!";
        }
        
        $this->load->view('payment_success', $data);
    }
}
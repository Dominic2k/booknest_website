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
    
        // Kiểm tra xem người dùng đã đăng nhập chưa
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
    
        // Kiểm tra xem thanh toán từ giỏ hàng hay chi tiết sách
        $book_id = isset($_GET['book_id']) ? $_GET['book_id'] : null; // Lấy từ URL nếu thanh toán từ chi tiết sách
        $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1; // Lấy số lượng từ URL
            // Thanh toán từ chi tiết sách nếu có book_id trong URL
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

        // Tính tổng giá trị đơn hàng
        $totalPrice = 0;
        foreach ($data['user_cart'] as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $data['total_price'] = $totalPrice; 
    

        // Xử lý thanh toán
        $total_Price = $totalPrice; // Tổng giá trị đơn hàng
        $bankTransferInfo = $orderModel->getBankTransferInfo($order_id, $total_Price);
        if (!$bankTransferInfo) {
            die("Không lấy được thông tin thanh toán.");
        }

        $data['bankTransferInfo'] = $bankTransferInfo;

    // Trả về view thanh toán
    $this->load->view('Payment', $data);
    }

    public function buyNowCart() {
        session_start();
        $orderModel = $this->load->model('orderModel');
        $userModel = $this->load->model('userModel');
        $cartModel = $this->load->model('cartModel');
        $bookModel = $this->load->model('bookModel');
        $data = [];

        
        // Kiểm tra xem người dùng đã đăng nhập chưa
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
    
        $orderID = $orderModel->getOrderID('orders', $userId);
        $order_id = $orderID[0]['order_id'];
    
        // Cập nhật trạng thái đơn hàng
        $orderModel->updateOrderStatusFromCart('orders', ['status' => 'pending'], "user_id = $userId AND order_id = $order_id AND status = 'inCart'");
        
        $data['user_cart'] = $cartModel->getUserCartStatus($userId, 'pending');
        if (empty($data['user_cart'])) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Không thể chuyển trạng thái đơn hàng!'
            ];
            header('Location: /booknest_website');
            exit();
        }
    
        // Tính tổng giá trị đơn hàng
        $totalPrice = 0;
        foreach ($data['user_cart'] as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $data['total_price'] = $totalPrice;

        // Xử lý thanh toán
        $total_Price = $totalPrice; // Tổng giá trị đơn hàng
        $bankTransferInfo = $orderModel->getBankTransferInfo($order_id, $total_Price);
        if (!$bankTransferInfo) {
            die("Không lấy được thông tin thanh toán.");
        }

        $data['bankTransferInfo'] = $bankTransferInfo;

    // Trả về view thanh toán
    $this->load->view('Payment', $data);
    }


    public function order() {
        session_start();
        $orderModel = $this->load->model('orderModel');
        $userId = $_SESSION['current_user']['user_id'];

        $orderID = $orderModel->getOrderID('orders', $userId);
        $order_id = $orderID[0]['order_id'];
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paymentMethod = $_POST['paymentMethod'];
            $addressDelivery = $_POST['inputAddress'];
            $userName = $_POST['inputName'];
            $userPhone = $_POST['inputPhone'];
            $userNote = $_POST['inputNote'];
    
            // Kiểm tra thông tin thanh toán
            if (!$paymentMethod || !$addressDelivery || !$userName || !$userPhone || !$userNote) {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Vui lòng điền đầy đủ thông tin!'
                ];
                header('Location: /booknest_website/paymentController/processPayment');
                exit();
            }

            // Cập nhật trạng thái đơn hàng
            $status = ($paymentMethod == 'bank_transfer') ? 'complete' : 'pending';
            $data = ['status' => $status];
            $orderModel->updateOrderStatus('orders', $data, "user_id = $userId AND order_id = $order_id");
    
            // Lưu thông tin thanh toán vào bảng payment
            $paymentData = [
                'order_id' => $order_id,
                'payment_method' => $paymentMethod,
                'address_delivery' => $addressDelivery,
                'user_note' => $userNote
            ];
            $orderModel->insertPayment('payments', $paymentData);

            // Nếu thanh toán bằng chuyển khoản ngân hàng, lấy thông tin ngân hàng và tạo mã QR

    
            // Chuyển hướng đến trang thành công
            header("Location: /booknest_website/paymentController/showBookOrder");
            exit();
        }
    }
    

   public function showBookOrder() {
        session_start();
        $orderModel = $this->load->model('orderModel');
    
        // Kiểm tra session người dùng
        if (!isset($_SESSION['current_user'])) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Bạn chưa đăng nhập. Vui lòng đăng nhập vào hệ thống!'
            ];
            header('Location: /booknest_website/userController/loginForm');
            exit();
        }
        $userId = $_SESSION['current_user']['user_id'];
    
        // Lấy thông tin đơn hàng
        $table_orders = 'orders';
        $data['bookInOrder'] = $orderModel->getBookInOrder($table_orders, $userId);
    
        // Kiểm tra nếu không có đơn hàng
        if (empty($data['bookInOrder'])) {
            die("Không có đơn hàng nào.");
        }

        $bookInOrderDetails= $orderModel->getAllBookInOrderDetails($table_orders, $userId);

        $infoCustomer = $orderModel->getInfoCustomer($table_orders, $userId);

        $email = $infoCustomer[0]['email'];
        $userName = $infoCustomer[0]['username'];
        $totalPayment = $infoCustomer[0]['total_price'];
        $deliveryAddress = $infoCustomer[0]['address_delivery'] ;

        if (sendConfirmationEmail($email, $bookInOrderDetails, $userName, $totalPayment, $deliveryAddress)) {
            echo "Check your email!";
            // header("Location: /booknest_website");
            // exit();
        } else {
            echo "Failed to send confirm.";
        }

        $this->load->view('payment_success', $data);
    }
}



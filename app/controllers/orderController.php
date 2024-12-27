<?php
require 'success_payment.php';
class orderController extends DController {
    public function __construct() {
        parent::__construct();
    }

    // Hàm hiển thị trang thanh toán
    public function Payment() {
        $this->load->view('Payment');
    }

    // Hàm hiển thị trang thành công sau khi thanh toán
    public function orderSuccess() {
        $this->load->view('payment_success');
    }

    // Hàm xử lý thông tin thanh toán
    public function showPaymentInfo() {
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
        $orderInfo = $orderModel->getOrderInfo($table_orders, $userId);

        if (empty($orderInfo)) {
            die("Không tìm thấy đơn hàng nào.");
        }

        // Lấy thông tin đơn hàng mới nhất
        $orderID = $orderInfo[0]['order_id'];
        $totalPrice = $orderInfo[0]['total_price'];

        // Lấy thông tin thanh toán (bao gồm mã QR)
        $bankTransferInfo = $orderModel->getBankTransferInfo($orderID, $totalPrice);
        if (!$bankTransferInfo) {
            die("Không lấy được thông tin thanh toán.");
        }
        // Truyền dữ liệu vào view nếu không có POST hoặc sau khi xử lý thành công
        $data['bankTransferInfo'] = $bankTransferInfo;

        // Kiểm tra nếu có dữ liệu POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy các giá trị từ form
            $paymentMethod = $_POST['paymentMethod'] ?? null;
            $addressDelivery = $_POST['inputAddress'] ?? null;
            $userName = $_POST['inputName'] ?? null;
            $userPhone = $_POST['inputPhone'] ?? null;
            $userNote = $_POST['inputNote'] ?? null;

            // Kiểm tra dữ liệu có hợp lệ không
            if (!$paymentMethod || !$addressDelivery || !$userName || !$userPhone) {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Vui lòng điền đầy đủ thông tin!'
                ];
                header('Location: /booknest_website/orderController/showPaymentInfo');
                exit();
            }

            // Thêm thông tin thanh toán vào bảng payment
            $table_payment = 'payments';
            $paymentData = [
                'order_id' => $orderID,
                'payment_method' => $paymentMethod,
                'address_delivery' => $addressDelivery,
                'user_note' => $userNote
            ];
            $result = $orderModel->insertPayment($table_payment, $paymentData);

            if (!$result) {
                die("Không thể lưu thông tin thanh toán.");
            }

            // Chuyển hướng đến trang payment_success sau khi thanh toán thành công
            header("Location: /booknest_website/orderController/showBookOrder");
            exit();
        }
        $this->load->view('Payment', $data);
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


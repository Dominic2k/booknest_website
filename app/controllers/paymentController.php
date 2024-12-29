<?php
class paymentController extends DController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function viewPayment()
    {
        session_start();
        $book_id = isset($_GET['book_id']) ? $_GET['book_id'] : null;
        $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : null;
        $data = null;

        if ($book_id && $quantity) {
            // 1. có param tên book_id và quantity
            $bookModel = $this->load->model('bookModel');
            $table_book = 'books';
            $book = $bookModel->getBookById($table_book, $book_id)[0];
            $total_price_per_item = $book['price'] * $quantity;
            $data['user_cart'] = [
                [
                    'quantity' => $quantity,
                    "book_id" => $book['book_id'],
                    'image_path' => $book['image_path'],
                    'price' => $book['price'],
                    'title' => $book['title'],
                    'total_price' => $total_price_per_item,
                    'total_price_per_item' => $total_price_per_item
                ]
            ];
        } else {
            // 2. Không có 2 params trên, thì tìm user_payment
            // 3. Nếu không có user_payment thì $data['user_payment'] sẽ rỗng, tý bên view check lại 
            // nếu không có  $data['user_payment'] thì hiển thị chưa có sản phẩm nào trong giỏ hàng 
            $cartModel = $this->load->model('cartModel');
            if (isset($_SESSION['current_user'])) {
                $user_id = $_SESSION['current_user']['user_id'];
                $data['user_cart'] = $cartModel->getUserCart($user_id, 'inCart');
            }
        }

        $this->load->view('Payment', $data);
    }
    public function viewPaymentSuccess()
    {
        $this->load->view('payment_success');
    }

    public function checkout()
    {
        session_start();
        // Lấy toàn bộ form info 
        $name = $_POST['name'] ?? '';
        $address = $_POST['address'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $total_price = $_POST['total_price'] ?? 0;
        $payment_method = $_POST['payment_method'] ?? 'cash';

        // Lấy danh sách sản phẩm
        $products = $_POST['products'] ?? [];

        // Kiểm tra dữ liệu
        if (empty($name) || empty($address) || empty($phone) || empty($products)) {
            echo "Vui lòng điền đầy đủ thông tin và chọn sản phẩm!";
            exit;
        }
        // Tạo đơn hàng mới
        $cartModel = $this->load->model('cartModel');
        $orderModel = $this->load->model('orderModel');
        $user_id = $_SESSION['current_user']['user_id'];
        $table_orders = 'orders';
        // Kiểm tra lại loại thanh toán
        $status = 'pending';
        if ($payment_method == 'bank transfer') {
            $status = 'complete';
        }


        $data = array(
            'user_id' => $user_id,
            'status' => $status,
            'total_price' => $total_price
        );

        $newOrderId = $cartModel->createNewCart($table_orders, $data);
        if ($newOrderId) {
            $table_order_items = 'order_items';
            //Tạo orderItem
            foreach ($products as $product) {
                $book_id = $product['book_id'];
                $quantity = $product['quantity'];

                $data = array(
                    'order_id' => $newOrderId,
                    'book_id' => $book_id,
                    'quantity' => $quantity
                );
                $result = $orderModel->insertBookIntoOrderItems($table_order_items, $data);
                if (!$result) {
                    $_SESSION['flash_message'] = [
                        'type' => 'error',
                        'message' => 'Không thể thêm sản phẩm vào đơn hàng mới!'
                    ];
                }
            }
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Không thể tạo đơn hàng mới!'
            ];
        }

        // Lưu thành công thì Chuyển hướng trang đến payment success
        header('Location: /booknest_website/paymentController/viewPaymentSuccess');
        exit();
    }
}

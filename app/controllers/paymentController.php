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
        // Lấy order_id từ form nếu có
        $order_id = $_POST['order_id'] ?? null;
        // Lấy toàn bộ form info 
        $name = $_POST['inputName'] ?? '';
        $address = $_POST['inputAddress'] ?? '';
        $phone = $_POST['inputPhone'] ?? '';
        $note = $_POST['inputNote'] ?? '';
        $total_price = $_POST['total_price'] ?? 0;
        $payment_method = $_POST['payment_method'] ?? 'cash';

        // Kiểm tra dữ liệu
        if (empty($name) || empty($address) || empty($phone) || empty($note) || empty($payment_method)) {
            echo "Vui lòng điền đầy đủ thông tin và chọn sản phẩm!";
            exit;
        }


        // Load model và các data cần thiết
        $cartModel = $this->load->model('cartModel');
        $orderModel = $this->load->model('orderModel');
        $user_id = $_SESSION['current_user']['user_id'];
        $table_orders = 'orders';
        $table_payments = 'payments';

        if (!empty($order_id)) {
            // Important: Thanh toán từ cart
            // Vì đã có order status inCart trước đó nên chỉ cần các bước sau:
            // 1. Update status inCart thành complete
            // 2. Lưu thông tin từ form vào bảng payments

            // Start logic
            // 1. Update status inCart thành complete
            $condition = "$table_orders.order_id = '$order_id'";

            $data = array(
                'status' => 'complete'
            );
            $orderModel->updateOrderSummary($table_orders, $data, $condition);

            // 2. Lưu thông tin từ form vào bảng payments
            $data_payment = array(
                'order_id' => $order_id,
                'payment_method' => $payment_method,
                'address_delivery' => $address,
                'user_note' => $note,
            );
            $result_payment = $orderModel->insertPayment($table_payments, $data_payment);
            if (!$result_payment) {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Không thể lưu thông tin đơn hàng!'
                ];
            }
        } else {
            // Important: Buy now
            // Vì buy now không có tạo order trước nên các bước như sau
            // 1. Tạo order
            // 2. Tạo order_item (chính là sản phẩm được buy now)
            // 3. Lưu thông tin từ form vào bảng payments

            // Start logic
            // Lấy danh sách sản phẩm
            $products = $_POST['products'] ?? [];

            // TODO: Do chỉ có 1 payment method nên không kiểm tra lại loại thanh toán
            // $status = 'pending';
            // if ($payment_method == 'bank transfer') {
            //     $status = 'complete';
            // }

            // 1. Tạo order
            $data = [
                'user_id' => $user_id,
                'status' => 'complete',
                'total_price' => $total_price
            ];
            $newOrderId = $cartModel->createNewCart($table_orders, $data);
            if ($newOrderId) {
                // set biến toàn cục $order_id để phục vụ chuyển trang sang paymentSuccess
                $order_id = $newOrderId;

                // 2. Tạo order_item (chính là sản phẩm được buy now)
                $table_order_items = 'order_items';
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

                // 3. Lưu thông tin từ form vào bảng payments
                $data_payment = [
                    'order_id' => $order_id,
                    'payment_method' => $payment_method,
                    'address_delivery' => $address,
                    'user_note' => $note,
                ];
                $result_payment = $orderModel->insertPayment($table_payments, $data_payment);
                if (!$result_payment) {
                    $_SESSION['flash_message'] = [
                        'type' => 'error',
                        'message' => 'Không thể lưu thông tin đơn hàng!'
                    ];
                }
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Không thể tạo đơn hàng mới!'
                ];
            }
        }

        // Lưu thành công thì Chuyển hướng trang đến payment success
        header('Location: /booknest_website/paymentController/viewPaymentSuccess');
        exit();
    }
}

<?php 

class OrderModel extends DModel {

    public function __construct() {
        parent::__construct();
    }

    public function insertBookIntoOrderItems($table_order_items, $data) {
        return $this->db->insert($table_order_items, $data);
    }

    public function updateOrderSummary($table_orders, $data, $condition) {
        return $this->db->update($table_orders, $data, $condition);
    }

    public function calculateTotalPrice($table_order_items, $order_id) {
        $sql = "
            SELECT 
                SUM(oi.quantity * b.price) AS total_price
            FROM 
                $table_order_items oi
            JOIN 
                books b ON oi.book_id = b.book_id
            WHERE 
                oi.order_id = :order_id
        ";

        $data = [':order_id' => $order_id];
        return $this->db->select($sql, $data);  
    }
    
    public function getBankTransferInfo($orderId, $total_Price) {
        // Thông tin thanh toán
        $bankTransferInfo = [
            'bankName' => 'VIETTINBANK',
            'accountNumber' => '0312 455 602',
            'accountHolder' => 'BOOKNEST WEBSITE',
            'amount' => $total_Price
        ];
    
        // Tạo đường dẫn thư mục và file QR
        $qrCodesDir = __DIR__ . '/../../public/qr_codes';
        if (!file_exists($qrCodesDir)) {
            mkdir($qrCodesDir, 0777, true);
        }
        $qrFilePath = $qrCodesDir . '/payment_qr_' . $orderId. '.png';
    
        // Tạo mã QR
        if (file_exists(__DIR__ . '/../../phpqrcode/qrlib.php')) {
            require_once __DIR__ . '/../../phpqrcode/qrlib.php';
    
            // Nội dung mã QR
            $qrData = "Bank: " . $bankTransferInfo['bankName'] . "\n" .
                      "Account Number: " . $bankTransferInfo['accountNumber'] . "\n" .
                      "Account Holder: " . $bankTransferInfo['accountHolder'] . "\n" .
                      "Amount: " . $bankTransferInfo['amount'] . " VND\n";
    
            // Lưu mã QR vào file
            QRcode::png($qrData, $qrFilePath, QR_ECLEVEL_L, 10);
        } else {
            throw new Exception('QR Code library is not found');
        }
    
        // Thêm đường dẫn file vào thông tin trả về
        $bankTransferInfo['qrFilePath'] = '../public/qr_codes/payment_qr_' . $orderId . '.png';
        return $bankTransferInfo;
    }

    public function insertPayment($table_payments, $paymentData) {
        return $this->db->insert($table_payments, $paymentData);
    }
    
    public function getBookInOrder($tables_orders, $order_id){
        $sql = "
            SELECT 
                b.book_id, 
                b.title, 
                b.price, 
                i.path, 
                o.total_price, 
                p.address_delivery
            FROM books b
            JOIN order_items oi ON b.book_id = oi.book_id
            JOIN orders o ON oi.order_id = o.order_id
            JOIN images i ON b.book_id = i.book_id
            JOIN payments p ON o.order_id = p.order_id
            WHERE o.order_id = :order_id
            ORDER BY oi.order_item_id
    ";
    
        $data = [':order_id' => $order_id];
        return $this->db->select($sql, $data);
    }
    
    public function getAllBookInOrderDetails($table_orders, $order_id){
        $sql = "
            SELECT 
                i.path,
                b.title,
                b.price,
                oi.quantity
            FROM orders o
            JOIN `order_items` oi ON o.order_id = oi.order_id
            JOIN books b ON b.book_id = oi.book_id
            JOIN images i ON i.book_id = b.book_id
            WHERE o.order_id = :order_id
            ORDER BY oi.order_item_id
            ";

        $data = [':order_id' => $order_id];
        return $this->db->select($sql, $data);
    }

    public function getInfoCustomer($table_orders, $order_id){
        $sql = "
            SELECT 
                o.total_price,
                u.username,
                u.email,
                p.address_delivery
            FROM orders o
            JOIN users u ON o.user_id = u.user_id
            JOIN payments p ON o.order_id = p.order_id
            WHERE o.order_id = :order_id
        ";

        $data = [':order_id' => $order_id];
        return $this->db->select($sql, $data);
    }
    
    public function getOrderItemByOrderIdAndBookId($order_id, $book_id) {
        $sql = "SELECT * FROM order_items WHERE order_id = :order_id AND book_id = :book_id";

        $data = [':order_id' => $order_id,
                ':book_id' => $book_id];
        return $this->db->select($sql, $data);

    }

    public function updateOrderItemQuantity($table_order_items, $data, $condition) {
        return $this->db->update($table_order_items, $data, $condition);
    }

    public function updateOrderStatusFromCart($table_orders, $data, $condition){
        return $this->db->update($table_orders, $data,$condition);
    }
    public function updateOrderStatus($table_orders, $data, $condition){
        return $this->db->update($table_orders, $data, $condition);
    }

    public function getBookPrice($table_books, $bookId){
        $sql = "SELECT price FROM $table_books WHERE book_id = :book_id";
        $data = ['book_id' => $bookId];
        return $this->db->select($sql, $data);
    }

    public function createOrder($table_orders, $data){
        return $this->db->insert($table_orders, $data);
    }
    public function addOrderItem($table_order_items, $data){
        return $this->db->insert($table_order_items, $data);
    }
    public function getOrderId($table_orders, $user_id){
        $sql = "SELECT order_id FROM $table_orders WHERE user_id = :user_id
        ORDER BY created_at DESC
        LIMIT 1";
        
        $data = [':user_id' => $user_id];
        return $this->db->select($sql, $data);
    }
    public function getOrderIdInCart($table_orders, $user_id){
        $sql = "SELECT order_id FROM $table_orders WHERE user_id = :user_id AND status = 'inCart'";
        $data = ['user_id' => $user_id];
        return $this->db->select($sql, $data);
    }

    public function getAllOrders($table_orders, $limit, $skip) {
        $sql = "SELECT o.order_id, o.user_id, u.username AS buyer_name, o.total_price, o.status, o.created_at AS order_date
                FROM $table_orders o
                JOIN users u 
                ON o.user_id = u.user_id
                WHERE o.status IN ('pending', 'complete')
                ORDER BY o.created_at DESC limit $limit offset $skip;
                ";
        return $this->db->select($sql);
    }

    public function getOrderStatus($order_id) {
        $sql = "select orders.status from orders where order_id = $order_id";
        return $this->db->select($sql);
    }

    public function getOrderDetails($orderId) {
        $sql = "SELECT b.title AS product_name, oi.quantity, b.price
                FROM order_items oi
                JOIN books b ON oi.book_id = b.book_id
                WHERE oi.order_id = :order_id";
    
        $data = [':order_id' => $orderId];
        return $this->db->select($sql, $data);
    }

    public function getWeeklyRevenue() {
        $sql = "SELECT SUM(oi.quantity * b.price) AS weekly_revenue
                FROM orders o
                JOIN order_items oi ON o.order_id = oi.order_id
                JOIN books b ON oi.book_id = b.book_id
                WHERE YEARWEEK(o.created_at, 1) = YEARWEEK(CURDATE(), 1)";
        return $this->db->select($sql);
        // [0]['weekly_revenue'] ?? 0
    }

    public function getPendingOrders() {
        $sql = "SELECT COUNT(*) AS pending_orders FROM orders WHERE status = 'pending'";
        return $this->db->select($sql);
    }
    
    public function getTotalBooksSold() {
        $sql = "SELECT SUM(quantity) AS total_books_sold FROM order_items";
        return $this->db->select($sql);
    }

    public function getTopSellingBooks() {
        $sql = "SELECT b.title, SUM(oi.quantity) AS total_sold
                FROM order_items oi
                JOIN books b ON oi.book_id = b.book_id
                GROUP BY b.book_id
                ORDER BY total_sold DESC
                LIMIT 5";
        return $this->db->select($sql);
    }

    public function getOrderItems($orderId) {
        $sql = "SELECT book_id, quantity FROM order_items WHERE order_id = $orderId";
        return $this->db->select($sql);
    }

    public function updateStock($table_order_items, $data, $condition) {
        return $this->db->update($table_order_items, $data, $condition);
    }

    public function getQuantity($book_id){
        $sql = "select books.stock from books where book_id = $book_id";
        return $this->db->select($sql);
    }

    public function getCountOrders() {
        $sql = "select count(*) from orders";
        return $this->db->select($sql);
    }
} 

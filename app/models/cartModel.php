<?php 

class cartModel extends DModel {

    public function __construct() {
        parent::__construct();
    }

    public function getCartByUserIdAndStatus($user_id, $status) {
        $sql = "SELECT * FROM `orders` WHERE `user_id` = :user_id AND `status` = :status LIMIT 1";
        
        $data = [':user_id' => $user_id, 'status' => $status];
        return $this->db->select($sql, $data);
    }
    public function getUserCart($user_id, $status) {
        $sql = "SELECT 
                    books.book_id,
                    books.title,
                    books.price,
                    order_items.quantity,
                    order_items.order_item_id,
                    (books.price * order_items.quantity) AS total_price_per_item,
                    images.path AS image_path,
                    orders.total_price,
                    orders.order_id
                FROM 
                    orders
                JOIN 
                    order_items ON orders.order_id = order_items.order_id
                JOIN 
                    books ON order_items.book_id = books.book_id
                LEFT JOIN 
                    images ON books.book_id = images.book_id
                WHERE 
                    orders.user_id = :user_id
                    AND orders.status = :status
                GROUP BY 
                    order_items.order_item_id
                ORDER BY 
                    books.title ASC;
                ";
        
        $data = [':user_id' => $user_id,
                 ':status' => $status];
        return $this->db->select($sql, $data);
    }
    public function getUserCartStatus($user_id, $status) {
        // Bước 1: Lấy order_id của đơn hàng gần nhất
        $sqlOrder = "SELECT orders.order_id
                     FROM orders
                     WHERE orders.user_id = :user_id
                     AND orders.status = :status
                     ORDER BY orders.created_at DESC
                     LIMIT 1";  // Chỉ lấy đơn hàng gần nhất
    
        $dataOrder = [':user_id' => $user_id, ':status' => $status];
        $order = $this->db->select($sqlOrder, $dataOrder);
    
        // Kiểm tra nếu có đơn hàng gần nhất
        if (empty($order)) {
            return []; // Không có đơn hàng nào
        }
    
        $orderId = $order[0]['order_id']; // Lấy order_id của đơn hàng gần nhất
    
        // Bước 2: Lấy tất cả sách của đơn hàng gần nhất
        $sqlBooks = "SELECT 
                        books.book_id,
                        books.title,
                        books.price,
                        order_items.quantity,
                        order_items.order_item_id,
                        (books.price * order_items.quantity) AS total_price_per_item,
                        images.path AS image_path,
                        orders.total_price,
                        orders.order_id
                     FROM 
                        order_items
                     JOIN 
                        books ON order_items.book_id = books.book_id
                     LEFT JOIN 
                        images ON books.book_id = images.book_id
                     JOIN 
                        orders ON order_items.order_id = orders.order_id
                     WHERE 
                        orders.order_id = :order_id
                     ORDER BY 
                        order_items.order_item_id";  // Lấy tất cả sách của đơn hàng gần nhất
    
        $dataBooks = [':order_id' => $orderId];
        return $this->db->select($sqlBooks, $dataBooks);
    }
    
    
    
    
    public function createNewCart($table_orders, $data) {
        return $this->db->insertCart($table_orders, $data);
    }

    public function updateQuantity($table_order_items, $data, $condition) {
        try {
            return $this->db->update($table_order_items, $data, $condition);
        } catch (Exception $e) {
            return false;  // Trả về false nếu có lỗi
        }
    }

    public function deleteItemFromCart($table_order_items, $condition) {
        return $this->db->delete($table_order_items, $condition);
    }
    
}
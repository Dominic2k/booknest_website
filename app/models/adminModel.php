<?php
class adminModel extends DModel {

    public function __construct() {
        parent::__construct();
    }

    public function updateUserAdmin($table_users,$data,$condition){
        return $this->db->update($table_users, $data, $condition);
    }

    public function deleteUserAdmin($table_users, $condition, $limit = 1){
        return $this->db->delete($table_users, $condition, $limit = 1);
    }

    public function getAllBooks($limit, $offset){
        $sql = "SELECT 
            b.book_id,
            b.title,
            b.author,
            b.price,
            b.description,
            b.stock,
            MIN(i.path) AS image_path, -- Lấy ảnh đầu tiên theo ID nhỏ nhất
            c.name AS category_name
        FROM books b
        JOIN images i ON b.book_id = i.book_id
        JOIN categories c ON b.category_id = c.category_id
        GROUP BY 
            b.book_id, b.title, b.author, b.price, b.description, b.stock, c.name
        ORDER BY 
            b.book_id ASC
        LIMIT $limit OFFSET $offset;
                ";
        return $this->db->select($sql);
    }

    public function getCategoryID($table_categories, $categoryBook){
        $sql = "SELECT $table_categories.category_id FROM $table_categories WHERE $table_categories.name = :name";
        $data = [':name' => $categoryBook];
        return $this->db->select($sql, $data);  
    }

    public function updateBookAdmin($table_books,$data,$condition){
        return $this->db->update($table_books, $data, $condition);
    }

    public function deleteBookAdmin($table_books, $condition, $limit = 1){
        return $this->db->delete($table_books, $condition, $limit = 1);
    }

    public function addNewBook($table_books, $data) {
        // Thực hiện câu lệnh INSERT vào bảng books
        $this->db->insert($table_books, $data);
        
        // Kiểm tra xem ID mới nhất có hợp lệ không
        $book_id = $this->db->lastInsertId();  // Lấy ID của bản ghi mới nhất
        
        if ($book_id) {
            return $book_id;  // Trả về book_id nếu thành công
        } else {
            // Xử lý lỗi nếu không thể lấy book_id
            return false;
        }
    }

    public function addImage($table_images, $data, $book_id) {
        // Thêm book_id vào dữ liệu của hình ảnh
        $data['book_id'] = $book_id;
    
        // Thực hiện câu truy vấn INSERT vào bảng images
        return $this->db->insert($table_images, $data);
    }

    public function updateImage($table_images, $dataImage, $condition){
        return $this->db->update($table_images, $dataImage, $condition);
    }

    public function getCountBooks() {
        $sql = "select count(*) from books";
        return $this->db->select($sql);
    }
}
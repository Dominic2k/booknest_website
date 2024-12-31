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

    public function getAllBooks(){
        $sql = "SELECT 
                    b. book_id,
                    b. title,
                    b. author,
                    b. price,
                    b. description,
                    b. stock,
                    i. path as image_path,
                    c. name as category_name
                FROM books b
                JOIN images i ON b.book_id = i.book_id
                JOIN categories c ON b.category_id = c.category_id
                ORDER BY 
                    b.book_id ASC
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
    
}
<?php 

class bookModel extends DModel {

    public function __construct() {
        parent::__construct();
    }

    public function getAllBooks($table_books) {
        $sql = "
                SELECT * from $table_books
                ORDER BY $table_books.stock DESC
                LIMIT 16;
            ";
        return $this->db->select($sql);
    }

    public function getBookById($table_books, $book_id) {
        $sql = "SELECT 
            b.book_id,
            b.title, 
            b.price,
            b.author,
            b.stock,
            b.description,
            i.path AS image_path
        FROM 
            $table_books b
        LEFT JOIN 
            images i ON b.book_id = i.book_id
        where 
        b.book_id = :book_id;";

        $data = [':book_id' => $book_id];

        return $this->db->select($sql, $data);
    }

    public function getBooksByCategoryId($table_books, $category_id) {
        $sql = "
                SELECT 
                    $table_books.book_id,
                    $table_books.title, 
                    $table_books.price, 
                    MIN(i.path) AS image_path
                FROM
                    $table_books
                LEFT JOIN
                    images as i ON $table_books.book_id = i.book_id
                WHERE
                    $table_books.category_id = $category_id
                GROUP BY 
                    $table_books.book_id, $table_books.title, $table_books.price
                ORDER BY
                    $table_books.stock ASC, $table_books.book_id ASC
            ";
        return $this->db->select($sql);
    }

    public function getBestSellingBookHomepage($table_books) {
        $sql = "
        SELECT 
            $table_books.book_id,
            $table_books.title, 
            $table_books.price, 
            MIN(i.path) AS image_path
        FROM 
            $table_books
        LEFT JOIN 
            images i ON $table_books.book_id = i.book_id
        GROUP BY 
            $table_books.book_id, $table_books.title, $table_books.price
        ORDER BY 
            $table_books.stock ASC, $table_books.book_id ASC
        LIMIT 10;
        ";

        return $this->db->select($sql);
    }

    public function getBooksByCategory($table_book, $category) {
        $sql = "
                SELECT $table_book.book_id, $table_book.title, $table_book.price, images.path as image_path
                from $table_book
                left join images on $table_book.book_id = images.book_id
                JOIN categories on books.category_id = categories.category_id
                WHERE categories.name = :category_name
                ORDER BY $table_book.stock DESC
                LIMIT 4;
            ";

        $data = [':category_name' => $category];
        return $this->db->select($sql, $data);  
    }

    public  function getLiteratureBooks($table_books){
        $sql = "
                SELECT $table_books.book_id, $table_books.title, $table_books.price, images.path as image_path
                from $table_books
                left join images on $table_books.book_id = images.book_id
                JOIN categories on books.category_id = categories.category_id
                WHERE categories.name = 'Literature books'
                ORDER BY $table_books.stock DESC
                LIMIT 16;
            ";
        return $this->db->select($sql);
    }

    public function getBookHasTheSameType($table_books, $book_id) {
        $sql = "SELECT b.book_id, b.title, b.author, b.price, b.description, i.path AS image_path 
                FROM $table_books b
                LEFT JOIN images i ON b.book_id = i.book_id
                WHERE b.category_id = (SELECT category_id FROM books WHERE book_id = :book_id) 
                AND b.book_id != :book_id 
                ORDER BY b.stock DESC 
                LIMIT 5";

        $data = [':book_id' => $book_id];
        return $this->db->select($sql, $data);
    }
    
    public function insertBook($table_books, $data) {
        return $this->db->insert($table_books, $data);
    }

    public function updateBook($table_books, $data, $condition) {
        return $this->db->update($table_books, $data, $condition);
    }

    public function deleteBook($table_books, $condition) {
        return $this->db->delete($table_books, $condition);
    }

}


<?php

class BookController extends DController {
    public function __construct() {
        parent::__construct();
    }
    public function showBookDetail() {
        session_start();
        $bookModel = $this->load->model('bookModel');

        $table_book = 'books';
        $book_id = $_GET['book_id'];

        $data['bookById'] = $bookModel->getBookById($table_book, $book_id);
        $data['bookHasTheSameType'] = $bookModel->getBookHasTheSameType($table_book, $book_id);

        $this->load->view('bookdetails', $data);
    }
    
    public function deleteBook(){

    }
    public function updateBook(){

    }

}

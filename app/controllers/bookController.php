<?php

class BookController extends DController {
    public function __construct() {
        parent::__construct();
    }
    public function showBookDetail() {
        session_start();
        $bookModel = $this->load->model('BookModel');

        $table_book = 'books';
        $book_id = $_GET['book_id'];

        $data['bookById'] = $bookModel->getBookById($table_book, $book_id);
        $data['bookHasTheSameType'] = $bookModel->getBookHasTheSameType($table_book, $book_id);

        $this->load->view('books/bookdetails', $data);
    }

    public function showSearch() {
        session_start();
        $bookModel = $this->load->model('BookModel');

        $table_book = 'books';
        $term = isset($_GET['q']) ? $_GET['q'] : null;
        $searchOpt = isset($_GET['searchOpt']) ? $_GET['searchOpt'] : null;

        if (empty($term)) {
            $data['books'] = $bookModel->getAllBooks($table_book);
        } else {
            if (isset($searchOpt) && $searchOpt == "author") {
                $data['books'] = $bookModel->searchBooksByTermAuthor($term);
            } else {
                $data['books'] = $bookModel->searchBooksByTerm($term);
            }
        }

        $data['term'] = $term;

        $this->load->view('books/search', $data);
    }
}
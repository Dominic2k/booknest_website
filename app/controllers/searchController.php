<?php

class searchController extends DController {
    public function __construct() {
        parent::__construct();
    }

    public function showSearch() {
        session_start();
        $bookModel = $this->load->model('bookModel');
        $searchModel = $this->load->model('searchModel');

        $table_book = 'books';
        $term = isset($_GET['q']) ? $_GET['q'] : null;

        if (empty($term)) {
            $data['books'] = $bookModel->getAllBooks($table_book);
        } else {
            $data['books'] = $searchModel->searchBooksByTerm($term);
        }

        $data['term'] = $term;

        $this->load->view('search', $data);
    }
}

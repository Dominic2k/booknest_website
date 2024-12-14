<?php
class homepage extends DController {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $bookModel = $this->load->model('bookModel');
        $table_book = 'books';
        $category_economics_books = "Economics Books";
        $category_lifeskills_books = "Life skills books";
        $category_Health_Lifestyle_books = "Health & Lifestyle";
        $category_Childrens_books = "Children's Books";
        $category_Horror_books = "Horror Books";
        $data['books'] = $bookModel->getAllBooks($table_book);
        $data['LiteratureBooks'] = $bookModel->getLiteratureBooks($table_book);
        $data['EconomicBooks'] = $bookModel->getBooksByCategory($table_book, $category_economics_books);
        $data['LifeSkillsBooks'] = $bookModel->getBooksByCategory($table_book, $category_lifeskills_books);
        $data['HealthLifestyle'] = $bookModel->getBooksByCategory($table_book, $category_Health_Lifestyle_books);
        $data['Childrens_books'] = $bookModel->getBooksByCategory($table_book, $category_Childrens_books);
        $data['Horror_books'] = $bookModel->getBooksByCategory($table_book, $category_Horror_books);
        $data['bookBestSelling'] = $bookModel->getBestSellingBookHomepage($table_book);
        $this->load->view('homepage', $data);
    }

    public function notfound() {
        $this->load->view('404');
    }
}
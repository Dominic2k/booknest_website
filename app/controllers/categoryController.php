<?php

class CategoryController extends DController {
    public function __construct() {
        parent::__construct();
    }

    private function findCategoryById($categories, $category_id) {
        foreach ($categories as $category) {
            if ($category['category_id'] == $category_id) {
                return $category;
            }
        }
        return null; // Nếu không tìm thấy
    }
    public function showCategory() {
        session_start();
        $categoryModel = $this->load->model('categoryModel');
        $bookModel = $this->load->model('bookModel');

        $table_books = 'books';
        $table_categories = 'categories';
        $category_id = $_GET['category_id'];

        $data['categories'] = $categoryModel->getAllCategory($table_categories);
        $data['category'] = $this->findCategoryById($data['categories'], $category_id);
        $data['books'] = $bookModel->getBooksByCategoryId($table_books, $category_id);

        $this->load->view('category', $data);
    }
}

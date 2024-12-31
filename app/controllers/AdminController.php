<?php

class adminController extends DController {
    public function __construct() {
        parent::__construct();
    }

    public function loadAdmin() {
        // User-------------------------------------
        $userModel = $this->load->model('userModel');
        $data['allUser'] = $userModel->getAllUsers();
    // ------------------------------------------   

    // Product---------------------------------------
        $adminModel = $this->load->model('adminModel');
        $data['allBook'] = $adminModel->getAllBooks();

        $this->load->view('admin',$data);
    }

    public function updateUserAdmin(){
        $adminModel = $this->load->model('adminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['userId'];
            $userName = $_POST['userName'];
            $userEmail = $_POST['userEmail'];
            $userPhone = $_POST['userPhone'];
            $userRole = $_POST['userRole'];

            if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format.";
                exit();
            }

            if (!preg_match('/^\d{10,11}$/', $userPhone)) {
                echo "Phone number must be 10 or 11 digits.";
                exit();
            }
            
            if (!in_array($userRole, ['1', '2'])) {
                echo "Role must be '1' or '2'.";
                exit();
            }
            
            $table_users = 'users';
            $data=[
                'username' => $userName,
                'email' => $userEmail,
                'phone' => $userPhone,
                'role' => $userRole
            ];
            $condition = "$table_users.user_id = '$userId'";
            $adminModel->updateUserAdmin($table_users,$data,$condition);

            echo "<script>alert('Bạn đã cập nhật thông tin của user thành công!');</script>";
            echo "<script>window.location.href = '/booknest_website/adminController/loadAdmin';</script>";
            exit();
        }
           
    }

    public function deleteUserAdmin(){
        $adminModel = $this->load->model('adminModel');
        $userModel = $this->load->model('userModel');
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null; 

        $table_users ='users';
        
        $userById = $userModel->getUserByUserid($table_users, $user_id);

        if($userById && $userById['role']=='2'){
            $condition = "$table_users.user_id = '$user_id'";
            $adminModel->deleteUserAdmin($table_users, $condition, $limit=1);
            
            echo "<script>alert('Bạn đã xóa user thành công!');</script>";
            echo "<script>window.location.href = '/booknest_website/adminController/loadAdmin';</script>";
            exit();
        }
        else{
            echo "<script>alert('Bạn không thể xóa User có quyền quản trị!');</script>";
            echo "<script>window.location.href = '/booknest_website/adminController/loadAdmin';</script>";
            exit();
        }
    }

    public function updateBookAdmin(){
        $adminModel = $this->load->model('adminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookId = $_POST['book_id'];
            $titleBook = $_POST['title_book'];
            $authorBook = $_POST['author_book'];
            $priceBook = $_POST['price_book'];
            $descriptionBook = $_POST['description_book'];
            $categoryBook = $_POST['category'];
            $stockBook = $_POST['stock_book'];
            
            $table_books = 'books';
            $table_categories = 'categories';

            $categoryID = $adminModel->getCategoryID($table_categories, $categoryBook);
            $category_id = $categoryID[0]['category_id'];
            if($category_id){
                $data=[
                    'title' => $titleBook,
                    'author' => $authorBook,
                    'price' => $priceBook,
                    'description' => $descriptionBook,
                    'category_id' => $category_id,
                    'stock' => $stockBook
                ];
                $condition = "$table_books.book_id = '$bookId'";
                $adminModel->updateBookAdmin($table_books,$data,$condition);

                echo "<script>alert('Bạn đã cập nhật thông tin của sách thành công!');</script>";
                echo "<script>window.location.href = '/booknest_website/adminController/loadAdmin';</script>";
                exit();
            }
        }   
    }

    public function deleteBookAdmin(){
        $adminModel = $this->load->model('adminModel');
        $book_id = isset($_GET['book_id']) ? $_GET['book_id'] : null;

        $table_books = 'books';
        $condition = "$table_books.book_id = '$book_id'";
        $adminModel->deleteBookAdmin($table_books, $condition, $limit=1);
            
        echo "<script>alert('Bạn đã xóa thông tin sách thành công!');</script>";
        echo "<script>window.location.href = '/booknest_website/adminController/loadAdmin';</script>";
        exit();
    }
}
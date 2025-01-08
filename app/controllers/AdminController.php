<?php

class AdminController extends DController {
    public function __construct() {
        parent::__construct();
    }

    public function loadDashboard() {
      session_start();
            if(isset($_SESSION['admin_login'])){                
                $this->load->view('admin/dashboard');
            }else {
                header("Location: " . BASE_URL . "HomeController/notfound");
                return;
            }
    }
    public function loadOrders() {
      session_start();
            if(isset($_SESSION['admin_login'])){
                $page = 1;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                }
                
                $orderModel = $this->load->model('OrderModel');
                
                $data['countOrders'] = $orderModel->getCountOrders();
                $numberOrders = $data['countOrders'][0]['count(*)'];
                $numberOrderOnOnePage = 2;
                
                $data['numberPage'] = ceil($numberOrders / $numberOrderOnOnePage);

                $skip = $numberOrderOnOnePage * ($page - 1); 
                $data['orders'] = $orderModel->getAllOrders('Orders', $numberOrderOnOnePage, $skip);

                $this->load->view('admin/orders', $data);
            }else {
                header("Location: " . BASE_URL . "HomeController/notfound");
                return;
            }
    }
    public function loadCustomers() {
      session_start();
            if(isset($_SESSION['admin_login'])){
                $page = 1;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                }
                
                $userModel = $this->load->model('UserModel');
                
                $data['countUsers'] = $userModel->getCountUsers();
                $numberUsers = $data['countUsers'][0]['count(*)'];
                $numberUserOnOnePage = 8;
                
                $data['numberPage'] = ceil($numberUsers / $numberUserOnOnePage);

                $skip = $numberUserOnOnePage * ($page - 1); 
                $data['allUser'] = $userModel->getAllUsers($numberUserOnOnePage, $skip);
                $this->load->view('admin/customers', $data);
            }else {
                header("Location: " . BASE_URL . "HomeController/notfound");
                return;
            }
    }
    public function loadBooks() {
      session_start();
            if(isset($_SESSION['admin_login'])){

                $page = 1;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                }
                
                $adminModel = $this->load->model('AdminModel');
                
                $data['countBooks'] = $adminModel->getCountBooks();
                $numberBooks = $data['countBooks'][0]['count(*)'];
                $numberBookOnOnePage = 4;
                
                $data['numberPage'] = ceil($numberBooks / $numberBookOnOnePage);

                $skip = $numberBookOnOnePage * ($page - 1); 

                $data['allBook'] = $adminModel->getAllBooks($numberBookOnOnePage, $skip);

                $this->load->view('admin/books', $data);
            }else {
                header("Location: " . BASE_URL . "HomeController/notfound");
                return;
            }
    }

    public function updateUserAdmin(){
        $adminModel = $this->load->model('AdminModel');
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
            echo "<script>window.location.href = '/booknest_website/AdminController/loadCustomers';</script>";
            exit();
        }
           
    }

    public function deleteUserAdmin(){
        $adminModel = $this->load->model('AdminModel');
        $userModel = $this->load->model('UserModel');
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null; 

        $table_users ='users';
        
        $userById = $userModel->getUserByUserid($table_users, $user_id);

        if($userById && $userById[0]['role'] == 2){
            $condition = "$table_users.user_id = '$user_id'";
            $adminModel->deleteUserAdmin($table_users, $condition, $limit=1);
            
            echo "<script>alert('Bạn đã xóa user thành công!');</script>";
            echo "<script>window.location.href = '/booknest_website/AdminController/loadCustomers';</script>";
            exit();
        }
        else{
            echo "<script>alert('Bạn không thể xóa User có quyền quản trị!');</script>";
            echo "<script>window.location.href = '/booknest_website/AdminController/loadCustomers';</script>";
            exit();
        }
    }

    public function updateBookAdmin(){
        $adminModel = $this->load->model('AdminModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {}
            $bookId = $_POST['book_id'];
            $titleBook = $_POST['title_book'];
            $authorBook = $_POST['author_book'];
            $priceBook = $_POST['price_book'];
            $descriptionBook = $_POST['description_book'];
            $categoryBook = $_POST['category'];
            $stockBook = $_POST['stock_book'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageTmpPath = $_FILES['image']['tmp_name'];
                $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
                $uploadDir = 'public/img/'; 
                $imagePath = $uploadDir . $imageName;
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
                }
            
                if (move_uploaded_file($imageTmpPath, $imagePath)){
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

                        $table_images = 'images';
                        $dataImage = [
                            'path' => $imageName 
                        ];
                        $condition = "$table_images.book_id = '$bookId'";
                        $adminModel->updateImage($table_images, $dataImage, $condition);

                        echo "<script>alert('Bạn đã cập nhật thông tin của sách thành công!');</script>";
                        echo "<script>window.location.href = '/booknest_website/AdminController/loadBooks';</script>";
                        exit();
                }
            }
        }   
    }

    public function deleteBookAdmin(){
        $adminModel = $this->load->model('AdminModel');
        $book_id = isset($_GET['book_id']) ? $_GET['book_id'] : null;

        $table_books = 'books';
        $condition = "$table_books.book_id = '$book_id'";
        $adminModel->deleteBookAdmin($table_books, $condition, $limit=1);
            
        echo "<script>alert('Bạn đã xóa thông tin sách thành công!');</script>";
        echo "<script>window.location.href = '/booknest_website/AdminController/loadBooks';</script>";
        exit();
    }

    public function addNewBookAdmin(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->load->model('AdminModel');

            $bookId = $_POST['book_id'];
            $titleBook = $_POST['title_book'];
            $authorBook = $_POST['author_book'];
            $priceBook = $_POST['price_book'];
            $descriptionBook = $_POST['description_book'];
            $categoryBook = $_POST['category'];
            $stockBook = $_POST['stock_book'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageTmpPath = $_FILES['image']['tmp_name'];

                $character = 'shd'; 
                $timestamp = time(); 
                $imageName = $character . '-' . $timestamp . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                $uploadDir = 'public/img/';
                $imagePath = $uploadDir . $imageName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); 
                }
            
                if (move_uploaded_file($imageTmpPath, $imagePath)) {
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
                        $book_id = $adminModel->addNewBook($table_books, $data);

                        $table_images = 'images';
                        $dataImage = [
                            'path' => $imageName 
                        ];

                        $adminModel->addImage($table_images, $dataImage, $book_id);

                        echo "<script>alert('Bạn đã thêm sách mới thành công!');</script>";
                        echo "<script>window.location.href = '/booknest_website/AdminController/loadBooks';</script>";
                        exit();

                    }
                } else {
                    echo "Failed to upload the image.";
                }
            } else {
                echo "No image uploaded or there was an upload error.";
            }
        }
    }
}
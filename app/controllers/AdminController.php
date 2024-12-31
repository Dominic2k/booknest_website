<?php

class adminController extends DController {
    public function __construct() {
        parent::__construct();
    }

    public function loadAdmin() {
        // -------------------------------------
        $userModel = $this->load->model('userModel');
        $data['allUser'] = $userModel->getAllUsers();
    // ------------------------------------------   

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
            
            // Validate phone number (10 or 11 digits)
            if (!preg_match('/^\d{10,11}$/', $userPhone)) {
                echo "Phone number must be 10 or 11 digits.";
                exit();
            }
            
            // Validate role (only '1' or '2')
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

            header('Location: /booknest_website/adminController/loadAdmin');
            exit();
        }
           
    }

    public function deleteUserAdmin(){
        $adminModel = $this->load->model('adminModel');
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null; 

        $table_users ='users';
        $condition = "$table_users.user_id = '$user_id'";
        $adminModel->deleteUserAdmin($table_users, $condition, $limit=1);

        header('Location: /booknest_website/adminController/loadAdmin');
        exit();
    }
}
<?php
require 'forgot_password.php';
session_start();
class UserController extends DController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updateUserInfo() {
        $userModel = $this->load->model('UserModel');
        // session_start();
        if(isset($_SESSION['current_user']['user_id'])){
            $user_id = $_SESSION['current_user']['user_id'];
        }else{
            die('Không có sesssion');
        }
    
        $table_user = 'users';

        $condition = "$table_user.user_id = '$user_id'";

        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $data = array(
            'username' => $username,
            'password' => $password, // Lưu đường dẫn ảnh vào DB
            'email' => $email,
            'phone' => $phone
            
        );
    
        // Gọi hàm update
        $msgUpdateUserInfo = $userModel->updateUserInfo($table_user, $data, $condition);
        
        if ($msgUpdateUserInfo == 1) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Cập nhật tài khoản thành công!'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Cập nhật tài khoản thất bại!'
            ];
        }
        header("Location: /booknest_website/");
        exit();
    }

    public function registerForm(){
        $this->load->view('users/register_form');
    }

    public function forgotPassForm() {
        $data['check-process'] = 1;
        if(isset($_GET['check'])) {
            if($_GET['check'] == 2) {
                $data['check-process'] = 2;
            };
        }
        $this->load->view('users/forgotPassword', $data);
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->load->model('UserModel');
            $email = $_POST['email'];
            $table = 'users';

            if ($userModel->checkUserExists($table,$email)) {
                $resetCode = rand(100000, 999999);
                $_SESSION['reset_code'] = $resetCode;
                $_SESSION['reset_email'] = $email;
                $_SESSION['reset_expiry'] = time() + 60;


                if (sendCodeResetPassword($email, $resetCode)) {
                    echo "Reset code sent to your email!";
                    header("Location: /booknest_website/UserController/forgotPassForm?check=2");
                    exit();
                } else {
                    echo "Failed to send reset email.";
                }
            } else {
                echo "Email does not exist.";
            }
        }
        $this->load->view('users/forgotPassword');
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $userModel = $this->load->model('UserModel');
            $enteredCode = $_POST['reset_code'];
            $newPassword = $_POST['new_password'];

            if (isset($_SESSION['reset_code']) && isset($_SESSION['reset_expiry']) && time() < $_SESSION['reset_expiry']) {
                if ($enteredCode == $_SESSION['reset_code']) {
                    $email = $_SESSION['reset_email'];
                    $data['check-process'] = 2;
                    $table = 'users';

                    $data = array(
                        'password' => md5($newPassword)
                    );

                    $condition = "$table.email = '$email'";

                    $msgUpdatePassword = $userModel->updatePassword($table, $data, $condition);

                    if ($msgUpdatePassword == 1) {
                        unset($_SESSION['reset_code'], $_SESSION['reset_email'], $_SESSION['reset_expiry']);
                        $_SESSION['flash_message'] = [
                            'type' => 'success',
                            'message' => 'Thay đổi mật khẩu thành công!'
                        ];
                    } else {
                        $_SESSION['flash_message'] = [
                            'type' => 'error',
                            'message' => 'Thay đổi mật khẩu thất bại!'
                        ];
                    }
                    header("Location: /booknest_website/UserController/loginForm");
                    exit();
                } else {
                    echo "Invalid reset code.";
                }
            } else {
                echo "Reset code expired or invalid.";
            }
        }
        $this->load->view('users/forgotPassword');
    }

    public function register() {
        $userModel = $this->load->model('UserModel');

        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phone = "";

        // Ràng buộc
        // Kiểm tra input rỗng
        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Vui lòng điền đầy đủ thông tin!'
            ];
            header('Location: /booknest_website/UserController/registerForm');
            exit();
        }
        // Kiểm tra đúng định dạng email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Email không đúng định dạng!'
            ];
            header('Location: /booknest_website/UserController/registerForm');
            exit();
        }
        // Kiểm tra độ dài mật khẩu
        if (strlen($password) < 6) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Mật khẩu phải có ít nhất 6 ký tự!'
            ];
            header('Location: /booknest_website/UserController/registerForm');
            exit();
        }

        // Kiểm tra user có tồn tại trong db chưa
        $table_user = "users";
        $existingUser = $userModel->checkUserExists($table_user, $email);
        if ($existingUser) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Email này đã tồn tại. Vui lòng dùng email khác!'
            ];
            header('Location: /booknest_website/UserController/registerForm');
            exit();
        }

        $data = array(
            'username' => $username,
            'password' => md5($password),
            'email' => $email,
            'phone' => $phone
        );


        $result = $userModel->insertUser($table_user, $data);

        if ($result == 1) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Đăng ký thành công! Vui lòng đăng nhập!'
            ];
            header('Location: /booknest_website/UserController/loginForm');
            exit();
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Đăng ký thất bại. Vui lòng thử lại!'
            ];
            header('Location: /booknest_website/UserController/registerForm');
            exit();
        }
    }

    public function loginForm()
    {
        $this->load->view('users/login_form');
    }

    public function login()
    {
        $userModel = $this->load->model('UserModel');

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Kiểm tra input không rỗng
        if (empty($username) || empty($password)) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Vui lòng điền đầy đủ thông tin!'
            ];
            header('Location: /booknest_website/UserController/loginForm');
            exit();
        }

        // Kiểm tra độ dài mật khẩu
        if (strlen($password) < 6) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Mật khẩu phải có ít nhất 6 ký tự!'
            ];
            header('Location: /booknest_website/UserController/loginForm');
            exit();
        }

        // Lấy thông tin user dựa theo username từ input
        $table_user = "users";
        $data['all_user'] = $userModel->getAllUsers();
        foreach($data['all_user'] as $value){
            if($value['username'] == $username && $value['password'] == md5($password)){
                if($value['role'] == 1) {
                    $_SESSION['admin_login'] = true;
                    $_SESSION['current_user'] = $value;
                    $_SESSION['is_logged_in'] = true;
                    $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Đăng nhập admin thành công!'
                    ];
                    header('Location: /booknest_website/AdminController/loadAdmin');
                    exit();
                }else {
                    $_SESSION['current_user'] = $value;
                    $_SESSION['is_logged_in'] = true;
                    $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Đăng nhập thành công!'
                    ];
                    header('Location: /booknest_website/');
                    exit();
                }
            }
        }
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'Tài khoản này không tồn tại hoặc sai thông tin đăng nhập, vui lòng kiểm tra lại thông tin!'
        ];
        header('Location: /booknest_website/UserController/loginForm');
        exit();
        
    }

    public function userProfile() {
    
        $userModel = $this->load->model('UserModel');
    
        $table_user = 'users';
        
        if(isset($_SESSION['current_user']['user_id'])){
            $user_id = $_SESSION['current_user']['user_id'];
        }else{
            die("Không có session ở đây");
        }
    
        $data['user'] = $userModel->getUserByUserid($table_user, $user_id);
        $this->load->view('users/profile', $data);
    }

    public function logout(){
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Đăng xuất thành công!'
        ];
        header('Location: /booknest_website/');
        exit();
    }
        
}


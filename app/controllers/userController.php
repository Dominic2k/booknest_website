<?php
require 'forgot_password.php';
session_start();
class userController extends DController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function registerForm()
    {
        $this->load->view('register_form');
    }

    public function forgotPassForm() {
        $data['check-process'] = 1;
        if(isset($_GET['check'])) {
            if($_GET['check'] == 2) {
                $data['check-process'] = 2;
            };
        }
        $this->load->view('forgotPassword', $data);
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->load->model('userModel');
            $email = $_POST['email'];
            $table = 'users';

            if ($userModel->checkUserExists($table,$email)) {
                $resetCode = rand(100000, 999999);
                $_SESSION['reset_code'] = $resetCode;
                $_SESSION['reset_email'] = $email;
                $_SESSION['reset_expiry'] = time() + 60;


                if (sendCodeResetPassword($email, $resetCode)) {
                    echo "Reset code sent to your email!";
                    header("Location: /booknest_website/userController/forgotPassForm?check=2");
                    exit();
                } else {
                    echo "Failed to send reset email.";
                }
            } else {
                echo "Email does not exist.";
            }
        }
        $this->load->view('forgotPassword');
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $userModel = $this->load->model('userModel');
            $enteredCode = $_POST['reset_code'];
            $newPassword = $_POST['new_password'];

            if (isset($_SESSION['reset_code']) && isset($_SESSION['reset_expiry']) && time() < $_SESSION['reset_expiry']) {
                if ($enteredCode == $_SESSION['reset_code']) {
                    $email = $_SESSION['reset_email'];
                    $data['check-process'] = 2;
                    $table = 'users';

                    $data = array(
                        'password' => $newPassword
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
                    header("Location: /booknest_website/userController/loginForm");
                    exit();
                } else {
                    echo "Invalid reset code.";
                }
            } else {
                echo "Reset code expired or invalid.";
            }
        }
        $this->load->view('forgotPassword');
    }


    public function register() {
        $userModel = $this->load->model('userModel');

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
            header('Location: /booknest_website/userController/registerForm');
            exit();
        }
        // Kiểm tra đúng định dạng email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Email không đúng định dạng!'
            ];
            header('Location: /booknest_website/userController/registerForm');
            exit();
        }
        // Kiểm tra độ dài mật khẩu
        if (strlen($password) < 6) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Mật khẩu phải có ít nhất 6 ký tự!'
            ];
            header('Location: /booknest_website/userController/registerForm');
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
            header('Location: /booknest_website/userController/registerForm');
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
            header('Location: /booknest_website/userController/loginForm');
            exit();
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Đăng ký thất bại. Vui lòng thử lại!'
            ];
            header('Location: /booknest_website/userController/registerForm');
            exit();
        }
    }

    // Function Show màn hình login
    public function loginForm()
    {
        $this->load->view('login_form');
    }

    // Function xử lý khi click Login trong LoginForm
    public function login()
    {
        $userModel = $this->load->model('userModel');

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Kiểm tra input không rỗng
        if (empty($username) || empty($password)) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Vui lòng điền đầy đủ thông tin!'
            ];
            header('Location: /booknest_website/userController/loginForm');
            exit();
        }

        // Kiểm tra độ dài mật khẩu
        if (strlen($password) < 6) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Mật khẩu phải có ít nhất 6 ký tự!'
            ];
            header('Location: /booknest_website/userController/loginForm');
            exit();
        }

        // Lấy thông tin user dựa theo username từ input
        $table_user = "users";
        $field_name = "username";
        $user = $userModel->checkUserExistsByField($table_user, $field_name, $username);

        if (!$user) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Tài khoản này không tồn tại, vui lòng kiểm tra lại thông tin!'
            ];
            header('Location: /booknest_website/userController/loginForm');
            exit();
        }

        $hashed_password = md5($password);

        if ($hashed_password != $user["password"]) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Không đúng mật khẩu, vui lòng kiểm tra lại!'
            ];
        }

        // Lưu session vào trong browser để dùng cho các 
        // lần tới mà không cần login lại
        session_start(); 
        $_SESSION['user_id'] = $user["username"];
        $_SESSION['username'] = $user["username"];
        $_SESSION['email'] = $user["email"];
        $_SESSION['is_logged_in'] = true;

        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Đăng nhập thành công!'
        ];
        header('Location: /booknest_website/');
        exit();
    }

    public function logout()
    {
        // Xoá dữ liệu session
        session_unset();

        // Hủy session
        session_destroy();

        // Chuyển hướng người dùng đến trang đăng nhập hoặc trang chủ
        header('Location: /booknest_website/');
        exit();
    }
}

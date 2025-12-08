<?php
class AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $this->model->login($_POST['username']);

            if ($user && password_verify($_POST['password'], $user['password'])) {
                // 1. Lưu thông tin cơ bản
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // 2. Nếu là HDV thì gán thêm ID hồ sơ HDV từ bảng users
                if ($user['role'] === 'hdv' && !empty($user['hdv_id'])) {
                    $_SESSION['hdv_profile_id'] = $user['hdv_id'];
                }

                // 3. Chuyển hướng đến dashboard
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $error = "Sai tài khoản hoặc mật khẩu!";
            }
        }

        include PATH_VIEW . 'auth/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->register($_POST);
            header("Location: index.php?action=login");
            exit;
        }
        include PATH_VIEW . 'auth/register.php';
    }

    public function logout()
    {
        session_destroy();
        header("Location: index.php?action=login");
    }
}

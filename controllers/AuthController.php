<?php
class AuthController {
    private $model;
    public function __construct() {
        $this->model = new UserModel();
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $this->model->login($_POST['username']);
            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $error = "Sai tài khoản hoặc mật khẩu!";
            }
        }
        include PATH_VIEW . 'auth/login.php';
    }
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->register($_POST);
            header("Location: index.php?action=login");
            exit;
        }
        include PATH_VIEW . 'auth/register.php';
    }
    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
    }
}
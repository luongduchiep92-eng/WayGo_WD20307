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
                // 1. Lưu thông tin cơ bản
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email']; // Quan trọng: Phải lưu email
                $_SESSION['role'] = $user['role'];

                // 2. [QUAN TRỌNG] NẾU LÀ HDV -> LẤY ID HỒ SƠ
                if ($user['role'] === 'hdv') {
                    // Gọi hàm lấy ID từ Model (đảm bảo model đã có hàm getHdvIdByEmail)
                    $hdvId = $this->model->getHdvIdByEmail($user['email']);
                    
                    if ($hdvId) {
                        $_SESSION['hdv_profile_id'] = $hdvId;
                    } else {
                        // Trường hợp lỗi: Có tài khoản đăng nhập nhưng chưa có hồ sơ bên bảng huong_dan_viens
                        $_SESSION['hdv_profile_id'] = 0; 
                    }
                }

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
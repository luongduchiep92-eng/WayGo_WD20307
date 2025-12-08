<?php
include_once 'models/UserModel.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        // Khởi tạo model User
        $this->userModel = new UserModel();
    }

    // Action: Danh sách tài khoản
    public function listUser()
    {
        $users = $this->userModel->getAllUsers();
        // Gửi dữ liệu qua View
        include 'views/admin/users/user_list.php';
    }

    // Action: Thêm tài khoản (hiển thị form & xử lý khi submit)
    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form thêm mới
            $data = [
                'username'   => $_POST['username'],
                'full_name'  => $_POST['full_name'],
                'email'      => $_POST['email'],
                'password'   => $_POST['password'],
                'role'       => $_POST['role'],
                'status'     => isset($_POST['status']) ? 1 : 0,  // nếu checkbox "Kích hoạt" được chọn
                'phone'      => $_POST['phone'] ?? ''            // số ĐT (tùy chọn nếu role=hdv)
            ];
            // Gọi model để tạo người dùng mới
            $result = $this->userModel->createUser($data);
            if ($result) {
                // Chuyển hướng về danh sách sau khi thêm thành công
                header("Location: index.php?action=user_list");
            } else {
                $error = "Email hoặc tên đăng nhập đã tồn tại!";
                // Load lại view form thêm kèm thông báo lỗi
                include 'views/admin/users/user_add.php';
            }
        } else {
            // Phương thức GET: hiển thị form thêm
            include 'views/admin/users/user_add.php';
        }
    }

    // Action: Sửa tài khoản
    public function editUser()
    {
        $id = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Thu thập dữ liệu từ form sửa
            $data = [
                'full_name' => $_POST['full_name'],
                'email'     => $_POST['email'],
                'role'      => $_POST['role'],
                'status'    => isset($_POST['status']) ? 1 : 0
            ];
            // Nếu có nhập mật khẩu mới thì đưa vào data
            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }
            // Cập nhật dữ liệu qua model
            $this->userModel->updateUser($id, $data);
            // Chuyển hướng về danh sách tài khoản sau khi lưu
            header("Location: index.php?action=user_list");
        } else {
            // Phương thức GET: lấy thông tin người dùng và hiển thị form
            $user = $this->userModel->getUserById($id);
            include 'views/admin/users/user_edit.php';
        }
    }

    // Action: Xóa tài khoản
    public function deleteUser()
    {
        $id = $_GET['id'] ?? 0;
        if ($id) {
            $this->userModel->deleteUser($id);
        }
        // Sau khi xóa, quay lại trang danh sách
        header("Location: index.php?action=user_list");
    }
}

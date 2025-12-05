<?php
class UserController
{
    private $model;

    public function __construct()
    {
        // Sử dụng UserModel để tương tác CSDL
        $this->model = new UserModel();
    }

    // 3.1. Hiển thị danh sách tài khoản
    public function listUser()
    {
        $users = $this->model->getAllUsers();
        include PATH_VIEW . 'admin/users/user_list.php';
    }

    // 3.2. Thêm tài khoản mới
    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form thêm mới
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email    = $_POST['email'] ?? '';
            $role     = $_POST['role'] ?? '';

            // Mã hóa mật khẩu trước khi lưu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Tạo mảng dữ liệu người dùng mới
            $userData = [
                'username' => $username,
                'password' => $hashedPassword,
                'email'    => $email,
                'role'     => $role
            ];

            // Gọi model để thêm người dùng vào CSDL
            $this->model->insertUser($userData);

            // Chuyển hướng về trang danh sách tài khoản
            header("Location: index.php?action=user_list");
            exit;
        }

        // Phương thức GET: hiển thị form thêm tài khoản
        include PATH_VIEW . 'admin/users/user_add.php';
    }

    // 3.3. Hiển thị form chỉnh sửa và cập nhật tài khoản
    public function editUser()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            // Không có ID -> quay lại danh sách
            header("Location: index.php?action=user_list");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu cập nhật từ form sửa
            $username = $_POST['username'];
            $email    = $_POST['email'] ?? '';
            $role     = $_POST['role'] ?? '';
            $password = $_POST['password'] ?? '';

            // Nếu nhập mật khẩu mới thì mã hóa, không thì giữ nguyên mật khẩu cũ
            $hashedPassword = null;
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            }

            // Cập nhật dữ liệu tài khoản thông qua model
            $this->model->updateUser($id, $username, $email, $role, $hashedPassword);

            // Quay về trang danh sách sau khi cập nhật
            header("Location: index.php?action=user_list");
            exit;
        }

        // Phương thức GET: lấy thông tin tài khoản hiện tại để hiển thị lên form
        $user = $this->model->getUserById($id);
        include PATH_VIEW . 'admin/users/user_edit.php';
    }

    // 3.4. Xóa tài khoản
    public function deleteUser()
    {
        $id = $_GET['id'] ?? 0;
        if ($id) {
            $this->model->deleteUser($id);
        }
        // Sau khi xóa, chuyển hướng về danh sách
        header("Location: index.php?action=user_list");
        exit;
    }
}

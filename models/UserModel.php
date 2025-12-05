<?php
require_once "BaseModel.php";

class UserModel extends BaseModel
{

    // Hàm đăng ký (Đã nâng cấp)
    public function register($data)
    {
        try {
            $this->pdo->beginTransaction(); // Bắt đầu giao dịch an toàn

            // 1. Kiểm tra username hoặc email đã tồn tại chưa
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$data['username'], $data['email']]);
            if ($stmt->rowCount() > 0) {
                return false; // Đã tồn tại
            }

            // 2. Xác định role (chỉ cho phép user hoặc hdv, cấm admin)
            $role = ($data['role'] === 'hdv') ? 'hdv' : 'user';

            // 3. Tạo User
            $sqlUser = "INSERT INTO users (username, password, full_name, email, role) VALUES (?, ?, ?, ?, ?)";
            $stmtUser = $this->pdo->prepare($sqlUser);
            $stmtUser->execute([
                $data['username'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['full_name'],
                $data['email'],
                $role
            ]);

            // 4. [QUAN TRỌNG] Nếu là HDV -> Tự tạo hồ sơ trong bảng huong_dan_viens
            if ($role === 'hdv') {
                $sqlHdv = "INSERT INTO huong_dan_viens (ho_ten, email, so_dien_thoai, loai_hdv, kinh_nghiem_nam, suc_khoe) 
                           VALUES (?, ?, ?, 'Nội địa', 0, 'Tốt')";
                $stmtHdv = $this->pdo->prepare($sqlHdv);
                $stmtHdv->execute([
                    $data['full_name'],
                    $data['email'],
                    $data['phone'] // Lấy từ form
                ]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function login($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getHdvIdByEmail($email)
    {
        // Hàm này rất quan trọng để lấy ID thực của HDV
        $stmt = $this->pdo->prepare("SELECT id FROM huong_dan_viens WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }
    // Lấy tất cả tài khoản (danh sách người dùng)
    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    // Lấy thông tin một tài khoản theo ID
    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Thêm tài khoản mới vào CSDL
    public function insertUser($data)
    {
        // Nếu bảng users có cột full_name và cần giá trị, có thể truyền thêm. Ở đây để trống.
        $fullName = $data['full_name'] ?? '';

        $sql = "INSERT INTO users (username, password, full_name, email, role) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $data['username'],
            $data['password'],
            $fullName,
            $data['email'],
            $data['role']
        ]);
        // Có thể trả về ID vừa thêm (nếu cần dùng): 
        return $this->pdo->lastInsertId();
    }

    // Cập nhật thông tin tài khoản
    public function updateUser($id, $username, $email, $role, $newPassword = null)
    {
        $sql = "UPDATE users SET username = ?, email = ?, role = ?";
        $params = [$username, $email, $role];
        if (!is_null($newPassword)) {
            $sql .= ", password = ?";
            $params[] = $newPassword;
        }
        $sql .= " WHERE id = ?";
        $params[] = $id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    // Xóa tài khoản theo ID
    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
}

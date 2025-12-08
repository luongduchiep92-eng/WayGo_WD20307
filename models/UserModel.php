<?php
require_once "BaseModel.php";

class UserModel extends BaseModel
{
    // Đăng ký tài khoản (dành cho user hoặc hdv)
    public function register($data)
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$data['username'], $data['email']]);
            if ($stmt->rowCount() > 0) {
                return false;
            }

            $role = ($data['role'] === 'hdv') ? 'hdv' : 'user';

            $sqlUser = "INSERT INTO users (username, password, full_name, email, role) 
                        VALUES (?, ?, ?, ?, ?)";
            $stmtUser = $this->pdo->prepare($sqlUser);
            $stmtUser->execute([
                $data['username'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['full_name'],
                $data['email'],
                $role
            ]);

            if ($role === 'hdv') {
                $sqlHdv = "INSERT INTO huong_dan_viens (ho_ten, email, so_dien_thoai, loai_hdv, kinh_nghiem_nam, suc_khoe) 
                           VALUES (?, ?, ?, 'Nội địa', 0, 'Tốt')";
                $stmtHdv = $this->pdo->prepare($sqlHdv);
                $stmtHdv->execute([
                    $data['full_name'],
                    $data['email'],
                    $data['phone'] ?? ''
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
        $stmt = $this->pdo->prepare("SELECT id FROM huong_dan_viens WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    // ✅ Lấy tất cả người dùng
    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT id, username, full_name, email, role, status FROM users");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Lấy người dùng theo ID
    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, username, full_name, email, role, status FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Thêm người dùng (dành cho admin thêm)
    public function createUser($data)
    {
        try {
            $this->pdo->beginTransaction();

            $stmtCheck = $this->pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmtCheck->execute([$data['username'], $data['email']]);
            if ($stmtCheck->rowCount() > 0) {
                $this->pdo->rollBack();
                return false;
            }

            $allowed_roles = ['admin', 'staff', 'user', 'hdv'];
            $role = in_array($data['role'], $allowed_roles) ? $data['role'] : 'user';

            $stmt = $this->pdo->prepare(
                "INSERT INTO users (username, password, full_name, email, role, status) 
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $data['username'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['full_name'],
                $data['email'],
                $role,
                $data['status']
            ]);

            if ($role === 'hdv') {
                $stmtHdv = $this->pdo->prepare(
                    "INSERT INTO huong_dan_viens (ho_ten, email, so_dien_thoai, loai_hdv, kinh_nghiem_nam, suc_khoe)
                     VALUES (?, ?, ?, 'Nội địa', 0, 'Tốt')"
                );
                $stmtHdv->execute([
                    $data['full_name'],
                    $data['email'],
                    $data['phone'] ?? ''
                ]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // ✅ Cập nhật người dùng
    public function updateUser($id, $data)
    {
        $fields = "full_name = ?, email = ?, role = ?, status = ?";
        $params = [$data['full_name'], $data['email'], $data['role'], $data['status']];

        if (!empty($data['password'])) {
            $fields .= ", password = ?";
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $params[] = $id;
        $sql = "UPDATE users SET $fields WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // ✅ Xóa người dùng
    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

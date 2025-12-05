<?php
require_once "BaseModel.php";

class UserModel extends BaseModel {
    
    public function register($data) {
        try {
            $this->pdo->beginTransaction(); 

            // 1. Kiểm tra username/email tồn tại chưa
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$data['username'], $data['email']]);
            if ($stmt->rowCount() > 0) {
                return false; 
            }

            // 2. Lấy role từ form (chỉ chấp nhận: admin, staff, hdv)
            $allowed_roles = ['admin', 'staff', 'hdv'];
            $role = in_array($data['role'], $allowed_roles) ? $data['role'] : 'staff'; // Mặc định là staff nếu sai

            // 3. Tạo User trong bảng users
            $sqlUser = "INSERT INTO users (username, password, full_name, email, role) VALUES (?, ?, ?, ?, ?)";
            $stmtUser = $this->pdo->prepare($sqlUser);
            $stmtUser->execute([
                $data['username'], 
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['full_name'], 
                $data['email'], 
                $role
            ]);

            // 4. [LOGIC QUAN TRỌNG] Chỉ tạo hồ sơ bên bảng huong_dan_viens nếu role là 'hdv'
            if ($role === 'hdv') {
                $sqlHdv = "INSERT INTO huong_dan_viens (ho_ten, email, so_dien_thoai, loai_hdv, kinh_nghiem_nam, suc_khoe) 
                           VALUES (?, ?, ?, 'Nội địa', 0, 'Tốt')";
                $stmtHdv = $this->pdo->prepare($sqlHdv);
                $stmtHdv->execute([
                    $data['full_name'],
                    $data['email'],
                    $data['phone']
                ]);
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false; // Hoặc throw $e để debug
        }
    }

    public function login($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getHdvIdByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT id FROM huong_dan_viens WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }
}
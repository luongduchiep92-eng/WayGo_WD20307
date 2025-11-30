<?php
require_once "BaseModel.php";
class UserModel extends BaseModel {
    public function register($data) {
        $sql = "INSERT INTO users (username, password, full_name, email, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['username'], password_hash($data['password'], PASSWORD_DEFAULT),
            $data['full_name'], $data['email'], 'admin' // Mặc định tạo admin để test, sau này đổi thành 'user'
        ]);
    }
    public function login($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
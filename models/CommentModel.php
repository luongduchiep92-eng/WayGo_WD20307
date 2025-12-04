<?php
require_once "BaseModel.php";

class CommentModel extends BaseModel {
    
    // Lấy tất cả comment kèm bộ lọc
    public function getAllComments($filters = []) {
        $sql = "SELECT * FROM comments WHERE 1=1";
        $params = [];

        if (!empty($filters['guest_name'])) {
            $sql .= " AND guest_name LIKE ?";
            $params[] = "%" . $filters['guest_name'] . "%";
        }
        if (!empty($filters['supplier_name'])) {
            $sql .= " AND supplier_name LIKE ?";
            $params[] = "%" . $filters['supplier_name'] . "%";
        }
        if (!empty($filters['rating'])) {
            $sql .= " AND rating = ?";
            $params[] = $filters['rating'];
        }

        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm comment mới
    public function addComment($guest_name, $supplier_name, $content, $rating) {
        $sql = "INSERT INTO comments (guest_name, supplier_name, content, rating, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$guest_name, $supplier_name, $content, $rating]);
    }

    // Xóa comment
    public function deleteComment($id) {
        $sql = "DELETE FROM comments WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Lấy chi tiết comment
    public function getCommentById($id) {
        $sql = "SELECT * FROM comments WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
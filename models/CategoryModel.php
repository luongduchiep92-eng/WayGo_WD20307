<?php
class CategoryModel extends BaseModel {
    protected $table = 'categories';

    public function getAllCategories() {
        $sql = "SELECT * FROM {$this->table} ORDER BY name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ); 
        return $stmt->fetchAll();
    }

    public function getCategoryById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetch();
    }

    public function getCategoryWithProducts($id) {
        $sql = "SELECT c.*, COUNT(p.id) as product_count 
                FROM {$this->table} c
                LEFT JOIN products p ON c.id = p.category_id AND p.status = 'active'
                WHERE c.id = :id
                GROUP BY c.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetch();
    }
}

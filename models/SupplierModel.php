<?php
require_once "models/BaseModel.php";

class Supplier extends BaseModel
{
    protected $table = "suppliers";

    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO $this->table (name, phone, email, address) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['phone'],
            $data['email'],
            $data['address']
        ]);
    }

    public function updateSupplier($id, $data)
    {
        $sql = "UPDATE $this->table SET name=?, phone=?, email=?, address=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['phone'],
            $data['email'],
            $data['address'],
            $id
        ]);
    }

    public function deleteSupplier($id)
    {
        $sql = "DELETE FROM $this->table WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

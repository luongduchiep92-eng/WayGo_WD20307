<?php
class HuongDanVienModel extends BaseModel
{
    protected $table = 'huong_dan_viens';

    public function getAllHDV()
    {
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getHDVById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function insertHDV($data)
    {
        $sql = "INSERT INTO $this->table (ho_ten, avatar, ngay_sinh, so_dien_thoai, email, chung_chi, ngon_ngu, kinh_nghiem_nam, loai_hdv, suc_khoe, danh_gia)
                VALUES (:ho_ten, :avatar, :ngay_sinh, :so_dien_thoai, :email, :chung_chi, :ngon_ngu, :kinh_nghiem_nam, :loai_hdv, :suc_khoe, :danh_gia)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function updateHDV($id, $data)
    {
        $sql = "UPDATE $this->table SET 
                    ho_ten = :ho_ten,
                    avatar = :avatar,
                    ngay_sinh = :ngay_sinh,
                    so_dien_thoai = :so_dien_thoai,
                    email = :email,
                    chung_chi = :chung_chi,
                    ngon_ngu = :ngon_ngu,
                    kinh_nghiem_nam = :kinh_nghiem_nam,
                    loai_hdv = :loai_hdv,
                    suc_khoe = :suc_khoe,
                    danh_gia = :danh_gia
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function deleteHDV($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

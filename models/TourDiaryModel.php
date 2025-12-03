<?php
require_once "BaseModel.php";

class TourDiaryModel extends BaseModel {
    
    // Lấy tất cả nhật ký (kèm thông tin tour và booking)
    public function getAllDiaries() {
        $sql = "SELECT d.*, b.customer_name, t.ten_tour, t.ngay_khoi_hanh 
                FROM tour_diaries d
                JOIN bookings b ON d.booking_id = b.id
                JOIN tours t ON b.tour_id = t.id
                ORDER BY d.created_at DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết 1 nhật ký
    public function getDiaryById($id) {
        $sql = "SELECT d.*, b.customer_name, t.ten_tour, t.ngay_khoi_hanh, b.so_luong 
                FROM tour_diaries d
                JOIN bookings b ON d.booking_id = b.id
                JOIN tours t ON b.tour_id = t.id
                WHERE d.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách các Booking ĐÃ HOÀN THÀNH để chọn viết nhật ký
    // (Chỉ lấy những booking chưa có nhật ký)
    public function getCompletedBookingsForSelect($exclude_id = null) {
        $sql = "SELECT b.id, t.ten_tour, b.customer_name, t.ngay_khoi_hanh 
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                WHERE b.status = 'Hoàn tất' 
                AND b.id NOT IN (SELECT booking_id FROM tour_diaries)";
        
        // Nếu đang sửa, cho phép hiện lại booking hiện tại
        if($exclude_id) {
             $sql .= " OR b.id = $exclude_id"; 
        }
        
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm mới
    public function create($data) {
        $sql = "INSERT INTO tour_diaries (booking_id, supplier_feedback, incidents, resolution, customer_feedback) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['booking_id'],
            $data['supplier_feedback'],
            $data['incidents'],
            $data['resolution'],
            $data['customer_feedback']
        ]);
    }

    // Cập nhật
    public function update($id, $data) {
        $sql = "UPDATE tour_diaries SET supplier_feedback=?, incidents=?, resolution=?, customer_feedback=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['supplier_feedback'],
            $data['incidents'],
            $data['resolution'],
            $data['customer_feedback'],
            $id
        ]);
    }

    // Xóa
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tour_diaries WHERE id=?");
        return $stmt->execute([$id]);
    }
}
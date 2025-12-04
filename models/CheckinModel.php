<?php
require_once "BaseModel.php";

class CheckinModel extends BaseModel {
    
    // Lấy danh sách tour cần checkin (Đã cọc hoặc Hoàn tất)
    public function getBookingsForCheckin() {
        $sql = "SELECT b.id, t.ten_tour, t.ngay_khoi_hanh, h.ho_ten as hdv_name, b.so_luong, b.status
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                LEFT JOIN huong_dan_viens h ON b.hdv_id = h.id
                WHERE b.status IN ('Đã cọc', 'Hoàn tất')
                ORDER BY t.ngay_khoi_hanh ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách khách hàng của 1 booking
    public function getCustomersByBookingId($booking_id) {
        $sql = "SELECT * FROM booking_customers WHERE booking_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$booking_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin booking cơ bản
    public function getBookingInfo($booking_id) {
        $sql = "SELECT b.id, t.ten_tour, t.ngay_khoi_hanh, b.so_luong 
                FROM bookings b JOIN tours t ON b.tour_id = t.id WHERE b.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$booking_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // [TÍNH NĂNG 2, 3, 4] Cập nhật trạng thái + Thời gian thực + Ghi chú
    public function updateCustomerStatus($id, $status, $note = null) {
        $sql = "UPDATE booking_customers SET checkin_status = ?, checkin_time = NOW()";
        $params = [$status];
        
        if ($note !== null) {
            $sql .= ", checkin_note = ?";
            $params[] = $note;
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // [TÍNH NĂNG 7] Check-in hàng loạt (Chỉ những người chưa check-in)
    public function checkinAllPresent($booking_id) {
        $sql = "UPDATE booking_customers 
                SET checkin_status = 'Có mặt', checkin_time = NOW() 
                WHERE booking_id = ? AND checkin_status = 'Chưa checkin'";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$booking_id]);
    }

    // [TÍNH NĂNG 5] Lấy thống kê Dashboard
    public function getCheckinStats($booking_id) {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN checkin_status = 'Có mặt' THEN 1 ELSE 0 END) as present,
                    SUM(CASE WHEN checkin_status = 'Vắng mặt' THEN 1 ELSE 0 END) as absent,
                    SUM(CASE WHEN checkin_status = 'Đến muộn' THEN 1 ELSE 0 END) as late,
                    SUM(CASE WHEN checkin_status = 'Chưa checkin' THEN 1 ELSE 0 END) as pending
                FROM booking_customers WHERE booking_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$booking_id]);
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Xử lý null thành 0
        foreach ($stats as $key => $val) $stats[$key] = $val ?? 0;
        return $stats;
    }
}
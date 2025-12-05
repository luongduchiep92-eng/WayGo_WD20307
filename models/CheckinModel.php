<?php
require_once "BaseModel.php";

class CheckinModel extends BaseModel {
    
    // 1. Lấy danh sách tour cần checkin (Sửa lỗi ngày 1970)
    public function getBookingsForCheckin() {
        // COALESCE: Lấy ngày booking, nếu null thì lấy ngày tour
        $sql = "SELECT b.id, t.ten_tour, 
                COALESCE(b.ngay_khoi_hanh, t.ngay_khoi_hanh) as ngay_khoi_hanh, 
                h.ho_ten as hdv_name, b.so_luong, b.status,
                (SELECT image_path FROM tour_images WHERE tour_id = t.id LIMIT 1) as tour_image
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                LEFT JOIN huong_dan_viens h ON b.hdv_id = h.id
                WHERE b.status IN ('Đã cọc', 'Hoàn tất')
                ORDER BY ngay_khoi_hanh ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy thông tin cơ bản booking
    public function getBookingInfo($booking_id) {
        $sql = "SELECT b.id, t.ten_tour, 
                COALESCE(b.ngay_khoi_hanh, t.ngay_khoi_hanh) as ngay_khoi_hanh, 
                b.so_luong 
                FROM bookings b JOIN tours t ON b.tour_id = t.id WHERE b.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$booking_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Lấy danh sách Phiên (Sessions) checkin của 1 booking
    public function getSessions($booking_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM checkin_sessions WHERE booking_id = ? ORDER BY created_at DESC");
        $stmt->execute([$booking_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Lấy chi tiết khách hàng trong 1 phiên
    public function getSessionDetails($session_id) {
        $sql = "SELECT cd.*, c.ho_ten, c.so_dien_thoai, c.gioi_tinh, c.tuoi
                FROM checkin_details cd
                JOIN booking_customers c ON cd.customer_id = c.id
                WHERE cd.session_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$session_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Tạo phiên Checkin Mới (Và tự động thêm danh sách khách vào)
    public function createSession($booking_id, $title) {
        try {
            $this->pdo->beginTransaction();
            
            // Tạo session
            $stmt = $this->pdo->prepare("INSERT INTO checkin_sessions (booking_id, title) VALUES (?, ?)");
            $stmt->execute([$booking_id, $title]);
            $session_id = $this->pdo->lastInsertId();

            // Lấy danh sách khách của booking đó
            $stmtCust = $this->pdo->prepare("SELECT id FROM booking_customers WHERE booking_id = ?");
            $stmtCust->execute([$booking_id]);
            $customers = $stmtCust->fetchAll(PDO::FETCH_ASSOC);

            // Insert khách vào bảng detail
            $stmtDet = $this->pdo->prepare("INSERT INTO checkin_details (session_id, customer_id, status) VALUES (?, ?, 'Chưa checkin')");
            foreach ($customers as $c) {
                $stmtDet->execute([$session_id, $c['id']]);
            }

            $this->pdo->commit();
            return $session_id;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    // 6. Cập nhật trạng thái từng khách
    public function updateCustomerStatus($detail_id, $status, $note = null) {
        $sql = "UPDATE checkin_details SET status = ?, checkin_time = NOW()";
        $params = [$status];
        
        if ($note !== null) {
            $sql .= ", note = ?";
            $params[] = $note;
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $detail_id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // 7. [SỬA LỖI] Check-in tất cả (Ghi đè bất kể trạng thái cũ)
    public function checkinAllPresent($session_id) {
        $sql = "UPDATE checkin_details 
                SET status = 'Có mặt', checkin_time = NOW() 
                WHERE session_id = ?"; // Bỏ điều kiện 'Chưa checkin' để cho phép ghi đè
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$session_id]);
    }

    // 8. Thống kê cho 1 phiên
    public function getSessionStats($session_id) {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'Có mặt' THEN 1 ELSE 0 END) as present,
                    SUM(CASE WHEN status = 'Vắng mặt' THEN 1 ELSE 0 END) as absent,
                    SUM(CASE WHEN status = 'Đến muộn' THEN 1 ELSE 0 END) as late,
                    SUM(CASE WHEN status = 'Chưa checkin' THEN 1 ELSE 0 END) as pending
                FROM checkin_details WHERE session_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$session_id]);
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
        foreach ($stats as $key => $val) $stats[$key] = $val ?? 0;
        return $stats;
    }
    public function deleteSession($session_id) {
        $stmt = $this->pdo->prepare("DELETE FROM checkin_sessions WHERE id = ?");
        return $stmt->execute([$session_id]);
    }
}
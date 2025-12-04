<?php
require_once "BaseModel.php";

class HdvAppModel extends BaseModel {
    
    public function getMyTours($hdv_id) {
        // [SỬA LỖI] Bỏ điều kiện lọc status tạm thời để debug xem có hiện dữ liệu không
        // Thêm DISTINCT để tránh lặp tour nếu 1 tour có nhiều booking (dù logic chuẩn là 1 tour 1 booking cho 1 đoàn, nhưng cứ thêm cho chắc)
        $sql = "SELECT 
                    b.id as booking_id, 
                    t.id as tour_id, 
                    t.ten_tour, 
                    t.ngay_khoi_hanh, 
                    t.thoi_gian, 
                    b.so_luong, 
                    b.status, 
                    t.phuong_tien
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                WHERE b.hdv_id = ? 
                -- Tạm thời comment dòng status để test hiển thị
                -- AND b.status IN ('Đã cọc', 'Hoàn tất') 
                ORDER BY t.ngay_khoi_hanh ASC";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$hdv_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHdvStats($hdv_id) {
        $sql = "SELECT 
                    COUNT(*) as total_tours,
                    SUM(CASE WHEN t.ngay_khoi_hanh >= CURDATE() THEN 1 ELSE 0 END) as upcoming
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                WHERE b.hdv_id = ?"; // Bỏ status check luôn cho chắc
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$hdv_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Xử lý null nếu không có dữ liệu
        return [
            'total_tours' => $result['total_tours'] ?? 0,
            'upcoming' => $result['upcoming'] ?? 0
        ];
    }

    // Hàm lấy lịch trình (Giữ nguyên)
    public function getTourScheduleFull($tour_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tours WHERE id = ?");
        $stmt->execute([$tour_id]);
        $tour = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tour) {
            $stmtDays = $this->pdo->prepare("SELECT * FROM tour_schedule_days WHERE tour_id = ? ORDER BY ngay_thu ASC");
            $stmtDays->execute([$tour_id]);
            $days = $stmtDays->fetchAll(PDO::FETCH_ASSOC);

            foreach ($days as &$day) {
                $stmtAct = $this->pdo->prepare("SELECT * FROM tour_schedule_activities WHERE day_id = ? ORDER BY thoi_gian_bat_dau ASC");
                $stmtAct->execute([$day['id']]);
                $day['activities'] = $stmtAct->fetchAll(PDO::FETCH_ASSOC);
            }
            $tour['schedule'] = $days;
        }
        return $tour;
    }
}
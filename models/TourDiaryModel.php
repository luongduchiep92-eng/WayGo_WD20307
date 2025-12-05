<?php
require_once "BaseModel.php";

class TourDiaryModel extends BaseModel {
    
    // 1. Lấy danh sách các Tour ĐÃ CÓ nhật ký (Để hiện ra trang List)
    public function getBookingsWithDiaries() {
        $sql = "SELECT b.id, t.ten_tour, b.customer_name, 
                COALESCE(b.ngay_khoi_hanh, t.ngay_khoi_hanh) as ngay_khoi_hanh,
                (SELECT image_path FROM tour_images WHERE tour_id = t.id LIMIT 1) as tour_image,
                COUNT(d.id) as total_entries,
                MAX(d.created_at) as last_update
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                JOIN tour_diaries d ON b.id = d.booking_id -- Chỉ lấy tour đã có nhật ký
                GROUP BY b.id
                ORDER BY last_update DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy danh sách Tour ĐỦ ĐIỀU KIỆN viết mới (Đang/Đã đi + Chưa bị hủy)
    // Dùng cho dropdown khi bấm "Thêm mới"
    public function getEligibleBookingsForSelect() {
        $today = date('Y-m-d');
        // Lấy tour đang/đã đi VÀ chưa có trong bảng nhật ký (hoặc có cũng được, tùy logic)
        // Ở đây ta lấy hết các tour hợp lệ để người dùng chọn
        $sql = "SELECT b.id, t.ten_tour, b.customer_name, 
                COALESCE(b.ngay_khoi_hanh, t.ngay_khoi_hanh) as ngay_khoi_hanh 
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                WHERE b.status != 'Hủy'
                AND COALESCE(b.ngay_khoi_hanh, t.ngay_khoi_hanh) <= ?
                ORDER BY ngay_khoi_hanh DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$today]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Lấy chi tiết 1 Booking kèm toàn bộ nhật ký
    public function getBookingWithDiaries($booking_id) {
        // Thông tin tour
        $sqlTour = "SELECT b.*, t.ten_tour, t.thoi_gian, h.ho_ten as hdv_name
                    FROM bookings b
                    JOIN tours t ON b.tour_id = t.id
                    LEFT JOIN huong_dan_viens h ON b.hdv_id = h.id
                    WHERE b.id = ?";
        $stmt = $this->pdo->prepare($sqlTour);
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($booking) {
            // Danh sách bài viết
            $sqlDiaries = "SELECT * FROM tour_diaries WHERE booking_id = ? ORDER BY ngay_thu DESC, created_at DESC";
            $stmtD = $this->pdo->prepare($sqlDiaries);
            $stmtD->execute([$booking_id]);
            $booking['diaries'] = $stmtD->fetchAll(PDO::FETCH_ASSOC);

            // Đếm số ngày tối đa của tour
            $stmtCount = $this->pdo->prepare("SELECT COUNT(*) FROM tour_schedule_days WHERE tour_id = ?");
            $stmtCount->execute([$booking['tour_id']]);
            $booking['max_days'] = $stmtCount->fetchColumn();
        }
        return $booking;
    }

    // 4. Lưu / Cập nhật nhật ký (Xử lý mảng)
    public function saveDiaries($booking_id, $diaries, $deleted_ids) {
        try {
            $this->pdo->beginTransaction();

            // Xóa các dòng bị đánh dấu
            if (!empty($deleted_ids)) {
                $ids = explode(',', $deleted_ids);
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                // Đảm bảo chỉ xóa của đúng booking này
                $sqlDel = "DELETE FROM tour_diaries WHERE id IN ($placeholders) AND booking_id = ?";
                $stmtDel = $this->pdo->prepare($sqlDel);
                $ids[] = $booking_id; // Thêm booking_id vào cuối mảng tham số
                $stmtDel->execute($ids);
            }

            // Thêm / Sửa
            $stmtIns = $this->pdo->prepare("INSERT INTO tour_diaries (booking_id, ngay_thu, tieu_de, noi_dung, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmtUpd = $this->pdo->prepare("UPDATE tour_diaries SET ngay_thu=?, tieu_de=?, noi_dung=? WHERE id=?");

            foreach ($diaries as $key => $d) {
                if (is_numeric($key)) { // Update
                    $stmtUpd->execute([$d['ngay_thu'], $d['tieu_de'], $d['noi_dung'], $key]);
                } else { // Insert
                    $stmtIns->execute([$booking_id, $d['ngay_thu'], $d['tieu_de'], $d['noi_dung']]);
                }
            }
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
        }
    }

    // 5. [MỚI] Xóa toàn bộ nhật ký của 1 tour (Xóa tour khỏi list nhật ký)
    public function deleteAllDiariesByBooking($booking_id) {
        $stmt = $this->pdo->prepare("DELETE FROM tour_diaries WHERE booking_id = ?");
        return $stmt->execute([$booking_id]);
    }
    
    // 6. Lấy số ngày tour (cho Ajax)
    public function getTourDaysCount($booking_id) {
        $stmt = $this->pdo->prepare("SELECT tour_id FROM bookings WHERE id = ?");
        $stmt->execute([$booking_id]);
        $tour_id = $stmt->fetchColumn();
        if ($tour_id) {
            $stmtCount = $this->pdo->prepare("SELECT COUNT(*) FROM tour_schedule_days WHERE tour_id = ?");
            $stmtCount->execute([$tour_id]);
            return $stmtCount->fetchColumn();
        }
        return 0;
    }
}
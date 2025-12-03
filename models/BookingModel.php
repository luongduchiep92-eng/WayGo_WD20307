<?php
require_once "BaseModel.php";

class BookingModel extends BaseModel
{
    // ... (GIỮ NGUYÊN CÁC HÀM CŨ: getAllTours, getAllHdvs, getSuppliersByType...) ...
    public function getAllTours() { return $this->pdo->query("SELECT * FROM tours WHERE status='Hoạt động'")->fetchAll(PDO::FETCH_ASSOC); }
    public function getAllHdvs() { return $this->pdo->query("SELECT * FROM huong_dan_viens")->fetchAll(PDO::FETCH_ASSOC); }
    public function getSuppliersByType($type) { 
        $stmt = $this->pdo->prepare("SELECT * FROM suppliers WHERE type=?"); 
        $stmt->execute([$type]); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    // Hàm lấy danh sách booking (Giữ nguyên, chỉ sửa query nếu cần)
    public function getAllBookings($status = null) {
    $sql = "SELECT b.*, t.ten_tour, h.ho_ten AS hdv_name
            FROM bookings b
            LEFT JOIN tours t ON b.tour_id = t.id
            LEFT JOIN huong_dan_viens h ON b.hdv_id = h.id
            WHERE 1=1"; // Kỹ thuật 1=1 để dễ nối chuỗi AND phía sau
    
    // [QUAN TRỌNG] Nếu có status gửi xuống thì nối thêm điều kiện lọc
    if ($status) {
        $sql .= " AND b.status = '$status'";
    }

    $sql .= " ORDER BY b.created_at DESC";
    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

    // --- [MỚI] HÀM CHECK HDV RẢNH THEO YÊU CẦU ---
    public function getAvailableHdvs($ngay_khoi_hanh, $loai_tour) {
        // 1. Map loại tour sang loại HDV (Trong nước -> Nội địa, Quốc tế -> Quốc tế)
        $loai_hdv = ($loai_tour == 'Trong nước') ? 'Nội địa' : 'Quốc tế';

        // 2. Query: Lấy HDV đúng loại VÀ Không nằm trong các booking trùng ngày (trừ booking Hủy)
        $sql = "SELECT * FROM huong_dan_viens 
                WHERE loai_hdv = ? 
                AND id NOT IN (
                    SELECT b.hdv_id FROM bookings b
                    JOIN tours t ON b.tour_id = t.id
                    WHERE t.ngay_khoi_hanh = ? 
                    AND b.status != 'Hủy' 
                    AND b.hdv_id IS NOT NULL
                )";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$loai_hdv, $ngay_khoi_hanh]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- [SỬA] CREATE BOOKING ---
    public function createBookingFull($data) {
        try {
            $this->pdo->beginTransaction();

            // Thêm phuong_tien vào SQL
            $sql = "INSERT INTO bookings (tour_id, hdv_id, customer_name, customer_phone, phuong_tien, so_luong, tong_tien, tien_da_coc, status, created_by, hotel_supplier_id, restaurant_supplier_id, chi_phi_phat_sinh, ly_do_phat_sinh) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data['tour_id'], $data['hdv_id'], $data['customer_name'], $data['customer_phone'],
                $data['phuong_tien'], // <--- MỚI
                $data['so_luong'], $data['tong_tien'], $data['tien_da_coc'], $data['status'],
                $_SESSION['user_id'] ?? 1, 
                empty($data['hotel_supplier_id']) ? null : $data['hotel_supplier_id'], 
                empty($data['restaurant_supplier_id']) ? null : $data['restaurant_supplier_id'],
                $data['chi_phi_phat_sinh'], $data['ly_do_phat_sinh']
            ]);
            $booking_id = $this->pdo->lastInsertId();

            // Thêm so_dien_thoai vào SQL Khách hàng
            if (!empty($data['customers'])) {
                $sqlCust = "INSERT INTO booking_customers (booking_id, ho_ten, so_dien_thoai, tuoi, gioi_tinh, gia_tien, CCCD) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmtCust = $this->pdo->prepare($sqlCust);
                foreach ($data['customers'] as $c) {
                    $stmtCust->execute([$booking_id, $c['name'], $c['phone'], $c['age'], $c['gender'], $c['price'], $c['cccd']]);
                }
            }

            // ... (Giữ nguyên phần Payment và Schedule cũ của bạn) ...
            if ($data['tien_da_coc'] > 0) {
                $this->addPaymentHistory($booking_id, $data['tien_da_coc'], 'Cọc', 'Đặt cọc khi tạo booking');
            }
            if (!empty($data['schedule'])) {
                 foreach ($data['schedule'] as $day) {
                    $stmtDay = $this->pdo->prepare("INSERT INTO booking_schedule_days (booking_id, ngay_thu, tieu_de, mo_ta) VALUES (?, ?, ?, ?)");
                    $stmtDay->execute([$booking_id, $day['ngay_thu'], $day['tieu_de'], $day['mo_ta'] ?? '']);
                    $day_id = $this->pdo->lastInsertId();
                    if (!empty($day['activities'])) {
                        $stmtAct = $this->pdo->prepare("INSERT INTO booking_schedule_activities (day_id, thoi_gian_bat_dau, thoi_gian_ket_thuc, dia_diem, hoat_dong) VALUES (?, ?, ?, ?, ?)");
                        foreach ($day['activities'] as $act) {
                            $stmtAct->execute([$day_id, $act['start'], $act['end'], $act['place'], $act['action']]);
                        }
                    }
                }
            }

            $this->pdo->commit();
            return $booking_id;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // --- [SỬA] UPDATE BOOKING ---
    public function updateBookingFull($id, $data) {
        $sql = "UPDATE bookings SET hdv_id=?, phuong_tien=?, hotel_supplier_id=?, restaurant_supplier_id=?, status=?, chi_phi_phat_sinh=?, ly_do_phat_sinh=?, tong_tien=? WHERE id=?";
        
        // Sửa lỗi Incorrect integer value bằng cách check empty -> null
        $this->pdo->prepare($sql)->execute([
            $data['hdv_id'], 
            $data['phuong_tien'], // <--- MỚI
            empty($data['hotel_supplier_id']) ? null : $data['hotel_supplier_id'], 
            empty($data['restaurant_supplier_id']) ? null : $data['restaurant_supplier_id'], 
            $data['status'], 
            $data['chi_phi_phat_sinh'], 
            $data['ly_do_phat_sinh'], 
            $data['tong_tien'], 
            $id
        ]);
        
        // Cập nhật khách hàng (Xóa cũ thêm mới có SĐT)
        if (!empty($data['customers'])) {
            $this->pdo->prepare("DELETE FROM booking_customers WHERE booking_id=?")->execute([$id]);
            $sqlCust = "INSERT INTO booking_customers (booking_id, ho_ten, so_dien_thoai, tuoi, gioi_tinh, gia_tien, CCCD) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtCust = $this->pdo->prepare($sqlCust);
            foreach ($data['customers'] as $c) {
                $stmtCust->execute([$id, $c['name'], $c['phone'], $c['age'], $c['gender'], $c['price'], $c['cccd']]);
            }
        }
    }

    // ... (GIỮ NGUYÊN CÁC HÀM KHÁC: getBookingDetailFull, addPaymentHistory, deleteBooking, getTourDataForBooking...)
    public function getBookingDetailFull($id) {
        // ... Code cũ của bạn ...
        $sql = "SELECT b.*, t.ten_tour, t.loai_tour, t.ngay_khoi_hanh, h.ho_ten as hdv_name, s1.name as hotel_name, s2.name as res_name 
                FROM bookings b
                LEFT JOIN tours t ON b.tour_id = t.id
                LEFT JOIN huong_dan_viens h ON b.hdv_id = h.id
                LEFT JOIN suppliers s1 ON b.hotel_supplier_id = s1.id
                LEFT JOIN suppliers s2 ON b.restaurant_supplier_id = s2.id
                WHERE b.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$booking) return null;

        $booking['customers'] = $this->pdo->query("SELECT * FROM booking_customers WHERE booking_id=$id")->fetchAll(PDO::FETCH_ASSOC);
        $booking['payments'] = $this->pdo->query("SELECT * FROM payment_history WHERE booking_id=$id ORDER BY ngay_thu DESC")->fetchAll(PDO::FETCH_ASSOC);
        
        $days = $this->pdo->query("SELECT * FROM booking_schedule_days WHERE booking_id=$id ORDER BY ngay_thu ASC")->fetchAll(PDO::FETCH_ASSOC);
        foreach($days as &$day) {
             $day['activities'] = $this->pdo->query("SELECT * FROM booking_schedule_activities WHERE day_id={$day['id']} ORDER BY thoi_gian_bat_dau ASC")->fetchAll(PDO::FETCH_ASSOC);
        }
        $booking['schedule'] = $days;
        return $booking;
    }

    public function addPaymentHistory($booking_id, $amount, $type, $note) {
        $stmt = $this->pdo->prepare("INSERT INTO payment_history (booking_id, so_tien, loai_thanh_toan, ghi_chu, nguoi_thu_tien) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$booking_id, $amount, $type, $note, $_SESSION['user_name'] ?? 'Admin']);
        $this->pdo->prepare("UPDATE bookings SET tien_da_coc = (SELECT SUM(so_tien) FROM payment_history WHERE booking_id=?) WHERE id=?")->execute([$booking_id, $booking_id]);
    }
    
    public function deleteBooking($id) {
        $this->pdo->prepare("DELETE FROM bookings WHERE id=?")->execute([$id]);
    }
    
    public function getTourDataForBooking($tour_id) {
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
?>
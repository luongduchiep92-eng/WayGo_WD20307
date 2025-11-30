<?php
require_once "BaseModel.php";

class BookingModel extends BaseModel
{
    // --- LẤY DỮ LIỆU CƠ BẢN ---
    public function getAllTours() { return $this->pdo->query("SELECT * FROM tours WHERE status='Hoạt động'")->fetchAll(PDO::FETCH_ASSOC); }
    public function getAllHdvs() { return $this->pdo->query("SELECT * FROM huong_dan_viens")->fetchAll(PDO::FETCH_ASSOC); }
    public function getSuppliersByType($type) { 
        $stmt = $this->pdo->prepare("SELECT * FROM suppliers WHERE type=?"); 
        $stmt->execute([$type]); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    // --- AJAX: LẤY TOUR + LỊCH TRÌNH MẪU (Để đổ vào Form Thêm/Sửa) ---
    public function getTourDataForBooking($tour_id) {
        // 1. Lấy thông tin Tour cơ bản
        $stmt = $this->pdo->prepare("SELECT * FROM tours WHERE id = ?");
        $stmt->execute([$tour_id]);
        $tour = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tour) {
            // 2. Lấy Ngày lịch trình
            $stmtDays = $this->pdo->prepare("SELECT * FROM tour_schedule_days WHERE tour_id = ? ORDER BY ngay_thu ASC");
            $stmtDays->execute([$tour_id]);
            $days = $stmtDays->fetchAll(PDO::FETCH_ASSOC);

            // 3. Lấy Hoạt động cho từng ngày
            foreach ($days as &$day) {
                $stmtAct = $this->pdo->prepare("SELECT * FROM tour_schedule_activities WHERE day_id = ? ORDER BY thoi_gian_bat_dau ASC");
                $stmtAct->execute([$day['id']]);
                $day['activities'] = $stmtAct->fetchAll(PDO::FETCH_ASSOC);
            }
            $tour['schedule'] = $days;
        }
        return $tour;
    }

    // --- CHECK HDV RẢNH KHÔNG ---
    public function isHdvAvailable($hdv_id, $ngay_khoi_hanh, $booking_id_ignore = null) {
        // Check lịch nghỉ
        $stmt1 = $this->pdo->prepare("SELECT * FROM hdv_nghi WHERE hdv_id=? AND ngay_nghi=?");
        $stmt1->execute([$hdv_id, $ngay_khoi_hanh]);
        if($stmt1->rowCount() > 0) return false;

        // Check lịch dẫn tour khác
        $sql2 = "SELECT b.id FROM bookings b JOIN tours t ON b.tour_id = t.id WHERE b.hdv_id = ? AND t.ngay_khoi_hanh = ? AND b.status != 'Hủy'";
        if($booking_id_ignore) $sql2 .= " AND b.id != $booking_id_ignore";
        $stmt2 = $this->pdo->prepare($sql2);
        $stmt2->execute([$hdv_id, $ngay_khoi_hanh]);
        return ($stmt2->rowCount() == 0);
    }

    // --- TẠO BOOKING FULL (Transaction) ---
    public function createBookingFull($data) {
        try {
            $this->pdo->beginTransaction();

            // 1. Insert Booking Chính
            $sql = "INSERT INTO bookings (tour_id, hdv_id, customer_name, customer_phone, so_luong, tong_tien, tien_da_coc, status, created_by, hotel_supplier_id, restaurant_supplier_id, chi_phi_phat_sinh, ly_do_phat_sinh) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data['tour_id'], $data['hdv_id'], $data['customer_name'], $data['customer_phone'],
                $data['so_luong'], $data['tong_tien'], $data['tien_da_coc'], $data['status'],
                $_SESSION['user_id'] ?? 1, $data['hotel_supplier_id'] ?: null, $data['restaurant_supplier_id'] ?: null,
                $data['chi_phi_phat_sinh'], $data['ly_do_phat_sinh']
            ]);
            $booking_id = $this->pdo->lastInsertId();

            // 2. Insert Khách hàng (Lưu giá riêng từng người)
            if (!empty($data['customers'])) {
                $sqlCust = "INSERT INTO booking_customers (booking_id, ho_ten, tuoi, gioi_tinh, so_dien_thoai, gia_tien, CCCD) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmtCust = $this->pdo->prepare($sqlCust);
                foreach ($data['customers'] as $c) {
                    $stmtCust->execute([$booking_id, $c['name'], $c['age'], $c['gender'], $c['phone'], $c['price'], $c['cccd']]);
                }
            }

            // 3. Insert Lịch sử thanh toán (Nếu có cọc)
            if ($data['tien_da_coc'] > 0) {
                $this->addPaymentHistory($booking_id, $data['tien_da_coc'], 'Cọc', 'Đặt cọc khi tạo booking');
            }

            // 4. Insert Lịch trình Riêng (Lưu sâu vào booking_schedule_days và activities)
            // Dữ liệu này được Controller gửi xuống (lấy từ form)
            if (!empty($data['schedule'])) {
                foreach ($data['schedule'] as $day) {
                    // Lưu Ngày
                    $stmtDay = $this->pdo->prepare("INSERT INTO booking_schedule_days (booking_id, ngay_thu, tieu_de, mo_ta) VALUES (?, ?, ?, ?)");
                    $stmtDay->execute([$booking_id, $day['ngay_thu'], $day['tieu_de'], $day['mo_ta'] ?? '']);
                    $day_id = $this->pdo->lastInsertId();

                    // Lưu Hoạt động của ngày đó
                    if (!empty($day['activities'])) {
                        $stmtAct = $this->pdo->prepare("INSERT INTO booking_schedule_activities (day_id, thoi_gian_bat_dau, thoi_gian_ket_thuc, dia_diem, hoat_dong) VALUES (?, ?, ?, ?, ?)");
                        foreach ($day['activities'] as $act) {
                            // Kiểm tra dữ liệu rỗng
                            $start = !empty($act['start']) ? $act['start'] : null;
                            $end = !empty($act['end']) ? $act['end'] : null;
                            $stmtAct->execute([$day_id, $start, $end, $act['place'], $act['action']]);
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

    // --- LẤY CHI TIẾT BOOKING FULL ---
    public function getBookingDetailFull($id) {
        // 1. Thông tin chung
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

        // 2. Danh sách khách hàng
        $booking['customers'] = $this->pdo->query("SELECT * FROM booking_customers WHERE booking_id=$id")->fetchAll(PDO::FETCH_ASSOC);
        
        // 3. Lịch sử thanh toán
        $booking['payments'] = $this->pdo->query("SELECT * FROM payment_history WHERE booking_id=$id ORDER BY ngay_thu DESC")->fetchAll(PDO::FETCH_ASSOC);
        
        // 4. Lịch trình chi tiết (Ngày + Hoạt động)
        $days = $this->pdo->query("SELECT * FROM booking_schedule_days WHERE booking_id=$id ORDER BY ngay_thu ASC")->fetchAll(PDO::FETCH_ASSOC);
        foreach($days as &$day) {
             $day['activities'] = $this->pdo->query("SELECT * FROM booking_schedule_activities WHERE day_id={$day['id']} ORDER BY thoi_gian_bat_dau ASC")->fetchAll(PDO::FETCH_ASSOC);
        }
        $booking['schedule'] = $days;

        return $booking;
    }

    // Helper: Thêm thanh toán
    public function addPaymentHistory($booking_id, $amount, $type, $note) {
        $stmt = $this->pdo->prepare("INSERT INTO payment_history (booking_id, so_tien, loai_thanh_toan, ghi_chu, nguoi_thu_tien) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$booking_id, $amount, $type, $note, $_SESSION['user_name'] ?? 'Admin']);
        $this->pdo->prepare("UPDATE bookings SET tien_da_coc = (SELECT SUM(so_tien) FROM payment_history WHERE booking_id=?) WHERE id=?")->execute([$booking_id, $booking_id]);
    }
    
    // Helper: Update Booking
    public function updateBookingFull($id, $data) {
        $sql = "UPDATE bookings SET hdv_id=?, hotel_supplier_id=?, restaurant_supplier_id=?, status=?, chi_phi_phat_sinh=?, ly_do_phat_sinh=?, tong_tien=? WHERE id=?";
        $this->pdo->prepare($sql)->execute([
            $data['hdv_id'], $data['hotel_supplier_id'], $data['restaurant_supplier_id'], 
            $data['status'], $data['chi_phi_phat_sinh'], $data['ly_do_phat_sinh'], $data['tong_tien'], $id
        ]);
    }

    // Helper: List Booking cho trang danh sách
    public function getAllBookings() {
        $sql = "SELECT b.*, t.ten_tour, h.ho_ten AS hdv_name
                FROM bookings b
                LEFT JOIN tours t ON b.tour_id = t.id
                LEFT JOIN huong_dan_viens h ON b.hdv_id = h.id
                ORDER BY b.created_at DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function deleteBooking($id) {
        $this->pdo->prepare("DELETE FROM bookings WHERE id=?")->execute([$id]);
    }
}
?>
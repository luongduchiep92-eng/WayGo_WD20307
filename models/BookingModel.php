<?php
require_once "BaseModel.php";

class BookingModel extends BaseModel
{
    // 1. Lấy danh sách Tour đang hoạt động
    public function getAllTours() { 
        return $this->pdo->query("SELECT * FROM tours WHERE status='Hoạt động'")->fetchAll(PDO::FETCH_ASSOC); 
    }

    // 2. Lấy danh sách HDV
    public function getAllHdvs() { 
        return $this->pdo->query("SELECT * FROM huong_dan_viens")->fetchAll(PDO::FETCH_ASSOC); 
    }

    // 3. Lấy NCC theo loại
    public function getSuppliersByType($type) { 
        $stmt = $this->pdo->prepare("SELECT * FROM suppliers WHERE type=?"); 
        $stmt->execute([$type]); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    // 4. Lấy danh sách Booking (Có ảnh + Ngày hiển thị)
    public function getAllBookings($status = null) {
        $sql = "SELECT b.*, t.ten_tour, h.ho_ten AS hdv_name,
                COALESCE(b.ngay_khoi_hanh, t.ngay_khoi_hanh) as hien_thi_ngay,
                (SELECT image_path FROM tour_images WHERE tour_id = t.id LIMIT 1) as tour_image
                FROM bookings b
                LEFT JOIN tours t ON b.tour_id = t.id
                LEFT JOIN huong_dan_viens h ON b.hdv_id = h.id
                WHERE 1=1";
        
        if ($status) {
            $sql .= " AND b.status = '$status'";
        }

        $sql .= " ORDER BY b.created_at DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Kiểm tra HDV rảnh
    public function getAvailableHdvs($ngay_khoi_hanh, $loai_tour) {
        $loai_hdv = ($loai_tour == 'Trong nước') ? 'Nội địa' : 'Quốc tế';
        $sql = "SELECT * FROM huong_dan_viens 
                WHERE loai_hdv = ? 
                AND id NOT IN (
                    SELECT b.hdv_id FROM bookings b
                    WHERE b.ngay_khoi_hanh = ? 
                    AND b.status != 'Hủy' 
                    AND b.hdv_id IS NOT NULL
                )";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$loai_hdv, $ngay_khoi_hanh]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 6. TẠO BOOKING MỚI (FULL LOGIC)
    public function createBookingFull($data) {
        try {
            $this->pdo->beginTransaction();

            // A. Insert Booking (created_by = NULL để tránh lỗi FK)
            $sql = "INSERT INTO bookings (tour_id, hdv_id, customer_name, customer_phone, phuong_tien, ngay_khoi_hanh, so_luong, tong_tien, tien_da_coc, status, created_by, hotel_supplier_id, restaurant_supplier_id, chi_phi_phat_sinh, ly_do_phat_sinh) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL, ?, ?, ?, ?)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data['tour_id'], 
                empty($data['hdv_id']) ? null : $data['hdv_id'], 
                $data['customer_name'], 
                $data['customer_phone'],
                $data['phuong_tien'],
                $data['ngay_khoi_hanh'], 
                $data['so_luong'], 
                $data['tong_tien'], 
                $data['tien_da_coc'], 
                $data['status'],
                empty($data['hotel_supplier_id']) ? null : $data['hotel_supplier_id'], 
                empty($data['restaurant_supplier_id']) ? null : $data['restaurant_supplier_id'],
                $data['chi_phi_phat_sinh'], 
                $data['ly_do_phat_sinh']
            ]);
            $booking_id = $this->pdo->lastInsertId();

            // B. Insert Khách hàng
            if (!empty($data['customers'])) {
                $sqlCust = "INSERT INTO booking_customers (booking_id, ho_ten, so_dien_thoai, tuoi, gioi_tinh, gia_tien, CCCD) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmtCust = $this->pdo->prepare($sqlCust);
                foreach ($data['customers'] as $c) {
                    $stmtCust->execute([$booking_id, $c['name'], $c['phone'], $c['age'], $c['gender'], $c['price'], $c['cccd']]);
                }
            }

            // C. Ghi lịch sử thanh toán (Cọc)
            if ($data['tien_da_coc'] > 0) {
                $this->addPaymentHistory($booking_id, $data['tien_da_coc'], 'Cọc', 'Đặt cọc khi tạo booking');
            }

            // D. Xử lý Lịch trình (Copy từ Tour hoặc dùng dữ liệu gửi lên)
            if (!empty($data['schedule'])) {
                foreach ($data['schedule'] as $day) {
                    $this->insertBookingDayFromData($booking_id, $day);
                }
            } else {
                // Tự động copy lịch trình gốc của Tour sang Booking
                $this->copyScheduleFromTour($booking_id, $data['tour_id']);
            }

            $this->pdo->commit();
            return $booking_id;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // 7. CẬP NHẬT BOOKING (FULL LOGIC)
    public function updateBookingFull($id, $data) {
        try {
            // A. Update thông tin chung
            $sql = "UPDATE bookings SET hdv_id=?, phuong_tien=?, ngay_khoi_hanh=?, hotel_supplier_id=?, restaurant_supplier_id=?, status=?, chi_phi_phat_sinh=?, ly_do_phat_sinh=?, tong_tien=? WHERE id=?";
            $this->pdo->prepare($sql)->execute([
                empty($data['hdv_id']) ? null : $data['hdv_id'], 
                $data['phuong_tien'], 
                $data['ngay_khoi_hanh'],
                empty($data['hotel_supplier_id']) ? null : $data['hotel_supplier_id'], 
                empty($data['restaurant_supplier_id']) ? null : $data['restaurant_supplier_id'], 
                $data['status'], 
                $data['chi_phi_phat_sinh'], 
                $data['ly_do_phat_sinh'], 
                $data['tong_tien'], 
                $id
            ]);
            
            // B. Update Khách hàng (Xóa cũ thêm mới)
            if (!empty($data['customers'])) {
                $this->pdo->prepare("DELETE FROM booking_customers WHERE booking_id=?")->execute([$id]);
                $sqlCust = "INSERT INTO booking_customers (booking_id, ho_ten, so_dien_thoai, tuoi, gioi_tinh, gia_tien, CCCD) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmtCust = $this->pdo->prepare($sqlCust);
                foreach ($data['customers'] as $c) {
                    $stmtCust->execute([$id, $c['name'], $c['phone'], $c['age'], $c['gender'], $c['price'], $c['cccd']]);
                }
            }

            // C. Xử lý Lịch trình (Xóa/Sửa/Thêm)
            
            // C1. Xóa các mục bị đánh dấu
            if (!empty($data['deleted_days'])) {
                $delDays = explode(',', $data['deleted_days']);
                foreach ($delDays as $dId) if(is_numeric($dId)) {
                    $this->pdo->prepare("DELETE FROM booking_schedule_activities WHERE day_id=?")->execute([$dId]);
                    $this->pdo->prepare("DELETE FROM booking_schedule_days WHERE id=?")->execute([$dId]);
                }
            }
            if (!empty($data['deleted_activities'])) {
                $delActs = explode(',', $data['deleted_activities']);
                foreach ($delActs as $aId) if(is_numeric($aId)) {
                    $this->pdo->prepare("DELETE FROM booking_schedule_activities WHERE id=?")->execute([$aId]);
                }
            }

            // C2. Thêm mới hoặc Cập nhật
            if(!empty($data['schedule'])){
                $stmtUpdDay = $this->pdo->prepare("UPDATE booking_schedule_days SET tieu_de=?, mo_ta=? WHERE id=?");
                $stmtInsDay = $this->pdo->prepare("INSERT INTO booking_schedule_days (booking_id, ngay_thu, tieu_de, mo_ta) VALUES (?, ?, ?, ?)");
                
                $stmtUpdAct = $this->pdo->prepare("UPDATE booking_schedule_activities SET thoi_gian_bat_dau=?, thoi_gian_ket_thuc=?, dia_diem=?, hoat_dong=? WHERE id=?");
                $stmtInsAct = $this->pdo->prepare("INSERT INTO booking_schedule_activities (day_id, thoi_gian_bat_dau, thoi_gian_ket_thuc, dia_diem, hoat_dong) VALUES (?, ?, ?, ?, ?)");

                $dayCount = 0; // Để tính ngày thứ mấy nếu thêm mới

                foreach($data['schedule'] as $day_key => $day){
                    $dayCount++;
                    $current_day_id = 0;

                    if(is_numeric($day_key)){
                        // Cập nhật ngày cũ
                        $stmtUpdDay->execute([$day['tieu_de'], $day['mo_ta'], $day_key]);
                        $current_day_id = $day_key;
                    } else {
                        // Thêm ngày mới
                        $ngay_thu = $dayCount; 
                        $stmtInsDay->execute([$id, $ngay_thu, $day['tieu_de'], $day['mo_ta']]);
                        $current_day_id = $this->pdo->lastInsertId();
                    }

                    if(!empty($day['activities'])){
                        foreach($day['activities'] as $act_key => $act){
                            if(is_numeric($act_key)){
                                // Cập nhật hoạt động cũ
                                $stmtUpdAct->execute([$act['thoi_gian_bat_dau'], $act['thoi_gian_ket_thuc'], $act['dia_diem'], $act['hoat_dong'], $act_key]);
                            } else {
                                // Thêm hoạt động mới
                                $stmtInsAct->execute([$current_day_id, $act['thoi_gian_bat_dau'], $act['thoi_gian_ket_thuc'], $act['dia_diem'], $act['hoat_dong']]);
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            // Có thể log lỗi
        }
    }

    // 8. Lấy chi tiết Booking (Kèm Ảnh & Lịch trình Booking)
    public function getBookingDetailFull($id) {
        $sql = "SELECT b.*, 
                COALESCE(b.ngay_khoi_hanh, t.ngay_khoi_hanh) as ngay_khoi_hanh,
                t.ten_tour, t.loai_tour, h.ho_ten as hdv_name, s1.name as hotel_name, s2.name as res_name,
                (SELECT image_path FROM tour_images WHERE tour_id = t.id LIMIT 1) as tour_image
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
        
        // Lấy lịch trình từ bảng BOOKING (để hiển thị đúng cái đã sửa/copy)
        $days = $this->pdo->query("SELECT * FROM booking_schedule_days WHERE booking_id=$id ORDER BY ngay_thu ASC")->fetchAll(PDO::FETCH_ASSOC);
        foreach($days as &$day) {
             $day['activities'] = $this->pdo->query("SELECT * FROM booking_schedule_activities WHERE day_id={$day['id']} ORDER BY thoi_gian_bat_dau ASC")->fetchAll(PDO::FETCH_ASSOC);
        }
        $booking['schedule'] = $days;
        return $booking;
    }

    // 9. Thêm lịch sử thanh toán
    public function addPaymentHistory($booking_id, $amount, $type, $note) {
        $stmt = $this->pdo->prepare("INSERT INTO payment_history (booking_id, so_tien, loai_thanh_toan, ghi_chu, nguoi_thu_tien) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$booking_id, $amount, $type, $note, $_SESSION['user_name'] ?? 'Admin']);
        $this->pdo->prepare("UPDATE bookings SET tien_da_coc = (SELECT SUM(so_tien) FROM payment_history WHERE booking_id=?) WHERE id=?")->execute([$booking_id, $booking_id]);
    }
    
    // 10. Xóa Booking
    public function deleteBooking($id) {
        $this->pdo->prepare("DELETE FROM bookings WHERE id=?")->execute([$id]);
    }
    
    // 11. Lấy Data Tour cho Ajax (Gồm cả lịch trình)
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

    // --- CÁC HÀM HỖ TRỢ PRIVATE ---
    
    private function copyScheduleFromTour($booking_id, $tour_id) {
        $stmtDays = $this->pdo->prepare("SELECT * FROM tour_schedule_days WHERE tour_id = ? ORDER BY ngay_thu ASC");
        $stmtDays->execute([$tour_id]);
        $tourDays = $stmtDays->fetchAll(PDO::FETCH_ASSOC);

        if ($tourDays) {
            $stmtInsDay = $this->pdo->prepare("INSERT INTO booking_schedule_days (booking_id, ngay_thu, tieu_de, mo_ta) VALUES (?, ?, ?, ?)");
            $stmtInsAct = $this->pdo->prepare("INSERT INTO booking_schedule_activities (day_id, thoi_gian_bat_dau, thoi_gian_ket_thuc, dia_diem, hoat_dong) VALUES (?, ?, ?, ?, ?)");

            foreach ($tourDays as $td) {
                $stmtInsDay->execute([$booking_id, $td['ngay_thu'], $td['tieu_de'], $td['mo_ta']]);
                $newBookingDayId = $this->pdo->lastInsertId();

                $stmtActs = $this->pdo->prepare("SELECT * FROM tour_schedule_activities WHERE day_id = ?");
                $stmtActs->execute([$td['id']]);
                $tourActs = $stmtActs->fetchAll(PDO::FETCH_ASSOC);

                foreach ($tourActs as $ta) {
                    $stmtInsAct->execute([$newBookingDayId, $ta['thoi_gian_bat_dau'], $ta['thoi_gian_ket_thuc'], $ta['dia_diem'], $ta['hoat_dong']]);
                }
            }
        }
    }

    private function insertBookingDayFromData($booking_id, $day) {
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
?>
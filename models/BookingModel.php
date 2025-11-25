<?php
require_once "BaseModel.php";

class BookingModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct(); // gọi PDO
    }

    public function getAllTours()
    {
        $stmt = $this->pdo->query("SELECT * FROM tours");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllHdvs()
    {
        $stmt = $this->pdo->query("SELECT * FROM huong_dan_viens");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSuppliersByType($type)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM suppliers WHERE type = ?");
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy tất cả booking
    public function getAllBookings()
    {
        $sql = "SELECT b.*, t.ten_tour, h.ho_ten AS hdv_name
                FROM bookings b
                LEFT JOIN tours t ON b.tour_id = t.id
                LEFT JOIN huong_dan_viens h ON b.hdv_id = h.id
                ORDER BY b.created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết booking
    public function getBookingDetail($id)
    {
        // Lấy thông tin booking
        $stmt = $this->pdo->prepare("
        SELECT b.*, t.ten_tour, t.so_nguoi_toi_da, h.ho_ten AS hdv_name
        FROM bookings b
        LEFT JOIN tours t ON b.tour_id = t.id
        LEFT JOIN huong_dan_viens h ON b.hdv_id = h.id
        WHERE b.id = ?
    ");
        $stmt->execute([$id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$booking) return null;

        // Khách của booking
        $stmt2 = $this->pdo->prepare("
        SELECT bc.*, hr.room_type, hr.trang_thai, c.status AS checkin_status
        FROM booking_customers bc
        LEFT JOIN hotel_rooms hr ON hr.booking_customer_id = bc.id
        LEFT JOIN customer_checkin c ON c.booking_customer_id = bc.id
        WHERE bc.booking_id = ?
    ");
        $stmt2->execute([$id]);
        $booking['customers'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // Lịch trình tour
        $stmt3 = $this->pdo->prepare("
        SELECT * FROM tour_schedule_days 
        WHERE tour_id = ? ORDER BY ngay_thu
    ");
        $stmt3->execute([$booking['tour_id']]);
        $days = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        foreach ($days as &$day) {
            $stmt4 = $this->pdo->prepare("
            SELECT * FROM tour_schedule_activities 
            WHERE day_id = ? ORDER BY thoi_gian_bat_dau
        ");
            $stmt4->execute([$day['id']]);
            $day['activities'] = $stmt4->fetchAll(PDO::FETCH_ASSOC);
        }

        $booking['schedule'] = $days;

        // Nhà cung cấp tour
        $stmt5 = $this->pdo->prepare("
        SELECT ts.*, s.*
        FROM tour_suppliers ts
        JOIN suppliers s ON ts.supplier_id = s.id
        WHERE ts.tour_id = ?
        ");
        $stmt5->execute([$booking['tour_id']]);
        $booking['suppliers'] = $stmt5->fetchAll(PDO::FETCH_ASSOC);

        return $booking;
    }


    // Kiểm tra HDV có rảnh/nghỉ
    public function isHdvAvailable($hdv_id, $ngay_khoi_hanh)
    {
        $stmt1 = $this->pdo->prepare("SELECT * FROM hdv_lich_lam_viec WHERE hdv_id=? AND ngay=? AND trang_thai!='Rảnh'");
        $stmt1->execute([$hdv_id, $ngay_khoi_hanh]);
        $check1 = $stmt1->rowCount();

        $stmt2 = $this->pdo->prepare("SELECT * FROM hdv_nghi WHERE hdv_id=? AND ngay_nghi=?");
        $stmt2->execute([$hdv_id, $ngay_khoi_hanh]);
        $check2 = $stmt2->rowCount();

        return ($check1 == 0 && $check2 == 0);
    }

    // Thêm booking
    public function addBooking($data)
    {
        if (!$this->isHdvAvailable($data['hdv_id'], $data['ngay_khoi_hanh'])) {
            return ['error' => 'HDV không rảnh hoặc đang nghỉ'];
        }

        $sql = "INSERT INTO bookings (tour_id, hdv_id, customer_name, customer_phone, so_luong, tong_tien, created_by, hotel_supplier_id, restaurant_supplier_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $data['tour_id'],
            $data['hdv_id'],
            $data['customer_name'],
            $data['customer_phone'],
            $data['so_luong'],
            $data['tong_tien'],
            $data['created_by'],
            $data['hotel_supplier_id'],
            $data['restaurant_supplier_id']
        ]);
        return $this->pdo->lastInsertId();
    }

    // Cập nhật booking
    public function updateBooking($id, $data)
    {
        $sql = "UPDATE bookings SET tour_id=?, hdv_id=?, customer_name=?, customer_phone=?, so_luong=?, tong_tien=?, approved_by=?, approved_at=?, hotel_supplier_id=?, restaurant_supplier_id=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['tour_id'],
            $data['hdv_id'],
            $data['customer_name'],
            $data['customer_phone'],
            $data['so_luong'],
            $data['tong_tien'],
            $data['approved_by'],
            $data['approved_at'],
            $data['hotel_supplier_id'],
            $data['restaurant_supplier_id'],
            $id
        ]);
    }

    // Xóa booking
    public function deleteBooking($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM bookings WHERE id=?");
        return $stmt->execute([$id]);
    }
}

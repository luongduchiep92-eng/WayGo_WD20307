<?php
require_once PATH_MODEL . "TourModel.php";
require_once PATH_MODEL . "BookingModel.php";

class DashboardController {
    private $tourModel;
    private $bookingModel;

    public function __construct() {
        $this->tourModel = new TourModel();
        $this->bookingModel = new BookingModel();
    }

    public function index() {
        // 1. Lấy tất cả tour
        $tours = $this->tourModel->getAllTours();
        
        // 2. Xử lý tìm kiếm theo loại tour
        $filterType = $_GET['tour_type'] ?? '';
        if ($filterType) {
            $tours = array_filter($tours, function($t) use ($filterType) {
                // Ép kiểu object về array nếu cần, hoặc dùng $t->loai_tour nếu là object
                $t = (array)$t; 
                return $t['loai_tour'] === $filterType;
            });
        }

        // 3. Tính toán thống kê
        $stats = [
            'total' => count($tours),
            'active' => 0,
            'paused' => 0,
            'cancelled' => 0
        ];

        foreach ($tours as $t) {
            $t = (array)$t; // Đảm bảo là mảng
            if ($t['status'] == 'Hoạt động') $stats['active']++;
            elseif ($t['status'] == 'Đang tạm dừng') $stats['paused']++;
            elseif ($t['status'] == 'Hủy') $stats['cancelled']++;
        }

        // 4. Lấy số liệu Booking (Ví dụ: Doanh thu tạm tính)
        $bookings = $this->bookingModel->getAllBookings();
        $totalRevenue = 0;
        foreach($bookings as $b) {
            $totalRevenue += $b['tong_tien'];
        }

        include PATH_VIEW . 'admin/dashboard.php';
    }
}
<?php
class TourDiaryController {
    private $model;

    public function __construct() {
        $this->model = new TourDiaryModel();
    }

    // 1. Hiển thị danh sách các tour ĐÃ CÓ nhật ký
    public function listDiary() {
        $bookings = $this->model->getBookingsWithDiaries();
        include PATH_VIEW . 'admin/tour_diaries/list.php';
    }

    // 2. Trang Viết / Xem chi tiết
    public function manageDiary() {
        // Có thể lấy ID từ GET (xem/sửa) hoặc POST (khi chọn tour mới từ dropdown)
        $booking_id = $_REQUEST['booking_id'] ?? 0;

        if (!$booking_id) {
            // Nếu chưa có ID, chuyển sang trang chọn Tour (Add)
            $bookings = $this->model->getEligibleBookingsForSelect();
            include PATH_VIEW . 'admin/tour_diaries/add_select.php';
            return;
        }

        // Xử lý lưu dữ liệu
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
            $diaries = $_POST['diaries'] ?? [];
            $deleted_ids = $_POST['deleted_ids'] ?? '';
            $this->model->saveDiaries($booking_id, $diaries, $deleted_ids);
            
            // Reload lại trang
            header("Location: index.php?action=diary_manage&booking_id=$booking_id");
            exit;
        }

        // Lấy dữ liệu hiển thị
        $data = $this->model->getBookingWithDiaries($booking_id);
        include PATH_VIEW . 'admin/tour_diaries/form.php';
    }

    // 3. Xóa toàn bộ nhật ký của 1 tour
    public function deleteBookingDiaries() {
        $booking_id = $_GET['booking_id'] ?? 0;
        if ($booking_id) {
            $this->model->deleteAllDiariesByBooking($booking_id);
        }
        header("Location: index.php?action=diary_list");
        exit;
    }

    // Ajax lấy ngày
    public function ajaxGetTourDays() {
        $booking_id = $_GET['booking_id'] ?? 0;
        $days = $this->model->getTourDaysCount($booking_id);
        echo json_encode(['days' => $days]);
        exit;
    }
}
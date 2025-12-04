<?php
class CheckinController {
    private $model;

    public function __construct() {
        $this->model = new CheckinModel();
    }

    // Hiển thị danh sách tour để chọn
    public function listBookings() {
        $bookings = $this->model->getBookingsForCheckin();
        include PATH_VIEW . 'admin/checkin/list.php';
    }

    // Hiển thị giao diện Check-in chi tiết
    public function performCheckin() {
        $booking_id = $_GET['id'] ?? 0;
        $booking = $this->model->getBookingInfo($booking_id);
        $customers = $this->model->getCustomersByBookingId($booking_id);
        $stats = $this->model->getCheckinStats($booking_id); // Lấy thống kê

        include PATH_VIEW . 'admin/checkin/form.php';
    }

    // API AJAX: Cập nhật trạng thái từng khách
    public function ajaxUpdateStatus() {
        $id = $_POST['id'] ?? 0;
        $status = $_POST['status'] ?? '';
        $note = $_POST['note'] ?? null;

        if ($id && $status) {
            $this->model->updateCustomerStatus($id, $status, $note);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }

    // Action: Check-in tất cả
    public function checkinAll() {
        $booking_id = $_GET['id'] ?? 0;
        if ($booking_id) {
            $this->model->checkinAllPresent($booking_id);
        }
        header("Location: index.php?action=checkin_perform&id=$booking_id");
        exit;
    }
}
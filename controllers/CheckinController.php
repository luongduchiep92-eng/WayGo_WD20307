<?php
class CheckinController
{
    private $model;

    public function __construct()
    {
        $this->model = new CheckinModel();
    }

    // Hiển thị danh sách tour để chọn
    public function listBookings()
    {
        $bookings = $this->model->getBookingsForCheckin();
        include PATH_VIEW . 'admin/checkin/list.php';
    }

    // Hiển thị giao diện Check-in
    public function performCheckin()
    {
        $booking_id = $_GET['id'] ?? 0;
        $active_session_id = $_GET['session_id'] ?? null;

        $booking = $this->model->getBookingInfo($booking_id);

        // Lấy tất cả các lần điểm danh cũ
        $sessions = $this->model->getSessions($booking_id);
        // nhưng trong DB đã có session cũ -> Tự chọn cái mới nhất (đầu tiên)
        if (!$active_session_id && !empty($sessions)) {
            $active_session_id = $sessions[0]['id'];
        }

        $customers = [];
        $stats = ['total' => 0, 'present' => 0, 'absent' => 0, 'late' => 0, 'pending' => 0];

        // Nếu đã xác định được phiên cần xem -> Lấy danh sách khách
        if ($active_session_id) {
            $customers = $this->model->getSessionDetails($active_session_id);
            $stats = $this->model->getSessionStats($active_session_id);
        }

        if (isset($_SESSION['role']) && $_SESSION['role'] === 'hdv') {
            include PATH_VIEW . 'hdv/checkin_form.php';
        } else {
            include PATH_VIEW . 'admin/checkin/form.php';
        }
    }

    // Hàm tạo phiên (Đảm bảo code này đúng)
    public function createSession()
    {
        $booking_id = $_POST['booking_id'];
        $title = $_POST['title'];

        if (empty($title)) {
            $title = 'Điểm danh lúc ' . date('H:i d/m');
        }

        // Gọi model tạo và trả về ID vừa tạo
        $session_id = $this->model->createSession($booking_id, $title);

        if ($session_id) {
            // Chuyển hướng ngay đến phiên vừa tạo
            header("Location: index.php?action=checkin_perform&id=$booking_id&session_id=$session_id");
        } else {
            // Xử lý lỗi nếu không tạo được
            header("Location: index.php?action=checkin_perform&id=$booking_id");
        }
        exit;
    }

    // AJAX: Cập nhật trạng thái
    public function ajaxUpdateStatus()
    {
        $id = $_POST['id'] ?? 0; // Đây là ID của bảng checkin_details
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

    // Check-in tất cả
    public function checkinAll()
    {
        $booking_id = $_GET['id'];
        $session_id = $_GET['session_id'];

        if ($session_id) {
            $this->model->checkinAllPresent($session_id);
        }
        header("Location: index.php?action=checkin_perform&id=$booking_id&session_id=$session_id");
        exit;
    }
    public function deleteSession()
    {
        $session_id = $_GET['session_id'] ?? 0;
        $booking_id = $_GET['booking_id'] ?? 0;

        if ($session_id) {
            $this->model->deleteSession($session_id);
        }

        header("Location: index.php?action=checkin_perform&id=$booking_id");
        exit;
    }
}

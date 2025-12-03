<?php
class BookingController
{
    private $model;

    public function __construct() {
        $this->model = new BookingModel();
    }

    // API AJAX: Lấy thông tin tour để đổ vào form
    public function ajaxGetTourInfo() {
        if (!isset($_GET['tour_id'])) return;
        $data = $this->model->getTourDataForBooking($_GET['tour_id']);
        echo json_encode($data);
        exit;
    }

    public function listBooking() {
        $bookings = $this->model->getAllBookings();
        include PATH_VIEW . "admin/bookings/booking_list.php";
    }

    public function addBooking() {
        $tours = $this->model->getAllTours();
        $hdvs = $this->model->getAllHdvs();
        $hotels = $this->model->getSuppliersByType('Khách sạn');
        $restaurants = $this->model->getSuppliersByType('Nhà hàng');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate HDV
            $ngayKhoiHanh = $_POST['ngay_khoi_hanh']; 
            if (!$this->model->isHdvAvailable($_POST['hdv_id'], $ngayKhoiHanh)) {
                $error = "Hướng dẫn viên này đang bận hoặc nghỉ phép vào ngày $ngayKhoiHanh!";
            } else {
                $result = $this->model->createBookingFull($_POST);
                if (is_array($result) && isset($result['error'])) {
                    $error = $result['error'];
                } else {
                    header("Location: index.php?action=booking_list");
                    exit;
                }
            }
        }
        include PATH_VIEW . "admin/bookings/booking_add.php";
    }

    public function detailBooking() {
        $id = $_GET['id'] ?? 0;
        $booking = $this->model->getBookingDetailFull($id);
        
        // Tính toán tài chính
        $tongPhaiTra = $booking['tong_tien'] + $booking['chi_phi_phat_sinh'];
        $daThanhToan = $booking['tien_da_coc'];
        $conLai = $tongPhaiTra - $daThanhToan;

        include PATH_VIEW . "admin/bookings/booking_detail.php";
    }

    public function editBooking() {
        $id = $_GET['id'];
        $booking = $this->model->getBookingDetailFull($id);
        $tours = $this->model->getAllTours(); // Để hiển thị tên tour (disable)
        $hdvs = $this->model->getAllHdvs();
        $hotels = $this->model->getSuppliersByType('Khách sạn');
        $restaurants = $this->model->getSuppliersByType('Nhà hàng');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Validate HDV nếu thay đổi
             if ($_POST['hdv_id'] != $booking['hdv_id'] && !$this->model->isHdvAvailable($_POST['hdv_id'], $booking['ngay_khoi_hanh'], $id)) {
                $error = "Hướng dẫn viên mới đang bận!";
             } else {
                 $this->model->updateBookingFull($id, $_POST);
                 
                 // Nếu có nhập thêm cọc ở trang Edit
                 if (!empty($_POST['them_coc']) && $_POST['them_coc'] > 0) {
                     $this->model->addPaymentHistory($id, $_POST['them_coc'], 'Thanh toán thêm', 'Thêm từ trang sửa');
                 }
                 
                 header("Location: index.php?action=booking_detail&id=$id");
                 exit;
             }
        }
        include PATH_VIEW . "admin/bookings/booking_edit.php";
    }
    
    public function deleteBooking() {
        $this->model->deleteBooking($_GET['id']);
        header("Location: index.php?action=booking_list");
    }
}
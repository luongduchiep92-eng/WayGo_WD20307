<?php
class BookingController
{
    private $model;

    public function __construct() {
        $this->model = new BookingModel();
    }

    // LẤY HDV RẢNH THEO NGÀY & LOẠI TOUR
    public function ajaxGetAvailableHdvs() {
        $ngay = $_GET['date'] ?? '';
        $type = $_GET['type'] ?? '';
        $tour_id = $_GET['tour_id'] ?? null;

        if ($ngay && $type) {
            $hdvs = $this->model->getAvailableHdvs($ngay, $type, $tour_id);
            echo json_encode($hdvs);
        } else {
            echo json_encode([]);
        }
        exit;
    }
    
    public function ajaxGetTourInfo() {
        if (!isset($_GET['tour_id'])) return;
        $data = $this->model->getTourDataForBooking($_GET['tour_id']);
        echo json_encode($data);
        exit;
    }
public function listBooking() {
    // 1. Lấy trạng thái từ thanh tìm kiếm trên URL (nếu có)
    $status = $_GET['status'] ?? null; 

    // 2. Truyền trạng thái này vào Model
    $bookings = $this->model->getAllBookings($status);

    include PATH_VIEW . "admin/bookings/booking_list.php";
}

    public function addBooking() {
        $tours = $this->model->getAllTours();
        // $hdvs = $this->model->getAllHdvs(); // Xóa dòng này, không load HDV từ đầu nữa
        $hotels = $this->model->getSuppliersByType('Khách sạn');
        $restaurants = $this->model->getSuppliersByType('Nhà hàng');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->createBookingFull($_POST);
            if (is_array($result) && isset($result['error'])) {
                $error = $result['error'];
            } else {
                header("Location: index.php?action=booking_list");
                exit;
            }
        }
        include PATH_VIEW . "admin/bookings/booking_add.php";
    }

    public function detailBooking() {
        $id = $_GET['id'] ?? 0;
        $booking = $this->model->getBookingDetailFull($id);
        include PATH_VIEW . "admin/bookings/booking_detail.php";
    }

    public function editBooking() {
        $id = $_GET['id'];
        $booking = $this->model->getBookingDetailFull($id);
        $tours = $this->model->getAllTours(); 
        $hdvs = $this->model->getAllHdvs(); // Edit thì cứ load hết để hiển thị người cũ
        $hotels = $this->model->getSuppliersByType('Khách sạn');
        $restaurants = $this->model->getSuppliersByType('Nhà hàng');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $this->model->updateBookingFull($id, $_POST);
             
             // Xử lý thanh toán thêm (Loại bỏ dấu phẩy)
             if (!empty($_POST['them_coc']) && $_POST['them_coc'] != 0) {
                 $amount = str_replace(',', '', $_POST['them_coc']);
                 if(is_numeric($amount) && $amount > 0) {
                    $this->model->addPaymentHistory($id, $amount, 'Thanh toán thêm', 'Cập nhật tại trang chỉnh sửa');
                 }
             }
             header("Location: index.php?action=booking_detail&id=$id");
             exit;
        }
        include PATH_VIEW . "admin/bookings/booking_edit.php";
    }
    
    public function deleteBooking() {
        $this->model->deleteBooking($_GET['id']);
        header("Location: index.php?action=booking_list");
    }
}
<?php
class BookingController {
    private $model;

    public function __construct(){
        $this->model = new BookingModel();
    }

    public function listBooking() {
        $bookings = $this->model->getAllBookings();
        include PATH_VIEW . "bookings/booking_list.php";
    }

    public function detailBooking() {
        $id = $_GET['id'] ?? 0; // Lấy id từ GET, nếu không có thì mặc định 0
        $booking = $this->model->getBookingDetail($id);
        include PATH_VIEW . "bookings/booking_detail.php";
    }

    public function addBooking() {
        $tours = $this->model->getAllTours();
        $hdvs = $this->model->getAllHdvs();
        $hotels = $this->model->getSuppliersByType('Khách sạn');
        $restaurants = $this->model->getSuppliersByType('Nhà hàng');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = $_POST;
            $result = $this->model->addBooking($data);
            if(isset($result['error'])){
                $error = $result['error'];
            } else {
                header("Location: index.php?action=booking_list");
                exit;
            }
        }

        include PATH_VIEW . "bookings/booking_add.php";
    }

    public function editBooking() {
        $id = $_GET['id'] ?? 0; // Lấy id trực tiếp từ GET
        $booking = $this->model->getBookingDetail($id);
        $tours = $this->model->getAllTours();
        $hdvs = $this->model->getAllHdvs();
        $hotels = $this->model->getSuppliersByType('Khách sạn');
        $restaurants = $this->model->getSuppliersByType('Nhà hàng');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = $_POST;
            $this->model->updateBooking($id, $data);
            header("Location: index.php?action=booking_list");
            exit;
        }

        include PATH_VIEW . "bookings/booking_edit.php";
    }

    public function deleteBooking() {
        $id = $_GET['id'] ?? 0; // Lấy id từ GET
        if($id){
            $this->model->deleteBooking($id);
        }
        header("Location: index.php?action=booking_list");
        exit;
    }
}

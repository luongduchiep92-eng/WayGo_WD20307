<?php
// session_start();

// if (!isset($_SESSION['role'])) {
//     (new LoginController())->login();
//     exit;
// }

// $role = $_SESSION['role'] ?? 'tour_list';
$action = $_GET['action'] ?? '/';

// if ($role === 'admin') {
//     $controller = new TourController();

match ($action) {
    // tours: danh sách quản lý tour
    '/', 'tour_list' => (new TourController())->listTour(),
    'tour_add' => (new TourController())->addTour(),
    'tour_detail' => (new TourController())->detailTour(),
    'tour_edit' => (new TourController())->editTour(),
    'tour_delete' => (new TourController())->deleteTour(),
    //  guides: danh sách quản lý hướng dẫn viên
    'hdv_list' => (new HuongDanVienController())->listHDV(),
    'hdv_add' => (new HuongDanVienController())->addHDV(),
    'hdv_detail' => (new HuongDanVienController())->detailHDV(),
    'hdv_edit' => (new HuongDanVienController())->editHDV(),
    'hdv_delete' => (new HuongDanVienController())->deleteHDV(),
    // suppliers: danh sách quản lý nhà cung cấp
    'addsupplier' => (new SupplierController())->addSupplier(),
    'editsupplier' => (new SupplierController())->editSupplier(),
    'deletesupplier' => (new SupplierController())->deleteSupplier(),
    'listsupplier'   => (new SupplierController())->listSupplier(),
    'storesupplier'  => (new SupplierController())->storeSupplier(),
    'updatesupplier' => (new SupplierController())->updateSupplier(),
    'detailsupplier' => (new SupplierController())->detailSupplier(),
    // booking: danh sách quản lý đặt tour
    'booking_list' => (new BookingController())->listBooking(),
    'booking_detail' => (new BookingController())->detailBooking(),
    'booking_delete' => (new BookingController())->deleteBooking(),
    'booking_add' => (new BookingController())->addBooking(),
    'booking_edit' => (new BookingController())->editBooking(),
    default => (new TourController())->listTour(),
};
// }
// elseif ($role === 'hdv') {
//     $controller = new HuongDanVienController();

//     match ($action) {
//         default => $controller->index(),
//     };
// }
// else {
//     echo "Bạn không có quyền truy cập!";
// }

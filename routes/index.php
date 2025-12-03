<?php
// session_start();

if (!isset($_SESSION['user_id']) && !in_array($_GET['action'] ?? '', ['login', 'register'])) {
    header("Location: index.php?action=login");
    exit;
}
// $role = $_SESSION['role'] ?? 'tour_list';
$action = $_GET['action'] ?? 'dashboard';

// if ($role === 'admin') {
//     $controller = new TourController();

match ($action) {
    'dashboard' => (new DashboardController())->index(),
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
    // auth: đăng nhập, đăng xuất
    'login' => (new AuthController())->login(),
    'register' => (new AuthController())->register(),
    'logout' => (new AuthController())->logout(),
    
    // Booking Routes
    'booking_list' => (new BookingController())->listBooking(),
    'booking_add' => (new BookingController())->addBooking(),
    'booking_detail' => (new BookingController())->detailBooking(),
    'booking_edit' => (new BookingController())->editBooking(),
    'booking_delete' => (new BookingController())->deleteBooking(),
    'ajax_get_tour' => (new BookingController())->ajaxGetTourInfo(),
    'ajax_get_hdv_avail' => (new BookingController())->ajaxGetAvailableHdvs(),
    // comments: đánh giá nhà cung cấp
    'comments_list' => (new CommentController())->listComments(),
    'comment_add_form' => (new CommentController())->showAddForm(),
    'comment_add' => (new CommentController())->addComment(),
    'comment_delete' => (new CommentController())->deleteComment(),
    'comment_detail' => (new CommentController())->detailComment(),
    // NHẬT KÝ TOUR (TOUR DIARY)
    'diary_list' => (new TourDiaryController())->listDiary(),
    'diary_add' => (new TourDiaryController())->addDiary(),
    'diary_detail' => (new TourDiaryController())->detailDiary(),
    'diary_edit' => (new TourDiaryController())->editDiary(),
    'diary_delete' => (new TourDiaryController())->deleteDiary(),
    default => (new DashboardController())->index(),
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

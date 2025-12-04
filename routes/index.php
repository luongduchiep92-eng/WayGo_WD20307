<?php
/**
 * File: routes/index.php
 */

// 1. Kiểm tra session_id() để tránh lỗi "Session already active"
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = $_GET['action'] ?? 'dashboard';

// 2. KHU VỰC CÔNG KHAI (Public Routes) - Ai cũng vào được
// Bao gồm: Đăng nhập, Đăng ký, Đăng xuất
if (in_array($action, ['login', 'register', 'logout'])) {
    match ($action) {
        'login' => (new AuthController())->login(),
        'register' => (new AuthController())->register(),
        'logout' => (new AuthController())->logout(),
    };
    return; // Dừng xử lý tại đây sau khi xong
}

// 3. KIỂM TRA ĐĂNG NHẬP (Authentication Check)
// Nếu chưa đăng nhập -> Đá về trang login ngay
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit;
}

// 4. PHÂN QUYỀN (Authorization) - Dựa vào Role
$role = $_SESSION['role'] ?? '';

if ($role === 'admin') {
    // --- KHU VỰC CỦA ADMIN ---
    match ($action) {
        'dashboard' => (new DashboardController())->index(),
        
        // Quản lý Tour
        '/', 'tour_list' => (new TourController())->listTour(),
        'tour_add' => (new TourController())->addTour(),
        'tour_detail' => (new TourController())->detailTour(),
        'tour_edit' => (new TourController())->editTour(),
        'tour_delete' => (new TourController())->deleteTour(),
        
        // Quản lý HDV
        'hdv_list' => (new HuongDanVienController())->listHDV(),
        'hdv_add' => (new HuongDanVienController())->addHDV(),
        'hdv_detail' => (new HuongDanVienController())->detailHDV(),
        'hdv_edit' => (new HuongDanVienController())->editHDV(),
        'hdv_delete' => (new HuongDanVienController())->deleteHDV(),
        
        // Quản lý NCC
        'listsupplier'   => (new SupplierController())->listSupplier(),
        'addsupplier' => (new SupplierController())->addSupplier(),
        'storesupplier'  => (new SupplierController())->storeSupplier(),
        'detailsupplier' => (new SupplierController())->detailSupplier(),
        'editsupplier' => (new SupplierController())->editSupplier(),
        'updatesupplier' => (new SupplierController())->updateSupplier(),
        'deletesupplier' => (new SupplierController())->deleteSupplier(),
        
        // Quản lý Booking
        'booking_list' => (new BookingController())->listBooking(),
        'booking_add' => (new BookingController())->addBooking(),
        'booking_detail' => (new BookingController())->detailBooking(),
        'booking_edit' => (new BookingController())->editBooking(),
        'booking_delete' => (new BookingController())->deleteBooking(),
        'ajax_get_tour' => (new BookingController())->ajaxGetTourInfo(),
        'ajax_get_hdv_avail' => (new BookingController())->ajaxGetAvailableHdvs(),
        
        // Quản lý Đánh giá
        'comments_list' => (new CommentController())->listComments(),
        'comment_add_form' => (new CommentController())->showAddForm(),
        'comment_add' => (new CommentController())->addComment(),
        'comment_delete' => (new CommentController())->deleteComment(),
        'comment_detail' => (new CommentController())->detailComment(),
        
        // Nhật ký Tour
        'diary_list' => (new TourDiaryController())->listDiary(),
        'diary_add' => (new TourDiaryController())->addDiary(),
        'diary_detail' => (new TourDiaryController())->detailDiary(),
        'diary_edit' => (new TourDiaryController())->editDiary(),
        'diary_delete' => (new TourDiaryController())->deleteDiary(),
        
        // Check-in
        'checkin_list' => (new CheckinController())->listBookings(),
        'checkin_perform' => (new CheckinController())->performCheckin(),
        'checkin_ajax_update' => (new CheckinController())->ajaxUpdateStatus(),
        'checkin_all' => (new CheckinController())->checkinAll(),
        
        default => (new DashboardController())->index(),
    };

} elseif ($role === 'hdv') {
    // --- KHU VỰC CỦA HDV ---
    match ($action) {
        'dashboard' => (new HdvAppController())->index(),
        'my_tours'  => (new HdvAppController())->myTours(),
        'hdv_tour_detail' => (new HdvAppController())->detailTour(),
        
        // Các chức năng dùng chung với Admin (nhưng giao diện HDV)
        'checkin_perform' => (new CheckinController())->performCheckin(),
        'checkin_ajax_update' => (new CheckinController())->ajaxUpdateStatus(),
        'checkin_all' => (new CheckinController())->checkinAll(),
        'diary_add' => (new TourDiaryController())->addDiary(),
        'diary_edit' => (new TourDiaryController())->editDiary(),
        
        default => (new HdvAppController())->index(),
    };

} else {
    // Trường hợp đăng nhập rồi nhưng role lạ hoặc bị lỗi
    echo "<div style='text-align:center; margin-top:50px;'>";
    echo "<h3>Bạn không có quyền truy cập khu vực này!</h3>";
    echo "<p>Role hiện tại: <strong>$role</strong></p>";
    echo "<a href='index.php?action=logout'>Đăng xuất</a>";
    echo "</div>";
}
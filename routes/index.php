<?php
/**
 * File: routes/index.php
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = $_GET['action'] ?? 'dashboard';

// --- 1. KHU VỰC CÔNG KHAI (Login/Register) ---
if (in_array($action, ['login', 'register', 'logout'])) {
    match ($action) {
        'login' => (new AuthController())->login(),
        'register' => (new AuthController())->register(),
        'logout' => (new AuthController())->logout(),
    };
    return;
}

// --- 2. KIỂM TRA ĐĂNG NHẬP ---
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit;
}

// Lấy role từ session
$role = $_SESSION['role'] ?? '';

// NHÓM 1: ADMIN & STAFF -> Vào trang quản trị
if ($role === 'admin' || $role === 'staff') {
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
        'diary_manage' => (new TourDiaryController())->manageDiary(),
        'diary_delete_all' => (new TourDiaryController())->deleteBookingDiaries(),
        'ajax_get_tour_days' => (new TourDiaryController())->ajaxGetTourDays(),

        // Check-in
        'checkin_list' => (new CheckinController())->listBookings(),
        'checkin_perform' => (new CheckinController())->performCheckin(),
        'checkin_ajax_update' => (new CheckinController())->ajaxUpdateStatus(),
        'checkin_all' => (new CheckinController())->checkinAll(),
        'checkin_create_session' => (new CheckinController())->createSession(),
        'checkin_delete_session' => (new CheckinController())->deleteSession(),
        default => (new DashboardController())->index(),
    };

} 
// NHÓM 2: HDV -> Vào trang ứng dụng mobile
elseif ($role === 'hdv') {
    match ($action) {
        'dashboard' => (new HdvAppController())->index(),
        'my_tours'  => (new HdvAppController())->myTours(),
        'hdv_tour_detail' => (new HdvAppController())->detailTour(),
        
        // Các chức năng dùng chung (Checkin & Diary)
        'checkin_perform' => (new CheckinController())->performCheckin(),
        'checkin_ajax_update' => (new CheckinController())->ajaxUpdateStatus(),
        'checkin_all' => (new CheckinController())->checkinAll(),
        'diary_add' => (new TourDiaryController())->addDiary(),
        'diary_edit' => (new TourDiaryController())->editDiary(),
        
        default => (new HdvAppController())->index(),
    };

} 
else {
    // Role lạ hoặc user thường (không có quyền vào admin)
    echo "<div style='display:flex; justify-content:center; align-items:center; height:100vh; flex-direction:column; font-family:sans-serif;'>";
    echo "<h2 style='color:red;'>Truy cập bị từ chối!</h2>";
    echo "<p>Tài khoản của bạn (Role: $role) không có quyền truy cập trang quản trị.</p>";
    echo "<a href='index.php?action=logout' style='padding:10px 20px; background:#333; color:#fff; text-decoration:none; border-radius:5px;'>Đăng xuất</a>";
    echo "</div>";
}
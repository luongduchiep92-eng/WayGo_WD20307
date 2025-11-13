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
        '/', 'tour_list' => (new TourController())->listTour(),
        'tour_add' => (new TourController())->addTour(),
        'tour_detail' => (new TourController())->detailTour(),
        'tour_edit' => (new TourController())->editTour(),
        'tour_delete' => (new TourController())->deleteTour(),
        'hdv_list' => (new TourController())->listHDV(),
        'hdv_add' => (new TourController())->addHDV(),
        'hdv_detail' => (new TourController())->detailHDV(),
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

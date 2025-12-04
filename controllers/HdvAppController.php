<?php
// Gọi Model checkin và diary để tái sử dụng
require_once PATH_MODEL . 'CheckinModel.php';
require_once PATH_MODEL . 'TourDiaryModel.php';
require_once PATH_MODEL . 'HdvAppModel.php';

class HdvAppController {
    private $model;

    public function __construct() {
        $this->model = new HdvAppModel();
    }

    public function index() {
        $hdv_id = $_SESSION['hdv_profile_id'] ?? 0;
        
        // --- DEBUG (Nếu vẫn không thấy tour, hãy bỏ comment dòng dưới để xem ID là gì) ---
        // echo "HDV ID: " . $hdv_id; die; 
        
        $stats = $this->model->getHdvStats($hdv_id);
        $tours = $this->model->getMyTours($hdv_id);
        include PATH_VIEW . 'hdv/dashboard.php';
    }

    public function myTours() {
        $hdv_id = $_SESSION['hdv_profile_id'] ?? 0;
        $tours = $this->model->getMyTours($hdv_id);
        include PATH_VIEW . 'hdv/my_tours.php';
    }

    // [MỚI] Xem chi tiết lịch trình tour
    public function detailTour() {
        $tour_id = $_GET['tour_id'] ?? 0;
        
        if(!$tour_id) {
            echo "Lỗi: Không tìm thấy ID tour."; die;
        }

        $tour = $this->model->getTourScheduleFull($tour_id);
        
        // Debug nếu cần:
        // echo "<pre>"; print_r($tour); die;

        include PATH_VIEW . 'hdv/tour_detail.php';
    }
}
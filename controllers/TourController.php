<?php
class TourController {
    private $model;

    public function __construct(){
        $this->model = new TourModel();
    }
public function listTour(){
    // Lấy dữ liệu từ thanh tìm kiếm (nếu có)
    $keyword = $_GET['keyword'] ?? null;
    $loai_tour = $_GET['loai_tour'] ?? null;

    // Gọi model với tham số lọc
    $tours = $this->model->getAllTours($keyword, $loai_tour);
    
    include PATH_VIEW . 'admin/tours/tour_list.php';
}

    public function addTour(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $tourData = [
                'ten_tour'=>$_POST['ten_tour'],
                'loai_tour'=>$_POST['loai_tour'],
                'dia_diem'=>$_POST['dia_diem'],
                'thoi_gian'=>$_POST['thoi_gian'],
                'gia_tour'=>$_POST['gia_tour'],
                'mo_ta'=>$_POST['mo_ta'],
                'ngay_khoi_hanh'=>$_POST['ngay_khoi_hanh'],
                'phuong_tien'=>$_POST['phuong_tien'],
                'so_nguoi_toi_da'=>$_POST['so_nguoi_toi_da'],
                'status' => $_POST['status']
            ];
            $tour_id = $this->model->insertTour($tourData);

            // Hình ảnh
            if(!empty($_POST['images'])){
                foreach($_POST['images'] as $img){
                    if(!empty($img)) $this->model->insertTourImage($tour_id, $img);
                }
            }

            // Lịch trình
            if(!empty($_POST['schedule'])){
                foreach($_POST['schedule'] as $day){
                    $day_id = $this->model->insertScheduleDay($tour_id, $day['tieu_de'], $day['mo_ta']);
                    if(!empty($day['activities'])){
                        foreach($day['activities'] as $act){
                            $this->model->insertScheduleActivity($day_id, $act);
                        }
                    }
                }
            }

            header("Location: index.php?action=tour_list"); exit;
        }

        include PATH_VIEW . 'admin/tours/tour_add.php';
    }

    public function detailTour(){
    $id = $_GET['id'] ?? 0;
    $tour = $this->model->getTourById($id);

    // Lấy lịch trình tour
    $schedule = $this->model->getTourSchedule($id);

    include PATH_VIEW . 'admin/tours/tour_detail.php';
    }
   public function editTour(){
    $id = $_GET['id'] ?? 0;
    $tour = $this->model->getTourById($id);
    $schedule = $this->model->getTourSchedule($id);
    $images = $this->model->getTourImages($id);

    if($_SERVER['REQUEST_METHOD']==='POST'){
        // 1. Cập nhật thông tin cơ bản
        $tourData = [
            'ten_tour'=>$_POST['ten_tour'],
            'loai_tour'=>$_POST['loai_tour'],
            'dia_diem'=>$_POST['dia_diem'],
            'thoi_gian'=>$_POST['thoi_gian'],
            'gia_tour'=>$_POST['gia_tour'],
            'mo_ta'=>$_POST['mo_ta'],
            'ngay_khoi_hanh'=>$_POST['ngay_khoi_hanh'] ?? null,
            'phuong_tien'=>$_POST['phuong_tien'],
            'so_nguoi_toi_da'=>$_POST['so_nguoi_toi_da'],
            'status' => $_POST['status']
        ];
        $this->model->updateTour($id, $tourData);
        // Xóa Hoạt động bị đánh dấu
        if (!empty($_POST['deleted_activities'])) {
            $delActIds = explode(',', $_POST['deleted_activities']);
            foreach ($delActIds as $delId) {
                if (is_numeric($delId)) $this->model->deleteScheduleActivity($delId);
            }
        }
        // Xóa Ngày bị đánh dấu
        if (!empty($_POST['deleted_days'])) {
            $delDayIds = explode(',', $_POST['deleted_days']);
            foreach ($delDayIds as $delId) {
                if (is_numeric($delId)) $this->model->deleteScheduleDay($delId);
            }
        }

        // 3. Xử lý Thêm mới / Cập nhật Lịch trình
        if(!empty($_POST['schedule'])){
            foreach($_POST['schedule'] as $day_key => $day){
                // Nếu key là số -> Cập nhật ngày cũ. Nếu key là chuỗi (vd: new_1) -> Thêm ngày mới
                if(is_numeric($day_key)){
                    $current_day_id = $day_key;
                    $this->model->updateScheduleDay($current_day_id, $day);
                } else {
                    $current_day_id = $this->model->insertScheduleDay($id, $day['tieu_de'], $day['mo_ta']);
                }

                // Xử lý hoạt động bên trong ngày
                if(!empty($day['activities'])){
                    foreach($day['activities'] as $act_key => $act){
                        if(is_numeric($act_key)){
                            // Cập nhật hoạt động cũ
                            $this->model->updateScheduleActivity($act_key, $act);
                        } else {
                            // Thêm hoạt động mới
                            $this->model->insertScheduleActivity($current_day_id, $act);
                        }
                    }
                }
            }
        }

        // 4. Xử lý hình ảnh (Giữ nguyên logic cũ)
        if(!empty($_POST['images_existing'])){
            foreach($_POST['images_existing'] as $img_id=>$path){
                if(empty($path)){
                    $this->model->deleteTourImage($img_id);
                }else{
                    $this->model->updateTourImage($img_id, $path);
                }
            }
        }
        if(!empty($_POST['images_new'])){
            foreach($_POST['images_new'] as $path){
                if(!empty($path)) $this->model->insertTourImage($id, $path);
            }
        }

        header("Location: index.php?action=tour_detail&id=$id"); exit;
    }

    include PATH_VIEW . 'admin/tours/tour_edit.php';
}
    public function deleteTour(){
    $id = $_GET['id'] ?? 0;

    if($id){
        $this->model->deleteTour($id);
    }
    header("Location: index.php?action=tour_list");
    exit;
}

}
?>

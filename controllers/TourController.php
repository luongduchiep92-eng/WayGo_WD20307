<?php
class TourController {
    private $model;

    public function __construct(){
        $this->model = new TourModel();
    }

    public function listTour(){
        $tours = $this->model->getAllTours();
        include PATH_VIEW . 'tours/tour_list.php';
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
                'so_nguoi_toi_da'=>$_POST['so_nguoi_toi_da']
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

        include PATH_VIEW . 'tours/tour_add.php';
    }

    public function detailTour(){
    $id = $_GET['id'] ?? 0;
    $tour = $this->model->getTourById($id);

    // Lấy lịch trình tour
    $schedule = $this->model->getTourSchedule($id);

    include PATH_VIEW . 'tours/tour_detail.php';
    }



    public function editTour(){
        $id = $_GET['id'] ?? 0;
        $tour = $this->model->getTourById($id);
        $schedule = $this->model->getTourSchedule($id);
        $images = $this->model->getTourImages($id);

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
                'so_nguoi_toi_da'=>$_POST['so_nguoi_toi_da']
            ];
            $this->model->updateTour($id, $tourData);

            // Xử lý hình ảnh cũ
            if(!empty($_POST['images_existing'])){
                foreach($_POST['images_existing'] as $img_id=>$path){
                    if(empty($path)){
                        $this->model->deleteTourImage($img_id);
                    }else{
                        $this->model->updateTourImage($img_id, $path);
                    }
                }
            }

            // Hình ảnh mới
            if(!empty($_POST['images_new'])){
                foreach($_POST['images_new'] as $path){
                    if(!empty($path)) $this->model->insertTourImage($id, $path);
                }
            }

            // Xử lý lịch trình
            if(!empty($_POST['schedule'])){
                foreach($_POST['schedule'] as $day_id=>$day){
                    if(is_numeric($day_id)){
                        // Cập nhật ngày hiện có
                        $this->model->updateScheduleDay($day_id, $day);
                        if(!empty($day['activities'])){
                            foreach($day['activities'] as $act_id=>$act){
                                if(is_numeric($act_id)){
                                    // Cập nhật hoạt động hiện có
                                    $this->model->updateScheduleActivity($act_id, $act);
                                }else{
                                    // Thêm hoạt động mới
                                    $this->model->insertScheduleActivity($day_id, $act);
                                }
                            }
                        }
                    }else{
                        // Thêm ngày mới
                        $new_day_id = $this->model->insertScheduleDay($id, $day['tieu_de'], $day['mo_ta']);
                        if(!empty($day['activities'])){
                            foreach($day['activities'] as $act){
                                $this->model->insertScheduleActivity($new_day_id, $act);
                            }
                        }
                    }
                }
            }

            header("Location: index.php?action=tour_detail&id=$id"); exit;
        }

        include PATH_VIEW . 'tours/tour_edit.php';
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

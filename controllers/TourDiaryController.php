<?php
class TourDiaryController {
    private $model;

    public function __construct() {
        $this->model = new TourDiaryModel();
    }

    public function listDiary() {
        $diaries = $this->model->getAllDiaries();
        include PATH_VIEW . 'admin/tour_diaries/list.php';
    }

    public function addDiary() {
        // Lấy danh sách booking đã hoàn tất để chọn
        $bookings = $this->model->getCompletedBookingsForSelect();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create($_POST);
            header("Location: index.php?action=diary_list");
            exit;
        }
        include PATH_VIEW . 'admin/tour_diaries/add.php';
    }

    public function editDiary() {
        $id = $_GET['id'];
        $diary = $this->model->getDiaryById($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header("Location: index.php?action=diary_detail&id=$id");
            exit;
        }
        include PATH_VIEW . 'admin/tour_diaries/edit.php';
    }

    public function detailDiary() {
        $id = $_GET['id'];
        $diary = $this->model->getDiaryById($id);
        include PATH_VIEW . 'admin/tour_diaries/detail.php';
    }

    public function deleteDiary() {
        $this->model->delete($_GET['id']);
        header("Location: index.php?action=diary_list");
    }
}
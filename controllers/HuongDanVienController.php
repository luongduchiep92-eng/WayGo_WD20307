<?php
class HuongDanVienController
{
    private $model;

    public function __construct()
    {
        $this->model = new HuongDanVienModel();
    }

    public function listHDV()
    {
        $hdvs = $this->model->getAllHDV();
        include PATH_VIEW . 'huong_dan_vien/hdv_list.php';
    }

    public function detailHDV()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?action=hdv_list");
            exit;
        }

        $hdv = $this->model->getHDVById($id);
        include PATH_VIEW . 'huong_dan_vien/hdv_detail.php';
    }

    public function addHDV()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ho_ten' => $_POST['ho_ten'],
                'avatar' => $_POST['avatar'] ?? null,
                'ngay_sinh' => $_POST['ngay_sinh'],
                'so_dien_thoai' => $_POST['so_dien_thoai'],
                'email' => $_POST['email'],
                'chung_chi' => $_POST['chung_chi'],
                'ngon_ngu' => $_POST['ngon_ngu'],
                'kinh_nghiem_nam' => $_POST['kinh_nghiem_nam'],
                'loai_hdv' => $_POST['loai_hdv'],
                'suc_khoe' => $_POST['suc_khoe'],
                'danh_gia' => $_POST['danh_gia']
            ];

            $this->model->insertHDV($data);
            header("Location: index.php?action=hdv_list");
            exit;
        }

        include PATH_VIEW . 'huong_dan_vien/hdv_add.php';
    }

    public function editHDV()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?action=hdv_list");
            exit;
        }

        $hdv = $this->model->getHDVById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ho_ten' => $_POST['ho_ten'],
                'avatar' => $_POST['avatar'] ?? $hdv->avatar,
                'ngay_sinh' => $_POST['ngay_sinh'],
                'so_dien_thoai' => $_POST['so_dien_thoai'],
                'email' => $_POST['email'],
                'chung_chi' => $_POST['chung_chi'],
                'ngon_ngu' => $_POST['ngon_ngu'],
                'kinh_nghiem_nam' => $_POST['kinh_nghiem_nam'],
                'loai_hdv' => $_POST['loai_hdv'],
                'suc_khoe' => $_POST['suc_khoe'],
                'danh_gia' => $_POST['danh_gia']
            ];

            $this->model->updateHDV($id, $data);
            header("Location: index.php?action=hdv_list");
            exit;
        }

        include PATH_VIEW . 'huong_dan_vien/hdv_edit.php';
    }

    public function deleteHDV()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->deleteHDV($id);
        }
        header("Location: index.php?action=hdv_list");
        exit;
    }
}

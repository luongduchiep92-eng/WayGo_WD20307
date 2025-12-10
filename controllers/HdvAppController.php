<?php
require_once PATH_MODEL . 'CheckinModel.php';
require_once PATH_MODEL . 'TourDiaryModel.php';
require_once PATH_MODEL . 'HdvAppModel.php';

class HdvAppController
{
    private $model;

    public function __construct()
    {
        $this->model = new HdvAppModel();
    }

    public function index()
    {
        $hdv_id = $_SESSION['hdv_profile_id'] ?? 0;
        $stats = $this->model->getHdvStats($hdv_id);
        $tours = $this->model->getMyTours($hdv_id);

        // Lọc chỉ giữ tour đang hoặc sắp diễn ra
        $today = date('Y-m-d');
        foreach ($tours as $key => $tour) {
            $startDate = !empty($tour['bk_ngay_khoi_hanh']) ? $tour['bk_ngay_khoi_hanh'] : $tour['ngay_khoi_hanh'];
            if (empty($startDate)) {
                // Tour chưa có ngày khởi hành -> xem như sắp tới
                $tours[$key]['timeline_status'] = 'Sắp tới';
                $startDate = null;
            }
            if ($startDate) {
                // Tính ngày kết thúc tour (start + total_days - 1)
                $days = (int)($tour['total_days'] ?? 1);
                if ($days < 1) $days = 1;
                $endDate = date('Y-m-d', strtotime("$startDate + " . ($days - 1) . " days"));
                if ($endDate < $today) {
                    // Loại bỏ tour đã kết thúc (trước hôm nay)
                    unset($tours[$key]);
                    continue;
                }
                // Gán trạng thái dựa trên thời gian
                if ($today < $startDate) {
                    $tours[$key]['timeline_status'] = 'Sắp tới';
                } elseif ($today <= $endDate) {
                    $tours[$key]['timeline_status'] = 'Đang tiến hành';
                } else {
                    $tours[$key]['timeline_status'] = 'Đã hoàn thành';
                }
            }
        }
        // Đặt lại chỉ số mảng sau khi unset
        $tours = array_values($tours);

        include PATH_VIEW . 'hdv/home.php';
    }

    public function myTours()
    {
        $hdv_id = $_SESSION['hdv_profile_id'] ?? 0;
        $tours = $this->model->getMyTours($hdv_id);

        // Lọc chỉ giữ tour đã khởi hành (bao gồm đã hoàn thành và đang diễn ra)
        $today = date('Y-m-d');
        foreach ($tours as $key => $tour) {
            $startDate = !empty($tour['bk_ngay_khoi_hanh']) ? $tour['bk_ngay_khoi_hanh'] : $tour['ngay_khoi_hanh'];
            if (empty($startDate) || $startDate > $today) {
                // Chưa có ngày hoặc khởi hành trong tương lai -> bỏ qua
                unset($tours[$key]);
                continue;
            }
            // Tính ngày kết thúc
            $days = (int)($tour['total_days'] ?? 1);
            if ($days < 1) $days = 1;
            $endDate = date('Y-m-d', strtotime("$startDate + " . ($days - 1) . " days"));
            // Gán trạng thái 'Đang tiến hành' hoặc 'Đã hoàn thành'
            if ($today <= $endDate) {
                $tours[$key]['timeline_status'] = 'Đang tiến hành';
            } else {
                $tours[$key]['timeline_status'] = 'Đã hoàn thành';
            }
        }
        $tours = array_values($tours);

        include PATH_VIEW . 'hdv/my_tours.php';
    }

    // [MỚI] Xem chi tiết lịch trình tour
    public function detailTour()
    {
        $tour_id = $_GET['tour_id'] ?? 0;

        if (!$tour_id) {
            echo "Lỗi: Không tìm thấy ID tour.";
            die;
        }

        $tour = $this->model->getTourScheduleFull($tour_id);

        include PATH_VIEW . 'hdv/tour_detail.php';
    }

    public function manageDiary()
    {
        $hdv_id    = $_SESSION['hdv_profile_id'] ?? 0;
        $booking_id = $_REQUEST['booking_id'] ?? 0;

        // Nếu chưa chọn tour nào, hiển thị danh sách các tour của HDV (đã khởi hành) để chọn viết nhật ký
        if (!$booking_id) {
            $tours = $this->model->getMyTours($hdv_id);
            // Chỉ lấy những tour đã hoặc đang diễn ra (ngày khởi hành <= hôm nay)
            $tours = array_filter($tours, function ($t) {
                return !empty($t['ngay_khoi_hanh']) && strtotime($t['ngay_khoi_hanh']) <= time();
            });
            include PATH_VIEW . 'hdv/diary_select.php';
            return;
        }

        // Đảm bảo booking thuộc HDV hiện tại
        $diaryModel = new TourDiaryModel();
        $booking = $diaryModel->getBookingWithDiaries($booking_id);
        if (!$booking || $booking['hdv_id'] != $hdv_id) {
            die("Không tìm thấy tour hoặc không có quyền truy cập!");
        }

        // Nếu submit form (POST) thì lưu nhật ký
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $diaries    = $_POST['diaries'] ?? [];
            $deleted_ids = '';

            // Xử lý những entry bị xóa (nội dung trống)
            $ids_to_delete = [];
            foreach ($diaries as $day => $entry) {
                $content = trim($entry['noi_dung'] ?? '');
                if (!empty($entry['id']) && $content === '') {
                    $ids_to_delete[] = $entry['id'];  // đánh dấu xóa nhật ký cũ nếu nội dung bị xóa
                }
                // Bỏ qua entry rỗng (không tiêu đề và nội dung)
                if ($content === '' && ($entry['tieu_de'] ?? '') === '') {
                    unset($diaries[$day]);
                }
            }
            if (!empty($ids_to_delete)) {
                $deleted_ids = implode(',', $ids_to_delete);
            }

            // Lưu thay đổi nhật ký vào CSDL
            $diaryModel->saveDiaries($booking_id, $diaries, $deleted_ids);
            header("Location: index.php?action=diary_manage&booking_id=$booking_id");
            exit;
        }

        // Nếu phương thức GET: hiển thị form nhập nhật ký
        $max_days = $diaryModel->getTourDaysCount($booking_id);
        $data = $booking;
        $data['max_days'] = $max_days;
        include PATH_VIEW . 'hdv/diary_form.php';
    }
}

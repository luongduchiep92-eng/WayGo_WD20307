<?php

require_once "BaseModel.php";

class HdvAppModel extends BaseModel
{
    public function getMyTours($hdv_id)
    {
        $sql = "SELECT 
                    b.id AS booking_id,
                    COALESCE(b.ngay_khoi_hanh, t.ngay_khoi_hanh) AS bk_ngay_khoi_hanh,
                    t.id AS tour_id,
                    t.ten_tour,
                    t.ngay_khoi_hanh,
                    t.dia_diem,
                    t.thoi_gian,
                    b.so_luong,
                    b.status,
                    t.phuong_tien,
                    /* Thêm tổng số ngày của tour */
                    (SELECT COUNT(*) FROM tour_schedule_days WHERE tour_id = t.id) AS total_days
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                WHERE b.hdv_id = ?
                ORDER BY COALESCE(b.ngay_khoi_hanh, t.ngay_khoi_hanh) ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$hdv_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHdvStats($hdv_id)
    {
        $sql = "SELECT 
                    COUNT(*) AS total_tours,
                    SUM(CASE WHEN t.ngay_khoi_hanh >= CURDATE() THEN 1 ELSE 0 END) AS upcoming
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                WHERE b.hdv_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$hdv_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'total_tours' => $result['total_tours'] ?? 0,
            'upcoming' => $result['upcoming'] ?? 0
        ];
    }

    public function getTourScheduleFull($tour_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tours WHERE id = ?");
        $stmt->execute([$tour_id]);
        $tour = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tour) {
            $stmtDays = $this->pdo->prepare("SELECT * FROM tour_schedule_days WHERE tour_id = ? ORDER BY ngay_thu ASC");
            $stmtDays->execute([$tour_id]);
            $days = $stmtDays->fetchAll(PDO::FETCH_ASSOC);

            foreach ($days as &$day) {
                $stmtAct = $this->pdo->prepare("SELECT * FROM tour_schedule_activities WHERE day_id = ? ORDER BY thoi_gian_bat_dau ASC");
                $stmtAct->execute([$day['id']]);
                $day['activities'] = $stmtAct->fetchAll(PDO::FETCH_ASSOC);
            }

            $tour['schedule'] = $days;
        }

        return $tour;
    }
}

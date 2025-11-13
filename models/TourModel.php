<?php
class TourModel extends BaseModel {

    // Lấy tất cả tour
    public function getAllTours() {
    $stmt = $this->pdo->query("
        SELECT t.*, 
            (SELECT image_path FROM tour_images WHERE tour_id = t.id LIMIT 1) AS image_path
        FROM tours t
        ORDER BY t.id DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


    // Lấy 1 tour
    public function getTourById($id){
    // Lấy thông tin tour
    $stmt = $this->pdo->prepare("SELECT * FROM tours WHERE id=?");
    $stmt->execute([$id]);
    $tour = $stmt->fetch(PDO::FETCH_OBJ);

    if($tour){
        // Lấy tất cả hình ảnh của tour
        $stmt2 = $this->pdo->prepare("SELECT * FROM tour_images WHERE tour_id=?");
        $stmt2->execute([$id]);
        $tour->images = $stmt2->fetchAll(PDO::FETCH_OBJ);

        // Lấy lịch trình
        $stmt3 = $this->pdo->prepare("SELECT * FROM tour_schedule_days WHERE tour_id=? ORDER BY ngay_thu ASC");
        $stmt3->execute([$id]);
        $days = $stmt3->fetchAll(PDO::FETCH_OBJ);

        foreach($days as $day){
            $stmt4 = $this->pdo->prepare("SELECT * FROM tour_schedule_activities WHERE day_id=? ORDER BY thoi_gian_bat_dau ASC");
            $stmt4->execute([$day->id]);
            $day->activities = $stmt4->fetchAll(PDO::FETCH_OBJ);
        }

        $tour->schedule = $days;
    }

    return $tour;
}

// Lấy tất cả hình ảnh của tour
        public function getTourImages($tour_id){
            $stmt = $this->pdo->prepare("SELECT * FROM tour_images WHERE tour_id=?");
            $stmt->execute([$tour_id]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }


    // Lấy hình ảnh của tour
    public function getTourSchedule($tour_id){
    $stmt = $this->pdo->prepare("SELECT * FROM tour_schedule_days WHERE tour_id = :tour_id ORDER BY ngay_thu ASC");
    $stmt->execute(['tour_id' => $tour_id]);
    $days = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach($days as $day){
        $stmtAct = $this->pdo->prepare("SELECT * FROM tour_schedule_activities WHERE day_id = :day_id ORDER BY thoi_gian_bat_dau ASC");
        $stmtAct->execute(['day_id' => $day->id]);
        $day->activities = $stmtAct->fetchAll(PDO::FETCH_OBJ);
    }

    return $days;
}


    // Thêm tour
    public function insertTour($data){
        $stmt = $this->pdo->prepare("INSERT INTO tours (ten_tour, loai_tour, dia_diem, thoi_gian, gia_tour, mo_ta, ngay_khoi_hanh, phuong_tien, so_nguoi_toi_da) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['ten_tour'], $data['loai_tour'], $data['dia_diem'], $data['thoi_gian'],
            $data['gia_tour'], $data['mo_ta'], $data['ngay_khoi_hanh'], $data['phuong_tien'], $data['so_nguoi_toi_da']
        ]);
        return $this->pdo->lastInsertId();
    }

    // Cập nhật tour
    public function updateTour($id, $data){
        $stmt = $this->pdo->prepare("UPDATE tours SET ten_tour=?, loai_tour=?, dia_diem=?, thoi_gian=?, gia_tour=?, mo_ta=?, ngay_khoi_hanh=?, phuong_tien=?, so_nguoi_toi_da=? WHERE id=?");
        $stmt->execute([
            $data['ten_tour'], $data['loai_tour'], $data['dia_diem'], $data['thoi_gian'],
            $data['gia_tour'], $data['mo_ta'], $data['ngay_khoi_hanh'], $data['phuong_tien'], $data['so_nguoi_toi_da'],
            $id
        ]);
    }

    // Tour Images 
    public function insertTourImage($tour_id, $path){
        $stmt = $this->pdo->prepare("INSERT INTO tour_images (tour_id, image_path) VALUES (?, ?)");
        $stmt->execute([$tour_id, $path]);
    }

    public function updateTourImage($id, $path){
        $stmt = $this->pdo->prepare("UPDATE tour_images SET image_path=? WHERE id=?");
        $stmt->execute([$path, $id]);
    }

    public function deleteTourImage($id){
        $stmt = $this->pdo->prepare("DELETE FROM tour_images WHERE id=?");
        $stmt->execute([$id]);
    }

    // Schedule
    public function insertScheduleDay($tour_id, $tieu_de, $mo_ta) {
    // Lấy số ngày hiện có của tour
    $stmt = $this->pdo->prepare("SELECT COUNT(*) as count_day FROM tour_schedule_days WHERE tour_id=?");
    $stmt->execute([$tour_id]);
    $count = $stmt->fetch(PDO::FETCH_OBJ)->count_day;
    $ngay_thu = $count + 1; // ngày tiếp theo

    // Thêm ngày mới
    $stmt = $this->pdo->prepare("INSERT INTO tour_schedule_days (tour_id, tieu_de, mo_ta, ngay_thu) VALUES (?, ?, ?, ?)");
    $stmt->execute([$tour_id, $tieu_de, $mo_ta, $ngay_thu]);

    return $this->pdo->lastInsertId();
}


    public function updateScheduleDay($day_id, $day){
        $stmt = $this->pdo->prepare("UPDATE tour_schedule_days SET tieu_de=?, mo_ta=? WHERE id=?");
        $stmt->execute([$day['tieu_de'], $day['mo_ta'], $day_id]);
    }

    public function deleteScheduleDay($day_id){
        // Xóa luôn activities
        $stmt = $this->pdo->prepare("DELETE FROM tour_schedule_activities WHERE day_id=?");
        $stmt->execute([$day_id]);

        $stmt2 = $this->pdo->prepare("DELETE FROM tour_schedule_days WHERE id=?");
        $stmt2->execute([$day_id]);
    }

    public function insertScheduleActivity($day_id, $act){
        $stmt = $this->pdo->prepare("INSERT INTO tour_schedule_activities (day_id, thoi_gian_bat_dau, thoi_gian_ket_thuc, dia_diem, hoat_dong, hinh_anh)
                                     VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $day_id,
            $act['thoi_gian_bat_dau'] ?? null,
            $act['thoi_gian_ket_thuc'] ?? null,
            $act['dia_diem'] ?? null,
            $act['hoat_dong'] ?? null,
            $act['hinh_anh'] ?? null
        ]);
    }

    public function updateScheduleActivity($act_id, $act){
        $stmt = $this->pdo->prepare("UPDATE tour_schedule_activities SET thoi_gian_bat_dau=?, thoi_gian_ket_thuc=?, dia_diem=?, hoat_dong=?, hinh_anh=? WHERE id=?");
        $stmt->execute([
            $act['thoi_gian_bat_dau'] ?? null,
            $act['thoi_gian_ket_thuc'] ?? null,
            $act['dia_diem'] ?? null,
            $act['hoat_dong'] ?? null,
            $act['hinh_anh'] ?? null,
            $act_id
        ]);
    }

    public function deleteScheduleActivity($act_id){
        $stmt = $this->pdo->prepare("DELETE FROM tour_schedule_activities WHERE id=?");
        $stmt->execute([$act_id]);
    }
    // Xóa tất cả ảnh của tour
public function deleteTourImages($tour_id){
    $stmt = $this->pdo->prepare("DELETE FROM tour_images WHERE tour_id=?");
    $stmt->execute([$tour_id]);
}

// Xóa lịch trình của tour (cả activities)
public function deleteTourSchedule($tour_id){
    // Xóa activities
    $stmt1 = $this->pdo->prepare("DELETE ta FROM tour_schedule_activities ta
                                  INNER JOIN tour_schedule_days ts ON ta.day_id = ts.id
                                  WHERE ts.tour_id = ?");
    $stmt1->execute([$tour_id]);

    // Xóa các ngày
    $stmt2 = $this->pdo->prepare("DELETE FROM tour_schedule_days WHERE tour_id=?");
    $stmt2->execute([$tour_id]);
}

// Xóa tour
public function deleteTour($id){
    $this->deleteTourSchedule($id);
    $this->deleteTourImages($id);
    $stmt = $this->pdo->prepare("DELETE FROM tours WHERE id=?");
    $stmt->execute([$id]);
}

}
?>

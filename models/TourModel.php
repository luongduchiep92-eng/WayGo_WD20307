<?php
    class TourModel extends BaseModel{
        public function getAllTour(){
            $sql = "SELECT t.*, 
                   GROUP_CONCAT(DISTINCT hi.image_path SEPARATOR ',') AS images,
                   GROUP_CONCAT(DISTINCT hd.ho_ten SEPARATOR ', ') AS hdv_names
            FROM tours t
            LEFT JOIN tour_images hi ON t.id = hi.tour_id
            LEFT JOIN tour_hdv th ON t.id = th.tour_id
            LEFT JOIN huong_dan_viens hd ON th.hdv_id = hd.id
            GROUP BY t.id
            ORDER BY t.ngay_khoi_hanh DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
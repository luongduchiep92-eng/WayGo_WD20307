<?php
    class TourModel extends BaseModel{
        protected $table = "tours";
        public function getAllTours() {
            $sql = "SELECT *
                    FROM {$this->table}
                    ORDER BY ngay_khoi_hanh DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            return $stmt->fetchAll();
        }
        
    }
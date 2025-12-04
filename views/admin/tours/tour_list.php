<?php require_once "views/layouts/header.php"; ?>
<link rel="stylesheet" href="assets/css/tour/tour_list.css">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Danh sách Tour</h1>
    <a href="index.php?action=tour_add" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-plus fa-sm text-white-50"></i> Tạo Tour Mới
    </a>
</div>

<!-- GRID LIST TOUR -->
<div class="tour-grid">
    <?php foreach ($tours as $tour): ?>
        <div class="tour-card">

            <!-- Hình tour -->
            <div class="tour-img">
                <img src="<?= $tour->hinh_anh ?? 'public/default-tour.jpg' ?>" alt="Tour">
                <span class="tour-badge"><?= $tour->loai_tour ?></span>
            </div>

            <!-- Nội dung -->
            <div class="tour-content">
                <h3 class="tour-title"><?= $tour->ten_tour ?></h3>

                <div class="tour-time">
                    <i class="fa-solid fa-clock"></i> <?= $tour->thoi_gian ?>
                </div>

                <div class="tour-price">
                    <?= number_format($tour->gia_tour) ?> đ
                </div>

                <div class="tour-status">
                    <span class="badge bg-<?php
                                            if ($tour->status == 'Hủy') echo 'danger';
                                            elseif ($tour->status == 'Đang tạm dừng') echo 'warning text-dark';
                                            else echo 'success';
                                            ?>">
                        <?= $tour->status ?>
                    </span>
                </div>

                <!-- nút thao tác -->
                <div class="tour-actions mt-3">
                    <a href="index.php?action=tour_detail&id=<?= $tour->id ?>" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></a>
                    <a href="index.php?action=tour_edit&id=<?= $tour->id ?>" class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-pen"></i></a>
                    <a href="index.php?action=tour_delete&id=<?= $tour->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa tour này?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once "views/layouts/footer.php"; ?>
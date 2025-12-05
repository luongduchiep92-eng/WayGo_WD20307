<?php require_once "views/layouts/header.php"; ?>
<link rel="stylesheet" href="assets/css/tour/tour_list.css">

<div class="card card-modern mb-4">
    <div class="card-body py-3">
        <form action="index.php" method="GET" class="row g-3 align-items-center">
            <input type="hidden" name="action" value="tour_list">
            
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm tên tour..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                </div>
            </div>
            
            <div class="col-md-3">
                <select name="loai_tour" class="form-select">
                    <option value="">-- Tất cả loại tour --</option>
                    <?php 
                    $types = ['Trong nước', 'Quốc tế', 'Theo yêu cầu'];
                    foreach($types as $type): 
                    ?>
                        <option value="<?= $type ?>" <?= (isset($_GET['loai_tour']) && $_GET['loai_tour'] == $type) ? 'selected' : '' ?>>
                            <?= $type ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 fw-bold">Lọc</button>
            </div>
            
            <div class="col-md-3 text-end">
                <a href="index.php?action=tour_add" class="btn btn-success shadow-sm">
                    <i class="fa-solid fa-plus"></i> Tạo Tour Mới
                </a>
            </div>
        </form>
    </div>
</div>

<div class="tour-grid">
    <?php if(empty($tours)): ?>
        <div class="col-12 text-center text-muted py-5">
            <i class="fa-solid fa-box-open fa-3x mb-3"></i>
            <p>Không tìm thấy tour nào phù hợp.</p>
        </div>
    <?php else: ?>
        <?php foreach ($tours as $tour): ?>
            <div class="tour-card">
                <div class="tour-img">
                    <img src="<?= $tour->image_path ?? 'assets/img/no-image.jpg' ?>" alt="Tour">
                    <span class="tour-badge"><?= $tour->loai_tour ?></span>
                </div>
                <div class="tour-content">
                    <h3 class="tour-title"><?= $tour->ten_tour ?></h3>
                    <div class="tour-time"><i class="fa-solid fa-clock"></i> <?= $tour->thoi_gian ?></div>
                    <div class="tour-price"><?= number_format($tour->gia_tour) ?>đ / khách</div>
                    <div class="tour-status">
                         <span class="badge bg-<?= ($tour->status == 'Hủy') ? 'danger' : (($tour->status == 'Đang tạm dừng') ? 'warning text-dark' : 'success') ?>">
                            <?= $tour->status ?>
                        </span>
                    </div>
                    <div class="tour-actions mt-3">
                        <a href="index.php?action=tour_detail&id=<?= $tour->id ?>" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></a>
                        <a href="index.php?action=tour_edit&id=<?= $tour->id ?>" class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-pen"></i></a>
                        <a href="index.php?action=tour_delete&id=<?= $tour->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa tour này?')"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once "views/layouts/footer.php"; ?>
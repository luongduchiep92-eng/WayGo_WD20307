<?php require_once "views/layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Danh sách Tour</h1>
    <a href="index.php?action=tour_add" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-plus fa-sm text-white-50"></i> Tạo Tour Mới
    </a>
</div>
<div class="card card-modern mb-4" style="height: auto !important;">
    <div class="card-body py-3">
        <form action="" method="GET" class="row g-3 align-items-center">
            <input type="hidden" name="action" value="tour_list">
            
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="keyword" class="form-control border-start-0 bg-light" placeholder="Tìm kiếm tên tour..." value="<?= $_GET['keyword'] ?? '' ?>">
                </div>
            </div>
            
            <div class="col-md-3">
                <select name="loai_tour" class="form-select">
                    <option value="">-- Tất cả loại tour --</option>
                    <option value="Trong nước" <?= (isset($_GET['loai_tour']) && $_GET['loai_tour'] == 'Trong nước') ? 'selected' : '' ?>>Trong nước</option>
                    <option value="Quốc tế" <?= (isset($_GET['loai_tour']) && $_GET['loai_tour'] == 'Quốc tế') ? 'selected' : '' ?>>Quốc tế</option>
                    <option value="Theo yêu cầu" <?= (isset($_GET['loai_tour']) && $_GET['loai_tour'] == 'Theo yêu cầu') ? 'selected' : '' ?>>Theo yêu cầu</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter"></i> Lọc</button>
            </div>
            
            <div class="col-md-2">
                <a href="index.php?action=tour_list" class="btn btn-outline-secondary w-100">Đặt lại</a>
            </div>
        </form>
    </div>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
       <div class="table-responsive">
            <table class="table table-modern table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="30%">Tên Tour</th>
                        <th width="15%">Giá Tour</th>
                        <th width="15%">Loại Tour</th>
                        <th width="15%">Trạng thái</th>
                        <th width="20%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($tours)): ?>
                        <?php foreach ($tours as $tour): ?>
                        <tr>
                            <td>#<?= $tour->id ?></td>
                            <td>
                                <div class="fw-bold text-primary"><?= $tour->ten_tour ?></div>
                                <small class="text-muted"><i class="fa-solid fa-clock"></i> <?= $tour->thoi_gian ?></small>
                            </td>
                            <td class="fw-bold text-success"><?= number_format($tour->gia_tour) ?> đ</td>
                            <td>
                                <?php if($tour->loai_tour == 'Trong nước'): ?>
                                    <span class="badge bg-info text-dark">Trong nước</span>
                                <?php elseif($tour->loai_tour == 'Quốc tế'): ?>
                                    <span class="badge bg-primary">Quốc tế</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Theo yêu cầu</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                    $statusClass = 'success';
                                    if($tour->status == 'Đang tạm dừng') $statusClass = 'warning text-dark';
                                    elseif($tour->status == 'Hủy') $statusClass = 'danger';
                                ?>
                                <span class="badge bg-<?= $statusClass ?>"><?= $tour->status ?></span>
                            </td>
                            <td>
                                <a href="index.php?action=tour_detail&id=<?= $tour->id ?>" class="btn btn-sm btn-outline-info" title="Chi tiết"><i class="fa-solid fa-eye"></i></a>
                                <a href="index.php?action=tour_edit&id=<?= $tour->id ?>" class="btn btn-sm btn-outline-warning" title="Sửa"><i class="fa-solid fa-pen"></i></a>
                                <a href="index.php?action=tour_delete&id=<?= $tour->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa tour này?')" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Không tìm thấy tour nào phù hợp.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>
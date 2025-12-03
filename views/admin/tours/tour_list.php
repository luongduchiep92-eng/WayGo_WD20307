<?php require_once "views/layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Danh sách Tour</h1>
    <a href="index.php?action=tour_add" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-plus fa-sm text-white-50"></i> Tạo Tour Mới
    </a>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="30%">Tên Tour</th>
                        <th width="15%">Giá Tour / 1 người</th>
                        <th width="15%">Loại Tour</th>
                        <th width="15%">Trạng thái</th>
                        <th width="20%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>
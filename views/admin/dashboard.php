<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Tổng quan hệ thống</h1>
    
    <form class="d-flex shadow-sm bg-white rounded overflow-hidden" method="GET" action="index.php">
        <input type="hidden" name="controller" value="admin">
        <input type="hidden" name="action" value="dashboard">
        <select name="tour_type" class="form-select border-0" style="width: 200px;" onchange="this.form.submit()">
            <option value="">-- Tất cả loại tour --</option>
            <option value="Trong nước" <?= ($_GET['tour_type'] ?? '') == 'Trong nước' ? 'selected' : '' ?>>Trong nước</option>
            <option value="Quốc tế" <?= ($_GET['tour_type'] ?? '') == 'Quốc tế' ? 'selected' : '' ?>>Quốc tế</option>
            <option value="Theo yêu cầu" <?= ($_GET['tour_type'] ?? '') == 'Theo yêu cầu' ? 'selected' : '' ?>>Theo yêu cầu</option>
        </select>
        <button class="btn btn-primary rounded-0 px-4"><i class="fa-solid fa-filter"></i> Lọc</button>
    </form>
</div>

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">
        <div class="card card-modern card-border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                            Tổng số Tour</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?= $stats['total'] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-earth-americas fa-2x text-gray-300" style="color: #cbd3da;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-modern card-border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">
                            Đang hoạt động</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?= $stats['active'] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-check-circle fa-2x" style="color: #cbd3da;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-modern card-border-left-warning h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                            Đang tạm dừng</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?= $stats['paused'] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-pause-circle fa-2x" style="color: #cbd3da;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-modern card-border-left-info h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">
                            Tổng doanh thu (Dự kiến)</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?= number_format($totalRevenue) ?> đ</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-dollar-sign fa-2x" style="color: #cbd3da;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-modern mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
                <h6 class="m-0 fw-bold text-primary">Các Tour mới nhất</h6>
                <a href="index.php?action=tour_list" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Tên Tour</th>
                                <th>Loại</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Hiển thị tối đa 5 tour đầu tiên
                            $count = 0;
                            foreach($tours as $t): 
                                if($count >= 5) break; 
                                $t = (array)$t;
                            ?>
                            <tr>
                                <td class="fw-bold"><?= $t['ten_tour'] ?></td>
                                <td><span class="badge bg-light text-dark border"><?= $t['loai_tour'] ?></span></td>
                                <td class="text-success fw-bold"><?= number_format($t['gia_tour']) ?> đ</td>
                                <td>
                                    <?php if($t['status'] == 'Hoạt động'): ?>
                                        <span class="badge bg-success">Hoạt động</span>
                                    <?php elseif($t['status'] == 'Đang tạm dừng'): ?>
                                        <span class="badge bg-warning text-dark">Tạm dừng</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Hủy</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php $count++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>
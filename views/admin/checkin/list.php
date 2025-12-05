<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0"><i class="fa-solid fa-clipboard-user me-2"></i>Điểm Danh Khách Hàng</h2>
            <p class="text-muted mb-0">Chọn tour đang khởi hành để thực hiện check-in</p>
        </div>
    </div>

    <div class="card card-modern border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary text-uppercase small">
                        <tr>
                            <th class="ps-4">Tour</th>
                            <th>Ngày khởi hành</th>
                            <th>HDV Phụ trách</th>
                            <th class="text-center">Số khách</th>
                            <th class="text-end pe-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($bookings)): ?>
                            <?php foreach($bookings as $b): 
                                $ngay = $b['ngay_khoi_hanh'] ? date('d/m/Y', strtotime($b['ngay_khoi_hanh'])) : '<span class="text-danger">Chưa chốt</span>';
                                $img = $b['tour_image'] ?? 'assets/img/no-image.jpg';
                            ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $img ?>" class="rounded shadow-sm me-3" width="50" height="50" style="object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark text-truncate" style="max-width: 300px;"><?= $b['ten_tour'] ?></div>
                                            <small class="text-muted">Booking #<?= $b['id'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary"><?= $ngay ?></div>
                                </td>
                                <td>
                                    <?php if($b['hdv_name']): ?>
                                        <span class="badge bg-light text-dark border"><i class="fa-solid fa-user-tie me-1"></i> <?= $b['hdv_name'] ?></span>
                                    <?php else: ?>
                                        <span class="text-muted small fst-italic">-- Chưa có --</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center fw-bold fs-5 text-secondary"><?= $b['so_luong'] ?></td>
                                <td class="text-end pe-4">
                                    <a href="index.php?action=checkin_perform&id=<?= $b['id'] ?>" class="btn btn-warning fw-bold shadow-sm rounded-pill px-3">
                                        <i class="fa-solid fa-check-to-slot me-1"></i> Check-in
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted"><i class="fa-regular fa-folder-open fa-2x mb-3"></i><p>Không có tour nào sắp khởi hành.</p></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>
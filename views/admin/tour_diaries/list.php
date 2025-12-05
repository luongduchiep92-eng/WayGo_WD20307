<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0"><i class="fa-solid fa-book-journal-whills me-2"></i> Danh Sách Nhật Ký</h2>
            <p class="text-muted mb-0">Các tour đã có ghi chép nhật ký hành trình</p>
        </div>
        <a href="index.php?action=diary_manage" class="btn btn-success shadow-sm fw-bold rounded-pill px-4">
            <i class="fa-solid fa-plus me-1"></i> Viết cho Tour mới
        </a>
    </div>

    <div class="card card-modern border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary text-uppercase small">
                    <tr>
                        <th class="ps-4">Tour</th>
                        <th>Thời gian</th>
                        <th class="text-center">Số bài viết</th>
                        <th>Cập nhật cuối</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($bookings)): ?>
                        <?php foreach($bookings as $b): 
                            $img = $b['tour_image'] ?? 'assets/img/no-image.jpg';
                            $date = date('d/m/Y', strtotime($b['ngay_khoi_hanh']));
                        ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <img src="<?= $img ?>" class="rounded shadow-sm me-3" width="60" height="60" style="object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 300px;"><?= $b['ten_tour'] ?></div>
                                        <div class="small text-muted"><i class="fa-solid fa-user me-1"></i> Khách: <?= $b['customer_name'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-primary"><?= $date ?></div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill px-3">
                                    <?= $b['total_entries'] ?> mục
                                </span>
                            </td>
                            <td class="small text-muted">
                                <?= date('H:i d/m/Y', strtotime($b['last_update'])) ?>
                            </td>
                            <td class="text-end pe-4">
                                <a href="index.php?action=diary_manage&booking_id=<?= $b['id'] ?>" class="btn btn-sm btn-outline-primary border-0 me-2" title="Xem chi tiết & Viết thêm">
                                    <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                </a>
                                <a href="index.php?action=diary_delete_all&booking_id=<?= $b['id'] ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('CẢNH BÁO: Bạn có chắc muốn xóa TOÀN BỘ nhật ký của tour này không?')" title="Xóa tour khỏi danh sách">
                                    <i class="fa-solid fa-trash-can fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-5 text-muted"><i class="fa-regular fa-folder-open fa-2x mb-3"></i><p>Chưa có nhật ký nào được viết.</p></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>
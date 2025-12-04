<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4">
    <h3 class="fw-bold text-primary mb-4"><i class="fa-solid fa-clipboard-user"></i> Chọn Tour để Check-in</h3>

    <div class="card card-modern">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã Tour</th>
                        <th>Tên Tour</th>
                        <th>Ngày Khởi Hành</th>
                        <th>HDV</th>
                        <th class="text-center">Số khách</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($bookings)): ?>
                        <?php foreach($bookings as $b): ?>
                        <tr>
                            <td><strong>#<?= $b['id'] ?></strong></td>
                            <td class="fw-bold text-primary"><?= $b['ten_tour'] ?></td>
                            <td>
                                <?php 
                                    $date = strtotime($b['ngay_khoi_hanh']);
                                    $today = strtotime(date('Y-m-d'));
                                    if($date == $today) echo '<span class="badge bg-success">Hôm nay</span>';
                                    else echo date('d/m/Y', $date);
                                ?>
                            </td>
                            <td><?= $b['hdv_name'] ?: '<span class="text-muted">--</span>' ?></td>
                            <td class="text-center fw-bold"><?= $b['so_luong'] ?></td>
                            <td>
                                <a href="index.php?action=checkin_perform&id=<?= $b['id'] ?>" class="btn btn-warning btn-sm fw-bold shadow-sm">
                                    <i class="fa-solid fa-check-to-slot"></i> Vào Check-in
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4">Không có tour nào sắp khởi hành.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>
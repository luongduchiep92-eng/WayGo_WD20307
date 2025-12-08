<?php include PATH_VIEW . 'layouts/header_hdv.php'; ?>

<div class="container mt-4 mb-5">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold text-primary mb-1">Lịch làm việc của tôi</h4>
            <div class="text-muted small">
                Chỉ hiển thị tour <b>đang diễn ra</b> và <b>sắp tới</b>.
            </div>
        </div>
    </div>

    <?php if (empty($tours)): ?>
        <div class="alert alert-info shadow-sm border-0">
            Hiện chưa có tour nào trong lịch làm việc.
        </div>
    <?php else: ?>
        <div class="d-grid gap-3">

            <?php foreach ($tours as $tour): ?>
                <?php
                $date = !empty($tour['bk_ngay_khoi_hanh']) ? $tour['bk_ngay_khoi_hanh'] : ($tour['ngay_khoi_hanh'] ?? null);
                $formattedDate = $date ? date('d/m/Y', strtotime($date)) : "Chưa rõ";

                $status = $tour['timeline_status'] ?? '';

                // Badge trạng thái
                $badgeClass = 'bg-secondary';
                $icon = 'fa-circle-info';
                if ($status === 'Đang tiến hành') {
                    $badgeClass = 'bg-primary';
                    $icon = 'fa-person-walking-luggage';
                } elseif ($status === 'Sắp tới') {
                    $badgeClass = 'bg-warning text-dark';
                    $icon = 'fa-clock';
                } elseif ($status === 'Đã hoàn thành') {
                    $badgeClass = 'bg-success';
                    $icon = 'fa-circle-check';
                }

                // Link
                $detailUrl  = "index.php?action=hdv_tour_detail&tour_id={$tour['tour_id']}&booking_id={$tour['booking_id']}";
                $checkinUrl = "index.php?action=checkin_perform&id={$tour['booking_id']}";

                // Info phụ (nếu có)
                $vehicle = htmlspecialchars($tour['phuong_tien'] ?? '---');
                $qty = isset($tour['so_luong']) ? (int)$tour['so_luong'] : null;
                ?>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <div class="d-flex align-items-start justify-content-between gap-3">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <h5 class="fw-bold mb-0">
                                        <?= htmlspecialchars($tour['ten_tour']) ?>
                                    </h5>
                                </div>

                                <div class="text-muted">
                                    <span class="me-3">
                                        <i class="fa-regular fa-calendar me-1"></i><?= $formattedDate ?>
                                    </span>
                                    <span class="me-3">
                                        <i class="fa-solid fa-bus me-1"></i><?= $vehicle ?>
                                    </span>
                                    <?php if ($qty !== null): ?>
                                        <span class="me-3">
                                            <i class="fa-solid fa-users me-1"></i><?= $qty ?> khách
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if ($status): ?>
                                <span class="badge <?= $badgeClass ?> px-3 py-2 rounded-pill">
                                    <i class="fa-solid <?= $icon ?> me-1"></i><?= $status ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <hr class="my-3">

                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <a href="<?= $detailUrl ?>" class="btn btn-outline-secondary btn-sm px-3">
                                <i class="fa-solid fa-circle-info me-1"></i> Xem chi tiết
                            </a>

                            <?php if ($status === 'Đang tiến hành'): ?>
                                <a href="<?= $checkinUrl ?>" class="btn btn-success btn-sm px-3">
                                    <i class="fa-solid fa-clipboard-check me-1"></i> Check-in
                                </a>
                            <?php else: ?>
                                <button class="btn btn-success btn-sm px-3" disabled
                                    title="Chỉ check-in khi tour đang diễn ra">
                                    <i class="fa-solid fa-clipboard-check me-1"></i> Check-in
                                </button>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    <?php endif; ?>

</div>

<?php include PATH_VIEW . 'layouts/footer_hdv.php'; ?>
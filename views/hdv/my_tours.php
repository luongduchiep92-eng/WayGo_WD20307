<?php include PATH_VIEW . 'layouts/header_hdv.php'; ?>

<style>
    /* (tuỳ chọn) hover mượt hơn - bỏ cũng không sao */
    .tour-card:hover {
        transform: translateY(-2px);
    }

    .tour-card {
        transition: .15s ease;
    }
</style>

<div class="container py-4">

    <?php
    $countAll = is_array($tours) ? count($tours) : 0;
    $countDoing = 0;
    $countDone = 0;
    foreach (($tours ?? []) as $t) {
        $st = $t['timeline_status'] ?? 'Đang tiến hành';
        if ($st === 'Đang tiến hành') $countDoing++;
        if ($st === 'Đã hoàn thành') $countDone++;
    }
    ?>

    <!-- Header / Toolbar -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div>
                    <h4 class="fw-bold text-primary mb-1">Các Tour đã và đang đi</h4>
                    <div class="text-muted">Tìm nhanh theo tên tour / phương tiện / ngày và lọc theo trạng thái.</div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill text-bg-dark px-3 py-2">
                        <i class="fa-solid fa-layer-group me-1"></i> Tổng: <?= (int)$countAll ?>
                    </span>
                    <span class="badge rounded-pill text-bg-primary px-3 py-2">
                        <i class="fa-solid fa-spinner me-1"></i> Đang tiến hành: <?= (int)$countDoing ?>
                    </span>
                    <span class="badge rounded-pill text-bg-success px-3 py-2">
                        <i class="fa-solid fa-circle-check me-1"></i> Hoàn thành: <?= (int)$countDone ?>
                    </span>
                </div>
            </div>

            <hr class="my-3">

            <div class="row g-2">
                <div class="col-12 col-md-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input id="searchInput" type="text" class="form-control"
                            placeholder="Tìm theo tên tour / phương tiện / ngày (dd/mm/yyyy)...">
                        <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">Xoá</button>
                    </div>
                </div>

                <div class="col-12 col-md-5">
                    <select id="statusFilter" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="Đang tiến hành">Đang tiến hành</option>
                        <option value="Đã hoàn thành">Đã hoàn thành</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($tours)): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="display-6 mb-2">😴</div>
                <div class="fw-bold">Chưa có tour nào</div>
                <div class="text-muted">Khi có tour được phân công, bạn sẽ thấy danh sách hiển thị tại đây.</div>
            </div>
        </div>
    <?php else: ?>

        <div class="row g-3" id="tourGrid">
            <?php foreach ($tours as $t): ?>
                <?php
                $date = !empty($t['bk_ngay_khoi_hanh']) ? $t['bk_ngay_khoi_hanh'] : ($t['ngay_khoi_hanh'] ?? null);
                $formattedDate = $date ? date('d/m/Y', strtotime($date)) : "Chưa có ngày";

                $status = $t['timeline_status'] ?? 'Đang tiến hành';

                // Badge Bootstrap thuần
                $badgeClass = 'text-bg-secondary';
                if ($status === 'Đang tiến hành') $badgeClass = 'text-bg-primary';
                if ($status === 'Đã hoàn thành')  $badgeClass = 'text-bg-success';

                $tenTour = htmlspecialchars($t['ten_tour'] ?? '');
                $phuongTien = htmlspecialchars($t['phuong_tien'] ?? '---');

                $tourId = (int)($t['tour_id'] ?? 0);
                $bookingId = (int)($t['booking_id'] ?? 0);
                ?>
                <div class="col-12 col-lg-6 tour-item"
                    data-name="<?= htmlspecialchars(mb_strtolower($t['ten_tour'] ?? '')) ?>"
                    data-vehicle="<?= htmlspecialchars(mb_strtolower($t['phuong_tien'] ?? '')) ?>"
                    data-date="<?= htmlspecialchars(mb_strtolower($formattedDate)) ?>"
                    data-status="<?= htmlspecialchars($status) ?>">

                    <a class="text-decoration-none text-reset"
                        href="index.php?action=hdv_tour_detail&tour_id=<?= $tourId ?>&booking_id=<?= $bookingId ?>">

                        <div class="card border-0 shadow-sm tour-card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between gap-3">
                                    <div class="d-flex gap-3">
                                        <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                            style="width:44px;height:44px;">
                                            <i class="fa-solid fa-map-location-dot"></i>
                                        </div>

                                        <div>
                                            <div class="fw-bold mb-1"><?= $tenTour ?></div>
                                            <div class="text-muted small">
                                                <i class="fa-regular fa-calendar me-1"></i><?= $formattedDate ?>
                                                <span class="mx-2">|</span>
                                                <i class="fa-solid fa-bus me-1"></i><?= $phuongTien ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <span class="badge rounded-pill <?= $badgeClass ?> px-3 py-2">
                                            <?= htmlspecialchars($status) ?>
                                        </span>
                                        <div class="text-muted small mt-2">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-3">

                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge rounded-pill text-bg-light border text-secondary px-3 py-2">
                                        <i class="fa-solid fa-ticket me-1"></i> Booking #<?= $bookingId ?>
                                    </span>
                                    <span class="badge rounded-pill text-bg-light border text-secondary px-3 py-2">
                                        <i class="fa-solid fa-hashtag me-1"></i> Tour #<?= $tourId ?>
                                    </span>

                                    <?php if ($status === 'Đang tiến hành'): ?>
                                        <span class="badge rounded-pill text-bg-primary-subtle border border-primary-subtle text-primary px-3 py-2">
                                            <i class="fa-solid fa-person-walking me-1"></i> Đang chạy
                                        </span>
                                    <?php elseif ($status === 'Đã hoàn thành'): ?>
                                        <span class="badge rounded-pill text-bg-success-subtle border border-success-subtle text-success px-3 py-2">
                                            <i class="fa-solid fa-flag-checkered me-1"></i> Kết thúc
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<script>
    function clearSearch() {
        const s = document.getElementById('searchInput');
        s.value = '';
        applyFilters();
        s.focus();
    }

    function applyFilters() {
        const q = (document.getElementById('searchInput').value || '').trim().toLowerCase();
        const st = document.getElementById('statusFilter').value || '';

        document.querySelectorAll('.tour-item').forEach(item => {
            const name = item.dataset.name || '';
            const vehicle = item.dataset.vehicle || '';
            const date = item.dataset.date || '';
            const status = item.dataset.status || '';

            const matchQ = !q || name.includes(q) || vehicle.includes(q) || date.includes(q);
            const matchSt = !st || status === st;

            item.style.display = (matchQ && matchSt) ? '' : 'none';
        });
    }

    document.getElementById('searchInput').addEventListener('input', applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
</script>

<?php include PATH_VIEW . 'layouts/footer_hdv.php'; ?>
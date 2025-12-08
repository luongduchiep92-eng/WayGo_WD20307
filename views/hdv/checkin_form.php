<?php
include PATH_VIEW . 'layouts/header_hdv.php';

$active_session_id = $_GET['session_id'] ?? null;

// Nếu có phiên thì mặc định chọn phiên mới nhất
if (!empty($sessions) && !$active_session_id) {
    $active_session_id = $sessions[0]['id'];
}

// Tính thêm số "chưa check"
$stats_total   = $stats['total']   ?? 0;
$stats_present = $stats['present'] ?? 0;
$stats_absent  = $stats['absent']  ?? 0;
$stats_late    = $stats['late']    ?? 0;
$stats_pending = max($stats_total - $stats_present - $stats_absent - $stats_late, 0);
?>

<style>
    .page-shell {
        background: #f5f7fb;
        min-height: 100vh;
    }

    .card {
        border-radius: 16px;
    }

    .soft-shadow {
        box-shadow: 0 10px 30px rgba(16, 24, 40, .08);
    }

    .stat-card {
        border: 1px solid rgba(15, 23, 42, .06);
    }

    .table thead th {
        font-weight: 600;
    }

    .table-hover tbody tr:hover {
        background: rgba(13, 110, 253, .05);
    }

    .sticky-thead thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background: #f8f9fa !important;
    }

    .customer-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(0, 123, 255, .15);
        color: #0d6efd;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        border: 1px solid rgba(0, 123, 255, .2);
    }

    .btn-soft {
        background: rgba(13, 110, 253, .12);
        border: 1px solid rgba(13, 110, 253, .2);
        color: #0d6efd;
    }

    .btn-soft:hover {
        background: rgba(13, 110, 253, .18);
    }

    .status-select {
        min-width: 170px;
    }
</style>

<div class="page-shell py-4">
    <div class="container-fluid">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-primary mb-1">
                    Check-in: <?= htmlspecialchars($booking['ten_tour'] ?? '') ?>
                </h3>
                <p class="text-muted mb-0">
                    <i class="fa-regular fa-calendar me-1"></i>
                    <?= !empty($booking['ngay_khoi_hanh']) ? date('d/m/Y', strtotime($booking['ngay_khoi_hanh'])) : 'Chưa xác định' ?>
                    <span class="mx-2">|</span>
                    Booking ID: #<?= $booking['id'] ?>
                </p>
            </div>
            <a href="index.php?action=dashboard" class="btn btn-secondary shadow-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <div class="row">

            <!-- Cột trái: phiên điểm danh -->
            <div class="col-lg-3 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">
                            <i class="fa-solid fa-clock-rotate-left me-1"></i> Lịch sử điểm danh
                        </h6>
                    </div>

                    <div class="list-group list-group-flush">
                        <?php if (!empty($sessions)): ?>
                            <?php foreach ($sessions as $s): ?>
                                <a href="index.php?action=checkin_perform&id=<?= $booking['id'] ?>&session_id=<?= $s['id'] ?>"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= $s['id'] == $active_session_id ? 'active' : '' ?>">
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars($s['title']) ?></div>
                                        <small class="text-muted">
                                            <?= date('H:i d/m/Y', strtotime($s['created_at'])) ?>
                                        </small>
                                    </div>
                                    <?php if ($s['id'] == $active_session_id): ?>
                                        <i class="fa-solid fa-chevron-right small"></i>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="list-group-item text-muted small">
                                Chưa có phiên điểm danh nào.
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Form thêm phiên -->
                    <div class="card-footer text-center bg-white border-0">
                        <div id="newSessionBtn">
                            <button class="btn btn-outline-primary btn-sm"
                                onclick="
                                document.getElementById('newSessionBtn').style.display='none';
                                document.getElementById('newSessionFormContainer').style.display='block';
                                document.getElementById('newSessionTitle').focus();
                            ">
                                <i class="fa-solid fa-plus me-1"></i> Thêm mới
                            </button>
                        </div>

                        <div id="newSessionFormContainer" style="display:none;">
                            <form method="POST" action="index.php?action=checkin_create_session"
                                class="mt-2 d-flex justify-content-center align-items-center">
                                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">

                                <input id="newSessionTitle" type="text" name="title"
                                    class="form-control form-control-sm me-2" style="width: 220px;"
                                    placeholder="Nhập địa điểm check-in" required>

                                <button class="btn btn-primary btn-sm" type="submit">Tạo</button>
                                <button type="button" class="btn btn-light btn-sm ms-2"
                                    onclick="
                                    document.getElementById('newSessionFormContainer').style.display='none';
                                    document.getElementById('newSessionBtn').style.display='block';
                                ">
                                    Huỷ
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Cột phải -->
            <div class="col-lg-9">

                <!-- Toolbar -->
                <div class="card border-0 soft-shadow mb-3">
                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-4 p-2 bg-primary-subtle text-primary">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <strong>Quản lý điểm danh khách hàng</strong>
                                <div class="small text-muted">Chọn trạng thái từng khách hoặc thao tác nhanh</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="index.php?action=checkin_all&id=<?= $booking['id'] ?>&session_id=<?= $active_session_id ?>"
                                onclick="return confirm('Đánh dấu toàn bộ khách đều có mặt?');"
                                class="btn btn-success">
                                <i class="fa-solid fa-check-double me-1"></i> Tất cả có mặt
                            </a>

                            <button class="btn btn-soft" onclick="expandAllActions()">
                                <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Mở thao tác nhanh
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md">
                        <div class="card stat-card soft-shadow text-center py-3">
                            <div class="small text-muted">Tổng</div>
                            <div class="fw-bold fs-4"><?= $stats_total ?></div>
                        </div>
                    </div>
                    <div class="col-6 col-md">
                        <div class="card stat-card soft-shadow text-center py-3">
                            <div class="small text-muted">Có mặt</div>
                            <div class="fw-bold fs-4 text-success"><?= $stats_present ?></div>
                        </div>
                    </div>
                    <div class="col-6 col-md">
                        <div class="card stat-card soft-shadow text-center py-3">
                            <div class="small text-muted">Đi muộn</div>
                            <div class="fw-bold fs-4 text-warning"><?= $stats_late ?></div>
                        </div>
                    </div>
                    <div class="col-6 col-md">
                        <div class="card stat-card soft-shadow text-center py-3">
                            <div class="small text-muted">Vắng mặt</div>
                            <div class="fw-bold fs-4 text-danger"><?= $stats_absent ?></div>
                        </div>
                    </div>
                    <div class="col-12 col-md">
                        <div class="card stat-card soft-shadow text-center py-3">
                            <div class="small text-muted">Chưa check</div>
                            <div class="fw-bold fs-4 text-secondary"><?= $stats_pending ?></div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card border-0 soft-shadow">
                    <div class="card-header bg-white border-0 pt-4 pb-3">
                        <div class="d-flex flex-column flex-lg-row justify-content-between gap-2">
                            <div>
                                <h6 class="fw-bold mb-0">Danh sách khách hàng</h6>
                                <div class="small text-muted">Tìm theo tên / SĐT hoặc lọc theo trạng thái</div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa-solid fa-search"></i></span>
                                    <input type="text" id="searchInput" class="form-control" placeholder="Tìm khách...">
                                </div>

                                <select id="filterStatus" class="form-select" style="width: 200px;">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="Có mặt">Có mặt</option>
                                    <option value="Vắng mặt">Vắng mặt</option>
                                    <option value="Đến muộn">Đến muộn</option>
                                    <option value="Chưa checkin">Chưa checkin</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 sticky-thead">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width:70px;">STT</th>
                                        <th>Khách hàng</th>
                                        <th style="width:150px;">Số ĐT</th>
                                        <th class="text-center" style="width:260px;">Trạng thái</th>
                                    </tr>
                                </thead>

                                <tbody id="customerTbody">

                                    <?php if (empty($customers)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                Chưa có khách trong đoàn.
                                            </td>
                                        </tr>
                                    <?php else: ?>

                                        <?php $i = 1;
                                        foreach ($customers as $c): ?>
                                            <?php
                                            $tenKhach = $c['ten_khach'] ?? $c['ho_ten'] ?? '';
                                            $soDt = $c['so_dt'] ?? '';
                                            $status = $c['status'] ?? 'Chưa checkin';

                                            $detailId = $c['id'] ?? 0;

                                            $statusText = 'Chưa checkin';
                                            $class = 'secondary';

                                            if ($status == 'Có mặt') {
                                                $statusText = 'Có mặt';
                                                $class = 'success';
                                            } elseif ($status == 'Vắng mặt') {
                                                $statusText = 'Vắng mặt';
                                                $class = 'danger';
                                            } elseif ($status == 'Đến muộn') {
                                                $statusText = 'Đến muộn';
                                                $class = 'warning text-dark';
                                            }

                                            $initial = mb_strtoupper(mb_substr(trim($tenKhach ?: '?'), 0, 1));
                                            ?>

                                            <tr class="customer-row"
                                                data-name="<?= strtolower($tenKhach) ?>"
                                                data-phone="<?= $soDt ?>"
                                                data-status="<?= $statusText ?>">

                                                <td class="text-center text-muted"><?= $i++ ?></td>

                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="customer-avatar"><?= $initial ?></div>
                                                        <div>
                                                            <div class="fw-semibold"><?= htmlspecialchars($tenKhach) ?></div>
                                                            <div class="small text-muted">ID #<?= $detailId ?></div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="fw-semibold"><?= htmlspecialchars($soDt) ?></td>

                                                <td class="text-center">
                                                    <div class="d-flex flex-column align-items-center gap-2">

                                                        <span id="badge-<?= $detailId ?>"
                                                            class="badge rounded-pill px-3 py-2 bg-<?= $class ?>">
                                                            <?= $statusText ?>
                                                        </span>

                                                        <div class="actions-collapse d-flex gap-2" style="display:none;">
                                                            <select class="form-select form-select-sm status-select"
                                                                id="select-<?= $detailId ?>">
                                                                <option <?= $statusText == 'Có mặt' ? 'selected' : '' ?>>Có mặt</option>
                                                                <option <?= $statusText == 'Vắng mặt' ? 'selected' : '' ?>>Vắng mặt</option>
                                                                <option <?= $statusText == 'Đến muộn' ? 'selected' : '' ?>>Đến muộn</option>
                                                                <option <?= $statusText == 'Chưa checkin' ? 'selected' : '' ?>>Chưa checkin</option>
                                                            </select>

                                                            <button class="btn btn-primary btn-sm"
                                                                onclick="saveStatus(<?= $detailId ?>)">
                                                                <i class="fa-solid fa-floppy-disk me-1"></i> Lưu
                                                            </button>
                                                        </div>

                                                        <small id="msg-<?= $detailId ?>" style="display:none;"
                                                            class="text-success">Đã lưu ✓</small>
                                                    </div>
                                                </td>

                                            </tr>

                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 small py-3">
                        <span><i class="fa-solid fa-square text-success me-1"></i>Có mặt</span>
                        <span class="ms-3"><i class="fa-solid fa-square text-danger me-1"></i>Vắng mặt</span>
                        <span class="ms-3"><i class="fa-solid fa-square text-warning me-1"></i>Đến muộn</span>
                        <span class="ms-3"><i class="fa-solid fa-square text-secondary me-1"></i>Chưa điểm danh</span>
                    </div>
                </div>

            </div> <!-- END COL RIGHT -->
        </div>

    </div>
</div>

<!-- Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:9999;">
    <div id="saveToast" class="toast text-bg-success border-0" data-bs-delay="1200">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fa-solid fa-circle-check me-1"></i> Đã lưu trạng thái!
            </div>
            <button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script>
    function expandAllActions() {
        document.querySelectorAll('.actions-collapse').forEach(el => {
            el.style.display = el.style.display === 'flex' ? 'none' : 'flex';
        });
    }

    function applyFilters() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        const st = document.getElementById('filterStatus').value;

        document.querySelectorAll('.customer-row').forEach(row => {
            const n = row.dataset.name;
            const p = row.dataset.phone;
            const s = row.dataset.status;

            let ok1 = !q || n.includes(q) || p.includes(q);
            let ok2 = !st || s === st;

            row.style.display = (ok1 && ok2) ? '' : 'none';
        });
    }

    document.getElementById('searchInput').addEventListener('input', applyFilters);
    document.getElementById('filterStatus').addEventListener('change', applyFilters);

    function badgeClassByStatus(s) {
        if (s === 'Có mặt') return 'bg-success';
        if (s === 'Vắng mặt') return 'bg-danger';
        if (s === 'Đến muộn') return 'bg-warning text-dark';
        return 'bg-secondary';
    }

    async function saveStatus(id) {
        const select = document.getElementById('select-' + id);
        const badge = document.getElementById('badge-' + id);
        const msg = document.getElementById('msg-' + id);

        const status = select.value;
        select.disabled = true;

        const res = await fetch("index.php?action=checkin_ajax_update", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams({
                id,
                status
            })
        });

        const data = await res.json();

        if (data.success) {
            badge.textContent = status;
            badge.className = "badge rounded-pill px-3 py-2 " + badgeClassByStatus(status);

            badge.closest("tr").dataset.status = status;

            msg.style.display = 'inline';
            setTimeout(() => msg.style.display = 'none', 900);

            bootstrap.Toast.getOrCreateInstance(document.getElementById('saveToast')).show();

            applyFilters();
        } else {
            alert("Lỗi cập nhật.");
        }

        select.disabled = false;
    }
</script>

<?php include PATH_VIEW . 'layouts/footer_hdv.php'; ?>
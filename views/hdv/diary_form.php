<?php include PATH_VIEW . 'layouts/header_hdv.php';
// Lấy dữ liệu truyền vào (thông tin tour và nhật ký)
$maxDays = $data['max_days'] ?? 1;
$bookingInfo = $data;
$diaryList = $data['diaries'] ?? [];
// Chuyển nhật ký hiện có thành mảng với key là ngày
$existingDiaries = [];
foreach ($diaryList as $d) {
    $existingDiaries[$d['ngay_thu']] = $d;
}
?>

<div class="container mt-4">
    <div class="mb-4">
        <h4 class="fw-bold text-primary mb-1">Nhật ký: <?= htmlspecialchars($bookingInfo['ten_tour']) ?></h4>
        <p class="text-muted mb-0">
            <i class="fa-regular fa-calendar me-1"></i> Khởi hành: <?= date('d/m/Y', strtotime($bookingInfo['ngay_khoi_hanh'] ?? date('Y-m-d'))) ?>
            <span class="mx-2">|</span>
            HDV: <?= htmlspecialchars($bookingInfo['hdv_name'] ?? '') ?>
        </p>
    </div>

    <form method="POST" class="pb-5">
        <input type="hidden" name="booking_id" value="<?= $bookingInfo['id'] ?>">
        <?php for ($day = 1; $day <= $maxDays; $day++):
            $d = $existingDiaries[$day] ?? null;
            $title = $d['tieu_de'] ?? '';
            $content = $d['noi_dung'] ?? '';
            $id = $d['id'] ?? '';
        ?>
            <div class="card mb-4 p-3 shadow-sm">
                <h6 class="fw-bold text-secondary">Ngày <?= $day ?></h6>
                <div class="mb-2">
                    <label class="form-label">Tiêu đề</label>
                    <input type="text" name="diaries[<?= $day ?>][tieu_de]" class="form-control"
                        value="<?= htmlspecialchars($title) ?>">
                </div>
                <div class="mb-2">
                    <label class="form-label">Nội dung</label>
                    <textarea name="diaries[<?= $day ?>][noi_dung]" class="form-control" rows="4"><?= htmlspecialchars($content) ?></textarea>
                </div>
                <?php if (!empty($id)): ?>
                    <input type="hidden" name="diaries[<?= $day ?>][id]" value="<?= $id ?>">
                <?php endif; ?>
                <input type="hidden" name="diaries[<?= $day ?>][ngay_thu]" value="<?= $day ?>">
            </div>
        <?php endfor; ?>

        <div class="text-center">
            <button type="submit" class="btn btn-success px-4">
                <i class="fa-solid fa-save me-1"></i> Lưu nhật ký
            </button>
        </div>
    </form>
</div>

<?php include PATH_VIEW . 'layouts/footer_hdv.php'; ?>
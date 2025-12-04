<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Chi tiết đánh giá #<?= $comment['id'] ?></h2>
        <a href="index.php?action=comments_list" class="btn btn-secondary">Quay lại</a>
    </div>

    <?php if($comment): ?>
        <div class="card card-modern p-4" style="height: auto !important;">
            <div class="row mb-3 border-bottom pb-3">
                <div class="col-md-6">
                    <label class="text-muted small text-uppercase">Người đánh giá</label>
                    <div class="fs-5 fw-bold"><?= htmlspecialchars($comment['guest_name']) ?></div>
                </div>
                <div class="col-md-6 text-end">
                    <label class="text-muted small text-uppercase">Thời gian</label>
                    <div class="fw-bold"><?= date('H:i d/m/Y', strtotime($comment['created_at'])) ?></div>
                </div>
            </div>

            <div class="mb-3">
                <label class="text-muted small text-uppercase">Nhà cung cấp</label>
                <div class="fs-4 text-primary fw-bold"><i class="fa-solid fa-store"></i> <?= htmlspecialchars($comment['supplier_name']) ?></div>
            </div>

            <div class="mb-4">
                <label class="text-muted small text-uppercase">Đánh giá sao</label>
                <div class="fs-3 text-warning">
                    <?= str_repeat('<i class="fa-solid fa-star"></i>', $comment['rating']) ?>
                    <span class="text-muted fs-6 fw-normal">(<?= $comment['rating'] ?>/5)</span>
                </div>
            </div>

            <div class="bg-light p-3 rounded border">
                <label class="fw-bold mb-2"><i class="fa-solid fa-comment-dots"></i> Nội dung:</label>
                <p class="mb-0 text-secondary" style="white-space: pre-line;">
                    <?= htmlspecialchars($comment['content']) ?>
                </p>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Không tìm thấy thông tin đánh giá này.</div>
    <?php endif; ?>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>
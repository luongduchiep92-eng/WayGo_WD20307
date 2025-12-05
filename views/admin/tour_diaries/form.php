<?php include PATH_VIEW . 'layouts/header.php'; 
    $maxDays = $data['max_days'] ?? 1;
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-primary mb-1">Nhật Ký: <?= htmlspecialchars($data['ten_tour']) ?></h3>
        <p class="text-muted mb-0">
            <i class="fa-regular fa-calendar me-1"></i> KH: <?= date('d/m/Y', strtotime($data['ngay_khoi_hanh'])) ?> 
            <span class="mx-2">|</span> 
            <i class="fa-solid fa-user-tie me-1"></i> HDV: <?= $data['hdv_name'] ?: 'Chưa có' ?>
        </p>
    </div>
    <a href="index.php?action=diary_list" class="btn btn-secondary shadow-sm fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> Quay lại</a>
</div>

<form method="POST" id="diaryForm" class="pb-5">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="booking_id" value="<?= $data['id'] ?>">
    <input type="hidden" name="deleted_ids" id="deleted_ids" value="">

    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <div id="diary-container" class="position-relative ps-4 border-start border-2 border-light">
                
                <?php if(!empty($data['diaries'])): ?>
                    <?php foreach($data['diaries'] as $d): ?>
                        <div class="card mb-4 diary-item shadow-sm border-0 position-relative" data-id="<?= $d['id'] ?>">
                            <div class="position-absolute top-0 start-0 translate-middle rounded-circle bg-primary border border-4 border-white shadow-sm" style="width: 20px; height: 20px; left: -25px !important;"></div>
                            
                            <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center border-bottom-0">
                                <span class="badge bg-primary rounded-pill px-3">Ngày <?= $d['ngay_thu'] ?></span>
                                <button type="button" class="btn btn-sm text-danger opacity-50 hover-opacity-100" onclick="deleteDiary(this, <?= $d['id'] ?>)" title="Xóa bài này"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row g-2">
                                    <div class="col-12 mb-2">
                                        <input type="hidden" name="diaries[<?= $d['id'] ?>][ngay_thu]" value="<?= $d['ngay_thu'] ?>">
                                        <input type="text" name="diaries[<?= $d['id'] ?>][tieu_de]" class="form-control fw-bold border-0 px-0 fs-5 text-dark" value="<?= htmlspecialchars($d['tieu_de']) ?>" placeholder="Tiêu đề..." style="box-shadow: none;">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="diaries[<?= $d['id'] ?>][noi_dung]" class="form-control bg-light" rows="3" placeholder="Nội dung..."><?= htmlspecialchars($d['noi_dung']) ?></textarea>
                                    </div>
                                </div>
                                <div class="text-end mt-2">
                                    <small class="text-muted fst-italic" style="font-size: 0.75rem;">Cập nhật: <?= date('H:i d/m', strtotime($d['created_at'])) ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted py-5" id="empty-msg">
                        <i class="fa-solid fa-pen-fancy fa-3x mb-3 opacity-25"></i>
                        <p>Chưa có dòng nhật ký nào. Hãy bắt đầu viết!</p>
                    </div>
                <?php endif; ?>

            </div>

            <div class="text-center mt-4 mb-5">
                <button type="button" class="btn btn-outline-primary btn-lg border-dashed rounded-pill px-5 fw-bold" onclick="addDiary()">
                    <i class="fa-solid fa-plus me-2"></i> THÊM BÀI VIẾT MỚI
                </button>
            </div>

        </div>
    </div>

    <div class="fixed-bottom bg-white border-top py-3 shadow-lg" style="z-index: 1020;">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php?action=diary_list" class="btn btn-white border fw-bold text-secondary px-4">Đóng</a>
            <button type="submit" class="btn btn-success fw-bold text-white px-5 py-2 shadow-sm text-uppercase">
                <i class="fa-solid fa-floppy-disk me-2"></i> Lưu Tất Cả
            </button>
        </div>
    </div>
    <div style="height: 60px;"></div>
</form>

<script>
    const container = document.getElementById('diary-container');
    const deletedInput = document.getElementById('deleted_ids');
    const maxDays = <?= $maxDays ?>;
    const emptyMsg = document.getElementById('empty-msg');

    // Tạo options cho select ngày (Dùng cho form thêm mới)
    let dayOptions = '';
    for(let i=1; i<=maxDays; i++) {
        dayOptions += `<option value="${i}">Ngày ${i}</option>`;
    }

    function addDiary() {
        if(emptyMsg) emptyMsg.style.display = 'none';
        
        const tempId = 'new_' + Date.now();
        const html = `
        <div class="card mb-4 diary-item shadow-sm border-start border-4 border-success position-relative bg-light">
            <div class="position-absolute top-0 start-0 translate-middle rounded-circle bg-success border border-4 border-white shadow-sm" style="width: 20px; height: 20px; left: -25px !important;"></div>
            
            <div class="card-header bg-transparent py-2 d-flex justify-content-between align-items-center border-bottom-0">
                <select name="diaries[${tempId}][ngay_thu]" class="form-select form-select-sm w-auto fw-bold text-success border-success">
                    ${dayOptions}
                </select>
                <button type="button" class="btn btn-sm text-secondary" onclick="this.closest('.diary-item').remove()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="card-body pt-0">
                <input type="text" name="diaries[${tempId}][tieu_de]" class="form-control fw-bold border-0 bg-transparent px-0 mb-2 fs-5" placeholder="Nhập tiêu đề (VD: Sáng ngày 1...)" required>
                <textarea name="diaries[${tempId}][noi_dung]" class="form-control bg-white" rows="3" placeholder="Ghi lại sự kiện..." required></textarea>
            </div>
        </div>`;
        
        container.insertAdjacentHTML('beforeend', html);
        
        // Scroll nhẹ xuống cuối
        const newItems = container.querySelectorAll('.diary-item');
        newItems[newItems.length - 1].scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function deleteDiary(btn, id) {
        if(confirm('Bạn có chắc muốn xóa bài viết này?')) {
            let current = deletedInput.value ? deletedInput.value.split(',') : [];
            current.push(id);
            deletedInput.value = current.join(',');
            
            const item = btn.closest('.diary-item');
            item.style.transition = "all 0.3s";
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            setTimeout(() => item.remove(), 300);
        }
    }
</script>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>
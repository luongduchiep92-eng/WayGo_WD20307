<?php include PATH_VIEW . 'layouts/header_hdv.php';
$maxDays = $data['max_days'] ?? 1;
$bookingInfo = $data;
$diaryList = $data['diaries'] ?? [];
?>

<div class="container mt-4 mb-5">
    <div class="card border-0 shadow-sm mb-4 bg-primary text-white">
        <div class="card-body">
            <h5 class="fw-bold mb-1"><i class="fa-solid fa-book-open me-2"></i>Nhật Ký Tour</h5>
            <div class="fw-bold fs-5"><?= htmlspecialchars($bookingInfo['ten_tour']) ?></div>
            <div class="small opacity-75 mt-1">
                <i class="fa-regular fa-calendar me-1"></i> Khởi hành: <?= date('d/m/Y', strtotime($bookingInfo['ngay_khoi_hanh'])) ?>
            </div>
        </div>
    </div>

    <form method="POST" id="hdvDiaryForm" class="pb-5">
        <input type="hidden" name="booking_id" value="<?= $bookingInfo['id'] ?>">
        <input type="hidden" name="deleted_ids" id="deleted_ids" value="">

        <div id="diary-container">
            <?php if (!empty($diaryList)): ?>
                <?php foreach ($diaryList as $d): ?>
                    <div class="card mb-3 diary-item shadow-sm border-0" data-id="<?= $d['id'] ?>">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center pt-3 pb-0 border-0">
                            <div class="badge bg-primary rounded-pill px-3">Ngày <?= $d['ngay_thu'] ?></div>
                            <button type="button" class="btn btn-link text-danger p-0" onclick="deleteDiary(this, <?= $d['id'] ?>)">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                        <div class="card-body pt-2">
                            <div class="mb-2">
                                <input type="hidden" name="diaries[<?= $d['id'] ?>][ngay_thu]" value="<?= $d['ngay_thu'] ?>">
                                <input type="text" name="diaries[<?= $d['id'] ?>][tieu_de]" 
                                       class="form-control fw-bold border-0 px-0 text-dark" 
                                       value="<?= htmlspecialchars($d['tieu_de']) ?>" 
                                       placeholder="Tiêu đề (VD: Sáng, Chiều...)" 
                                       style="font-size: 1.1rem; box-shadow: none;">
                            </div>
                            <div>
                                <textarea name="diaries[<?= $d['id'] ?>][noi_dung]" 
                                          class="form-control bg-light border-0" 
                                          rows="3" 
                                          placeholder="Nội dung chi tiết..."><?= htmlspecialchars($d['noi_dung']) ?></textarea>
                            </div>
                            <div class="text-end mt-2">
                                <small class="text-muted fst-italic" style="font-size: 0.7rem;">
                                    Lưu lúc: <?= date('H:i d/m', strtotime($d['created_at'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-muted py-5" id="empty-msg">
                    <i class="fa-solid fa-pen-to-square fa-3x mb-3 opacity-25"></i>
                    <p>Chưa có nhật ký nào. Hãy bắt đầu viết!</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-grid gap-2 mt-3">
            <button type="button" class="btn btn-outline-primary border-dashed fw-bold py-2" onclick="addDiary()">
                <i class="fa-solid fa-plus-circle me-1"></i> Thêm mục mới
            </button>
        </div>

        <div style="height: 80px;"></div> <div class="fixed-bottom bg-white border-top p-3 shadow-lg" style="z-index: 1050;">
            <div class="d-flex gap-2">
                <a href="index.php?action=dashboard" class="btn btn-light flex-grow-0 text-secondary border">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <button type="submit" class="btn btn-success fw-bold flex-grow-1 text-uppercase shadow-sm">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Lưu Nhật Ký
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const container = document.getElementById('diary-container');
    const deletedInput = document.getElementById('deleted_ids');
    const emptyMsg = document.getElementById('empty-msg');
    const maxDays = <?= $maxDays ?>;

    // Tạo danh sách chọn ngày
    let dayOptions = '';
    for(let i = 1; i <= maxDays; i++) {
        dayOptions += `<option value="${i}">Ngày ${i}</option>`;
    }

    function addDiary() {
        if(emptyMsg) emptyMsg.style.display = 'none';
        
        const tempId = 'new_' + Date.now();
        const html = `
        <div class="card mb-3 diary-item shadow-sm border border-success">
            <div class="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center py-2">
                <select name="diaries[${tempId}][ngay_thu]" class="form-select form-select-sm w-auto border-success text-success fw-bold">
                    ${dayOptions}
                </select>
                <button type="button" class="btn btn-sm text-secondary" onclick="this.closest('.diary-item').remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="card-body">
                <input type="text" name="diaries[${tempId}][tieu_de]" 
                       class="form-control fw-bold border-0 px-0 mb-2" 
                       placeholder="Nhập tiêu đề..." required>
                <textarea name="diaries[${tempId}][noi_dung]" 
                          class="form-control bg-light" 
                          rows="3" 
                          placeholder="Nội dung nhật ký..." required></textarea>
            </div>
        </div>`;
        
        container.insertAdjacentHTML('beforeend', html);
        
        // Cuộn xuống mục vừa thêm
        const newItems = container.querySelectorAll('.diary-item');
        newItems[newItems.length - 1].scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function deleteDiary(btn, id) {
        if(confirm('Xóa mục này?')) {
            // Thêm ID vào input hidden để backend xử lý xóa
            let current = deletedInput.value ? deletedInput.value.split(',') : [];
            current.push(id);
            deletedInput.value = current.join(',');
            
            // Xóa trên giao diện
            const item = btn.closest('.diary-item');
            item.style.transition = "all 0.3s";
            item.style.opacity = '0';
            setTimeout(() => item.remove(), 300);
        }
    }
</script>

<?php include PATH_VIEW . 'layouts/footer_hdv.php'; ?>
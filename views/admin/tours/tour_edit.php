<?php include(PATH_VIEW . 'layouts/header.php'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Cập nhật Tour: <?= $tour->ten_tour ?></h1>
    <a href="index.php?action=tour_list" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Quay lại
    </a>
</div>

<div class="card card-modern">
    <div class="card-body p-4">
        <form action="" method="POST">
            <h5 class="text-primary mb-3 border-bottom pb-2">1. Thông tin cơ bản</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tên tour</label>
                    <input type="text" name="ten_tour" class="form-control" value="<?= $tour->ten_tour ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Loại tour</label>
                    <select name="loai_tour" class="form-select">
                        <option value="Trong nước" <?= $tour->loai_tour=='Trong nước'?'selected':'' ?>>Trong nước</option>
                        <option value="Quốc tế" <?= $tour->loai_tour=='Quốc tế'?'selected':'' ?>>Quốc tế</option>
                        <option value="Theo yêu cầu" <?= $tour->loai_tour=='Theo yêu cầu'?'selected':'' ?>>Theo yêu cầu</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="Hoạt động" <?= $tour->status=='Hoạt động'?'selected':'' ?>>Hoạt động</option>
                        <option value="Đang tạm dừng" <?= $tour->status=='Đang tạm dừng'?'selected':'' ?>>Đang tạm dừng</option>
                        <option value="Hủy" <?= $tour->status=='Hủy'?'selected':'' ?>>Hủy</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Địa điểm</label>
                    <input type="text" name="dia_diem" class="form-control" value="<?= $tour->dia_diem ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Thời gian</label>
                    <input type="text" name="thoi_gian" class="form-control" value="<?= $tour->thoi_gian ?>">
                </div>
                <!-- <div class="col-md-4">
                    <label class="form-label">Ngày khởi hành</label>
                    <input type="date" name="ngay_khoi_hanh" class="form-control" value="<?= $tour->ngay_khoi_hanh ?>">
                </div> -->
                <div class="col-md-4">
                    <label class="form-label fw-bold text-success">Giá tour / 1 người</label>
                    <input type="number" name="gia_tour" class="form-control" value="<?= $tour->gia_tour ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Phương tiện</label>
                    <input type="text" name="phuong_tien" class="form-control" value="<?= $tour->phuong_tien ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Số người tối đa</label>
                    <input type="number" name="so_nguoi_toi_da" class="form-control" value="<?= $tour->so_nguoi_toi_da ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Mô tả</label>
                    <textarea name="mo_ta" class="form-control" rows="3"><?= $tour->mo_ta ?></textarea>
                </div>
            </div>

            <h5 class="text-primary mt-4 mb-3 border-bottom pb-2">2. Hình ảnh</h5>
            <div class="row mb-3" id="images-container">
                <?php if(!empty($tour->images)): ?>
                    <?php foreach($tour->images as $img): ?>
                        <div class="col-md-4 mb-2 position-relative img-wrapper">
                            <div class="input-group">
                                <span class="input-group-text p-0"><img src="<?= $img->image_path ?>" height="38"></span>
                                <input type="text" name="images_existing[<?= $img->id ?>]" class="form-control" value="<?= $img->image_path ?>">
                                <button type="button" class="btn btn-outline-danger remove-img-btn"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" id="add-image-btn" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-plus"></i> Thêm ảnh mới</button>

            <h5 class="text-primary mt-4 mb-3 border-bottom pb-2">3. Lịch trình (Cấu trúc tương tự)</h5>
            <div id="schedule-container">
                <?php if(!empty($schedule)): ?>
                    <?php foreach($schedule as $day): ?>
                        <div class="card mb-3 bg-light">
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-primary">Ngày <?= $day->ngay_thu ?></h6>
                                <input type="text" name="schedule[<?= $day->id ?>][tieu_de]" class="form-control mb-2" value="<?= $day->tieu_de ?>">
                                <textarea name="schedule[<?= $day->id ?>][mo_ta]" class="form-control mb-2"><?= $day->mo_ta ?></textarea>
                                
                                <div class="border-start border-3 border-info ps-3">
                                    <?php foreach ($day->activities as $act): ?>
                                        <div class="d-flex gap-2 mb-2">
                                            <input type="time" name="schedule[<?= $day->id ?>][activities][<?= $act->id ?>][thoi_gian_bat_dau]" class="form-control form-control-sm" value="<?= $act->thoi_gian_bat_dau ?>">
                                            <input type="time" name="schedule[<?= $day->id ?>][activities][<?= $act->id ?>][thoi_gian_ket_thuc]" class="form-control form-control-sm" value="<?= $act->thoi_gian_ket_thuc ?>">
                                            <input type="text" name="schedule[<?= $day->id ?>][activities][<?= $act->id ?>][hoat_dong]" class="form-control form-control-sm w-50" value="<?= $act->hoat_dong ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="alert alert-info small"><i class="fa-solid fa-circle-info"></i> Để thêm ngày mới, vui lòng tạo tour mới hoặc liên hệ admin kỹ thuật.</div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning px-5 py-2 fw-bold text-white">LƯU THAY ĐỔI</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Script xóa/thêm ảnh cơ bản
    document.getElementById('add-image-btn').addEventListener('click', ()=>{
        const div = document.createElement('div');
        div.className = 'col-md-4 mb-2 position-relative';
        div.innerHTML = `
            <div class="input-group">
                <input type="text" name="images_new[]" class="form-control" placeholder="Link ảnh mới...">
                <button type="button" class="btn btn-outline-danger remove-new-btn"><i class="fa-solid fa-trash"></i></button>
            </div>`;
        document.getElementById('images-container').appendChild(div);
        div.querySelector('.remove-new-btn').addEventListener('click', ()=>div.remove());
    });
    
    document.querySelectorAll('.remove-img-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            // Logic xóa ảnh cũ (có thể cần hidden input để đánh dấu xóa)
            const parent = e.target.closest('.img-wrapper');
            const input = parent.querySelector('input[type="text"]');
            input.value = ''; // Xóa value để server biết
            parent.style.display = 'none';
        });
    });
</script>

<?php include(PATH_VIEW . 'layouts/footer.php'); ?>
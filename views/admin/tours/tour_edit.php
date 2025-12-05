<?php include(PATH_VIEW . 'layouts/header.php'); ?>

<style>
    /* Style cho Card Ngày */
    .day-card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden; /* Để bo góc header */
    }
    .day-card-header {
        background-color: #0d6efd; /* Màu primary đậm */
        color: white;
        padding: 12px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .day-card-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    /* Style cho dòng Hoạt động bên trong */
    .activity-item {
        background-color: #f8f9fa; /* Màu nền xám nhẹ */
        border-left: 4px solid #0dcaf0; /* Đường viền màu info bên trái */
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 6px;
        position: relative;
        transition: all 0.2s ease;
    }
    .activity-item:hover {
        background-color: #f0f2f5;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    /* Khu vực thời gian */
    .time-range-badge {
        background: #e7f1ff;
        color: #0d6efd;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }
    .time-input-slim {
        border: none;
        background: transparent;
        font-weight: inherit;
        color: inherit;
        padding: 0;
        width: auto;
        outline: none;
        font-family: monospace; /* Để số thẳng hàng */
    }
    .time-input-slim:focus {
        box-shadow: none;
        border-bottom: 1px dotted currentColor;
    }

    /* Các input khác */
    .input-location {
        border: none;
        background: transparent;
        border-bottom: 1px solid #dee2e6;
        border-radius: 0;
        padding-left: 0;
    }
    .input-location:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }
    .textarea-activity {
        resize: none;
        border-color: #eee;
        font-size: 0.95rem;
    }

    /* Nút thêm mới */
    .btn-dashed-lg {
        border: 2px dashed #adb5bd;
        color: #6c757d;
        font-weight: 600;
        background: #f8f9fa;
        transition: all 0.3s;
    }
    .btn-dashed-lg:hover {
        border-color: #0d6efd;
        color: #0d6efd;
        background: #fff;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
         <h1 class="h3 mb-0 text-gray-800 fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i>Cập nhật Tour</h1>
         <p class="text-muted mb-0"><?= htmlspecialchars($tour->ten_tour ?? '') ?></p>
    </div>
   
    <a href="index.php?action=tour_list" class="btn btn-secondary shadow-sm fw-bold">
        <i class="fa-solid fa-arrow-left me-2"></i> Quay lại danh sách
    </a>
</div>

<form action="" method="POST" id="editTourForm">
    <input type="hidden" name="deleted_days" id="deleted_days" value="">
    <input type="hidden" name="deleted_activities" id="deleted_activities" value="">

    <div class="row">
        <div class="col-lg-8">
             <div class="card card-modern mb-4">
                <div class="card-header bg-white py-3 fw-bold text-primary border-bottom">
                    <i class="fa-solid fa-info-circle me-2"></i> 1. Thông tin cơ bản
                </div>
                <div class="card-body p-4">
                     <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Tên tour <span class="text-danger">*</span></label>
                            <input type="text" name="ten_tour" class="form-control form-control-lg fw-bold text-primary" value="<?= htmlspecialchars($tour->ten_tour ?? '') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Loại tour</label>
                            <select name="loai_tour" class="form-select">
                                <option value="Trong nước" <?= ($tour->loai_tour ?? '') == 'Trong nước' ? 'selected' : '' ?>>Trong nước</option>
                                <option value="Quốc tế" <?= ($tour->loai_tour ?? '') == 'Quốc tế' ? 'selected' : '' ?>>Quốc tế</option>
                                <option value="Theo yêu cầu" <?= ($tour->loai_tour ?? '') == 'Theo yêu cầu' ? 'selected' : '' ?>>Theo yêu cầu</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="Hoạt động" <?= ($tour->status ?? '') == 'Hoạt động' ? 'selected' : '' ?>>Hoạt động (Hiện)</option>
                                <option value="Đang tạm dừng" <?= ($tour->status ?? '') == 'Đang tạm dừng' ? 'selected' : '' ?>>Đang tạm dừng (Ẩn)</option>
                                <option value="Hủy" <?= ($tour->status ?? '') == 'Hủy' ? 'selected' : '' ?>>Hủy (Ngừng KD)</option>
                            </select>
                        </div>
                         <div class="col-md-4">
                            <label class="form-label fw-bold text-success"><i class="fa-solid fa-money-bill-wave me-1"></i> Giá tour / khách</label>
                            <div class="input-group">
                                <input type="number" name="gia_tour" class="form-control fw-bold text-success" value="<?= $tour->gia_tour ?? 0 ?>">
                                <span class="input-group-text fw-bold">VNĐ</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fa-solid fa-map-marker-alt me-1 text-muted"></i> Địa điểm khởi hành</label>
                            <input type="text" name="dia_diem" class="form-control" value="<?= htmlspecialchars($tour->dia_diem ?? '') ?>">
                        </div>
                         <div class="col-md-3">
                            <label class="form-label"><i class="fa-solid fa-clock me-1 text-muted"></i> Thời lượng</label>
                            <input type="text" name="thoi_gian" class="form-control" value="<?= htmlspecialchars($tour->thoi_gian ?? '') ?>" placeholder="VD: 3N2Đ">
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label"><i class="fa-solid fa-users me-1 text-muted"></i> Số người tối đa</label>
                            <input type="number" name="so_nguoi_toi_da" class="form-control" value="<?= $tour->so_nguoi_toi_da ?? 0 ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label"><i class="fa-solid fa-bus me-1 text-muted"></i> Phương tiện di chuyển</label>
                            <input type="text" name="phuong_tien" class="form-control" value="<?= htmlspecialchars($tour->phuong_tien ?? '') ?>" placeholder="VD: Ô tô du lịch đời mới, Máy bay Vietnam Airlines...">
                        </div>
                        
                        <div class="col-12 mt-4">
                            <label class="form-label fw-bold">Mô tả ngắn / Giới thiệu tour</label>
                            <textarea name="mo_ta" class="form-control" rows="4"><?= htmlspecialchars($tour->mo_ta ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
             <div class="card card-modern mb-4">
                <div class="card-header bg-white py-3 fw-bold text-primary border-bottom">
                    <i class="fa-regular fa-images me-2"></i> 2. Thư viện ảnh
                </div>
                <div class="card-body p-3 bg-light">
                    <div id="images-container" class="row g-2">
                        <?php if(!empty($tour->images)): ?>
                            <?php foreach($tour->images as $img): ?>
                                <div class="col-6 col-md-6 img-wrapper">
                                    <div class="card h-100 border-0 shadow-sm position-relative">
                                        <img src="<?= $img->image_path ?>" class="card-img-top" alt="Tour Image" style="height: 120px; object-fit: cover; border-radius: 4px 4px 0 0;">
                                        <div class="card-body p-2">
                                             <input type="text" name="images_existing[<?= $img->id ?>]" class="form-control form-control-sm border-0 bg-transparent p-0 mb-1 text-truncate" value="<?= htmlspecialchars($img->image_path ?? '') ?>" readonly title="<?= htmlspecialchars($img->image_path ?? '') ?>">
                                             <button type="button" class="btn btn-sm btn-danger w-100 remove-img-btn py-0"><i class="fa-solid fa-trash-can"></i> Xóa ảnh này</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" id="add-image-btn" class="btn btn-outline-primary w-100 mt-3 fw-bold">
                        <i class="fa-solid fa-cloud-arrow-up me-1"></i> Thêm link ảnh mới
                    </button>
                </div>
            </div>
        </div>
    </div>

    <h4 class="fw-bold text-primary mb-3 mt-3">
        <i class="fa-solid fa-calendar-days me-2"></i> 3. Lịch trình chi tiết
    </h4>
    
    <div id="schedule-container">
        <?php if(!empty($schedule)): ?>
            <?php foreach($schedule as $index => $day): ?>
                <div class="card day-card mb-4 day-block" data-day-id="<?= $day->id ?>">
                    <div class="day-card-header">
                        <h5 class="day-card-title">
                            <i class="fa-regular fa-calendar-check"></i> Ngày <?= $index + 1 ?>
                        </h5>
                        <button type="button" class="btn btn-sm btn-danger bg-gradient fw-bold shadow-sm border-0 px-3" onclick="deleteDay(this, <?= $day->id ?>)">
                            <i class="fa-solid fa-trash-can me-1"></i> Xóa ngày này
                        </button>
                    </div>
                    <div class="card-body bg-white p-4">
                        <div class="mb-4 bg-light p-3 rounded-3 border">
                             <div class="mb-2">
                                <label class="form-label small text-muted text-uppercase fw-bold mb-1">Tiêu đề ngày</label>
                                <input type="text" name="schedule[<?= $day->id ?>][tieu_de]" class="form-control fw-bold fs-5 text-primary border-0 bg-transparent p-0" value="<?= htmlspecialchars($day->tieu_de ?? '') ?>" placeholder="VD: Khám phá Vịnh Hạ Long">
                             </div>
                            <div>
                                <label class="form-label small text-muted text-uppercase fw-bold mb-1">Mô tả chung (Tùy chọn)</label>
                                <input type="text" name="schedule[<?= $day->id ?>][mo_ta]" class="form-control border-0 bg-transparent p-0 text-muted" value="<?= htmlspecialchars($day->mo_ta ?? '') ?>" placeholder="Nhập mô tả ngắn gọn cho cả ngày...">
                            </div>
                        </div>
                        
                        <h6 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-list-ul me-2"></i>Danh sách hoạt động trong ngày:</h6>
                        <div class="activities-wrapper ps-2">
                            <?php if(!empty($day->activities)): ?>
                                <?php foreach ($day->activities as $act): ?>
                                    <div class="activity-item" data-act-id="<?= $act->id ?>">
                                        <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                                            <div class="time-range-badge shadow-sm">
                                                <i class="fa-regular fa-clock"></i>
                                                <input type="time" name="schedule[<?= $day->id ?>][activities][<?= $act->id ?>][thoi_gian_bat_dau]" class="time-input-slim" value="<?= $act->thoi_gian_bat_dau ?? '' ?>">
                                                <i class="fa-solid fa-arrow-right-long mx-1 text-muted small"></i>
                                                <input type="time" name="schedule[<?= $day->id ?>][activities][<?= $act->id ?>][thoi_gian_ket_thuc]" class="time-input-slim" value="<?= $act->thoi_gian_ket_thuc ?? '' ?>">
                                            </div>

                                            <div class="flex-grow-1 mx-md-3">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text bg-transparent border-0 ps-0 text-success"><i class="fa-solid fa-location-dot"></i></span>
                                                    <input type="text" name="schedule[<?= $day->id ?>][activities][<?= $act->id ?>][dia_diem]" class="form-control input-location fw-bold text-success" placeholder="Địa điểm (VD: Hang Sửng Sốt)" value="<?= htmlspecialchars($act->dia_diem ?? '') ?>">
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="deleteActivity(this, <?= $act->id ?>)" title="Xóa hoạt động này">
                                                <i class="fa-solid fa-xmark fa-lg"></i>
                                            </button>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-transparent border-0 ps-0 align-items-start pt-2 text-muted"><i class="fa-solid fa-align-left"></i></span>
                                            <textarea name="schedule[<?= $day->id ?>][activities][<?= $act->id ?>][hoat_dong]" class="form-control textarea-activity bg-white" rows="2" placeholder="Chi tiết hoạt động (VD: HDV đưa đoàn đi thăm quan, chụp ảnh lưu niệm...)"><?= htmlspecialchars($act->hoat_dong ?? '') ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-light text-primary fw-bold mt-2 border shadow-sm px-3" onclick="addActivity(this, '<?= $day->id ?>')">
                            <i class="fa-solid fa-plus-circle me-1"></i> Thêm hoạt động mới vào Ngày <?= $index + 1 ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <button type="button" class="btn btn-dashed-lg w-100 py-3 mb-5" onclick="addNewDay()">
        <i class="fa-solid fa-calendar-plus fa-2x mb-2 d-block"></i>
        THÊM NGÀY MỚI VÀO LỊCH TRÌNH
    </button>

    <div class="py-4 mt-5 border-top">
        <div class="d-flex justify-content-between align-items-center">
            <a href="index.php?action=tour_detail&id=<?= $tour->id ?>" class="btn btn-white border border-secondary-subtle text-secondary fw-bold px-4">
                <i class="fa-solid fa-xmark me-1"></i> Hủy bỏ
            </a>

            <button type="submit" class="btn btn-warning text-white fw-bold px-4 py-2 text-uppercase shadow-sm" style="background-color: #ffc107; border-color: #ffc107;">
                <i class="fa-solid fa-floppy-disk me-2"></i> LƯU LẠI TOÀN BỘ THAY ĐỔI
            </button>
        </div>
    </div>

</form>

<script>
    const deletedDaysInput = document.getElementById('deleted_days');
    const deletedActsInput = document.getElementById('deleted_activities');

    function deleteDay(btn, dayId) {
        if(!confirm('Xác nhận xóa? Hành động này sẽ xóa ngày này và tất cả hoạt động bên trong.')) return;
        if (Number.isInteger(dayId)) {
            let current = deletedDaysInput.value ? deletedDaysInput.value.split(',') : [];
            current.push(dayId);
            deletedDaysInput.value = current.join(',');
        }
        // Hiệu ứng fade out trước khi xóa
        const block = btn.closest('.day-block');
        block.style.transition = 'all 0.3s';
        block.style.opacity = '0';
        setTimeout(() => block.remove(), 300);
    }

    function deleteActivity(btn, actId) {
        if (Number.isInteger(actId)) {
            let current = deletedActsInput.value ? deletedActsInput.value.split(',') : [];
            current.push(actId);
            deletedActsInput.value = current.join(',');
        }
         // Hiệu ứng fade out
        const row = btn.closest('.activity-item');
        row.style.transition = 'all 0.3s';
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        setTimeout(() => row.remove(), 300);
    }

    function addNewDay() {
        const container = document.getElementById('schedule-container');
        const tempId = 'new_day_' + Date.now();
        const currentDays = container.querySelectorAll('.day-block').length;
        const nextDayNum = currentDays + 1;

        // HTML Template mới cho Ngày
        const html = `
        <div class="card day-card mb-4 day-block border-success">
             <div class="day-card-header bg-success">
                <h5 class="day-card-title">
                    <i class="fa-solid fa-calendar-plus"></i> Ngày ${nextDayNum} (Mới)
                </h5>
                <button type="button" class="btn btn-sm btn-light text-success fw-bold shadow-sm border-0 px-3" onclick="this.closest('.day-block').remove()">
                    <i class="fa-solid fa-times me-1"></i> Hủy
                </button>
            </div>
            <div class="card-body bg-white p-4">
                 <div class="mb-4 bg-light p-3 rounded-3 border border-success bg-opacity-10">
                        <div class="mb-2">
                        <label class="form-label small text-muted text-uppercase fw-bold mb-1">Tiêu đề ngày</label>
                        <input type="text" name="schedule[${tempId}][tieu_de]" class="form-control fw-bold fs-5 text-success border-0 bg-transparent p-0" placeholder="VD: Tự do khám phá...">
                        </div>
                    <div>
                        <label class="form-label small text-muted text-uppercase fw-bold mb-1">Mô tả chung (Tùy chọn)</label>
                        <input type="text" name="schedule[${tempId}][mo_ta]" class="form-control border-0 bg-transparent p-0 text-muted" placeholder="Nhập mô tả ngắn gọn...">
                    </div>
                </div>
                <h6 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-list-ul me-2"></i>Danh sách hoạt động:</h6>
                <div class="activities-wrapper ps-2"></div>
                <button type="button" class="btn btn-sm btn-light text-success fw-bold mt-2 border border-success shadow-sm px-3" onclick="addActivity(this, '${tempId}')">
                    <i class="fa-solid fa-plus-circle me-1"></i> Thêm hoạt động mới
                </button>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
        // Scroll tới ngày mới thêm
        container.lastElementChild.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function addActivity(btn, dayKey) {
        const wrapper = btn.previousElementSibling;
        const tempActId = 'new_act_' + Date.now() + Math.floor(Math.random() * 100);
        
        // HTML Template mới cho Hoạt động
        const html = `
        <div class="activity-item border-start border-success">
            <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                <div class="time-range-badge shadow-sm bg-success bg-opacity-10 text-success">
                    <i class="fa-regular fa-clock"></i>
                    <input type="time" name="schedule[${dayKey}][activities][${tempActId}][thoi_gian_bat_dau]" class="time-input-slim" value="08:00">
                    <i class="fa-solid fa-arrow-right-long mx-1 text-muted small"></i>
                    <input type="time" name="schedule[${dayKey}][activities][${tempActId}][thoi_gian_ket_thuc]" class="time-input-slim" value="09:00">
                </div>
                <div class="flex-grow-1 mx-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-transparent border-0 ps-0 text-success"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="text" name="schedule[${dayKey}][activities][${tempActId}][dia_diem]" class="form-control input-location fw-bold text-success" placeholder="Địa điểm...">
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary border-0 text-hover-danger" onclick="this.closest('.activity-item').remove()">
                    <i class="fa-solid fa-xmark fa-lg"></i>
                </button>
            </div>
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-transparent border-0 ps-0 align-items-start pt-2 text-muted"><i class="fa-solid fa-align-left"></i></span>
                <textarea name="schedule[${dayKey}][activities][${tempActId}][hoat_dong]" class="form-control textarea-activity bg-white" rows="2" placeholder="Chi tiết hoạt động..."></textarea>
            </div>
        </div>`;
        wrapper.insertAdjacentHTML('beforeend', html);
    }

    // Xử lý ảnh (Giữ nguyên, chỉ làm đẹp lại HTML thêm mới)
    document.getElementById('add-image-btn').addEventListener('click', ()=>{
        const container = document.getElementById('images-container');
        const div = document.createElement('div');
        div.className = 'col-6 col-md-6 img-wrapper';
        div.innerHTML = `
            <div class="card h-100 border-dashed shadow-sm bg-light">
                <div class="card-body p-3 d-flex flex-column justify-content-center align-items-center text-center" style="min-height: 150px;">
                    <i class="fa-regular fa-image fa-2x text-muted mb-2"></i>
                    <input type="text" name="images_new[]" class="form-control form-control-sm mb-2" placeholder="Dán link ảnh vào đây...">
                    <button type="button" class="btn btn-sm btn-outline-danger py-0" onclick="this.closest('.img-wrapper').remove()">Hủy</button>
                </div>
            </div>`;
        container.appendChild(div);
    });
    
    document.querySelectorAll('.remove-img-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const parent = e.target.closest('.img-wrapper');
            const input = parent.querySelector('input[type="text"]');
            input.value = '';
            parent.style.display = 'none';
        });
    });
</script>

<?php include(PATH_VIEW . 'layouts/footer.php'); ?>
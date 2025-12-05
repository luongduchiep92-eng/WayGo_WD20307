<?php include PATH_VIEW . 'layouts/header.php'; 
    $ngayKhoiHanh = $booking['ngay_khoi_hanh'] ?? $booking['hien_thi_ngay'] ?? date('Y-m-d');
    $isCustomTour = ($booking['loai_tour'] === 'Theo yêu cầu');
?>

<style>
    .day-card { border: 1px solid #e3e6f0; border-radius: 8px; overflow: hidden; margin-bottom: 15px; }
    .day-card-header { background: #f8f9fc; padding: 10px 15px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e3e6f0; }
    .activity-item { background: #fff; padding: 10px; border-bottom: 1px dashed #e3e6f0; }
    .activity-item:last-child { border-bottom: none; }
    .btn-dashed { border: 1px dashed #ccc; background: #fafafa; color: #666; width: 100%; margin-top: 10px; transition: 0.2s; }
    .btn-dashed:hover { border-color: #4e73df; color: #4e73df; background: #fff; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i>Cập nhật Booking #<?= $booking['id'] ?></h1>
        <p class="text-muted mb-0">Chỉnh sửa thông tin đơn đặt tour</p>
    </div>
    <a href="index.php?action=booking_list" class="btn btn-secondary shadow-sm fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> Quay lại</a>
</div>

<form method="post" id="bookingForm" class="pb-5">
    
    <input type="hidden" name="deleted_days" id="deleted_days" value="">
    <input type="hidden" name="deleted_activities" id="deleted_activities" value="">

    <div class="row">
        <div class="col-lg-8">
            
            <div class="card card-modern mb-4">
                <div class="card-header bg-white py-3 fw-bold text-primary border-bottom">
                    <i class="fa-solid fa-map-location-dot me-2"></i> 1. Thông tin Tour & Lịch trình
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted">Tour đang chọn</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold"><?= $booking['loai_tour'] ?></span>
                                <input type="text" class="form-control fw-bold text-primary bg-light" value="<?= htmlspecialchars($booking['ten_tour']) ?>" readonly>
                            </div>
                            <?php if($isCustomTour): ?>
                                <div class="alert alert-info mt-2 py-2 small mb-0">
                                    <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Đây là tour theo yêu cầu. Bạn có thể tùy chỉnh lịch trình chi tiết bên dưới.
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6"><label class="form-label fw-bold">Ngày Khởi Hành</label><input type="date" name="ngay_khoi_hanh" class="form-control" value="<?= $ngayKhoiHanh ?>"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Phương tiện</label><input type="text" name="phuong_tien" class="form-control" value="<?= htmlspecialchars($booking['phuong_tien']) ?>"></div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Hướng Dẫn Viên</label>
                            <select name="hdv_id" class="form-select">
                                <option value="">-- Chưa chọn HDV --</option>
                                <?php foreach ($hdvs as $h): ?>
                                    <option value="<?= $h['id'] ?>" <?= $h['id'] == $booking['hdv_id'] ? 'selected' : '' ?>><?= $h['ho_ten'] ?> (<?= $h['loai_hdv'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary border-bottom pb-2 mb-3"><i class="fa-solid fa-list-check me-1"></i> Chi tiết Lịch trình (Có thể chỉnh sửa)</h6>
                    
                    <div id="schedule-container">
                        <?php if(!empty($booking['schedule'])): ?>
                            <?php foreach($booking['schedule'] as $index => $day): ?>
                                <div class="day-card day-block" data-day-id="<?= $day['id'] ?>">
                                    <div class="day-card-header">
                                        <div class="d-flex align-items-center w-100 me-2">
                                            <span class="badge bg-primary me-2">Ngày</span>
                                            <input type="text" name="schedule[<?= $day['id'] ?>][tieu_de]" class="form-control form-control-sm fw-bold border-0 bg-transparent p-0" value="<?= htmlspecialchars($day['tieu_de'] ?? '') ?>" placeholder="Tiêu đề ngày...">
                                        </div>
                                        <button type="button" class="btn btn-sm text-danger" onclick="deleteDay(this, <?= $day['id'] ?>)"><i class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                    <div class="p-3 bg-white">
                                        <input type="text" name="schedule[<?= $day['id'] ?>][mo_ta]" class="form-control form-control-sm mb-2 text-muted fst-italic" value="<?= htmlspecialchars($day['mo_ta'] ?? '') ?>" placeholder="Mô tả chung cho ngày này...">
                                        
                                        <div class="activities-wrapper">
                                            <?php if(!empty($day['activities'])): ?>
                                                <?php foreach ($day['activities'] as $act): ?>
                                                    <div class="activity-item d-flex gap-2 align-items-center" data-act-id="<?= $act['id'] ?>">
                                                        <div class="d-flex flex-column gap-1" style="width: 140px;">
                                                            <input type="time" name="schedule[<?= $day['id'] ?>][activities][<?= $act['id'] ?>][thoi_gian_bat_dau]" class="form-control form-control-sm" value="<?= $act['thoi_gian_bat_dau'] ?>">
                                                            <input type="time" name="schedule[<?= $day['id'] ?>][activities][<?= $act['id'] ?>][thoi_gian_ket_thuc]" class="form-control form-control-sm" value="<?= $act['thoi_gian_ket_thuc'] ?>">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <input type="text" name="schedule[<?= $day['id'] ?>][activities][<?= $act['id'] ?>][hoat_dong]" class="form-control form-control-sm fw-bold mb-1" value="<?= htmlspecialchars($act['hoat_dong']) ?>" placeholder="Hoạt động...">
                                                            <input type="text" name="schedule[<?= $day['id'] ?>][activities][<?= $act['id'] ?>][dia_diem]" class="form-control form-control-sm text-success" value="<?= htmlspecialchars($act['dia_diem']) ?>" placeholder="Tại đâu...">
                                                        </div>
                                                        <button type="button" class="btn btn-sm text-secondary" onclick="deleteActivity(this, <?= $act['id'] ?>)"><i class="fa-solid fa-xmark"></i></button>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-light text-primary w-100 mt-2 border" onclick="addActivity(this, '<?= $day['id'] ?>')"><i class="fa-solid fa-plus"></i> Thêm hoạt động</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-dashed py-2" onclick="addNewDay()"><i class="fa-solid fa-calendar-plus"></i> THÊM NGÀY MỚI</button>
                </div>
            </div>

            <div class="card card-modern mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <span class="fw-bold text-success"><i class="fa-solid fa-users me-2"></i> 2. Danh sách Khách hàng</span>
                    <button type="button" class="btn btn-sm btn-success shadow-sm" id="addCustBtn"><i class="fa-solid fa-user-plus"></i> Thêm khách</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="custTable">
                            <thead class="table-light text-secondary"><tr><th width="25%">Họ tên</th><th width="15%">SĐT</th><th width="10%">Tuổi</th><th width="15%">Giới tính</th><th width="20%">Giá vé</th><th width="5%">#</th></tr></thead>
                            <tbody>
                                <?php if (!empty($booking['customers'])): foreach ($booking['customers'] as $key => $c): ?>
                                    <tr class="cust-row">
                                        <td><input type="text" name="customers[<?= $key ?>][name]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($c['ho_ten']) ?>" required></td>
                                        <td><input type="text" name="customers[<?= $key ?>][phone]" class="form-control form-control-sm" value="<?= htmlspecialchars($c['so_dien_thoai']) ?>"></td>
                                        <td><input type="number" name="customers[<?= $key ?>][age]" class="form-control form-control-sm age-input" value="<?= $c['tuoi'] ?>" required></td>
                                        <td><select name="customers[<?= $key ?>][gender]" class="form-select form-select-sm"><option value="Nam" <?= $c['gioi_tinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option><option value="Nữ" <?= $c['gioi_tinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option></select></td>
                                        <td><input type="number" name="customers[<?= $key ?>][price]" class="form-control form-control-sm fw-bold text-end price-input text-success" value="<?= $c['gia_tien'] ?>"><input type="hidden" name="customers[<?= $key ?>][cccd]" value="<?= $c['CCCD'] ?>"></td>
                                        <td class="text-center"><button type="button" class="btn btn-outline-danger btn-sm del-row"><i class="fa-solid fa-trash"></i></button></td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-modern mb-4 sticky-top" style="top: 20px; z-index: 1;">
                <div class="card-header bg-white py-3 fw-bold text-warning border-bottom"><i class="fa-solid fa-file-invoice-dollar me-2"></i> 3. Thanh toán & Trạng thái</div>
                <div class="card-body p-4">
                    <div class="mb-3"><label class="form-label fw-bold">Trạng thái</label><select name="status" class="form-select fw-bold"><option value="Chờ xử lý" <?= $booking['status']=='Chờ xử lý'?'selected':'' ?>>Chờ xử lý</option><option value="Đã cọc" <?= $booking['status']=='Đã cọc'?'selected':'' ?>>Đã cọc</option><option value="Hoàn tất" <?= $booking['status']=='Hoàn tất'?'selected':'' ?>>Hoàn tất</option><option value="Hủy" <?= $booking['status']=='Hủy'?'selected':'' ?>>Hủy</option></select></div>
                    <hr>
                    <div class="mb-2 row"><label class="col-6 col-form-label text-muted">Tổng tiền vé:</label><div class="col-6"><input type="text" name="tong_tien" id="totalMoney" class="form-control form-control-sm fw-bold text-end bg-white" readonly value="<?= $booking['tong_tien'] ?>"></div></div>
                    <div class="mb-2 row"><label class="col-6 col-form-label text-muted">Phát sinh:</label><div class="col-6"><input type="number" id="phatSinh" name="chi_phi_phat_sinh" class="form-control form-control-sm text-end text-danger fw-bold" value="<?= $booking['chi_phi_phat_sinh'] ?>"></div></div>
                    <div class="mb-3"><input type="text" name="ly_do_phat_sinh" class="form-control form-control-sm fst-italic" placeholder="Lý do phát sinh..." value="<?= htmlspecialchars($booking['ly_do_phat_sinh']) ?>"></div>
                    <div class="mb-3 row bg-light py-2 rounded mx-0"><label class="col-6 col-form-label fw-bold">Đã thanh toán:</label><div class="col-6"><input type="text" class="form-control form-control-sm fw-bold text-end text-success bg-transparent border-0" id="paidAmount" value="<?= number_format($booking['tien_da_coc']) ?>" readonly data-raw="<?= $booking['tien_da_coc'] ?>"></div></div>
                    <div class="mb-3"><label class="form-label fw-bold text-primary">Thu thêm tiền:</label><input type="text" name="them_coc" id="payMoreInput" class="form-control fw-bold border-primary text-end" placeholder="0"></div>
                    <div class="alert alert-secondary text-center fw-bold mb-0"><div id="remainText">...</div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mt-4 border-top pt-4">
        <a href="index.php?action=booking_list" class="btn btn-outline-secondary fw-bold px-4 me-2">Hủy</a>
        <button type="submit" class="btn btn-warning fw-bold text-white px-5 py-2 shadow-sm text-uppercase">Cập nhật Booking</button>
    </div>
</form>

<script>
// --- JS XỬ LÝ LỊCH TRÌNH ---
const deletedDaysInput = document.getElementById('deleted_days');
const deletedActsInput = document.getElementById('deleted_activities');

function deleteDay(btn, dayId) {
    if(!confirm('Xóa ngày này?')) return;
    if (Number.isInteger(dayId)) {
        let current = deletedDaysInput.value ? deletedDaysInput.value.split(',') : [];
        current.push(dayId);
        deletedDaysInput.value = current.join(',');
    }
    btn.closest('.day-block').remove();
}

function deleteActivity(btn, actId) {
    if (Number.isInteger(actId)) {
        let current = deletedActsInput.value ? deletedActsInput.value.split(',') : [];
        current.push(actId);
        deletedActsInput.value = current.join(',');
    }
    btn.closest('.activity-item').remove();
}

function addNewDay() {
    const container = document.getElementById('schedule-container');
    const tempId = 'new_' + Date.now();
    const html = `
    <div class="day-card day-block bg-white border-success">
        <div class="day-card-header bg-success text-white">
            <div class="d-flex align-items-center w-100 me-2">
                <span class="badge bg-white text-success me-2">Mới</span>
                <input type="text" name="schedule[${tempId}][tieu_de]" class="form-control form-control-sm fw-bold border-0 bg-transparent text-white p-0" placeholder="Nhập tiêu đề ngày..." style="color:white !important;">
            </div>
            <button type="button" class="btn btn-sm text-white" onclick="this.closest('.day-block').remove()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="p-3">
            <input type="text" name="schedule[${tempId}][mo_ta]" class="form-control form-control-sm mb-2" placeholder="Mô tả...">
            <div class="activities-wrapper"></div>
            <button type="button" class="btn btn-sm btn-light text-success w-100 mt-2 border" onclick="addActivity(this, '${tempId}')">Thêm hoạt động</button>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function addActivity(btn, dayKey) {
    const wrapper = btn.previousElementSibling;
    const tempActId = 'new_act_' + Date.now() + Math.floor(Math.random() * 100);
    const html = `
    <div class="activity-item d-flex gap-2 align-items-center border-start border-3 border-success ps-2">
        <div class="d-flex flex-column gap-1" style="width: 140px;">
            <input type="time" name="schedule[${dayKey}][activities][${tempActId}][thoi_gian_bat_dau]" class="form-control form-control-sm">
            <input type="time" name="schedule[${dayKey}][activities][${tempActId}][thoi_gian_ket_thuc]" class="form-control form-control-sm">
        </div>
        <div class="flex-grow-1">
            <input type="text" name="schedule[${dayKey}][activities][${tempActId}][hoat_dong]" class="form-control form-control-sm fw-bold mb-1" placeholder="Hoạt động...">
            <input type="text" name="schedule[${dayKey}][activities][${tempActId}][dia_diem]" class="form-control form-control-sm text-success" placeholder="Tại đâu...">
        </div>
        <button type="button" class="btn btn-sm text-secondary" onclick="this.closest('.activity-item').remove()"><i class="fa-solid fa-xmark"></i></button>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
}

// --- JS TÍNH TIỀN (GIỮ NGUYÊN) ---
document.addEventListener("DOMContentLoaded", function(){
    // ... (Giữ nguyên logic tính tiền, thêm khách như file cũ)
    const custTable = document.getElementById("custTable").querySelector("tbody");
    const totalMoneyInput = document.getElementById("totalMoney");
    const phatSinhInput = document.getElementById("phatSinh");
    const paidInput = document.getElementById("paidAmount");
    const payMoreInput = document.getElementById("payMoreInput");
    const remainText = document.getElementById("remainText");
    let idx = 9000; 

    document.getElementById("addCustBtn").addEventListener("click", function(){
        const row = custTable.insertRow();
        row.className = "cust-row";
        row.innerHTML = `<td><input type="text" name="customers[${idx}][name]" class="form-control form-control-sm fw-bold" required></td><td><input type="text" name="customers[${idx}][phone]" class="form-control form-control-sm"></td><td><input type="number" name="customers[${idx}][age]" class="form-control form-control-sm age-input" required></td><td><select name="customers[${idx}][gender]" class="form-select form-select-sm"><option>Nam</option><option>Nữ</option></select></td><td><input type="number" name="customers[${idx}][price]" class="form-control form-control-sm fw-bold text-end price-input text-success" value="0"></td><td class="text-center"><button type="button" class="btn btn-outline-danger btn-sm del-row"><i class="fa-solid fa-trash"></i></button></td>`;
        idx++; updateTotal();
    });

    custTable.addEventListener("click", function(e){ if(e.target.closest(".del-row")){ if(confirm("Xóa?")) { e.target.closest("tr").remove(); updateTotal(); } } });
    custTable.addEventListener("input", function(e){ if(e.target.classList.contains("price-input")) updateTotal(); });
    phatSinhInput.addEventListener("input", updateTotal);
    payMoreInput.addEventListener("input", updateTotal);

    function updateTotal(){
        let sum = 0;
        document.querySelectorAll(".price-input").forEach(el => { let val = parseFloat(el.value); if(!isNaN(val)) sum += val; });
        totalMoneyInput.value = sum;
        const ps = parseFloat(phatSinhInput.value) || 0;
        const paid = parseFloat(paidInput.dataset.raw) || 0;
        const more = parseFloat(payMoreInput.value.replace(/,/g, '')) || 0;
        const totalDue = sum + ps;
        const remain = totalDue - (paid + more);
        
        if(remain > 0) { remainText.innerHTML = `<span class="text-danger">THIẾU: ${new Intl.NumberFormat('vi-VN').format(remain)} đ</span>`; }
        else if (remain < 0) { remainText.innerHTML = `<span class="text-primary">DƯ: ${new Intl.NumberFormat('vi-VN').format(Math.abs(remain))} đ</span>`; }
        else { remainText.innerHTML = `<span class="text-success">ĐỦ TIỀN</span>`; }
    }
    updateTotal();
});
</script>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>
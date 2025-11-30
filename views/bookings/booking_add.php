<?php include PATH_VIEW . 'layouts/header.php'; ?>
<div class="container mt-4 mb-5">
    <h3 class="fw-bold text-primary mb-3">Thêm Booking Mới</h3>
    <?php if (isset($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

    <form method="post" id="bookingForm" class="card shadow p-4">
        <h5 class="section-title border-bottom pb-2 text-info">1. Thông tin Tour & Thời gian</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Chọn Tour <span class="text-danger">*</span></label>
                <select name="tour_id" id="tourSelect" class="form-select" required>
                    <option value="">-- Chọn Tour --</option>
                    <?php foreach ($tours as $t): ?>
                        <option value="<?= $t['id'] ?>" data-type="<?= $t['loai_tour'] ?>" data-price="<?= $t['gia_tour'] ?>">
                            <?= $t['ten_tour'] ?> (<?= $t['loai_tour'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" id="tourType" name="tour_type">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Ngày Khởi Hành</label>
                <input type="date" name="ngay_khoi_hanh" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Hướng Dẫn Viên</label>
                <select name="hdv_id" class="form-select" required>
                    <?php foreach ($hdvs as $h): ?><option value="<?= $h['id'] ?>"><?= $h['ho_ten'] ?></option><?php endforeach; ?>
                </select>
            </div>
        </div>

        <h5 class="section-title border-bottom pb-2 text-info">2. Thông tin Người đặt & Khách hàng</h5>
        <div class="row g-3 mb-3">
            <div class="col-md-6"><input type="text" name="customer_name" id="mainName" class="form-control" placeholder="Tên người đặt" required></div>
            <div class="col-md-6"><input type="text" name="customer_phone" id="mainPhone" class="form-control" placeholder="SĐT liên hệ" required></div>
        </div>
        <table class="table table-bordered align-middle" id="custTable">
            <thead class="table-light"><tr><th>Họ tên</th><th>Tuổi</th><th>Giới tính</th><th>CCCD</th><th>Giá vé</th><th>#</th></tr></thead>
            <tbody>
                <tr>
                    <td><input type="text" name="customers[0][name]" id="row0Name" class="form-control" required></td>
                    <td><input type="number" name="customers[0][age]" class="form-control" placeholder="Tuổi" required></td>
                    <td><select name="customers[0][gender]" class="form-select"><option>Nam</option><option>Nữ</option></select></td>
                    <td><input type="text" name="customers[0][cccd]" class="form-control"></td>
                    <td><input type="number" name="customers[0][price]" class="form-control price-input" value="0"></td>
                    <td><span class="badge bg-secondary">Trưởng đoàn</span></td>
                    <input type="hidden" name="customers[0][phone]" id="row0Phone">
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-outline-primary mb-4" id="addCustBtn">+ Thêm khách</button>

        <h5 class="section-title border-bottom pb-2 text-info">3. Tài chính & Trạng thái</h5>
        <div class="row g-3 bg-light p-3 rounded border mb-4">
            <div class="col-md-3"><label>Tổng khách</label><input type="text" name="so_luong" id="totalPax" class="form-control fw-bold bg-white" readonly></div>
            <div class="col-md-3"><label class="text-danger fw-bold">TỔNG TIỀN</label><input type="text" name="tong_tien" id="totalMoney" class="form-control fw-bold text-danger bg-white" readonly></div>
            <div class="col-md-3"><label>Đã Cọc</label><input type="number" name="tien_da_coc" class="form-control" value="0"></div>
            <div class="col-md-3">
                <label>Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="Chờ xử lý">Chờ xử lý</option>
                    <option value="Đã cọc">Đã cọc</option>
                    <option value="Hoàn tất">Hoàn tất</option>
                </select>
            </div>
            <div class="col-md-6"><label>Phát sinh</label><input type="number" name="chi_phi_phat_sinh" class="form-control" value="0"></div>
            <div class="col-md-6"><label>Lý do</label><input type="text" name="ly_do_phat_sinh" class="form-control"></div>
        </div>

        <h5 class="section-title border-bottom pb-2 text-info">
            4. Lịch trình chi tiết <span id="tourTypeBadge" class="badge bg-secondary"></span>
        </h5>
        
        <div id="customControls" class="mb-2 d-none">
            <button type="button" class="btn btn-success btn-sm" id="addDayBtn"><i class="fa-solid fa-calendar-plus"></i> Thêm Ngày Mới</button>
        </div>

        <div id="scheduleBox" class="mb-3 border p-3 rounded bg-white">
            <p class="text-muted fst-italic">Vui lòng chọn tour để hiển thị lịch trình...</p>
        </div>

        <div class="row">
            <div class="col-md-6"><label>Khách sạn</label><select name="hotel_supplier_id" class="form-select"><option value="">--Chọn--</option><?php foreach($hotels as $h):?><option value="<?=$h['id']?>"><?=$h['name']?></option><?php endforeach;?></select></div>
            <div class="col-md-6"><label>Nhà hàng</label><select name="restaurant_supplier_id" class="form-select"><option value="">--Chọn--</option><?php foreach($restaurants as $r):?><option value="<?=$r['id']?>"><?=$r['name']?></option><?php endforeach;?></select></div>
        </div>

        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-primary btn-lg px-5">XÁC NHẬN BOOKING</button>
            <a href="index.php?action=booking_list" class="btn btn-secondary btn-lg">Quay lại</a>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
    const tourSelect = document.getElementById("tourSelect");
    const scheduleBox = document.getElementById("scheduleBox");
    const customControls = document.getElementById("customControls");
    const addDayBtn = document.getElementById("addDayBtn");
    const custTable = document.getElementById("custTable").querySelector("tbody");

    // Global variable to keep track of day index for custom tours
    let dayIndex = 0;

    // Helper: Create HTML for a Day
    function createDayHTML(index, dayData = {}, isCustom = false) {
        const dayNum = dayData.ngay_thu || (index + 1);
        const title = dayData.tieu_de || `Ngày ${dayNum}`;
        const desc = dayData.mo_ta || '';
        
        let activitiesHTML = '';
        let actIndex = 0;
        
        if (dayData.activities && dayData.activities.length > 0) {
            dayData.activities.forEach((act, j) => {
                activitiesHTML += createActivityRow(index, j, act, isCustom);
                actIndex++;
            });
        }

        let html = `
        <div class="card mb-3 border-info day-container" data-day-index="${index}">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center w-75">
                    <strong class="me-2">Ngày:</strong> 
                    <input type="number" name="schedule[${index}][ngay_thu]" class="form-control form-control-sm w-25 me-2" value="${dayNum}" ${isCustom ? '' : 'readonly'}>
                    ${isCustom 
                        ? `<input type="text" class="form-control form-control-sm w-50" name="schedule[${index}][tieu_de]" value="${title}" placeholder="Tiêu đề ngày...">`
                        : `<span>${title}</span><input type="hidden" name="schedule[${index}][tieu_de]" value="${title}">`
                    }
                </div>
                ${isCustom ? '<button type="button" class="btn btn-sm btn-danger remove-day-btn">Xóa Ngày</button>' : ''}
            </div>
            <div class="card-body p-2">
                <div class="mb-2">
                    <label class="small text-muted">Mô tả:</label>
                    ${isCustom 
                        ? `<textarea class="form-control" name="schedule[${index}][mo_ta]">${desc}</textarea>`
                        : `<p class="mb-0">${desc}</p><input type="hidden" name="schedule[${index}][mo_ta]" value="${desc}">`
                    }
                </div>
                
                <table class="table table-sm table-bordered activity-table">
                    <thead class="table-secondary">
                        <tr><th style="width:15%">Bắt đầu</th><th style="width:15%">Kết thúc</th><th>Hoạt động</th><th>Địa điểm</th>${isCustom ? '<th style="width:5%">#</th>' : ''}</tr>
                    </thead>
                    <tbody>
                        ${activitiesHTML}
                    </tbody>
                </table>
                
                ${isCustom ? `<button type="button" class="btn btn-sm btn-outline-info add-activity-btn" data-day-idx="${index}">+ Thêm Hoạt Động</button>` : ''}
            </div>
        </div>`;
        return html;
    }

    // Helper: Create HTML for an Activity Row
    function createActivityRow(dayIdx, actIdx, actData = {}, isCustom = false) {
        const start = actData.thoi_gian_bat_dau || '';
        const end = actData.thoi_gian_ket_thuc || '';
        const action = actData.hoat_dong || '';
        const place = actData.dia_diem || '';

        if (isCustom) {
            return `
            <tr>
                <td><input type="time" name="schedule[${dayIdx}][activities][${actIdx}][start]" class="form-control form-control-sm" value="${start}"></td>
                <td><input type="time" name="schedule[${dayIdx}][activities][${actIdx}][end]" class="form-control form-control-sm" value="${end}"></td>
                <td><input type="text" name="schedule[${dayIdx}][activities][${actIdx}][action]" class="form-control form-control-sm" value="${action}"></td>
                <td><input type="text" name="schedule[${dayIdx}][activities][${actIdx}][place]" class="form-control form-control-sm" value="${place}"></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-act-btn">X</button></td>
            </tr>`;
        } else {
            return `
            <tr>
                <td>${start}<input type="hidden" name="schedule[${dayIdx}][activities][${actIdx}][start]" value="${start}"></td>
                <td>${end}<input type="hidden" name="schedule[${dayIdx}][activities][${actIdx}][end]" value="${end}"></td>
                <td>${action}<input type="hidden" name="schedule[${dayIdx}][activities][${actIdx}][action]" value="${action}"></td>
                <td>${place}<input type="hidden" name="schedule[${dayIdx}][activities][${actIdx}][place]" value="${place}"></td>
            </tr>`;
        }
    }

    // Select Tour Handler
    tourSelect.addEventListener("change", function(){
        const opt = this.options[this.selectedIndex];
        if(!opt.value) return;

        const price = opt.getAttribute("data-price") || 0;
        const type = opt.getAttribute("data-type");
        const tourId = this.value;
        const isCustom = (type === 'Theo yêu cầu');

        // Update UI based on type
        document.getElementById("tourTypeBadge").innerText = type;
        document.getElementById("tourType").value = type;
        document.querySelector(".price-input").value = price;
        updateTotal();

        // Show/Hide Custom Controls
        if (isCustom) {
            customControls.classList.remove('d-none');
        } else {
            customControls.classList.add('d-none');
        }

        // AJAX Fetch Schedule
        fetch(`index.php?action=ajax_get_tour&tour_id=${tourId}`)
        .then(res => res.json())
        .then(data => {
            let html = "";
            dayIndex = 0; // Reset index

            if(data.schedule && data.schedule.length > 0){
                data.schedule.forEach((d) => {
                    html += createDayHTML(dayIndex, d, isCustom);
                    dayIndex++;
                });
            } else {
                if(!isCustom) html = "<p class='text-warning'>Tour này chưa có lịch trình mẫu.</p>";
            }

            // Prepend alert message
            if(isCustom){
                html = `<div class="alert alert-success mb-3"><i class="fa-solid fa-pen-to-square"></i> Tour Theo Yêu Cầu: Bạn có thể thêm ngày, giờ và hoạt động tùy ý.</div>` + html;
            } else {
                html = `<div class="alert alert-secondary mb-3"><i class="fa-solid fa-lock"></i> Tour Cố Định: Lịch trình được đồng bộ tự động.</div>` + html;
            }
            
            scheduleBox.innerHTML = html;
        });
    });

    // --- Dynamic Events for Custom Schedule ---
    
    // 1. Add New Day
    addDayBtn.addEventListener("click", function() {
        const newDayHTML = createDayHTML(dayIndex, {}, true);
        scheduleBox.insertAdjacentHTML('beforeend', newDayHTML);
        dayIndex++;
    });

    // 2. Add Activity & Remove Day/Activity (Event Delegation)
    scheduleBox.addEventListener("click", function(e) {
        // Add Activity
        if (e.target.classList.contains('add-activity-btn')) {
            const dayIdx = e.target.getAttribute('data-day-idx');
            const tableBody = e.target.closest('.card-body').querySelector('.activity-table tbody');
            const newRowIdx = tableBody.children.length;
            const newRowHTML = createActivityRow(dayIdx, newRowIdx, {}, true);
            tableBody.insertAdjacentHTML('beforeend', newRowHTML);
        }
        
        // Remove Activity
        if (e.target.classList.contains('remove-act-btn')) {
            if(confirm('Xóa hoạt động này?')) {
                e.target.closest('tr').remove();
            }
        }

        // Remove Day
        if (e.target.classList.contains('remove-day-btn')) {
            if(confirm('Xóa toàn bộ ngày này?')) {
                e.target.closest('.day-container').remove();
            }
        }
    });


    // --- Customer Table Logic (Existing) ---
    let idx = 1;
    document.getElementById("addCustBtn").addEventListener("click", function(){
        const row = custTable.insertRow();
        row.innerHTML = `<td><input type="text" name="customers[${idx}][name]" class="form-control" required></td>
            <td><input type="number" name="customers[${idx}][age]" class="form-control" required></td>
            <td><select name="customers[${idx}][gender]" class="form-select"><option>Nam</option><option>Nữ</option></select></td>
            <td><input type="text" name="customers[${idx}][cccd]" class="form-control"></td>
            <td><input type="number" name="customers[${idx}][price]" class="form-control price-input" value="0"></td>
            <td><button type="button" class="btn btn-danger btn-sm del-row">X</button></td>`;
        idx++;
        updateTotal();
    });
    custTable.addEventListener("click", function(e){ if(e.target.closest(".del-row")){ e.target.closest("tr").remove(); updateTotal(); } });
    custTable.addEventListener("input", function(e){ if(e.target.classList.contains("price-input")) updateTotal(); });
    document.getElementById("mainName").addEventListener("input", function(){ document.getElementById("row0Name").value = this.value; });
    document.getElementById("mainPhone").addEventListener("input", function(){ document.getElementById("row0Phone").value = this.value; });
    
    function updateTotal(){
        let sum = 0, count = 0;
        document.querySelectorAll(".price-input").forEach(el => { let val = parseFloat(el.value); if(!isNaN(val)) { sum += val; count++; } });
        document.getElementById("totalMoney").value = sum;
        document.getElementById("totalPax").value = count;
    }
});
</script>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>
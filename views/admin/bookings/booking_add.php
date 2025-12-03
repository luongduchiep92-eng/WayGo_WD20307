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
                <input type="date" name="ngay_khoi_hanh" id="startDate" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Phương tiện</label>
                <input type="text" name="phuong_tien" class="form-control" placeholder="Xe, Máy bay...">
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold">Hướng Dẫn Viên (Check lịch & Loại tour)</label>
                <select name="hdv_id" id="hdvSelect" class="form-select" required>
                    <option value="">-- Chọn Tour & Ngày trước --</option>
                </select>
            </div>
        </div>

        <h5 class="section-title border-bottom pb-2 text-info">2. Thông tin Người đặt & Khách hàng</h5>
        <div class="row g-3 mb-3">
            <div class="col-md-6"><input type="text" name="customer_name" id="mainName" class="form-control" placeholder="Tên người đặt" required></div>
            <div class="col-md-6"><input type="text" name="customer_phone" id="mainPhone" class="form-control" placeholder="SĐT liên hệ" required></div>
        </div>
        
        <table class="table table-bordered align-middle" id="custTable">
            <thead class="table-light"><tr><th>Họ tên</th><th>SĐT Khách</th><th>Tuổi</th><th>Giới tính</th><th>CCCD</th><th>Giá vé</th><th>#</th></tr></thead>
            <tbody>
                <tr>
                    <td><input type="text" name="customers[0][name]" id="row0Name" class="form-control" required></td>
                    <td><input type="text" name="customers[0][phone]" id="row0Phone" class="form-control" placeholder="SĐT"></td>
                    <td><input type="number" name="customers[0][age]" class="form-control" style="width:80px"></td>
                    <td><select name="customers[0][gender]" class="form-select"><option>Nam</option><option>Nữ</option></select></td>
                    <td><input type="text" name="customers[0][cccd]" class="form-control"></td>
                    <td><input type="number" name="customers[0][price]" class="form-control price-input" value="0"></td>
                    <td><span class="badge bg-secondary">Trưởng đoàn</span></td>
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

        <h5 class="section-title border-bottom pb-2 text-info">4. Lịch trình chi tiết</h5>
        <div id="scheduleBox" class="mb-3 border p-3 rounded bg-white"><p class="text-muted">Vui lòng chọn tour...</p></div>

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
    const startDateInput = document.getElementById("startDate");
    const hdvSelect = document.getElementById("hdvSelect");
    const scheduleBox = document.getElementById("scheduleBox");
    const custTable = document.getElementById("custTable").querySelector("tbody");

    // [MỚI] Hàm Ajax load HDV
    function loadHdvs() {
        const date = startDateInput.value;
        const opt = tourSelect.options[tourSelect.selectedIndex];
        const type = opt ? opt.getAttribute('data-type') : '';

        if(date && type) {
            hdvSelect.innerHTML = '<option>Đang check lịch HDV...</option>';
            fetch(`index.php?action=ajax_get_hdv_avail&date=${date}&type=${type}`)
            .then(res => res.json())
            .then(data => {
                hdvSelect.innerHTML = '<option value="">-- Chọn HDV --</option>';
                if(data.length > 0) {
                    data.forEach(h => {
                        hdvSelect.innerHTML += `<option value="${h.id}">${h.ho_ten} (${h.loai_hdv})</option>`;
                    });
                } else {
                    hdvSelect.innerHTML = '<option value="">Không có HDV phù hợp!</option>';
                }
            });
        }
    }

    tourSelect.addEventListener("change", function(){
        const opt = this.options[this.selectedIndex];
        if(!opt.value) return;
        const price = opt.getAttribute("data-price") || 0;
        const type = opt.getAttribute("data-type");
        const tourId = this.value;

        document.querySelector(".price-input").value = price;
        updateTotal();
        loadHdvs(); // Load HDV khi chọn tour

        // Load lịch trình (Giữ nguyên)
        fetch(`index.php?action=ajax_get_tour&tour_id=${tourId}`)
        .then(res => res.json())
        .then(data => {
            let html = "";
            if(data.schedule && data.schedule.length > 0){
                data.schedule.forEach((d) => {
                    let acts = "";
                    if(d.activities) d.activities.forEach(a => acts += `<li>${a.thoi_gian_bat_dau} - ${a.thoi_gian_ket_thuc}: ${a.hoat_dong}</li>`);
                    html += `<div class="mb-2"><strong>Ngày ${d.ngay_thu}: ${d.tieu_de}</strong><ul class="small text-muted">${acts}</ul></div>`;
                });
            } else { html = "Chưa có lịch trình."; }
            scheduleBox.innerHTML = html;
        });
    });

    startDateInput.addEventListener("change", loadHdvs); // Load HDV khi đổi ngày

    // [MỚI] Thêm dòng khách có SĐT
    let idx = 1;
    document.getElementById("addCustBtn").addEventListener("click", function(){
        const row = custTable.insertRow();
        row.innerHTML = `
            <td><input type="text" name="customers[${idx}][name]" class="form-control" required></td>
            <td><input type="text" name="customers[${idx}][phone]" class="form-control"></td>
            <td><input type="number" name="customers[${idx}][age]" class="form-control" style="width:80px"></td>
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
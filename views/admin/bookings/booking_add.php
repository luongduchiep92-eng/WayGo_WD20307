<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><i class="fa-solid fa-plus-circle me-2"></i>Thêm Booking Mới</h1>
        <p class="text-muted mb-0">Tạo phiếu đặt tour mới cho khách hàng</p>
    </div>
    <a href="index.php?action=booking_list" class="btn btn-secondary shadow-sm fw-bold">
        <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger shadow-sm border-left-danger">
        <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= $error ?>
    </div>
<?php endif; ?>

<form method="post" id="bookingForm" class="mb-5">
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-modern mb-4">
                <div class="card-header bg-white py-3 fw-bold text-primary border-bottom">
                    <i class="fa-solid fa-map me-2"></i> 1. Thông tin Tour & Lịch trình
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Chọn Tour <span class="text-danger">*</span></label>
                            <select name="tour_id" id="tourSelect" class="form-select form-select-lg fw-bold text-primary" required>
                                <option value="" data-price="0">-- Vui lòng chọn Tour --</option>
                                <?php foreach ($tours as $t): ?>
                                    <option value="<?= $t['id'] ?>" data-type="<?= $t['loai_tour'] ?>" data-price="<?= $t['gia_tour'] ?>">
                                        <?= $t['ten_tour'] ?> (Giá: <?= number_format($t['gia_tour']) ?> đ)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" id="tourType" name="tour_type">
                            <input type="hidden" id="basePrice" value="0"> </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Ngày Khởi Hành</label>
                            <input type="date" name="ngay_khoi_hanh" id="startDate" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phương tiện</label>
                            <input type="text" name="phuong_tien" class="form-control" placeholder="Xe, Máy bay...">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Hướng Dẫn Viên (Check lịch tự động)</label>
                            <select name="hdv_id" id="hdvSelect" class="form-select bg-light">
                                <option value="">-- Chọn Tour & Ngày trước để kiểm tra --</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Tóm tắt lịch trình:</label>
                        <div id="scheduleBox" class="p-3 bg-light rounded border text-muted small" style="min-height: 100px;">
                            Vui lòng chọn tour để xem trước lịch trình...
                        </div>
                    </div>
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
                            <thead class="table-light text-secondary">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Họ tên <span class="text-danger">*</span></th>
                                    <th width="15%">SĐT</th>
                                    <th width="10%">Tuổi</th>
                                    <th width="15%">Giới tính</th>
                                    <th width="20%">Giá vé (VND)</th>
                                    <th width="10%">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="cust-row">
                                    <td class="text-center fw-bold text-muted">1</td>
                                    <td><input type="text" name="customers[0][name]" id="row0Name" class="form-control form-control-sm fw-bold" placeholder="Tên khách..." required></td>
                                    <td><input type="text" name="customers[0][phone]" id="row0Phone" class="form-control form-control-sm" placeholder="SĐT"></td>
                                    <td><input type="number" name="customers[0][age]" class="form-control form-control-sm age-input" placeholder="Tuổi" required></td>
                                    <td>
                                        <select name="customers[0][gender]" class="form-select form-select-sm">
                                            <option>Nam</option><option>Nữ</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="customers[0][price]" class="form-control form-control-sm fw-bold text-end price-input text-success" value="0">
                                        <input type="hidden" name="customers[0][cccd]">
                                    </td>
                                    <td class="text-center"><button type="button" class="btn btn-outline-secondary btn-sm" disabled><i class="fa-solid fa-lock"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <small class="text-muted fst-italic">* Nhập tuổi để tự động tính giá (Dưới 3 tuổi giảm 50%)</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-modern mb-4">
                <div class="card-header bg-white py-3 fw-bold text-warning border-bottom">
                    <i class="fa-solid fa-file-invoice-dollar me-2"></i> 3. Thông tin Đặt & Thanh toán
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Người đặt tour</label>
                        <input type="text" name="customer_name" id="mainName" class="form-control" placeholder="Tên người liên hệ..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Số điện thoại chính</label>
                        <input type="text" name="customer_phone" id="mainPhone" class="form-control" placeholder="SĐT liên hệ..." required>
                    </div>
                    <hr>
                    
                    <div class="mb-3 row align-items-center">
                        <label class="col-6 col-form-label">Tổng khách:</label>
                        <div class="col-6">
                            <input type="text" name="so_luong" id="totalPax" class="form-control text-center fw-bold" readonly value="1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">TỔNG TIỀN (Tạm tính)</label>
                        <div class="input-group">
                            <input type="text" name="tong_tien" id="totalMoney" class="form-control fw-bold text-primary fs-4 text-end" readonly value="0">
                            <span class="input-group-text fw-bold text-primary">đ</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Đã đặt cọc</label>
                        <input type="number" name="tien_da_coc" class="form-control text-end fw-bold text-success" value="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Trạng thái booking</label>
                        <select name="status" class="form-select">
                            <option value="Chờ xử lý">Chờ xử lý</option>
                            <option value="Đã cọc">Đã cọc</option>
                            <option value="Hoàn tất">Hoàn tất</option>
                        </select>
                    </div>
                    
                    <hr>
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted">Chi phí phát sinh (nếu có)</label>
                        <input type="number" name="chi_phi_phat_sinh" class="form-control form-control-sm text-end" value="0">
                    </div>
                    <div class="mb-2">
                        <input type="text" name="ly_do_phat_sinh" class="form-control form-control-sm" placeholder="Lý do phát sinh...">
                    </div>
                </div>
            </div>

            <div class="card card-modern mb-4">
                <div class="card-header bg-white py-3 fw-bold text-secondary border-bottom">
                    <i class="fa-solid fa-truck-field me-2"></i> Dịch vụ (Option)
                </div>
                <div class="card-body p-3">
                    <div class="mb-3">
                        <label class="form-label small">Khách sạn</label>
                        <select name="hotel_supplier_id" class="form-select form-select-sm">
                            <option value="">-- Chưa chọn --</option>
                            <?php foreach($hotels as $h):?>
                                <option value="<?=$h['id']?>"><?=$h['name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label small">Nhà hàng</label>
                        <select name="restaurant_supplier_id" class="form-select form-select-sm">
                            <option value="">-- Chưa chọn --</option>
                            <?php foreach($restaurants as $r):?>
                                <option value="<?=$r['id']?>"><?=$r['name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mt-4 mb-5 border-top pt-4">
        <a href="index.php?action=booking_list" class="btn btn-outline-secondary fw-bold px-4 me-2">
            <i class="fa-solid fa-times me-1"></i> Hủy
        </a>
        <button type="submit" class="btn btn-success fw-bold px-5 py-2 shadow-sm text-uppercase">
            <i class="fa-solid fa-check-circle me-2"></i> Xác nhận Booking
        </button>
    </div>

</form>

<script>
document.addEventListener("DOMContentLoaded", function(){
    const tourSelect = document.getElementById("tourSelect");
    const startDateInput = document.getElementById("startDate");
    const hdvSelect = document.getElementById("hdvSelect");
    const scheduleBox = document.getElementById("scheduleBox");
    const custTable = document.getElementById("custTable").querySelector("tbody");
    const basePriceInput = document.getElementById("basePrice");

    // 1. XỬ LÝ KHI CHỌN TOUR
    tourSelect.addEventListener("change", function(){
        const opt = this.options[this.selectedIndex];
        if(!opt.value) return;
        
        // Lấy giá và cập nhật giá gốc
        const price = parseFloat(opt.getAttribute("data-price")) || 0;
        basePriceInput.value = price;
        const type = opt.getAttribute("data-type");
        const tourId = this.value;

        // Cập nhật lại giá cho toàn bộ danh sách khách hiện tại dựa trên tuổi
        recalcAllRows();

        // Load HDV & Lịch trình
        loadHdvs(); 
        fetch(`index.php?action=ajax_get_tour&tour_id=${tourId}`)
        .then(res => res.json())
        .then(data => {
            let html = "";
            if(data.schedule && data.schedule.length > 0){
                data.schedule.forEach((d) => {
                    let acts = "";
                    if(d.activities) d.activities.forEach(a => acts += `<div class="ms-3 text-dark">- ${a.thoi_gian_bat_dau.substring(0,5)}: ${a.hoat_dong}</div>`);
                    html += `<div class="mb-2"><strong>Ngày ${d.ngay_thu}: ${d.tieu_de}</strong>${acts}</div>`;
                });
            } else { html = "<span class='text-muted'>Chưa có lịch trình chi tiết.</span>"; }
            scheduleBox.innerHTML = html;
        });
    });

    startDateInput.addEventListener("change", loadHdvs);

    // Hàm load HDV rảnh
    function loadHdvs() {
        const date = startDateInput.value;
        const opt = tourSelect.options[tourSelect.selectedIndex];
        const type = opt ? opt.getAttribute('data-type') : '';

        if(date && type) {
            hdvSelect.innerHTML = '<option>Đang kiểm tra...</option>';
            fetch(`index.php?action=ajax_get_hdv_avail&date=${date}&type=${type}`)
            .then(res => res.json())
            .then(data => {
                hdvSelect.innerHTML = '<option value="">-- Chọn HDV phù hợp --</option>';
                if(data.length > 0) {
                    data.forEach(h => {
                        hdvSelect.innerHTML += `<option value="${h.id}">${h.ho_ten} (${h.loai_hdv})</option>`;
                    });
                } else {
                    hdvSelect.innerHTML = '<option value="">⚠️ Không có HDV rảnh ngày này!</option>';
                }
            });
        }
    }

    // 2. XỬ LÝ THÊM DÒNG KHÁCH
    let idx = 1;
    document.getElementById("addCustBtn").addEventListener("click", function(){
        const row = custTable.insertRow();
        row.className = "cust-row";
        row.innerHTML = `
            <td class="text-center text-muted fw-bold">${idx + 1}</td>
            <td><input type="text" name="customers[${idx}][name]" class="form-control form-control-sm fw-bold" required></td>
            <td><input type="text" name="customers[${idx}][phone]" class="form-control form-control-sm"></td>
            <td><input type="number" name="customers[${idx}][age]" class="form-control form-control-sm age-input" required></td>
            <td><select name="customers[${idx}][gender]" class="form-select form-select-sm"><option>Nam</option><option>Nữ</option></select></td>
            <td><input type="number" name="customers[${idx}][price]" class="form-control form-control-sm fw-bold text-end price-input text-success" value="0"><input type="hidden" name="customers[${idx}][cccd]"></td>
            <td class="text-center"><button type="button" class="btn btn-outline-danger btn-sm del-row"><i class="fa-solid fa-trash"></i></button></td>`;
        idx++;
        updateTotal();
    });

    // 3. XỬ LÝ SỰ KIỆN TRÊN BẢNG (XÓA & NHẬP TUỔI)
    custTable.addEventListener("click", function(e){ 
        if(e.target.closest(".del-row")){ 
            e.target.closest("tr").remove(); 
            updateTotal(); 
        } 
    });

    // Lắng nghe sự kiện nhập tuổi để tính tiền
    custTable.addEventListener("input", function(e){
        if(e.target.classList.contains("age-input")) {
            const row = e.target.closest("tr");
            calculateRowPrice(row);
            updateTotal();
        }
        // Nếu sửa trực tiếp giá
        if(e.target.classList.contains("price-input")) {
            updateTotal();
        }
    });

    // Đồng bộ tên người đặt vào dòng đầu tiên
    document.getElementById("mainName").addEventListener("input", function(){ document.getElementById("row0Name").value = this.value; });
    document.getElementById("mainPhone").addEventListener("input", function(){ document.getElementById("row0Phone").value = this.value; });

    // 4. HÀM TÍNH TOÁN LOGIC GIÁ
    function calculateRowPrice(row) {
        const ageInput = row.querySelector(".age-input");
        const priceInput = row.querySelector(".price-input");
        const basePrice = parseFloat(basePriceInput.value) || 0;
        
        const age = parseInt(ageInput.value);

        if (basePrice > 0 && !isNaN(age)) {
            if (age < 3) {
                // Dưới 3 tuổi: Giảm 50%
                priceInput.value = basePrice * 0.5;
            } else {
                // Từ 3 tuổi trở lên: Giá gốc
                priceInput.value = basePrice;
            }
        }
    }

    function recalcAllRows() {
        const rows = custTable.querySelectorAll("tr");
        rows.forEach(row => calculateRowPrice(row));
        updateTotal();
    }

    function updateTotal(){
        let sum = 0, count = 0;
        document.querySelectorAll(".price-input").forEach(el => { 
            let val = parseFloat(el.value); 
            if(!isNaN(val)) { sum += val; } 
        });
        // Đếm số dòng
        count = document.querySelectorAll(".cust-row").length;

        document.getElementById("totalMoney").value = sum; 
        
        document.getElementById("totalPax").value = count;
    }
});
</script>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>
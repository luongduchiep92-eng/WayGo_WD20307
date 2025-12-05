<?php include(PATH_VIEW . 'layouts/header.php'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
         <h1 class="h3 mb-0 text-gray-800 fw-bold">Thêm Tour Mới</h1>
         <p class="text-muted mb-0">Nhập thông tin chi tiết cho tour du lịch</p>
    </div>
    <a href="index.php?action=tour_list" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

<form action="" method="POST" id="addTourForm" class="pb-5">

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="m-0 fw-bold"><i class="fa-solid fa-info-circle me-2"></i>Thông tin cơ bản</h6>
        </div>
        <div class="card-body">
             <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-bold">Tên tour <span class="text-danger">*</span></label>
                    <input type="text" name="ten_tour" class="form-control" placeholder="Nhập tên tour..." required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Loại tour</label>
                    <select name="loai_tour" class="form-select" required>
                        <option value="">-- Chọn --</option>
                        <option value="Trong nước">Trong nước</option>
                        <option value="Quốc tế">Quốc tế</option>
                        <option value="Theo yêu cầu">Theo yêu cầu</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="Hoạt động">Hoạt động</option>
                        <option value="Đang tạm dừng">Đang tạm dừng</option>
                    </select>
                </div>
                 <div class="col-md-4">
                    <label class="form-label fw-bold">Giá tour (VNĐ)</label>
                    <input type="number" name="gia_tour" class="form-control" value="0" min="0" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Địa điểm khởi hành</label>
                    <input type="text" name="dia_diem" class="form-control" placeholder="VD: Hà Nội, TP.HCM..." required>
                </div>
                 <div class="col-md-3">
                    <label class="form-label">Thời lượng</label>
                    <input type="text" name="thoi_gian" class="form-control" placeholder="VD: 3N2Đ" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Số khách tối đa</label>
                    <input type="number" name="so_nguoi_toi_da" class="form-control" value="20" min="1">
                </div>
                <div class="col-12">
                    <label class="form-label">Phương tiện di chuyển</label>
                    <input type="text" name="phuong_tien" class="form-control" placeholder="VD: Xe du lịch, Máy bay...">
                </div>
                <div class="col-12">
                    <label class="form-label">Mô tả giới thiệu</label>
                    <textarea name="mo_ta" class="form-control" rows="3" placeholder="Nhập mô tả chi tiết về tour..."></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-2">
            <h6 class="m-0 fw-bold text-primary">Thư viện ảnh</h6>
        </div>
        <div class="card-body">
            <div id="images-container">
                <div class="input-group mb-2 img-wrapper">
                    <input type="text" name="images[]" class="form-control" placeholder="Dán link ảnh (URL) vào đây...">
                    <button type="button" class="btn btn-outline-danger remove-img-btn" onclick="this.closest('.img-wrapper').remove()">Xóa</button>
                </div>
            </div>
            <button type="button" id="add-image-btn" class="btn btn-sm btn-outline-primary mt-2">
                <i class="fa-solid fa-plus"></i> Thêm link ảnh
            </button>
        </div>
    </div>

    <h4 class="fw-bold text-dark mb-3">Lịch trình chi tiết</h4>
    
    <div id="schedule-container">
        </div>

    <button type="button" class="btn btn-outline-success w-100 py-2 border-dashed mb-5" onclick="addNewDay()">
        <i class="fa-solid fa-calendar-plus me-1"></i> THÊM NGÀY MỚI
    </button>

    <div class="py-4 mt-5 border-top">
        <div class="d-flex justify-content-between align-items-center">
            <a href="index.php?action=tour_list" class="btn btn-white border border-secondary-subtle text-secondary fw-bold px-4">
                <i class="fa-solid fa-xmark me-1"></i> Hủy bỏ
            </a>

            <button type="submit" class="btn btn-success fw-bold text-white px-5 py-2 shadow-sm">
                <i class="fa-solid fa-check me-2"></i> LƯU TOUR MỚI
            </button>
        </div>
    </div>

</form>

<script>
    // --- JS XỬ LÝ FORM ---
    
    // Hàm xóa ngày (Chỉ xóa trên giao diện vì chưa lưu DB)
    function deleteDay(btn) {
        if(!confirm('Xóa ngày này?')) return;
        btn.closest('.day-block').remove();
    }

    // Hàm xóa hoạt động
    function deleteActivity(btn) {
        btn.closest('.activity-item').remove();
    }

    // Hàm thêm ngày mới (Logic giống trang Edit nhưng input name đơn giản hơn)
    function addNewDay() {
        const container = document.getElementById('schedule-container');
        
        // Tạo ID tạm thời để JS phân biệt (dùng timestamp)
        // Controller addTour của bạn đang duyệt mảng schedule theo index, nên name có thể đặt là schedule[tempId]...
        const tempId = 'new_' + Date.now(); 
        
        // Đếm số ngày hiện tại để hiển thị "Ngày 1, Ngày 2..."
        const currentDays = container.querySelectorAll('.day-block').length;
        const nextDayNum = currentDays + 1;

        const html = `
        <div class="card mb-4 day-block border-success">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <span><strong>Ngày ${nextDayNum}</strong> (Mới)</span>
                <button type="button" class="btn btn-sm btn-light text-success fw-bold" onclick="deleteDay(this)">Hủy</button>
            </div>
            <div class="card-body bg-light">
                <div class="row g-2 mb-3">
                        <div class="col-md-6">
                        <label class="form-label small fw-bold">Tiêu đề ngày</label>
                        <input type="text" name="schedule[${tempId}][tieu_de]" class="form-control" placeholder="VD: Ngày tự do" required>
                        </div>
                        <div class="col-md-6">
                        <label class="form-label small fw-bold">Mô tả chung</label>
                        <input type="text" name="schedule[${tempId}][mo_ta]" class="form-control" placeholder="Mô tả ngắn gọn...">
                        </div>
                </div>
                <label class="form-label fw-bold mb-2">Các hoạt động:</label>
                <div class="activities-wrapper"></div>
                <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addActivity(this, '${tempId}')">
                    <i class="fa-solid fa-plus"></i> Thêm hoạt động
                </button>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
    }

    // Hàm thêm hoạt động
    function addActivity(btn, dayKey) {
        const wrapper = btn.previousElementSibling;
        
        // Controller addTour lặp qua activities, ta dùng mảng rỗng [] để PHP tự đánh index
        // Hoặc dùng tempId nếu controller cần key
        const html = `
        <div class="activity-item bg-white p-3 border rounded mb-2 shadow-sm position-relative">
            <div class="row g-2 align-items-end">
                <div class="col-6 col-md-2">
                    <label class="small text-muted mb-1">Giờ bắt đầu</label>
                    <input type="time" name="schedule[${dayKey}][activities][][thoi_gian_bat_dau]" class="form-control">
                </div>
                <div class="col-6 col-md-2">
                    <label class="small text-muted mb-1">Giờ kết thúc</label>
                    <input type="time" name="schedule[${dayKey}][activities][][thoi_gian_ket_thuc]" class="form-control">
                </div>
                <div class="col-md-7">
                    <label class="small text-muted mb-1">Địa điểm</label>
                    <input type="text" name="schedule[${dayKey}][activities][][dia_diem]" class="form-control" placeholder="Tại đâu...">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="deleteActivity(this)" title="Xóa"><i class="fa-solid fa-trash"></i></button>
                </div>
                <div class="col-12 mt-2">
                    <input type="text" name="schedule[${dayKey}][activities][][hoat_dong]" class="form-control fw-bold" placeholder="Nội dung hoạt động (VD: Ăn trưa, Nhận phòng...)">
                </div>
            </div>
        </div>`;
        wrapper.insertAdjacentHTML('beforeend', html);
    }

    // Xử lý thêm ảnh
    document.getElementById('add-image-btn').addEventListener('click', ()=>{
        const container = document.getElementById('images-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2 img-wrapper';
        div.innerHTML = `
            <input type="text" name="images[]" class="form-control" placeholder="Dán link ảnh vào đây...">
            <button type="button" class="btn btn-outline-danger" onclick="this.closest('.img-wrapper').remove()">Xóa</button>
        `;
        container.appendChild(div);
    });
    
    // Tự động thêm sẵn 1 ngày khi vào trang cho tiện
    document.addEventListener("DOMContentLoaded", () => {
        addNewDay(); 
    });
</script>

<?php include(PATH_VIEW . 'layouts/footer.php'); ?>
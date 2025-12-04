<?php include(PATH_VIEW . 'layouts/header.php'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Thêm Tour Mới</h1>
    <a href="index.php?action=tour_list" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Quay lại
    </a>
</div>

<div class="card card-modern">
    <div class="card-body p-4">
        <form action="" method="POST" enctype="multipart/form-data">
            <h5 class="text-primary mb-3 border-bottom pb-2">1. Thông tin cơ bản</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tên tour</label>
                    <input type="text" name="ten_tour" class="form-control" required placeholder="Nhập tên tour...">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Loại tour</label>
                    <select name="loai_tour" class="form-select" required>
                        <option value="">-- Chọn --</option>
                        <option value="Trong nước">Trong nước</option>
                        <option value="Quốc tế">Quốc tế</option>
                        <option value="Theo yêu cầu">Theo yêu cầu</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="Hoạt động">Hoạt động</option>
                        <option value="Đang tạm dừng">Đang tạm dừng</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Địa điểm</label>
                    <input type="text" name="dia_diem" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Thời gian (VD: 3N2Đ)</label>
                    <input type="text" name="thoi_gian" class="form-control" required>
                </div>
                <!-- <div class="col-md-4">
                    <label class="form-label">Ngày khởi hành</label>
                    <input type="date" name="ngay_khoi_hanh" class="form-control" required>
                </div> -->
                <div class="col-md-4">
                    <label class="form-label fw-bold text-success">Giá tour / 1 người (VNĐ)</label>
                    <input type="number" name="gia_tour" class="form-control" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Phương tiện</label>
                    <input type="text" name="phuong_tien" class="form-control" placeholder="Xe, Máy bay...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Số người tối đa</label>
                    <input type="number" name="so_nguoi_toi_da" class="form-control" min="1" value="20">
                </div>
                <div class="col-12">
                    <label class="form-label">Mô tả chi tiết</label>
                    <textarea name="mo_ta" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <h5 class="text-primary mt-4 mb-3 border-bottom pb-2">2. Hình ảnh & Lịch trình</h5>
            <div class="mb-3">
                <label class="form-label fw-bold">Link Hình ảnh (URL)</label>
                <div id="images-container"></div>
                <button type="button" id="add-image-btn" class="btn btn-sm btn-outline-secondary mt-2"><i class="fa-solid fa-image"></i> Thêm link ảnh</button>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Lịch trình chi tiết</label>
                <div id="schedule-container"></div>
                <button type="button" id="add-day-btn" class="btn btn-sm btn-outline-primary mt-2"><i class="fa-solid fa-calendar-plus"></i> Thêm ngày</button>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">LƯU TOUR MỚI</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Copy lại đoạn script JS thêm ngày/hoạt động từ file cũ của bạn vào đây
    // (Đoạn script bắt đầu bằng: let dayCount = 0; ...)
    let dayCount = 0;
    const scheduleContainer = document.getElementById('schedule-container');
    const addDayBtn = document.getElementById('add-day-btn');

    function addDay() {
        dayCount++;
        const dayDiv = document.createElement('div');
        dayDiv.classList.add('card', 'mb-3', 'bg-light');
        dayDiv.innerHTML = `
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-primary">Ngày ${dayCount}</h6>
                    <button type="button" class="btn btn-sm btn-danger remove-day-btn"><i class="fa-solid fa-trash"></i></button>
                </div>
                <input type="text" name="schedule[${dayCount}][tieu_de]" class="form-control mb-2" placeholder="Tiêu đề ngày...">
                <textarea name="schedule[${dayCount}][mo_ta]" class="form-control mb-2" rows="2" placeholder="Mô tả chung..."></textarea>
                
                <div class="activities-container ps-3 border-start border-3 border-info"></div>
                <button type="button" class="btn btn-sm btn-link text-decoration-none add-activity-btn">+ Thêm hoạt động</button>
            </div>
        `;
        scheduleContainer.appendChild(dayDiv);

        dayDiv.querySelector('.add-activity-btn').addEventListener('click', () => {
            const container = dayDiv.querySelector('.activities-container');
            const actCount = container.children.length + 1;
            const actDiv = document.createElement('div');
            actDiv.classList.add('mb-2', 'border-bottom', 'pb-2');
            actDiv.innerHTML = `
                <div class="d-flex gap-2 mb-1">
                    <input type="time" name="schedule[${dayCount}][activities][${actCount}][thoi_gian_bat_dau]" class="form-control form-control-sm">
                    <input type="time" name="schedule[${dayCount}][activities][${actCount}][thoi_gian_ket_thuc]" class="form-control form-control-sm">
                    <input type="text" name="schedule[${dayCount}][activities][${actCount}][dia_diem]" class="form-control form-control-sm" placeholder="Địa điểm">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-activity-btn"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <textarea name="schedule[${dayCount}][activities][${actCount}][hoat_dong]" class="form-control form-control-sm" rows="1" placeholder="Chi tiết hoạt động..."></textarea>
            `;
            container.appendChild(actDiv);
            actDiv.querySelector('.remove-activity-btn').addEventListener('click', ()=>actDiv.remove());
        });

        dayDiv.querySelector('.remove-day-btn').addEventListener('click', ()=>dayDiv.remove());
    }

    addDayBtn.addEventListener('click', ()=>addDay());
    
    // Script thêm ảnh
    const imagesContainer = document.getElementById('images-container');
    document.getElementById('add-image-btn').addEventListener('click', ()=>{
        const div = document.createElement('div');
        div.classList.add('input-group', 'mb-2');
        div.innerHTML = `
            <input type="text" name="images[]" class="form-control" placeholder="Dán link ảnh vào đây...">
            <button type="button" class="btn btn-outline-danger remove-img-btn"><i class="fa-solid fa-trash"></i></button>
        `;
        imagesContainer.appendChild(div);
        div.querySelector('.remove-img-btn').addEventListener('click', ()=> div.remove());
    });
</script>

<?php include(PATH_VIEW . 'layouts/footer.php'); ?>
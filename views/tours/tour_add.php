<?php include(PATH_VIEW . 'layouts/header.php'); ?>

<div class="container mt-4">
    <h2>Thêm tour mới</h2>

    <form action="" method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Tên tour</label>
            <input type="text" name="ten_tour" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Loại tour</label>
            <select name="loai_tour" class="form-select" required>
                <option value="">-- Chọn loại tour --</option>
                <option value="Trong nước">Trong nước</option>
                <option value="Quốc tế">Quốc tế</option>
                <option value="Theo yêu cầu">Theo yêu cầu</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa điểm</label>
            <input type="text" name="dia_diem" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Thời gian</label>
                <input type="text" name="thoi_gian" class="form-control" placeholder="VD: 3N2Đ">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Ngày khởi hành</label>
                <input type="date" name="ngay_khoi_hanh" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Giá tour (VNĐ)</label>
                <input type="number" name="gia_tour" class="form-control" min="0">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Phương tiện</label>
            <input type="text" name="phuong_tien" class="form-control" placeholder="VD: Xe du lịch, máy bay">
        </div>

        <div class="mb-3">
            <label class="form-label">Số người tối đa</label>
            <input type="number" name="so_nguoi_toi_da" class="form-control" min="1">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="mo_ta" class="form-control" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Hình ảnh tour</label>
            <div id="images-container"></div>
            <button type="button" id="add-image-btn" class="btn btn-secondary mt-2">+ Thêm ảnh</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Lịch trình chi tiết</label>
            <div id="schedule-container"></div>
            <button type="button" id="add-day-btn" class="btn btn-primary mt-2">+ Thêm ngày</button>
        </div>

        <button type="submit" class="btn btn-success">Thêm tour</button>
        <a href="index.php?action=tour_list" class="btn btn-secondary">Quay lại</a>
    </form>
</div>


<?php include(PATH_VIEW . 'layouts/footer.php'); ?>

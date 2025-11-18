<?php include(PATH_VIEW . 'layouts/header.php'); ?>

<div class="container mt-4">
    <h2>Sửa tour: <?= $tour->ten_tour ?></h2>
    <form action="" method="POST">
        <!-- Thông tin cơ bản -->
        <div class="mb-3">
            <label>Tên tour</label>
            <input type="text" name="ten_tour" class="form-control" value="<?= $tour->ten_tour ?>">
        </div>

        <div class="mb-3">
            <label>Loại tour</label>
            <select name="loai_tour" class="form-control">
                <option value="Trong nước" <?= $tour->loai_tour=='Trong nước'?'selected':'' ?>>Trong nước</option>
                <option value="Quốc tế" <?= $tour->loai_tour=='Quốc tế'?'selected':'' ?>>Quốc tế</option>
                <option value="Theo yêu cầu" <?= $tour->loai_tour=='Theo yêu cầu'?'selected':'' ?>>Theo yêu cầu</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Địa điểm</label>
            <input type="text" name="dia_diem" class="form-control" value="<?= $tour->dia_diem ?>">
        </div>

        <div class="mb-3">
            <label>Thời gian</label>
            <input type="text" name="thoi_gian" class="form-control" value="<?= $tour->thoi_gian ?>">
        </div>

        <div class="mb-3">
            <label>Ngày khởi hành</label>
            <input type="date" name="ngay_khoi_hanh" class="form-control" value="<?= $tour->ngay_khoi_hanh ?>">
        </div>

        <div class="mb-3">
            <label>Giá tour</label>
            <input type="number" name="gia_tour" class="form-control" value="<?= $tour->gia_tour ?>">
        </div>

        <div class="mb-3">
            <label>Phương tiện</label>
            <input type="text" name="phuong_tien" class="form-control" value="<?= $tour->phuong_tien ?>">
        </div>

        <div class="mb-3">
            <label>Số người tối đa</label>
            <input type="number" name="so_nguoi_toi_da" class="form-control" value="<?= $tour->so_nguoi_toi_da ?>">
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="mo_ta" class="form-control"><?= $tour->mo_ta ?></textarea>
        </div>

        <!-- Hình ảnh tour -->
        <hr>
        <h4>Hình ảnh tour</h4>
        <div class="row mb-3">
            <?php if(!empty($tour->images)): ?>
                <?php foreach($tour->images as $img): ?>
                    <div class="col-md-3 mb-2">
                        <div class="position-relative">
                            <img src="<?= BASE_ASSETS_UPLOADS . $img->image_path ?>" class="img-fluid rounded" alt="Hình tour">
                            <input type="text" name="images_existing[<?= $img->id ?>]" class="form-control mt-1" value="<?= $img->image_path ?>" placeholder="Path hình ảnh">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-img-btn">&times;</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div id="new-images-container"></div>
        <button type="button" class="btn btn-secondary mb-3" id="add-new-image-btn">+ Thêm hình ảnh mới</button>

        <hr>
        <!-- Lịch trình -->
        <h4>Lịch trình tour</h4>
        <?php if(!empty($schedule)): ?>
            <?php foreach($schedule as $day): ?>
                <div class="card mb-3 p-3">
                    <h5>Ngày <?= $day->ngay_thu ?>: <?= $day->tieu_de ?></h5>
                    <input type="text" name="schedule[<?= $day->id ?>][tieu_de]" class="form-control mb-2" value="<?= $day->tieu_de ?>">
                    <textarea name="schedule[<?= $day->id ?>][mo_ta]" class="form-control mb-2"><?= $day->mo_ta ?></textarea>

                    <h6>Hoạt động:</h6>
                    <?php foreach ($day->activities as $act): ?>
                        <div class="mb-2 border p-2">
                            <input type="time" name="schedule[<?= $day->id ?>][activities][<?= $act->id ?>][thoi_gian_bat_dau]" value="<?= $act->thoi_gian_bat_dau ?>">
                            -
                            <input type="time" name="schedule[<?= $day->id ?>][activities][<?= $act->id ?>][thoi_gian_ket_thuc]" value="<?= $act->thoi_gian_ket_thuc ?>">
                            <input type="text" name="schedule[<?= $day->id ?>][activities][<?= $act->id ?>][dia_diem]" value="<?= $act->dia_diem ?>" placeholder="Địa điểm">
                            <textarea name="schedule[<?= $day->id ?>][activities][<?= $act->id ?>][hoat_dong]" placeholder="Hoạt động"><?= $act->hoat_dong ?></textarea>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
        <a href="index.php?action=tour_list<?= $tour->id ?>" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<script src="assets/js/tour_edit.js"></script>

<?php include(PATH_VIEW . 'layouts/footer.php'); ?>

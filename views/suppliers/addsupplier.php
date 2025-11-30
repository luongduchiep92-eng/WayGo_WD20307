<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Thêm Nhà Cung Cấp</h1>
    <a href="index.php?action=listsupplier" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Quay lại
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-modern">
            <div class="card-body p-4">
                <form method="post" action="index.php?action=storesupplier">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên Nhà Cung Cấp <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Ví dụ: Khách sạn Mường Thanh..." required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" placeholder="Nhập SĐT liên hệ">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ cụ thể">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-5 fw-bold">
                            <i class="fa-solid fa-save"></i> LƯU THÔNG TIN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>
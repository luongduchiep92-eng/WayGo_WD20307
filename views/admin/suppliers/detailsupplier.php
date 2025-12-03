<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 fw-bold">Chi tiết Nhà Cung Cấp</h1>
        <div>
            <a href="index.php?action=editsupplier&id=<?= $supplier['id'] ?>" class="btn btn-warning shadow-sm"><i class="fa-solid fa-pen"></i> Sửa</a>
            <a href="index.php?action=listsupplier" class="btn btn-secondary shadow-sm ms-2"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="card card-modern h-100">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 30px;">
                            <i class="fa-solid fa-building"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1"><?= $supplier['name'] ?></h3>
                    <p class="text-muted mb-4">ID: #<?= $supplier['id'] ?></p>
                    
                    <hr>
                    
                    <div class="text-start mt-4">
                        <p class="mb-2"><i class="fa-solid fa-phone me-2 text-primary"></i> <strong>SĐT:</strong> <?= $supplier['phone'] ?></p>
                        <p class="mb-2"><i class="fa-solid fa-envelope me-2 text-primary"></i> <strong>Email:</strong> <?= $supplier['email'] ?></p>
                        <p class="mb-2"><i class="fa-solid fa-location-dot me-2 text-primary"></i> <strong>Địa chỉ:</strong> <?= $supplier['address'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card card-modern h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Thông tin đánh giá & Hợp tác</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="fw-bold d-block mb-2">Đánh giá chất lượng:</label>
                        <div class="fs-4 text-warning">
                            <?php 
                            $rating = $supplier['rating'] ?? 5; // Mặc định 5 sao nếu null
                            for($i=1; $i<=5; $i++) {
                                echo ($i <= $rating) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
                            }
                            ?>
                            <span class="text-muted fs-6 ms-2">(<?= $rating ?>/5)</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold d-block mb-2">Loại hình dịch vụ:</label>
                        <span class="badge bg-info text-dark fs-6 px-3 py-2"><?= $supplier['type'] ?></span>
                    </div>

                    <div class="alert alert-light border">
                        <i class="fa-solid fa-circle-info text-info me-2"></i>
                        Nhà cung cấp này đã hợp tác từ ngày: <strong><?= date('d/m/Y', strtotime($supplier['created_at'])) ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>
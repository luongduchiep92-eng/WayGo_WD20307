<?php require_once "views/layouts/header.php"; ?>

<?php
// Lấy ID nhà cung cấp
$supplier_id = $_GET['id'];

// Kết nối DB
$conn = mysqli_connect("localhost", "root", "", "tour_management_1");

// Lấy nhà cung cấp
$sql = "SELECT * FROM suppliers WHERE id = $supplier_id";
$result = mysqli_query($conn, $sql);
$supplier = mysqli_fetch_assoc($result);

// Nếu không có rating thì mặc định = 0
$rating = $supplier['rating'] ?? 0;
// Nếu không có rank thì mặc định = "Mới"
$rank = $supplier['rank'] ?? "Mới";

// Lấy danh sách tour thuộc NCC
$sqlTours = "
SELECT t.*
FROM tour_suppliers ts
JOIN tours t ON ts.tour_id = t.id
WHERE ts.supplier_id = $supplier_id
";
$tourResult = mysqli_query($conn, $sqlTours);
?>

<div class="container">
    <h2>Chi tiết nhà cung cấp</h2>

    <p><strong>ID:</strong> <?= $supplier['id'] ?></p>
    <p><strong>Tên NCC:</strong> <?= $supplier['name'] ?></p>
    <p><strong>SĐT:</strong> <?= $supplier['phone'] ?></p>
    <p><strong>Email:</strong> <?= $supplier['email'] ?></p>
    <p><strong>Địa chỉ:</strong> <?= $supplier['address'] ?></p>

    <!-- đánh giá nhà cung cấp -->
    <div class="supplier-rating">
        <strong>Đánh giá nhà cung cấp: </strong>
        <?php
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) echo '<span class="star filled">&#9733;</span>';
            else echo '<span class="star">&#9734;</span>';
        }
        ?>
    </div>

    <!-- hạng nhà cung cấp -->
    <div class="supplier-rank">
        <strong>Hạng nhà cung cấp: </strong>
        <?php
        if ($rank == 'VIP') echo '<span class="rank vip">VIP</span>';
        elseif ($rank == 'Thường') echo '<span class="rank normal">Thường</span>';
        else echo '<span class="rank new">Mới</span>';
        ?>
    </div>

    <!-- danh sách tour -->
    <div class="supplier-tours">
        <h3>Danh sách tour đang quản lý</h3>
        <?php
        if (mysqli_num_rows($tourResult) > 0) {
            while ($tour = mysqli_fetch_assoc($tourResult)) {
                echo '<p>• ' . $tour['ten_tour'] .
                    ' – ' . $tour['thoi_gian'] .
                    ' – Giá: ' . number_format($tour['gia_tour'], 0, ",", ".") . ' VND</p>';
            }
        } else {
            echo "<p>Nhà cung cấp này chưa có tour nào.</p>";
        }
        ?>
    </div>

    <a href="index.php?action=listsupplier" class="btn">Quay lại danh sách</a>
</div>

<link rel="stylesheet" href="assets/css/supplier_detail.css">

<?php include PATH_VIEW . 'layouts/footer.php'; ?>
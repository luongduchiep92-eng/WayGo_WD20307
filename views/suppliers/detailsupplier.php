<?php require_once "views/layouts/header.php"; ?>

<?php
// Lấy ID nhà cung cấp từ URL
$supplier_id = $_GET['id'];

// Kết nối DB
$conn = mysqli_connect("localhost", "root", "", "tour_management");

// Lấy thông tin nhà cung cấp
$sql = "SELECT * FROM suppliers WHERE id = $supplier_id";
$result = mysqli_query($conn, $sql);
$supplier = mysqli_fetch_assoc($result);

// Lấy danh sách tour của nhà cung cấp
$sqlTours = "SELECT * FROM tours WHERE supplier_id = $supplier_id";
$tourResult = mysqli_query($conn, $sqlTours);
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f0f2f5, #d9e2ec);
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 700px;
        margin: 50px auto;
        background: #ffffff;
        padding: 40px 50px;
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .container:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.3);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #2c3e50;
        font-weight: 800;
        font-size: 28px;
    }

    p {
        font-size: 16px;
        line-height: 1.6;
        margin: 12px 0;
        color: #555;
    }

    p strong {
        color: #333;
        width: 140px;
        display: inline-block;
    }

    a.btn {
        display: inline-block;
        margin-top: 25px;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        color: #fff;
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 10px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    a.btn:hover {
        background: linear-gradient(135deg, #2575fc, #6a11cb);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    }

    /* đánh giá sao */
    .supplier-rating {
        margin: 15px 0;
    }

    .star {
        font-size: 20px;
        color: #ccc;
        margin-right: 2px;
    }

    .star.filled {
        color: #f1c40f;
    }

    /* hạng NCC */
    .supplier-rank {
        margin: 15px 0;
    }

    .rank {
        padding: 6px 14px;
        border-radius: 8px;
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        display: inline-block;
    }

    .rank.vip {
        background: #e74c3c;
    }

    .rank.normal {
        background: #3498db;
    }

    .rank.new {
        background: #2ecc71;
    }

    /* danh sách tour */
    .supplier-tours {
        margin-top: 25px;
    }

    .supplier-tours h3 {
        margin-bottom: 15px;
        font-size: 20px;
        color: #2c3e50;
        border-bottom: 2px solid #2575fc;
        padding-bottom: 5px;
    }

    .supplier-tours p {
        margin: 8px 0;
        padding: 8px 12px;
        border-left: 4px solid #2575fc;
        background: #f7f9fc;
        border-radius: 6px;
    }

    @media (max-width: 768px) {
        .container {
            padding: 30px 20px;
        }

        h2 {
            font-size: 24px;
        }

        a.btn {
            padding: 10px 20px;
        }
    }
</style>

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
        $rating = $supplier['rating'];
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
        $rank = $supplier['rank'];
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
                echo '<p>• ' . $tour['ten_tour'] . ' – ' . $tour['thoi_gian'] . ' – Giá: ' . number_format($tour['gia_tour'], 0, ",", ".") . ' VND</p>';
            }
        } else {
            echo "<p>Nhà cung cấp này chưa có tour nào.</p>";
        }
        ?>
    </div>

    <a href="index.php?action=listsupplier" class="btn">Quay lại danh sách</a>
    <a href="">honag dz</a>
</div>
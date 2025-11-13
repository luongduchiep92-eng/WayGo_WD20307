<?php require_once "views/layouts/header.php"; ?>

<div class="tour-container">
    <a href="<?php echo BASE_URL . '?action=tour_add'; ?>" class="add-tour-btn">
        + Tạo mới Tour
    </a>

    <h1>Danh sách Tour</h1>

    <table class="tour-table">
        <tr>
            <th>ID</th>
            <th>Tên tour</th>
            <th>Hình ảnh</th>
            <th>Giá tour</th>
            <th>Loại tour</th>
            <th>Thao tác</th>
        </tr>

        <?php foreach($tours as $tour): ?>
            <tr>
                <td><?= $tour->id ?></td>
                <td><?= $tour->ten_tour ?></td>
                <td>
                    <img src="<?= BASE_ASSETS_UPLOADS . $tour->image_path ?>" width="60" alt="">
                </td>
                <td><?= number_format($tour->gia_tour) ?> VND</td>
                <td><?= $tour->loai_tour ?></td>
                <td class="action-links">
                    <a href="<?= BASE_URL . '?action=tour-edit&id=' . $tour->id ?>">Sửa</a> |
                    <a href="<?= BASE_URL . '?action=tour-detail&id=' . $tour->id ?>">Chi tiết</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once "views/layouts/footer.php"; ?>

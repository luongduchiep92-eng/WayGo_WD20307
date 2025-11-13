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
            <th>Giá tour</th>
            <th>Loại tour</th>
            <th>Thao tác</th>
        </tr>

        <?php foreach($tours as $tour): ?>
            <tr>
                <td><?= $tour->id ?></td>
                <td><?= $tour->ten_tour ?></td>
                <td><?= number_format($tour->gia_tour) ?> VND</td>
                <td><?= $tour->loai_tour ?></td>
                <td>
                    <a href="<?= BASE_URL . '?action=tour_edit&id=' . $tour->id ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="<?= BASE_URL . '?action=tour_detail&id=' . $tour->id ?>"  class="btn btn-sm btn-info">Chi tiết</a>
                    <a href="<?= BASE_URL . '?action=tour_delete&id=' . $tour->id ?> "  class="btn btn-sm btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once "views/layouts/footer.php"; ?>

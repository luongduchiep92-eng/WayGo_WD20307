<a href="<?php BASE_URL . '?action=tour_list'; ?>">Tạo mới Tour</a>
<h1>Danh sách tour</h1>
<table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>ten_tour</th>
            <th>cover_image</th>
            <th>loai_tour</th>
            <th>dia_diem</th>
            <th>thoi_gian</th>
            <th>gia_tour</th>
            <th>mo_ta</th>
            <th>ngay_khoi_hanh</th>
            <th>phuong_tien</th>
            <th>so_nguoi_toi_da</th>
            <th>Hành động</th>
        </tr>
        <?php foreach($tours as $tour): ?>
            <tr>
                <td><?= $tour['id'] ?></td>
                <td><?= $tour['ten_tour'] ?></td>
                <td>
                    <img src="<?= BASE_ASSETS_UPLOADS. $tour['cover_image'] ?>" width="50" alt="">
                </td>
                <td><?= $tour['loai_tour'] ?></td>
                <td><?= $tour['dia_diem'] ?></td>
                <td><?= $tour['thoi_gian'] ?></td>
                <td><?= number_format($tour['gia_tour']) ?>VND</td>
                <td><?= $tour['mo_ta'] ?></td>
                <td><?= $tour['ngay_khoi_hanh'] ?></td>
                <td><?= $tour['phuong_tien'] ?></td>
                <td><?= $tour['so_nguoi_toi_da'] ?></td>
                <td>
                    <a href="<?php echo BASE_URL . '?action=tour-edit&id='.$tour['id'];?>">Sửa</a> |
                    <a href="<?php echo BASE_URL . '?action=tour-detail&id='.$tour['id'];?>">Chi tiết</a>
                </td>
            </tr>
        <?php endforeach; ?>
</table>
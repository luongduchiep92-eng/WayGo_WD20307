<?php require_once "views/layouts/header.php"; ?>
<div class="container-supplier">
    <h2>Danh sách nhà cung cấp</h2>
    <a href="index.php?controller=supplier&action=addsupplier" class="add-btn">+ Thêm nhà cung cấp</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Tên NCC</th>
            <th>SĐT</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($suppliers as $s): ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= $s['name'] ?></td>
                <td><?= $s['phone'] ?></td>
                <td><?= $s['email'] ?></td>
                <td><?= $s['address'] ?></td>
                <td>
                    <a href="index.php?controller=supplier&action=editsupplier&id=<?= $s['id'] ?>" class="btn-action btn-edit">Sửa</a>
                    <br>
                    <br>
                    <a href="index.php?controller=supplier&action=detailsupplier&id=<?= $s['id'] ?>" class="btn btn-info btn-sm">Xem chi tiết</a>
                    <br> <br>
                    <a class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')" href="index.php?controller=supplier&action=deletesupplier&id=<?= $s['id'] ?>">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

\<style>
    /* Container tổng */
    .container-supplier {
        max-width: 1000px;
        margin: 40px auto;
        padding: 30px;
        background: #f9f9f9;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Tiêu đề */
    .container-supplier h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #2c3e50;
        font-weight: 700;
        font-size: 28px;
        letter-spacing: 1px;
    }

    /* Link thêm mới */
    .container-supplier a.add-btn {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 20px;
        background: #3498db;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        transition: 0.3s;
        font-weight: 600;
    }

    .container-supplier a.add-btn:hover {
        background: #2980b9;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    /* Bảng */
    .container-supplier table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    /* Header bảng */
    .container-supplier th {
        background: #2c3e50;
        color: #fff;
        font-weight: 600;
        padding: 12px;
        text-align: left;
    }

    /* Dòng dữ liệu */
    .container-supplier td {
        padding: 12px;
        border-bottom: 1px solid #e1e1e1;
    }

    /* Hover dòng */
    .container-supplier tr:hover {
        background: #f1f1f1;
    }

    /* Button hành động */
    .container-supplier .btn-action {
        display: inline-block;
        padding: 6px 14px;
        margin-right: 5px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        color: #fff;
        transition: 0.3s;
    }

    /* Sửa */
    .container-supplier .btn-edit {
        background: #f39c12;
    }

    .container-supplier .btn-edit:hover {
        background: #d68910;
        transform: scale(1.05);
    }

    /* Xóa */
    .container-supplier .btn-delete {
        background: #e74c3c;
    }

    .container-supplier .btn-delete:hover {
        background: #c0392b;
        transform: scale(1.05);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-supplier {
            padding: 20px;
        }

        .container-supplier table,
        .container-supplier th,
        .container-supplier td {
            font-size: 14px;
        }

        .container-supplier a.add-btn {
            padding: 8px 16px;
            font-size: 14px;
        }
    }
</style>
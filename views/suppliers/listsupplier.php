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
                    <div class="action-buttons">
                        <a href="index.php?controller=supplier&action=editsupplier&id=<?= $s['id'] ?>" class="btn-action btn-edit">Sửa</a>
                        <a href="index.php?controller=supplier&action=detailsupplier&id=<?= $s['id'] ?>" class="btn btn-info btn-sm">Chi tiết</a>
                        <a href="index.php?controller=supplier&action=deletesupplier&id=<?= $s['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</a>
                    </div>
                </td>


            </tr>
        <?php endforeach; ?>
    </table>
</div>

\<style>
    /* ====== FONT CHO TOÀN TRANG ====== */
    body {
        font-family: 'Inter', 'Segoe UI', 'Tahoma', sans-serif;
        color: #333;
        background: #f4f6f8;
    }

    /* ====== CONTAINER ====== */
    .container-supplier {
        max-width: 1100px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    /* ====== TITLE ====== */
    .container-supplier h2 {
        text-align: center;
        margin-bottom: 25px;
        font-size: 32px;
        font-weight: 700;
        color: #1d3557;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        line-height: 1.2;
    }

    /* ====== ADD BUTTON ====== */
    .container-supplier .add-btn {
        display: inline-block;
        padding: 12px 22px;
        background: #457b9d;
        color: #fff;
        border-radius: 10px;
        text-decoration: none;
        margin-bottom: 20px;
        font-size: 15px;
        font-weight: 600;
        transition: 0.25s ease;
    }

    .container-supplier .add-btn:hover {
        background: #1d3557;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
    }

    /* ====== TABLE ====== */
    .container-supplier table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
        font-size: 15px;
    }

    .container-supplier th {
        background: #1d3557;
        color: #fff;
        padding: 14px;
        font-weight: 600;
        font-size: 14px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .container-supplier td {
        padding: 14px;
        color: #333;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .container-supplier tr:hover td {
        background: #edf2f4;
        transform: scale(1.005);
        transition: 0.2s;
    }

    /* ====== ACTION BUTTONS NẰM NGANG ====== */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    /* Giữ CSS nút hiện tại */
    .action-buttons .btn-action,
    .action-buttons .btn-info,
    .action-buttons .btn-danger {
        display: inline-block;
        margin: 0;
        font-weight: 600;
        font-size: 14px;
        border-radius: 6px;
        padding: 6px 14px;
        transition: 0.2s;
    }

    /* EDIT */
    .btn-edit {
        background: #f4a261;
        color: #fff;
    }

    .btn-edit:hover {
        background: #e76f51;
        transform: translateY(-2px);
    }

    /* INFO */
    .btn-info {
        background: #2a9d8f;
        color: #fff;
    }

    .btn-info:hover {
        background: #21867a;
        transform: translateY(-2px);
    }

    /* DELETE */
    .btn-danger {
        background: #e63946;
        color: #fff;
    }

    .btn-danger:hover {
        background: #b71c1c;
        transform: translateY(-2px);
    }

    /* ====== RESPONSIVE ====== */
    @media (max-width: 768px) {
        .container-supplier {
            padding: 20px;
        }

        .container-supplier table,
        th,
        td {
            font-size: 13px;
        }

        .btn-action,
        .btn-info,
        .btn-danger {
            padding: 5px 10px;
            font-size: 13px;
        }

        .container-supplier .add-btn {
            width: 100%;
            text-align: center;
            padding: 10px 0;
        }
    }
</style>
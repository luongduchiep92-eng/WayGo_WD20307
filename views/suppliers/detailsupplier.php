<?php require_once "views/layouts/header.php"; ?><style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f2f5;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        background: #ffffff;
        padding: 30px 40px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .container:hover {
        transform: translateY(-5px);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        font-weight: 700;
    }

    p {
        font-size: 16px;
        line-height: 1.6;
        margin: 12px 0;
        color: #555;
    }

    p strong {
        color: #222;
        width: 120px;
        display: inline-block;
    }

    a.btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 25px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        color: #fff;
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    a.btn:hover {
        background: linear-gradient(135deg, #2575fc, #6a11cb);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
    }
</style>

<div class="container">
    <h2>Chi tiết nhà cung cấp</h2>

    <p><strong>ID:</strong> <?= $supplier['id'] ?></p>
    <p><strong>Tên NCC:</strong> <?= $supplier['name'] ?></p>
    <p><strong>SĐT:</strong> <?= $supplier['phone'] ?></p>
    <p><strong>Email:</strong> <?= $supplier['email'] ?></p>
    <p><strong>Địa chỉ:</strong> <?= $supplier['address'] ?></p>

    <a href="index.php?action=listsupplier" class="btn">Quay lại danh sách</a>
</div>
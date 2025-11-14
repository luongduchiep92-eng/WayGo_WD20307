<?php require_once "views/layouts/header.php"; ?>
<h2 class="supplier-title">Thêm nhà cung cấp</h2>

<form class="supplier-form" method="post" action="index.php?controller=supplier&action=storesupplier">
    <div class="form-group">
        <label>Tên NCC</label>
        <input type="text" name="name" placeholder="Nhập tên nhà cung cấp" required>
    </div>

    <div class="form-group">
        <label>SĐT</label>
        <input type="text" name="phone" placeholder="Nhập số điện thoại">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="Nhập email">
    </div>

    <div class="form-group">
        <label>Địa chỉ</label>
        <input type="text" name="address" placeholder="Nhập địa chỉ">
    </div>

    <button type="submit" class="btn-submit">Lưu</button>
</form>

<style>
    /* css */
    .supplier-title {
        text-align: center;
        font-size: 2rem;
        color: #333;
        margin-bottom: 30px;
        font-weight: 600;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Form style */
    .supplier-form {
        max-width: 500px;
        margin: 0 auto;
        background-color: #fefefe;
        padding: 30px 40px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Form group */
    .form-group {
        margin-bottom: 20px;
    }

    /* Labels */
    .form-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
        color: #555;
    }

    /* Inputs */
    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border-radius: 10px;
        border: 1px solid #ccc;
        outline: none;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
    }

    /* Button */
    .btn-submit {
        width: 100%;
        padding: 12px;
        background: linear-gradient(90deg, #007bff, #00c6ff);
        border: none;
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
    }
</style>
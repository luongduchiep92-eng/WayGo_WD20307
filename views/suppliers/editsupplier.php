<?php require_once "views/layouts/header.php"; ?>
<div class="update-supplier-form">
    <h2>Cập nhật nhà cung cấp</h2>


    <form method="post" action="index.php?controller=supplier&action=updatesupplier&id=<?= $supplier['id'] ?>">

        <label>Tên NCC</label>
        <input type="text" name="name" value="<?= $supplier['name'] ?>" required>

        <label>SĐT</label>
        <input type="text" name="phone" value="<?= $supplier['phone'] ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?= $supplier['email'] ?>">

        <label>Địa chỉ</label>
        <input type="text" name="address" value="<?= $supplier['address'] ?>">

        <button type="submit">Cập nhật</button>
    </form>
</div>
<style>
    /* Container form */
    .update-supplier-form {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        background: #f9f9f9;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Heading */
    .update-supplier-form h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
        font-weight: 600;
    }

    /* Input fields */
    .update-supplier-form input[type="text"],
    .update-supplier-form input[type="email"] {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .update-supplier-form input[type="text"]:focus,
    .update-supplier-form input[type="email"]:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        outline: none;
    }

    /* Button */
    .update-supplier-form button {
        width: 100%;
        padding: 12px;
        background-color: #28a745;
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .update-supplier-form button:hover {
        background-color: #218838;
    }

    /* Labels (nếu muốn thêm) */
    .update-supplier-form label {
        font-weight: 500;
        color: #555;
    }
</style>
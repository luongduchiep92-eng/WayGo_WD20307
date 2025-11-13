<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm loại tour</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f6fa;
            padding: 20px;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
        }

        button {
            background: #00a8ff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #0097e6;
        }
    </style>
</head>

<body>
    <h2>Thêm loại tour</h2>
    <form method="POST">
        <label>Tên loại tour:</label>
        <input type="text" name="name" required>

        <label>Mô tả:</label>
        <textarea name="description"></textarea>

        <label>Trạng thái:</label>
        <select name="status">
            <option value="1">Hoạt động</option>
            <option value="0">Ẩn</option>
        </select>

        <button type="submit">Lưu</button>
    </form>
</body>

</html>
<?php
// File: reset_pass.php

// 1. Cấu hình Database (Giống trong file env.php của bạn)
define('DB_HOST',     'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME',     'tour_management_1'); // Kiểm tra lại tên DB của bạn nếu khác

try {
    // 2. Kết nối
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Thông tin tài khoản cần Reset
    $username_can_sua = 'hdv_an'; // <--- ĐIỀN TÊN ĐĂNG NHẬP CỦA BẠN VÀO ĐÂY
    $password_moi     = '123456';    // <--- Mật khẩu mới mong muốn

    // 4. Mã hóa mật khẩu
    $hash = password_hash($password_moi, PASSWORD_DEFAULT);

    // 5. Cập nhật vào Database
    $sql = "UPDATE users SET password = :pass WHERE username = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['pass' => $hash, 'user' => $username_can_sua]);

    if ($stmt->rowCount() > 0) {
        echo "<h2 style='color:green'>Thành công!</h2>";
        echo "Mật khẩu của tài khoản <b>$username_can_sua</b> đã được đổi thành: <b>$password_moi</b><br>";
        echo "Mã hóa mới là: $hash <br>";
        echo "<a href='index.php?action=login'>Bấm vào đây để Đăng nhập ngay</a>";
    } else {
        echo "<h2 style='color:red'>Không tìm thấy tài khoản!</h2>";
        echo "Vui lòng kiểm tra lại tên đăng nhập: <b>$username_can_sua</b> có đúng trong bảng users chưa?";
    }

} catch (PDOException $e) {
    die("Lỗi kết nối Database: " . $e->getMessage());
}
?>
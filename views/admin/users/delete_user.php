<?php
// Kết nối CSDL
include_once 'config.php';
if (!isset($conn)) {
    $conn = mysqli_connect("localhost", "db_username", "db_password", "db_name");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
}

if (isset($_GET['id'])) {
    $user_id = (int) $_GET['id'];
    $sql = "DELETE FROM users WHERE id=$user_id";
    mysqli_query($conn, $sql);
}
mysqli_close($conn);
// Chuyển hướng về danh sách (có thể kèm thông báo xoá thành công)
header("Location: user_list.php?msg=deleted");
exit();

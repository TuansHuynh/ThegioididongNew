<?php
// Kết nối cơ sở dữ liệu SQL Server
$serverName = "HUYNH-ANH-TUAN\TUANSHUYNH";
$connectionOptions = [
    "Database" => "Thegioididong_admin",
    "UID" => "sa",
    "PWD" => "123"
]; 

$conn = sqlsrv_connect($serverName, $connectionOptions);

// Kiểm tra kết nối
if ($conn === false) {
    die("Không thể kết nối đến cơ sở dữ liệu: " . print_r(sqlsrv_errors(), true));
}

// Kiểm tra xem có ID người dùng trong URL không
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Chuẩn bị câu lệnh xóa người dùng
    $sql = "DELETE FROM Users WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Kiểm tra và thông báo kết quả
    if ($stmt === false) {
        die("Không thể xóa người dùng: " . print_r(sqlsrv_errors(), true));
    } else {
        // Sau khi xóa thành công, chuyển hướng lại trang quản lý người dùng
        header("Location: manager_user.php");
        exit();
    }
}

// Đóng kết nối
sqlsrv_close($conn);
?>